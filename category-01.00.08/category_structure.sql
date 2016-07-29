
CREATE TABLE IF NOT EXISTS `PRE_category` (
`category_id` INT( 3 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`parent_id` INT( 3 ) NOT NULL ,
`orderby` INT( 3 ) NOT NULL ,
`category_label` VARCHAR( 100 ) NOT NULL
) ENGINE = MYISAM COMMENT =  'categorie avec libelle';
