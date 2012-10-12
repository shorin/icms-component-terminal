<?php
	
	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
	class comands{
		
		function __construct(){}
		
		public function install(){
			$array = array(
						'name'=>'ip',
						'info'=>'команда показывает ваш IP адрес',
						'root'=>'admin',
						);
			return $array;
		}
		
		public function execute(){
			return $_SERVER['REMOTE_ADDR'];
		}
		
	}
?>