<?php

/**
 * Cria o helper do breadcrump
 *
 * @name gazetamarista_View_Helper_Breadcrumb
 */
class gazetamarista_View_Helper_Breadcrumb
{
    protected $_init = "";

    public function breadcrumb($label = null) {
        // Busca as configurações
        $config = Zend_Registry::get("config");

        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $this->_url = "http://localhost" . $config->gazetamarista->config->basepath;
        } elseif ($_SERVER['HTTP_HOST'] == "sites.gazetamarista.com.br") {
            $this->_url = "http://sites.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
        } else {
            $this->_url = "http://" . $config->gazetamarista->config->domain;
        }

        $this->_init = array($this->_url => 'Início');

        // Separa label
        $arrlabel = explode("-", $label);

        if($arrlabel[0] == "menuitem") {
            return $this->menuitem($label);
        }else{
            if(is_array($label)){
                return $this->render(array_merge($this->_init, $label));
            }else{
                return $this->render($this->_init);
            }
        }
    }

    private function render($data){
        $ret = '<ul class="breadcrumbs">' . PHP_EOL;
        $tot = count($data);
        $i = 1;

        foreach($data as $key => $value) {
            $value = ucfirst($value);
            $ret .= ($tot == $i) ? "<li class='current'><a href='#' title='{$value}'>{$value}</li></a>" : "<li><a href='{$key}' title='{$value}'>{$value}</a></li>";
            $i++;
        }

        return $ret . '</ul>' . PHP_EOL;
    }

    /**
     * Captura dados do menu_itens para exibir no breadcrumb
     * @param  [type] $campo (colunas da tabela)
     * @return [type] string
     */
    public function menuitem($campo) {
        // Captura dados da tabela menu_itens
        $model      = new Admin_Model_Menusitens();

        $controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();

        // Texto default
        $txt_campo  = "Admin";

        // Separa o campo (menuitem | campo)
        $arrcampo = explode("-", $campo);
        if(count($arrcampo) > 1) {
            $coluna = $arrcampo[1];
            if(!empty($coluna)) {
                // Select
                $select = $model->select()
                    ->from("menu_itens", array('*'))
                    ->joinInner("menu_categorias", "menu_itens.idcategoria = menu_categorias.idcategoria", array('categoria' => 'descricao'))
                    ->where("controlador = ?", $controller)
                    ->setIntegrityCheck(false);

                $item = $model->fetchRow($select);
                if($item) {
                    $dados      = $item->toarray();
                    $txt_campo  = $dados[$coluna];
                }
            }
        }

        return $txt_campo;
    }
}