<?php

/**
 * Class Tipoupload
 *
 * * @name gazetamarista_Tipoupload
 * 
 * Helpers para Upload
 *
 * @author  gazetamarista - Rossi
 */
class gazetamarista_Tipoupload {
	/**
	 * Erros
	 *
	 * @var bool|string
	 */
	protected $erros = false;

	/**
	 * Resposta da api
	 *
	 * @var array
	 */
	protected $resposta = false;

	/**
	 * Limite do arquivo em mb
	 *
	 * @var decimal
	 */
	protected $limite_size_max = 3;

	/**
	 * Retorna os erros
	 *
	 * @return mixed
	 */
	public function erros() {
		return $this->erros;
	}

	/**
	 * Verifica se bloqueia o upload
	 *
	 * @param $file_temp [file ou array de files]
	 *
	 * @return $resposta
	 */
	public function bloqueio($file_temp=null, $arr_extensoes_permitidas=array()) {
	    $resposta = array('status'=>'sucesso');

        // Multiplos arquivos
        $countarray = count($file_temp['tmp_name']);

        for($i=0;$i<$countarray;$i++) {
            // Dados do arquivo
            if(is_array($file_temp['name'])) {
                $arquivo_nome = $file_temp['name'][$i];
                $arquivo_tipo = $file_temp['type'][$i];
                $arquivo_size = $file_temp['size'][$i];
            }else{
                $arquivo_nome = $file_temp['name'];
                $arquivo_tipo = $file_temp['type'];
                $arquivo_size = $file_temp['size'];
            }
            $arquivo_extensao	= end(explode(".", $arquivo_nome));
            $arquivo_type 		= reset(explode("/", $arquivo_tipo));

            // Verifica se existe arquivo
            if($arquivo_size > 0) {
                if(
                    $arquivo_extensao != "php"
                    && $arquivo_extensao != "sql"
                    && $arquivo_extensao != "exe"
                    && $arquivo_extensao != "bat"
                    && $arquivo_extensao != "java"
                    && $arquivo_extensao != "ogg"
                    && $arquivo_extensao != "tgz"
                    && $arquivo_extensao != "gz"
                    && $arquivo_extensao != "bz2"
                    && $arquivo_extensao != "tar"
                ) {

                    $posicao_bloqueio = strpos($arquivo_tipo, "php"); // text/x-php

                    // Validar extensões permitidas no model
                    if(count($arr_extensoes_permitidas) > 0) {
                        if(!in_array($arquivo_extensao, $arr_extensoes_permitidas)) {
                            // Não permitido
                            $posicao_bloqueio = true;
                        }
                    }

                    // Verifica extensão de bloqueio
                    if($posicao_bloqueio == true) {
                        $resposta = array('status'=>'erro', 'msg'=>'(.'.$arquivo_extensao.') Tipo de arquivo não aceito.');
                    }

                    // Verifica peso do arquivo (MB)
                    if($arquivo_type == "image" && $arquivo_size > ($this->limite_size_max*1024*1024)) {
                        $resposta = array('status'=>'erro', 'msg'=>'Arquivo muito pesado, acima de '.$this->limite_size_max.'MB não é permitido.');
                    }
                }else{
                    $resposta = array('status'=>'erro', 'msg'=>'(.'.$arquivo_extensao.') Tipo de arquivo não liberado.');
                }
            }
        }
		
		return $resposta;
	}
}
