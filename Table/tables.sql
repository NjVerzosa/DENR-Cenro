CREATE TABLE `authorized` (
  `id` int(255) AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `authorized` (`id`, `email`, `password`, `role`) VALUES 
('1', 'njverzosa24@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Authorized'),
('2', 'admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin');

CREATE TABLE `archive_docs` (
  `id` int(255) AUTO_INCREMENT PRIMARY KEY,
  `registered_at` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `no_of_year` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `docs` (
  `id` int(255) AUTO_INCREMENT PRIMARY KEY,
  `registered_at` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `no_of_year` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
