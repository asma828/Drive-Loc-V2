CREATE DATABASE CAR;
USE car;

 create table role (
     id_role INT AUTO_INCREMENT PRIMARY KEY,
     roleName varchar(20) NOT NULL
     );

create table utilisateur (
     id_user INT AUTO_INCREMENT PRIMARY KEY,
     name varchar(255) NOT NULL,
     email varchar(255) UNIQUE NOT NULL,
     password text,
     role_id int,
     FOREIGN KEY (role_id) REFERENCES role(id_role) on delete cascade
     );

create table categorie (
     id_categorie INT AUTO_INCREMENT PRIMARY KEY,
     name varchar(255) NOT NULL
     );          

create table vechicule (
     id_vechicule INT AUTO_INCREMENT PRIMARY KEY,
     name varchar(255) NOT NULL,
     model varchar(255) NOT NULL,
     prix decimal NOT NULL,
     categorie_id int,
     FOREIGN KEY (categorie_id) REFERENCES categorie(id_categorie)
     );

create table reservation (
     id_reservation INT AUTO_INCREMENT PRIMARY KEY,
     user_id INT NOT NULL,
     vehicle_id INT NOT NULL,
     place_id INT NOT NULL,
     start_date DATE NOT NULL,
     end_date DATE NOT NULL,
     FOREIGN KEY (user_id) REFERENCES utilisateur(id_user),
     FOREIGN KEY (vehicle_id) REFERENCES vechicule(id_vechicule),
     FOREIGN KEY (place_id) REFERENCES place(id_place)
     );

 create table place (
     id_place INT AUTO_INCREMENT PRIMARY KEY,
     name varchar(255) not null
     );

CREATE TABLE reviews (
    id_reviews INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_id INT NOT NULL,
    rating INT CHECK(rating BETWEEN 1 AND 5),
    comment TEXT,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES utilisateur(id_user),
    FOREIGN KEY (vehicle_id) REFERENCES vechicule(id_vechicule)
     );
 ALTER TABLE vechicule
    ADD COLUMN image text;

INSERT INTO role (roleName) VALUES ('client'), ('admin');

INSERT INTO categorie (name) VALUES ('SUV'), ('Berline'), ('Camionnette');

INSERT INTO vechicule (name, model, prix, categorie_id, image) 
VALUES 
('Toyota RAV4', '2022', 50, 1, '../assets/images/toyota_rav4.jpg'),
('BMW X5', '2023', 70, 1, '../assets/images/bmw_x5.jpg');

ALTER TABLE reviews 
ADD COLUMN created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN deleted_at DATETIME DEFAULT NULL;


INSERT INTO vechicule (name, model, prix, categorie_id, image) 
VALUES 
('Honda CR-V', '2021', 60, 1, '../assets/images/honda_crv.jpg'),
('Mercedes-Benz GLC', '2023', 85, 1, '../assets/images/mercedes_glc.jpg'),
('Audi A4', '2022', 75, 2, '../assets/images/audi_a4.jpg'),
('Tesla Model S', '2023', 120, 2, '../assets/images/tesla_model_s.jpg'),
('Ford F-150', '2020', 65, 3, '../assets/images/ford_f150.jpg'),
('Chevrolet Silverado', '2021', 75, 3, '../assets/images/chevrolet_silverado.jpg');


INSERT INTO place (name) VALUES 
('Aéroport Mohammed V'),
('Gare Casa Voyageurs'),
('Agence Centre-Ville'),
('Marina Casablanca'),
('Aéroport Marrakech Menara'),
('Gare Rabat Ville');

ALTER TABLE reservation
    ADD COLUMN status enum ('Anuller','Attent','Confirme') DEFAULT 'Attent';

ALTER TABLE reservation
   DROP FOREIGN KEY reservation_ibfk_2;
   
ALTER TABLE reservation   
   ADD CONSTRAINT reservation_ibfk_2 FOREIGN KEY (vehicle_id) REFERENCES vechicule(id_vechicule) ON DELETE CASCADE;

   INSERT INTO reviews (vehicle_id, rating, comment, user_id, created_at, deleted_at)
     VALUES (9, 5, 'Amazing car, great performance!', 8, NOW(), NULL);

     /* version 2 */
CREATE TABLE themes (                         
   id_theme INT AUTO_INCREMENT PRIMARY KEY,  
   name VARCHAR(100) NOT NULL                
);                                            

CREATE TABLE articles (
  id_article INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  content TEXT NOT NULL,
  image VARCHAR(255),
  id_theme INT NOT NULL,
  id_user INT NOT NULL,
  status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_theme) REFERENCES themes(id_theme) ON DELETE CASCADE,
  FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
);

CREATE TABLE comments (
  id_comment INT AUTO_INCREMENT PRIMARY KEY,
  id_article INT NOT NULL,
  id_user INT NOT NULL,
  content TEXT NOT NULL,
  is_deleted BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_article) REFERENCES articles(id_article) ON DELETE CASCADE,
  FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
 );

CREATE TABLE tags (
  id_tag INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 );

CREATE TABLE articles_tags (
 id_article INT NOT NULL,
 id_tag INT NOT NULL,
 PRIMARY KEY (id_article, id_tag),
 FOREIGN KEY (id_article) REFERENCES articles(id_article) ON DELETE CASCADE,
 FOREIGN KEY (id_tag) REFERENCES tags(id_tag) ON DELETE CASCADE
 );

CREATE TABLE favorites (
 id_favorit INT AUTO_INCREMENT PRIMARY KEY,
 id_article INT NOT NULL,
 id_user INT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (id_article) REFERENCES articles(id_article) ON DELETE CASCADE,
 FOREIGN KEY (id_user) REFERENCES utilisateur(id_user) ON DELETE CASCADE
 );

 INSERT INTO articles (title, content, image, id_theme, id_user) VALUES
     ('Les 5 meilleures destinations de voyage en voiture', 'Voyager, c/est faire face à des situations nouvelles et inconnues, sortir de sa zone de confort, devoir composer avec des situations inédites', '../assets/images/voyages1.jpg', 1,5);

INSERT INTO themes (name) VALUES
 ('Voyages'),
 ('Entretien de voiture'),
 ('Nouveaux modèles'),
 ('Conseils de conduite');

Alter table themes
  ADD COLUMN image varchar(255);

INSERT INTO tags (name) VALUES
('Voyage'),
('Écologie'),
('Électrique'),
('Hiver');

INSERT INTO article_tags (article_id, tag_id) VALUES
(4, 1), 
(5, 4), 
(3, 2), 
(3, 3);