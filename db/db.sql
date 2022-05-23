CREATE DATABASE IF NOT EXISTS moviedb;

USE moviedb;

CREATE TABLE tUser (
  id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(50) NOT NULL UNIQUE,
  encrypted_password VARCHAR(100) NOT NULL,
  roles VARCHAR(50) NOT NULL,
  profile_image VARCHAR(200) 
  );

CREATE TABLE tMovie (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  sinopsis longtext NOT NULL,
  image VARCHAR(200) NOT NULL,
  created DATE NOT NULL,
  gender VARCHAR(500) NOT NULL,
  duration VARCHAR(50) NOT NULL
);

CREATE TABLE tComentarios (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  comentario VARCHAR(2000),
  movie_id INTEGER NOT NULL,
  fecha_comentario DATE,
  usuario_id INTEGER NOT NULL,
  FOREIGN KEY (movie_id) REFERENCES tMovie(id),
  FOREIGN KEY (usuario_id) REFERENCES tUser(id)
);

CREATE TABLE tWatchlist (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  usuario_id INTEGER NOT NULL,
  movie_id INTEGER NOT NULL,
  FOREIGN KEY (movie_id) REFERENCES tMovie(id),
  FOREIGN KEY (usuario_id) REFERENCES tUser(id)
);
