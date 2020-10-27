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
    
CREATE TABLE IF NOT EXISTS rooms
(
	`id` INT NOT NULL auto_increment,
    `name` VARCHAR(50),
    `price` INT NOT NULL,
    `capacity` INT NOT NULL, 
    `id_cinema` INT NOT NULL,
    CONSTRAINT pk_room PRIMARY KEY (`id`),
    CONSTRAINT fk_room_cinema FOREIGN KEY (id_cinema) REFERENCES cinemas(`id`)
)Engine=InnoDB;
        
/*CREATE TABLE IF NOT EXISTS movies 
(
	`id` INT NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `poster_path` VARCHAR(500),
    original_language VARCHAR (50),
    `overview` VARCHAR (500) NOT NULL,
    `release_date` date,
    `id_genre` INT NOT NULL,
    CONSTRAINT pk_movie PRIMARY KEY (`id`)
)Engine=InnoDB;*/
        
CREATE TABLE IF NOT EXISTS screenings
(
	`id` INT NOT NULL auto_increment,
    `day` date NOT NULL,
	`time` time NOT NULL,
	`runtime` int NOT NULL,
    id_room INT NOT NULL,
    id_movie INT NOT NULL,
    CONSTRAINT pk_screening PRIMARY KEY(`id`),
    CONSTRAINT fk_room_screening FOREIGN KEY (id_room) REFERENCES rooms(`id`)/*,
    CONSTRAINT fk_movie_screening FOREIGN KEY (id_movie) REFERENCES movies(`id`)*/
)Engine=InnoDB;
        
CREATE TABLE IF NOT EXISTS tickets 
(
	`id` INT NOT NULL auto_increment,
    id_user INT NOT NULL,
    id_screening INT NOT NULL, 
	CONSTRAINT pk_ticket PRIMARY KEY (`id`),
    CONSTRAINT fk_user_tickets FOREIGN KEY (id_user) REFERENCES users(`id`),
    CONSTRAINT fk_screening_tickets FOREIGN KEY(id_screening) REFERENCES screenings(`id`)
)Engine=InnoDB;
        
CREATE TABLE IF NOT EXISTS credit_cias 
(
	`id` INT NOT NULL auto_increment,
    `name` VARCHAR(50),
    CONSTRAINT pk_credit_cia PRIMARY KEY (`id`)
)Engine=InnoDB;
        
CREATE TABLE IF NOT EXISTS bill
(
	`id` INT NOT NULL auto_increment,
    `day` datetime NOT NULL,
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
        
	
DROP PROCEDURE IF EXISTS `Cinemas_GetAll`;

DELIMITER $$

CREATE PROCEDURE Cinemas_GetAll()
BEGIN
    SELECT cinemas.id as `id`, cinemas.name as `name`, cinemas.address as `address`, users.id as `owner`
    FROM cinemas
    JOIN users
    ON (cinemas.id_user = users.id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_GetById`;

DELIMITER $$

CREATE PROCEDURE Cinemas_GetById(IN id INT)
BEGIN
    SELECT cinemas.id as `id`, cinemas.name as `name`, cinemas.address as `address`, users.id as `owner`
    FROM cinemas
    JOIN users
    ON (cinemas.id_user = users.id)
    WHERE (cinemas.id = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_GetByOwnerId`;

DELIMITER $$

CREATE PROCEDURE Cinemas_GetByOwnerId(IN ownerId INT)
BEGIN
    SELECT cinemas.id as `id`, cinemas.name as `name`, cinemas.address as `address`, users.name as `owner`
    FROM cinemas
    JOIN users
    ON (cinemas.id_user = users.id)
    WHERE (users.id = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_Add`;

DELIMITER $$

CREATE PROCEDURE Cinemas_Add(IN `name` VARCHAR(50), IN `address` VARCHAR(100), IN `owner` INT)
BEGIN
    INSERT INTO cinemas
        (cinemas.name, cinemas.address, cinemas.id_user)
    VALUES
        (`name`, `address`, `owner`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_Update`;

DELIMITER $$

CREATE PROCEDURE Cinemas_Update(IN `id` INT, IN `name` VARCHAR(50), IN `address` VARCHAR(100))
BEGIN
    UPDATE `cinemas`
    SET cinemas.name=`name`, cinemas.address=`address`
    WHERE cinemas.id = `id`;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_Delete`;

DELIMITER $$

CREATE PROCEDURE Cinemas_Delete(IN id INT)
BEGIN
    DELETE
    FROM cinemas
    WHERE (cinemas.id = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Rooms_Add`;

DELIMITER $$

CREATE PROCEDURE Rooms_Add(IN `name` VARCHAR(50), IN price INT, IN capacity INT, IN id_cinema INT)
BEGIN
    INSERT INTO rooms
        (rooms.name, rooms.price, rooms.capacity, rooms.id_cinema)
    VALUES
        (`name`, price, capacity, id_cinema);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Rooms_GetByCinemaId`;

DELIMITER $$

CREATE PROCEDURE Rooms_GetByCinemaId(IN id INT)
BEGIN
    SELECT rooms.id as `id`, rooms.name as `name`, rooms.price as `price`,
        rooms.capacity as `capacity`, rooms.id_cinema as `idCinema`
    FROM rooms
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (rooms.id_cinema = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Users_GetByEmail`;

DELIMITER $$

CREATE PROCEDURE Users_GetByEmail(IN email VARCHAR(100))
BEGIN
    SELECT users.id as `id`, users.email as `email`, users.pass as `pass`, users.type as `type`, users.name as `name`
    FROM users
    WHERE (users.email = email);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Users_GetById`;

DELIMITER $$

CREATE PROCEDURE Users_GetByid(IN id INT)
BEGIN
    SELECT users.id as `id`, users.email as `email`, users.pass as `pass`, users.type as `type`, users.name as `name`
    FROM users
    WHERE (users.id = id);
    END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Users_GetAll`;

DELIMITER $$

CREATE PROCEDURE Users_GetAll()
BEGIN
    SELECT users.id as `id`, users.email as `email`, users.pass as `pass`, users.type as `type`, users.name as `name`
    FROM users;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Users_Add`;

DELIMITER $$

CREATE PROCEDURE Users_Add(IN `name` VARCHAR(50), IN email VARCHAR(100), IN pass VARCHAR(50), IN `type` VARCHAR(10))
BEGIN
    INSERT INTO users
        (users.name, users.email, users.pass, users.type)
    VALUES
        (`name`, `email`, `pass`, `type`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Users_Delete`;

DELIMITER $$

CREATE PROCEDURE Users_Delete (in email VARCHAR(100))
BEGIN
    DELETE 
    FROM users
    WHERE (users.email = email);
END$$

DELIMITER ;


