DROP TABLE IF EXISTS `#__terminal_log`;

CREATE TABLE `#__terminal_log` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`comand_time` DATETIME NOT NULL ,
`comand` VARCHAR( 800 ) NOT NULL ,
`ip` VARCHAR( 16 ) NOT NULL ,
INDEX ( `id` )
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

INSERT INTO `#__terminal_log` (`id`, `comand_time`, `comand`, `ip`) VALUES
(1, NOW(), 'terminal > ��� ������ ������ ������� <b>help</b>', '127.0.0.1');

DROP TABLE IF EXISTS `#__terminal_comands`;

CREATE TABLE `#__terminal_comands` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`comand` VARCHAR( 25 ) NOT NULL ,
`info` VARCHAR( 800 ) NOT NULL ,
`root` VARCHAR( 25 ) NOT NULL ,
INDEX ( `id` )
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

INSERT INTO `#__terminal_comands` (`id`, `comand`, `info`, `root`) VALUES
(1, 'help', '�������������� ������', 'admin'),
(2, 'info', '���������� � �������. <b>info �������</b> ', 'admin'),
(3, 'su', '����������� � ������� <b>root</b>.<br><b>su ������</b> - ���� ; <b>su exit</b> - �����', 'admin'),
(4, 'comand', '���������� ���������. <b>comand install �������</b> - ��������� �������; <b>comand remove �������</b> - �������� �������; <b>comand chown ������� ��������</b> - ��������� ������� � �������, �������� ����� ���� ���� <b>admin</b> ���� <b>root</b>', 'root');