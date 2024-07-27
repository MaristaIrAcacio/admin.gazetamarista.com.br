<?php

// Inclui a classe markup
require_once("Zend/Markup.php");

/**
 * Cria o helper do dateformat
 * 
 * @name Zend_View_Helper_Dateformat
 * @example
 * 
 * {$this->dateformat($this->translate('extension_date'), '2011-12-25 00:12:35')}
 * 
 */
class gazetamarista_View_Helper_Dateformat extends Zend_View_Helper_Abstract {
	/**
	 * Método da classe
	 * 
	 * @name dateformat
	 * @param string $format Formato da data a ser exibida
	 * @param datetime $string Data a ser formatada
	 */
	public function dateformat($format, $date) {
		// $translate = Zend_Registry::get("translate");
		
		// 
		$timestamp = strtotime($date);
		$new_date = $format;
		
		// Cria o vetor de dias da semana
		// $week = array();
		// $week[7] = $translate->translate("sunday");
		// $week[1] = $translate->translate("monday");
		// $week[2] = $translate->translate("tuesday");
		// $week[3] = $translate->translate("wednesday");
		// $week[4] = $translate->translate("thursday");
		// $week[5] = $translate->translate("friday");
		// $week[6] = $translate->translate("saturday");
		// $new_date = str_replace("%E", $week[date("N", $timestamp)], $new_date);
		
		// Cria o vetor dos meses
		// $month = array();
		// $month[1] = $translate->translate("january");
		// $month[2] = $translate->translate("february");
		// $month[3] = $translate->translate("march");
		// $month[4] = $translate->translate("april");
		// $month[5] = $translate->translate("may");
		// $month[6] = $translate->translate("june");
		// $month[7] = $translate->translate("july");
		// $month[8] = $translate->translate("august");
		// $month[9] = $translate->translate("september");
		// $month[10] = $translate->translate("october");
		// $month[11] = $translate->translate("november");
		// $month[12] = $translate->translate("december");
		// $new_date = str_replace("%F", $month[date("n", $timestamp)], $new_date);
		
		// Cria o vetor dos meses
		// $month = array();
		// $month[1] = $translate->translate("Jan");
		// $month[2] = $translate->translate("Feb");
		// $month[3] = $translate->translate("Mar");
		// $month[4] = $translate->translate("Apr");
		// $month[5] = $translate->translate("May");
		// $month[6] = $translate->translate("Jun");
		// $month[7] = $translate->translate("Jul");
		// $month[8] = $translate->translate("Aug");
		// $month[9] = $translate->translate("Sep");
		// $month[10] = $translate->translate("Oct");
		// $month[11] = $translate->translate("Nov");
		// $month[12] = $translate->translate("Dec");
		// $new_date = str_replace("%M", $month[date("n", $timestamp)], $new_date);
		
		// Troca as informacoes
		$new_date = str_replace("%Y", date("Y", $timestamp), $new_date);
		$new_date = str_replace("%d", date("d", $timestamp), $new_date);
		$new_date = str_replace("%m", date("m", $timestamp), $new_date);
		
		// Verifica se retorna a hora
		$pos_hora = strripos($format, "%H");
		if($pos_hora) {
			$new_date = str_replace("%H", date("H", $timestamp), $new_date);
			
			$pos_min = strripos($format, "%i");
			if($pos_min) {
				$new_date = str_replace("%i", date("i", $timestamp), $new_date);
			}
			
			$pos_s = strripos($format, "%s");
			if($pos_s) {
				$new_date = str_replace("%s", date("s", $timestamp), $new_date);
			}
		}
		
		// Retorna a string formatada
		return $new_date;
	}
}
