<?php

/**
 *	Author FORM LOG IN
 *
 *	@author		Dipa
 *	@date		Jan 16 2014
 *	@version	1.0.0
 */
class Application_Form_Login extends Zend_Form {

	//private $_config;

	/**
	 *	Initiate
	 */
	public function init() {

		//$this->_config = Zend_Registry::get('config');

		$this->setAttrib('id', 'login_form')->setAction('/index/login')->setMethod('post');
															 

		$this->addElement('text', 'uname',
							array(
										'required' 			=> true,
										'decorators' 		=> $this->eDec,
										'label' 			=> 'Username',
										'class' 			=> 'w4',
										//'value'				=> 'Email',
										//'maxlength' 		=> 64,
										//'placeholder'		=> 'Email Address'
								)
						);

		$this->addElement('password', 'pass',
							array(
										'required' 			=> true,
										'decorators' 		=> $this->eDec,
										'label' 			=> 'Password',
										'class' 			=> 'w4',
										//'placeholder'		=> 'Password',
										//'maxlength' 		=> 32,
								)
						);
		

		/*$this->addElement('hidden', 'plaintext', array(
				'description' => $description,
				'required'=>false,
				'ignore'=>true,
				'decorators' => array(
					array(
						'Description', array(
								'escape' => false,
								'tag'  => 'div',
								'class' => 'login-forgot',
						)
					)
				)
			)
		);*/

		$this->addElement('submit', 'submit',
							array(
									//'ignore' 				=> true,
									'decorators' 			=> $this->gProd,
									'label' 				=> 'Log In',
									//'placeholder'		=> 'Log In',
									'class' 				=> 'signin',
									//'onsubmit'				=> "return true;"
								)
						);
		

	}
	// END
	

	/* ------------------------------ *
	 * Default Decorators
	 * ------------------------------ */
	public function loadDefaultDecorators() {
		$this->setDecorators(array('FormElements',  array('HtmlTag', array('tag' => 'table')), 'Form'));
	}
	// END
	
	protected $gProd 	 = array('ViewHelper',
	   array(array('data'=>'HtmlTag'), array('tag'=>'td')),
	   array(array('emptyrow'=>'HtmlTag'), array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'tag'=>'td')),
	  );

	
	/* ------------------------------ *
	 * GET PASSWORD
	 * ------------------------------ */
	public function getPassword() {
		$this->getElement('pass')->clearErrorMessages();
		$this->getElement('pass')->setErrorMessages(array('Passwords do not match what we have on record for you. <a href="'.$this->_config->thor->base.'user/member_profile/" rel="external" rev="'.$this->_popupstats.'">Please click here to reset your password.</a>'));
	}
	// END
	
	public $eDec 	= array('ViewHelper', 
						array('Errors', array('escape' => false, 'tag' => 'div', 'class' => 'error-block')), 
						 array('HtmlTag', array('tag' => 'td')),
   						 array('Label', array('tag' => 'td')),
						array(array('row' => 'HtmlTag'), array('tag' => 'tr') ) );
		
		
	//blic $hDec 	= array('ViewHelper');
	//public $eDec 	= array('ViewHelper', array('Errors', array('escape' => false, 'tag' => 'div', 'class' => 'error-block')), array(array('data' => 'HtmlTag'), array('tag' => 'dd', 'class' => 'element') ), array('Description', array('tag' => 'dd', 'class' => 'element-description', 'escape' => false)), array(array('row' => 'HtmlTag'), array('tag' => 'dl', 'class' => 'form') ) );
	//public $sDec 	= array('ViewHelper', array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'submit-block')) );
	
	//public $lDec 	= array('ViewHelper', array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'login-block')) );
	
	//public $gDec 	= array('FormElements', array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'outline')), array('Description', array('placement' => 'APPEND', 'tag' => 'div', 'class' => 'link-forgotpass', 'escape' => false)), array('Fieldset', array('class' => 'outline')));
	
	//public $gsDec 	= array('FormElements', array('Fieldset', array('class' => 'sform')) );

}
// END CLASS

// VALIDATORS
require_once 'Zend/Validate/Abstract.php';

/*class Zend_Validate_NotEmpty extends Zend_Validate_Abstract
{
	const IS_EMPTY = 'isEmpty';
	protected $_messageTemplates = array(self::IS_EMPTY => "Required");
	public function isValid($value){
		$this->_setValue((string) $value);
		if ( is_string($value) && (('' === $value) || preg_match('/^\s+$/s', $value)) ) {
			$this->_error(self::IS_EMPTY);
			return false;
		} elseif ( ! is_string($value) && empty($value) ) {
			$this->_error(self::IS_EMPTY);
			return false;
		}
		return true;
	}
}

class Zend_Validate_Reject extends Zend_Validate_Abstract
{
	const REJECT_MATCH = 'rejectMatch';
	protected $_messageTemplates = array(
		self::REJECT_MATCH => "'%value%' contains illegal characters."
	);
	protected $_messageVariables = array(
		'pattern' => '_pattern'
	);
	protected $_pattern;
	public function __construct($pattern) {
		$this->setPattern($pattern);
	}
	public function getPattern() {
		return $this->_pattern;
	}
	public function setPattern($pattern) {
		$this->_pattern = (string) $pattern;
		return $this;
	}
	public function isValid($value) {
		$this->_setValue($value);
		$status = @preg_match($this->_pattern, $value);
		if (false === $status) {
			require_once 'Zend/Validate/Exception.php';
			throw new Zend_Validate_Exception("Internal error matching pattern '$this->_pattern' against value '$value'");
		}
		if ($status > 0) {
			$this->_error(self::REJECT_MATCH);
			return false;
		}
		return true;
	}
}*/
// END VALIDATORS


/* End of file Login.php */
/* Location: ./application/forms/Login.php */