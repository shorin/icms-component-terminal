<?php
	
	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
	class comands{
		
		function __construct(){}
		
		public function install(){
			$array = array(
						'name'=>'cache',
						'info'=>'��������� ���. <b>cache number</b> - ���������� ������ � ����; <b>cache clear</b> - ������� ����',
						'root'=>'admin',
						);
			return $array;
		}
		
		public function execute($parametr){
			if (!$parametr){return '����������� ��������';}
			
			if ($parametr == 'number'){
				$file_delete = 0;
				if ($handle = opendir($_SERVER['DOCUMENT_ROOT'].'/cache/')){
					while (false !== ($file = readdir($handle))){
						if ($file != '.' && $file != '..' && $file != '.htaccess' && $file != 'index.html'){
							$file_delete++;
						}
					}
					closedir($handle);
				}
				
				if ($file_delete == 0){
					return '��������� ��� ����.';
				}
				return '������ � ��������� ����: '.$file_delete;
			}
			
			if ($parametr == 'clear'){
				$file_delete = 0;
				if ($handle = opendir($_SERVER['DOCUMENT_ROOT'].'/cache/')){
					while (false !== ($file = readdir($handle))){
						if ($file != '.' && $file != '..' && $file != '.htaccess' && $file != 'index.html'){
							unlink($_SERVER['DOCUMENT_ROOT'].'/cache/'.$file);
							$file_delete++;
						}
					}
					closedir($handle);
				}
				
				if ($file_delete == 0){
					return '��������� ��� ����.';
				}
				return '��������� ��� ������. ������ �������: '.$file_delete;
			}
			
			return '����������� ��������';
		}
	}
?>