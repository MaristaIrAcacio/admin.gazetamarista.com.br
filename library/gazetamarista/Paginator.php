<?php

class gazetamarista_Paginator extends Zend_Paginator {
	public $next = 0;
	public $total_items = 0;
	public $total_pages = 0;
	public $next_page = 0;
	public $previous_page = 0;
	public $current_page = 0;
	
	public function __construct($data, $adapter = self::INTERNAL_ADAPTER, array $prefixPaths = null) {
		if ($data instanceof Zend_Paginator_AdapterAggregate) {
			parent::__construct($data->getPaginatorAdapter());
		} else {
			if ($adapter == self::INTERNAL_ADAPTER) {
				if (is_array($data)) {
					$adapter = 'Array';
				} else if ($data instanceof Zend_Db_Table_Select) {
					$adapter = 'DbTableSelect';
				} else if ($data instanceof Zend_Db_Select) {
					$adapter = 'DbSelect';
				} else if ($data instanceof Iterator) {
					$adapter = 'Iterator';
				} else if (is_integer($data)) {
					$adapter = 'Null';
				} else {
					$type = (is_object($data)) ? get_class($data) : gettype($data);
		
					/**
					 * @see Zend_Paginator_Exception
					 */
					require_once 'Zend/Paginator/Exception.php';
		
					throw new Zend_Paginator_Exception('No adapter for type ' . $type);
				}
			}
		
			$pluginLoader = self::getAdapterLoader();
		
			if (null !== $prefixPaths) {
				foreach ($prefixPaths as $prefix => $path) {
					$pluginLoader->addPrefixPath($prefix, $path);
				}
			}
		
			$adapterClassName = $pluginLoader->load($adapter);
		
			parent::__construct(new $adapterClassName($data));
		}
	}
	
	public function assign() {
		// Busca a pagina atual
		$this->current_page = parent::getCurrentPageNumber();
		$per_page = parent::getItemCountPerPage();
		
		// Busca o total de paginas
		$this->total_pages = (int)(parent::getTotalItemCount() / parent::getItemCountPerPage());
		$this->total_pages++;
		
		// Busca o total
		$this->total_items = parent::getTotalItemCount();
		
		// Verifica o total
		if($this->total_items % $per_page == 0) {
			$this->total_pages--;
		}
		
		// Busca a pagina anterior
		$this->previous_page = $this->current_page - 1;
		if($this->previous_page <= 0) {
			$this->previous_page = 1;
		}
		
		// Busca a proxima pagina 
		$this->next_page = $this->current_page + 1;
		if($this->next_page > $this->total_pages) {
			$this->next_page = $this->total_pages;
		}
		
		return $this;
	}
}