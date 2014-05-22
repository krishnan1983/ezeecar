<?php
/**
 * This is how you use it:
 * $requestStatus = Author_Status::Temp;
 * 
 */
final class Author_Status{
	
	//Request Status
	const Temp              	= 0;
    const Open           		= 1;
    const Closed    			= 2;
    const TA       				= 3;
    const AssignedToAuthor      = 4;
    const AssignedToAdmin       = 5;
	
    //Dropdown Status
    const Me              		= 'me';
    const All              		= 'all';
        
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
          return 'Assigned to TA';
        case self::AssignedToAuthor:
          return 'Pending with Author';
        case self::AssignedToAdmin:
          return 'Pending with Admin';          
        case self::Me:
          return 'Pending with me';
        case self::All:
          return 'All My Requests';
        default:
        	 return 'Temp';
      }
    }
    
    public static function statusArray(){
    	   	    	
    	return array(4=>'Pending with Author', 5=>'Pending with Admin');    	
    }
    
}



