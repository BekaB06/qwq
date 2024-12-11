CREATE DATABASE IF NOT EXISTS FinalFantasy

CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL UNIQUE,
    name VARCHAR(25) NOT NULL,
    surname VARCHAR(60) NOT NULL,
    password VARCHAR(60) NOT NULL,
    email VARCHAR(40) NOT NULL UNIQUE,
    subscribe VARCHAR(3) NOT NULL);

CREATE TABLE IF NOT EXISTS shipping (   
    id INT PRIMARY KEY AUTO_INCREMENT,
    shipid VARCHAR(30)  NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    address VARCHAR(30) NOT NULL,
    city VARCHAR(30) NOT NULL,
    state VARCHAR(20) NOT NULL,
    zip VARCHAR(10)) NOT NULL;

CREATE TABLE IF NOT EXISTS billing (
    id INT PRIMARY KEY AUTO_INCREMENT,
    billid VARCHAR(30)  NOT NULL UNIQUE,
    name VARCHAR(50)  NOT NULL,
    address VARCHAR(30)  NOT NULL,
    city VARCHAR(30)  NOT NULL,
    state VARCHAR(20)  NOT NULL,
    zip VARCHAR(10)  NOT NULL,
    cardtype ENUM('Visa', 'MasterCard', 'American Express', 'Discover'),
    numer VARCHAR(16) NOT NULL,
    dat VARCHAR(5)) NOT NULL;


-- users table
INSERT INTO users (username, password, name, surname, email, subscribe) VALUES
('user1', 'password1', 'John', 'Doe', 'user1@example.com', 'yes'),
('user2', 'password2', 'Jane', 'Doe', 'user2@example.com', 'yes'),
('user3', 'password3', 'Alice', 'Smith', 'user3@example.com', 'no');

-- shipping table
INSERT INTO shipping (shipid, name, address, city, state, zip) VALUES
('user1', 'John Doe', '123 Main St', 'Anytown', 'CA', '12345'),
('user2', 'Jane Doe', '456 Elm St', 'Somewhere', 'NY', '67890'),
('user3', 'Alice Smith', '789 Oak St', 'Othertown', 'FL', '98765'),
('user1', 'John Doe', '123 Main St', 'Anytown', 'CA', '12345'),
('user2', 'Jane Doe', '456 Elm St', 'Somewhere', 'NY', '67890'),
('user3', 'Alice Smith', '789 Oak St', 'Othertown', 'FL', '98765');

-- billing table
INSERT INTO billing (billid, name, address, city, state, zip, cardtype, numer, dat) VALUES
('user1', 'John Doe', '123 Main St', 'Anytown', 'CA', '12345', 'Visa', '1234567890123456', '12/20'),
('user2', 'Jane Doe', '456 Elm St', 'Somewhere', 'NY', '67890', 'MasterCard', '2345678901234567', '09/21'),
('user3', 'Alice Smith', '789 Oak St', 'Othertown', 'FL', '98765', 'American Express', '3456789012345678', '08/22'),
('user1', 'John Doe', '123 Main St', 'Anytown', 'CA', '12345', 'Discover', '4567890123456789', '10/20'),
('user2', 'Jane Doe', '456 Elm St', 'Somewhere', 'NY', '67890', 'Visa', '5678901234567890', '01/23'),
('user3', 'Alice Smith', '789 Oak St', 'Othertown', 'FL', '98765', 'MasterCard', '6789012345678901', '02/24');


