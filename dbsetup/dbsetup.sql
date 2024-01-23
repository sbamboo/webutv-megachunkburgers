CREATE DATABASE megacbur;

USE megacbur;

CREATE TABLE tb_orders (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    `TableNr` varchar(45),
    FullName varchar(255),
    Telephone varchar(30),
    Email varchar(255),
    Time varchar(20),
    Details varchar(255)
);

CREATE TABLE fd_orders (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    `TableNr` varchar(45),
    Price varchar(45),
    Time varchar(20),
    Food varchar(255)
);

CREATE TABLE admin_pg (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username varchar(45),
    Password varchar(80)
);

INSERT INTO admin_pg (Username, Password) VALUES ("test","test");