-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_form_field`
-- 

CREATE TABLE `tl_form_field` (
  `loadCSV` char(1) NOT NULL default '',
  `source` varchar(255) NOT NULL default '',
  `csvSeparator` varchar(10) NOT NULL default '',
  `csvCache` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

