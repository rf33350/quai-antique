/*remplissage de la table Restaurant*/
INSERT INTO quai_antique.restaurant (name, address, seat_number)  VALUES ('Quai Antique',' 16 Avenue Charles de Gaule 7300 Chambery', 56);

/*remplissage de la table User*/
INSERT INTO quai_antique.user (email, roles, password, first_name, last_name, allergy)  VALUES ('admin@quaiantique.fr',' ["ROLE_USER","ROLE_ADMIN"]', '$2y$13$SelaswFpk1UoYaSeVZvNKeSpND291RiWOpDE6kbGe2cfG3PIzwmby', 'Arnaud', 'Michant', '-');
INSERT INTO quai_antique.user (email, roles, password, first_name, last_name, allergy)  VALUES ('user@quaiantique.fr',' []', '$2y$13$tFdnsiuaYu.F9UPzmUrRA.5enamtngGmn2O7DXHmx8mPOHygloexC', 'Charles', 'Michant', 'compte de test user');

/*remplissage de la table Dish*/
INSERT INTO quai_antique.dish (relation_id, title, category, description, price, is_star)  VALUES (1,'Burito', 'plat', 'plat typique mexicain', 12.5, 1);
INSERT INTO quai_antique.dish (relation_id, title, category, description, price, is_star)  VALUES (1,'Pâtes aux gambas', 'entrée', 'Fameuse et exqusises pâtes agrémentées d\'apétissantes gambas', 10.5, 1);
INSERT INTO quai_antique.dish (relation_id, title, category, description, price, is_star)  VALUES (1,'Tiramisu cake', 'dessert', 'Gâteau fait maison. Revisite du tiramisu', 7.49, 1);
INSERT INTO quai_antique.dish (relation_id, title, category, description, price, is_star)  VALUES (1,'Perrier 33cl', 'boissons', 'Perrier 33cl', 3.5, 0);

/*remplissage de la table OpenHour*/
INSERT INTO quai_antique.open_hour (relation_id, day, mourning_start_time, mourning_stop_time, evening_start_time, evening_stop_time)  VALUES (1,'Lundi', '12:00:00', '14:00:00', '19:00:00', '22:00:00');
INSERT INTO quai_antique.open_hour (relation_id, day, mourning_start_time, mourning_stop_time, evening_start_time, evening_stop_time)  VALUES (1,'Mardi', '12:00:00', '14:00:00', '19:00:00', '22:00:00');
INSERT INTO quai_antique.open_hour (relation_id, day, mourning_start_time, mourning_stop_time, evening_start_time, evening_stop_time)  VALUES (1,'Mercredi', null, null, null, null);
INSERT INTO quai_antique.open_hour (relation_id, day, mourning_start_time, mourning_stop_time, evening_start_time, evening_stop_time)  VALUES (1,'Jeudi', '12:00:00', '14:00:00', '19:00:00', '22:00:00');
INSERT INTO quai_antique.open_hour (relation_id, day, mourning_start_time, mourning_stop_time, evening_start_time, evening_stop_time)  VALUES (1,'Vendredi', '12:00:00', '14:00:00', '19:00:00', '22:00:00');
INSERT INTO quai_antique.open_hour (relation_id, day, mourning_start_time, mourning_stop_time, evening_start_time, evening_stop_time)  VALUES (1,'Samedi', null, null, '19:00:00', '22:00:00');
INSERT INTO quai_antique.open_hour (relation_id, day, mourning_start_time, mourning_stop_time, evening_start_time, evening_stop_time)  VALUES (1,'Dimanche', '12:00:00', '14:00:00', null, null);

/*remplissage de la table Menu*/
INSERT INTO quai_antique.menu (restaurant_id, title)  VALUES (1,'Le menu classique');
INSERT INTO quai_antique.menu (restaurant_id, title)  VALUES (1,'Le menu de la mer');
INSERT INTO quai_antique.menu (restaurant_id, title)  VALUES (1,'Le menu enfants');

/*remplissage de la table Formula*/
INSERT INTO quai_antique.formula (menu_id, title, description, price)  VALUES (1,'Formule du midi', 'Formule au choix entrée+plat ou plat+dessert', 25.9);
INSERT INTO quai_antique.formula (menu_id, title, description, price)  VALUES (1,'Formule du soir', 'Formule au choix entrée+plat ou plat+dessert', 32.5);
INSERT INTO quai_antique.formula (menu_id, title, description, price)  VALUES (2,'Formule du midi', 'Formule au choix entrée de la mer+plat ou plat+dessert', 32.9);
INSERT INTO quai_antique.formula (menu_id, title, description, price)  VALUES (2,'Formule du soir', 'Formule au choix entrée de la mer+plat ou plat+dessert', 45.9);
INSERT INTO quai_antique.formula (menu_id, title, description, price)  VALUES (3,'Formule du midi', 'Notre formule comprend un burger avec son accompagnement de frites ', 19.9);
INSERT INTO quai_antique.formula (menu_id, title, description, price)  VALUES (3,'Formule du soir', 'Notre formule comprend un burger avec son accompagnement de frites ', 21.9);

/*remplissage de la table Reservation*/
INSERT INTO quai_antique.reservation (restaurant_id, date, arrival_hour, seats, service, allergy, first_name, last_name, email)  VALUES (1,'2023-05-22', '20:45:00', 2, 'soir', '-', 'remi', 'faure', 'remi@mail.fr');
INSERT INTO quai_antique.reservation (restaurant_id, date, arrival_hour, seats, service, allergy, first_name, last_name, email)  VALUES (1,'2023-05-22', '12:45:00', 2, 'midi', 'crevettes', 'remi', 'faure', 'remi@mail.fr');
INSERT INTO quai_antique.reservation (restaurant_id, date, arrival_hour, seats, service, allergy, first_name, last_name, email)  VALUES (1,'2023-05-15', '19:45:00', 2, 'soir', 'chocolat', 'remi', 'faure', 'remi@mail.fr');

/*remplissage de la table Disponibility*/
INSERT INTO quai_antique.disponibility (restaurant_id, date, available_seats, service)  VALUES (1,'2023-06-01', 56, 'midi');
INSERT INTO quai_antique.disponibility (restaurant_id, date, available_seats, service)  VALUES (1,'2023-06-01', 56, 'soir');
INSERT INTO quai_antique.disponibility (restaurant_id, date, available_seats, service)  VALUES (1,'2023-06-02', 56, 'midi');
INSERT INTO quai_antique.disponibility (restaurant_id, date, available_seats, service)  VALUES (1,'2023-06-02', 56, 'soir');
INSERT INTO quai_antique.disponibility (restaurant_id, date, available_seats, service)  VALUES (1,'2023-06-03', 56, 'soir');
INSERT INTO quai_antique.disponibility (restaurant_id, date, available_seats, service)  VALUES (1,'2023-06-04', 56, 'midi');