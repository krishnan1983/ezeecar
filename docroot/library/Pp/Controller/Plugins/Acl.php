<?php


class Pp_Controller_Plugins_Acl extends Zend_Controller_Plugin_Abstract
{	
	private $_auth;
	private $_acl;
	
	function __construct()
	{
		$this->_auth = Zend_Auth::getInstance();
		$this->_acl = Zend_Registry::get('acl');
	}

	/**
	 * Checks to see if this "member" has access to this resource
	 * The rules are like this.
	 * If the user has an identity (i.e. is logged in) then check if they have access to the resource
	 * If not logged in - then check to see if they have access as a guest role
	 * If guest does not have access then send user to login page.
	 * If user is logged in but is trying to access a denied resource - then send to error/index page
	 *
	 * @return void
	 *
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		  
		//Default to the guest role
		$roleName = 'guest';
		
		// If user has already logged in - get the saved role description
		if($this->_auth->hasIdentity())
		{			
			$roleName = $this->_auth->getStorage()->read()->user_role;
			$roldName = 'Admin';
			if($request->getControllerName() == 'error')  return ;
						
		  	$privilageName=$request->getActionName(); 
	        $controllerName=$request->getControllerName();
	        						
			//echo $roleName.$controllerName.$privilageName ; die();
	        if(!$this->_acl->isAllowed($roleName,$controllerName,$privilageName))
	        {
	            $request->setControllerName('index');
	            $request->setActionName('login');       
	
	    	}
		}else {
          // $this->_redirect('index/login');
        }
		
	}

}