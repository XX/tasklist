CREATE DATABASE tasklist CHARACTER SET utf8;
CREATE USER 'tasklist'@'localhost' IDENTIFIED BY 'tasklist';
GRANT ALL PRIVILEGES ON tasklist.* TO 'tasklist'@'localhost';
