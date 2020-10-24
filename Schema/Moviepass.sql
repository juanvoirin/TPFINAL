CREATE DATABASE IF NOT EXISTS sql10372627;
USE sql10372627;

CREATE TABLE IF NOT EXISTS `users`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `pass` VARCHAR(50) NOT NULL,
    `type` VARCHAR(20) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    CONSTRAINT `PK_Users` PRIMARY KEY (`id`)
)Engine=InnoDB;
    
CREATE TABLE IF NOT EXISTS `cinemas`
(
	`id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50),
    `address` VARCHAR (50),
    `owner` INT NOT NULL,
    CONSTRAINT `pk_cinema` PRIMARY KEY (`id`),
    CONSTRAINT unq_name unique (`name`),
    CONSTRAINT unq_adrress unique (`address`),
    CONSTRAINT fk_user_cinema FOREIGN KEY (`owner`) REFERENCES users(`id`)
)Engine=InnoDB;
    
CREATE TABLE rooms
(
	`id` INT NOT NULL auto_increment,
    `name` VARCHAR(50),
    `price` INT NOT NULL,
    `capacity` INT NOT NULL, 
    `id_cinema` INT NOT NULL,
    CONSTRAINT pk_room PRIMARY KEY (`id`),
    CONSTRAINT fk_room_cinema FOREIGN KEY (id_cinema) REFERENCES cinemas(`id`)
)Engine=InnoDB;
        
CREATE TABLE movies 
(
	`id` INT NOT NULL,
    `title` VARCHAR(100),
    `poster_path` VARCHAR(500),
    original_language VARCHAR (50),
    `overview` VARCHAR (500),
    `release_date` date,
    `id_genre` INT NOT NULL,
    CONSTRAINT pk_movie PRIMARY KEY (`id`)
)Engine=InnoDB;
        
CREATE TABLE screenings
(
	`id` INT NOT NULL auto_increment,
    `day` datetime,
    id_room INT NOT NULL,
    id_movie INT NOT NULL,
    CONSTRAINT pk_screening PRIMARY KEY(`id`),
    CONSTRAINT fk_room_screening FOREIGN KEY (id_room) REFERENCES rooms(`id`),
    CONSTRAINT fk_movie_screening FOREIGN KEY (id_movie) REFERENCES movies(`id`)
)Engine=InnoDB;
        
CREATE TABLE tickets 
(
	`id` INT NOT NULL auto_increment,
    id_user INT NOT NULL,
    id_screening INT NOT NULL, 
	CONSTRAINT pk_ticket PRIMARY KEY (`id`),
    CONSTRAINT fk_user_tickets FOREIGN KEY (id_user) REFERENCES users(`id`),
    CONSTRAINT fk_screening_tickets FOREIGN KEY(id_screening) REFERENCES screenings(`id`)
)Engine=InnoDB;
        
CREATE TABLE credit_cias 
(
	`id` INT NOT NULL auto_increment,
    `name` VARCHAR(50),
    CONSTRAINT pk_credit_cia PRIMARY KEY (`id`)
)Engine=InnoDB;
        
CREATE TABLE bill
(
	`id` INT NOT NULL auto_increment,
    `day` datetime,
    `quantity` INT NOT NULL,
    `price` INT NOT NULL,
    id_user INT NOT NULL,
    id_screening INT NOT NULL,
    id_credit_cia INT NOT NULL,
    CONSTRAINT pk_bill PRIMARY KEY (`id`),
    CONSTRAINT fk_user_bill FOREIGN KEY (id_user) REFERENCES users(`id`),
    CONSTRAINT fk_screening_bill FOREIGN KEY(id_screening) REFERENCES screenings(`id`),
    CONSTRAINT fk_credit_cia_bill FOREIGN KEY (id_credit_cia) REFERENCES credit_cias(`id`)
)Engine=InnoDB;
        
	
DROP procedure IF EXISTS `Cinemas_GetAll`;

DELIMITER $$

CREATE PROCEDURE Cinemas_GetAll()
BEGIN
    SELECT cinemas.name as `name`, cinemas.address as `address`, users.name as `owner`
    FROM cinemas
    JOIN users
    ON (cinemas.id_user = users.id);
END$$

DELIMITER ;