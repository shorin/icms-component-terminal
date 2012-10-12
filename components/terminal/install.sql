DROP TABLE IF EXISTS `#__terminal_log`;

CREATE TABLE `#__terminal_log` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`comand_time` DATETIME NOT NULL ,
`comand` VARCHAR( 800 ) NOT NULL ,
`ip` VARCHAR( 16 ) NOT NULL ,
INDEX ( `id` )
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=2 ;

INSERT INTO `#__terminal_log` (`id`, `comand_time`, `comand`, `ip`) VALUES
(1, NOW(), 'terminal > для начала работы введите <b>help</b>', '127.0.0.1');

DROP TABLE IF EXISTS `#__terminal_comands`;

CREATE TABLE `#__terminal_comands` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`comand` VARCHAR( 25 ) NOT NULL ,
`info` VARCHAR( 800 ) NOT NULL ,
`root` VARCHAR( 25 ) NOT NULL ,
INDEX ( `id` )
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

INSERT INTO `#__terminal_comands` (`id`, `comand`, `info`, `root`) VALUES
(1, 'help', 'первоначальная помощь', 'admin'),
(2, 'info', 'информация о команде. <b>info команда</b> ', 'admin'),
(3, 'su', 'авторизация с правами <b>root</b>.<br><b>su пароль</b> - вход ; <b>su exit</b> - выход', 'admin'),
(4, 'comand', 'Управление командами. <b>comand install команда</b> - установка команды; <b>comand remove команда</b> - удаление команды; <b>comand chown команда параметр</b> - изменение допуска к команде, параметр может быть либо <b>admin</b> либо <b>root</b>', 'root');