<?php

/**
 *	P&G ProcessPedia Micro Site Application
 *
 *	@aspect		Controller
 *	@date		01.23.2014
 *	@version	3.0.0
 *
 *	@purpose	Admin Modules
 *
 *	@file		AdminController.php
 */


class AdminController extends Zend_Controller_Action {
	
	protected $_session;
	protected $auth;
	protected $_config;
	protected $img_exts = array('jpeg', 'jpg', 'png', 'gif');
	protected $exts = array('pdf'=>'pdf.png', 'doc'=>'word.png', 'docx'=>'word.png', 'pptx'=>'ppt.jpg', 'xlsx'=>'excel.jpg', 'xls'=>'excel.jpg', 'csv'=>'excel.jpg', 'jpeg' => 'NULL', 'jpg'  => 'NULL', 'png'  => 'NULL', 'gif'  => 'NULL');	
 
	
	public function init() { 
				
 		$this->view->headTitle('PP Editor - Admin');
		$this->auth 	= Zend_Auth::getInstance();		
 		$this->_config  = Zend_Registry::get('config'); 
 		$this->_session = new Zend_Session_Namespace('Admin');
		$this->view->docViewPath = $this->_config->docViewPath;
 		
		if ($this->_helper->FlashMessenger->hasMessages()) {
	        $this->view->errmessages = $this->_helper->FlashMessenger->getMessages();
	    }
		 		
    }
    
	Public function requestsAction(){
		try {	
							
			$this->view->search = $this->_getParam('search', Pp_Status::Me);
						
			$uid = $this->auth->getStorage()->read()->uid; 
			$tb = new Application_Model_DbTable_Requests(); 			
			$select = $tb->getAdminRequests($uid, $this->view->search);			
			
			$paginator = Zend_Paginator::factory($select);
	        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
	        $paginator->setItemCountPerPage($this->_config->itemCountPerPage);
	        
	        $this->view->data = $paginator;
	        
	        $rowCountResult = $tb->getAdminRequestsCount($uid, $this->view->search);	
	        $this->view->rowCount = $rowCountResult;
	        
	        $this->view->admin_current_page = 'requesttab';
			
		}catch(Exception $e) {
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}  
		
	}
	
	Public function viewrequestAction()
	{
		try{
			
			$this->view->search = $this->_getParam('search');						
			$requestId = (int)$this->_getParam('request');
			
			$tb = new Application_Model_DbTable_Requests();
			$select = $tb->getviewRequest($requestId);

			$admin_roles = $this->_config->admin->toArray(); 
			$admin_role_id = array_keys($admin_roles);			
			//print_r($admin_role_id);
			
			$this->view->admin_id = $admin_role_id;		
			$this->view->rs = $select;			
			$this->view->admin_current_page = 'requesttab';
			
		}catch(Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
		
	}
	
	Public function editrequestAction(){
		try{
			
			$this->view->search = $this->_getParam('search');
			$requestId = $this->_getParam('request');
			$tb = new Application_Model_DbTable_Requests();
			$select = $tb->geteditRequest($requestId);
			
			//$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/config.ini',APPLICATION_ENV);			
			//$admin_roles = $config->admin->toArray();
			
			$admin_roles = $this->_config->admin;
			$this->view->admin_role = $admin_roles;
			//$this->_helper->FlashMessenger('Request has been updated Successfully');
			$this->view->rs = $select;
			
			$this->view->admin_current_page = 'requesttab';
			
		}catch(Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	Public function updaterequestAction(){
		try{
			
			$data = $this->getRequest();
			$requestId = $data->getParam('RequestId');
			$tb = new Application_Model_DbTable_Requests();
			$doctype =  $data->getParam('doctype');
			
			 $preAssignTo =  $data->getParam('preAssignTo');
			 $assign =  $data->getParam('assign');
			 
			 $DocumentId =  $data->getParam('DocumentId');
			echo $DocumentUrl = Pp_Common_UrlHelper::getPreviewURL($DocumentId);
			
			$preStatus =  $data->getParam('preStatus');
			$status =  $data->getParam('Status');
			echo $statusVal = Pp_Status::getDescriptionById($status);
			
			if(isset($doctype) && $doctype != 'd'){
			$data = array('StagingUrl'=>$data->getParam('StagingUrl'),'ProductionUrl'=>$data->getParam('ProductionUrl'),'Status'=>$data->getParam('Status'),'AssignedTo'=>$data->getParam('assign'));
			}else{
			$data = array('Status'=>$data->getParam('Status'),'AssignedTo'=>$data->getParam('assign'));
			}
			
			$select = $tb->updateAdminRequest($data, $requestId);
			
			
			
			
			// if  assign to get changed send email to assign admin, cc primary admin and author
			if($assign != $preAssignTo && $status!=Pp_Status::Closed){ 
					
				$to =  $tb->getAuthorDetail($requestId);
				
				$cc = array($to['mail'] => $to['CreatedBy']);		
				$toArray = array($to['assignMail'] => $to['assignName']);
				
				$template = 'editRequest';	

				$html = new Zend_View();
				$html->setScriptPath(APPLICATION_PATH . '/views/emails/');					
					
				//$html->assign('name', str_ireplace("upload", "",$to['Name']));
				$html->assign('name', $to['Name']);	
				$html->assign('status', $statusVal);	
				$html->assign('RequestBy', $to['CreatedBy']);	
				$html->assign('AssignedTo', $to['assignName']);	
				$html->assign('DocumentUrl', $DocumentUrl);							
				$bodyText = $html->render($template.".phtml"); 	 
				
				$this->_send($template, $bodyText,  $toArray, $cc);	
				
			}
			
			
			if(Pp_Status::Closed == $status){ 
					
				$to =  $tb->getEmailRequestDetail($requestId);	
				//$cc = array($to['mail'] => $to['CreatedBy']);		
				$toArray = array(
				$to['assignMail'] => $to['assignName'],
				$to['mail'] => $to['CreatedBy']
				);
				
				$template = 'closed';	

				$html = new Zend_View();
				$html->setScriptPath(APPLICATION_PATH . '/views/emails/');					
					
				//$html->assign('name', str_ireplace("upload", "",$to['Name']));
				$html->assign('name', $to['Name']);	
				$html->assign('status', $statusVal);	
				$html->assign('RequestBy', $to['CreatedBy']);	
				$html->assign('AssignedTo', $to['assignName']);	
				$html->assign('DocumentUrl', $DocumentUrl);	

				$html->assign('StagingUrl', $to['StagingUrl']);
				$html->assign('ProductionUrl', $to['ProductionUrl']);
				
				$bodyText = $html->render($template.".phtml");
				
				//echo $bodyText;die();
					 

				$this->_send($template, $bodyText,  $toArray);	
				
			}
			
					
			
			
		if($preStatus!=Pp_Status::TA && $status==Pp_Status::TA){ 
			
				$configT = new Application_Model_DbTable_Configuration();
				$configs = $configT->fetchRow('ConfigId = 1')->toarray();
				//echo "<pre>";print_r($configs);die();
				$to =  $tb->getAuthorDetail($requestId);	
				$cc = array($to['mail'] => $to['name']);		
				
				$toArray = array(
							$configs['TechAgencyLeadEmailId'] => $configs['TechAgencyLeadName'],
							$configs['OpsSpecialistEmailId'] => $configs['OpsSpecialistName'],
							$configs['TechAgencyDeveloperEmailId'] => $configs['TechAgencyDeveloperName']
							);
							
			try{ 
				
				$template = 'sendToTa';	
				
				$html = new Zend_View();
				$html->setScriptPath(APPLICATION_PATH . '/views/emails/');					
					
				$html->assign('name', str_ireplace("upload", "",$to['Name']));	
				$html->assign('link', Pp_Common_UrlHelper::getPreviewURL($DocumentId));							
				$bodyText = $html->render($template.".phtml"); 	 

				$this->_send($template, $bodyText,  $toArray, $cc);	
			}catch (Exception $e)
			{
			echo $e->getMessage();
			}
				
			}
					
			
			
			
			$this->_helper->FlashMessenger('Request has been updated successfully');
			$this->_helper->redirector('viewrequest', 'admin', '', array('request' => $requestId));			
			$this->view->admin_current_page = 'requesttab';
			
		}catch (Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	Public function sendmsgAction()
	{
		try{
			
			$this->view->search = $this->_getParam('search');
			$requestId = $this->_getParam('request');
			$data = $this->getRequest();
			$msg = new Application_Model_DbTable_Messages();
			
			$select = $msg->getAllMessageById($requestId);
					
			$this->view->rs = $select;
			$this->view->admin_current_page = 'requesttab';
			
			
		}catch(Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
		
	}
	public function createmsgAction()
	{
		try{
			$uid = $this->auth->getStorage()->read()->uid;
			$data = $this->getRequest();
			
			if($this->getRequest()->isPost()) { 				
			$post = $this->_request->getPost();
			//print_r($post);
			
			$post['uid'] = $uid;
			
			$msg = new Application_Model_DbTable_Messages();
			$select = $msg->createMsg($post);
			if($select)	
			{	
				//send message
				//print_r($post); die();
				
				// get author detail getAuthorDetail
				$reqT = new Application_Model_DbTable_Requests();
				$to = $reqT->getAuthorDetail($post['RequestId']);
				
				//print_r($to);
				$toArray = array($to['mail'] => $to['name']);

					
				$template = 'adminToAuthor';

				
				// create view object
				$html = new Zend_View();
				$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
				
				$html->assign('message', stripslashes($post['message']));
				$html->assign('to', $to['name']);
				//$html->assign('link', Pp_Common_UrlHelper::getPreviewURL($result['DocumentId']));	
				
			
				$bodyText = $html->render($template.".phtml"); 	 					
				
				//$bodyText = stripslashes($post['message']);

				$this->_send($template, $bodyText,  $toArray);	
						
				$this->_helper->FlashMessenger('Message has been sent successfully');
			}
			$this->_helper->redirector('requests', 'admin', '', array());
			}
			
			$this->view->admin_current_page = 'requesttab';
			
		}catch(Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	
	public function sendtotaAction()
	{
	try{
			$this->view->search = $this->_getParam('search');
			$uid = $this->auth->getStorage()->read()->uid;
			if($this->getRequest()->isPost()) { 
				
				$post = $this->_request->getPost(); 
				$post['uid'] = $uid;
				//echo "<pre>";print_r($post);die();
				$msg = new Application_Model_DbTable_Messages();
				$select = $msg->createMsg($post);
				
				// send message to Technical Agency/DPO 
				$requestId = $post['RequestId']; 
				$tb = new Application_Model_DbTable_Requests();
				$result = $tb->getDocLink($requestId);
				
				//echo "<pre>";
				//print_r($result);
				
				// send email
				$template = 'sendToTA';		
				
				// create view object
				$html = new Zend_View();
				$html->setScriptPath(APPLICATION_PATH . '/views/emails/');
				
				$html->assign('name', $result['Name']);
				$html->assign('link', Pp_Common_UrlHelper::getPreviewURL($result['DocumentId']));	
				
			
				$bodyText = $html->render($template.".phtml"); 	 					
											
				$configT = new Application_Model_DbTable_Configuration();
				$configs = $configT->fetchRow('ConfigId = 1')->toarray();
									
				$to = array(
							$configs['TechAgencyLeadEmailId'] => $configs['TechAgencyLeadName'],
							$configs['OpsSpecialistEmailId'] => $configs['OpsSpecialistName'],
							$configs['TechAgencyDeveloperEmailId'] => $configs['TechAgencyDeveloperName']
						);
								
				$this->_send($template, $bodyText,  $to);
				
				$this->_helper->FlashMessenger('Request has been sent to TA');
				$this->_helper->redirector('requests', 'admin', '', array());
				
			}else{
			
			
				$requestId = $this->_getParam('request');
				$tb = new Application_Model_DbTable_Requests();
				$select = $tb->sendtoTa($requestId);
				//echo "<pre>";print_r($select);die();
				$this->view->rs = $select;
			}
			
			$this->view->admin_current_page = 'requesttab';
			
			
		}catch(Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
			
		}
	}
	
	public function configurationAction()
	{
		try {
			
			$config = new Application_Model_DbTable_Configuration();
			if($this->getRequest()->isPost()) {
				
				$uid = $this->auth->getStorage()->read()->uid;
				$post = $this->_request->getPost();
				$post['uid'] = $uid;
				$select = $config->updateConfig($post);	
				$this->_helper->FlashMessenger('Record has been updated successfully');
				$this->_helper->redirector('configuration', 'admin', '', array());				
				
			}
			$result = $config->getConfigDetails();
			$this->view->rs = $result;
			
			$this->view->admin_current_page = 'configurationtab';
				
		}catch(Exception $e){
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	
	public function templatesAction()
	{
		try {		
				$temp = new Application_Model_DbTable_MasterTemplates();
				$result = $temp->getAllMasterTemplates();
				$this->view->rs = $result;			

				$this->view->admin_current_page = 'templatetab';
				
		}catch(Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	
	public function createtemplateAction()
	{
		try {	
				
			$temp = new Application_Model_DbTable_MasterTemplates();
			
			// Edit Master Template section.....
			$templateId = $this->_getParam('template');
			if(isset($templateId))
			{
				$temp = new Application_Model_DbTable_MasterTemplates();
				$result = $temp->getMasterTemplates($templateId);
				$this->view->rs = $result;	
				
			}elseif($this->getRequest()->isPost()) {
			
				$post = $this->_request->getPost();
				$uid = $this->auth->getStorage()->read()->uid;
				$post['uid'] = $uid;
				$tempid = $post['templateid'];							 
				$select = $temp->createMasterTemplate($post, $tempid);
				if(!empty($post['templateid']))
					$this->_helper->FlashMessenger('Template has been updated successfully');
				else
					$this->_helper->FlashMessenger('Template has been created successfully');
					
				$this->_helper->redirector('templates', 'admin', '', array());
			}				
			
			$this->view->admin_current_page = 'templatetab';
					
		}catch(Exception $e){
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	
	
	public function deleteTempAction() {
		
		$templateId = $this->_request->getPost('temp_id'); 
	
		try{	
				
			$temp = new Application_Model_DbTable_MasterTemplates();
			$temp->deleteTemp($templateId);	
			//$this->_helper->FlashMessenger('Template has been deleted successfully');
			//$this->_helper->redirector('templates', 'admin');			
			die("success");
		
		}catch(Exception $e) {					
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
		
	
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
       
	
	public function editDocumentAction(){ 
				
		if($this->_getParam('document')){
			$documentId = (int) $this->_getParam('document');
			$requestId = (int) $this->_getParam('request');
			$this->_session->documentId = $documentId;	
			$this->_session->requestId = $requestId	;

		}else {		
				$documentId = $this->_session->documentId; 
				$requestId = $this->_session->requestId;
		}
		
		$docT = new Application_Model_DbTable_Documents(); 
		$getGuide	= $docT->getGuide($documentId);	
		
		$this->view->name = $getGuide['Name'];
		$this->view->folder =  $getGuide['Type']."_".$getGuide['Category'];
		$this->view->content = trim(stripslashes($getGuide['Content']));
	
			
		if($this->getRequest()->isPost()) { 	
			$post = $this->_request->getPost();
		
			$valid = $this->_validate(array('name' => $post['name'], 'elm1' => $post['elm1']));		
			if ($valid && !is_array($valid)) { 
			
				$post['createdBy'] = $this->auth->getStorage()->read()->uid; 
				$category = explode("_", $post['folder']);	
				$post['type'] = $category['0'];
				$post['category'] = $category['1'];					
				$post['documentId'] = $documentId;
				
				try {	
					
					$documentId = $docT->createDocument($post, 'save');									
					//Zend_Session::namespaceUnset('Admin');					
				
					$this->_helper->FlashMessenger('Document has been saved');
					$this->_helper->redirector('viewrequest', 'admin','',array('request' => $this->_session->requestId));
					
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
		
		$this->view->admin_current_page = 'requesttab';
		
	}
	
	
	private function _validate(array $post) {
		
		//name, elm1
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
	
	private function _send($template, $bodyText, array $to, array $cc = NULL, $pAdminCc = 'y'){
	
		
		//print_r($to);
		
		//echo $bodyText; die();
		
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
			
			$patterns = array();
			$patterns[0] = '/_pg/';
			$patterns[1] = '/_1/';
			$replacements = array();
			$replacements[0] = '';
			
			$uname = preg_replace($patterns, $replacements, $primary['name']);
			$pAdminCc = 'n'; 
			$mail->addTo($primary['mail'], $uname);
		}
			
		if(count($cc)>0){
			foreach($cc as $key => $value){
				$mail->addCc($key, $value); echo "cc".$key, $value;
			}			
		}
		
		if($pAdminCc == 'y'){ 
			
			$patterns = array();
			$patterns[0] = '/_pg/';
			$patterns[1] = '/_1/';
			$replacements = array();
			$replacements[0] = '';
			
			$uname = preg_replace($patterns, $replacements, $primary['name']);
			$mail->addCc($primary['mail'], $uname); echo "primary".$key, $value;
		
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
	
}