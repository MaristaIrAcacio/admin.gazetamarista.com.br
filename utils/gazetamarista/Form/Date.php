<?php

/**
 * Elemento date do formulario
 *
 * @name gazetamarista_Form_Date
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_Date extends Zend_Form_Element_Text {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "date");
		parent::setAttrib("class", "datepicker");
		parent::setAttrib("data-datepicker", "");
	}
}
