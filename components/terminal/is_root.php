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
	
	$inCore->loadClass('user');
	
	$inConf = cmsConfig::getInstance();
	$inUser = cmsUser::getInstance();
	
	if (!$inUser->update()) { $inCore->halt(); }
	if ($inConf->siteoff && !$inUser->is_admin){ $inCore->halt(); }
	
	if ($inUser->sessionGet('is_root')) {echo 'root';}else{echo '';}

?>