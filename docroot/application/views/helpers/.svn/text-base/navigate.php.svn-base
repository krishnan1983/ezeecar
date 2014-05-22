<?php 

class Zend_View_Helper_Navigate extends Zend_View_Helper_Abstract
{
	public function navigate ()
	{
		$auth = Zend_Auth::getInstance();
		//echo $auth->getStorage()->read()->uid; die();
		if ($auth->hasIdentity()) {
			$username = $auth->getStorage()->read()->name;
			$logoutUrl = $this->view->url(array('controller'=>'index',
			'action'=>'logout'), null, true);
			return '<ul>
				<li><a href="/author/requests/" class="active" title="REQUESTS">REQUESTS</a></li>
				<li><a href="/author/documents/" title="TEMPLATES">DOCUMENTS</a></li>
			</ul>';
		}
	}
	
	
}