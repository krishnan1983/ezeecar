<?php

class Application_Model_DbTable_MasterTemplates extends Zend_Db_Table_Abstract {

    protected $_name = 'pp_mastertemplates';
    
    
	public static function getTemplates() {		
		try {		
					   
		   $db = Zend_Db_Table::getDefaultAdapter();
			$select = $db->select()->from( 'pp_mastertemplates', array(new Zend_Db_Expr("CONCAT(TemplateType,'_',TemplateId)"),  'TemplateName'))
					->where('Flag != ?',Pp_Status::DocDeleted);
	
			$result = $db->fetchPairs($select);	
			
			return $result;
			
		 }catch(Exception $e) { var_dump($e); 		 	
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}          
	}
	
	public static function getAllMasterTemplates() {		
		try {		
					   
		   $db = Zend_Db_Table::getDefaultAdapter();
			$select = $db->select()
			->from(array('pp_mastertemplates'),'*')
			->where('Flag != ?','1');
						
			$result = $db->fetchAll($select);	
			
			return $result;
			
		 }catch(Exception $e) { var_dump($e); 		 	
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}          
	}
	
	public function getMasterTemplates($templateId) {		
		try {		
					   
		   $db = Zend_Db_Table::getDefaultAdapter();
			$select = $this->select()
			->from(array('pp_mastertemplates'),'*')
			->where('TemplateId = ?',$templateId);
						
			$result = $db->query($select)->fetch();	 
			
			return $result;
			
		 }catch(Exception $e) { var_dump($e); 		 	
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);			
		}          
	}
	
	
	
	public  function createMasterTemplate($post, $tempid) {		
		try {	
		
		// create document
		$param['TemplateName'] 			= $post['templatename'];
		$param['TemplateType'] 			= $post['templatetype'];
		$param['TemplateLayout'] 		= $post['elm1'];
		$param['CreatedBy'] 			= $post['uid'];
			
		
		if(isset($tempid) && $tempid!='')
		{
		$param['UpdatedOn'] 	= new Zend_Db_Expr('NOW()');
		$templateInsert = $this->update($param,'TemplateId = '.$tempid);
		}else{
			
		$param['CreatedOn'] 	= new Zend_Db_Expr('NOW()');
		$templateInsert = $this->insert($param);
		
		}
		
		return $templateInsert;			
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}        
	}
	
	
	
	
	public function getTemplateDetail($templateId) {		
		try {		
		
			$db = Zend_Db_Table::getDefaultAdapter();
		    $select = $db->select()
	        		->from('pp_mastertemplates', array('TemplateLayout'))	
	        		->where('TemplateId = ?', $templateId);
	        		
	        $result = $db->query($select)->fetch();	         
	        return $result['TemplateLayout'];
    
		 }catch(Exception $e) { 		 	
		 	Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);		
		}          
	}
	
	public function deleteTemp($templateId) {		
	
		$data['Flag'] 	   = Pp_Status::DocDeleted;
		$data['UpdatedOn'] = new Zend_Db_Expr('NOW()');		
		$where = $this->getAdapter()->quoteInto('TemplateId = ?', $templateId );
				
		try {		
			//$rs = $this->delete($where );
			$this->update($data, $where );
				
		}catch(Exception $e) { 
			Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
		}		 
	}
    
}