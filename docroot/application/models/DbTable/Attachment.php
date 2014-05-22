<?php

class Application_Model_DbTable_Attachment extends Zend_Db_Table_Abstract {

    protected $_name = 'pp_document_attachment';
    protected $_primary = 'AId';
    
	public function create($post) {		
				
		return $this->insert($post);
	
	}
	
}