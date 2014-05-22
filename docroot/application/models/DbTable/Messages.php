<?php

class Application_Model_DbTable_Messages extends Zend_Db_Table_Abstract {

    protected $_name = 'pp_messages';
 
	public static function getLastMsgById($requestId) {		
		try {	

			$db = Zend_Db_Table::getDefaultAdapter();
		    $select = $db->select()
	        		->from(array('m' => 'pp_messages'),array('*', 'dt'=>new Zend_Db_Expr('DATE_FORMAT(CreatedOn, \'on %D %b,  %Y\')')))  
	        		->joinLeft(array('u' => 'users'), 'm.MessageBy = u.uid',array('MessagedBy'=>'name'))   		
	        		->where('RequestId = ?', $requestId)
	        		 ->order('m.CreatedOn desc');     		
			//echo $select;		 
	       $result = $db->query($select)->fetchAll();
	       return $result['0'];
	       
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}          
	}
	
	public static function getAllMsgById($requestId) {		
		try {	

			$db = Zend_Db_Table::getDefaultAdapter();
		    $select = $db->select()
	        		->from(array('m' => 'pp_messages'),array('*','dt'=>new Zend_Db_Expr('DATE_FORMAT(CreatedOn, \'on %D %b,  %Y\')')))  	
	        		->joinLeft(array('u' => 'users'), 'm.MessageBy = u.uid',array('name'))   			        	
	        		->where('RequestId = ?', $requestId)
	        		->order('CreatedOn asc');
					
			//echo  $select;
			
	       $result = $db->query($select)->fetchAll();
	       return $result;
	       
		 }catch(Exception $e) { //var_dump($e);
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}          
	}
	
	    
	public function create(array $param) {				
		try {
		
			$param['CreatedOn'] = new Zend_Db_Expr('NOW()');
			return $this->insert($param);
			
		} catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}   
	}

	
	//  Admin Msg function start here	
	public static function getAllMessageById($requestId) {		
		try {	

			$db = Zend_Db_Table::getDefaultAdapter();
		    $select = $db->select()
	        		->from(array('r' => 'pp_requests'),array('Name','Status','RequestId'))
	        		->joinLeft(array('m'=>'pp_messages'), 'm.RequestId = r.RequestId', array('Message','MessageBy','dt'=>new Zend_Db_Expr('DATE_FORMAT(m.CreatedOn, \'on %D %b,  %Y\')')))
	        		->joinLeft(array('u'=>'users'), 'm.MessageBy = u.uid', array('name'))
	        		->where('m.RequestId = ?', $requestId)
	        		->order('m.CreatedOn asc');
	        //echo  $select;
	        		  		
	       $result = $db->query($select)->fetchAll();
	       return $result;
	       
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}          
	}
	
	
	public function createMsg($data) {		
	
	try {	
	
			// create Message
			$param['Message'] 			= $data['message'];
			$param['MessageBy'] 		= $data['uid'];
			$param['CreatedOn'] 		= new Zend_Db_Expr('NOW()');		
			$param['RequestId'] 		= $data['RequestId'];
			$messageInsert = $this->insert($param);
			$db = Zend_Db_Table::getDefaultAdapter();
			if($messageInsert){
				
				$rdata['Status'] = $data['Status'];
				$rs = $db->update('pp_requests', $rdata,'RequestId = '.$data['RequestId']);
				
			}
			//return $rs;		
				
			return true;
			
		}catch(Exception $e) { 
			
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}    
	
	}
	
	
	public static function getAdminLastMsgById($requestId) {		
		try {	

			$db = Zend_Db_Table::getDefaultAdapter();
		    $select = $db->select()
	        		->from(array('m' => 'pp_messages'),array('*', 'dt'=>new Zend_Db_Expr('DATE_FORMAT(CreatedOn, \'on %D %b,  %Y\')')))  
	        		->joinLeft(array('u' => 'users'), 'm.MessageBy = u.uid',array('MessagedBy'=>'name'))   		
	        		->where('RequestId = ?', $requestId)
	        		 ->order('m.CreatedOn desc');     		
					 
	       $result = $db->query($select)->fetchAll();
	       return $result['0'];
	       
		 }catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}          
	}
	
	
	
	
	
}