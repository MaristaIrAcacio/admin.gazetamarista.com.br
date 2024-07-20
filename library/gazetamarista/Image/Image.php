<?php

require_once("gazetamarista/Library/Intervention/vendor/autoload.php");

use Intervention\Image\ImageManager;

/**
 * Classe de extensão da classe de manipulação de imagens, canvas
 *
 * @name gazetamarista_Image_Image
 *
 */
class gazetamarista_Image_Image extends ImageManager
{

	/**
	 * Config
	 *
	 * @var array
	 */
	public $config = [
		'driver' => 'gd',
	];

}
