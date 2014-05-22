<?php

/**
 *	Author FORM LOG IN
 *
 *	@author		Dipa
 *	@date		Jan 16 2014
 *	@version	1.0.0
 */
class Application_Form_Message extends Zend_Form {

	//private $_config;

	/**
	 *	Initiate
	 */
	public function init() {
		
		$this->setAttrib('id', 'message_form')->setAction('/author/message')->setMethod('post');

		$this->addElement('hidden', 'request', '');
		
		$this->addElement('textarea', 'message',
							array(
										'required' 			=> true,
										'decorators' 		=> $this->eDec,
										'label' 			=> 'Message: ',
										'cols'				=> '50',
										'rows'				=>'4'				
								)
								
						);
						
		$this->addElement('select', 'status',
							array(
										'required' 			=> true,
										'decorators' 		=> $this->eDec,
										'label' 			=> 'Status: ',
										'multiOptions' => Pp_Status::statusArray() 
								)
						);
										
		$this->addElement('submit', 'submit',
							array(
									'label' 	 => 'Send Message',
									'decorators' => array('ViewHelper'),
									'class' => 'sm-btn',
								)
						);
		$this->addElement('button', 'cancel',
			array(
					'label' 				=> 'Cancel',
					'decorators' 			=> array('ViewHelper'),
					'onClick'				=> "return false;",
					'class' => 'sm-btn'
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
	
	/*public function loadDefaultDecorators($array = array('FormElements', 'Form')) {
		$this->setDecorators($array);
	}*/
	// END
	
	public function useDisplayGroups() {
		$this->addDisplayGroup(array('submit', 'cancel'), 'savegrp');
		$this->savegrp
			->setDecorators($this->gProd);		
	}
	
	protected $gProd 	 = array('FormElements',
	   array(array('data'=>'HtmlTag'), array('tag'=>'td')),
	   array(array('emptyrow'=>'HtmlTag'), array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'tag'=>'td')),
	  );
	  
	public $eDec 	= array('ViewHelper', 
						array('Errors', array('escape' => false, 'tag' => 'div', 'class' => 'error-block')), 
						 array('HtmlTag', array('tag' => 'td')),
   						 array('Label', array('tag' => 'td')),
						array(array('row' => 'HtmlTag'), array('tag' => 'tr') ) );
						
		
}
// END CLASS
