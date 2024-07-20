<?php
/**
 * Controlador para extensão das funcionalidades do Zend
 *
 * @name gazetamarista_Controller_Action
 * @see Zend_Controller_Action
 */
class gazetamarista_Controller_Action extends Zend_Controller_Action {
    /**
     * Armazena os icones dinamicos da listagem
     *
     * @access protected
     * @name $__listExtraIcons
     * @var array
     */
    protected $__listExtraIcons = array();

    /**
     * Armazena os parametros obrigatórios para o funcionamento da tela
     *
     * @access protected
     * @name $_requiredParam
     * @var array
     */
    protected $_requiredParam = array();

    /**
     * Armazena a variavel de mensagens
     *
     * @access public
     * @name $_messages
     * @var Zend_Session_Namespace
     */
    public $_messages = NULL;

    /**
     * Armazena a variavel do login
     *
     * @access protected
     * @name $_usuariologin
     * @var Zend_Session_Namespace
     */
    protected $_usuariologin = NULL;

    /**
     * Método que inicializa o controlador
     *
     * @name init
     */
    public function init() {
        // Busca o campo da chave primaria
        $primary = $this->_model->getPrimaryField();
        $primary = $primary[1];
        $this->view->primary = $primary;

        // Busca se bloqueia manipulação dos dados e exibe somente a tela view
        $this->view->somenteview = $this->_model->getSomenteView();

        // Busca se bloqueia gerar xls na tela list
        $this->view->gerarxls = $this->_model->getGerarXlsView();

        // Busca se bloqueia gerar pdf na tela view
        $this->view->gerarpdf = $this->_model->getGerarPdfView();

        // Busca se esconde o botão 'Remover' na tela list
        $this->view->esconderBtnRemover = $this->_model->getEsconderBtnRemoverList();

        // Busca se esconde o botão 'Novo' na tela list
        $this->view->esconderBtnNovo = $this->_model->getEsconderBtnNovoList();

        // Busca se esconde o botão 'Visualizar' na tela list
        $this->view->esconderBtnVisualizar = $this->_model->getEsconderBtnVisualizarList();

        // Busca se esconde o botão 'Filtrar' na tela list
        $this->view->esconderBtnFiltrar = $this->_model->getEsconderBtnFiltrarList();

        // Inicializa a sessão das mensagens
        $this->_messages = new Zend_Session_Namespace("messages");

        // Inicializa a sessão do login
        $this->_usuariologin = new Zend_Session_Namespace("loginadmin");

        // Parametros para permissão
        $this->param_usuario		= $this->_usuariologin->logged_usuario['idusuario'];
        $this->idperfil 			= $this->_usuariologin->logged_usuario['idperfil'];
        $this->param_modulo 		= $this->_request->getParam("module", "");
        $this->param_controlador	= $this->_request->getParam("controller", "");
        $this->param_acao			= $this->_request->getParam("action", "");

        // Assina o model principal
        $this->view->_model = $this->_model;

        // Verifica se está logado no admin
        if($this->param_modulo == "admin" && !empty($this->idperfil)) {
            // Verifica se possui permissão de acesso de perfil
            $model_menuitens = new Admin_Model_Menusitens();
            $select_perfil_acesso = $model_menuitens->select()
                ->where('controlador = ?', $this->param_controlador);

            $perfil_acesso = $this->_model->fetchRow($select_perfil_acesso);
            if($perfil_acesso) {
                if(($this->idperfil < $perfil_acesso->idperfil) && ($this->param_acao != "reset" && $this->param_acao != "logout" && $this->param_acao != "trocarsenha")) {
                    // Se for ajax
                    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        $this->_helper->json(array('result' => FALSE, 'message' => "Você não possui acesso liberado!"));
                        die();
                    }else{
                        // Redirect
                        $this->_messages->error = "Você não possui acesso liberado!";
                        $this->_redirect("admin");
                    }
                }
            }
        }

        // Chama o parente
        parent::init();
    }

    /**
     * Ação de consulta padrão
     *
     * @access protected
     * @name listAction
     */
    protected function listAction() {
        // Busca a pagina exibida
        $current_page = intval($this->_request->getParam("page", 1));

        // Cria o formulario para busca
        $form = $this->_model->getForm("search");

        // Popula o formulário
        $form->isValid($this->_request->getParams());

        // Busca as informações da tabela
        $columns = $this->_model->describeTable();

        // Cria a query inicial
        $select = $this->_model->select();

        // Cria um hook para a listagem
        $return = $this->doBeforeList($select);

        // Pega elemento por elemento
        foreach($form->getElements() as $element) {
            // Busca o nome do elemento
            $form_name = $element->getName();

            // Verifica se é o botão submit
            if($form_name == "submit" || $form_name == "cancel") {
                continue;
            }

            // Busca o valor à ser buscado
            $value = $this->_request->getParam($form_name);
            $field_type = $element->getAttrib("alt");
            $name_name = $element->getName();
            $propriedadedb = $columns[ $name_name ];

            // Verifica se é decimal
            switch($field_type) {
                case "decimal":
                    $field_value = number_format($value, $propriedadedb['SCALE'], ",", ".");
                    break;

                case "date":
                    $field_value = implode("/", array_reverse(explode("-", $value)));
                    // Verifica se a data existe
                    if($field_value == "00/00/0000") {
                        $field_value = "";
                    }
                    break;

                case "datetime":
                    $dataar = explode(" ", $value);
                    $hrar 	= explode(":", $dataar[1]);

                    // Data e hora
                    //$field_value = implode("/", explode("-", $dataar[0])).' '.$hrar[0].':'.$hrar[1];

                    // Somente Data
                    $field_value = implode("/", explode("-", $dataar[0]));

                    // Verifica se a data existe
                    if($value == "00/00/0000 00:00:00" || $value == "00/00/0000 00:00" || $value == "00/00/0000") {
                        $field_value = "";
                    }
                    break;

                default:
                    $field_value = $value;
            }

            // Seta o valor no campo
            $form->getElement($name_name)->setValue($field_value);

            // Verifica se o valor está sendo passado
            if(strlen($value) > 0) {

                // Verifica o tipo
                switch($columns[$form_name]['DATA_TYPE']) {
                    // Verifica se é uma string
                    case "varying":
                    case "varchar":
                    case "text" :
                    case "longblob" :
                        // Modifica para suportar o ILIKE
                        $signal = "LIKE";
                        $value = "%" . $value . "%";
                        break;
                    case "date":
                    case "datetime":
                        $signal = ">=";
                        $value = implode("-", array_reverse(explode("-", $value)));
                        break;
                    // Outros tipos não são full-text
                    default:
                        $signal = "=";
                        break;
                }

                // Selecionar o aliás do FROM
                $array_return = (array)$return;
                $prefix = chr(0).'*'.chr(0);

                // Seleciona a primeira chave, para evitar erro de ambiguidade
                foreach($array_return[$prefix."_parts"]["from"] as $key_from => $ret) {
                    $key_from = $key_from . ".";
                    break;
                }

                $db = Zend_Registry::get("db");

                // Monta o where
                //$select->where($key_from . $form_name . ' ' . $signal . ' _utf8 "' . $value . '" COLLATE utf8_general_ci');
                $select->where($key_from . $form_name . " " . $signal . " _utf8 " . $db->quote($value) . " COLLATE utf8_general_ci");
            }
        }

        // Cria um hook para a listagem
        //$return = $this->doBeforeList($select);

        // Verifica se o retorno do hook é um select personalizado
        // if($return != NULL) {
        // 	$select = $return;
        // }

        // Monta a ordem
        $primary_field = $this->_model->getPrimaryField();
        $parans = array();
        foreach($primary_field as $field) {
            $select->order($field);
        }

        // Busca a configuração da paginação
        $config = Zend_Registry::get("config");

        // Cria a paginação
        try {
            $paginator = Zend_Paginator::factory($select);
            $paginator->setPageRange($config->gazetamarista->paginator->range);
            $paginator->setCurrentPageNumber($current_page);
        } catch(Exception $e) {
            //var_dump($e);
            //die("<br />Fatal PHP error in " . __FILE__ . " on line " . __LINE__);
        }

        // Verifica o parametro nopage
        if($this->_request->getParam("nopage", 0) == 1) {
            $paginator->setItemCountPerPage(-1);
        }
        else {
            $paginator->setItemCountPerPage($config->gazetamarista->paginator->perpage);
        }

        // Chama o hook manipulador
        $form_temp = $this->doAfterCreateForm();

        // Percorre os elementos novos
        foreach($form_temp->getElements() as $element) {
            // Busca o nome do elemento
            $name_name = $element->getName();

            // Verifica se possui os dados na sessão
            $param = $this->_request->getParam($name_name);
            if($param > 0) {
                // Busca a descricao
                $label = $this->_request->getParam($name_name . "_label");

                // Seta os valores no campo
                $element->setAttrib("ac_label", $label);
                $element->setValue($param);
            }

            // Adiciona o elemento ao formulário
            $form->addElement($element);
        }

        // Percorre os parametros obrigatorios
        foreach($this->_requiredParam as $param => $value) {
            $form->setAction($form->getAction() . "/" . $param . "/" . $value);
        }

        // Busca o total de paginas paginas
        $total_paginas = (int)($paginator->getTotalItemCount() / $paginator->getItemCountPerPage());
        $total_paginas++;


        // Monta os parâmetros de filtros
        if($this->_request->getParams()) {
            foreach($this->_request->getParams() as $keyfiltro => $filtrosform) {
                if($keyfiltro != $primary_field[1] && $keyfiltro != "module" && $keyfiltro != "controller" && $keyfiltro != "action" && $keyfiltro != "page") {
                    $this->_requiredParam += array(
                        $keyfiltro => $filtrosform
                    );
                }
            }

            // Percorre os parametros
            $url = $form->getElement("cancel")->getAttrib("data-url");
            foreach($this->_requiredParam as $param => $value) {
                $url .= "/" . $param . "/" . $value;
            }
        }

        // Assina as variaveis à view
        $this->view->requireParam 			= $this->_requiredParam;
        $this->view->form 					= $form;
        $this->view->filtrosParam 			= $url;
        $this->view->paginator 				= $paginator;
        $this->view->listExtraIcons 		= $this->__listExtraIcons;
        $this->view->next_page 				= ($current_page < $total_paginas) ? $current_page + 1 : $total_paginas;
        $this->view->previous_page 			= ($current_page > 1) ? $current_page - 1 : 1;

        // Assina o modulo e o controlador que foi chamado
        $this->view->module 				= $this->_request->getParam("module");
        $this->view->controller 			= $this->_request->getParam("controller");
        $this->view->primaryKeys 			= $primary_field;
        $this->view->searchFormVisibility 	= $this->_model->getSearchFormVisibility();
    }

    /**
     * Ação de busca padrão
     *
     * @access protected
     * @name searchAction
     */
    protected function searchAction() {
        // Busca o formulário
        $form = $this->_model->getForm("search");

        // Chama o hook manipulador
        $form_temp = $this->doAfterCreateForm();

        // Percorre os elementos novos
        foreach($form_temp->getElements() as $element) {
            $form->addElement($element);
        }

        // Percorre as variaveis post
        $params = array();
        foreach($form->getElements() as $element) {
            // Verifica se é o botão submit
            if($element->getName() == "submit" || $element->getName() == "cancel") {
                continue;
            }

            // Busca o valor à ser buscado
            $value = $this->_request->getParam($element->getName());

            // Verifica se o valor está sendo passado
            if(strlen($value) > 0) {
                // Busca o tipo do campo
                $field_type = $element->getAttrib("field-type");
                $name_name = $element->getName();

                // Verifica se é decimal
                switch($field_type) {
                    case "decimal":
                        $value = str_replace(",", ".", str_replace(".", "", $value));
                        if($value <= 0) {
                            $value = "";
                        }
                        break;

//                    case "checkbox":
//                        if($value <= 0) {
//                            $value = "";
//                        }
//                        break;

                    case "date":
                        $value = implode("-", array_reverse(explode("/", $value)));
                        // Verifica se a data existe
                        if($value == "00/00/0000" || $value == "0000-00-00") {
                            $value = "";
                        }
                        break;

                    case "datetime":
                        $dataar = explode(" ", $value);
                        $hrar 	= $dataar[1];

                        // Data e hora
                        //$value = implode("-", array_reverse(explode("/", $dataar[0]))).' '.$hrar;

                        // Somente Data
                        $value = implode("-", array_reverse(explode("/", $dataar[0])));

                        // Verifica se a data existe
                        if($value == "00/00/0000 00:00:00" || $value == "00/00/0000 00:00" || $value == "00/00/0000") {
                            $value = "";
                        }
                        break;
                }

                if(strlen($value) > 0 && $value != "*Geral*") {
                    $params[$element->getName()] = $value;
                }
            }

            // Verifica se existe campo label de autocomplete
            $label = $this->_request->getParam($element->getName()."_label", NULL);
            if($label !== NULL) {

                // Verifica se o valor está sendo passado
                if(strlen($value) > 0) {
                    $params[$element->getName()."_label"] = $label;
                }
            }
        }

        // Verifica o parametro nopage
        if($this->_request->getParam("nopage") == "on") {
            $params["nopage"] = TRUE;
        }

        // Redireciona para a listagem
        $this->_helper->redirector("list", NULL, NULL, array_merge($params, $this->_requiredParam));
    }

    /**
     * Ação de criação e tratamento do formulario
     *
     * @access protected
     * @name formAction
     */
    protected function formAction() {
        // Inicia o vetor que armazenará as futuras inserções
        $toAddAtMultiple = array();

        // Busca o campo da chave primaria
        $primary_field = $this->_model->getPrimaryField();

        // Cria os parametros
        $where = array();
        $paramsr = array();
        foreach($primary_field as $field) {
            // Busca o parametro
            $value = $this->_request->getParam($field, 0);
            $id = $value;

            // Verifica o parametro
            if($value > 0) {
                $where[$field . " = ?"] = $value;
                $paramsr[$field] = $value;
            }
        }

        // Verifica se existe id passando por parametro
        if(count($where) > 0) {
            // Cria o formulario para atualizar
            $form = $this->_model->getForm("update");

            // Busca o registro para popular o formulario para edição
            $data = $this->_model->fetchRow($where);
        }
        else {
            // Cria o formulario para inserir
            $form = $this->_model->getForm("insert");
        }

        // Hook para a criação do formulário
        $form = $this->doOnCreateForm($form);

        // Verifica se esta vindo por post
        if($this->_request->isPost()) {

            // Percorre os campos de multipla seleção
            foreach($this->_model->getMultipleFields() as $multiple_name) {
                // Busca o elemento do formulario
                $element = $form->getElement($multiple_name);

                // Remove a obrigatoriedade
                $element->setRequired(FALSE);

                // Verifica se é um campo de seleção multipla
                if($element->getAttrib("data-ac_middle") != "") {

                    // Remove o campo do formulario
                    $tmp = array(
                        'reference_table' => $element->getAttrib("data-ac"),
                        'relation_table' => $element->getAttrib("data-ac_middle"),
                        'data' => $_POST[$multiple_name],
                        'label' => $_POST[$multiple_name."l"]
                    );

                    unset($_POST[$multiple_name."l"]);

                    // Monta o json dos dados
                    $toJson = array();
                    foreach($tmp['data'] as $index => $value) {
                        $toJson[] = array('value' => $value, 'label' => $tmp['label'][$index]);
                    }
                    $toJson = array_reverse($toJson);

                    // Ajusta os atributos
                    $element->setAttrib('data-json_values', json_encode($toJson));
                    $toAddAtMultiple[] = $tmp;
                }
            }

            // Percorre os valores
            foreach($_POST as $key => $value) {
                // Tratar valor
                $value = trim($value);

                // Busca o elemento do formulario
                $element = $form->getElement($key);

                // Verifica se o campo existe
                if($element != NULL) {

                    // Busca o tipo do campo
                    $field_type = $element->getAttrib("field-type");

                    // Verifica se é decimal
                    switch($field_type) {
                        case "decimal":
                            $_POST[$key] = str_replace(",", ".", str_replace(".", "", $value));
                            break;

                        case "integer":
                            if(!is_numeric($_POST[$key])) {
                                $_POST[$key] = NULL;
                            }
                            break;

                        case "password":
                            //$_POST[$key] = md5($_POST[$key]);
                            break;

                        case "":

                            break;

                        case "date":
                            $_POST[$key] = implode("-", array_reverse(explode("/", $value)));
                            break;

                        case "datetime":
                            $dataar = explode(' ',$value);
                            $hrar = explode(':',$dataar[1]);
                            $_POST[$key] = implode("-", array_reverse(explode("/", $dataar[0]))).' '.$hrar[0].':'.$hrar[1];
                            break;
                        default:
                            $_POST[$key] = $value;
                            break;
                    }
                }
            }

            // Verifica se o formulário é válido
            if($form->isValid($_POST)) {
                // Verifica o upload para bloquear
                $columns = $this->_model->getCampo();
                foreach ($columns as $name => $description) {
                    // Busca os modificadores
                    $modifier = $this->_model->getModifier($name);
                    if($modifier['type'] == "file") {
                        // Chama a função para validar o upload
                        $upload_block = new gazetamarista_Tipoupload();
                        $resposta_block = $upload_block->bloqueio($_FILES[$name], $modifier['extension']);

                        if($resposta_block['status'] == 'erro') {
                            $this->_messages->error = !empty($resposta_block['msg']) ? $resposta_block['msg'] : "Tipo de arquivo não permitido, tente novamente";
                            $this->_redirect($_SERVER['HTTP_REFERER']);
                            exit;
                        }
                    }
                }

                // Busca os dados dos elementos
                $data = $form->getValues();

                // Busca as colunas do formulario
                $columns = $this->_model->getCampo();
                foreach($columns as $name => $description) {
                    // Verifica se existe o campo
                    if($form->getElement($name) == NULL) {
                        continue;
                    }

                    // Busca o auto-complete
                    if($form->getElement($name)->getAttrib("data-ac_middle") != "") {
                        unset($data[$name]);
                    }

                    // Busca os modificadores
                    $modifier = $this->_model->getModifier($name);
                    if($modifier['type'] == "file") {
                        // Verifica se existe arquivo
                        if($_FILES[$name]['size'] > 0) {
                            // Confirma o upload do arquivo
                            $form->$name->receive();

                            // Adiciona o nome ao data
                            $data[$name] = basename($form->$name->getFileName());

                            // ********* Tratamento de imagem e envio para pasta (padrão novo)
							$arquivo_extensao = end(explode(".", $data[$name]));
							if(in_array($arquivo_extensao, ['png', 'jpeg', 'jpg', 'bmp', 'gif'])) {
								$file_max_width = $modifier['max_width'] ? $modifier['max_width'] : 1600;
								$file_max_height = $modifier['max_height'] ? $modifier['max_height'] : 1600;
								(new gazetamarista_Image_Image())->make($modifier['destination'] . "/" . $data[$name])->resize($file_max_width, $file_max_height, function ($constraint) {
									$constraint->aspectRatio();
									$constraint->upsize();
								})->save($modifier['destination'] . "/" . $data[$name], 80);
							}
                            // ********* FIM Tratamento *******************************************
                        }
                        else {
                            unset($data[$name]);
                        }
                    }
                }

                // Verifica se o registro está sendo inserido ou editado
                if(count($where) <= 0) {
                    // Hook antes da inserção
                    $data = $this->doBeforeInsert($data);

                    // //
                    // foreach($data as $key => $value) {
                    // 	unset($data[$key]);
                    // 	$data[strtoupper($key)] = $value;
                    // }

                    // Salva os dados
                    $this->_model->insert($data);

                    // Busca o id gerado
                    $sequence_name = $this->_model->getSchemaName() . "." . $this->_model->getTableName() . "_" . implode("_", $this->_model->getPrimaryField());
                    $id = $this->_model->getAdapter()->lastInsertId($sequence_name);

                    // Cria o log
                    $data_log = array(current($primary_field) => (int)$id);
                    $data_log = array_merge($data_log, $data);
                    $this->doDatabaseLog("INSERT", NULL, $data_log);

                    // Hook depois da inserção
                    $this->doAfterInsert($id);

                    // Mensagem de ok
                    $this->_messages->success = "Cadastro realizado com sucesso.";
                }
                else {
                    // Hook antes da atualização
                    $data = $this->doBeforeUpdate($data);

                    // Cria o log
                    $data_log = array(current($primary_field) => (int)$this->_request->getParam(current($primary_field), 0));
                    $data_log = array_merge($data_log, $data);

                    // Captura os dados antes de atualizar
                    $atual = $this->_model->fetchRow($this->_model->select()->where(current($primary_field) . " = ?", (int)$this->_request->getParam(current($primary_field), 0)));
                    if($atual) {
                        $data_antes = $atual->toarray();
                    }

                    // Insere o registro do log
                    $this->doDatabaseLog("UPDATE", $data_antes, $data_log);

                    // Salva os dados
                    $this->_model->update($data, $where);

                    // Armazena o id
                    $id = (int)$this->_request->getParam(current($primary_field), 0);

                    // Hook depois da atualização
                    $this->doAfterUpdate();

                    // Mensagem de ok
                    $this->_messages->success = "Alteração realizado com sucesso.";
                }

                // Percorre os valores de multiplos selects
                foreach($toAddAtMultiple as $toAdd) {
                    // Cria o model do relacionamento
                    $relation_model = new $toAdd['relation_table']();
                    $reference_model = new $toAdd['reference_table']();

                    // Busca o id da tabela
                    if(is_array($this->_model->getPrimaryField())) {
                        $idreference1 = array_pop($this->_model->getPrimaryField());
                    }
                    else {
                        $idreference1 = $this->_model->getPrimaryField();
                    }

                    // Busca o id da tabela de referencia
                    if(is_array($this->_model->getPrimaryField())) {
                        $idreference2 = array_pop($reference_model->getPrimaryField());
                    }
                    else {
                        $idreference2 = $reference_model->getPrimaryField();
                    }

                    // Remove os itens ja cadastrados
                    if(count($where) > 0) {
                        $relation_model->delete($where);
                    }

                    // Percorre os valores do formulario
                    foreach($toAdd['data'] as $value) {
                        // Monta o vetor de dados
                        $data = array();
                        $data[$idreference1] = $id;
                        $data[$idreference2] = $value;

                        // Insere o valor
                        $relation_model->insert($data);
                    }
                }

                // Seta o config
                $config = Zend_Registry::get('config');

                // Verifica se existe parametro da pagina
                if($this->_request->getParam("page", 0) > 0) {
                    $this->_requiredParam['page'] = $this->_request->getParam("page", 0);
                }

                // Verifica se possui referer
                $referer_url = $this->_request->getParam("referer_url", "");
                $continuared = false;
                if( $this->_request->getParam("submitcontinuar","") != "" ){
                    $continuared = $this->_request->getParam("submitcontinuar");
                }

                if($referer_url != "") {
                    if($continuared) {
                        // Redireciona o usuário ao form
                        //$this->_helper->redirector("form", NULL, NULL, $paramsr);

                        // Monta o retorno
                        $referer_link = str_replace("/list/", "/form/", $referer_url);
                        $url = end(explode("/admin/", $referer_link));
                        $this->_redirect("/admin/" . $url);
                    }else{

                        $basepath = $config->gazetamarista->config->basepath;
                        $url = str_replace($basepath, "", $referer_url);

                        foreach($primary_field as $primary) {
                            $url = substr($url, 0, strpos($url, "/" . $primary));
                        }

                        // Redireciona o usuário à url
                        $this->_redirect($url);
                    }
                }
                else {
                    // Url completa atual
                    $referer_link = $_SERVER['REQUEST_URI'];

                    if($continuared) {
                        // Redireciona o usuário ao form
                        //$this->_helper->redirector("form", NULL, NULL, $paramsr);

                        // Monta o retorno
                        $url = end(explode("/admin/", $referer_link));
                        $this->_redirect("/admin/" . $url);
                    }else{
                        // Redireciona o usuário ao list
                        //$this->_helper->redirector("list", NULL, NULL, $this->_requiredParam);

                        // Monta o retorno
                        $referer_link = str_replace("/form", "/list", $referer_link);
                        $url = end(explode("/admin/", $referer_link));
                        foreach($primary_field as $primary) {
                            $url = str_replace("/".$primary."/".$this->_request->getParam($primary, 0), "", $url);
                        }
                        $this->_redirect("/admin/" . $url);
                    }
                }
            }
        } else {
            // Cria o hook para população do formulario
            $data = $this->doBeforePopulate($data);

            // Popula os campos caso estiver editando
            if(count($where) > 0) {
                // Busca o nome do elemento
                $form_elements = $form->getElements();

                //
                foreach($form_elements as $form_element) {
                    // Busca o nome do elemento
                    $form_name = $form_element->getName();

                    // Verifica se éo botão submit
                    if(($form_name == "submit") || ($form_name == "cancel")) {
                        continue;
                    }

                    $middle = $form_element->getAttrib("data-ac_middle");
                    if($middle != "") {
                        //var_dump($form_element);
                    }
                    else {
                        // Seta o valor no campo
                        $form->getElement($form_name)->setValue($data[$form_name]);
                    }
                }
            }

            // Verifica se possui abas
            $tabs = $this->_model->getTabs();
            $this->view->_tabs = $tabs;

            $tabsCompletas = $this->_model->getTabsCompletas();
            $this->view->_tabscompletas = $tabsCompletas;
        }

        // Chama o hook manipulador
        $form_temp = $this->doAfterCreateForm();

        // Percorre os elementos novos
        foreach($form_temp->getElements() as $element) {

            // Busca o nome do elemento
            $name_name = $element->getName();

            // Verifica se possui os dados na sessão
            $param = $this->_request->getParam($name_name);
            if($param > 0) {
                // Busca a descricao
                $label = $this->_request->getParam($name_name . "_label");

                // Seta os valores no campo
                $element->setAttrib("ac_label", $label);
                $element->setValue($param);
            }
            else {
                // Popula os campos caso estiver editando
                if(count($where) > 0) {
                    // Verifica se é um autocomplete
                    if(strlen($element->getAttrib("ac")) > 0) {
                        // Busca os modelos referencia
                        $reference_autocomplete = $element->getAttrib("ac");
                        $reference_ref = $element->getAttrib("ac_ref");

                        // Cria o objeto model
                        $model_ref = new $reference_ref();

                        // Busca a coluna descrição
                        $model_final = new $reference_autocomplete();
                        $description_column = $model_final->getDescription();
                        $placeholder_column = $model_final->getPlaceholder();

                        // Busca o valor
                        $label = $this->_request->getParam($name_name."_label", -1);

                        // Busca o campo da chave primaria
                        $primary_field = $model_final->getPrimaryField();

                        // Busca os campos
                        foreach($primary_field as $field) {
                            $return = $this->_model->fetchAll($where);

                            // Busca o label e o value
                            $label = $return->current()->findParentRow($reference_ref)->findParentRow($reference_autocomplete)->$description_column;
                            $label = $return->current()->findParentRow($reference_ref)->findParentRow($reference_autocomplete)->$placeholder_column;

                            $value = $return->current()->findParentRow($reference_ref)->findParentRow($reference_autocomplete)->$field;
                        }

                        // Seta os valores no campo
                        $element->setAttrib("ac_label", $label);
                        $element->setValue($value);
                    }
                }
            }

            // Adiciona o elemento ao formulario
            $form->addElement($element);
        }

        // Busca as informações da tabela
        $columns = $this->_model->describeTable();

        // Percorre os elementos do form para formata-los
        foreach($form->getElements() as $element) {
            // Busca o tipo do campo
            $field_type 	= $element->getAttrib("field-type");
            $value 			= $element->getValue();
            $name_name 		= $element->getName();
            $propriedadedb 	= $columns[ $name_name ];

            // Verifica se é decimal
            switch($field_type) {
                case "decimal":
                    $value = number_format($value, $propriedadedb['SCALE'], ",", ".");
                    break;

                case "date":
                    // Separa a hora da data
                    $values = explode(" ", $value);

                    // Trata a data
                    $date = implode("/", array_reverse(explode("-", $values[0])));

                    // Verifica se a data existe
                    if($date == "00/00/0000") {
                        $date = "";
                    }

                    // Junta a data
                    $value = $date;
                    break;

                case "datetime":
                    // Separa a hora da data
                    $values = explode(" ", $value);
                    $hr 	= explode(":", $values[1]);

                    // Trata a data
                    $date = implode("/", array_reverse(explode("-", $values[0]))).' '.$hr[0].':'.$hr[1];

                    // Verifica se a data existe
                    if($date == "00/00/0000 00:00:00" || $date == "00/00/0000 00:00" || trim($date) == ':') {
                        $date = "";
                    }

                    // Junta a data
                    $value = $date;
                    break;
            }

            // Seta o valor no campo
            $form->getElement($name_name)->setValue($value);
        }

        // Monta os parâmetros de filtros
        if($this->_request->getParams()) {
            foreach($this->_request->getParams() as $keyfiltro => $filtrosform) {
                if($keyfiltro != $primary_field[1] && $keyfiltro != "module" && $keyfiltro != "controller" && $keyfiltro != "action" && $keyfiltro != "page") {
                    $this->_requiredParam += array(
                        $keyfiltro => $filtrosform
                    );
                }
            }
        }

        // Percorre os parametros obrigatorios
        $url = $form->getElement("cancel")->getAttrib("data-url");
        foreach($this->_requiredParam as $param => $value) {
            $form->setAction($form->getAction() . "/" . $param . "/" . $value);
            $url .= "/" . $param . "/" . $value;
        }

        // Verifica se tem parametro de pagina
        if($this->_request->getParam("page", 0) > 0) {
            $url .= "/page/" . $this->_request->getParam("page", 0);
            $form->setAction($form->getAction() . "/page/" . $this->_request->getParam("page", 0));
        }

        // Adiciona a url ao cancelar
        $form->getElement("cancel")->setAttrib("data-url", $url);

        // Assina as variaveis
        $this->view->id 			= $id;
        $this->view->requireParam 	= $this->_requiredParam;
        $this->view->filtrosParam 	= $url;
        $this->view->form 			= $form;
        $this->view->submitLabel 	= $form->getElement("submit")->getLabel();
        $this->view->module 		= $this->_request->getParam("module");
        $this->view->controller 	= $this->_request->getParam("controller");
        $this->view->TableName 	= $this->_model->getTableName();
    }

    /**
     * Ação de criação e tratamento do formulario view
     *
     * @access protected
     * @name formAction
     */
    protected function viewAction() {
        // Busca o campo da chave primaria
        $primary_field = $this->_model->getPrimaryField();

        // Cria os parametros
        $where = array();
        $paramsr = array();
        foreach($primary_field as $field) {
            // Busca o parametro
            $value = $this->_request->getParam($field, 0);
            $id = $value;

            // Verifica o parametro
            if($value > 0) {
                $where[$field . " = ?"] = $value;
                $paramsr[$field] = $value;
            }
        }

        // Verifica se existe id passando por parametro
        if(count($where) > 0) {
            // Cria o formulario para visualizar
            $form = $this->_model->getForm("update");

            // Busca o registro para popular o formulario
            $data = $this->_model->fetchRow($where);
        }
        else {
            // Mensagem de erro
            $this->_messages->error = "Item não selecionado corretamente";
            $this->_helper->redirector("list", NULL, NULL, $this->_requiredParam);
        }

        // Hook para a criação do formulário
        $form = $this->doOnCreateForm($form);

        // Cria o hook para população do formulario
        $data = $this->doBeforePopulate($data);

        // Busca o nome do elemento
        $form_elements = $form->getElements();

        //
        foreach($form_elements as $form_element) {
            // Busca o nome do elemento
            $form_name = $form_element->getName();

            // Verifica se é o botão submit ou cancel
            if(($form_name == "submit") || ($form_name == "cancel")) {
                continue;
            }

            $middle = $form_element->getAttrib("data-ac_middle");
            if($middle != "") {

            }
            else {
                // Seta o valor no campo
                $form->getElement($form_name)->setValue($data[$form_name]);
            }
        }

        // Verifica se possui abas
        $tabs = $this->_model->getTabs();
        $this->view->_tabs = $tabs;

        // Verifica se possui abas com Listagem
        $tabsCompletas = $this->_model->getTabsCompletas();
        $this->view->_tabscompletas = $tabsCompletas;

        // Chama o hook manipulador
        $form_temp = $this->doAfterCreateForm();

        // Percorre os elementos novos
        foreach($form_temp->getElements() as $element) {
            // Busca o nome do elemento
            $name_name = $element->getName();

            // Verifica se possui os dados na sessão
            $param = $this->_request->getParam($name_name);
            if($param > 0) {
                // Busca a descricao
                $label = $this->_request->getParam($name_name . "_label");

                // Seta os valores no campo
                $element->setAttrib("ac_label", $label);
                $element->setValue($param);
            }
            else {
                // Popula os campos caso possuir parâmetro
                if(count($where) > 0) {
                    // Verifica se é um autocomplete
                    if(strlen($element->getAttrib("ac")) > 0) {
                        // Busca os modelos referencia
                        $reference_autocomplete = $element->getAttrib("ac");
                        $reference_ref = $element->getAttrib("ac_ref");

                        // Cria o objeto model
                        $model_ref = new $reference_ref();

                        // Busca a coluna descrição
                        $model_final = new $reference_autocomplete();
                        $description_column = $model_final->getDescription();

                        // Busca o valor
                        $label = $this->_request->getParam($name_name."_label", -1);

                        // Busca o campo da chave primaria
                        $primary_field = $model_final->getPrimaryField();

                        // Busca os campos
                        foreach($primary_field as $field) {
                            $return = $this->_model->fetchAll($where);

                            // Busca o label e o valu
                            $label = $return->current()->findParentRow($reference_ref)->findParentRow($reference_autocomplete)->$description_column;
                            $value = $return->current()->findParentRow($reference_ref)->findParentRow($reference_autocomplete)->$field;
                        }

                        // Seta os valores no campo
                        $element->setAttrib("ac_label", $label);
                        $element->setValue($value);
                    }
                }
            }

            // Adiciona o elemento ao formulario
            $form->addElement($element);
        }

        // Busca as informações da tabela
        $columns = $this->_model->describeTable();

        // Percorre os elementos do form para formata-los
        foreach($form->getElements() as $element) {
            // Busca o tipo do campo
            $field_type = $element->getAttrib("field-type");
            $value = $element->getValue();
            $name_name = $element->getName();
            $propriedadedb = $columns[ $name_name ];

            // Verifica se é decimal
            switch($field_type) {
                case "decimal":
                    $value = number_format($value, $propriedadedb['SCALE'], ",", ".");
                    break;

                case "date":
                    // Separa a hora da data
                    $values = explode(" ", $value);

                    // Trata a data
                    $date = implode("/", array_reverse(explode("-", $values[0])));

                    // Verifica se a data existe
                    if($date == "00/00/0000") {
                        $date = "";
                    }

                    // Junta a data
                    $value = $date;
                    break;

                case "datetime":
                    // Separa a hora da data
                    $values = explode(" ", $value);
                    $hr 	= explode(":", $values[1]);

                    // Trata a data
                    $date = implode("/", array_reverse(explode("-", $values[0]))).' '.$hr[0].':'.$hr[1];

                    // Verifica se a data existe
                    if($date == "00/00/0000 00:00:00" || $date == "00/00/0000 00:00" || trim($date) == ':') {
                        $date = "";
                    }

                    // Junta a data
                    $value = $date;
                    break;
            }

            // Seta o valor no campo
            $form->getElement($name_name)->setValue($value);

            // Seta o campo como readonly
            $form->getElement($name_name)->setAttrib("readonly", "readonly");
        }

        // Monta os parâmetros de filtros
        if($this->_request->getParams()) {
            foreach($this->_request->getParams() as $keyfiltro => $filtrosform) {
                if($keyfiltro != $primary_field[1] && $keyfiltro != "module" && $keyfiltro != "controller" && $keyfiltro != "action" && $keyfiltro != "page") {
                    $this->_requiredParam += array(
                        $keyfiltro => $filtrosform
                    );
                }
            }
        }

        // Percorre os parametros obrigatorios
        $url = $form->getElement("cancel")->getAttrib("data-url");
        foreach($this->_requiredParam as $param => $value) {
            $form->setAction($form->getAction() . "/" . $param . "/" . $value);
            $url .= "/" . $param . "/" . $value;
        }

        // Verifica se tem parametro de pagina
        if($this->_request->getParam("page", 0) > 0) {
            $url .= "/page/" . $this->_request->getParam("page", 0);
            $form->setAction($form->getAction() . "/page/" . $this->_request->getParam("page", 0));
        }

        // Adiciona a url ao cancelar
        $form->getElement("cancel")->setAttrib("data-url", $url);

        // Assina as variaveis
        $this->view->id 			= $id;
        $this->view->requireParam 	= $this->_requiredParam;
        $this->view->filtrosParam 	= $url;
        $this->view->form 			= $form;
        $this->view->submitLabel 	= $form->getElement("submit")->getLabel();
        $this->view->module 		= $this->_request->getParam("module");
        $this->view->controller 	= $this->_request->getParam("controller");
    }

    /**
     * Ação para remoção de registros
     *
     * @access protected
     * @name deleteAction
     */
    protected function deleteAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        // Busca o campo da chave primaria
        $primary_field = $this->_model->getPrimaryField();

        // Cria os parametros
        $where = array();
        foreach($primary_field as $field) {
            $where[$field . " = ?"] = (int)$this->_request->getParam($field, 0);
        }

        // Percorre os campos de multipla seleção
        foreach($this->_model->getMultipleFields() as $multiple_name) {
            $autocomplete = $this->_model->getAutocomplete($multiple_name);

            $model = new $autocomplete['middle_model']();

            $model->delete($where);
        }

        // Hook para antes da exclusão
        $this->doBeforeDelete();

        // Busca os dados do registro deletado
        $data = $this->_model->fetchRow($where);
        if($data) {
            $data_antes = $data->toArray();
        }else{
            $this->_helper->json(array('result' => FALSE, 'message' => "Registro não encontrado."));
            die();
        }

        //
        try {
            // Deleta o item
            $this->_model->delete($where);
        } catch (Exception $e) {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->_helper->json(array('result' => FALSE, 'message' => $e->getMessage()));
            }
            else {
                throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
            }
        }

        // Cria o log
        try {
            $this->doDatabaseLog("DELETE", $data_antes, NULL);
        } catch(Exception $e) {
            $json_message = "Não foi possivel salvar o log";
        }

        //
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->_helper->json(array('result' => TRUE, 'message' => $json_message));
            die();
        }

        // Redireciona o usuario para a listagem
        $this->_helper->redirector("list", NULL, NULL, $this->_requiredParam);
    }

    /**
     * Ação para remoção de arquivo
     *
     * @access protected
     * @name deleteAction
     */
    protected function deletefileAction() {
        // Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        // Busca o campo da chave primaria
        $primary_field = $this->_model->getPrimaryField();

        // Cria os parametros
        $where = array();
        $params = array();
        foreach($primary_field as $field) {
            $where[$field . " = ?"] = (int)$this->_request->getParam($field, 0);
            $params[$field] = (int)$this->_request->getParam($field, 0);
        }

        // Campo array
        $campo = array( $this->_request->getParam('field') => '' );

        // Campo clicado para remover o arquivo
        $campo_file = $this->_request->getParam('field', '');

        // Busca os dados do registro antes de deletar o arquivo
        $data = $this->_model->fetchRow($where);
        if($data) {
            $data_antes = $data->toArray();
        }

        // Seleciona o modificador do campo
        $modificadoresa = $this->_model->getModifier($campo_file);

        // Monta o caminho físico do arquivo
        $caminho = $modificadoresa['destination'] . '/' . $data_antes[$campo_file];

        // Remove o item do diretório
        unlink($caminho);

        // Limpa o Campo
        try {
            // Limpa o Campo do item informado
            $this->_model->update($campo, $where);
        } catch (Exception $e) {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->_helper->json(array('result' => FALSE, 'message' => $e->getMessage()));
            }
            else {
                throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
            }
        }

        // Cria o log
        try {
            $this->doDatabaseLog("UPDATE", $data_antes, $campo);
        } catch(Exception $e) {
            $json_message = "Não foi possivel salvar o log";
        }

        //
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->_helper->json(array('result' => TRUE, 'message' => $json_message));
            die();
        }

        // Redireciona o usuario para a listagem
        $this->_helper->redirector("form", NULL, NULL, $params);
    }

    /**
     * Ação para gerar excel dinamicamente na listagem dos registros
     *
     * @access protected
     * @name exportarxlsAction
     */
    protected function exportarxlsAction() {
    	// Desabilita o layout
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        // Passa para 800 segundos o max_execution_time
        set_time_limit(800);

        // Cria o formulario para busca
        $form = $this->_model->getForm("search");

        // Popula o formulário
        $form->isValid($this->_request->getParams());

        // Busca as informações da tabela
        $columns_table = $this->_model->describeTable();

        // Busca modifiers
        $columns_modifier = $this->_model->_modifiers;

        // Cria a query inicial
        $select = $this->_model->select();

        // Cria um hook para a listagem
        $return = $this->doBeforeList($select);

        // Pega elemento por elemento
        foreach($form->getElements() as $element) {
            // Busca o nome do elemento
            $form_name = $element->getName();

            // Busca o valor à ser buscado
            $value 			= $this->_request->getParam($form_name);
            $field_type 	= $element->getAttrib("alt");
            $form_name 		= $element->getName();

            // Verifica se não exibe alguns campos
            $campos_not_view = array(
                "submit","cancel","senha","chave","password","ip"
            );

            if(in_array($form_name, $campos_not_view)) {
                continue;
            }

            // Verifica se é campo do tipo file
            if($columns_modifier[$form_name]['type'] == "file") {
                continue;
            }

            // Verifica se é um autocomplete
            if($element->getAttrib("data-ac") != "") {
                $name_autocomplete 	= $form_name;
                $ac_autocomplete 	= $element->getAttrib("data-ac");
            }

            // Verifica se o valor está sendo passado
            if(strlen($value) > 0) {
                // Verifica o tipo
                switch($columns_table[$form_name]['DATA_TYPE']) {
                    // Verifica se é uma string
                    case "varying":
                    case "varchar":
                    case "text" :
                        // Modifica para suportar o LIKE
                        $signal = "LIKE";
                        $value = "%" . $value . "%";
                        break;

                    // Outros tipos não são full-text
                    default:
                        $signal = "=";
                        break;
                }

                // Selecionar o aliás do FROM
                $array_return = (array)$return;
                $prefix = chr(0).'*'.chr(0);

                // Seleciona a primeira chave, para evitar erro de ambiguidade
                foreach($array_return[$prefix."_parts"]["from"] as $key_from => $ret) {
                    $key_from = $key_from . ".";
                    break;
                }

                // Monta o where
                $select->where($key_from . $form_name . " " . $signal . " ?", $value);
            }
        }

        // Monta a ordem
        $primary_field = $this->_model->getPrimaryField();
        foreach($primary_field as $field) {
            $select->order($field);
        }

        // Fetch
        $registros = $this->_model->fetchAll($select);

        // Array colunas/letras excel
        $arr_excel = array();
        for($a = 'a';  $a != 'aaa'; $a++) {
            $arr_excel[] = strtoupper($a);
        }

        // Array das colunas
        $arr_colunas = array();

        // Percorre os registros para contar as colunas e armazenar os titulos das colunas
        $qtdcolunas = 0;
        foreach($registros as $chave => $registro) {
            // Percorre as colunas
            foreach($registro as $campo => $coluna) {
                $campos_not_view = array(
                    "senha","chave","password","ip","meta_dados","dados","cliente_session_id",
                    "celular_pagamento","referencias_pagamento","pais_pagamento","tipo_pagamento","tipo_entrega","referencias_entrega","pais_entrega","idstatus_pedido"
                );

                if(!in_array($campo, $campos_not_view) && $columns_modifier[$campo]['type'] != "file") {
                    // Tipo do campo no bd
                    $coluna_tipo = $columns_table[$campo]['DATA_TYPE'];
                    $coluna_tamanho = $columns_table[$campo]['LENGTH'];

                    if($form->getElement($campo)) {
                        $form_label_completo 	= str_replace(" * ","",$form->getElement($campo)->getLabel());
                        $form_label_arr 		= explode("<",$form_label_completo);
                        $form_label 			= $form_label_arr[0];
                    }else{
                        $form_label = $campo;
                    }

                    $arr_colunas[$qtdcolunas]['col_letra'] 		= $arr_excel[$qtdcolunas];
                    $arr_colunas[$qtdcolunas]['col_name'] 		= $campo;
                    $arr_colunas[$qtdcolunas]['col_label'] 		= $form_label;
                    $arr_colunas[$qtdcolunas]['col_tipo'] 		= $coluna_tipo;
                    $arr_colunas[$qtdcolunas]['col_tamanho'] 	= $coluna_tamanho;

                    // Soma 1
                    $qtdcolunas++;
                }
            }
            break;
        }

        // Se for pedidos, adiciona colunas extras
        if($this->_model->getTableName() == "pedidos") {
            // Coluna 'Lista de produtos'
            $arr_colunas[$qtdcolunas]['col_letra'] = $arr_excel[$qtdcolunas];
            $arr_colunas[$qtdcolunas]['col_name']  = "semregistro";
            $arr_colunas[$qtdcolunas]['col_label'] = 'Produtos da compra';
            $arr_colunas[$qtdcolunas]['col_tipo']  = 'text-big';
            $qtdcolunas++;

            // Coluna 'Lista de histórico'
            $arr_colunas[$qtdcolunas]['col_letra'] = $arr_excel[$qtdcolunas];
            $arr_colunas[$qtdcolunas]['col_name']  = "semregistro";
            $arr_colunas[$qtdcolunas]['col_label'] = 'Histórico da compra';
            $arr_colunas[$qtdcolunas]['col_tipo']  = 'text-big-big';
            $qtdcolunas++;
        }

        // Se for clientes, adiciona colunas extras
        if($this->_model->getTableName() == "clientes") {
            // Coluna 'Endereço cobrança'
            $arr_colunas[$qtdcolunas]['col_letra'] = $arr_excel[$qtdcolunas];
            $arr_colunas[$qtdcolunas]['col_name']  = "semregistro";
            $arr_colunas[$qtdcolunas]['col_label'] = 'Endereço da cobraça';
            $arr_colunas[$qtdcolunas]['col_tipo']  = 'text-big';
            $qtdcolunas++;

            // Coluna 'Endereços entrega'
            $arr_colunas[$qtdcolunas]['col_letra'] = $arr_excel[$qtdcolunas];
            $arr_colunas[$qtdcolunas]['col_name']  = "semregistro";
            $arr_colunas[$qtdcolunas]['col_label'] = 'Endereço da entrega';
            $arr_colunas[$qtdcolunas]['col_tipo']  = 'text-big-big';
            $qtdcolunas++;
        }

        // Define o nome do arquivo
        $arquivo = $this->_request->getParam("controller") . "-" . date("Ymd-hms");

        // Configura o arquivo
        $excel = new gazetamarista_Geraexcel();
        $excel->getProperties()->setCreator("Admin");
        $excel->getProperties()->setLastModifiedBy("Admin");
        $excel->getProperties()->setTitle($arquivo);
        $excel->getProperties()->setSubject($arquivo);
        $excel->getProperties()->setDescription("Admin - exportação" . $this->_request->getParam("controller"));

        // Define a linha inicial
        $linha = 1;

        // Seta o tamanho das colunas
        $excel->setActiveSheetIndex(0);
        foreach($arr_colunas as $item) {
            // Tamanho default
            $tamanho = 30;

            if($item['col_tamanho'] < 10) {
                $tamanho = 15;
            }

            // Verifica o tamanho do campo
            if($item['col_tamanho'] > 50 || is_null($item['col_tipo'])) {
                $tamanho = 45;
            }

            if($item['col_tipo'] == "datetime" || substr($item['col_tipo'],0,4) == "enum") {
                $tamanho = 25;
            }

            if($item['col_tipo'] == "text") {
                $tamanho = 60;
            }

            if($item['col_tipo'] == "text-big") {
                $tamanho = 100;
            }

            if($item['col_tipo'] == "text-big-big") {
                $tamanho = 150;
            }

            if(!empty($item['col_letra'])) {
                $excel->getActiveSheet()->getColumnDimension($item['col_letra'])->setWidth($tamanho);
            }
        }

        // Define a configuração do estilo
        $styleTitulo = array(
            'font' => array(
                'bold' => true
            )
        );

        $styleLinha = array(
            'fill' => array(
                'type' => 'solid',
                'color' => array('rgb' => 'DCDCDC')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => 'thin'
                )
            ),
            'wrap' => true
        );

        $styleLinha2 = array(
            'fill' => array(
                'type' => 'solid',
                'color' => array('rgb' => 'FFFFFF')
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => 'thin'
                )
            ),
            'alignment' => array(
                'wrap' => true
            )
        );

        // Escreve o titulo das colunas
        $excel->getActiveSheet();
        foreach($arr_colunas as $item) {
            if(!empty($item['col_letra'])) {
                $excel->getActiveSheet()->SetCellValue($item['col_letra'].$linha, $item['col_label']);

                $excel->getActiveSheet()->getStyle($item['col_letra'].$linha)->applyFromArray($styleTitulo);
            }
        }

        // Inicia variável
        $novachave = -1;

        // Percorre os registros para montar o excel
        foreach($registros as $chave => $dado) {
            // Percorre as colunas
            foreach($arr_colunas as $chavecol => $item) {
                if((int)$chave > (int)$novachave) {
                    // Incrementa a variavel que define a linha
                    $linha++;
                    $novachave = $chave;
                }

                // Adiciona conteúdo extra
                if($item['col_name'] == "semregistro") {
                    // Limpa campo
                    $conteudorow = '';

                    // Busca conteúdo extra pedidos
                    if($this->_model->getTableName() == "pedidos") {
                        // Busca produtos
                        if($item['col_label'] == 'Produtos da compra') {
                            // Item conteúdo
                            $conteudorow = '';

                            if(class_exists('Admin_Model_Pedidosprodutos')) {
								// Busca os produtos do pedido
								$model_pedprod = new Admin_Model_Pedidosprodutos();
								$select_pedprods = $model_pedprod->select()
									->from("pedidos_produtos", array('*'))
									->where("pedidos_produtos.idpedido = ?", $dado->idpedido)
									->group('pedidos_produtos.idproduto')
									->setIntegrityCheck(FALSE);

								$produtos_pedido = $model_pedprod->fetchAll($select_pedprods);
								foreach ($produtos_pedido as $prodped) {
									if (!empty($conteudorow)) {
										$conteudorow .= "; ";
									}

									$xqtd_prod = (int)$prodped->quantidade;
									if ($prodped->tipo == "metro") {
										$xqtd_prod .= ' metro(s)';
									} else {
										$xqtd_prod .= ' unit(s)';
									}

									$conteudorow .= '' . trim($prodped->descricao) . ' - ' . $prodped->titulo . ' ' . $prodped->colecao . ': ' . $xqtd_prod;
								}
							}
                        }

                        if(class_exists('Admin_Model_Pedidosstatus')) {
							// Busca histórico
							if ($item['col_label'] == 'Histórico da compra') {
								// Item conteúdo
								$conteudorow = '';

								// Busca o histórico de status do pedido
								$model_historicos = new Admin_Model_Pedidosstatus();
								$select_historicos = $model_historicos->select()
									->from("pedidos_status", array('*'))
									->where("pedidos_status.idpedido = ?", $dado->idpedido)
									->order("pedidos_status.data_execucao ASC")
									->setIntegrityCheck(FALSE);

								$historicos_pedido = $model_historicos->fetchAll($select_historicos);
								foreach ($historicos_pedido as $histped) {
									if (count($historicos_pedido) == 1 || (count($historicos_pedido) > 1 && $histped->idstatus_pedido != 1)) {
										if (!empty($conteudorow)) {
											$conteudorow .= "; ";
										}
										$conteudorow .= date("d/m/Y H:i", strtotime($histped->data_execucao)) . ' ' . $histped->status_pedido;
									}
								}
							}
						}
                    }

                    // Busca conteúdo extra clientes
                    if($this->_model->getTableName() == "clientes") {
                        // Endereço de cobrança
                        if($item['col_label'] == 'Endereço da cobraça') {
                            $model_enderecos = new Admin_Model_Clientesenderecos();
                            $select_cobranca = $model_enderecos->select()
                                ->where("idcliente = ?", $dado->idcliente)
                                ->where("tipo = 'cobranca'")
                                ->order("idcliente_endereco DESC");

                            $end_cobrancas = $model_enderecos->fetchAll($select_cobranca);
                            foreach($end_cobrancas as $clicobranca) {
                                if(!empty($conteudorow)) {
                                    $conteudorow .= chr(10);
                                }

                                $conteudorow .= $clicobranca->endereco . ', ' . $clicobranca->numero . ' ' . $clicobranca->bairro . ' ' . $clicobranca->complemento;
                                $conteudorow .= ', ' . $clicobranca->cep . ', ' . $clicobranca->cidade . '/' . $clicobranca->estado;
                            }
                        }

                        // Endereços de entrega
                        if($item['col_label'] == 'Endereço da entrega') {
                            $model_enderecos = new Admin_Model_Clientesenderecos();
                            $select_entregas = $model_enderecos->select()
                                ->where("idcliente = ?", $dado->idcliente)
                                ->where("tipo = 'entrega'")
                                ->order("idcliente_endereco DESC");

                            $end_entregas = $model_enderecos->fetchAll($select_entregas);
                            foreach($end_entregas as $clientrega) {
                                if(!empty($conteudorow)) {
                                    $conteudorow .= chr(10);
                                }

                                $conteudorow .= $clientrega->endereco . ', ' . $clientrega->numero . ' ' . $clientrega->bairro . ' ' . $clientrega->complemento;
                                $conteudorow .= ', ' . $clientrega->cep . ', ' . $clientrega->cidade . '/' . $clientrega->estado;
                            }
                        }
                    }
                }else{
                    // Item name
                    $item_txt = $item['col_name'];

                    // Item conteúdo
                    $conteudorow = $dado->$item_txt;
                }

                // Formatacao
                if($item['col_name'] == "ativo" || $item['col_name'] == "destaque" || $item['col_name'] == "oferta"
                    || $item['col_name'] == "lancamento" || $item['col_name'] == "visualizado") {
                    if($conteudorow == 1) {
                        $conteudorow = "sim";
                    }else{
                        $conteudorow = "não";
                    }
                }

                if($item['col_tipo'] == "datetime") {
                    if($conteudorow != "0000-00-00 00:00:00") {
                        $conteudorow = date("d/m/Y H:i", strtotime($conteudorow));
                    }
                }

                if($item['col_tipo'] == "date") {
                    if($conteudorow != "0000-00-00") {
                        $conteudorow = date("d/m/Y", strtotime($conteudorow));
                    }
                }

                if($item['col_tipo'] == "text") {
                    $conteudorow = nl2br($conteudorow);
                }

                if($item['col_tipo'] == "decimal") {
                    $conteudorow = number_format($conteudorow,2,",",".");
                }

                // Bloqueia a exibição de alguns campos
                if($item['col_name'] == "senha" || $item['col_name'] == "password" || $item['col_name'] == "chave" || $item['col_name'] == "ip") {
                    $conteudorow = "-";
                }

                if(!empty($item['col_letra'])) {
                    // Escreve na planilha
                    $excel->getActiveSheet()->SetCellValue($item['col_letra'].$linha, $conteudorow);

                    if($linha % 2 == 0){
                        $excel->getActiveSheet()->getStyle($item['col_letra'].$linha)->applyFromArray($styleLinha);
                    }else{
                        $excel->getActiveSheet()->getStyle($item['col_letra'].$linha)->applyFromArray($styleLinha2);
                    }
                }
            }
        }

        $excel->getActiveSheet()->setTitle('Admin export');

        // Seta header charset
        header('Content-Type: text/html; charset=ISO-8859-1');

        ob_end_clean();

        // Salva o arquivo
        $writer = new gazetamarista_Geraexcelwriter($excel);
        $writer->save(APPLICATION_PATH . "/../common/uploads/export/".$arquivo .".xls");

        // Busca as configurações
        $config = Zend_Registry::get("config");

        // Captura o domínio
        if($_SERVER['HTTP_HOST'] == "localhost") {
            $url_dominio = "//localhost" . $config->gazetamarista->config->basepath;
        }elseif($_SERVER['HTTP_HOST'] == "sites.gazetamarista.com.br") {
            $url_dominio = "//sites.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
        }else{
            $url_dominio = "//" . $config->gazetamarista->config->domain;
        }

        // Download do arquivo
        header("Location: " . $url_dominio . "/common/uploads/export/" . $arquivo . ".xls");

        die("<br><br>Exportação de lista<br><br>Arquivo: " . $url_dominio . "/common/uploads/export/" . $arquivo . ".xls");
    }

    /**
     * Ação para gerar pdf de um registro
     *
     * @access protected
     * @name exportpdfAction
     */
    protected function exportpdfAction() {
        // Desabilita os layouts
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        // Passa para 800 segundo o max_execution_time
        set_time_limit(800);

        // Busca os parametros
        $idregistro = $this->_request->getParam("id", "");

        if(empty($idregistro)) {
            // Adiciona a mensagem de erro à sessão
            $this->_messages->error = "ID inválido. Tente novamente";
            $this->_redirect($_SERVER["HTTP_REFERER"]);
        }

        // Busca o campo da chave primaria
        $primary_field = $this->_model->getPrimaryField();

        // Cria os parametros
        $where = array();
        $paramsr = array();
        foreach($primary_field as $field) {
            // Verifica o parametro
            if($idregistro > 0) {
                $where[$field . " = ?"] = $idregistro;
                $paramsr[$field] = $idregistro;
            }

            break;
        }

        // Verifica se existe id passando por parametro
        if(!count($where) > 0) {
            // Mensagem de erro
            $this->_messages->error = "Item não selecionado corretamente";
            $this->_helper->redirector("list", NULL, NULL, $this->_requiredParam);
        }

        // Texto do controlador
        $controlador_atual = $this->_request->getParam("controller", "");
        if(!empty($controlador_atual)) {
            // Busca o menu
            $model_menuitem = new Admin_Model_Menusitens();
            $select_menu = $model_menuitem->select()
                ->from("menu_itens", array(""))
                ->joinInner("menu_categorias", "menu_categorias.idcategoria = menu_itens.idcategoria", array("description" => "descricao"))
                ->columns(array(
                    'iditem'    => "menu_itens.iditem",
                    'descricao' => "concat(menu_categorias.descricao, ': ' , menu_itens.descricao)"
                ))
                ->where("menu_itens.controlador = ?", $controlador_atual)
                ->setIntegrityCheck(FALSE);

            $rowmenu = $model_menuitem->fetchRow($select_menu);

            if($rowmenu) {
                $txt_controlador_pdf = ucfirst($rowmenu->descricao);
            }else{
                $txt_controlador_pdf = ucfirst($controlador_atual);
            }
        }else{
            $txt_controlador_pdf = 'PDF';
        }

        // Cria o formulario para visualizar
        $form = $this->_model->getForm("update");

        // Busca o registro
        $data = $this->_model->fetchRow($where);

        // Instancia Zend Pdf
        $pdf = new Zend_Pdf();

        // Define o tamanho da página
        $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); //595 x 843

        // Cria linha delimitando a tabela
        $page->setLineColor(Zend_Pdf_Color_Html::color('#a6c9e2'))
            ->drawRectangle(30, 800, 565, 43, Zend_Pdf_Page::SHAPE_DRAW_STROKE);

        // Create new font
        $font 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
        $fontB 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
        $y 		= 765;

        // Busca as informações da tabela
        $columns_table = $this->_model->describeTable();

        // Busca modifiers
        $columns_modifier = $this->_model->_modifiers;

        // Sessão para pegar o nome do site
        $session_configuracao = new Zend_Session_Namespace("configuracao");

        // Cabeçalho do pdf
        $page->setFont($font, 16)
            ->setFillColor(Zend_Pdf_Color_Html::color('#bbbbbb'))
            ->drawText($session_configuracao->dados->nome_site, 60, $y+9, 'UTF-8');

        $page->setFont($font, 13)
            ->setFillColor(Zend_Pdf_Color_Html::color('#bbbbbb'))
            ->drawText($txt_controlador_pdf, 60, $y-3, 'UTF-8');

        $page->setFont($font, 13)
            ->setFillColor(Zend_Pdf_Color_Html::color('#bbbbbb'))
            ->drawText(date("d/m/Y H:i"), 445, $y+8, 'UTF-8');

        // Cria linha separando o cabeçalho
        $page->setLineColor(Zend_Pdf_Color_Html::color('#bbbbbb'))
            ->setLineDashingPattern(array(2, 2), 0)
            ->setLineWidth(1)
            ->drawLine(45, $y-10, 550, $y-10);

        // Altura da linha
        $y = $y - 26;

        // Busca os elementos
        $form_elements = $form->getElements();

        foreach($form_elements as $form_element) {
            // Busca o nome do elemento
            $form_name 				= $form_element->getName();
            $form_label_completo 	= str_replace(" * ","",$form_element->getLabel());
            $form_label_arr 		= explode("<",$form_label_completo);
            $form_label 			= $form_label_arr[0];

            // Verifica se não exibe alguns campos
            $campos_not_view = array(
                "submit","cancel","senha","password","data_execucao",
                "meta_dados","dados","identificacao","cliente_session_id",
                "celular_pagamento","referencias_pagamento","pais_pagamento","tipo_pagamento","tipo_entrega","referencias_entrega","pais_entrega"
            );

            if(in_array($form_name, $campos_not_view)) {
                continue;
            }

            // Verifica se é campo do tipo file
            if($columns_modifier[$form_name]['type'] == "file") {
                continue;
            }

            // Verifica se muda de página
            if($y < 65) {
                // Paginação
                $pdf->pages[] = $page;

                // Define pagina e cria linha delimitando a tabela
                $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); //595 x 843
                $page->setLineColor(Zend_Pdf_Color_Html::color('#a6c9e2'))
                    ->drawRectangle(30, 800, 565, 43, Zend_Pdf_Page::SHAPE_DRAW_STROKE);

                // Create new font
                $font 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
                $fontB 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
                $y 		= 765;
            }

            // Valor do campo
            $value = $data[$form_name];

            // Verifica se é um autocomplete
            if($form_element->getAttrib("data-ac") != "" && $form_element->getAttrib("data-ac_label") != "") {
                //$value = $form_element->getAttrib("data-ac_label");

                // Busca informação do model de referencia
                $model_element      = $form_element->getAttrib("data-ac");
                $model_reference    = new $model_element();
                $campo_reference    = $model_reference->getDescription();
                $fetchreference     = $model_reference->fetchRow(array($form_name.' = ?' => $value));
                $value              = $fetchreference->$campo_reference;
            }

            if(empty($value)) {
                $value = '--';
            }

            $data_valida = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", substr($value,0,10));

            if($data_valida) {
                if(substr($value,0,11) != "0000-00-00"){
                    // Verifica se possui horas
                    if(strpos($value, ':') && !strpos($value, '00:00:00')) {
                        $value = date("d/m/Y H:i", strtotime($value));
                    }else{
                        $value = date("d/m/Y", strtotime($value));
                    }
                }else{
                    $value = '--';
                }
            }

            // Tipo do campo da tabela
            if($columns_table[$form_name]['DATA_TYPE'] == "text") {
                $texto = $value;
                $novo_texto = wordwrap($texto, 75, "@quebralinha@", false);
                $value = explode('@quebralinha@', $novo_texto);;
            }

            if($columns_table[$form_name]['DATA_TYPE'] == "tinyint") {
                if($value == 1) {
                    $value = "sim";
                }else{
                    $value = "não";
                }
            }

            $page->setFont($fontB, 10)
                ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                ->drawText(trim($form_label).": ", 50, $y, 'UTF-8');

            if(is_array($value)) {
                // Array
                foreach($value as $chave_foreach => $linha_array) {
                    if($chave_foreach > 0) {
                        $y = $y - 14;
                    }

                    $page->setFont($font, 11)
                        ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                        ->drawText($linha_array, 200, $y, 'UTF-8');

                }
            }else{
                $page->setFont($font, 11)
                    ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                    ->drawText($value, 200, $y, 'UTF-8');
            }

            // Cria linha delimitando cada linha da tabela
            $page->setLineColor(Zend_Pdf_Color_Html::color('#e4e4e4'))
                ->setLineDashingPattern(array(2, 2), 0)
                ->setLineWidth(0.6)
                ->drawLine(45, $y-8, 550, $y-10);

            // Altura da linha
            $y = $y - 24;
        }

        // Se for assinaturas, adiciona extras
        if($this->_model->getTableName() == "assinaturas") {
            // Seleciona o histórico
            $model_pagtos = new Admin_Model_Pagtos();
            $select_pagtos = $model_pagtos->select()
                ->from("pagtos", array('*'))
                ->where("pagtos.idassinatura = ?", $idregistro)
                ->order("pagtos.data_execucao DESC")
                ->setIntegrityCheck(FALSE);

            $pagtos = $model_pagtos->fetchAll($select_pagtos);

            // Cabeçalho do histórico
            $page->setFont($fontB, 11)
                ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                ->drawText(":: Lista de Histórico", 50, $y, 'UTF-8');

            // Cria linha delimitando cada linha da tabela
            $page->setLineColor(Zend_Pdf_Color_Html::color('#e4e4e4'))
                ->setLineDashingPattern(array(2, 2), 0)
                ->setLineWidth(0.6)
                ->drawLine(45, $y-8, 550, $y-10);

            // Altura da linha
            $y = $y - 24;

            // Percorre o histórico
            foreach($pagtos as $pagto) {
                // Verifica se muda de página
                if($y < 65) {
                    // Paginação
                    $pdf->pages[] = $page;

                    // Define pagina e cria linha delimitando a tabela
                    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); //595 x 843
                    $page->setLineColor(Zend_Pdf_Color_Html::color('#a6c9e2'))
                        ->drawRectangle(30, 800, 565, 43, Zend_Pdf_Page::SHAPE_DRAW_STROKE);

                    // Create new font
                    $font 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
                    $fontB 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
                    $y 		= 765;
                }

                if($pagto->observacao == 'iniciado') {
                    $txt_status = "*Usuário acessou a tela de pagto";
                }else{
                    $txt_status = "*" . $pagto->status_pagto;
                }

                $historico_label = date("d/m/Y H:i:s", strtotime($pagto->data_execucao)) . ' - ' . $pagto->observacao . ' ' . $txt_status;
                $page->setFont($font, 11)
                    ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                    ->drawText($historico_label, 65, $y, 'UTF-8');

                // Cria linha delimitando cada linha da tabela
                $page->setLineColor(Zend_Pdf_Color_Html::color('#e4e4e4'))
                    ->setLineDashingPattern(array(2, 2), 0)
                    ->setLineWidth(0.6)
                    ->drawLine(45, $y-8, 550, $y-10);

                // Altura da linha
                $y = $y - 24;
            }
        }

        // Se for clientes, adiciona extras
        if($this->_model->getTableName() == "clientes") {
            // Seleciona endereços
	        $model_enderecos = new Admin_Model_Clientesenderecos();
	        $select_enderecos = $model_enderecos->select()
	            ->where("idcliente = ?", $idregistro)
	            ->order("tipo ASC")
	            ->order("idcliente_endereco ASC");

	        $clienderecos = $model_enderecos->fetchAll($select_enderecos);

            // Cabeçalho do histórico
            $page->setFont($fontB, 11)
                ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                ->drawText(":: Lista de Endereços", 50, $y, 'UTF-8');

            // Cria linha delimitando cada linha da tabela
            $page->setLineColor(Zend_Pdf_Color_Html::color('#e4e4e4'))
                ->setLineDashingPattern(array(2, 2), 0)
                ->setLineWidth(0.6)
                ->drawLine(45, $y-8, 550, $y-10);

            // Altura da linha
            $y = $y - 24;

            // Percorre o histórico
            foreach($clienderecos as $cliendereco) {
                // Verifica se muda de página
                if($y < 65) {
                    // Paginação
                    $pdf->pages[] = $page;

                    // Define pagina e cria linha delimitando a tabela
                    $page = new Zend_Pdf_Page(Zend_Pdf_Page::SIZE_A4); //595 x 843
                    $page->setLineColor(Zend_Pdf_Color_Html::color('#a6c9e2'))
                        ->drawRectangle(30, 800, 565, 43, Zend_Pdf_Page::SHAPE_DRAW_STROKE);

                    // Create new font
                    $font 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
                    $fontB 	= Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES_BOLD);
                    $y 		= 765;
                }

                if($cliendereco->tipo == 'cobranca') {
                    $endereco_label = "Cobrança: ";
                }else{
                    $endereco_label = "Entrega:    ";
                }

                $endereco_label .= $cliendereco->endereco . ', ' . $cliendereco->numero . ' ' . $cliendereco->bairro . ' ' . $cliendereco->complemento;
                $endereco_label .= ', ' . $cliendereco->cep . ', ' . $cliendereco->cidade . '/' . $cliendereco->estado;

                $page->setFont($font, 11)
                    ->setFillColor(Zend_Pdf_Color_Html::color('#000000'))
                    ->drawText($endereco_label, 65, $y, 'UTF-8');

                // Cria linha delimitando cada linha da tabela
                $page->setLineColor(Zend_Pdf_Color_Html::color('#e4e4e4'))
                    ->setLineDashingPattern(array(2, 2), 0)
                    ->setLineWidth(0.6)
                    ->drawLine(45, $y-8, 550, $y-10);

                // Altura da linha
                $y = $y - 24;
            }
        }

        $pdf->pages[] = $page;

        header('Content-Description: File Transfer');
        header("Content-Type: application/pdf;");
        header("Content-Disposition:inline; filename=".$this->_request->getParam("controller")."-".$idregistro.".pdf");

        $pdf->pdfDate(date("d/m/Y"));
        $pdf->setNamedDestination($this->_request->getParam("controller")."-".$idregistro.".pdf'");
        echo $pdf->render();
    }

    /**
     * Ação para gerar HTMl para Impressão de um registro
     *
     * @access protected
     * @name exportpdfAction
     */
    protected function printAction() {
        // Desabilita os layouts
        $this->_helper->layout->disableLayout();

        // Passa para 600 segundo o max_execution_time
        set_time_limit(600);

        // Busca os parametros
        $idregistro = $this->_request->getParam("id", "");

        if($idregistro == "") {
            // Adiciona a mensagem de erro à sessão
            $this->_messages->error = "ID inválido. Tente novamente";
            $this->_redirect($_SERVER["HTTP_REFERER"]);
        }

        // Busca o campo da chave primaria
        $primary_field = $this->_model->getPrimaryField();

        // Cria os parametros
        $where = array();
        $paramsr = array();
        foreach($primary_field as $field) {
            // Verifica o parametro
            if($idregistro > 0) {
                $where[$field . " = ?"] = $idregistro;
                $paramsr[$field] = $idregistro;
            }

            break;
        }

        // Verifica se existe id passando por parametro
        if(!count($where) > 0) {
            // Mensagem de erro
            $this->_messages->error = "Item não selecionado corretamente";
            $this->_helper->redirector("list", NULL, NULL, $this->_requiredParam);
        }

        // Cria o formulario para visualizar
        $form = $this->_model->getForm("update");

        // Busca o registro
        $data = $this->_model->fetchRow($where);
        $this->view->dados = $data;
        $this->view->idregistro = $idregistro;
    }

    /**
     * Cria o log de banco de dados
     *
     * @name doDatabaseLog
     * @param string $action Acao executada no banco de dados
     * @param array $data Vetor com os dados à serem modificados/adicionados na tabela
     */
    public function doDatabaseLog($action, $data_antes, $data) {
        // Busca a sessão das mensagens
        $session = new Zend_Session_Namespace("loginadmin");

        if(!empty($data_antes)) {
            $data_antes = json_encode($data_antes);
        }

        if(!empty($data)) {
            $data = json_encode($data);
        }

        // Monta os dados
        $insert_data 					= array();
        $insert_data['idusuario'] 		= $session->logged_usuario['idusuario'];
        $insert_data['nomeusuario'] 	= $session->logged_usuario['nome'] . " (" . $session->logged_usuario['login'] . ")";
        $insert_data['modulo'] 			= "admin";
        $insert_data['tabela'] 			= $this->_model->getTableName();
        $insert_data['json_data_antes'] = $data_antes;
        $insert_data['json_data'] 		= $data;
        $insert_data['acao_executada'] 	= $action;
        $insert_data['browser_sistema']	= json_encode($_SERVER["HTTP_USER_AGENT"]);
        $insert_data['data_execucao'] 	= date("Y-m-d H:i:s");
        $insert_data['ip'] 				= $_SERVER['REMOTE_ADDR'];

        // Cria o model dos logs
        $model = new Admin_Model_Logs();
        try {
            $model->insert($insert_data);
        }
        catch(Exception $e) {
            //throw new Zend_Controller_Action_Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Adiciona parametros obrigatórios da tela
     *
     * @name setRequiredParam
     * @param string $name Nome do parametro
     * @param string $value Valor do parametro
     */
    public function setRequiredParam($name, $value) {
        // Armazena o parametro
        $this->_requiredParam[$name] = $value;
    }

    /**
     * Hook para ser executado antes do insert
     *
     * @access protected
     * @name doBeforeInsert
     * @param array $data Vetor com os valores à serem inseridos
     * @return array
     */
    protected function doBeforeInsert($data) {
        return $data;
    }

    /**
     * Hook para ser executado depois do insert
     *
     * @access protected
     * @param integer $id Id gerado pelo insert
     * @name doAfterInsert
     */
    protected function doAfterInsert($id=0) {
    }

    /**
     * Hook para ser executado depois do atualização
     *
     * @access protected
     * @name doAfterUpdate
     */
    protected function doAfterUpdate() {
    }

    /**
     * Hook para ser executado antes do update
     *
     * @access protected
     * @name doBeforeUpdate
     * @param array $data Vetor com os valores à serem atualizados
     * @return array
     */
    protected function doBeforeUpdate($data) {
        return $data;
    }

    /**
     * Hook para ser executado antes da listagem dos registros
     *
     * @access protected
     * @param Zend_Db_Select $select Objeto select
     * @name doBeforeList
     */
    protected function doBeforeList($select=NULL) {
        return $select;
    }

    /**
     * Hook para ser executado antes da exclusão
     *
     * @access protected
     * @name doBeforeDelete
     */
    protected function doBeforeDelete() {
    }

    /**
     * Cria icones na listagem de forma dinamica
     *
     * @param string $value Nome do icone
     * @param string $class Classe CSS do icone
     * @param array $url Vetor com as posições/valores do module,controller,action
     * @param boolean $clear Valor de deve resetar os parametros
     */
    public function createIcon($value, $class, $url, $clear=FALSE) {
        // Formata a posição do vetor
        $icon = array();
        $icon['value'] = $value;
        $icon['class'] = $class;
        $icon['url'] = $url;
        $icon['clear'] = $clear;

        // Armazena na variavel global
        $this->__listExtraIcons[] = $icon;
    }

    /**
     * Hook para manipulação do formulário na sua criação
     *
     * @name doOnCreateForm
     * @param Zend_Form $form Formulario ja criado pelo model
     * @return Zend_Form
     */
    protected function doOnCreateForm($form) {
        // Retorna o proprio formulário
        return $form;
    }

    /**
     * Hook para manipulação do formulário após sua criação
     *
     * @name doAfterCreateForm
     * @return Zend_Form
     */
    protected function doAfterCreateForm() {
        // Cria o formulario temporario
        $form = new Zend_Form();

        // Retorna o proprio formulário
        return $form;
    }

    /**
     * Hook para manipulação dos dados antes de popular o formulário
     *
     * @name doBeforePopulate
     * @return array
     */
    protected function doBeforePopulate($data) {

        // Retorna o proprio dados
        return $data;
    }
}
