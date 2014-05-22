<?php
/**
 * This is how you use it:
 * $requestStatus = Author_Type::d;
 * 
 */
final class Author_Type{
	
	//Request Type
	const Playbook              	= 'p';
    const ProcessGuide           	= 'd';
    const Document    				= 'pg';
        
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
    
}



