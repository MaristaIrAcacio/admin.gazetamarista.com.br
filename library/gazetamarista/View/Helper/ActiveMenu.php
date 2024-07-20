<?php

/**
 * Cria o helper do Active Menu
 *
 * @name gazetamarista_View_Helper_ActiveMenu
 */
class gazetamarista_View_Helper_ActiveMenu
{
    private $_request;

    /**
     * @return Zend_Controller_Request_Abstract
     */
    public function getRequest(){
        if(null === $this->_request)
            $this->_request = Zend_Controller_Front::getInstance()->getRequest();
        return $this->_request;
    }

    public function activeMenu($controller = null, $action = null, $alias = null, $module = 'default', $class = 'active'){
        $controllerName = $this->getRequest()->getControllerName();
        $moduleName = $this->getRequest()->getModuleName();
        $actionName = $this->getRequest()->getActionName();
        $aliasName  = $this->getRequest()->getParams('alias');
        if($module == $moduleName && $controller == $controllerName && $action == $actionName && $aliasName == $alias){
            echo "class='{$class}'";
        }
    }
}
