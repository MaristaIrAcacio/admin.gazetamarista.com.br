<?php

/**
 * Elemento textarea do formulario
 *
 * @name gazetamarista_Form_Textarea
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_Textarea extends Zend_Form_Element_Textarea {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("rows", "10");
		parent::setAttrib("field-type", "textarea");
		parent::setAttrib("class", "string textarea");
	}
}
