<?php
/**
* A form to manage content.
*
* @package LydiaCore
*/
class CFormContentComment extends CForm{
	/**
	* Members
	*/
	private $content;
	
	/**
	* Constructor
	*/
	public function __construct($object, $id){
		parent::__construct();
		$this->AddElement(new CFormElementHidden('id', array('required'=>true, 'value'=>"$id")))
			 ->AddElement(new CFormElementTextarea('data', array('required'=>true, 'label'=>'Comment:')))
			 ->AddElement(new CFormElementSubmit('comment', array('callback'=>array($object, 'doComment'))));
			
		$this->SetValidation('data', array('not_empty'));
	}
}