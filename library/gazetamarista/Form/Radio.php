<?php

/**
 * Elemento de checagem do formulario
 *
 * @name gazetamarista_Form_Radio
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_Radio extends Zend_Form_Element_Radio {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "radio");
	}
}
