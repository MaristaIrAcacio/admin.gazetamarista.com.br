<?phpgazetamaristagazetamarista



/**

 * Busca a temperatura do google api

 * 

 * @name Clickweb_Google_Weather

 */

class Clickweb_Google_Weather {

	/**

	 * Construtor da classe

	 * 

	 * @name __construct

	 */

	public function __construct() {

	}

	

	/**

	 * Busca as informações do clima

	 * 

	 * @name getWeather

	 * @param string $location Localização para buscar o clima

	 * @return array

	 */

	public function getWeather($location) {

		// Busca o XML do google

		$xml = simplexml_load_file("http://www.google.com/ig/api?oe=utf-8&weather=" . $location . "&hl=pt-br");



		// Busca as informações

		$information = $xml->xpath("/xml_api_reply/weather/forecast_information");

		$current = $xml->xpath("/xml_api_reply/weather/current_conditions");

		$forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");

		

		// Busca os proximos

		$nexts = array();

		foreach($forecast_list as $forecast) {

			$nexts[] = array(

				'day_of_week'	=> (string)$forecast->day_of_week['data'],

				'low'			=> (string)$forecast->condition['data'],

				'high'			=> (string)$forecast->high['data'],

				'humidity'		=> (string)$forecast->low['data'],

				'icon'			=> "http://www.google.com/ig" . (string)$forecast->icon['data'],

				'condition'		=> (string)$forecast->condition['data'],

			);

		}

		

		// Monta o retorno

		$info = array(

			'city'			=> (string)$information[0]->city['data'],

			'condition'		=> (string)$current[0]->condition['data'],

			'temp'			=> (string)$current[0]->temp_c['data'],

			'humidity'		=> (string)$current[0]->humidity['data'],

			'icon'			=> "http://www.google.com/ig" . (string)$current[0]->icon['data'],

			'wind'			=> (string)$current[0]->wind_condition['data'],

			'nexts'			=> $nexts

		);

		

		// Retorna as informações

		return $info;

	}

}

