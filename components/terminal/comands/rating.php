<?php
	
	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
	class comands{
		
		function __construct(){
			$this->inDB = cmsDatabase::getInstance();
		}
		
		public function install(){
			$array = array(
						'name'=>'rating',
						'info'=>'��������� �������� ��� ������������. <b>rating ����� �����</b>',
						'root'=>'root',
						);
			return $array;
		}
		
		public function execute($parametr1, $parametr2){
			if (!$parametr1 || !$parametr2){return '����������� ��������';}
			
			$sql = "SELECT id FROM cms_users WHERE login = '{$parametr1}'";
			$result = $this->inDB->query($sql);
			if (!$this->inDB->num_rows($result)){
				return '������������ � ������� <b>'.$parametr1.'</b> �� ����������';
			}
			
			$sql = "UPDATE cms_users SET rating = '{$parametr2}' WHERE login = '{$parametr1}'";
			$this->inDB->query($sql);
			
			return '������� ��� ������������ � ������� <b>'.$parametr1.'</b> �������';
		}
		
	}
?>