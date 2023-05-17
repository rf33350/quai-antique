/*Creation de la base de données quai_antique*/
CREATE DATABASE IF NOT EXISTS quai_antique CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

/*creation de la table Restaurant*/
CREATE TABLE quai_antique.restaurant(
	id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name varchar(250),
	address varchar(250), 
	seat_number integer
)engine=INNODB;

/*creation de la table User*/
CREATE TABLE quai_antique.user(
	id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	first_name varchar(250),
	last_name varchar(250), 
	email varchar(250),
	password varchar(250),
	roles varchar(250),
	allergy varchar(250)
)engine=INNODB;

/*creation de la table dish*/
CREATE TABLE quai_antique.dish(
	Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title varchar(250),
	category varchar(250),
	description varchar(250),
	image_path varchar(250),
	price float,
	is_star boolean,
	relation_id int,
	FOREIGN KEY (relation_id) REFERENCES quai_antique.restaurant (id)
)engine=INNODB;

/*creation de la table openHour*/
CREATE TABLE quai_antique.open_hour(
	Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	day varchar(250),
	mourning_start_time time,
	mourning_stop_time time,
	evening_start_time time,
	evening_stop_time time,
	relation_id int,
	FOREIGN KEY (relation_id) REFERENCES quai_antique.restaurant (id)
)engine=INNODB;

/*creation de la table menu*/
CREATE TABLE quai_antique.menu(
	Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title varchar(250),
	restaurant_id int,
	FOREIGN KEY (restaurant_id) REFERENCES quai_antique.restaurant (id)
)engine=INNODB;

/*creation de la table formula, = set dans merise*/
CREATE TABLE quai_antique.formula(
	Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	title varchar(250),
	description varchar(250),
	price float,
	menu_id int,
	FOREIGN KEY (menu_id) REFERENCES quai_antique.menu (id)
)engine=INNODB;


/*creation de la table reservation*/
CREATE TABLE quai_antique.reservation(
	Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	first_name varchar(250),
	last_name varchar(250), 
	email varchar(250),
	seats int,
	date date,
	arrival_hour time,
	service varchar(250),
	allergy varchar(250),
	restaurant_id int,
	FOREIGN KEY (restaurant_id) REFERENCES quai_antique.restaurant (id)
)engine=INNODB;


/*creation de la table disponibility*/
CREATE TABLE quai_antique.disponibility(
	Id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
	date date,
	available_seats int,
	service varchar(250),
	restaurant_id int,
	FOREIGN KEY (restaurant_id) REFERENCES quai_antique.restaurant (id)
)engine=INNODB;