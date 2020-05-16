CREATE DATABASE `besthack_db`;
ALTER DATABASE `besthack_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE USER 'besthack'@'localhost' IDENTIFIED BY 'You_Shell_Not_Pass_0_o';
GRANT ALL PRIVILEGES ON `besthack_db`.* TO 'besthack'@'localhost';

USE besthack_db

CREATE TABLE `users` (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
value INT(3),
role INT(3),
image VARCHAR(255),
name VARCHAR(255),
surname VARCHAR(255),
patronymic VARCHAR(255),
email VARCHAR(255),
study VARCHAR(255),
work VARCHAR(255),
birth VARCHAR(10),
bio LONGTEXT,
sex int(1),
password VARCHAR(64));

CREATE TABLE `connections` (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT,
session VARCHAR(64),
token VARCHAR(64));

CREATE TABLE `confirmations` (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT,
token VARCHAR(64));

CREATE TABLE `chat_rooms` (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT,
chat_id INT);

CREATE TABLE `chat_confirm`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
token VARCHAR(64),
chat_id INT);

CREATE TABLE `chat_list` (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name varchar(255),
logo varchar(255));

CREATE TABLE `chat_owners`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
chat_id INT,
user_id INT);


CREATE TABLE `chat_example`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
owner_id INT,
date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
data LONGTEXT);

CREATE TABLE `public_events`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
owner_id INT,
subject INT,
name varchar(255),
img varchar(255),
start_date varchar(10),
end_date varchar(10),
start_time varchar(5),
end_time varchar(5),
data LONGTEXT);

CREATE TABLE `news`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
owner_id INT,
subject INT,
name varchar(255),
img varchar(255),
start_date varchar(10),
end_date varchar(10),
start_time varchar(5),
end_time varchar(5),
data LONGTEXT);

CREATE TABLE `private_events`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
owner_id INT,
chat_id INT,
subject INT,
name varchar(255),
img varchar(255),
start_date varchar(10),
end_date varchar(10),
start_time varchar(5),
end_time varchar(5),
data LONGTEXT);

CREATE TABLE `subjects`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
text varchar(255));

INSERT INTO `subjects` SET text='Testers';
INSERT INTO `subjects` SET text='Test!!!';

CREATE TABLE `verification_queries`(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
owner_id INT);

CREATE TABLE `pub_connect` (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT,
pub_event_id INT);
