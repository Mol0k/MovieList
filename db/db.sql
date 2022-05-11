CREATE DATABASE IF NOT EXISTS moviedb;

USE moviedb;

CREATE TABLE tUser (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  surname VARCHAR(100) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  encrypted_password VARCHAR(100) NOT NULL,
  roles VARCHAR(50) NOT NULL,
  profile_image VARCHAR(200) 
  );

CREATE TABLE tMovie (
  id INTEGER PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description VARCHAR(500) NOT NULL,
  image VARCHAR(200) NOT NULL,
  created DATE NOT NULL,
  gender VARCHAR(500) NOT NULL,
  duration VARCHAR(50) NOT NULL
);
