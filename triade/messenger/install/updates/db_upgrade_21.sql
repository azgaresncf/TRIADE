ALTER TABLE `IM_USR_USER` ADD `ID_ROLE` TINYINT UNSIGNED NULL default NULL AFTER `USR_LEVEL`;


CREATE TABLE IF NOT EXISTS `IM_ROL_ROLE` (
  `ID_ROLE` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ROL_NAME` varchar(40) NOT NULL,
  `ROL_DEFAULT` char(1) NOT NULL,
  PRIMARY KEY  (`ID_ROLE`)
) COMMENT = 'Roles';
--  Guest  Manager  Administrator  


CREATE TABLE IF NOT EXISTS `IM_MDL_MODULE` (
  `ID_MODULE` TINYINT UNSIGNED NOT NULL,
  `MDL_NAME` varchar(60) NOT NULL,
  PRIMARY KEY  (`ID_MODULE`)
) COMMENT = 'Modules/options';


CREATE TABLE `IM_RLM_ROLEMODULE` (
  `ID_ROLE` SMALLINT UNSIGNED NOT NULL,
  `ID_MODULE` TINYINT UNSIGNED NOT NULL,
  `RLM_STATE` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `RLM_VALUE` SMALLINT UNSIGNED NOT NULL,
  PRIMARY KEY (`ID_ROLE`, `ID_MODULE`),
  CONSTRAINT `im_rlm_rolemodule_fk1` FOREIGN KEY `im_rlm_rolemodule_fk1` (`ID_ROLE`)
    REFERENCES `IM_ROL_ROLE` (`ID_ROLE`)
    ON DELETE NO ACTION   ON UPDATE NO ACTION,
  CONSTRAINT `im_rlm_rolemodule_fk2` FOREIGN KEY `im_rlm_rolemodule_fk2` (`ID_MODULE`)
    REFERENCES `IM_MDL_MODULE` (`ID_MODULE`)
    ON DELETE NO ACTION   ON UPDATE NO ACTION
) COMMENT = 'Roles access to modules';
