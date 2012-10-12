<?php

	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }

	class cms_model_terminal{
		
		public  $config = array();
		private static $instance;
		
		function __construct(){
			$this->inDB = cmsDatabase::getInstance();
			$this->config = self::getConfig();
			$this->inUser = cmsUser::getInstance();
		}
		
		public function install(){
			return true;
		}
		
		public static function getInstance() {
			if (self::$instance === null) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		
		public static function getDefaultConfig(){
			$cfg = array(
						'name'=>'terminal',
						'password'=>'',
						'salt'=>date('is')
						);
			return $cfg;
		}
		
		public static function getConfig(){
			$inCore = cmsCore::getInstance();
			$default_cfg = self::getDefaultConfig();
			$cfg = $inCore->loadComponentConfig('terminal');
			$cfg = array_merge($default_cfg, $cfg);
			return $cfg;
		}
		
		public function addComand($comand, $ip) {
			$sql = "INSERT INTO cms_terminal_log (comand_time, comand, ip) VALUES (NOW(), '{$comand}', '{$ip}')";
			$this->inDB->query($sql);
			if ($this->inDB->error()) { return false; }
			return true;
		}
		
		public function getComands(){
			$sql = "SELECT comand_time, comand FROM cms_terminal_log ORDER BY id DESC LIMIT 13";
			$result = $this->inDB->query($sql);
			if (!$this->inDB->num_rows($result)) { return false; }
			while ($comand = $this->inDB->fetch_assoc($result)){
				$comands.= $comand['comand'].'<br>';
			}
			return $comands;
		}
		
		public function fillingMassive($parametrs){
			$num = 1;
			while ($num != 11){
				if (!$parametrs[$num]){$parametrs[$num] = '';}
				$num++;
			}
			return $parametrs;
		}
		
		public function is_root(){
			if ($this->inUser->sessionGet('is_root')){
				return 'root';
			}
			else{
				return 'admin';
			}
		}
		
		public function delComand(){
			$sql = "SELECT id FROM cms_terminal_log ORDER BY id DESC LIMIT 1";
			$result = $this->inDB->query($sql);
			$comand = $this->inDB->fetch_assoc($result);
			$sql = "DELETE FROM cms_terminal_log WHERE id = '{$comand['id']}'";
			$this->inDB->query($sql);
			if ($this->inDB->error()) { return false; }
			return true;
		}
		
		public function isComandBase($parametr){
			$sql = "SELECT id FROM cms_terminal_comands WHERE comand = '{$parametr}' LIMIT 1";
			$result = $this->inDB->query($sql);
			if ($this->inDB->error()) { return false; }
			if ($this->inDB->num_rows($result) == 1){return '1';}
			return '0';
		}
		
		public function getÑhown($parametr){
			$sql = "SELECT root FROM cms_terminal_comands WHERE comand = '{$parametr}' LIMIT 1";
			$result = $this->inDB->query($sql);
			if ($this->inDB->error()){return false;}
			$comand = $this->inDB->fetch_assoc($result);
			return $comand['root'];
		}
		
		public function isMethodClass($parametr){
			include($_SERVER['DOCUMENT_ROOT'].'/components/terminal/comands/base_comands.php');
			$base_comands = new base_comands();
			$methods = get_class_methods(get_class($base_comands));
			foreach ($methods as $method_name) {
				if ($method_name == $parametr) {return '1';}
			}
			return '0';
		}
		
	}
?>