<?php
/**
 * Stores the ACL and assigns the roles to resources
 *
 */



class Pp_Controller_Helper_Acl extends Zend_Acl
{	
		public $acl;
        public function __construct()
        {
            // first create Zend_Acl instance
            $this->acl = new Zend_Acl();
        }
        
        public function setRoles()
        {	
        	$this->acl->addRole(new Zend_Acl_Role('guest'));
        	
        	$parents = array('guest');
        	
            $this->acl->addRole(new Zend_Acl_Role('author'), $parents);
            $this->acl->addRole(new Zend_Acl_Role('admin'), $parents);
        }
        
		public function setResources()
        {
            // Adding resources action-wise
            // that means, these actions of "every controller" are going to get validated 
            // for access for guest or editor or admin users (roles) etc.
            
            // $this->acl->add(new Zend_Acl_Resource('index'));
            // $this->acl->add(new Zend_Acl_Resource('view'));
            // $this->acl->add(new Zend_Acl_Resource('edit'));
            // $this->acl->add(new Zend_Acl_Resource('delete'));
            
            $this->acl->add(new Zend_Acl_Resource('author'));
            $this->acl->add(new Zend_Acl_Resource('admin'));
            $this->acl->add(new Zend_Acl_Resource('index'));


        }
        
        public function setPrivilages()
        {
        
            // Setting privilages for actions of all controllers            
            // $this->acl->allow('guest',null, array('view', 'index'));
            // $this->acl->allow('editor',array('view','edit'));
            // $this->acl->allow('admin');
            
            // Setting privilages for actions as per particular controller
            // $this->acl->allow('<role>','<controller>', <array of controller actions>);
            // You can also fetch it from DB.
            
            // $this->acl->deny('guest','news', 'index');
            $this->acl->allow('author','author');
            $this->acl->allow('admin','admin');
            $this->acl->allow('guest','index');

            

           // $this->acl->allow('login'); 

            // Note that the actions which are not mentioned above i.e. inside array of
            // controller-action - becomes access-denied automatically
            // as in above example, news controller also have one more action demo2,
            // but demo2 is not mentioned in above allow actions, so 
            // when guest tries to access the action - demo2, it would not show the 
            // content of demo2, rather It would show content of error/index.phtml
        }
        
        
 		public function setAcl()
        {
            // store acl object using Zend_Registry for future use. This is compulsory.
            Zend_Registry::set('acl',$this->acl);
        }
}
	
