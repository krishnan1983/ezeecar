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
		
		try{
			
			// If user has already logged in - get the saved role description
			if($this->_auth->hasIdentity())
			{			
				$roleName = $this->_auth->getStorage()->read()->user_role;
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
					 
				
				$privilageName=$request->getActionName(); 
		        $controllerName=$request->getControllerName();
				
				if($controllerName == "index" & $privilageName == 'ldap'){
					//allow
				}else{			
					$request->setControllerName('index');
					$request->setActionName('login'); 
				}
				
				//$r = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
				//$r->gotoUrl('/index/index')->redirectAndExit();
	        }
	        
		}catch(Zend_Acl_Exception $e) {

            Pp_Logger::getInstance()->err(__METHOD__ . " - " . $e);
            
        }
		
	}

}