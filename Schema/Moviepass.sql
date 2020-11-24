CREATE DATABASE IF NOT EXISTS tpfinalthemovie;
USE tpfinalthemovie;

CREATE TABLE IF NOT EXISTS `users`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(100) NOT NULL,
    `pass` VARCHAR(50) NOT NULL,
    `type` VARCHAR(20) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    CONSTRAINT `PK_Users` PRIMARY KEY (`id`),
    CONSTRAINT unq_email_user unique(`email`)
)Engine=InnoDB;
    
CREATE TABLE IF NOT EXISTS `cinemas`
(
	`id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50),
    `address` VARCHAR (50),
    `owner` INT NOT NULL,
    CONSTRAINT `pk_cinema` PRIMARY KEY (`id`),
    CONSTRAINT unq_name_cinema unique (`name`),
    CONSTRAINT unq_adrress_cinema unique (`address`),
    CONSTRAINT fk_user_cinema FOREIGN KEY (`owner`) REFERENCES users(`id`)
)Engine=InnoDB;
    
    
CREATE TABLE IF NOT EXISTS rooms
(
	`id` INT NOT NULL auto_increment,
    `name` VARCHAR(50) NOT NULL,
    `price` INT NOT NULL,
    `capacity` INT NOT NULL, 
    `id_cinema` INT NOT NULL,
    CONSTRAINT pk_room PRIMARY KEY (`id`),
    CONSTRAINT fk_room_cinema FOREIGN KEY (id_cinema) REFERENCES cinemas(`id`)
)Engine=InnoDB;
        
CREATE TABLE IF NOT EXISTS movies 
(
	`id` INT NOT NULL auto_increment,
    `title` VARCHAR(100) NOT NULL,
    `poster_path` VARCHAR(500),
    original_language VARCHAR (50),
    `overview` VARCHAR (500) NOT NULL,
    `release_date` date,
    `runtime` INT NOT NULL,
    CONSTRAINT pk_movie PRIMARY KEY (`id`)
)Engine=InnoDB;
        
CREATE TABLE IF NOT EXISTS screenings
(
	`id` INT NOT NULL auto_increment,
    `date` date NOT NULL,
	`time` time NOT NULL,
	`runtime` int NOT NULL,
    `sold` int NOT NULL,
    id_room INT NOT NULL,
    id_movie INT NOT NULL,
    CONSTRAINT pk_screening PRIMARY KEY(`id`),
    CONSTRAINT fk_room_screening FOREIGN KEY (id_room) REFERENCES rooms(`id`),
    CONSTRAINT fk_movie_screening FOREIGN KEY (id_movie) REFERENCES movies(`id`)
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
    CONSTRAINT pk_credit_cia PRIMARY KEY (`id`),
    CONSTRAINT unq_name_credit_cias unique (`name`)
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
        
CREATE TABLE IF NOT EXISTS genres
(
    `id` INT NOT NULL,
    `name` VARCHAR(50),
    CONSTRAINT pk_id_genre PRIMARY KEY (`id`),
    CONSTRAINT unq_name_genre unique (`name`)
)Engine=InnoDB;

CREATE TABLE IF NOT EXISTS moviesXgenres
(
    id_movie INT NOT NULL,
    id_genre INT NOT NULL,
    CONSTRAINT pk_moviesXgenres PRIMARY KEY (`id_movie`, `id_genre`),
    CONSTRAINT fk_movie_movieXgenre FOREIGN KEY (id_movie) REFERENCES movies(`id`),
    CONSTRAINT fk_genre_movieXgenre FOREIGN KEY (id_genre) REFERENCES genres(`id`)
)Engine=InnoDB;
	
DROP PROCEDURE IF EXISTS `Cinemas_GetAll`;

DELIMITER $$

CREATE PROCEDURE Cinemas_GetAll()
BEGIN
    SELECT cinemas.id as `id`, cinemas.name as `name`, cinemas.address as `address`, cinemas.owner as `owner`
    FROM cinemas;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_GetById`;

DELIMITER $$

CREATE PROCEDURE Cinemas_GetById(IN id INT)
BEGIN
    SELECT cinemas.id as `id`, cinemas.name as `name`, cinemas.address as `address`, users.id as `owner`
    FROM cinemas
    JOIN users
    ON (cinemas.owner = users.id)
    WHERE (cinemas.id = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_GetByOwnerId`;

DELIMITER $$

CREATE PROCEDURE Cinemas_GetByOwnerId(IN ownerId INT)
BEGIN
    SELECT cinemas.id as `id`, cinemas.name as `name`, cinemas.address as `address`, users.id as `owner`
    FROM cinemas
    JOIN users
    ON (cinemas.owner = users.id)
    WHERE (users.id = ownerId);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Cinemas_Add`;

DELIMITER $$

CREATE PROCEDURE Cinemas_Add(IN `name` VARCHAR(50), IN `address` VARCHAR(100), IN `owner` INT)
BEGIN
    INSERT INTO cinemas
        (cinemas.name, cinemas.address, cinemas.owner)
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

DROP PROCEDURE IF EXISTS `Rooms_Delete` ;

DELIMITER $$

CREATE PROCEDURE Rooms_Delete(IN id INT)
BEGIN   
    DELETE
    FROM rooms
    WHERE (rooms.id = id);
END$$

DELIMITER ;


DROP PROCEDURE IF EXISTS `Room_GetById` ;

DELIMITER $$ 

CREATE PROCEDURE Room_GetById (IN id INT)
BEGIN   
    SELECT rooms.id as `id`, rooms.name as `name`, rooms.capacity as `capacity`, rooms.price as `price`, rooms.id_cinema as `id_cinema`
    FROM rooms
    JOIN cinemas
    ON (rooms.id_cinema = cinemas.id)
    WHERE (rooms.id = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Rooms_Update` ;

DELIMITER $$

CREATE PROCEDURE Rooms_Update (IN id INT, IN `name` VARCHAR(50), IN capacity INT, IN price INT)
BEGIN
    UPDATE rooms
    SET rooms.name = `name`, rooms.capacity = capacity, rooms.price = price
    WHERE (rooms.id = id);
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

DROP PROCEDURE IF EXISTS `Screenings_GetById` ;

DELIMITER $$ 

CREATE PROCEDURE Screenings_GetById (IN id INT)
BEGIN   
    SELECT screenings.id as `id`, screenings.date as `date`, screenings.time as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings
    JOIN rooms
    ON (screenings.id_room = rooms.id)
    WHERE (screenings.id = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetByIdRoom` ;

DELIMITER $$ 

CREATE PROCEDURE Screenings_GetByIdRoom (IN id INT)
BEGIN   
    SELECT screenings.id as `id`, screenings.date as `date`, screenings.time as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings
    JOIN rooms
    ON (rooms.id = screenings.id_room)
    WHERE (screenings.id_room = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetByIdMovie` ;

DELIMITER $$ 

CREATE PROCEDURE Screenings_GetByIdMovie (IN id INT)
BEGIN   
    SELECT screenings.id as `id`, screenings.date as `date`, screenings.time as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings
    JOIN movies
    ON (movies.id = screenings.id_movie)
    WHERE (screenings.id_movie = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetAll` ;

DELIMITER $$ 

CREATE PROCEDURE Screenings_GetAll ()
BEGIN   
    SELECT screenings.id as `id`, screenings.date as `date`, screenings.time as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_Add`;

DELIMITER $$

CREATE PROCEDURE Screenings_Add(IN `date` date, IN `time` time, IN `runtime` INT, IN `id_room` INT, IN `id_movie` INT)
BEGIN
    INSERT INTO screenings
        (screenings.date, screenings.time, screenings.runtime, screenings.id_room, screenings.id_movie)
    VALUES
        (`date`, `time`, `runtime`, `id_room`, `id_movie`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_Delete`;

DELIMITER $$

CREATE PROCEDURE Screenings_Delete(IN id INT)
BEGIN   
    DELETE
    FROM screenings
    WHERE (screenings.id = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetCinemaByDateAndMovie`;

DELIMITER $$

CREATE PROCEDURE Screenings_GetCinemaByDateAndMovie(IN `date` date, IN `id_movie` INT)
BEGIN
    SELECT screenings.id as `id`, screenings.date as `date`, screenings.time as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings
    INNER JOIN rooms
    ON (screenings.id_room = rooms.id)
    WHERE (screenings.date = `date` AND screenings.id_movie = `id_movie`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Movies_Add`;

DELIMITER $$

CREATE PROCEDURE Movies_Add (IN `id` INT, IN `title` VARCHAR(100), IN `poster_path` VARCHAR(500), IN `original_language` VARCHAR(50), IN `overview` VARCHAR(500), iN `release_date` date, IN `runtime` INT)
BEGIN
    INSERT INTO movies
        (movies.id, movies.title, movies.poster_path, movies.original_language, movies.overview, movies.release_date, movies.runtime)
    VALUES
        (`id`, `title`, `poster_path`, `original_language`,`overview`, release_date, runtime);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Movies_GetById`;

DELIMITER $$

CREATE PROCEDURE Movies_GetById (IN id INT)
BEGIN
    SELECT movies.id as `id`, movies.title as `title`, movies.poster_path as `poster_path`, movies.original_language as `original_language`, movies.overview as `overview`, movies.release_date as `release_date`, movies.runtime as `runtime`
    FROM movies
    WHERE movies.id = `id`;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Movies_GetByDate`;

DELIMITER $$

CREATE PROCEDURE Movies_GetByDate (IN `date` INT)
BEGIN
    SELECT movies.id as `id`, movies.title as `title`, movies.poster_path as `poster_path`, movies.original_language as `original_language`, movies.overview as `overview`, movies.release_date as `release_date`, movies.runtime as `runtime`
    FROM movies
    WHERE movies.release_date = `date` ;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Genre_Add`;

DELIMITER $$

CREATE PROCEDURE Genre_Add (IN id INT, IN `name` VARCHAR(50))
BEGIN
    INSERT INTO genres
        (genres.id, genres.name)
    VALUES 
        (`id`, `name`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Genre_GetByIdMovie`;

DROP PROCEDURE IF EXISTS `Genre_GetById`;

DELIMITER $$

CREATE PROCEDURE Genre_GetById (IN id INT)
BEGIN
SELECT genres.id as `id`, genres.name as `name`
FROM genres
WHERE genres.id = id;
END $$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Mxg_GetGenresByIdMovie`;

DELIMITER $$

CREATE PROCEDURE Mxg_GetGenresByIdMovie (IN id INT)
BEGIN
    SELECT moviesXgenres.id_genre as `idGenre`
    FROM moviesXgenres
    WHERE moviesXgenres.id_movie = id;
END $$

DELIMITER ;

DROP PROCEDURE IF EXISTS `moviesXgenres_Add`;

DELIMITER $$

CREATE PROCEDURE moviesXgenres_Add (IN id_movie INT, IN id_genre INT)
BEGIN
    INSERT INTO moviesXgenres
        (moviesXgenres.id_movie, moviesXgenres.id_genre)
    VALUES
        (`id_movie`, `id_genre`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Movies_GetMoviesWithScreenings`;

DELIMITER $$

CREATE PROCEDURE Movies_GetMoviesWithScreenings (IN `dateNow` date)
BEGIN
    select movies.id as `id`, movies.title as `title`, movies.poster_path as `poster_path`, movies.original_language as `original_language`, movies.overview as `overview`, movies.release_date as `release_date`, movies.runtime as `runtime`
    FROM screenings
    INNER JOIN movies
    ON screenings.id_movie = movies.id
    WHERE screenings.date >= `dateNow`
    group by movies.id;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Movies_GetMoviesWithScreeningsByOwner`;

DELIMITER $$

CREATE PROCEDURE Movies_GetMoviesWithScreeningsByOwner (IN `idOwner` INT)
BEGIN
    select movies.id as `id`, movies.title as `title`, movies.poster_path as `poster_path`, movies.original_language as `original_language`, movies.overview as `overview`, movies.release_date as `release_date`, movies.runtime as `runtime`
    FROM screenings
    INNER JOIN movies
    ON screenings.id_movie = movies.id
    INNER JOIN rooms
    ON screenings.id_room = rooms.id
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (cinemas.owner = `idOwner`)
    group by movies.id;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Movies_GetMoviesWithScreeningsByDate`;

DELIMITER $$

CREATE PROCEDURE Movies_GetMoviesWithScreeningsByDate (IN `date` date)
BEGIN
    select movies.id as `id`, movies.title as `title`, movies.poster_path as `poster_path`, movies.original_language as `original_language`, movies.overview as `overview`, movies.release_date as `release_date`, movies.runtime as `runtime`
    FROM screenings
    INNER JOIN movies
    ON screenings.id_movie = movies.id
    WHERE screenings.date = `date`
    group by movies.id;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetFinishHourScreening`;

DELIMITER $$

CREATE PROCEDURE Screenings_GetFinishHourScreening (IN id_room INT, IN `date` date)
BEGIN 
	select screenings.id as `id`, screenings.date as `date`, MAX(screenings.time) as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings
    WHERE (screenings.id_room = id_room) AND (screenings.date = `date`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Mxg_GetMoviesByIdGenre`;

DELIMITER $$

CREATE PROCEDURE Mxg_GetMoviesByIdGenre(IN id INT)
BEGIN
    select moviesXgenres.id_movie as id_movie, moviesXgenres.id_genre as id_genre
    FROM moviesXgenres
    WHERE (moviesXgenres.id_genre = id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetByIdRoomAndDate` ;

DELIMITER $$ 

CREATE PROCEDURE Screenings_GetByIdRoomAndDate (IN id INT, IN `date` date)
BEGIN   
    SELECT screenings.id as `id`, screenings.date as `date`, screenings.time as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings
    JOIN rooms
    ON (rooms.id = screenings.id_room)
    WHERE (screenings.id_room = id ) AND (screenings.date = `date`)
    ORDER BY screenings.time;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetByOwner` ;

DELIMITER $$

CREATE PROCEDURE Screenings_GetByOwner (IN idOwner INT)
BEGIN
    SELECT screenings.id as `id`, screenings.date as `date`, screenings.time as `time`, screenings.runtime as `runtime`, screenings.sold as `sold`, screenings.id_room as `id_room`, screenings.id_movie as `id_movie`
    FROM screenings
    JOIN rooms
    ON (rooms.id = screenings.id_room)
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (cinemas.owner = idOwner);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetCapacityByMovie` ;

DELIMITER $$

CREATE PROCEDURE Screenings_GetCapacityByMovie (IN idMovie INT, IN idOwner INT)
BEGIN
    SELECT (SUM(rooms.capacity)) as `capacity`
    FROM screenings
    JOIN rooms
    ON (rooms.id = screenings.id_room)
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (cinemas.owner = idOwner AND screenings.id_movie = idMovie);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_GetCapacityByCinema` ;

DELIMITER $$

CREATE PROCEDURE Screenings_GetCapacityByCinema (IN idCinema INT)
BEGIN
    SELECT (SUM(rooms.capacity)) as `capacity`
    FROM screenings
    JOIN rooms
    ON (rooms.id = screenings.id_room)
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (cinemas.id = idCinema);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Screenings_SumSoldScreening` ;

DELIMITER $$

CREATE PROCEDURE Screenings_SumSoldScreening (IN idScreening INT, IN quantity INT)
BEGIN
    UPDATE `screenings`
    SET `sold`= `quantity` 
    WHERE screenings.id = `idScreening`;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Tickets_Add` ;

DELIMITER $$ 

CREATE PROCEDURE Tickets_Add (IN idScreening INT, IN idUser INT)
BEGIN
    INSERT INTO tickets
        (tickets.id_screening, tickets.id_user)
    VALUES
        (`idScreening`, `idUser`);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Tickets_GetByUser` ;

DELIMITER $$ 

CREATE PROCEDURE Tickets_GetByUser (IN idUser INT)
BEGIN   
    SELECT tickets.id as `id`, tickets.id_user as `idUser`, tickets.id_screening as `idScreening`
    FROM tickets
    WHERE tickets.id_user = idUser
    ORDER BY tickets.id_screening;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Tickets_GetAvailability` ;

DELIMITER $$ 

CREATE PROCEDURE Tickets_GetAvailability (IN idScreening INT)
BEGIN   
    SELECT COUNT(tickets.id) as `quantity`
    FROM tickets
    WHERE tickets.id_screening = idScreening;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `ScreeningsByIdMovieAndDate`;

DELIMITER $$

CREATE PROCEDURE ScreeningsByIdMovieAndDate ( IN id_movie INT, IN `date_1` date, IN `date_2` date)
BEGIN
	SELECT s.id as `id_screening`,r.price as `price`
	FROM screenings s 
	JOIN rooms r 
	ON r.id = s.id_room
	WHERE s.id_movie = id_movie && s.date between `date_1` and `date_2`;
END $$

DELIMITER ;

DROP PROCEDURE IF EXISTS `ScreeningsByIdCineAndDate`;

DELIMITER $$

CREATE PROCEDURE ScreeningsByIdCineAndDate ( IN id_cine INT, IN `date_1` date, IN `date_2` date)
BEGIN
	SELECT s.id as `id_screening`,r.price as `price`
	FROM rooms r
	JOIN screenings s  
	ON s.id_room = r.id
	WHERE r.id_cinema = id_cine && s.date between `date_1` and `date_2`;
END $$

DROP PROCEDURE IF EXISTS `Tickets_GetListMoviesByOwner`;

DELIMITER $$

CREATE PROCEDURE Tickets_GetListMoviesByOwner(IN idOwner INT)
BEGIN
    SELECT movies.title as `title`, SUM(screenings.sold) as `sold`, movies.id as `idMovie`
    FROM `screenings`
    JOIN `movies`
    ON (screenings.id_movie = movies.id)
    JOIN `rooms`
    ON (rooms.id = screenings.id_room)
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (cinemas.owner = `idOwner`)
    GROUP BY (screenings.id_movie);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Tickets_GetListCinemasByOwner` ;

DELIMITER $$

CREATE PROCEDURE Tickets_GetListCinemasByOwner(IN idOwner INT)
BEGIN
    SELECT cinemas.name as `cinema`, SUM(screenings.sold) as `sold`, cinemas.id as `idCinema`
    FROM `screenings`
    JOIN `rooms`
    ON (rooms.id = screenings.id_room)
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (cinemas.owner = `idOwner`)
    GROUP BY (cinemas.id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Tickets_GetListRoomsByCinema` ;

DELIMITER $$

CREATE PROCEDURE Tickets_GetListRoomsByCinema(IN idCinema INT)
BEGIN
    SELECT rooms.name as `room`, SUM(screenings.sold) as `sold`, SUM(rooms.capacity) as `capacity`
    FROM `screenings`
    JOIN `rooms`
    ON (rooms.id = screenings.id_room)
    JOIN cinemas
    ON (cinemas.id = rooms.id_cinema)
    WHERE (cinemas.id = `idCinema`)
    GROUP BY (rooms.id);
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS `Tickets_GetById` ;

DELIMITER $$

CREATE PROCEDURE Tickets_GetById (IN idTicket INT)
BEGIN
    SELECT tickets.id as `id`, tickets.id_user as idUser, tickets.id_screening as idScreening
    FROM `tickets`
    WHERE (tickets.id = idTicket);
END$$

DELIMITER ;

