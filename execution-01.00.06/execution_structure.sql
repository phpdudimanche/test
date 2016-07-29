
CREATE TABLE IF NOT EXISTS `PRE_execution_scenario` (
`exs_id` INT( 3 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`exs_category_id` INT( 3 ) NOT NULL ,
`exs_label` VARCHAR( 250 ) NOT NULL,
`exs_create_date` date NOT NULL COMMENT 'beginning',
`exs_close_date` date NOT NULL COMMENT 'end'
) ENGINE = MYISAM COMMENT =  'scenario run';


CREATE TABLE IF NOT EXISTS `PRE_execution_steps` (
`exp_id` INT( 3 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`exp_step_id` INT( 3 ) NOT NULL ,
`exp_execution_id` INT( 3 ) NOT NULL ,
`exp_obtained` VARCHAR( 250 ),
`exp_status` INT( 1 )
) ENGINE = MYISAM COMMENT =  'test run';