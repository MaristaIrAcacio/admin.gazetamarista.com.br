<?php

/**
 * Controlador da index do institucional
 *
 * @name IndexController
 */
class IndexController extends Zend_Controller_Action
{
    /**
     *
     */
    public function init()
    {
        header('location: https://admin.gazetamarista.blog/admin/usuarios/login');
	}

}
