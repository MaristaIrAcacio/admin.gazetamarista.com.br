<?php

/**
 * Elemento numérico do formulario
 *
 * @name gazetamarista_Form_Integer
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_Integer extends Zend_Form_Element_Text {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
        parent::setAttrib("type", "number");
		parent::setAttrib("alt", "integer");
		parent::setAttrib("class", "integer");
		parent::setAttrib("field-type", "number");
	}
}
