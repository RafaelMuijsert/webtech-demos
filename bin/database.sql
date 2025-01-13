-- DROP DATABASE IF EXISTS webtechdemo;
CREATE DATABASE webtechdemo;
USE webtechdemo;
CREATE TABLE User (
  id INT PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE Comment (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NULL,
  text VARCHAR(255) NOT NULL
);

