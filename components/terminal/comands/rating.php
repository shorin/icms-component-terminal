<?php
	
	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
	class comands{
		
		function __construct(){
			$this->inDB = cmsDatabase::getInstance();
		}
		
		public function install(){
			$array = array(
						'name'=>'rating',
						'info'=>'Изменение рейтинга для пользователя. <b>rating логин число</b>',
						'root'=>'root',
						);
			return $array;
		}
		
		public function execute($parametr1, $parametr2){
			if (!$parametr1 || !$parametr2){return 'отсутствует параметр';}
			
			$sql = "SELECT id FROM cms_users WHERE login = '{$parametr1}'";
			$result = $this->inDB->query($sql);
			if (!$this->inDB->num_rows($result)){
				return 'пользователя с логином <b>'.$parametr1.'</b> не существует';
			}
			
			$sql = "UPDATE cms_users SET rating = '{$parametr2}' WHERE login = '{$parametr1}'";
			$this->inDB->query($sql);
			
			return 'рейтинг для пользователя с логином <b>'.$parametr1.'</b> изменен';
		}
		
	}
?>