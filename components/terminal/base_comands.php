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
			$text.='��������� �������: ';
			while ($comand = $this->inDB->fetch_assoc($result)){
				$text.= '<b>'.$comand['comand'].'</b>&nbsp&nbsp';
			}
			$text.='<br>��� ��������� ������� �� ������� �������� <b>info �������</b>';
			return $text;
		}
		
		public function info($parametr){
			if (!$parametr){
				return '�� �������� ��� �������. <b>info �������</b>' ;
			}
			$sql = "SELECT info, root FROM cms_terminal_comands WHERE comand = '{$parametr}' LIMIT 1";
			$result = $this->inDB->query($sql);
			if (!$this->inDB->num_rows($result)){
				return '������� <b>'.$parametr.'</b> �� ����������';
			}
			$info = $this->inDB->fetch_assoc($result);
			if ($info['root'] == $this->model->is_root() || $this->model->is_root() == 'root'){
				return $info['info'];
			}
			else{
				return '��� ��������� ���������� �� ������� <b>'.$parametr.'</b> ����� ����� <b>root</b>';
			}
		}
		
		public function su($password){
			if ($this->inUser->sessionGet('is_root')){
				if ($password == 'exit'){
					$this->inUser->sessionDel('is_root');
					return '������ <b>root</b> ���������';
				}
				return 'c����� <b>root</b> �������';
			}
			else{
				if (!$password){return '� ��� ������ ?';}
				$this->model->delComand();
				$cfg = $this->model->getConfig();
				if(md5($cfg['salt'].$password.$_SERVER['SERVER_NAME']) == $cfg['password']){
					$this->inUser->sessionPut('is_root', '1');
					return 'c����� <b>root</b> �������' ;
				}
				return '�������� ������';
			}
		}
		
		public function comand($parametr1, $parametr2, $parametr3){
			
			if (!$parametr1 || !$parametr2){return '�������� ���������';}
			
			if ($this->model->is_root() == $this->model->get�hown($parametr1) || $this->model->is_root() == 'root'){
				
				if ($parametr1 == 'install'){
					if ($this->model->isComandBase($parametr2) == 1){return '������� <b>'.$parametr2.'</b> ��� �����������';}
					if(file_exists($_SERVER['DOCUMENT_ROOT'].'/components/terminal/comands/'.$parametr2.'.php')){
						include($_SERVER['DOCUMENT_ROOT'].'/components/terminal/comands/'.$parametr2.'.php');
						$comands = new comands();
						$parametrs = $comands->install();
						$sql = "INSERT INTO cms_terminal_comands (comand, info, root) VALUES ('{$parametrs['name']}', '{$parametrs['info']}', '{$parametrs['root']}')";
						$this->inDB->query($sql);
						if ($this->inDB->error()){
							return '�� ������� ���������� ������� <b>'.$parametr2.'</b>';
						}
						return '������� <b>'.$parametr2.'</b> �����������' ;
					}
					else{
						return '������ ���������� ������� <b>'.$parametr2.'</b>';
					}
				}
				
				if ($parametr1 == 'remove'){
					if ($this->model->isComandBase($parametr2) == 0){
						return '������� <b>'.$parametr2.'</b> �� �����������';
					}
					if ($this->model->isMethodClass($parametr2) == 1){
						return '������ ������� ������� <b>'.$parametr2.'</b>';
					}
					$sql = "DELETE FROM cms_terminal_comands WHERE comand = '{$parametr2}'";
					$this->inDB->query($sql);
					if ($this->inDB->error()){
						return '�� ������� ������� ������� <b>'.$parametr2.'</b>';
					}
					return '������� <b>'.$parametr2.'</b> �������' ;
				}
				
				if ($parametr1 == 'chown'){
					if ($this->model->isComandBase($parametr2) == 0){return '������� <b>'.$parametr2.'</b> �� ����������';}
					if (!parametr3){return '�������� ���������';}
					if ($this->model->isMethodClass($parametr2) == 1){
						return '������ ������� ����� ��� ������� <b>'.$parametr2.'</b>';
					}
					if ($parametr3 != 'admin' && $parametr3 != 'root'){return '��������� �������� ����� ����� �������� ������ <b>admin</b> ���� <b>root</b>';}
					if ($this->model->get�hown($parametr2) == $parametr3){return '� ������� <b>'.$parametr2.'</b> ��� ����� <b>'.$parametr3.'</b>';}
					$sql = "UPDATE cms_terminal_comands SET root = '{$parametr3}' WHERE comand = '{$parametr2}'";
					$this->inDB->query($sql);
					if ($this->inDB->error()){
						return '�� ������� ������� ����� ��� ������� <b>'.$parametr2.'</b>';
					}
					return '����� ��� ������� <b>'.$parametr2.'</b> ��������' ;
				}
				
			}
			else{
				return '��� ���� ������� ����� ����� <b>root</b>';
			}
			
			return '�������� ���������';
		}
		
	}
?>

