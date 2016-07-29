
CREATE TABLE IF NOT EXISTS `PRE_upload` (
`upload_id` INT( 5 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`upload_number` INT( 5 ) NOT NULL ,
`upload_label` VARCHAR( 200 ) NOT NULL ,
`upload_name` VARCHAR( 100 ) NOT NULL ,
`upload_extension` VARCHAR( 10 ) NOT NULL ,
`upload_size` INT( 10 ) NOT NULL ,
`upload_dimensions` VARCHAR( 250 ) NOT NULL,
`upload_object` VARCHAR( 100 ) NOT NULL
) ENGINE = MYISAM;
