<?php 

class Zend_View_Helper_UserDetail extends Zend_View_Helper_Abstract
{
	public function userDetail($uid)
	{
		$select = $this->select()
		           ->setIntegrityCheck(false)
		           ->from ('users',array('name'))
		           ->where ('uid = ?',$uid);
		return  $rs = $this->getDefaultAdapter()->query($select)->fetch();
		      
	}
	
	
}