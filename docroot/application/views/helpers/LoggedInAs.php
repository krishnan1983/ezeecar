<?php 

class Zend_View_Helper_LoggedInAs extends Zend_View_Helper_Abstract
{
	public function loggedInAs ()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$username = $auth->getStorage()->read()->name;
			$logoutUrl = $this->view->url(array('controller'=>'index',
			'action'=>'logout'), null, true);
			return 'Welcome ' . $username . '. <a href="'.$logoutUrl.'">Logout</a>';
		}
	}
	
}
