
<?php
/**
 * This is how you use it:
 * $requestStatus = Author_Status::Temp;
 * 
 */
final class Pp_Status{
	
	//Request Status
	const Temp              	= 0;
    const Open           		= 1;
    const Closed    			= 2;
    const TA       				= 3;
    const AssignedToAuthor      = 4;
    const AssignedToAdmin       = 5;
	
	//const Saved       			= 6;
	
    //Dropdown Status
    const Me              		= 'me';
    const All              		= 'all';
    const Non              		= 'non';
    
    // Page Type
    const Playbook				=	'p';
    const ProgessGuide			=	'pg';
    const Documents				=	'd';
        
	
	// Document Flag
	const Active              	= 0;
	const DocDeleted            = 1;
	const tempDeleted           = -1;
	
    public static function getDescriptionById($id)
    {
      switch ($id) {
        case self::Temp:
          return 'Temp';
        case self::Open:
          return 'Open';
        case self::Closed:
          return 'Closed';
        case self::TA:
          return 'Pending with TA';
        case self::AssignedToAuthor:
          return 'Pending with Author';
        case self::AssignedToAdmin:
          return 'Pending with Admin';          
        case self::Me:
          return 'Pending with me';
        case self::All:
          return 'All My Requests';
		case self::Saved:
          return 'Saved';
		case self::Deleted:
          return 'Deleted';
		case self::Playbook:
		  return 'Playbook';
		case self::ProcessGuide:
		  return 'ProcessGuide';
		case self::Documents:
		  return 'Document';
        default:
        	 return 'Temp';
      }
    }
    
    public static function statusArray(){
    	   	    	
    	return array( self::AssignedToAuthor =>'Pending with Author', self::AssignedToAdmin =>'Pending with Admin');    	
    }
    
}



