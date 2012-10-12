<?php
function terminal(){

	$inCore = cmsCore::getInstance();
	$inPage = cmsPage::getInstance();
	$inDB = cmsDatabase::getInstance();
	$inUser = cmsUser::getInstance();

	if (!$inUser->login) {$inCore->redirect('/login'); }
	if (!$inUser->is_admin) { cmsCore::error404(); }
	
	$inCore->loadModel('terminal');
	$model = new cms_model_terminal();

	$cfg = $model->getConfig();
	if(!$cfg['component_enabled']) { cmsCore::error404(); }

	$do = $inCore->request('do', 'str', 'index');

	if ($do == 'index'){
		$inPage->setTitle("Òåðìèíàë");
		$inPage->addPathway('Òåðìèíàë', '/terminal');
		if ($inUser->sessionGet('is_root')){$terminal_root = 'root';}else{$terminal_root = '';}
		echo '
			<link href="/components/terminal/terminal.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="/components/terminal/terminal.js"></script>
			<div class=terminal_body>
				<div onkeypress="return enter_terminal(event);" class="terminal_script"> '.$inUser->nickname.' > 
					<input id="terminal" type="text" value="" autocomplete="off" class="terminal_input" />
					<span id="terminal_root" class="terminal_root">'.$terminal_root.'</span>
				</div>
				<div id="otvet_terminal" class="terminal_otvet">'.$model->getComands().'</div>
			</div>
		';
	}
	
}
?>
