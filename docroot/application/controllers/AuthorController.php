<?php
/**
 *	P&G ProcessPedia Application
 *
 *	@aspect		Controller
 *	@date		06.26.09
 *	@version	3.0.0
 *	@purpose	Author Modules
 *	@file		AuthorController.php
 */
class AuthorController extends Zend_Controller_Action {

	protected $_session;	
	protected $img_exts = array('jpeg', 'jpg', 'png', 'gif');
	protected $exts = array('pdf'=>'pdf.png', 'doc'=>'word.png', 'docx'=>'word.png', 'pptx'=>'ppt.jpg', 'xlsx'=>'excel.jpg', 'xls'=>'excel.jpg', 'csv'=>'excel.jpg', 'jpeg' => 'NULL', 'jpg'  => 'NULL', 'png'  => 'NULL', 'gif'  => 'NULL');	
	
	protected $auth;
	protected $_config;
	
 	public function init() { 
				
 		$this->view->headTitle('PP Editor - Author');
		
 		$this->auth 	= Zend_Auth::getInstance();		
 		$this->_config  = Zend_Registry::get('config');
 		$this->_session = new Zend_Session_Namespace('Author');
 		
	 	if ($this->_helper->FlashMessenger->hasMessages()) {
	        $this->view->errmessages = $this->_helper->FlashMessenger->getMessages();
	    }
 		
    }
    
	public function templateContentAction(){
		
		try {	
		
			$this->_helper->viewRenderer->setNoRender(true);
			$this->_helper->layout->disableLayout();
			
			$category = explode("_", $this->_request->getPost('folder'));	
			
			echo Application_Model_DbTable_MasterTemplates::getTemplateDetail($category['1']);
			
		}catch(Exception $e) {
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
		
	public function requestsAction(){
		try {	
			
			$this->view->search = $this->_getParam('search', Pp_Status::All);
			$this->_session->search = $this->view->search;
						
			$uid = $this->auth->getStorage()->read()->uid; 
			$reqT = new Application_Model_DbTable_Requests(); 			
			$select = $reqT->getMyRequests($uid, $this->view->search);		
			
			//echo $select;
	
			$paginator = Zend_Paginator::factory($select);
	        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
	        $paginator->setItemCountPerPage($this->_config->itemCountPerPage);
	        $this->view->data = $paginator;
	        
	        $rowCountResult = $reqT->getMyRequestsCount($uid, $this->view->search);	
	        $this->view->rowCount = $rowCountResult;
			
			$this->view->current_page = 'requesttab';

		}catch(Exception $e) {
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}  
		
	}
	
	public function documentsAction(){		
		try {	
			
			Zend_Session::namespaceUnset('Author');
			$this->view->search = $this->_getParam('search');
			
			$uid = $this->auth->getStorage()->read()->uid; 
			$docT = new Application_Model_DbTable_Documents(); 			
			$select = $docT->getMyDocuments($uid ,$this->view->search);		 

			$paginator = Zend_Paginator::factory($select);
	        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
	        $paginator->setItemCountPerPage($this->_config->itemCountPerPage);
	        $this->view->data = $paginator;
	        
	        $rowCountResult = $docT->getMyDocumentsCount($uid ,$this->view->search);	
	        $this->view->rowCount = $rowCountResult;
			
			$this->view->current_page = 'documenttab';
        
		}catch(Exception $e) {
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}  
		
	}
	
	public function duplicateAction(){
		try {	
			
			$this->_helper->viewRenderer->setNoRender(true);
	        $this->_helper->layout->disableLayout();
			
			if($this->getRequest()->isPost()) { 				
				
				$post = $this->_request->getPost();	
				$docT = new Application_Model_DbTable_Documents(); 
				$result = $docT->docNameDuplicate($post['docName']);
				die($result);
				/*if($result>0)
					die("Name already exists, please try another name");
				else
					die();*/
			}
	
		}catch(Exception $e) {
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}  
		
	}
	
	
	public function createGuideAction(){ 
							
				
		if($this->_getParam('document')){
			$documentId = (int) $this->_getParam('document');
			$this->_session->documentId = $documentId;	
			$this->_session->attachment = $documentId;
		}else  {				
			//create
			if( isset($this->_session->documentId) && isset($this->_session->attachment)){
				$documentId = $this->_session->documentId; 
			}else
				Zend_Session::namespaceUnset('Author');
		}
		
		$this->view->send = 'y';
		$this->view->save = 'y';

		$docT = new Application_Model_DbTable_Documents(); 
		if (!empty($documentId)) { 
		
			$getGuide	= $docT->getGuide($documentId);	
			$this->view->name = $getGuide['Name'];
			$this->view->folder =  $getGuide['Type']."_".$getGuide['Category'];
			$this->view->content = trim(stripslashes($getGuide['Content']));
			
			$editStatus = Application_Model_DbTable_Requests::activeRequest($documentId);						
			if(!empty($editStatus) && count($editStatus)> 0) {
				$this->view->send = 'n';
				
				if(!in_array($editStatus['Status'], array(Pp_Status::Open,Pp_Status::AssignedToAuthor)))
					$this->view->save = 'n';	
			}

			$this->view->edit =  1;
			
		}else{
		
			$this->view->edit =  0;
			//Zend_Session::namespaceUnset('Author');			
		}

		if($this->getRequest()->isPost()) { 				
			$post = $this->_request->getPost();	
		
			//remove mata tag detail for the document which are deleted by author			
			$valid = $this->_validate(array('name' => $post['name'], 'elm1' => $post['elm1']));			
			if ($valid && !is_array($valid)) { 
			
				$post['createdBy'] = $this->auth->getStorage()->read()->uid; 				
				if(isset($post['folder'])){
					
					$category = explode("_", $post['folder']);	
					$post['type'] = $category['0'];
					$post['category'] = $category['1'];	
					
				}
				if(!empty($documentId))
				 $post['documentId'] = $documentId;
			
				try {	
										
					$documentId = $docT->createDocument($post, 'save');
					Zend_Session::namespaceUnset('Author');				
					if($post['action'] == "sendGuide"){
						
						//$this->_helper->FlashMessenger('Request has been sent to Admin');
						$this->_helper->redirector('send-request', 'author', '', array('document' => Pp_Common_UrlHelper::enCryptId($documentId)));		
						
					}else{
					
						$this->_helper->FlashMessenger('Document has been saved');
					}
					$this->_helper->redirector('documents', 'author');
			
				}catch(Exception $e) {		
					Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
				}
			
			}else
			{
				$this->view->errors =  $valid;					
				$this->view->name = $post['name'];
				$this->view->folder =  $post['folder'];
				$this->view->content = trim(stripslashes($post['Content']));
			}
		}

		$this->view->current_page = 'documenttab';
		
	}
	
	// upload file 
	// resize (900* 870) image
	// create document register in session
  	public function uploadAction() {
			
		try{
			
			$this->_helper->viewRenderer->setNoRender(true);
	        $this->_helper->layout->disableLayout();
	        
	        // check documentid present in session or not
	        // if present create folder folder+documentId
	        // else use exiting one
	        // upload document
	        // on successs append meta data as data id
			if(isset($this->_session->documentId))
				$documentId = $this->_session->documentId;
			else {
													
				$docT = new Application_Model_DbTable_Documents();
				$data['CreatedOn'] = new Zend_Db_Expr('NOW()');
				$data['CreatedBy'] = $this->auth->getStorage()->read()->uid;
				$data['Flag'] = '-1';
				$documentId = $docT->insert($data);		
				$this->_session->documentId = $documentId;	
						
			}
			
			$this->_session->attachment = $documentId;
	        	
			 $foldername =  'folder'.$documentId;
	         $uploadFolder =  $this->_config->attUploadPath.$foldername;
			 
	         
	         //echo $uploadFolder;
	         if( !is_dir ( $uploadFolder)){
	         	
	         	if (!mkdir($uploadFolder, 0777, true)) {
				    die('Failed to create folders...');
				}
	         	
	         }
	         
			if( @is_uploaded_file($_FILES['filename']['tmp_name']) )
			{				
					
				 if( is_dir ( $uploadFolder)){
					 	
					//get uplaoded file detail
					$originalFilename = pathinfo($_FILES['filename']['name']);
					//print_r($originalFilename);
					$ext = strtolower($originalFilename['extension']); 
					
					// looking for format and size validity
					if (array_key_exists($ext, $this->exts)){	
						
						//store file in orginal name
						$uploadPath = $uploadFolder .'/'. $originalFilename['basename']; 
						$viewPath = $this->_config->attViewPath.$foldername.'/'. $originalFilename['basename']; 
						
						// move uploaded file from temp to uploads directory
						if (move_uploaded_file($_FILES['filename']['tmp_name'], $uploadPath))
						{
							$status = 'success';
							
							if(in_array($ext, $this->img_exts)){
															
								$file = '<img src="'.$viewPath.'"/>';
								$this->_resize('960', '870','auto',$uploadPath,$uploadPath);
							}
							else  { 
								
								//echo $_POST['metaData'];
								//$insertMeta = true;								
								$file ='<a href="'.$viewPath.'"  target="_blank"><span style="display:none; position: absolute; width: 0px; height: 0px; overflow: hidden;">'.$_POST['metaData'].'</span><img src="'.$this->_config->iconPath.$this->exts[$ext].'" width="30" height="30" />'.$originalFilename['basename'].'</a>';		
								
							}						
						}
						else 
							$status = 'Upload Fail: Unknown error occurred!';
	
					}
					else 
						$status = 'Upload Fail: Unsupported file format or It is too large to upload!';
				
				}
				else 
					$status = 'Upload Fail: File not uploaded!';				
			}
			else 
				$status = 'Bad request!';
			
			echo $file; die();
			//echo Zend_Json::encode(array('status' => $status, 'file' => $file));
			
		}catch(Exception $e) {				
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
    }
    
    
	
	private function _validate(array $post) {
		
        $errors = array();     
        foreach ($post as $key => $value) {
            if (!Zend_Validate::is($post[$key], 'NotEmpty')) {				
				$errors[$key] = 'Value is require, can not be empty';				
            }
        }         
        if (count($errors) < 1) {
            return true;
        } else {
            return $errors;
        }

	}
	

	
    /* upload file
	* Create document entry 
	* Email request link to “OS, TA developer, TA lead and primary admin marked in CC”, so that TA can download the attached document from it.
	*/
	public function createDocumentAction(){
				
		$form = new Application_Form_Document();
		$form->useDisplayGroups();		
		$form->getElement('uploadedfile')->setDestination($this->_config->docUploadPath);
        
		if($this->getRequest()->isPost()) { 				
			$post = $this->_request->getPost();	
			if( $form->isValid($post)){ 						
				try{
				
					$uid = $this->auth->getStorage()->read()->uid;
					// Change document name before saving					
					$originalFilename = pathinfo($form->uploadedfile->getFileName()); //print_r($originalFilename);
					$filebasename = explode(".", $originalFilename['basename']);
				    $newFilename = $filebasename['0'] .'_' . $uid.uniqid() . '.' . $originalFilename['extension']; //echo $newFilename;
				    $form->uploadedfile->addFilter('Rename', $newFilename);
				       
					if ($form->uploadedfile->receive()) { 
		
						$docT = new Application_Model_DbTable_Documents();
						$post['createdBy'] = $this->auth->getStorage()->read()->uid; 
						$post['fileName']  = $newFilename;
						$post['filePath']  = $this->_config->docUploadPath;
						$post['type'] 	   = Pp_Type::Document;
						 						
						$category 		     = explode("_", $post['folder']);	
						$post['category']    = $category['1'];
						$post['subCategory'] = $category['0'];
						
						if($RequestId = $docT->createDocument($post)){
						
							$configT = new Application_Model_DbTable_Configuration();
							$configs = $configT->fetchRow('ConfigId = 1')->toarray();
												
							$template = 'authorToTA';
									
							// create view object
							$html = new Zend_View();
							$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
							
							$folder = Application_Model_DbTable_Requests::getFolderById($category['0']);
							
							// assign values					
						 	$html->assign('documentName', stripslashes($post['name']));
							$html->assign('folder', $folder);		
							
						 	$bodyText = $html->render($template.".phtml"); 	 						 							 
							$to = array(
									$configs['TechAgencyLeadEmailId'] => $configs['TechAgencyLeadName'],
									$configs['OpsSpecialistEmailId'] => $configs['OpsSpecialistName'],
									$configs['TechAgencyDeveloperEmailId'] => $configs['TechAgencyDeveloperName']
								);
				 				
							//$cc = array($configs['TechAgencyLeadName'] => $configs['TechAgencyLeadEmailId']);				
							
							$this->_send($template, $bodyText,  $to);
						 		
							$this->_helper->FlashMessenger('Request has been sent to TA');
							$this->_helper->redirector('documents', 'author');
					
						}

					 }
					 					
				}catch(Exception $e) {					
				
					Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
				}					
			}
			$form->populate($post);
		}						
		$this->view->form = $form; 		
		$this->view->current_page = 'documenttab';
	}
	
	/*Create Request record with status as “Pending with TA”
	- Send email notification to OS, TA and Primary admin
	- Then mark the “uploaded document” as delete*/
	public function deleteDocumentAction(){
		
		//if documentid is null and not authorizes take to document detail page
		$documentId = Pp_Common_UrlHelper::deCryptId($this->_getParam('document')); 
		
		$docT = new Application_Model_DbTable_Documents();
		$docDetails = $docT->getDetailById($documentId);
		
		//echo $docDetails['CreatedBy']; 
		
		$this->_docCheck($documentId,$docDetails['CreatedBy']);
				
		$form = new Application_Form_Message();
		$form->removeElement('status');	

		$form->getElement('submit')->setLabel('Send Request');		
		$form->setAction('/author/delete-document/document/'.$this->_getParam('document'));
		$form->useDisplayGroups();
		
		$folder = Application_Model_DbTable_Requests::getFolderById($docDetails['SubCategory']);
		
		if($this->getRequest()->isPost()) { 	
			$post = $this->_request->getPost();					
			if( $form->isValid($post)){ 		
				try{
								
					$post['documentId'] 	= $documentId;
					$post['name'] 			= "Delete ".$docDetails['Name'];
					$post['createdBy'] 		= $this->auth->getStorage()->read()->uid; 
					$post['status'] 		= Pp_Status::TA;
					
					if($RequestId = $docT->deleteDocument($post)){
					
						// send email
						$template = 'delete';					
						
						// create view object
						$html = new Zend_View();
						$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
						
						$html->assign('documentName', $docDetails['Name']);
						$html->assign('folder', $folder);	
						
						$bodyText = $html->render($template.".phtml"); 	 					
						
						$configT = new Application_Model_DbTable_Configuration();
						$configs = $configT->fetchRow('ConfigId = 1')->toarray();
							
						/*$to = array($configs['OpsSpecialistName']=>$configs['OpsSpecialistEmailId'],
									$configs['TechAgencyLeadName']=>$configs['TechAgencyLeadEmailId'],
									$configs['TechAgencyDeveloperName']=>$configs['TechAgencyDeveloperEmailId']);*/
									
						$to = array(
									$configs['TechAgencyLeadEmailId'] => $configs['TechAgencyLeadName'],
									$configs['OpsSpecialistEmailId'] => $configs['OpsSpecialistName'],
									$configs['TechAgencyDeveloperEmailId'] => $configs['TechAgencyDeveloperName']
								);
								
						$this->_send($template, $bodyText,  $to);
						
						$this->_helper->FlashMessenger('Request has been sent to TA');
						$this->_helper->redirector('documents', 'author');
					}
	
				}catch(Exception $e) {					
					$form->populate($post);
					Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
				}
			}
		}
				
		$this->view->data = $docDetails;
		$this->view->data['folder'] = $folder;
		$this->view->form = $form; 
		$this->view->current_page = 'documenttab';
			
	}
	
	public function deleteGuideAction() {
		
		$this->_helper->viewRenderer->setNoRender(true);
	    $this->_helper->layout->disableLayout();
		
		$documentId = $this->_request->getPost('doc_id'); 
	
		try{		
			$docT = new Application_Model_DbTable_Documents();
			$docT->updateDocument($documentId);		
			die("success");
			//$this->_helper->FlashMessenger('Documet has been deleted successfully');
			//$this->_helper->redirector('documents', 'author');
		
		}catch(Exception $e) {					
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
		
	
	}
	public function messageAction(){ 
				
		//Request Id
		$requestId = Pp_Common_UrlHelper::deCryptId($this->_getParam('request')); //echo $requestId;

		//Fetch Request Detail
		$requestT = new Application_Model_DbTable_Requests();
		$requestDetail =  $requestT->getRequestDetail($requestId, 'n');	
		
		//echo $requestDetail['CreatedBy']; 
		$this->_reqCheck($requestId,$requestDetail['CreatedBy']);
		
		$this->view->data = $requestDetail;
		//Fetch all messages for this request
		$msgT = new Application_Model_DbTable_Messages();	
		$this->view->data['message'] = Application_Model_DbTable_Messages::getAllMsgById($requestId); 	
		
		$form = new Application_Form_Message();
		$form->useDisplayGroups();	
		$form->setAction('/author/message/request/'.$this->_getParam('request'));
				
		if($requestDetail['Status'] != Pp_Status::AssignedToAuthor){			
			$form->removeElement('status');
		}else
			$form->setDefault('status', $requestDetail['Status']);
		
		$this->view->search = (isset($this->_session->search))? $this->_session->search : Pp_Status::All;
		
		if($this->getRequest()->isPost()) { 	
			$post = $this->_request->getPost();					
			if( $form->isValid($post)){ 					
				try{

					$data['RequestId'] = $requestId;
					$data['MessageBy'] = $this->auth->getStorage()->read()->uid;
					$data['Message'] = $post['message'];
						
					$msgT = new Application_Model_DbTable_Messages();							
					if($msg = $msgT->create($data)){
						
						// if status is submittied then upadate request tabke
						if(isset($post['status'])){						
							$param['Status'] = $post['status'];
							$requestT->updateRequest($param, $requestId);
						}
					
						// Author messages Admin - Send email to Assigned Admin if not primary admin
						$toArray = array();
						if($requestDetail['AssignedTo']){
							$userT = new Application_Model_DbTable_Users();
							$to = $userT->getUserDetail($requestDetail['AssignedTo']);
							$toArray = array($to['mail'] => $to['name']);
						}
							
						$template = 'authorToAdmin';					
						$bodyText = stripslashes($post['message']);
		
						$this->_send($template, $bodyText,  $toArray);					
					}
				 										
					$this->_helper->FlashMessenger('Message has been sent to admin');
					$this->_helper->redirector('requests', 'author','', array('searh' => $this->view->search));
					
				}catch(Exception $e) {		
				
					$form->populate($post);
					Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
					
				}	
				
			}
		}	
		
		
		$this->view->form = $form; 
		
		$this->view->current_page = 'requesttab';
	}
	
	public function sendRequestAction(){		
		try {	
		
		//var_dump($this->_session);
						
		//fetch document detail 
		$documentId = Pp_Common_UrlHelper::deCryptId($this->_getParam('document'));	//echo $documentId;		
		$docT = new Application_Model_DbTable_Documents();
		$docDetail = $docT->getGuide($documentId);
		
		$form = new Application_Form_Message();
		$form->useDisplayGroups();	
		$form->setAction('/author/send-request/document/'.$this->_getParam('document'));
		$form->removeElement('status');
		$form->removeElement('cancel');
		$form->getElement('submit')->setLabel('Send Request');		
				
			 
		if($this->getRequest()->isPost()) { 	
			$post = $this->_request->getPost();			
			if( $form->isValid($post)){ 					
				try{
					
					//generate request and then send email to admin						
					$post['documentId'] = $documentId;
					$post['name'] = "Upload ". $docDetail['Name'];
					$post['createdBy'] = $this->auth->getStorage()->read()->uid; 
					$post['status'] = Pp_Status::Open;
					
					//print_r($post);
					
					//Array ( [request] => [message] => asdas [submit] => Send Request )
			
					$docT = new Application_Model_DbTable_Documents();
					$requestId = $docT->sendRequet($post);	 //echo $requestId;
					
					if($requestId){ 
	
						$template = 'review';
						
						// create view object
						$html = new Zend_View();
						$html->setScriptPath(APPLICATION_PATH . '/views/emails/');					
						$reqUrl = Pp_Common_UrlHelper::getAdminRequestURL($requestId);
						
						// assign values					
						$html->assign('link', $reqUrl);	
						$html->assign('name', stripslashes($docDetail['Name']));								
						$bodyText = $html->render($template.".phtml"); 	 
						
						
						// send email to add admin
						$userT = new Application_Model_DbTable_Users();			
						$adminArray = $this->_config->admin->toArray();
						
						//echo 
						foreach($adminArray as $key => $val)
						{
							$user = $userT->getUserDetail($key);
							if($user)
							{

								$patterns = array();
								$patterns[0] = '/_pg/';
								$patterns[1] = '/_1/';
								$replacements = array();
								$replacements[0] = '';
			
								$uname = preg_replace($patterns, $replacements, $user['name']);
								$to[$user['mail']] =  $uname;
							}
						}	
						//echo "<pre>";print_r($to);die();									
						$this->_send($template, $bodyText,  $to);
					}
					
					$this->_helper->FlashMessenger('Request has been sent to Admin');
					$this->_helper->redirector('documents', 'author');
										
				
				}catch(Exception $e) {		
				
					$form->populate($post);
					Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
					
				}	
				
			}
		}
		
		$this->view->data = $docDetail;
		$this->view->form = $form; 
		$this->view->current_page = 'documenttab';
		
		}catch(Exception $e) {
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		} 
	}
	
	
	private function _docCheck($documentId,$createdBy){
	
		$uid = $this->auth->getStorage()->read()->uid;		
		if(empty($documentId) || $uid!=$createdBy)
			$this->_helper->redirector('documents', 'author');
	}
	
	private function _reqCheck($requestId, $createdBy){
		
		$uid = $this->auth->getStorage()->read()->uid;		
		if(empty($requestId) || $uid!=$createdBy)
			$this->_helper->redirector('requests', 'author');
	}
	
	private function _handle_file_upload($id = 0, $width = 0, $height = 0) {
        
        $min = 10;
		$max = 6; // :)
		$ds = DIRECTORY_SEPARATOR;
		$image_formats = array('image/jpeg', 'image/png', 'image/bmp', 'image/tif', 'image/tiff', 'image/gif');

        if (isset($_FILES['image_file'])) {
            if (!$_FILES['image_file']['error'] && ($_FILES['image_file']['size'] > $min && (($_FILES['image_file']['size']/1024)/1024) < $max)) {
                
                $filename = $this->_renameFile($_FILES['image_file']['name']);
                $original_file_path = ($this->_path . $ds . $filename);

                move_uploaded_file($_FILES['image_file']['tmp_name'], $original_file_path);
 
                $this->_resize($width,$height,'auto',$original_file_path,$original_file_path);
                
                return $filename;
                
            } else {
            
            }
        }
	}
	
	
	public function sendAction(){
	
		  /* $to = "dipannita_das2@mindtree.com";
		   $subject = "This is subject";
		   $message = "This is simple text message.";
		   $header = "From:abc@somedomain.com \r\n";
		   $retval = mail ($to,$subject,$message,$header);
		   if( $retval == true )  
		   {
			  echo "Message sent successfully...";
		   }
		   else
		   {
			  echo "Message could not be sent...";
		   }*/
	
		$tr = new Zend_Mail_Transport_Sendmail();
		Zend_Mail::setDefaultTransport($tr);
		Zend_Mail::setDefaultFrom($this->_config->email->from, $this->_config->email->from_name);
		//Zend_Mail::setDefaultFrom($this->_config->email->from, $this->_config->email->from_name);

		
		$mail = new Zend_Mail();
		$mail->setBodyHtml('This is the text of the mail.');
		//$mail->setFrom('somebody@example.com', 'Some Sender');
		$mail->addTo('dipannita_das2@mindtree.com"', 'Some');
		$mail->setSubject('TestSubject');
		//$mail->send();

	
		try {			 				 		
	 		$mail->send();
            //return true;
            echo "Email sent"; die();
	 	}
	 	catch (Exception $e) { var_dump($e);
	 		//Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
	 	}
		

	die();
	
	}
	
	private function _send($template, $bodyText, array $to, array $cc = NULL, $pAdminCc = 'y'){
	
		
		
		
		//primary admin detail
		$userT = new Application_Model_DbTable_Users();
		$primary = $userT->getUserDetail($this->_config->primary);
		
		$tr = new Zend_Mail_Transport_Sendmail();
		Zend_Mail::setDefaultTransport($tr);
		Zend_Mail::setDefaultFrom($this->_config->email->from, $this->_config->email->from_name);
		
	 	//$mail = new Zend_Mail('utf-8'); 
	 	
		$mail = new Zend_Mail(); 
		
		if(count($to)>0){
			foreach($to as $key => $value){
				$mail->addTo($key, $value);
			}			
		}else {
			$pAdminCc = 'n'; 
			$mail->addTo($primary['mail'], $primary['name']);
		}
			
		if(count($cc)>0){
			foreach($cc as $key => $value){
				$mail->addCc($key, $value); echo "cc".$key, $value;
			}			
		}
		
		if($pAdminCc == 'y'){ 
			$mail->addCc($primary['mail'], $primary['name']); echo "primary".$key, $value;
		
		}
		
	 	$mail->setSubject($this->_config->$template->subject);
	 	$mail->setBodyHtml($bodyText);
	 	
		try {					 				 		
	 		$mail->send();
            return true;
           //echo "Email sent"; die();
	 	}
	 	catch (Exception $e) {
	 		Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
	 	}
	 	
	}
	
		
	private function _resize($width=0,$height=0,$op='',$source='',$destingation='') {
		// *** Include the class
		$image = new Application_Model_Image($source);

		// *** 1) Initialise / load image
		$resizeObj = new $image($source);

		// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
		$resizeObj -> resizeImage($width, $height, $op);

		// *** 3) Save image
		$resizeObj -> saveImage($destingation, 100);
		
		return true;
	}
    
	
}