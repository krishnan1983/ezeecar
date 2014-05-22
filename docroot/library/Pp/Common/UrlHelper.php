<?php
class Pp_Common_UrlHelper{
		
	public static function enCryptId($id){
	
		//return base64_encode($id . '_' . uniqid());
		
		return str_pad($id, 5 , "0", STR_PAD_LEFT);   
	}
	public static function deCryptId($id){
	
		//$ids = explode("_", base64_decode($id)); 
		return (int)$id;
	}
	
	public static function getPreviewURL($id){
		
		//echo "aaa".$_SERVER['HTTP_HOST'];
		
		//return  Zend_Registry::get('config')->siteUrl."doc/".self::enCryptId($id);
		return "http://".$_SERVER['HTTP_HOST']."/doc/".self::enCryptId($id);
		
	}
	
	public static function getRequestURL($id){
		
		
		//return  Zend_Registry::get('config')->siteUrl."request/detail/request/".self::enCryptId($id);	
		
		return  "http://".$_SERVER['HTTP_HOST']."/request/detail/request/".self::enCryptId($id);	
		
	}
	
	public static function getAdminRequestURL($id){
	
		//return  Zend_Registry::get('config')->siteUrl."admin/viewrequest/request/".$id;
		
		return  "http://".$_SERVER['HTTP_HOST']."/admin/viewrequest/request/".$id;

	}
	
	public static function getFileName($filename){
		return $filename;
	}	
	
}