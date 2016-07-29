
CREATE TABLE IF NOT EXISTS `PRE_scenario_step` (
  `sc_step_id` int(3) NOT NULL AUTO_INCREMENT,
  `sc_step_action` varchar(250) NOT NULL,
  `sc_step_expected` varchar(250) NOT NULL,
  `sc_step_order` int(2) NOT NULL,
  `sc_step_scenario_id` int(3) NOT NULL,
  PRIMARY KEY (`sc_step_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='scenario''s steps' AUTO_INCREMENT=1 ;