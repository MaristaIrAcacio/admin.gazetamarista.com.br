<?php

/*----------------------------------------------
 * Funções helpers
 ----------------------------------------------*/

if (!function_exists('dd')) {
    /**
     * Debug variavel
     *
     * @param      $var
     * @param bool $var_dump
     *
     * @return void
     */
    function dd($var, $var_dump = false)
    {
        echo '<pre>';
        if ($var_dump) {
            Zend_Debug::dump($var);
        } else {
            print_r($var);
        }
        echo '</pre>';
        die(1);
    }
}

if (!function_exists('thumb_existe')) {
    /**
     * Verifica se exite uma thumb
     *
     * @param $tipo
     * @param $arquivo
     *
     * @return bool
     */
    function thumb_existe($tipo, $arquivo)
    {
        return ($arquivo and is_file('common/uploads/' . $tipo . '/' . $arquivo)) === true;
    }
}

if (!function_exists('thumb')) {
    /**
     * Gera thumb
     *
     * @param        $tipo
     * @param        $arquivo
     * @param int $crop
     * @param int $largura
     * @param int $altura
     * @param string $fallback
     *
     * @return string
     */
    function thumb($tipo, $arquivo, $crop = 1, $largura = 0, $altura = 0, $fallback = 'not_found_img.jpg')
    {
        $arquivo_final = $arquivo;
        
        if (!$arquivo or !is_file('common/uploads/' . $tipo . '/' . $arquivo)) {
            $tipo = 'default';
            $arquivo_final = $fallback;
        }
        
        return (new Zend_View_Helper_Url())->url(['tipo' => $tipo, 'crop' => $crop, 'largura' => $largura, 'altura' => $altura, 'imagem' => $arquivo_final], 'imagem', true);
    }
}

if (!function_exists('url')) {
    /**
     * Gera url
     *
     * @param mixed $name The name of a Route to use. If null it will use the current Route
     * @param array $urlOptions Options passed to the assemble method of the Route object.
     * @param bool $reset Whether or not to reset the route defaults with those provided
     * @param bool $encode
     * @return string Url for the link href attribute.
     */
    function url($name = null, array $urlOptions = [], $reset = true, $encode = true)
    {
        foreach ($urlOptions as $key => $urlOption) {
            if ($key === 'slug') {
                $urlOptions[$key] = (new gazetamarista_View_Helper_CreateSlug())->createslug($urlOption);
            }
        }
        
        return (new Zend_View_Helper_Url())->url($urlOptions, $name, $reset, $encode);
    }
}

if (!function_exists('redirect_route')) {
    /**
     * Redireciona para rota
     *
     * @param mixed $name The name of a Route to use. If null it will use the current Route
     * @param array $urlOptions Options passed to the assemble method of the Route object.
     * @param bool $reset Whether or not to reset the route defaults with those provided
     */
    function redirect_route($name = null, array $urlOptions = [], $reset = true)
    {
        foreach ($urlOptions as $key => $urlOption) {
            if ($key === 'slug') {
                $urlOptions[$key] = (new gazetamarista_View_Helper_CreateSlug())->createslug($urlOption);
            }
        }
        
        // Redireciona
        (new Zend_Controller_Action_Helper_Redirector())->gotoRouteAndExit($urlOptions, $name, $reset);
    }
}

if (!function_exists('current_url')) {
    /**
     * Gera a url atual
     *
     * @return string|string[]
     * @throws Zend_Exception
     */
    function current_url()
    {
        $basePath = Zend_Registry::get("config")->gazetamarista->config->basepath;
        
        $url = $basePath . Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();
        
        // Remove o basePath duplicado
        if (starts_with($url, $basePath . $basePath)) {
            $url = str_replace($basePath . $basePath, $basePath, $url);
        }
        
        return $url;
    }
}

if (!function_exists('youtube_id')) {
    /**
     * Pego id do video do youtube pela url
     *
     * @param $url
     *
     * @return mixed|null
     */
    function youtube_id($url)
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        
        return $matches[1] ?? null;
    }
}

if (!function_exists('youtube_url_embed')) {
    /**
     * Gera o embed do youtube
     *
     * @param      $url
     * @param bool $autoplay
     *
     * @return string
     */
    function youtube_url_embed($url, $autoplay = true)
    {
        $id = youtube_id($url);
        
        if (!$id) {
            return null;
        }
        
        return 'https://www.youtube-nocookie.com/embed/' . $id . '?autoplay=' . ($autoplay ? 1 : 0) . '&showinfo=0&rel=0&modestbranding=1&playsinline=1';
    }
}

if (!function_exists('youtube_image')) {
    /**
     * Get image
     *
     * @param $url
     * @param $fallback
     *
     * @return string
     */
    function youtube_image($url, $fallback = 'common/uploads/default/not_found_img.jpg')
    {
        $id = youtube_id($url);
        
        if ($id) {
            return 'https://img.youtube.com/vi/' . $id . '/0.jpg';
        }
        
        return $fallback;
    }
}

if (!function_exists('str_limit')) {
    /**
     * Limta o número de caracteres na string
     *
     * @param string $value
     * @param int $limit
     * @param string $end
     *
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }
}

if (!function_exists('starts_with')) {
    /**
     * Verifica se a string começa com
     *
     * @param string $haystack - Texto completo
     * @param string|string[] $needles - Pesquisar por, pode ser array ai pesquisará por qualquer um
     *
     * @return bool
     */
    function starts_with($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('ends_with')) {
    /**
     * Verifica se a string termina com
     *
     * @param string $haystack - Texto completo
     * @param string|string[] $needles - Pesquisar por, pode ser array ai pesquisará por qualquer um
     *
     * @return bool
     */
    function ends_with($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ($needle !== '' && substr($haystack, -strlen($needle)) === (string)$needle) {
                return true;
            }
        }
        
        return false;
    }
}

if (!function_exists('valida_form')) {
    /**
     * Validação de form
     *
     * Validações
     * required
     * email
     * url
     * integer
     * decimal
     * numeric
     * alpha_numeric
     * array
     * base64
     * min (min:10) - Número
     * max (max:10) - Número
     * min_lenght (min_lenght:10)
     * max_lenght (max_lenght:10)
     * min_words (min_words:10)
     * max_words (max_words:10)
     * cep (99999-999)
     * phone ((99) 9999-9999 ou (99) 99999-9999)
     * cellphone ((99) 99999-9999)
     * latitude
     * longitude
     * youtube
     * date_format (date_format:d/m/Y) - Formato validado pela classe DateTime
     * cpf - CPF 999.999.999-99 14 caracteres
     * cpf_only_number - CPF 9999999999 só números 11 caracteres
     * cnpj - CNPJ 99.999.999/9999-99 18 caracteres
     * cnpj_only_number - CNPJ 99999999999999 só números 14 caracteres
     * cpf_cnpj - CPF 999.999.999-99 14 caracteres ou CNPJ 99.999.999/9999-99 18 caracteres
     * cpf_cnpj_only_number - CPF 9999999999 só números 11 caracteres ou CNPJ 99999999999999 só números 14 caracteres
     * in_list - array de valores
     *
     * <code>
     *    $form = valida_form([
     *        [
     *            'campo'  => 'assunto',
     *            'label'  => 'Assunto',
     *            'regras' => [
     *                'required',
     *                'in_list' => [
     *                     'Assunto 1',
     *                     'Assunto 2',
     *                     'Assunto 3',
     *                 ],
     *            ],
     *        ],
     *        [
     *            'campo'  => 'nome',
     *            'label'  => 'Nome',
     *            'regras' => [
     *                'required',
     *            ],
     *        ],
     *        [
     *            'campo'  => 'telefone',
     *            'label'  => 'Telefone',
     *            'regras' => [
     *                'required',
     *                'phone',
     *            ],
     *        ],
     *        [
     *            'campo'  => 'email',
     *            'label'  => 'E-mail',
     *            'regras' => [
     *                'required',
     *                'email',
     *            ],
     *        ],
     *        [
     *            'campo'  => 'mensagem',
     *            'label'  => 'Mensagem',
     *            'regras' => [
     *                'required',
     *            ],
     *        ],
     *        [
     *            'campo'  => 'nascimento',
     *            'label'  => 'Data de nascimento',
     *            'regras' => [
     *                'required',
     *                'date_format:d/m/Y',
     *            ],
     *        ],
     *        [
     *            'campo'  => 'cpf',
     *            'label'  => 'CPF',
     *            'regras' => [
     *                'required',
     *                'cpf',
     *            ],
     *        ],
     *    ]);
     *
     *    if( !$form['valido'] )
     *    {
     *        $resposta['status']   = 'erro';
     *        $resposta['titulo']   = 'Ocorreu um erro!';
     *        $resposta['mensagem'] = $form['erro'];
     *
     *        $this->_helper->json($resposta);
     *    }
     *
     *    // Complemento dos dados
     *    $form['dados']['data'] = new Zend_Db_Expr('NOW()');
     *    $form['dados']['ip']   = $this->getRequest()->getClientIp(true);
     *
     *    // Salva no banco
     *    $id = (new Admin_Model_Contatos())->insert($form['dados']);
     * </code>
     *
     * @param array $campos
     *
     * @return array
     */
    function valida_form(array $campos)
    {
        $sanitize = new gazetamarista_Sanitize();
        
        $retorno = [
            'valido' => true,
            'erro' => null,
            'campos' => $campos,
            'dados' => [],
        ];
        
        $mensagens = [
            'required' => '%s é obrigatório',
            'email' => '%s deve conter um e-mail válido',
            'url' => '%s deve conter uma url válida',
            'integer' => '%s deve ser número inteiro',
            'decimal' => '%s deve ser número decimal',
            'numeric' => '%s deve ser alpha-numérico',
            'alpha_numeric' => '%s deve ser numérico',
            'array' => '%s deve conter um array',
            'base64' => '%s deve conter um código base64',
            'min' => '%s deve ser maior que %s',
            'max' => '%s deve ser menor que %s',
            'min_lenght' => '%s deve conter no mínimo %s caracteres',
            'max_lenght' => '%s não deve ter mais que %s caracteres',
            'min_words' => '%s deve conter no mínimo %s palavras',
            'max_words' => '%s não deve ter mais que %s palavras',
            'cep' => '%s deve ser no formato 99999-999',
            'phone' => '%s deve ser no formato (99) 9999-9999 ou (99) 99999-9999.',
            'cellphone' => '%s deve ser no formato (99) 99999-9999',
            'latitude' => '%s deve conter uma latitude válida',
            'longitude' => '%s deve conter uma longitude válida',
            'youtube' => '%s deve ser uma url de vídeo do YouTube válida',
            'date_format' => '%s não corresponde ao formato "%s"',
            'cpf' => '%s não contém um CPF válido',
            'cpf_only_number' => '%s não contém um CPF válido',
            'cnpj' => '%s não contém um CNPJ válido',
            'cnpj_only_number' => '%s não contém um CNPJ válido',
            'cpf_cnpj' => '%s não contém um CPF/CNPJ válido',
            'cpf_cnpj_only_number' => '%s não contém um CPF/CNPJ válido',
            'in_list' => '%s não contém um valor válido',
        ];
        
        foreach ($campos as $key => $campo) {
            $valor = $sanitize->sanitizestring(Zend_Controller_Front::getInstance()->getRequest()->getParam($campo['campo']), 'search');
            $valido = true;
            $erro_validacao = null;
            $erro_mensagem = null;
            
            foreach ($campo['regras'] as $regra_key => $regra) {
                // Obrigatório
                if ($regra === 'required') {
                    if ((is_array($valor) and !count($valor)) or trim($valor) === '') {
                        $valido = false;
                    }
                } // E-mail
                elseif ($regra === 'email' and trim($valor) !== '' and !filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                    $valido = false;
                } // Url
                elseif ($regra === 'url' and trim($valor) !== '' and !filter_var($valor, FILTER_VALIDATE_URL)) {
                    $valido = false;
                } // Alpha numerico
                elseif ($regra === 'alpha_numeric' and trim($valor) !== '' and ctype_alnum((string)$valor)) {
                    $valido = false;
                } // Inteiro
                elseif ($regra === 'integer' and trim($valor) !== '' and !((bool)preg_match('/^[\-+]?[0-9]+$/', $valor))) {
                    $valido = false;
                } // Decimal
                elseif ($regra === 'decimal' and trim($valor) !== '' and !((bool)preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $valor))) {
                    $valido = false;
                } // Numerico
                elseif ($regra === 'numeric' and trim($valor) !== '' and !((bool)preg_match('/^[\-+]?[0-9]*\.?[0-9]+$/', $valor))) {
                    $valido = false;
                } // Array
                elseif ($regra === 'array' and trim($valor) !== '' and !is_array($valor)) {
                    $valido = false;
                } // Base64
                elseif ($regra === 'base64' and trim($valor) !== '' and !(base64_encode(base64_decode($valor)) === $valor)) {
                    $valido = false;
                } // Mínimo número
                elseif (starts_with($regra, 'min:') and trim($valor) !== '') {
                    $param = explode(':', $regra)[1];
                    
                    if (!(is_numeric($valor) ? ($valor > $param) : false)) {
                        $valido = false;
                    }
                } // Máximo número
                elseif (starts_with($regra, 'max:') and trim($valor) !== '') {
                    $param = explode(':', $regra)[1];
                    
                    if (!(is_numeric($valor) ? ($valor < $param) : false)) {
                        $valido = false;
                    }
                } // Min lenght
                elseif (starts_with($regra, 'min_lenght:') and trim($valor) !== '') {
                    $param = explode(':', $regra)[1];
                    
                    if (strlen($valor) < $param) {
                        $valido = false;
                    }
                } // Max lenght
                elseif (starts_with($regra, 'max_lenght:') and trim($valor) !== '') {
                    $param = explode(':', $regra)[1];
                    
                    if (strlen($valor) > $param) {
                        $valido = false;
                    }
                } // Min words
                elseif (starts_with($regra, 'min_words:') and trim($valor) !== '') {
                    $param = explode(':', $regra)[1];
                    
                    if (str_word_count($valor) < $param) {
                        $valido = false;
                    }
                } // Max words
                elseif (starts_with($regra, 'max_words:') and trim($valor) !== '') {
                    $param = explode(':', $regra)[1];
                    
                    if (str_word_count($valor) > $param) {
                        $valido = false;
                    }
                } // Cep
                elseif ($regra === 'cep' and trim($valor) !== '' and !preg_match('/^[0-9]{5}[-][0-9]{3}$/', $valor)) {
                    $valido = false;
                } // Telefone
                elseif ($regra === 'phone' and trim($valor) !== '' and !preg_match('/^\([0-9]{2}\) [0-9]{4,5}[-][0-9]{4}$/', $valor)) {
                    $valido = false;
                } // Celular
                elseif ($regra === 'cellphone' and trim($valor) !== '' and !preg_match('/^\([0-9]{2}\) [0-9]{5}[-][0-9]{4}$/', $valor)) {
                    $valido = false;
                } // Latitude
                elseif ($regra === 'latitude' and trim($valor) !== '' and !preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,11})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,11})?))$/', $valor)) {
                    $valido = false;
                } // Longitude
                elseif ($regra === 'longitude' and trim($valor) !== '' and !preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,11})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,11})?))$/', $valor)) {
                    $valido = false;
                } // Youtube url
                elseif ($regra === 'youtube' and trim($valor) !== '') {
                    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $valor, $matches);
                    
                    if (!isset($matches[1])) {
                        $valido = false;
                    }
                } // Date format
                elseif (starts_with($regra, 'date_format:') and trim($valor) !== '') {
                    $param = explode(':', $regra)[1];
                    
                    if (!is_string($valor) && !is_numeric($valor)) {
                        $valido = false;
                    } else {
                        // Cria a data
                        $data_teste = DateTime::createFromFormat('!' . $param, $valor);
                        
                        if (!($data_teste && $data_teste->format($param) == $valor)) {
                            $valido = false;
                        }
                    }
                } // CPF
                elseif (($regra === 'cpf' or $regra === 'cpf_only_number') and trim($valor) !== '') {
                    $valor_final = preg_replace('/\D/', '', $valor);
                    
                    if ($regra === 'cpf_only_number' and strlen($valor) !== 11) {
                        $valido = false;
                    } elseif (strlen($valor) !== 14) {
                        $valido = false;
                    } else {
                        $valido = valida_cpf($valor_final);
                    }
                } // CNPJ
                elseif (($regra === 'cnpj' or $regra === 'cnpj_only_number') and trim($valor) !== '') {
                    $valor_final = preg_replace('/\D/', '', $valor);
                    
                    if ($regra === 'cnpj_only_number' and strlen($valor) !== 14) {
                        $valido = false;
                    } elseif (strlen($valor) !== 18) {
                        $valido = false;
                    } else {
                        $valido = valida_cnpj($valor_final);
                    }
                } // CPF/CNPJ
                elseif (($regra === 'cpf_cnpj' or $regra === 'cpf_cnpj_only_number') and trim($valor) !== '') {
                    $valor_final = preg_replace('/\D/', '', $valor);
                    
                    // CPF
                    if (($regra === 'cpf_cnpj_only_number' and strlen($valor) === 11) or ($regra !== 'cpf_cnpj_only_number' and strlen($valor) === 14)) {
                        $valido = valida_cpf($valor_final);
                    } // CNPJ
                    elseif (($regra === 'cpf_cnpj_only_number' and strlen($valor) === 14) or ($regra !== 'cpf_cnpj_only_number' and strlen($valor) === 18)) {
                        $valido = valida_cnpj($valor_final);
                    } else {
                        $valido = false;
                    }
                } // Regras que são array
                elseif (is_array($regra)) {
                    // Valor do array
                    $regra_array = $regra;
                    
                    // A chave é a regra
                    $regra = $regra_key;
                    
                    // Lista
                    if ($regra === 'in_list' and trim($valor) !== '') {
                        if (!in_array($valor, $regra_array)) {
                            $valido = false;
                        }
                    }
                }
                
                // Se já for inválido, pára
                if (!$valido) {
                    if (strpos($regra, ':') !== false) {
                        $regra_prefix = explode(':', $regra);
                        
                        $erro_validacao = $regra_prefix;
                        $erro_mensagem = sprintf($mensagens[$regra_prefix[0]], $campo['label'], $regra_prefix[1]);
                    } else {
                        $erro_validacao = $regra;
                        $erro_mensagem = sprintf($mensagens[$regra], $campo['label']);
                    }
                    
                    $erro_mensagem = htmlspecialchars($erro_mensagem, ENT_QUOTES, 'UTF-8');
                    
                    break;
                }
            }
            
            // Salva o primeiro erro geral
            if ($erro_mensagem and !$retorno['erro']) {
                $retorno['erro'] = $erro_mensagem;
            }
            
            $retorno['campos'][$key]['valido'] = $valido;
            $retorno['campos'][$key]['valor'] = $valor;
            $retorno['campos'][$key]['erro_validacao'] = $erro_validacao;
            $retorno['campos'][$key]['erro_mensagem'] = $erro_mensagem;
            $retorno['dados'][$campo['campo']] = $valor;
        }
        
        foreach ($retorno['campos'] as $campo) {
            if (!$campo['valido']) {
                $retorno['valido'] = false;
                
                break;
            }
        }
        
        return $retorno;
    }
}

if (!function_exists('valida_recaptcha')) {
    /**
     * Validação de recaptcha
     *
     * @param null $valor
     *
     * @return array
     * @throws Zend_Http_Client_Exception
     */
    function valida_recaptcha($valor = null): array
    {
        if (!$valor) {
            $valor = Zend_Controller_Front::getInstance()->getRequest()->getParam('g-recaptcha-response');
        }
        
        $retorno = [
            'valido' => true,
            'erros' => [],
            'erros_mensagens' => [],
        ];
        
        $lista_erros = [
            'missing-input-secret' => 'O parâmetro "secreto" não foi enviado.',
            'invalid-input-secret' => 'O parâmetro "secreto" é inválido ou está malformatado .',
            'missing-input-response' => 'O parâmetro "response" não foi enviado.',
            'invalid-input-response' => 'O parâmetro "response" não foi enviado.',
            'bad-request' => 'A solicitação é inválida ou malformatada.',
            'timeout-or-duplicate' => 'A resposta não é mais válida, é muito antiga ou foi usada anteriormente.',
        ];
        
        // Recupera as configurações
        $session_configuracao = new Zend_Session_Namespace('configuracao');
        
        $recaptcha_secret = $session_configuracao->dados->recaptcha_secret;
        
        $client = new Zend_Http_Client();
        $client->setUri('https://www.google.com/recaptcha/api/siteverify');
        $client->setParameterPost([
            'secret' => $recaptcha_secret,
            'response' => $valor,
            //'remoteip' => Zend_Controller_Front::getInstance()->getRequest()->getClientIp(true),
        ]);
        
        try {
            $resposta = $client->request('POST')->getBody();
            $data = json_decode($resposta, true);
            
            if (!$data) {
                $retorno['valido'] = false;
            } elseif (isset($data['error-codes'])) {
                $retorno['valido'] = false;
                $retorno['erros'] = $data['error-codes'];
                
                foreach ($data['error-codes'] as $erro_cod) {
                    $retorno['erros_mensagens'][] = $lista_erros[$erro_cod] ?? '';
                }
            }
        } catch (Exception $e) {
            $retorno['valido'] = false;
        }
        
        return $retorno;
    }
}

if (!function_exists('valida_cpf')) {
    /**
     * CPF
     *
     * @param $value
     *
     * @return bool
     */
    function valida_cpf($value)
    {
        $cpf = $value;
        $num = [];
        
        // Cria um array com os valores
        for ($i = 0; $i < (strlen($cpf)); $i++) {
            $num[] = $cpf[$i];
        }
        
        if (count($num) != 11) {
            return false;
        } else {
            // Combinações como 00000000000 e 22222222222 embora
            // não sejam cpfs reais resultariam em cpfs
            // válidos após o calculo dos dígitos verificares e
            // por isso precisam ser filtradas nesta parte.
            for ($i = 0; $i < 10; $i++) {
                if ($num[0] == $i && $num[1] == $i && $num[2] == $i && $num[3] == $i && $num[4] == $i && $num[5] == $i && $num[6] == $i && $num[7] == $i && $num[8] == $i) {
                    return false;
                    break;
                }
            }
        }
        
        // Calcula e compara o primeiro dígito verificador
        $j = 10;
        $multiplica = [];
        
        for ($i = 0; $i < 9; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        
        $soma = array_sum($multiplica);
        $resto = $soma % 11;
        
        if ($resto < 2) {
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }
        
        if ($dg != $num[9]) {
            return false;
        }
        
        // Calcula e compara o segundo dígito verificador
        $j = 11;
        
        for ($i = 0; $i < 10; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        
        $soma = array_sum($multiplica);
        $resto = $soma % 11;
        
        if ($resto < 2) {
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }
        
        if ($dg != $num[10]) {
            return false;
        }
        
        return true;
    }
}

if (!function_exists('valida_cnpj')) {
    /**
     * CNPJ
     *
     * @param $value
     *
     * @return bool
     */
    function valida_cnpj($value)
    {
        $cnpj = $value;
        $num = [];
        
        // Cria um array com os valores
        for ($i = 0; $i < (strlen($cnpj)); $i++) {
            $num[] = $cnpj[$i];
        }
        
        // Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
        if (count($num) != 14) {
            return false;
        }
        
        // Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria
        // um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
        if ($num[0] == 0 && $num[1] == 0 && $num[2] == 0 && $num[3] == 0 && $num[4] == 0 && $num[5] == 0 && $num[6] == 0 && $num[7] == 0 && $num[8] == 0 && $num[9] == 0 && $num[10] == 0 && $num[11] == 0) {
            return false;
        } // Etapa 4: Calcula e compara o primeiro dígito verificador.
        else {
            $j = 5;
            $multiplica = [];
            
            for ($i = 0; $i < 4; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            
            $j = 9;
            
            for ($i = 4; $i < 12; $i++) {
                $multiplica[$i] = $num[$i] * $j;
                $j--;
            }
            
            $soma = array_sum($multiplica);
            $resto = $soma % 11;
            
            if ($resto < 2) {
                $dg = 0;
            } else {
                $dg = 11 - $resto;
            }
            
            if ($dg != $num[12]) {
                return false;
            }
        }
        
        // Etapa 5: Calcula e compara o segundo dígito verificador.
        $j = 6;
        for ($i = 0; $i < 5; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        
        $j = 9;
        
        for ($i = 5; $i < 13; $i++) {
            $multiplica[$i] = $num[$i] * $j;
            $j--;
        }
        
        $soma = array_sum($multiplica);
        $resto = $soma % 11;
        
        if ($resto < 2) {
            $dg = 0;
        } else {
            $dg = 11 - $resto;
        }
        
        if ($dg != $num[13]) {
            return false;
        }
        
        return true;
    }
}

if (!function_exists('upload')) {
    /**
     * Upload de arquivo
     *
     * As regras podem ser encontradas em https://framework.zend.com/manual/1.12/en/zend.file.transfer.validators.html
     *
     * <code>
     *    $upload = upload([
     *        'campo'       => 'arquivo',
     *        'label'       => 'Currículo',
     *        'pasta'       => 'trabalhe',
     *        'obrigatorio' => true,
     *        'regras'      => [
     *            'Count'     => ['max' => 1],
     *            'Size'      => ['max' => '10MB'],
     *            'Extension' => ['jpg', 'png', 'pdf', 'doc', 'docx'],
     *            'MimeType'  => [
     *                'image/jpeg',
     *                'image/jpg',
     *                'image/png',
     *                'application/pdf',
     *                'application/msword', // doc
     *                'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // docx
     *            ],
     *        ],
     *    ]);
     *
     *    if( !$upload['valido'] )
     *    {
     *        $resposta['status']   = 'erro';
     *        $resposta['titulo']   = 'Ocorreu um erro!';
     *        $resposta['mensagem'] = $upload['erro'];
     *
     *        $this->_helper->json($resposta);
     *    }
     * </code>
     *
     * @param array $opcoes
     *
     * @return array
     * @throws Zend_Exception
     * @throws Zend_File_Transfer_Exception
     */
    function upload(array $opcoes)
    {
        $retorno = [
            'valido' => true,
            'erro' => '',
            'arquivo_nome' => null,
            'arquivo_nome_original' => null,
            'arquivo_extensao' => null,
            'arquivo_pasta' => realpath(APPLICATION_PATH . '/../common/uploads/' . $opcoes['pasta']),
            'arquivo_path' => null,
            'arquivo_url' => null,
        ];
        
        // Inicia o upload
        $upload = new Zend_File_Transfer_Adapter_Http();
        
        // Valida se é obrigatorio e não veio o arquivo
        if (isset($opcoes['obrigatorio']) and $opcoes['obrigatorio'] and !$upload->isUploaded($opcoes['campo'])) {
            $retorno['valido'] = false;
            $retorno['erro'] = $opcoes['label'] . ' é obrigatório';
            
            return $retorno;
        } // Não enviou o arquivo
        elseif (!$upload->isUploaded($opcoes['campo'])) {
            return $retorno;
        }
        
        $arquivo_pathinfo = pathinfo($upload->getFileName($opcoes['campo']));
        $retorno['arquivo_nome'] = substr((new gazetamarista_View_Helper_CreateSlug())->createslug($arquivo_pathinfo['filename']), 0, 30) . '-' . substr(time(), -6) . '.' . $arquivo_pathinfo['extension'];
        $retorno['arquivo_nome_original'] = $arquivo_pathinfo['basename'];
        $retorno['arquivo_extensao'] = $arquivo_pathinfo['extension'];
        $retorno['arquivo_path'] = $retorno['arquivo_pasta'] . '/' . $retorno['arquivo_nome'];
        $retorno['arquivo_url'] = Zend_Registry::get("config")->gazetamarista->config->basepath . '/common/uploads/' . $opcoes['pasta'] . '/' . $retorno['arquivo_nome'];
        
        // Validação
        foreach ($opcoes['regras'] as $regra_key => $regra) {
            $upload->addValidator($regra_key, true, $regra, $opcoes['campo']);
        }
        
        // Arquivo final
        $upload->addFilter('Rename', $retorno['arquivo_path'], $opcoes['campo']);
        
        if (!$upload->isValid($opcoes['campo'])) {
            $retorno['valido'] = false;
            $retorno['erro'] = $opcoes['label'] . ': ' . $upload->getMessages()[array_keys($upload->getMessages())[0]] ?? 'Erro desconhecido';
            
            return $retorno;
        }
        
        // Recebe os arquivos
        $upload->receive($opcoes['campo']);
        
        return $retorno;
    }
}

if (!function_exists('aceitou_cookies')) {
    /**
     * Checa se o usuário aceitou os cookies
     *
     * @return bool
     */
    function aceitou_cookies()
    {
        return (bool)$_COOKIE['aceitou_cookies'];
    }
}

if (!function_exists('cookies_texto')) {
    /**
     * Texto de política de privacidade
     *
     * @return string
     */
    function cookies_texto()
    {
        return (new Admin_Model_Configuracoes())->fetchRow(['idconfiguracao = ?' => 1])->politica_cookie_texto ?? '';
    }
}

if( !function_exists('random_number') )
{
	/**
	 * Gera número int aleatório
	 *
	 * @return bool
	 */
	function random_number($length)
	{
		$valid_chars   = "0123456789";
		$random_string = "";

		$num_valid_chars = strlen($valid_chars);

		for( $i = 0; $i < $length; $i++ )
		{
			$random_pick = mt_Rand(1, $num_valid_chars);

			$random_char = $valid_chars[$random_pick - 1];

			$random_string .= $random_char;
		}

		return (int) $random_string;
	}
}

if( !function_exists('divisao') )
{
	/**
	 * Divisão
	 *
	 * @param      $a
	 * @param      $b
	 * @param bool $round
	 *
	 * @return float|int
	 */
	function divisao($a, $b, $round = false)
	{
		if( !$a ) return 0;
		if( !$b ) return 0;

		return $round ? round($a / $b, 2) : $a / $b;
	}
}

if( !function_exists('inicia_cache') )
{
	/**
	 * Inicia o cache do zend
	 *
	 * @param string $pasta
	 * @param int    $tempo
	 *
	 * @return Zend_Cache_Core|Zend_Cache_Frontend
	 * @throws Zend_Cache_Exception
	 */
	function inicia_cache($pasta = 'geral', $tempo = 86400)
	{
		$pasta_cache = APPLICATION_PATH . '/tmp/cache/';
		$pasta_final = $pasta_cache . $pasta;

		if( !is_dir($pasta_cache) )
		{
			@mkdir($pasta_cache, 0775);
			@chmod($pasta_cache, 0775);
		}

		if( !is_dir($pasta_final) )
		{
			@mkdir($pasta_final, 0775);
			@chmod($pasta_final, 0775);
		}

		$cache = @Zend_Cache::factory('Core', 'File',
			[
				'lifetime' => $tempo, // em segundos
			],
			[
				'cache_dir'             => APPLICATION_PATH . '/tmp/cache/' . $pasta,
				'hashed_directory_perm' => 0775,
				'cache_file_perm'       => 0644,
			]
		);

		return $cache;
	}
}

if( !function_exists('inicia_log') )
{
	/**
	 * Inicia o log do zend
	 *
	 * @param string $pasta
	 *
	 * @return Zend_Log
	 * @throws Zend_Log_Exception
	 */
	function inicia_log($pasta = 'geral')
	{
		$pasta_log   = APPLICATION_PATH . '/tmp/log/';
		$pasta_final = $pasta_log . $pasta;

		if( !is_dir($pasta_log) )
		{
			@mkdir($pasta_log, 0775);
			@chmod($pasta_log, 0775);
		}

		if( !is_dir($pasta_final) )
		{
			@mkdir($pasta_final, 0775);
			@chmod($pasta_final, 0775);
		}

		// Inicia o log do zend para debug
		$writer = new Zend_Log_Writer_Stream($pasta_final . '/' . (new DateTime())->format('Y-m-d-H-i-s-u') . '.log');
		$logger = new Zend_Log($writer);

		return $logger;
	}
}

if( !function_exists('em_desenvolvimento') )
{
	/**
	 * Se está em ambiente de desenvolvimento
	 *
	 * @return bool
	 */
	function em_desenvolvimento()
	{
		return APPLICATION_ENV === 'development';
	}
}

if( !function_exists('em_producao') )
{
	/**
	 * Se está em ambiente de produção
	 *
	 * @return bool
	 */
	function em_producao()
	{
		return APPLICATION_ENV === 'production';
	}
}

if( !function_exists('anos_nascimento') )
{
    /**
	 * Calcular idade em anos (data yyyy-mm-dd)
	 *
	 * @return int
	 */
	function anos_nascimento($datadonascimento=null)
    {
        // Separa em dia, mês e ano
        list($ano, $mes, $dia) = explode('-', $datadonascimento);

        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        // Descobre a unix timestamp da data de nascimento do fulano
        $diadonascimento = mktime(0, 0, 0, $mes, $dia, $ano);

        // Depois apenas fazemos o cálculo já citado :)
        $idade = floor((((($hoje - $diadonascimento) / 60) / 60) / 24) / 365.25);

        return $idade;
    }
}

if (!function_exists('tratar_link_externo'))
{
    /**
     * Tratar https/http de link externo
     *
     * @param $url
     *
     * @return string
     */
    function tratar_link_externo($url)
    {
        if (empty($url)) {
            return '#';
        }

        // Inicia
        $new_url   = "";
        $protocol  = "";
        $url_limpa = "";

        // Scheme e host
        $url_parse  = parse_url($url);
        $txt_scheme = $url_parse['scheme'];
        $txt_params = $url_parse['query'];
        $txt_path	= $url_parse['path'];

        $txt_host   = isset($url_parse['host']) ? $url_parse['host'] : '';

        // Nova url tratada
        $new_url = (empty($txt_scheme) ? 'https' : $txt_scheme) . '://' . $txt_host . $txt_path;

        if(!empty($txt_params)) {
			$new_url .= '?' . $txt_params;
		}

        return $new_url;
    }
}

if (!function_exists('url_dominio'))
{
	/**
	 * Buscar url completa do domínio (https://.......)
	 *
	 * @return string
	 */
	function url_dominio()
	{
		// Busca as configurações
		$config = Zend_Registry::get("config");

		// Domínio
		if ($_SERVER['HTTP_HOST'] == "localhost") {
			$dominio = "http://localhost" . $config->gazetamarista->config->basepath;
		} elseif ($_SERVER['HTTP_HOST'] == "sites.gazetamarista.com.br") {
			$dominio = "http://sites.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
		} elseif ($_SERVER['HTTP_HOST'] == "local.gazetamarista.com.br") {
			$dominio = "http://local.gazetamarista.com.br" . $config->gazetamarista->config->basepath;
		} elseif ($_SERVER['HTTP_HOST'] == "192.168.1.222") {
			$dominio = "http://192.168.1.222" . $config->gazetamarista->config->basepath;
		} else {
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
				$dominio = "https://" . $config->gazetamarista->config->domain;
			} else {
				$dominio = "http://" . $config->gazetamarista->config->domain;
			}
		}

		return $dominio;
	}
}

if (!function_exists('get_size_file'))
{
    /**
     * Buscar tamanho do arquivo
     *
     * @return array
     */
    function get_size_file($path=null)
    {
    	$sizeFile = "";

        if(!empty($path)) {
        	// Retorno array
			$sizeFile = array('size'=>'', 'type'=>'');

			$tamanhoarquivo = filesize($path);

			// Medidas
			$medidas = array('KB', 'MB', 'GB', 'TB');

			//Se for menor que 1KB arredonda para 1KB
			if($tamanhoarquivo < 999) {
				$tamanhoarquivo = 1024;
			}

			$i = 0;
			for($i = 0; $tamanhoarquivo > 999; $i++) {
				$tamanhoarquivo /= 1024;
			}

			// Format
			$sizeFile['size'] = number_format($tamanhoarquivo, 1, ',', '');
			$sizeFile['type'] = $medidas[$i-1];
		}

        return $sizeFile;
    }
}
