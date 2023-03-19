CREATE DATABASE cms;
USE cms;

CREATE TABLE category (
	cat_id INT AUTO_INCREMENT PRIMARY KEY,
	cat_title VARCHAR(255)
);

CREATE TABLE posts (
	post_id INT AUTO_INCREMENT PRIMARY KEY,
	post_category_id VARCHAR(255),
	post_title VARCHAR(255),
	post_author VARCHAR(255),
	post_date DATE,
	post_image TEXT,
	post_content TEXT,
	post_tags VARCHAR(255),
	post_comment_count INT,
	post_status VARCHAR(255) DEFAULT 'draft'
);


CREATE TABLE comments (
	comment_id INT AUTO_INCREMENT PRIMARY KEY,
	comment_post_id INT,
	comment_author VARCHAR(255),
	comment_email VARCHAR(255),
	comment_content TEXT,
	comment_status VARCHAR(255),
	comment_date DATE
);

CREATE TABLE users (
	user_id INT AUTO_INCREMENT PRIMARY KEY,
	username INT,
	user_password VARCHAR(255),
	user_firstname VARCHAR(255),
	user_lastname VARCHAR(255),
	user_email VARCHAR(255),
	user_image TEXT,
	user_role VARCHAR(255),
	token VARCHAR(255)
);

CREATE TABLE users_online (
	id INT AUTO_INCREMENT PRIMARY KEY,
	session VARCHAR(255),
	time INT
);