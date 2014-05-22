<?php

class Application_Model_DbTable_Documents extends Zend_Db_Table_Abstract {

    protected $_name = 'pp_documents';
    protected $_primary = 'DocumentId';
    
	public  function getDocumentById($documentId) {		
		try {	

		    $select = $this->select()
	        		->from($this->_name, array('Name', 'File', 'Folder'))
		        		->where('RequestId = ?', $requestId);
	       $result = $this->getDefaultAdapter()->query($select)->fetch();	       
	       return $result;
	       
		 }catch(Exception $e) { 
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	public  function getDetailById($documentId) {		
		try {	

		   $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('d' => $this->_name),array('Name', 'CreatedBy'))
					->joinLeft(array('u'=>'pp_documents_uploads'), 'd.DocumentId = u.DocumentId', '*')	        		
	        		->where('d.DocumentId = ?', $documentId);
			
			//echo $select;			
	       $result = $this->getDefaultAdapter()->query($select)->fetch();	      
	       return $result;
	       
		 }catch(Exception $e) { 
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	/**
	 *	Get All Documents by author
	 *  @param int $uid 
	 *  @param int $status default pending with author 
	 *  @return array $result 
	 */
	public function getMyDocumentsCount($uid, $type = "") {	
		try {				
		
			$status = array(Pp_Status::DocDeleted, Pp_Status::tempDeleted);

			$select = $this->select()
	        		->from(array('d' => $this->_name),array("num"=>"COUNT(*)"))
	        		->where('d.CreatedBy = ?', $uid)
					->where('d.Flag NOT IN (?)', $status);	
					
					
					
			if(!empty($type)){ 				
				$type = Pp_Type::getIdByDescription($type); 
				$select->where('d.Type = ?', $type);
			}				
	        $select->order('d.CreatedOn DESC');	
	        
	        $result = $this->getDefaultAdapter()->query($select)->fetch();
	        
	        return $result['num'];  
	         
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	
	public function getMyDocuments($uid, $type = "") {	
		try {				
		
			$status = array(Pp_Status::DocDeleted, Pp_Status::tempDeleted);

			$select = $this->select()
	        		->from(array('d' => $this->_name),array('DocumentId', 'Name', 'Type'))
	        		->where('d.CreatedBy = ?', $uid)
					->where('d.Flag NOT IN (?)', $status);	
					
					
					
			if(!empty($type)){ 				
				$type = Pp_Type::getIdByDescription($type); 
				$select->where('d.Type = ?', $type);
			}				
	        $select->order('d.CreatedOn DESC');	
	        return $select;  
	         
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	
	
	
	public function getGuide($documentId) {			
		try {	

		   $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('d' => $this->_name),array('*'))
					->joinLeft(array('c'=>'pp_documents_content'), 'd.DocumentId = c.DocumentId', '*')	        		
	        		->where('d.DocumentId = ?', $documentId);
			//echo $select; die();
	       $result = $this->getDefaultAdapter()->query($select)->fetch();	 	  
	       return $result;
	       
		}catch(Exception $e) { 
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}  
		
	}

	public function createDocument($data, $action = 'send') {		//print_r($data); die();
	//add transaction
	try {	
	
		// create document
		$param['Name'] 			= $data['name'];
		
		if(isset($data['type'])){
			$param['Type'] 		= $data['type'];
		}
		
		if(isset($data['category'])){	
			$param['Category'] 	= $data['category'];
		}
		
		$param['Flag'] 			= Pp_Status::Active;
			 
		if(!empty($data['documentId'])){ 
		
			$documentId = $data['documentId'];
			$param['UpdatedOn'] = new Zend_Db_Expr('NOW()');
			$where = $this->getAdapter()->quoteInto('DocumentId = ?', $documentId );					
			$this->update($param, $where );		
		}
		else {
			
			$param['CreatedBy'] 	= $data['createdBy'];
			$param['CreatedOn'] = new Zend_Db_Expr('NOW()');
			$documentId = $this->insert($param);

		}
		
		if($data['type'] == Pp_Type::Document){
			// insert file information 
			$file['DocumentId'] 	= $documentId;
			$file['SubCategory']    = $data['subCategory'];
			$file['FileName'] 		= $data['fileName'];
			$file['FilePath'] 		= $data['filePath'];
			$file['MetaData'] 		= $data['metaData'];
			
			$uploadT = new Application_Model_DbTable_Uploads();
			$uploadT->insert($file);
		}else{
						
			// fetch content if not present insert else update latest content 			
			$arrayData = array($documentId, $data['elm1'], $data['elm1']);			
			$sql = "INSERT INTO pp_documents_content (DocumentId, Content) VALUES (?, ?) ON DUPLICATE KEY UPDATE Content = ?";
			$this->getAdapter()->query($sql, $arrayData);
				
		}		
		if($action == 'send'){
		
			// create request
			$request['DocumentId'] 	= $documentId;
			$request['Name'] 		= 'Upload ' . $data['name'];
			$request['CreatedOn'] 	= new Zend_Db_Expr('NOW()');
			$request['CreatedBy'] 	= $data['createdBy'];
			$request['Status'] 		= ($data['type'] == Pp_Type::Document)? Pp_Status::TA : Pp_Status::Open;
			
			$reqT = new Application_Model_DbTable_Requests();
			$requestId = $reqT->insert($request);
			
			if($data['type'] == Pp_Type::Document){
				// log message
				$message['RequestId'] = $requestId;
				$message['Message']	  = $data['message'];
				$message['MessageBy'] = $data['createdBy'];
				$message['CreatedOn'] 	= new Zend_Db_Expr('NOW()');
			
				$msgT = new Application_Model_DbTable_Messages();
				$msgT->insert($message);
			}
			
			return $requestId;		
		}
		
		return $documentId;
			
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}    
	
	}
	
	public function sendRequet($data){
		
		try {
		
			$request['DocumentId'] 	= $data['documentId'];
			$request['Name'] 		= $data['name'];
			$request['CreatedBy'] 	= $data['createdBy']; 
			$request['Status'] 		= $data['status'];
			$request['CreatedOn'] 	= new Zend_Db_Expr('NOW()');

			$reqT = new Application_Model_DbTable_Requests();
			
			// log message
			$message['RequestId'] = $reqT->insert($request);
			$message['Message']	  = $data['message'];
			//$message['Status'] 	  = Pp_Status::Open;
			$message['MessageBy'] = $data['createdBy'];
			$message['CreatedOn'] 	= new Zend_Db_Expr('NOW()');
			
			$msgT = new Application_Model_DbTable_Messages();
			$msgT->insert($message);
			
			return $message['RequestId'];
		
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}	
		
	}
	
	public function deleteDocument($data) {	
	
		try {
		
			$request['DocumentId'] 	= $data['documentId'];
			$request['Name'] 		= $data['name'];
			$request['CreatedBy'] 	= $data['createdBy']; 
			$request['Status'] 		= $data['status'];
			$request['CreatedOn'] 	= new Zend_Db_Expr('NOW()');

			$reqT = new Application_Model_DbTable_Requests();
			
			// log message
			$message['RequestId'] = $reqT->insert($request);
			$message['Message']	  = $data['message'];
			//$message['Status'] 	  = Pp_Status::TA;
			$message['MessageBy'] = $data['createdBy'];
			$message['CreatedOn'] 	= new Zend_Db_Expr('NOW()');
			
			$msgT = new Application_Model_DbTable_Messages();
			$msgT->insert($message);
						
			$this->updateDocument($data['documentId']);
			
			return $message['RequestId'];
		
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}	
		
	}
	
	public function updateDocument($documentId) {		
	
		$data['Flag'] 	   = Pp_Status::DocDeleted;
		$data['UpdatedOn'] = new Zend_Db_Expr('NOW()');	
		$where = $this->getAdapter()->quoteInto('DocumentId = ?', $documentId );		
		try {		
			$this->update($data, $where );		
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}		 
	}
	
	public static function getAttachmentUrl($documentId){
	
	try {	
			$db = Zend_Db_Table::getDefaultAdapter();
			$select = $db->select()
					->from('pp_documents_uploads', array('Filename', 'FilePath'))    		
					->where('DocumentId =?', $documentId);
					
			$result = $db->query($select)->fetch();
			return $result;
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}

	}
	
	public function docNameDuplicate($name){
	
		try {	
				$type = array('p','pg');
			$where = $this->getAdapter()->quoteInto('Name = ?', $name );
			//$result = $this->fetch();
			
			$select = $this->select()
	        		->from($this->_name,array("num"=>"COUNT(*)"))
	        		->where($where)
	        		->where('Type IN (?)',$type);
	        		//echo $select;
			//echo $select;		
			
			$result = $this->getDefaultAdapter()->query($select)->fetch();			  
			return $result['num'];
			
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}

	}
	
	
	
}