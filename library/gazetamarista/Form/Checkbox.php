<?php

/**
 * Elemento de checagem do formulario
 *
 * @name gazetamarista_Form_Checkbox
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_Checkbox extends Zend_Form_Element_Checkbox {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "checkbox");
	}
}
