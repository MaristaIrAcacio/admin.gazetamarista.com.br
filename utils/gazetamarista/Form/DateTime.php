<?php

/**
 * Elemento date do formulario
 *
 * @name gazetamarista_Form_DateTime
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_DateTime extends Zend_Form_Element_Text {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "datetime");
		parent::setAttrib("class", "datetimepicker");
		parent::setAttrib("data-datetimepicker", "");
	}
}
