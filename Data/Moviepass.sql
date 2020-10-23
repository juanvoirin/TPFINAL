create database MoviePass;
use MoviePass;

create table users (
	email varchar(100),
    id int auto_increment,
    pass varchar(50),
    type varchar(10),
    name varchar(50),
    constraint pk_user primary key (id),
    constraint uc_email unique (email)
    );
    
create table cinemas (
	id int not null auto_increment,
    name varchar(50),
    address varchar (50),
    id_user int not null,
    constraint pk_cinema primary key (id),
    constraint uc_name unique (name),
    constraint uc_adrress unique (address),
    constraint fk_user foreign key (id_user) references users(id)
    );
    
    create table rooms(
		id int not null auto_increment,
        name varchar(50),
        price int not null,
        capacity int not null, 
        id_cinema int not null,
        constraint pk_room primary key (id),
        constraint fk_room_cinema foreign key (id_cinema) references cinemas(id)
        );
        
        create table movies (
			id int not null,
            title varchar(100),
            poster_path varchar(500),
            original_language varchar (50),
            overview varchar (500),
            release_date date,
            id_genre int not null,
            constraint pk_movie primary key (id)
            );
        
	create table screenings (
		id int not null auto_increment,
        day datetime,
        id_room int not null,
        id_movie int not null,
        constraint pk_screening primary key(id),
        constraint fk_room foreign key (id_room) references rooms(id),
        constraint fk_movie foreign key (id_movie) references movies(id)
        );
        
	create table tickets (
		id int not null auto_increment,
        id_user int not null,
        id_screening int not null, 
		constraint pk_ticket primary key (id),
        constraint fk_user foreign key (id_user) references users(id),
        constraint fk_screening foreign key(id_screening) references screenings(id)
        );
        
        create table credit_cias (
		id int not null auto_increment,
        name varchar(50),
        constraint pk_credit_cia primary key (id)
        );
        
	create table Bill (
		id int not null auto_increment,
        day datetime,
        quantity int not null,
        price int not null,
        id_user int not null,
        id_screening int not null,
        id_credit_cia int not null,
        constraint pk_bill primary key (id),
        constraint fk_user foreign key (id_user) references users(id),
        constraint fk_screening foreign key(id_screening) references screenings(id),
        constraint fk_credit_cia foreign key (id_credit_cia) references credit_cias(id)
        );
        
	
        
        
        
	
        
        
	
        
        
    
    
    
    
    

