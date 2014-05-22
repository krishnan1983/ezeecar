<?php 
//require_once '/content/propedia/docs/ppeditor/library/Pp/status.php';
//require_once '/content/propedia/docs/ppeditor/library/Pp/type.php';
//require_once '/content/propedia/docs/ppeditor/library/Pp/Controller/Helper/Acl.php';
//require_once '/content/propedia/docs/ppeditor/library/Pp/Controller/Plugins/Acl.php';
//require_once '/content/propedia/docs/ppeditor/library/Pp/Common/UrlHelper.php';


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDocType(){
        
        $view = new Zend_View();
        $view->doctype('XHTML1_TRANSITIONAL');
        return $view;
    }
    
	protected function _initAutoload()
	{
		$autoloader = new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Author',
			'basePath'  => dirname(__FILE__),
		));
		return $autoloader;
	}
	
	
/**
    * Method to urlencode ALL params found in the GET and POST variables.
    * Does not apply to any of the POST variables for controllers inside the  
    * $exception_controller_get_list array.
    *
    * @return void
    */
	
   protected function _initUrlencodeAllParams()
   {
       $request = Zend_Controller_Front::getInstance()->getRequest();
       echo "<pre>";print_r($request);die();
       /*Zend_Controller_Front::getInstance()->getRouter()->route($request);
       $current_controller = $request->getControllerName();
       $exception_controller_get_list = array('controllerone');
        
       $getParams = $request->getParams();
       foreach($getParams as $key => $value) {
           $value = $this->view->escape($value);
           $request->setParam($key, $value);
       }

       if(!in_array($current_controller,$exception_controller_get_list)) {
           $postParams = $request->getPost();
           $safePostParams = array();
           foreach($postParams as $key => $value) {
               $value = $this->view->escape($value);
               $safePostParams[$key] = $value;
           }
           $request->setPost($safePostParams);
       }*/
   }
    	
	protected function _initLogging()
	{			
		$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/config.ini', APPLICATION_ENV);
		Pp_Logger::setup($config);

		// Set the config into the registry
		Zend_Registry::set('config', $config);
		
		//Pp_Logger::setup($config);
	}
	
	protected function _initPlugins() 
    {	
    
    	$helper= new Pp_Controller_Helper_Acl();
		$helper->setRoles();
		$helper->setResources();
		$helper->setPrivilages();
		$helper->setAcl();
		
		//Zend_Controller_Front::getInstance()->registerPlugin(new Author_Controller_Helper_Acl());
		
        $objFront = Zend_Controller_Front::getInstance();
        $objFront->registerPlugin(new Pp_Controller_Plugins_Acl());
        return $objFront;
        
        // comment above 3 lines to remove ACL functionality
    }
	
	protected function _initRouting()
	{
		$router = Zend_Controller_Front::getInstance()->getRouter();
        include APPLICATION_PATH . "/configs/routes.php";
		
	}
}