<?php

/**
 * Cria o helper para exibição das metas dos pedidos
 * 
 * @name gazetamarista_View_Helper_YoutubeId
 */
class gazetamarista_View_Helper_YoutubeId extends Zend_View_Helper_Abstract {
	/**
	 * Extrai o código do vídeo do youtube
	 * 
	 * @access public
	 * @name YoutubeId
	 * @param $url do vídeo youtube
	 */
	public function YoutubeId($url, $type='id', $resolution='big') {
	    if(strlen($url) > 11) {
	        $var_id = null;
            $var_thumb = null;

            // Search id
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $idvideo)) {
                // Id do vídeo
                $var_id = $idvideo[1];
            }

            // Search thumb
            if(!empty($var_id)) {
                // Array resolutions
                $resolutions = array('maxresdefault', 'sddefault', 'hqdefault', 'mqdefault');
                if($resolution == "small") {
                    $resolutions = array_reverse($resolutions);
                }

                foreach ($resolutions as $res) {
                    $imgUrl = "https://img.youtube.com/vi/" . $var_id . "/" . $res . ".jpg";
                    if (@getimagesize(($imgUrl))) {
                        $var_thumb = $imgUrl;
                        break;
                    }
                }
            }

	        if($type == 'id') {
                return $var_id;
	        }else{
                return $var_thumb;
            }
	    }

	    return false;
	}
}