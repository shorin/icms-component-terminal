<?php

	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
	class base_comands{
		
		function __construct(){
			$this->inCore = cmsCore::getInstance();
			$this->inDB = cmsDatabase::getInstance();
			$this->inUser = cmsUser::getInstance();
			$this->model = cms_model_terminal::getInstance();
		}
		
		public function help(){
			if ($this->model->is_root() == 'admin'){
				$sql2 = "WHERE root = 'admin' ";
			}
			$sql = "SELECT comand FROM cms_terminal_comands ".$sql2 ;
			$result = $this->inDB->query($sql);
			$text.='доступные команды: ';
			while ($comand = $this->inDB->fetch_assoc($result)){
				$text.= '<b>'.$comand['comand'].'</b>&nbsp&nbsp';
			}
			$text.='<br>для получения справки по команде наберите <b>info команда</b>';
			return $text;
		}
		
		public function info($parametr){
			if (!$parametr){
				return 'не указанно имя команды. <b>info команда</b>' ;
			}
			$sql = "SELECT info, root FROM cms_terminal_comands WHERE comand = '{$parametr}' LIMIT 1";
			$result = $this->inDB->query($sql);
			if (!$this->inDB->num_rows($result)){
				return 'команда <b>'.$parametr.'</b> не существует';
			}
			$info = $this->inDB->fetch_assoc($result);
			if ($info['root'] == $this->model->is_root() || $this->model->is_root() == 'root'){
				return $info['info'];
			}
			else{
				return 'для просмотра информации по команде <b>'.$parametr.'</b> нужны права <b>root</b>';
			}
		}
		
		public function su($password){
			if ($this->inUser->sessionGet('is_root')){
				if ($password == 'exit'){
					$this->inUser->sessionDel('is_root');
					return 'сессия <b>root</b> завершена';
				}
				return 'cессия <b>root</b> активна';
			}
			else{
				if (!$password){return 'а где пароль ?';}
				$this->model->delComand();
				$cfg = $this->model->getConfig();
				if(md5($cfg['salt'].$password.$_SERVER['SERVER_NAME']) == $cfg['password']){
					$this->inUser->sessionPut('is_root', '1');
					return 'cессия <b>root</b> активна' ;
				}
				return 'неверный пароль';
			}
		}
		
		public function comand($parametr1, $parametr2, $parametr3){
			
			if (!$parametr1 || !$parametr2){return 'неверный синтаксис';}
			
			if ($this->model->is_root() == $this->model->getСhown($parametr1) || $this->model->is_root() == 'root'){
				
				if ($parametr1 == 'install'){
					if ($this->model->isComandBase($parametr2) == 1){return 'команда <b>'.$parametr2.'</b> уже установлена';}
					if(file_exists($_SERVER['DOCUMENT_ROOT'].'/components/terminal/comands/'.$parametr2.'.php')){
						include($_SERVER['DOCUMENT_ROOT'].'/components/terminal/comands/'.$parametr2.'.php');
						$comands = new comands();
						$parametrs = $comands->install();
						$sql = "INSERT INTO cms_terminal_comands (comand, info, root) VALUES ('{$parametrs['name']}', '{$parametrs['info']}', '{$parametrs['root']}')";
						$this->inDB->query($sql);
						if ($this->inDB->error()){
							return 'не удалось установить команду <b>'.$parametr2.'</b>';
						}
						return 'команда <b>'.$parametr2.'</b> установлена' ;
					}
					else{
						return 'нельзя установить команду <b>'.$parametr2.'</b>';
					}
				}
				
				if ($parametr1 == 'remove'){
					if ($this->model->isComandBase($parametr2) == 0){
						return 'команда <b>'.$parametr2.'</b> не установлена';
					}
					if ($this->model->isMethodClass($parametr2) == 1){
						return 'нельзя удалить команду <b>'.$parametr2.'</b>';
					}
					$sql = "DELETE FROM cms_terminal_comands WHERE comand = '{$parametr2}'";
					$this->inDB->query($sql);
					if ($this->inDB->error()){
						return 'не удалось удалить команду <b>'.$parametr2.'</b>';
					}
					return 'команда <b>'.$parametr2.'</b> удалена' ;
				}
				
				if ($parametr1 == 'chown'){
					if ($this->model->isComandBase($parametr2) == 0){return 'команда <b>'.$parametr2.'</b> не существует';}
					if (!parametr3){return 'неверный синтаксис';}
					if ($this->model->isMethodClass($parametr2) == 1){
						return 'нельзя сменить права для команды <b>'.$parametr2.'</b>';
					}
					if ($parametr3 != 'admin' && $parametr3 != 'root'){return 'последний параметр может иметь значение только <b>admin</b> либо <b>root</b>';}
					if ($this->model->getСhown($parametr2) == $parametr3){return 'у команды <b>'.$parametr2.'</b> уже права <b>'.$parametr3.'</b>';}
					$sql = "UPDATE cms_terminal_comands SET root = '{$parametr3}' WHERE comand = '{$parametr2}'";
					$this->inDB->query($sql);
					if ($this->inDB->error()){
						return 'не удалось сменить права для команды <b>'.$parametr2.'</b>';
					}
					return 'права для команды <b>'.$parametr2.'</b> изменены' ;
				}
				
			}
			else{
				return 'для этой команды нужны права <b>root</b>';
			}
			
			return 'неверный синтаксис';
		}
		
	}
?>

