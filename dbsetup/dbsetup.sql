CREATE DATABASE megacbur;

USE megacbur;

CREATE TABLE tb_orders (
    ID int,
    `TableNr` varchar(45),
    FullName varchar(255),
    Telephone varchar(30),
    Email varchar(255),
    Time varchar(20),
    Details varchar(255)
);

CREATE TABLE admin_pg (
    ID int,
    Username varchar(45),
    Password varchar(80)
);