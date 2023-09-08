CREATE TABLE IF NOT EXISTS `IM_SRV_SERVERSTATE` (
  `ID_SERVER` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `SRV_NAME` varchar(60) NOT NULL,
  `SRV_IP_ADDRESS` varchar(23) NOT NULL default '',
  `SRV_STATE` TINYINT UNSIGNED NOT NULL default '0',
  `SRV_STATE_DATE` date NOT NULL default '0000-00-00',
  `SRV_STATE_TIME` time NOT NULL default '00:00:00',
  `SRV_STATE_COMMENT` varchar(150) default '' NOT NULL,
  PRIMARY KEY  (`ID_SERVER`),
  UNIQUE KEY `SRV_NAME` (`SRV_NAME`)
) COMMENT = 'Servers states';


CREATE TABLE IF NOT EXISTS `IM_SBX_SHOUTBOX` (
  `ID_SHOUT` MEDIUMINT UNSIGNED NOT NULL auto_increment,
  `ID_GROUP_DEST` SMALLINT UNSIGNED NOT NULL default '0',
  `ID_USER_AUT` MEDIUMINT NOT NULL,
  `SBX_TEXT` varchar(250) NOT NULL,
  `SBX_TIME` time NOT NULL,
  `SBX_DATE` date NOT NULL,
  `SBX_DISPLAY` TINYINT NOT NULL default '1',
  `SBX_RATING` TINYINT NOT NULL default '0',
  PRIMARY KEY  (`ID_SHOUT`),
  KEY `SBX_IND_1` (`SBX_DATE`, `SBX_TIME`),
  KEY `SBX_IND_2` (`ID_SHOUT`, `ID_GROUP_DEST`)
) COMMENT = 'ShoutBox';


CREATE TABLE IF NOT EXISTS `IM_SBS_SHOUTSTATS` (
  `ID_USER_AUT` MEDIUMINT NOT NULL,
  `SBS_NB` SMALLINT UNSIGNED NOT NULL default '1',
  `SBS_NB_REJECT` TINYINT UNSIGNED NOT NULL default '0',
  `SBS_NB_VOTE_M` SMALLINT UNSIGNED NOT NULL default '0' COMMENT 'More',
  `SBS_NB_VOTE_L` SMALLINT UNSIGNED NOT NULL default '0' COMMENT 'Less',
  `SBS_NB_LAST_DATE` SMALLINT UNSIGNED NOT NULL default '1' COMMENT 'Day quota',
  `SBS_LAST_DATE` date NOT NULL,
  `SBS_NB_LAST_WEEK` SMALLINT UNSIGNED NOT NULL default '1' COMMENT 'Week quota',
  `SBS_LAST_WEEK` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY  (`ID_USER_AUT`)
) COMMENT = 'Stats shoutbox';


CREATE TABLE IF NOT EXISTS `IM_SBV_SHOUTVOTE` (
  `ID_SHOUT` MEDIUMINT UNSIGNED NOT NULL,
  `ID_USER_VOTE` MEDIUMINT NOT NULL,
  `ID_USER_AUT` MEDIUMINT NOT NULL COMMENT 'For stats',
  `SBV_DATE` date NOT NULL,
  `SBV_VOTE_M` TINYINT NOT NULL COMMENT 'More',
  `SBV_VOTE_L` TINYINT NOT NULL COMMENT 'Less',
  PRIMARY KEY  (`ID_SHOUT`, `ID_USER_VOTE`),
  KEY `SBV_IND_1` (`ID_USER_AUT`)
) COMMENT = 'Votes shoutbox';


