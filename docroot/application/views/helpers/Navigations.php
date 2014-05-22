<?php 

class Zend_View_Helper_Navigations extends Zend_View_Helper_Abstract
{
	public function navigations ()
	{
		$auth = Zend_Auth::getInstance();
		
		if ($auth->hasIdentity()) {
			return $user_role = $auth->getStorage()->read()->user_role;
				
		}
	}
}