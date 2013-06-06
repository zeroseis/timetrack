CREATE TABLE  `users` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NULL
) ENGINE = MYISAM ;

CREATE TABLE  `clients` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NULL
) ENGINE = MYISAM ;

CREATE TABLE  `projects` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NULL ,
`client_id` INT( 10 ) NULL
) ENGINE = MYISAM ;

CREATE TABLE  `tasks` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`start` INT( 10 ) NULL ,
`end` INT( 10 ) NULL ,
`description` VARCHAR( 255 ) NULL ,
`project_id` INT( 10 ) NULL ,
`user_id` INT( 10 ) NULL
) ENGINE = MYISAM ;