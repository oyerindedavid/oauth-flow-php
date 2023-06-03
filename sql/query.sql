CREATE TABLE `store`.`products` (
    `id` VARCHAR(11) NOT NULL , 
    `name` VARCHAR(255) NOT NULL , 
    `price` FLOAT NOT NULL , 
    `category_id` INT(11) NOT NULL ,
    `business_id` VARCHAR(255) NOT NULL ,  
    `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `last_modified` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    UNIQUE (`id`)
) ENGINE = InnoDB;

CREATE TABLE `store`.`clients` (
    `id` VARCHAR(255) NOT NULL , 
    `secrete` TEXT NOT NULL , 
    `name` VARCHAR(255) NOT NULL , 
    `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `last_modified` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    UNIQUE (`id`)
) ENGINE = InnoDB;

CREATE TABLE `store`.`tokens` (
    `id` INT(11) NOT NULL AUTO_INCREMENT , 
    `business_id` VARCHAR(255) NOT NULL , 
    `token` TEXT NOT NULL , 
    `client_id` VARCHAR NOT NULL , 
    `max_request` TINYINT(5) NOT NULL , 
    `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `last_modified` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `store`.`business` (
    `id` VARCHAR(255) NOT NULL , 
    `name` VARCHAR(255) NOT NULL , 
    `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `last_modified` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
     UNIQUE (`id`)
) ENGINE = InnoDB;
