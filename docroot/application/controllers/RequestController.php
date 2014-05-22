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

class RequestController extends Zend_Controller_Action {
	
	protected $_config;
	
	public function init() { 
				
 		$this->view->headTitle('PP Editor');
		

 		$this->_config  = Zend_Registry::get('config'); 
		$this->view->docViewPath = $this->_config->docViewPath;
 		$this->_session = new Zend_Session_Namespace('Author');
 		
	 	if ($this->_helper->FlashMessenger->hasMessages()) {
	        //$this->view->errmessages = $this->_helper->FlashMessenger->getMessages();
	    }
 		
    }
	
	public function detailAction(){		
		try {	
		
			$RequestId = Pp_Common_UrlHelper::deCryptId($this->_getParam('request'));  			
			$reqT = new Application_Model_DbTable_Requests(); 				       
			$requestDetail = $reqT->getRequestDetail($RequestId);	
			$this->view->data = $requestDetail ;
			$this->view->search = (isset($this->_session->search))? $this->_session->search : Pp_Status::All;
			
		}catch(Exception $e) {
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		} 
	}

	public function previewAction(){ 
	
		$this->_helper->layout->disableLayout();

		if($this->_getParam('document_id')){
			
			$documentId = Pp_Common_UrlHelper::deCryptId($this->_getParam('document_id'));				
			$docT = new Application_Model_DbTable_Documents();
			$docDetail = $docT->getGuide($documentId);
					
			$this->view->content = stripslashes($docDetail['Content']);
			
		}
		
	}
	
	public function tplpreviewAction(){ 
	
		//request/tpl-previews/document_id/111
	
		/*$this->_helper->layout->disableLayout();		
		$documentId = Pp_Common_UrlHelper::deCryptId($this->_getParam('document_id'));	
		
		$docT = new Application_Model_DbTable_Documents();
		$docDetail = $docT->getGuide($documentId);
				
		$this->view->content = stripslashes($docDetail['layout']);*/
		$this->render('preview');
		
		
	}

}