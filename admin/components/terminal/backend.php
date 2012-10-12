<?php
	if(!defined('VALID_CMS_ADMIN')) { die('ACCESS DENIED'); }
	
	cpAddPathway('Терминал', '?view=components&do=config&id='.$_REQUEST['id']);
	
	echo '<h3>Терминал</h3>';
	
	if (isset($_REQUEST['opt'])) { $opt = $_REQUEST['opt']; } else { $opt = 'list'; }
	
	$toolmenu = array();
	$toolmenu[0]['icon'] = 'save.gif';
	$toolmenu[0]['title'] = 'Сохранить';
	$toolmenu[0]['link'] = 'javascript:document.optform.submit();';
	$toolmenu[1]['icon'] = 'cancel.gif';
	$toolmenu[1]['title'] = 'Отмена';
	$toolmenu[1]['link'] = '?view=components';
	cpToolMenu($toolmenu);
	
	$cfg = $inCore->loadComponentConfig('terminal');
	$salt = $cfg['salt'];
	
	if($opt=='saveconfig'){	
		$cfg = array();
		$cfg['name'] = $_REQUEST['name'];
		$cfg['password'] = md5($salt.$_REQUEST['password'].$_SERVER['SERVER_NAME']);
		$cfg['salt'] = $salt;
		$inCore->saveComponentConfig('terminal', $cfg);
		$msg = 'Настройки сохранены.';
	}
	
	global $_CFG;
	
	if(!isset($cfgout['name'])) { $cfgout['name'] = 'terminal'; }
	
	if (@$msg) { echo '<p class="success">'.$msg.'</p>'; }
?>
	<form action="index.php?view=components&amp;do=config&amp;id=<?php echo $_REQUEST['id'];?>" method="post" name="optform" target="_self" id="form1">
		<table width="100%" border="0" cellpadding="10" cellspacing="0" class="proptable">
			<tr>
				<td>Имя терминала: </td>
				<td valign="top">
					<input name="name" type="text" id="" size="50" value="<?php echo @$cfg['name'];?>"/>
				</td>
			</tr>
			<tr>
				<td>Пароль root: </td>
				<td valign="top">
					<input name="password" type="text" id="" size="50" value=""/>
				</td>
			</tr>
		</table>
		<p>
			<input name="opt" type="hidden" value="saveconfig" />
			<input name="save" type="submit" id="save" value="Сохранить" />
			<input name="back" type="button" id="back" value="Отмена" onclick="window.location.href='index.php?view=components';"/>
		</p>
	</form>