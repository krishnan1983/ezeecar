<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract {

    protected $_name = 'users';
    protected $_primary = 'uid';
       
    public function getUserDetail($uid) {	    	
	    try {	
		       $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('r' => $this->_name),array('name', 'mail'))       		
	        		->where('r.uid = ?', $uid);
	        	//echo $select;
	           $result = $this->getDefaultAdapter()->query($select)->fetch();
		       return $result;
		       
			 }catch(Exception $e) { var_dump($e);
				Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);		
			}          
        
    }
    
    public function checkEmailAvailable($email)
    {
    	try {
	    		$select = $this->select()
		    		->from('users')
		    		->where('mail = ?',$email);
    		
    		$stmt = $this->getDefaultAdapter()->query($select)->fetch();
    		//echo $stmt;
    		return $stmt; 
    	}catch (Exception $e){
    		Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);		
    	}
    	
    }
    
    public function createPgUser($post)
    {
    	
    	//echo "<pre>";print_r($postData);die();
		  $result = $this->insert($post);
		  return $result;
	  
    }
}