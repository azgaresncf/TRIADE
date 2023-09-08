CREATE TABLE `T_CNF_CONFERENCE` (
  `ID_CONFERENCE` INT NOT NULL AUTO_INCREMENT,
  `ID_USER` INT NOT NULL ,
  `CNF_DATE_CREAT` date NOT NULL default '0000-00-00',
  `CNF_TIME_CREAT` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`ID_CONFERENCE`),
  KEY `ID_USER` (`ID_USER`)
) COMMENT = 'Conferences';


CREATE TABLE `T_USC_USERCONF` (
  `ID_CONFERENCE` INT NOT NULL ,
  `ID_USER` INT NOT NULL ,
  `USC_ACTIVE` TINYINT NOT NULL DEFAULT '0',
  INDEX ( `ID_CONFERENCE` , `ID_USER` )
) COMMENT = 'Users in conferences';


ALTER TABLE `T_MSG_MESSAGE` ADD `ID_CONFERENCE` INT NOT NULL default '0';
