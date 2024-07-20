<?php

/**
 * Elemento autocomplete do formulario
 *
 * @name gazetamarista_Form_Autocomplete
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_Autocomplete extends ZendX_JQuery_Form_Element_AutoComplete {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "integer");
		parent::setAttrib("class", "autocomplete");
	}
}
