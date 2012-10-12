<?php
	
	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
	class comands{
		
		function __construct(){
			$this->inDB = cmsDatabase::getInstance();
		}
		
		public function install(){
			$array = array(
						'name'=>'terminal',
						'info'=>'<b>terminal number</b>  - колличество записей в базе; <b>terminal clear</b>  - очистка лога терминала',
						'root'=>'root',
						);
			return $array;
		}
		
		public function execute($parametr){
			if (!$parametr){return 'отсутствует параметр';}
			
			if ($parametr == 'number'){
				$sql = "SELECT id FROM cms_terminal_log";
				$result = $this->inDB->query($sql);
				$koll = $this->inDB->num_rows($result);
				return $koll;
			}
			
			if ($parametr == 'clear'){
				$sql = "SELECT id FROM cms_terminal_log";
				$result = $this->inDB->query($sql);
				if ($this->inDB->error()) { return false; }
				if (!$this->inDB->num_rows($result)) { return false; }
				while ($data = $this->inDB->fetch_assoc($result)){
					$sql = "DELETE FROM cms_terminal_log WHERE id = '{$data['id']}'";
					$this->inDB->query($sql);
				}
				return 'лог терминала очищен';
			}
			
			return 'отсутствует параметр';
		}
		
	}
?>