<?php
/**
 * Classe de extenssão do zend table
 *
 * @name gazetamarista_Db_Table
 */
abstract class gazetamarista_Db_Table extends Zend_Db_Table_Abstract {

	/**
	 * Nome da tabela do banco de dados
	 *
	 * @name $_name
	 * @var string
	 */
	protected $_name = "";

	/**
	 * Nome do campo da chave primaria
	 *
	 * @name $_primary
	 * @var string
	 */
	protected $_primary = "";

	/**
	 * Armazena a visibilidade dos campos
	 *
	 * @access protected
	 * @name $__columnsVisibility
	 * @var array
	 */ 
	protected $__columnsVisibility = array();

	/**
	 * Armazena os campos que são de usuario
	 *
	 * @access protected
	 * @name $__userColumns
	 * @var array
	 */
	protected $__userColumns = array();

	/**
	 * Armazena a descrição da tabela
	 *
	 * @access protected
	 * @name __describeTable
	 * @var array
	 */
	protected $__describeTable = NULL;

	/**
	 * Armazena o nome dos campos
	 *
	 * @access protected
	 * @name __columnsName
	 * @var array
	 */
	protected $__columnsName = array();

	/**
	 * Armazena a descrição dos campos
	 *
	 * @access protected
	 * @name __columnsDescription
	 * @var array
	 */
	protected $__columnsDescription = array();

	/**
	 * Armazena o nome da coluna descrição
	 *
	 * @access protected
	 * @name __descriptionColumn
	 * @var string
	 */
	protected $__descriptionColumn = "";


    /**
     * Armazena o placeholder dos campos
     *
     * @access protected
     * @name __columnsPlaceholder
     * @var array
     */
    protected $__columnsPlaceholder = array();

    /**
     * Armazena o nome da coluna placeholder
     *
     * @access protected
     * @name __placeholderColumn
     * @var string
     */
    protected $__placeholderColumn = "";


	/**
	 * Armazena se deve ou não mostrar o formulario de busca
	 *
	 * @access protected
	 * @name $_searchFormVisibility
	 * @var boolean
	 */
	protected $_searchFormVisibility = TRUE;

	/**
	 * Armazena os campos auto complete
	 *
	 * @access protected
	 * @name $__autocompletes
	 * @var array
	 */
	protected $__autocompletes = array();

	/**
	 * Armazena o objeto de requisições
	 *
	 * @access protected
	 * @name $_request
	 * @var Zend_Request
	 */
	protected $_request;

	/**
	 * Armazena o objeto da view
	 *
	 * @access protected
	 * @name $view
	 * @var Zend_View
	 */
	protected $view;

	/**
	 * Armazena as queries dos autocompletes
	 *
	 * @access protected
	 * @name $__queryautocomplete
	 * @var array
	 */
	protected $__queryautocomplete = array();

	/**
	 * Armazena os campos de multipla seleção
	 *
	 * @access protected
	 * @name $__multipleselects
	 * @var array
	 */
	protected $__multipleselects = array();

	/**
	 * Inicializador da classe
	 *
	 * @name init
	 */
	public function init() {
		// Busca as colunas do model
		$db = Zend_Registry::get("db");
		
		if($db) {
			$this->__describeTable = $db->describeTable($this->getTableName());
		}

		// Armazena o request
		$fc = Zend_Controller_Front::getInstance();
		$this->_request = $fc->getRequest();

		// Armazena o view
		$this->view = Zend_Registry::get("view");
	}

	/**
	 * Adiciona abas ao formulario
	 *addTab
	 * @name addTab
	 */
	public function addTabCompleta($name, $url, $model, $select=NULL) {
		if(is_null($select)) {
			$select = $model->select();
		}

		$this->__tabscompletas[] = array(
			'model' => $model,
			'name' => $name,
            'url' => $url,
			'select' => $select
		);
	}

    public function getTabsCompletas() {
        return $this->__tabscompletas;
    }



    public function addTab($name, $url) {
        $this->__tabs[] = array(
            'name' => $name,
            'url' => $url,
        );
    }

    public function getTabs() {
        return $this->__tabs;
    }


    /**
	 * Busca os campos de uma tabela do banco de dados
	 *
	 * @name setDynamicFields
	 */
	public function setDynamicFields() {
		// Cria o model dos campos de usuário
		$model = new Admin_Model_Camposusuario();
		$tables = new Admin_Model_Camposusuariotabelas();

		// Cria o select para buscar os campos da tabela
		$select = $model->select()
			->from($model->getTableName(), array('*'))
			->joinUsing($tables->getTableName(), current($tables->getPrimaryField()), array())
			->where("tabela = ?", str_replace("U_", "", $this->getTableName()));

		// Busca os campos da tabela
		$fields = $model->fetchAll($select);
		foreach($fields as $field) {
			// Adiciona o campo ao model
			$this->setCampo("U_" . $field->campo, $field->titulo, $field->descricao, $field->placeholder);

			// Adiciona o campo à lista de campos de usuario
			$this->__userColumns["U_" . $field->campo] = TRUE;

			// Verifica se é uma tabela relacionada
			if($field->idcampo_usuario_tabela_relacionada > 0) {
				$this->setAutocomplete("U_" . $field->campo, "Admin_Model_Dynamic", "", "", "U" . $field->campo);
				$this->setModifier("U_" . $field->campo, array("table" => $field->idcampo_usuario_tabela_relacionada));
			}

			// Verifica o tipo do campo de usuário
			switch($field->idcampo_usuario_tipo) {
				case 3: // Text
					$this->setVisibility("U_" . $field->campo, TRUE, TRUE, FALSE, FALSE);
					break;

				case 5: // Imagem
					$this->setVisibility("U_" . $field->campo, TRUE, TRUE, FALSE, FALSE);
					$this->setModifier("U_" . $field->campo, array('type' => "file", 'preview' => "common/uploads/dynamic", 'destination' => APPLICATION_PATH . "/../common/uploads/dynamic"));
					break;
			}
		}
	}

	/**
	 * Hook para a configuração da tabela
	 *
	 * @access protected
	 * @name _setupTableName
	 */
	protected function _setupTableName() {
		global $application;

		// Chama o parent
		parent::_setupTableName();

		// Busca as opções de configuração
		$options = $application->getOption("resources");
		$prefix = $options['db']['prefix'];

		// Adiciona o prefixo
		$this->_name = $prefix . $this->_name;
	}
	/**
	 * Retorna o nome da tabela
	 *
	 * @name getTableName
	 * @return String
	 */
	public function getTableName() {
		return $this->_name;
	}

	/**
	 * Retorna o nome do esquema
	 *
	 * @name getSchemaName
	 * @return String
	 */
	public function getSchemaName() {
		return $this->_schema;
	}

	/**
	 * Retorna a descrição da tabela
	 *
	 * @name descriveTable
	 * @return array
	 */
	public function describeTable() {
		return $this->__describeTable;
	}

	/**
	 * Retorna se exibe somente o view do model
	 *
	 * @name somenteView
	 * @return array
	 */
	public function getSomenteView() {
		return $this->_somenteView;
	}

	/**
	 * Retorna se exibe gerar xls no list do model
	 *
	 * @name getGerarXlsView
	 * @return array
	 */
	public function getGerarXlsView() {
		return $this->_gerarXls;
	}

	/**
	 * Retorna se exibe gerar pdf no view do model
	 *
	 * @name getGerarPdfView
	 * @return array
	 */
	public function getGerarPdfView() {
		return $this->_gerarPdf;
	}

	/**
	 * Retorna se esconde o botão 'Remover' no list do model
	 *
	 * @name getEsconderBtnRemoverList
	 * @return boolean
	 */
	public function getEsconderBtnRemoverList() {
		return $this->_esconderBtnRemover;
	}

	/**
	 * Retorna se esconde o botão 'Novo' no list do model
	 *
	 * @name getEsconderBtnNovoList
	 * @return boolean
	 */
	public function getEsconderBtnNovoList() {
		return $this->_esconderBtnNovo;
	}

	/**
	 * Retorna se esconde o botão 'Visualizar' no list do model
	 *
	 * @name getEsconderBtnVisualizarList
	 * @return boolean
	 */
	public function getEsconderBtnVisualizarList() {
		return $this->_esconderBtnVisualizar;
	}

	/**
	 * Retorna se esconde o botão 'Filtrar' no list do model
	 *
	 * @name getEsconderBtnFiltrarList
	 * @return boolean
	 */
	public function getEsconderBtnFiltrarList() {
		return $this->_esconderBtnFiltrar;
	}

	/**
	 * Retorna a descrição do campo
	 *
	 * @access protected
	 * @name __getColumnDescription
	 * @param string $name Nome do campo
	 * @return string
	 */
	public function __getColumnDescription($column_name) {
		return $this->__columnsDescription[$column_name];
	}



    /**
     * Retorna o placeholder do campo
     *
     * @access protected
     * @name __getColumnPlaceholder
     * @param string $name Nome do campo
     * @return string
     */
    public function __getColumnPlaceholder($column_name) {
        return $this->__getColumnPlaceholder[$column_name];
    }


    /**
	 * Seta a visibilidade do campo
	 *
	 * @param string $campo Nome da coluna na tabela
	 * @param boolean $cadastro True para aparecer o campo, False para esconder o campo
	 * @param boolean $edicao True para aparecer o campo, False para esconder o campo
	 * @param boolean $busca True para aparecer o campo, False para esconder o campo
	 * @param boolean $listagem True para aparecer o campo, False para esconder o campo
	 */
	public function setVisibility($campo, $cadastro=TRUE, $edicao=TRUE, $busca=TRUE, $listagem=TRUE, $tab='', $array = array()) {
		$this->__columnsVisibility[$campo] = array(
			'insert'	=> $cadastro,
			'update'	=> $edicao,
			'search'	=> $busca,
			'list'		=> $listagem,
            'tab'		=> $tab,
			'dynamicInfo' => $array
		);
	}

	/**
	 * Retorna a visibilidade dos campos ou do campo especificado
	 *
	 * @name getVisibility
	 * @param string $field Nome do campo para retornar a visibilidade
	 * @return string|array
	 */
	public function getVisibility($field=NULL, $type=NULL) {
		// Verifica se retorna todos
		if($field != NULL) {
		if($type == NULL) {
				return $this->__columnsVisibility[$field];
			}
			else {
				return $this->__columnsVisibility[$field][$type];
			}
		}
		else {
			return $this->__columnsVisibility;
		}
	}

	/**
	 * Seta um campo ao model
	 *
	 * @name setCampo
	 * @param string $field Nome do campo
	 * @param string $name Nome do campo
	 * @param string $description Descrição do campo
     * @param string $placeholder Placeholder do campo
	 */
	public function setCampo($field, $name, $description="", $placeholder="") {

		// Adiciona o nome do campo no vetor
		$this->__columnsName[$field] = $name;

		// Adiciona a descrição em um vetor
		$this->__columnsDescription[$field] = $description;

        // Adiciona o placeholder em um vetor
        $this->__columnsPlaceholder[$field] = $placeholder;

		// Adiciona a visibilidade
		$this->setVisibility($field, TRUE, TRUE, TRUE, TRUE);
	}


	/**
	 *
	 */
	public function getCampo() {
		return $this->__columnsName;
	}

	/**
	 * Busca o nome do campo que armazena a chave primaria
	 *
	 * @name getPrimaryField
	 * @return string
	 */
	public function getPrimaryField() {
		return $this->_primary;
	}

	/**
	 * Seta se o formulario de busca será visivel
	 *
	 * @name setSearchFormVisibility
	 * @param boolean $value Valor da visibilidade do formulario
	 */
	public function setSearchFormVisibility($value) {
		$this->_searchFormVisibility = $value;
	}

	/**
	 * Busca a visibilidade do formulario
	 *
	 * @name getSearchFormVisibility
	 * @return boolean
	 */
	public function getSearchFormVisibility() {
		return $this->_searchFormVisibility;
	}

	/**
	 * Seta a columna de descrição
	 *
	 * @name setDescription
	 * @param string $value Nome da coluna que será descrição
	 */
	public function setDescription($value) {
		$this->__descriptionColumn = $value;

		// Adiciona o autocomplete padrão
		$s = $this->select();
		$this->setQueryAutoComplete("default", $s);
	}

	/**
	 * Retorna a columna de descrição
	 *
	 * @name getDescription
	 * @return string
	 */
	public function getDescription() {
		return $this->__descriptionColumn;
	}


    /**
     * Retorna a columna de placeholder
     *
     * @name getPlaceholder
     * @return string
     */
    public function getPlaceholder() {
        return $this->__placeholderColumn;
    }



    /**
	 * Seta um campo auto complete
	 *
	 * @name setAutocomplete
	 * @param string|array $field Nome do campo que será um auto complete
	 * @param string $model Nome da classe que será o model desse auto complete
	 * @param string $ac_name Nome do autocomplete para usar
	 * @param string $middleClass Nome da classe que vai cadastrar os registros
	 */
	public function setAutocomplete($field, $model, $ac_name="default", $middleClass="", $refmap="") {

		// Verifica se é um vetor
		if(is_array($field)) {
			// Adiciona a referencia no vetor de autocompletes
			$this->__autocompletes[$field[0]] = array('model'=>$model, 'ac_name'=>$ac_name, 'middle_model'=>$middleClass, 'field_model'=>$field[1]);

			// Cria a referencia
			$reference = array(
				'columns'		=> array($field[0]),
				'refTableClass'	=> $model,
				'refColumns'	=> array($field[1])
			);
		}
		else {
			// Adiciona a referencia no vetor de autocompletes
			$this->__autocompletes[$field] = array('model'=>$model, 'ac_name'=>$ac_name, 'middle_model'=>$middleClass, 'field_model'=>$field);

			// Cria a referencia
			$reference = array(
				'columns'		=> array($field),
				'refTableClass'	=> $model,
				'refColumns'	=> array($field)
			);
		}

		// Verifica o reference
		if($refmap == "") {
			//$refmap = $model;
			$refmap = $reference['columns'][0];
		}

		// Adiciona o relacionamento
        if(isset($this->_referenceMap[$refmap])) {

        }else{
            $this->_referenceMap[$refmap] = $reference;
        }

		// Armazena os campos de seleção multipla
		if($middleClass != "") {
			$this->__multipleselects[] = $field;
		}
	}

	/**
	 * Retorna os campos de seleção multipla
	 *
	 * @name getMultipleFields
	 * @return array
	 */
	public function getMultipleFields() {
		return $this->__multipleselects;
	}

	/**
	 * Busca um campo auto complete
	 *
	 * @name getAutocomplete
	 * @return array
	 */
	public function getAutocomplete($field=NULL) {
		if($field == NULL) {
			return $this->__autocompletes;
		}
		else {
			return $this->__autocompletes[$field];
		}
	}

	/**
	 * Monta o formulário
	 *
	 * @name getForm
	 * @param gazetamarista_DB_Table $model Modelo à gerar o formulário
	 * @param string $mode Modo do formulário
	 * @return Zend_Form
	 */
	public function getForm($mode="insert") {
	    // Busca as informações da tabela
		$columns = $this->describeTable();

		// Monta a ação do formulario
		$form_action = array();
		$form_action['module'] = $this->_request->getParam("module");
		$form_action['controller'] = $this->_request->getParam("controller");
		switch($mode) {
			case "insert":
			case "update":
				$form_action['action'] = "form";

				// Busca o campo da chave primaria
				$primary_field = $this->getPrimaryField();

				// Cria os parametros
				foreach($primary_field as $field) {
					$form_action[$field] = $this->_request->getParam($field);
				}

				break;
			case "search":
				$form_action['action'] = "search";
				break;
		}

		// Cria a URL do action
		$url = $this->view->url($form_action, NULL, TRUE);

		// Busca as configurações do model
		$column_visibilities = $this->getVisibility();
		$column_names = $this->getCampo();

		// Cria o formulário
		$form = new Zend_Form();
		$form->setAttrib('enctype', 'multipart/form-data')
			->setAttrib('id', 'form_admin')
			->setAttrib('data-abide', '');

		$form->setAction($url)->setMethod("post");
		$form->setDisableLoadDefaultDecorators(TRUE);
		$form->addDecorator("FormElements")
			->addDecorator("HtmlTag", array('tag' => "div"))
			->addDecorator("Form");
		$form->setElementDecorators(array(
			"ViewHelper",
			"Label",
			"Errors",
			new Zend_Form_Decorator_HtmlTag(array('tag' => "div"))
		));

		// Cria o botão submit
		$element = new gazetamarista_Form_Submit("submit");

		// Verifica o modo do formulario
		switch($mode) {
			case "insert":
				$form_label = "Cadastrar";
				break;

			case "update":
				$form_label = "Atualizar";
				break;

			case "search":
				$form_label = "Buscar";
				break;
		}

		//
		$element->setLabel($form_label);
		$element->clearDecorators();

		// Adiciona o botão ao formulário
		$form->addElement($element);

		// Cria o botão submit
		$element = new gazetamarista_Form_Button("cancel");

		//
		$element->setLabel("Cancelar");

		//
		$back_action = array();
		$back_action['module'] = $this->_request->getParam("module");
		$back_action['controller'] = $this->_request->getParam("controller");
		$back_action['action'] = "list";

		//
		if($this->_request->getParam("page", 0) > 0) {
			$back_action['page'] = $this->_request->getParam("page");
		}

		$element->clearDecorators();

		// Adiciona o botão ao formulário
		$form->addElement($element);

		// Muitas quantidades de inputs? Dividir em colunas
			if(count($column_names) > 120) {
				$class_two_columns_rows   = 'small-12 medium-3 large-3 columns ';
				$class_two_columns_inputs = 'small-12 medium-10 large-10 columns end';
			}elseif(count($column_names) > 60) {
				$class_two_columns_rows   = 'small-12 medium-4 large-4 columns ';
				$class_two_columns_inputs = 'small-12 medium-8 large-8 columns end';
			}elseif(count($column_names) > 30) {
				$class_two_columns_rows   = 'small-12 medium-6 large-6 columns ';
				$class_two_columns_inputs = 'small-12 medium-6 large-6 columns end';
			}else{
				$class_two_columns_rows   = '';
				$class_two_columns_inputs = '';
			}

		// Percorre as colunas
		foreach($column_names as $name_name => $column_description) {
			$column_info 			= $columns[$name_name];
			$column_visi 			= $column_visibilities[$name_name];

			// Cria o decorator padrão
				// Verifica o tamanho do campo VARCHAR para setar largura diferente
				$classDivInput = 'small-12 medium-5 large-5 columns end';

				$decorator =
					array(
						array('ViewHelper')
					)
				;

			// Verifica se é um campo visivel
				if($column_visi[$mode] === FALSE) {
					continue;
				}

			// Busca o nome do autocomplete se existir
				$autocomplete = $this->getAutocomplete($name_name);
				$autocomplete_name = $autocomplete['model'];
				$autocomplete_ac_name = $autocomplete['ac_name'];
				$autocomplete_middleclass = $autocomplete['middle_model'];
				$reference_table = $autocomplete_name;

			// Verifica se o autocomplete existe
				if(class_exists($autocomplete_name)) {
					$element = new gazetamarista_Form_Autocomplete($name_name);
					$element->setJQueryParam("source", "");
					$element->setAttrib("data-ac", $autocomplete_name);

					if($autocomplete_ac_name != "default") {
						$element->setAttrib("data-ac_name", $autocomplete_ac_name);
					}

					if($autocomplete_middleclass != "") {
						$element->setAttrib("data-ac_middle", $autocomplete_middleclass);
					}


					// Verifica se existe tabela
					if(strlen($this->_modifiers[$name_name]['table']) > 0) {
						// Cria o model das tabelas relacionadas
						$model = new Admin_Model_Camposusuariotabelasrelacionadas();
						$row = $model->fetchRow(array('idcampo_usuario_tabela = ?' => $this->_modifiers[$name_name]['table']));

						// Instancia a classe model
						$referece_model = new $reference_table("U_" . $row->tabela);

						// Adiciona a tabela
						$element->setAttrib("data-ac_table", $row->tabela);
					} else {
						// Instancia a classe model
						$referece_model = new $reference_table();
					}

					// Busca a coluna descrição
					$description_column = $referece_model->getDescription();
                    $plasceholder_column = $referece_model->getPlaceholder();

					$decorator =
						array(
							array('UiWidgetElement', array('tag' => ''))
						)
					;
					$classDivInput .= ' autocomplete-input';
				} else {
					// Verifica o tipo do campo
					switch($column_info['DATA_TYPE']) {
						case "int":
						case "int4":
						case "int8":
						case "int16":
							$element = new gazetamarista_Form_Integer($name_name);
							$element -> setAttribs(
								array(
									"class" => $column_info['DATA_TYPE'] . " integer",
									"max-length" => $column_info['LENGTH']
								)
							);


							$classDivInput = 'small-12 medium-3 large-1 columns end';
							break;

						case "float":
							$element = new gazetamarista_Form_Integer($name_name);
							$element->setAttribs(
								array(
									"class" => $column_info['DATA_TYPE'] . " float",
									"data-length" => $column_info['LENGTH'],
									"data-decimals" => $column_info['DECIMALS']
								)
							);

							$classDivInput = 'small-12 medium-3 large-1 columns end';
							break;

						case "decimal":
						case "float8":
							$element = new gazetamarista_Form_Decimal($name_name);
							$element -> setAttribs(
								array(
									"data-length" => $column_info['LENGTH'],
									"data-decimals" => $column_info['DECIMALS']
								)
							);

							$classDivInput = 'small-12 medium-3 large-1 columns end';
							break;

						case "tinyint":
						case "bool":
							$element = new gazetamarista_Form_Checkbox($name_name);

							$param_bool = $this->_request->getParam($name_name, "nullabled");

							$decorator =
								array(
									array(
										array('inputnovo' => 'HtmlTag'),
										array(
											'tag' => 'label',
											'for' => $name_name
										)
									),
									array(
										'ViewHelper',
										array(
											"placement" => "prepend"
										)
									),
									array(
										array('input' => 'HtmlTag'),
										array(
											'tag' => 'div',
											'class' => 'switch round small',
                                            'data-filterinput' => $param_bool
										)
									)
								)
							;
							break;

						case "date":
						case "timestamp":
							$element = new gazetamarista_Form_Date($name_name);

							$classDivInput = 'small-12 medium-2 large-2 columns end';
							break;

						case "datetime":
							$element = new gazetamarista_Form_DateTime($name_name);

							$classDivInput = 'small-12 medium-2 large-2 columns end';
							break;

						case "text":
						case "longblob":							
							$pagina_mode = $mode;
							$pagina_action = $this->_request->getParam("action", "");
							
							if($pagina_mode == "search") {
							//if($pagina_action == "list") {
								$element = new gazetamarista_Form_Text($name_name);
							}else{
								$element = new gazetamarista_Form_Textarea($name_name);
							}

							if($pagina_mode == "search") {
								$classDivInput = 'small-12 medium-3 large-4 columns end';
							}else{
								$classDivInput = 'small-12 medium-5 large-5 columns end';
							}
							break;

						case "varying":
						case "varchar":
						default:
							// Verifica o tamanho do campo
							if( $column_info['LENGTH'] <= 6 ) {
								$classDivInput = 'small-12 medium-2 large-1 columns end';
							}else if( $column_info['LENGTH'] <= 30 ) {
								$classDivInput = 'small-12 medium-2 large-2 columns end';
							}else if( $column_info['LENGTH'] <= 60 ) {
								$classDivInput = 'small-12 medium-2 large-3 columns end';
							}else if( $column_info['LENGTH'] <= 100 ) {
								$classDivInput = 'small-12 medium-3 large-4 columns end';
							}else{
								$classDivInput = 'small-12 medium-4 large-5 columns end';
							}

							// Verifica se é o campo ENUM
							if( strtolower(substr($column_info['DATA_TYPE'], 0, 4)) == "enum" ) {
								$classDivInput = 'small-12 medium-4 large-5 columns end';
							}

							// Verifica se é campo senha
							if($this->_modifiers[$name_name]['type'] == "password") {
								$element = new gazetamarista_Form_Password($name_name);
								$element->setAttribs(array("class" => $column_info['DATA_TYPE'] . " string password"));
								$classDivInput = 'small-12 medium-2 large-2 columns end';
							}
							
							// Verifica se é campo file
							elseif($this->_modifiers[$name_name]['type'] == "file") {
								$element = new gazetamarista_Form_File($name_name);
								$element -> setAttribs(array("class" => $column_info['DATA_TYPE'] . " file"));

								// Seta o destino do arquivo
								$element -> setDestination($this->_modifiers[$name_name]['destination']);

								// Armazena dados do arquivo
            					$arquivo_nome 		= $_FILES[$name_name]['name'];
            					$arquivo_extensao   = end(explode(".", $arquivo_nome));

            					// Slug helper
            					$slug 	   = new gazetamarista_View_Helper_CreateSlug();
            					$nome_slug = $slug->createslug(str_replace(".".$arquivo_extensao, "", $arquivo_nome));	

								if($this->_modifiers[$name_name]['equalfilename'] == true) {
            					    // Cria nome igual do arquivo
            					    $filename = substr($nome_slug,0,45) . "-" . substr(time(),-5) . "." . $arquivo_extensao;
                                }else{
            					    // Cria nome aleatório do arquivo
								    $filename = md5(time() . rand(0, 99999)) . substr($_FILES[$name_name]['name'], strrpos($_FILES[$name_name]['name'], "."));
                                }

								// Destino do arquivo e sobrescreve caso exista
								$element -> addFilter("Rename", array(
									'target' 	=> $this->_modifiers[$name_name]['destination'] . "/" . $filename,
									'overwrite' => true
								));

								// Verifica se está atualizando o registro
									$classDivInput = 'small-12 medium-3 large-5 columns end';
									$nData = 
									array(
										array(
											'botao' => 'HtmlTag',
										),
										array(
											'tag' => 'label',
											'class' => 'input-file-upload button'
										)
									);

									if($mode == "update") {
										if($this->_modifiers[$name_name]['preview']) {
											$select = $this->select();

											// Cria os parametros
											foreach($primary_field as $field) {
												$param = $this->_request->getParam($field, 0);
												if($param > 0) {
													$select->where($field . " = ?")->bind($param);
												}
											}
											$arquivo = $this->fetchAll($select)->current()->$name_name;
											if( file_exists($this->_modifiers[$name_name]['preview'] . "/" . $arquivo) && !empty($arquivo)) {											
												$nData = 
												array(
													array(
														'botao' => 'HtmlTag',
													),
													array(
														'tag' => 'label',
														'class' => 'input-file-upload medium button',
														'data-preview' => $this->_modifiers[$name_name]['preview'] . "/" . $arquivo,
														'data-delete' => '?' . $field . '=' . $param . '&field='. $name_name
													)
												);
											}
										}
									}

								$decorator =
									array(
										array('File'),
										$nData
									)
								;
							}
							else {
								$element = new gazetamarista_Form_Text($name_name);
								$element -> setAttribs(
									array(
										"class" => $column_info['DATA_TYPE'] . " string"
									)
								);
							}
							break;
					}
				}
				
				if( !empty($column_visi['dynamicInfo']['nclass']) ){
					$classDivInput = $column_visi['dynamicInfo']['nclass'];
					unset($column_visi['dynamicInfo']['nclass']);
				}

				if( !empty($column_visi['dynamicInfo']['class']) ){
					$classDivInput .= ' '.$column_visi['dynamicInfo']['class'];
					unset($column_visi['dynamicInfo']['class']);
				}

                if( !empty($column_visi['dynamicInfo']['data-information']) ){
                    $DivInfo = $column_visi['dynamicInfo']['data-information'];
                    unset($column_visi['dynamicInfo']['data-information']);
                }else{
                    $DivInfo = null;
                }

			$classes = $element -> getAttrib("class");

			$element -> setAttribs(
				array(
					"class" => $classes . ' ' . $column_visi['dynamicInfo']['inputclass'] . " radius",
				)
			);

			unset($column_visi['dynamicInfo']['inputclass']);

			if(!empty($column_visi['dynamicInfo'])){
				$element -> setAttribs($column_visi['dynamicInfo']);
			}

			// Verifica se precisa obrigatoriedade no forumulário
				$obrigatorio = '';
				if($mode != "search" && !$column_info['NULLABLE']) {
					$obrigatorio = ' *';
					$element
						-> setRequired(!$column_info['NULLABLE'])
						-> setAttribs(array("required" => ''));
				}

			// Verifica se é um autocomplete, e ja tem valor
				$label = $this->_request->getParam($name_name."_label", -1);
				if(($label > -1) || (strlen($description_column) > 0)) {
					$description = "";
					if(($mode == "update") && ($reference_table != NULL)) {

						// Busca o campo da chave primaria
						$primary_field = $this->getPrimaryField();

						$select = $this->select();

						// Cria os parametros
						foreach($primary_field as $field) {
							$param = $this->_request->getParam($field, 0);
							if($param > 0) {
								$select->where($field . " = ?")->bind($param);
							}
						}

						if($autocomplete_middleclass == "") {
							try {
								// Primary key
								$fetch_primary = implode(",",$referece_model->_primary);

								// Busca o registro
								if($fetch_primary != "") {
									$result = $referece_model->fetchRow(array(implode(",",$referece_model->_primary) . " = ?" => $this->fetchRow($select)->$name_name));
								}else{
									$result = $referece_model->fetchRow(array('idkey = ?' => $this->fetchRow($select)->$name_name));
								}

								if($result !== NULL) {
									// Verifica se existe o modifier 'concatenar_autocomplete'
									$modifier_concatenar_autocomplete = $referece_model->_modifiers['concatenar_autocomplete_'.$fetch_primary];
									if(isset($modifier_concatenar_autocomplete)) {
										$mod_campo_secundario = $modifier_concatenar_autocomplete['campoSecundario'];
										if(!empty($mod_campo_secundario)) {
											if(!empty($modifier_concatenar_autocomplete['divisoria'])) {
												$mod_campo_divisoria  = $modifier_concatenar_autocomplete['divisoria'];
											}else{
												$mod_campo_divisoria = " ";
											}

											// Armazena o valor, concatenando com divisória e campo secundário
											$description = $result->$description_column . $mod_campo_divisoria . $result->$mod_campo_secundario;
										}else{
											// Armazena o valor
											$description = $result->$description_column;
										}
									}else{
										// Armazena o valor
										$description = $result->$description_column;
									}
								}
							}
							catch(Exception $e) {
								try {
									$description = $this->fetchAll($select)->current()->findParentRow($reference_table)->$description_column;
								}
								catch(Exception $e) {
									$description = "";
								}
							}
						} else {

							$reference_model = new $reference_table();
							$reference_description = $reference_model->getDescription();
							$reference_field = current($reference_model->getPrimaryField());
							$toJson = array();
							foreach($this->fetchAll($select)->current()->findDependentRowset($autocomplete_middleclass) as $row) {
								$toJson[] = array('value' => $row->$reference_field, 'label' => $row->findParentRow($reference_table)->$reference_description);
							}

							$element->setAttrib("data-json_values", json_encode($toJson));
						}
					}

					$element->setAttrib("data-ac_label", $this->_request->getParam($name_name . "_label", $description));
				}

			// Cria o elemento nome
				if($column_names[$name_name] == NULL) {
					continue;
				}

			$labelDiv = 'small-12 medium-12 large-12 columns labeldiv';
			if($mode == "search") {
				$labelDiv = 'small-12 medium-12 large-12 columns labeldiv';
			}

			// Montando os Decoradores
				// Limpa todos os decoradores
				$element -> clearDecorators();
				// Adiciona os descoradores padrões
				$element -> setDecorators( 
					$decorator 
				);
				$element -> addDecorators(
					array(
						array(
							array('data' => 'HtmlTag'),
							array(
								'tag' => 'div',
								'class' => 'input-form ' . (!empty($class_two_columns_inputs) ? $class_two_columns_inputs : $classDivInput)
							)
						),
						array(
							'Label',
							array(
								'tag' => 'div', 
								'escape' => FALSE, 
								'tagOptions' => array( 
									'class' => $labelDiv, 
									'id' =>  "label-" . $name_name
								) 
							)
						),
						array(
							array('row' => 'HtmlTag'),
							array('tag' => 'div', 'class' => "row")
						),
						array(
							'row' => 'HtmlTag',
							array('tag' => 'div', 'class' => $class_two_columns_rows . "element-form", 'id'=>"element-" . $name_name)
						),
						array('Description'),
						array('Errors')
					)
				);

				if(class_exists($autocomplete_name)) {
				    $element -> setLabel($column_names[$name_name] . $obrigatorio . " <small> " . $this->__getColumnDescription($name_name) . "</small> <i class='autocomplete-info mdi mdi-information' data-msg='$DivInfo'> </i>");
				}else{
				    if(!empty($DivInfo)){
                        $element -> setLabel($column_names[$name_name] . $obrigatorio . " <small> " . $this->__getColumnDescription($name_name) . "</small> <i class='show_input_information mdi mdi-information' data-msg='$DivInfo'></i>");
                    }else{
                        $element -> setLabel($column_names[$name_name] . $obrigatorio . " <small> " . $this->__getColumnDescription($name_name) . "</small>");
                    }
				}

                if( !empty($column_visi['tab']) ){
                    $classteste = $column_visi['tab'];
                    unset($column_visi['tab']);

                    $element -> setAttribs(array('tab' => $classteste));
                }

			// Seta os decoradores do view
				// $element->setDecorators($decorator);
				// 
			$dfile = $element -> getDecorator('File');
			if( !empty( $dfile ) ){
				$botao = $element -> getDecorator('botao');
				$botao -> setPlainText('Selecione um arquivo');
			}

			// Verifica se está no modo de busca
			if($mode == "search") {
				$element->setAttrib("placeholder", "Buscar " . $column_names[$name_name]);
			}else{

                $element->setAttrib("placeholder", $this->__getColumnPlaceholder($name_name));
            }

			// Verifica se o campo é um campo de usuário
			if($this->__userColumns[$name_name] === TRUE) {
				$element->setAttrib("data-userfield", "true");
			}

			// Adiciona o elemento ao formulário
			$form->addElement($element);
		}

		// Retorna o formulário
		return $form;
	}

	/**
	 * Seta o autocomplete na lista
	 *
	 * @name setQueryAutoComplete
	 * @param string $name Nome do autocomplete
	 * @param Zend_Db_Table_Select $select Objeto de manipulação de query
	 */
	public function setQueryAutoComplete($name, $select) {
		$this->__queryautocomplete[$name] = $select;
	}

	/**
	 * Busca a query do autocomplete na lista
	 *
	 * @name getQueryAutoComplete
	 * @param string $name Nome do autocomplete
	 * @return Zend_Db_Table_Select
	 */
	public function getQueryAutoComplete($name) {
		return $this->__queryautocomplete[$name];
	}

	/**
	 * Seta o modificador do campo
	 *
	 * @name setModifier
	 * @param string $field Campo para aplicar o modificador
	 * @param array $modifier Vetor contendo os modificadores
	 */
	public function setModifier($field, $modifier) {
		// Verifica se o modificador ja existe
		if(!isset($this->_modifiers[$field])) {
			$this->_modifiers[$field] = $modifier;
		}
		else {
			// Concatena mais um modificador
			$this->_modifiers[$field] = array_merge($this->_modifiers[$field], $modifier);
		}
	}

	/**
	 * Busca o modificador do campo
	 *
	 * @name getModifier
	 * @param string $field Campo para buscar o modificador
	 */
	public function getModifier($field) {
		// Retorna os modificadores
		return $this->_modifiers[$field];
	}

	/**
	 * Busca a posiçao do campo no formulario
	 *
	 * @name getPosition
	 * @param string $field Nome do campo para buscar a posição
	 * @return string
	 * @todo Pensar numa forma de como saber se está editado ou inserindo
	 */
	public function getPosition($field) {
		// Inicializa a posição
		$position = 0;

		// Percorre as colunas
		foreach($this->__columnsName as $fieldName => $fieldDescription) {
			// Busca a visibilidade
			$action = $this->_request->getParam("action", "index");
			if($action == "list") {
				$mode = "search";
			} elseif($action == "form") {
				if(1) {
					$mode = "insert";
				}
				else {
					$mode = "update";
				}
			}

			// Verifica a visibilidade do campo
			if($this->__columnsVisibility[$fieldName][$mode]) {
				// Soma mais uma posição se for visivel
				$position++;
			}

			// Verifica se encontrou a posição
			if($fieldName == $field) {
				return $position;
			}
		}
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
}
