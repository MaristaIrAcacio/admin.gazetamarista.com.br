<?php

/**
 * Elemento file do formulario
 *
 * @name gazetamarista_Form_File
 * @package gazetamarista
 * @subpackage Form
 */
class gazetamarista_Form_File extends Zend_Form_Element_File {
	/**
	 * Configura o elemento
	 * 
	 * @name init
	 */
	public function init() {
		parent::setAttrib("field-type", "file");
		parent::setAttrib("class", "file");
	}
}
