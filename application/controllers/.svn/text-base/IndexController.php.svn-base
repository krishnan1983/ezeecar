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
	
    	$this->_helper->redirector('login', 'index');
    }
       
	public function loginAction()
	{ 	
		try {
			
			$this->_helper->layout->setLayout('login');
			
			//Check if there is signed in user
			$auth = Zend_Auth::getInstance();
			if($auth->hasIdentity()) {								
				$roleName = $auth->getStorage()->read()->user_role;			
				$this->_goTo($roleName);
			}				
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
			Pp_Logger::getInstance()->err($e);
		}		 
	}
	
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
				$config = Zend_Registry::get('config');
				
				$admin_roles = $config->admin->toArray();
				$admin_role_id = array_keys($admin_roles);
				//echo "<pre>";print_r($admin_role_id);die();

				$roleName = (in_array($userInfo->uid, $admin_role_id))? 'admin' : 'author';
				$userInfo->user_role = $roleName;
				$auth->getStorage()->write($userInfo);
				
				Zend_Session::rememberMe(3600);
				
				$this->_goTo($roleName);
		        
		    }else {
		    	$this->view->errorMsg='Invalid Credential';
		    }
		    
		}catch(Exception $e)
		{
			Pp_Logger::getInstance()->err($e);
		}		
		
	}
	
	private function _goTo($roleName)
	{ 
		
		if($roleName == 'admin')
			$this->_redirect('/admin/requests'); 
		else 							
			$this->_redirect('/author/requests'); 
	}
	
	
	
	//http://framework.zend.com/manual/1.12/en/zend.auth.adapter.ldap.html
	public function ldapAction()
	{ 
		//echo "SAML response";die();
		
	//SAML Response
	echo $samlResponse = $this->_request->getParam('SAMLResponse');
	
/*	if($this->getRequest()->isPost()) { 	
			$samlResponse = $this->_request->getPost();	
	}*/
	
			
	
		
	// XSS validation	
	//$samlResponseFilter = new Zend_Filter_Input($filters = array(), $validators=array(), $samlResponse);
		 	
	
	
	//SAML Dcoded value
	echo $returnValue = base64_decode($samlResponse);
	
	$newlines = array("\t","\n","\r","\x20\x20","\0","\x0B");

	echo $content = str_replace($newlines, "", html_entity_decode($returnValue));
	
	$start = strpos($content,'<ns2:Assertion"');

	$end = strpos($content,'</ns2:Assertion>',$start) + 1;

	$table = substr($content,$start,$end-$start);

	echo "<h4>Decoded HP Data and Extracted required Data:</h4><br>";
	
	//Extracting username here.
	$username = preg_match_all("|<ns2:Subject>(.*)</ns2:Subject>|U",$table,$userNameRows);
	echo $username = strip_tags($userNameRows[0][0])."_pg";
	echo $uname = $username;
	echo "<br>";
	
	//Extracting email id here.
	$username = preg_match_all('|<ns2:Attribute Name="email"(.*)</ns2:Attribute>|U',$table,$emailId);
	echo $email = strip_tags($emailId[0][0]);
	echo "<br>";
	
	$post = array('name'=>$uname, 'pass'=>md5($uname),'mail'=>$email,'status'=>'1');
	//echo "<pre>";print_r($postData);die();
	$user = new Application_Model_DbTable_Users();
	$resutlSet = $user->checkEmailAvailable($email);
	
	if(isset($resutlSet['name']) && $resutlSet['name']!='')
	{
		
		$post= array();
		$post['uname'] =  $resutlSet['name'];
		$post['pass'] =  $resutlSet['name'];
		 
		$auth = Zend_Auth::getInstance();
		$this->_login($post, $auth);
		
	}else
	{
		//  pass username and password to login function
		//echo "am else area";die();
	    
	    if($user->createPgUser($post))
	    {
	    	
	    $auth = Zend_Auth::getInstance();
	    $this->_login($post, $auth);
	    }
	    else {
	    	echo "not created";die();
	       }
	    
		
	}
		
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
			$this->_session->unsetAll();
			
        	Zend_Session::destroy();
        	$this->_redirect('/index/login');
			
		} catch(Exception $e) {
			Pp_Logger::getInstance()->err($e);
		}
	}
	//END
}

