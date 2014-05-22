<?php

class Application_Model_DbTable_Configuration extends Zend_Db_Table_Abstract {

    protected $_name = 'pp_configuration';
    
    public function getConfigDetails(){
    	try{
    						 
		    $select = $this->select()
	        		->setIntegrityCheck(false)
	        		->from(array('c' => $this->_name),array('ConfigId','OpsSpecialistName', 'OpsSpecialistEmailId', 'TechAgencyLeadName', 'TechAgencyLeadEmailId','TechAgencyDeveloperName','TechAgencyDeveloperEmailId'));
	        	         	    
	        	    $result = $this->getDefaultAdapter()->query($select)->fetch();
	        	    return $result;
    	}catch(Exception $e)
    	{
    		
    	}
    }
    
 public function updateConfig($post){
    	try{
    	$param['OpsSpecialistName'] 			= $post['OpsSpecialistName'];
		$param['OpsSpecialistEmailId'] 			= $post['OpsSpecialistEmailId'];
		$param['TechAgencyLeadName'] 			= $post['TechAgencyLeadName'];
		$param['TechAgencyLeadEmailId'] 		= $post['TechAgencyLeadEmailId'];
		$param['TechAgencyDeveloperName'] 		= $post['TechAgencyDeveloperName'];
		$param['TechAgencyDeveloperEmailId'] 	= $post['TechAgencyDeveloperEmailId'];
		$param['UpdatedOn'] 					= new Zend_Db_Expr('NOW()');
		$param['UpdatedBy'] 					= $post['uid'];

		$db = Zend_Db_Table::getDefaultAdapter();
		if(isset($post['Configid']) && $post['Configid']!='')
		$rs = $this->update($param,'ConfigId = '.$post['Configid']);
		else 
		$rs = $this->insert($param);
	    return $rs;
    	}catch(Exception $e)
    	{
    		
    	}
    }
        
}