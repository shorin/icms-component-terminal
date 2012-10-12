<?php

	function info_component_terminal(){
		$_component['title']        = 'Терминал';
		$_component['description']  = 'Компонент позволяет управлять сайтом по средствам командной строки';
		$_component['link']         = 'terminal';
		$_component['author']       = 'maix';
		$_component['internal']     = '0';
		$_component['version']      = '1.2';
		
		$inCore = cmsCore::getInstance();
		$inCore->loadModel('terminal');
		$_component['config'] = cms_model_terminal::getConfig();
		return $_component;
	}
	
	function install_component_terminal(){
		$inCore = cmsCore::getInstance();
		$inDB  = cmsDatabase::getInstance();
		$inConf = cmsConfig::getInstance();
		include($_SERVER['DOCUMENT_ROOT'].'/includes/dbimport.inc.php');
		dbRunSQL($_SERVER['DOCUMENT_ROOT'].'/components/terminal/install.sql', $inConf->db_prefix);
		return true; 
	}
	
	function upgrade_component_terminal(){
		return true;
	}
	
?>