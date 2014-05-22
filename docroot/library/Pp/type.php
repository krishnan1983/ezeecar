<?php
/**
 * This is how you use it:
 * $requestStatus = Author_Type::d;
 * 
 */
final class Pp_Type{
	
	//Request Type
	const Playbook       = 'p';
    const ProcessGuide   = 'pg';
    const Document    	 = 'd';
        
    public static function getDescriptionById($id)
    {
      switch ($id) {
        case self::Playbook:
          return 'Playbook';
        case self::ProcessGuide:
          return 'ProcessGuide';
        case self::Document:
          return 'Document';
      }
    }
	
	public static function getIdByDescription($id)
    {
      switch ($id) {
        case 'Playbook':
          return self::Playbook;
        case 'ProcessGuide':
          return self::ProcessGuide;
        case 'Document':
          return self::Document;
      }
    }
	
	public static function typeArray(){
    	   	    	
    	return array( 0 => 'All Types', 'Playbook' => 'Playbook', 'ProcessGuide' =>'ProcessGuide', 'Document' =>'Document');    	
    }
    
	
}



