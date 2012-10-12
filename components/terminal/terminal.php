<?php
	
	Error_Reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	
	setlocale(LC_ALL, 'ru_RU.CP1251');
	header('Content-Type: text/html; charset=windows-1251');
	
	define("VALID_CMS", 1);
	define('PATH', $_SERVER['DOCUMENT_ROOT']);
	
	if(@$_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') { die(); }
	
	session_start();
	
	include(PATH.'/core/cms.php');
	$inCore = cmsCore::getInstance();
	
	define('HOST', 'http://' . $inCore->getHost());
	
	$inCore->loadClass('user');
	
	$inDB   = cmsDatabase::getInstance();
	$inConf = cmsConfig::getInstance();
	$inUser = cmsUser::getInstance();
	
	if (!$inUser->update()) { $inCore->halt(); }
	
	if ($inConf->siteoff && !$inUser->is_admin){ $inCore->halt(); }
	
	$inCore->loadModel('terminal');
	$model = new cms_model_terminal();
	
	$inCore->includeFile('components/terminal/base_comands.php');
	$base_comands = new base_comands();
	
	$data = $inCore->request('data', 'str', 0);
	$ip = $inUser->ip;
	$cfg = $model->getConfig();
	$model->addComand($inUser->nickname.' > '.$data, $ip);
	$parametrs = explode(' ', $data);
	$comanda = $parametrs[0];
	unset($parametrs[0]);
	$parametrs = $model->fillingMassive($parametrs);
	$methods = get_class_methods(get_class($base_comands));

	foreach ($methods as $method_name) {
		if ($method_name == $comanda) {$is_base_comand = 1;}
	}
	
	if ($is_base_comand == 1){
		$execute = call_user_func_array(array($base_comands, $comanda), $parametrs);
		$model->addComand($cfg['name'].' > '.$execute, $ip);
	}
	else{
		if ($model->isComandBase($comanda) == '1'){
			if ($model->is_root() == $model->getСhown($comanda) || $model->is_root() == 'root'){
				if ($model->is_root() == $model->getСhown($comanda) || $model->is_root() == 'root'){
					include(PATH.'/components/terminal/comands/'.$comanda.'.php');
					$comands = new comands();
					$execute = call_user_func_array(array($comands, 'execute'), $parametrs);
					$model->addComand($cfg['name'].' > '.$execute, $ip);
				}
				else{
					$model->addComand($cfg['name'].' > отсутствует файл команды', $ip);
				}
			}
			else{
				$model->addComand($cfg['name'].' > для этой команды нужны права <b>root</b>', $ip);
			}
		}
		else{
			$model->addComand($cfg['name'].' > команды <b>'.$comanda.'</b> не существует', $ip);
		}
	}
	
	echo $model->getComands();

?>