<?php

/**
 *	P&G ProcessPedia Application
 *
 *	@aspect		Controller
 *	@date		06.26.09
 *	@version	3.0.0
 *
 *	@purpose	Login Modules
 *
 *	@file		IndexController.php
 */

class IndexController extends Zend_Controller_Action {

   	protected $_session;
   	protected $_auth;

    public function init() { 
    	
    	$this->_session = new Zend_Session_Namespace('user');
    }
    
	public function indexAction() {
	
       //echo "index"; die();
    }

	/*public function playbookAction() {

       
    }
    
	public function requestAction() {
		
		$this->_helper->layout->setLayout('layout1');
       
    }*/
    
  	public function uploadAction() {
		
		$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        
			//print_r($_FILES); die();
			
			//header('Content-type: application/json');
			
        //header('Content-type: text/html');
			
        	$domain = $this->view->serverUrl().'/ppeditor' ;
        	
       		// $domain = $this->view->serverUrl();
        
        
			$img_exts = array('jpeg', 'jpg', 'png', 'gif');
			
			$valid_exts = array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'docx', 'pptx', 'pdf', 'doc', 'xlsx'); // valid extensions
			//$max_size = 1050 * 1024; // max file size (200kb)
			$path = 'uploads/'; // upload directory
			
			if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
			{
				if( @is_uploaded_file($_FILES['image']['tmp_name']) )
				{
					// get uploaded file extension
					$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)); //echo $ext; 
					//echo $this->view->baseUrl();
					
					
					// looking for format and size validity
					if (in_array($ext, $valid_exts))
					{	
						$file_name = $_FILES['image']['name'];
						// unique file path
						//$path = $path . uniqid(). '.' .$ext;
						$path = $path . $_FILES['image']['name'];
						// move uploaded file from temp to uploads directory
						if (move_uploaded_file($_FILES['image']['tmp_name'], $path))
						{
							$status = 'Image successfully uploaded!';
							if(in_array($ext, $img_exts))
								$file = '<img src="'.$domain.'/'.$path.'"/>';
							else if (array_key_exists($ext, $this->icon_array)){
								
								$file ='<a href="'.$domain.'/'.$path.'" target="_blank"><img src="'.$domain.'/public/images/'.$this->icon_array[$ext].'" width="30" height="30" />'.$file_name.'</a>';
							}
								
						}
						else {
							$status = 'Upload Fail: Unknown error occurred!';
						}
					}
					else {
						$status = 'Upload Fail: Unsupported file format or It is too large to upload!';
					}
				}
				else {
					$status = 'Upload Fail: File not uploaded!';
				}
			}
			else {
				$status = 'Bad request!';
			}
			
			echo $file; die();
			//echo json_encode(array('file' => $file));
			
			// echo out json encoded status
			//echo json_encode(array('status' => $status, 'file' => $file));
			
			
			//echo "{\"status\":\".$status.\",\"file\":\".$file.\" }";
			
			//echo '{"status":"Image successfully uploaded!","file":"<img src=\"http://local.ppeditor/uploads/thumb_2c9cbae9b8edc92bf96a397b134f3bc7.jpg\"/>" }';
			
			//echo '{"status":"'.$status.'","file":"'.addslashes($file).'" }';
  			//echo '{"status":"'.$status.'","file":"'.addslashes($file).'"}';
			
  			//echo '{"status":"'.$status.'","file":"'.$file.'"}';
  	
  		 die();
    }
    
    
	public function loginAction()
	{ 
				
		try {
			
			//Check if there is signed in user
			$auth = Zend_Auth::getInstance();
			if($auth->hasIdentity()) {
								
				$roleName = $auth->getStorage()->read()->user_role;			
				$this->_goTo($roleName);
			}
				
			 $this->_helper->layout->setLayout('login');
		 
			 $form = new Application_Form_Login();
			 $element = $form->getElement('submit');
			  //$element->removeDecorator('label');

			 if($this->getRequest()->isPost()) { 
	
				$post = $this->_request->getPost();
				$form->populate($post);
	
				if($form->isValid($post)){
				$this->_login($post, $auth);
				
				}
			}
	
			$this->view->form = $form; 
		
		}catch(Exception $e) {
			//Th_Logger::getInstance()->err($e);
		}		 
	}
	// END
	
	private function _login($post, $auth){
	
		try{
		$this->_dbAdapter = Zend_Db_Table::getDefaultAdapter(); 
					$this->_authAdapter = new Zend_Auth_Adapter_DbTable(
						$this->_dbAdapter,
						'users',
						'name',
						'pass',
						'MD5(?)'
					);
					
		            $this->_authAdapter->setIdentity($post['uname'])
		                               ->setCredential($post['pass']);
	
		            $result = $auth->authenticate($this->_authAdapter);		            
		            if ($result->isValid()) { 
		            					
		                //$userInfo = $this->_authAdapter->getResultRowObject(null, 'pass');
		                
		            	$userInfo = $this->_authAdapter->getResultRowObject();

		                $config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/application.ini',APPLICATION_ENV);			
						$admin_roles = $config->admin->toArray();
						//echo "<pre>";print_r(array_keys($admin_roles));die();
						$admin_role_id = array_keys($admin_roles);
						//echo "<pre>";print_r($admin_role_id);die();
			
						$roleName = (in_array($userInfo->uid, $admin_role_id))? 'admin' : 'author';
						
					
						$userInfo->user_role = $roleName;
		                $auth->getStorage()->write($userInfo);
		                		                
		                $this->_goTo($roleName);
		        
		            }
		}catch(Exception $e)
		{
		echo $e->getMessage();
		}
		
		
	}
	
	private function _goTo($roleName)
	{ 
		
		if($roleName == 'admin')
			$this->_redirect('/admin/requests'); 
		else 							
			$this->_redirect('/author/requests'); 
	}
	
	public function testAction()
	{
		$SAMLResponse = array('username'=>'muthu','password'=>'test123','email'=>'smuthukris@gmail.com');
		
		$this->view->assign('action',"/index/ldap/SAMLResponse/");
		$this->view->assign('title','Member Login');
		$this->view->assign('label_fname','User Name');
		$this->view->assign('label_pass','Password');
		$this->view->assign('label_submit','Login');		
		$this->view->assign('description','Please enter your credential');
	}
	
	public function ldap1Action()
	{ 
		
	//SAML Response
	//$samlResponse = $this->_request->getParam('SAMLResponse');	
	
		if($this->getRequest()->isPost()) { 	
				$samlResponse = $this->_request->getPost();	
		}
				
		echo "<pre>";print_r($samlResponse);//die();
	
		die();
	}
	
	//http://framework.zend.com/manual/1.12/en/zend.auth.adapter.ldap.html
	public function ldapAction()
	{ 
		echo "SAML response";die();
		
	//SAML Response
	//$samlResponse = $this->_request->getParam('SAMLResponse');	
	
	if($this->getRequest()->isPost()) { 	
			$samlResponse = $this->_request->getPost();	
	}
			
	echo "<pre>";print_r($samlResponse);//die();
		
	// XSS validation	
	//$samlResponseFilter = new Zend_Filter_Input($filters = array(), $validators=array(), $samlResponse);
		 	
	
	
	//SAML Dcoded value
	/*$returnValue = base64_decode($samlResponseFilter);
	
	$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");

	echo $content = str_replace($newlines, "", html_entity_decode($returnValue));
	
	$start = strpos($content,'<ns2:Assertion"');

	$end = strpos($content,'</ns2:Assertion>',$start) + 1;

	$table = substr($content,$start,$end-$start);

	echo "<h4>Decoded HP Data and Extracted required Data:</h4><br>";
	
	//Extracting username here.
	$username = preg_match_all("|<ns2:Subject>(.*)</ns2:Subject>|U",$table,$userNameRows);
	echo $username = strip_tags($userNameRows[0][0])."_pg";
	//echo $pass = $username;
	echo "<br>";
	
	//Extracting email id here.
	$username = preg_match_all('|<ns2:Attribute Name="email"(.*)</ns2:Attribute>|U',$table,$emailId);
	echo $email = strip_tags($emailId[0][0]);
	echo "<br>";*/
	
	/*$user = new Application_Model_DbTable_Users();
	if($user->checkEmailAvailable($email))
	{
		   
		
	}else
	{
		//  pass username and password to login function
		$pass = md5($username);
		$date = new DateTime();
	    $created =$date->format('U') . "\n";
	    $user->createPgUser($username, $pass, $created);
		
	}*/
		
		/*$username = $this->_request->getParam('username');
		$password = $this->_request->getParam('password');
		 
		$auth = Zend_Auth::getInstance();
		 
		$config = new Zend_Config_Ini('../application/config/config.ini',
		                              'production');
		$log_path = $config->ldap->log_path;
		$options = $config->ldap->toArray();
		unset($options['log_path']);
		 
		$adapter = new Zend_Auth_Adapter_Ldap($options, $username,
		                                      $password);
		 
		$result = $auth->authenticate($adapter);*/
		 
		/*if ($log_path) {
		    $messages = $result->getMessages();
		 
		    $logger = new Zend_Log();
		    $logger->addWriter(new Zend_Log_Writer_Stream($log_path));
		    $filter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
		    $logger->addFilter($filter);
		 
		    foreach ($messages as $i => $message) {
		        if ($i-- > 1) { // $messages[2] and up are log messages
		            $message = str_replace("\n", "\n  ", $message);
		            $logger->log("Ldap: $i: $message", Zend_Log::DEBUG);
		        }
		    }
		}*/
	
	
	$this->_login($post);
		
	}
	
	
	public function logoutAction() {
		try { 
			
			Zend_Auth::getInstance()->clearIdentity();
			//Th_Auth_Helper::clearAuthPage();
			
			$this->_session->unsetAll();
			
			
        	Zend_Session::destroy();
        	$this->_redirect('index/login');
			
		} catch(Exception $e) {
			//Th_Logger::getInstance()->err($e);
		}
	}
	//END

}

