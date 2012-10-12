<?php
	
	if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }
	
	class comands{
		
		function __construct(){}
		
		public function install(){
			$array = array(
						'name'=>'cache',
						'info'=>'Системный кеш. <b>cache number</b> - количество файлов в кеше; <b>cache clear</b> - очистка кеша',
						'root'=>'admin',
						);
			return $array;
		}
		
		public function execute($parametr){
			if (!$parametr){return 'отсутствует параметр';}
			
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
					return 'Системный кэш пуст.';
				}
				return 'файлов в системном кеше: '.$file_delete;
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
					return 'Системный кэш пуст.';
				}
				return 'Системный кэш очищен. Файлов удалено: '.$file_delete;
			}
			
			return 'отсутствует параметр';
		}
	}
?>