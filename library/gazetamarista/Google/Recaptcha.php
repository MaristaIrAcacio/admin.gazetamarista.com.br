<?phpgazetamaristagazetamaristagazetamarista

/**
 * Validação google recaptcha
 *
 * @name gazetamarista_Google_Recaptcha
 */
class gazetamarista_Google_Recaptcha {
    /**
     * Armazena a SECRET KEY
     *
     * @access protected
     * @name $_secret_key_recaptcha
     * @var string
     */
    protected $_secret_key_recaptcha = "";

    /**
     * Armazena o SITE KEY
     *
     * @access protected
     * @name $_site_key_recaptcha
     * @var string
     */
    protected $_site_key_recaptcha = "";

    /**
     * Response do Recaptcha
     *
     * @access protected
     * @name $_response
     * @var string
     */
    protected $_response = null;

	/**
	 * Construtor da classe
	 *
	 * @name __construct
	 */
	public function __construct() {
        // Busca secret key
        $model_config = new Admin_Model_Configuracoes();
        $configuracao = $model_config->fetchRow(array("idconfiguracao = 1"));
        if ($configuracao) {
            $this->_secret_key_recaptcha = $configuracao->recaptcha_secret;
        }
	}

	/**
     * Validação google recaptcha
     *
     * @param $gRecaptchaResponse
     * @return booleans
     */
	public function verifyRecaptchaGoogle($gRecaptchaResponse) {
	    if(!empty($this->_secret_key_recaptcha)) {
            // Biblioteca
            require_once 'gazetamarista/Library/recaptchalib.php';

            $verify = new recaptchalib($this->_secret_key_recaptcha, $gRecaptchaResponse);

            // Return
            return $verify->isValid();
        }else{
	        // Return
	        return false;
        }
	}
}