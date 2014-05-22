<?php

class Application_Model_DbTable_Requests extends Zend_Db_Table_Abstract {

    protected $_name = 'pp_requests';
    
    /**
	 *	Get requests by creator
	 *  @param int $uid 
	 *  @return array $result 
	 */
	public function getAdminRequests($uid, $status = Pp_Status::Me) {
		
		try {	
			 
		   $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array('RequestId', 'Name', 'AssignedTo', 'Status'))
	        		->joinLeft(array('d'=>'pp_documents'), 'd.DocumentId = r.DocumentId', array('Type'))
	        		->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid', array('name'))	        		
	        	    ->where('r.Status != ?', Pp_Status::Closed);		
				
	        if($status == Pp_Status::Me){
	       		$select->where('r.AssignedTo = ?', $uid)
						->where('r.Status = ? ', Pp_Status::AssignedToAdmin);
	        }
	        
		 	if($status == Pp_Status::Non){
	       		$select->where('r.AssignedTo = ?', 0)
						->where('r.Status = ? ', Pp_Status::Open);
	        }
	       			
			
	        $select->order('r.CreatedOn DESC'); //echo $select;
	        $result = $this->getDefaultAdapter()->query($select)->fetchAll();
	        return $select;
	         
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}

	
	public function getAdminRequestsCount($uid, $status = Pp_Status::Me) {
		
	try {	
			 
		    $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array("num"=>"COUNT(*)"))
	        	    ->where('r.Status != ?', Pp_Status::Closed);		
				
	        if($status == Pp_Status::Me){
	       		$select->where('r.AssignedTo = ?', $uid)
						->where('r.Status = ? ', Pp_Status::AssignedToAdmin);
	        }
	       	
	        $select->order('r.CreatedOn DESC'); //echo $select;
	        $result = $this->getDefaultAdapter()->query($select)->fetch();
	       // echo $result['num'];
	        return $result['num'];
	         
		 }   catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	
	public function getviewRequest($requestId)
	{
		try{ 
		$select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),'*')
	        		->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid', array('CreatedBy'=>'name'))	  
	        		->joinLeft(array('a'=>'users'), 'r.AssignedTo = a.uid', array('assign' => 'name') )
	        		->joinLeft(array('d'=>'pp_documents'), 'd.DocumentId = r.DocumentId',array('Type') )   
	        		->joinLeft(array('du'=>'pp_documents_uploads'), 'du.DocumentId = d.DocumentId',array('FileName','FilePath') )  		
	        		->where('r.RequestId = ?', $requestId);
	        		
	       $result = $this->getDefaultAdapter()->query($select)->fetch();
	       $result['lastMessage'] = Application_Model_DbTable_Messages::getAdminLastMsgById($requestId);
	       return $result;
	       
		}catch(Exception $e){
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	
	
	
	public function geteditRequest($requestId)
	{
		try{ 
		$select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),'*')
	        		->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid',array('CreatedBy' => 'name','AuthorId'=>'uid'))
	        		->joinLeft(array('d'=>'pp_documents'), 'd.DocumentId = r.DocumentId',array('Type') )	  
	        		->joinLeft(array('a'=>'users'), 'r.AssignedTo = a.uid', array('assign' => 'name') )      		
	        		->where('r.RequestId = ?', $requestId);
	        		
	       $result = $this->getDefaultAdapter()->query($select)->fetch(); 
	       $result['lastMessage'] = Application_Model_DbTable_Messages::getAdminLastMsgById($requestId);
      
	       return $result;
		}catch(Exception $e){
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
	
	
	
	 /**
	 *	Get All requests by author
	 *  @param int $uid 
	 *  @param int $status default pending with author 
	 *  @return array $result 
	 */
	public function getMyRequests($uid, $status = Pp_Status::Me) {		
		try {				
			$select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array('RequestId', 'Name', 'AssignedTo', 'Status'))	 
	        		->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid', array('name'))	 
	        		->joinLeft(array('a'=>'users'), 'r.AssignedTo = a.uid', array('assign' => 'name'))	       		
	        		->where('r.CreatedBy = ?', $uid);
	     
	        if($status == Pp_Status::Me)
	        	$select->where('r.Status = ?', Pp_Status::AssignedToAuthor);
			//else
				//$select->where('r.Status != ?', Pp_Status::Closed);
				
	        $select->order('r.CreatedOn DESC');	  
	        return $select;  
	      
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	
	public function getMyRequestsCount($uid, $status = Pp_Status::Me) {		
		try {				
			$select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array("num"=>"COUNT(*)"))	 
	        			
	        		->where('r.CreatedBy = ?', $uid);
	     
	        if($status == Pp_Status::Me)
	        	$select->where('r.Status = ?', Pp_Status::AssignedToAuthor);
					
	        $select->order('r.CreatedOn DESC');	 

	         $result = $this->getDefaultAdapter()->query($select)->fetch();
	        
	         return $result['num'];  
	      
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	
	
	
	
	public function getMyAllRequests($uid) {		
		try {										 
		    $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array('RequestId', 'Name', 'AssignedTo', 'Status', 'Type'))       		
	        		->where('r.CreatedBy = ?', $uid);
	     	        	
	        $select->order('r.CreatedOn');	  	        
	        return $select;  
	         
		 }catch(Exception $e) { 
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	public function getRequestDetail($requestId, $lastmsg = 'y') {		
		try {	
								 
				$select = $this->select()
					->setIntegrityCheck(false)
					->from(array('r' => $this->_name),'*')
					->joinLeft(array('d'=>'pp_documents'), 'r.DocumentId = d.DocumentId', array('Type'))					
					->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid', array('name'))	  
					->joinLeft(array('a'=>'users'), 'r.AssignedTo = a.uid', array('assign' => 'name') )      		
					->where('r.RequestId = ?', $requestId);
	
				$result = $this->getDefaultAdapter()->query($select)->fetch();	 
				if($lastmsg == 'y')
					$result['lastMessage'] = Application_Model_DbTable_Messages::getLastMsgById($requestId);
		
				return $result;
	       
		 }catch(Exception $e) { 
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
    
	public static function getFolders() {		
		try {		
			
			$db = Zend_Db_Table::getDefaultAdapter();
		    $select = $db->select()
	        		->from('vocabulary', array('key' => 'vid', 'value' =>'name'))    		
	        		->where('vid IN (?)', array('10','11','12'));
	        		       	
	       $categories = $db->query($select)->fetchAll();
	       $result = array();	   	       	       
		   foreach($categories as $key => $category){	       		
	       	  $result[$category['value']] = self::getSubFolders($category['key']);	       	
	       }
	       
	       return $result;
	       
		 }catch(Exception $e) { 	 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}

	public static function getSubFolders($vid) {				
		try {		
						
			$db = Zend_Db_Table::getDefaultAdapter();
			
		    $select = $db->select()
	        		->from('term_data', array('key' => 'tid', 'value' => 'name'))    		
	        		->where('vid = ?', $vid);	 
					
	        $result =  self::_preProcess( $db->query($select)->fetchAll(), $vid);
	        return $result;
	       
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	private static function _preProcess($result, $vid) {				
		try {	
		
		   foreach($result as $row)
				  $resultq[$row['key']."_".$vid] = $row['value'];
	       return $resultq;
	       
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e); 
		 }          

	}
	
	public static function getFolderById($vid) {		
		try {		
		
			$db = Zend_Db_Table::getDefaultAdapter();
		    $select = $db->select()
	        		->from('term_data', 'name')    		
	        		->where('tid = ?', $vid);	 
					
	        $result =  $db->fetchCol($select);
	        return $result['0'];
	       
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	public function create($post) {		
				
		$param['CreatedOn'] = new Zend_Db_Expr('NOW()');
		$param['Type'] = 'p';
		$param['Name'] = NULL;
		$param['Status'] = Pp_Status::Temp;
		
		try {	
			return $this->insert($post);
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e); 
		}    
	
	}
	
	public function updateRequest($data, $requestId) {		
		
		try {			
		
			 $data['UpdatedOn'] = new Zend_Db_Expr('NOW()');
			 $where = $this->getAdapter()->quoteInto('RequestId = ?', $requestId);	
			 $this->update($data, $where);
			 
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e); 
		}
	}
	
	public static function activeRequest($documentId) {
	
		try {		
		
			$activeStatus = array(Pp_Status::Open, Pp_Status::TA, Pp_Status::AssignedToAuthor, Pp_Status::AssignedToAdmin, Pp_Status::Closed);
			
			$db = Zend_Db_Table::getDefaultAdapter();
			$select = $db->select()
						 ->from('pp_requests', 'Status')    		
						 ->where('DocumentId =?', $documentId)
						 ->where('Status IN (?)', $activeStatus);
		
			$result = $db->query($select)->fetch();
			return $result;
			
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e); 
		}
		 
	}
	
	public function updateAdminRequest($data, $requestId)
	{
		try {
		
			$db = Zend_Db_Table::getDefaultAdapter();			
			$rs = $db->update('pp_requests', $data,'RequestId = '.$requestId); 
			return $rs;
			
		}catch(Exception $e)
		{
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e); 
		}
	}
	
	public function sendtoTa($requestId) {
		
		try {	
								 
		    $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array('RequestId', 'Name','DocumentId'))
	        		->joinLeft(array('d'=>'pp_documents'), 'd.DocumentId = r.DocumentId', array('Type'))
	        		->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid', array('name'))	        		
	        	    ->where('r.RequestId = ?', $requestId);
	       	      	$select->order('r.CreatedOn');
	       	    
	        $result = $this->getDefaultAdapter()->query($select)->fetch();
	        return $result;  
	         
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	public function getDocLink($requestId) {
		
		try {	
								 
		    $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array('RequestId', 'DocumentId'))
	        		->joinLeft(array('d'=>'pp_documents'), 'd.DocumentId = r.DocumentId', array('Name'))
	        		//->joinLeft(array('u'=>'pp_documents_uploads'), 'd.DocumentId = u.DocumentId', array('FileName', 'FilePath'))	        		
	        	    ->where('r.RequestId = ?', $requestId);
	       	      	$select->order('r.CreatedOn');
	       	    
	        $result = $this->getDefaultAdapter()->query($select)->fetch();
	        return $result;  
	         
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	public function getAuthorDetail($requestId) {		
		try {	
								 
				$select = $this->select()
					->setIntegrityCheck(false)
					->from(array('r' => $this->_name),'Name')					
					->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid', array('CreatedBy'=>'name','mail'))
					->joinLeft(array('a'=>'users'), 'r.AssignedTo = a.uid', array('assignName' => 'name', 'assignMail' => 'mail'))	
					->where('r.RequestId = ?', $requestId);
				
				
				
				$result = $this->getDefaultAdapter()->query($select)->fetch();	 
				
				
				
				return $result;
	       
		 }catch(Exception $e) { 
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}          
	}
	
	
	public function getEmailRequestDetail($requestId)
	{
	
		try{
			$select = $this->select()
					->setIntegrityCheck(false)
					->from(array('r' => $this->_name),'*')					
					->joinLeft(array('u'=>'users'), 'r.CreatedBy = u.uid', array('CreatedBy'=>'name','mail'))
					->joinLeft(array('a'=>'users'), 'r.AssignedTo = a.uid', array('assignName' => 'name', 'assignMail' => 'mail'))	
					->where('r.RequestId = ?', $requestId);
				
				//echo $select; die();
				
				$result = $this->getDefaultAdapter()->query($select)->fetch();	
				//echo "<pre>";print_r($result);die();

				return $result;
			
		}catch(Exception $e)
		{
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}
	}
}