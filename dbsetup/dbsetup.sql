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

CREATE TABLE admin_pg (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username varchar(45),
    Password varchar(80)
);