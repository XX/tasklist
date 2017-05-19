CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `image_uri` varchar(1024) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

INSERT INTO `user` (`username`, `password`, `role`) VALUES ('admin', '$2y$10$3GBBkXfWSUqSGoJ.yZR98OAAZBISZCwHh9451s/a3bXC3yg4mm7jC', 'admin');