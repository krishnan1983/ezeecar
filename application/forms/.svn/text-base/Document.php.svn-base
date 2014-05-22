<?php

/**
 *	Author FORM LOG IN
 *
 *	@author		Dipa
 *	@date		Jan 16 2014
 *	@version	1.0.0
 */
class Application_Form_Document extends Zend_Form {

	/**
	 *	Initiate
	 */
	public function init() {

		$this->setAttrib('id', 'form')->setAction('/author/create-document')->setMethod('post');
		$this->setAttrib('enctype', 'multipart/form-data');

		
		$this->addElement('hidden', 'documnet', array('decorators' => $this->hDec));
		
		$this->addElement('text', 'name',
							array(
									'required' 			=> true,
									'decorators' 		=> $this->eDec,
									'label' 			=> 'Document Name:',
									'class'				=> 'w3'
								)
						);

		$this->addElement('select', 'folder',
							array(
									'required' 			=> true,
									'decorators' 		=> $this->eDec,
									'label' 			=> 'Folder Name:',
									'style' 			=> 'width:260px;',
									'multiOptions' => array("" => " Folder Name ") + Application_Model_DbTable_Requests::getFolders(),						
								)
						);
						
						
		
		$this->addElement('File', 'uploadedfile',
						array(																	
							'required' 			=> true,
							'label' 			=> 'Browse Document:',							
							)
					);
					
		
		$this->getElement('uploadedfile')->addValidator('Extension', false, array('docx','doc','xlsx','csv','xls','pptx','pdf'));
		//$this->getElement('uploadedfile')->addValidator('Size', false, '102400');
		
		
		$this->getElement('uploadedfile')->setDecorators(
		    array(
		        'File',
		        'Errors',
		        array(array('data' => 'HtmlTag'), array('tag' => 'td')),
		        array('Label', array('tag' => 'td')),
		        array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
		    )
		);

		$this->addElement('textarea', 'metaData',
							array(
									'required' 			=> true,
									'decorators' 		=> $this->eDec,
									'label' 			=> 'Meta Keywords:',
									'cols'				=> '50',
									'rows'				=>'4',
									'description'		=>'Enter Meta keywords separated by comma (exp. process guide, playbook). Max 15 keywords'					
								)
								
						);
												
		$this->addElement('textarea', 'message',
						array(
								'required' 			=> true,
								'decorators' 		=> $this->eDec,
								'label' 			=> 'Message For TA:',
								'cols'				=> '50',
								'rows'				=>'4'				
							)
							
					);
						
						
		$this->addElement('submit', 'submit',
						array(
								'label' 	 => 'Send to Technical Agency for Upload',
								'decorators' => array('ViewHelper'),
								'class' => 'btn',
							)
					);
	
		$this->addElement('button', 'cancel',
			array(
					'label' 				=> 'Cancel',
					'decorators' 			=> array('ViewHelper'),
					'onClick'				=> "return false;",
					'class' => 'sm-btn',
				)
		);

	}
	// END
	

	/* ------------------------------ *
	 * Default Decorators
	 * ------------------------------ */
	/*public function loadDefaultDecorators() {
		$this->setDecorators(array('FormElements',  array('HtmlTag', array('tag' => 'table', 'class'=>'table-style')), 'Form'));
	}*/
	
	public function loadDefaultDecorators($array = array('FormElements', 'Form')) {
		$this->setDecorators($array);
	}
	
	/*public function loadDefaultDecorators() {
		$this->setDecorators(array('FormElements',  'Form'));
	}*/
	
	public function useDisplayGroups() {
		$this->addDisplayGroup(array('submit', 'cancel', 'product_photo'), 'savegrp');
		$this->savegrp
			->setDecorators($this->gProd);		
	}
	
	protected $gProd 	 = array('FormElements',
	   array(array('data'=>'HtmlTag'), array('tag'=>'td')),
	   array(array('emptyrow'=>'HtmlTag'), array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'tag'=>'td')),
	  );
	
	protected $hDec 	= array('ViewHelper');
	
	public $eDec 	= array('ViewHelper', 
					array('Errors', array('escape' => false, 'tag' => 'div', 'class' => 'error-block')), 
					array('Description', array('tag' => '<p>',  array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'tag'=>'td'), 'escape' => false)), 					
					array(array('data' => 'HtmlTag'), array('tag' => 'td') ), 
					array('Label', array('tag' => 'td')),   		
					array(array('row' => 'HtmlTag'), array('tag' => 'tr') ) );
	
					
					//public $sDec 	= array('ViewHelper', array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'submit-block')) );
	
	//public $lDec 	= array('ViewHelper', array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'login-block')) );
	
	//public $gDec 	= array('FormElements', array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'outline')), array('Description', array('placement' => 'APPEND', 'tag' => 'div', 'class' => 'link-forgotpass', 'escape' => false)), array('Fieldset', array('class' => 'outline')));
	
	//public $gsDec 	= array('FormElements', array('Fieldset', array('class' => 'sform')) );

}
