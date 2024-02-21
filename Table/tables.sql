CREATE TABLE `authorized` (
  `id` int(255) AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `authorized` (`id`, `email`, `password`, `role`) VALUES 
('1', 'njverzosa24@gmail.com', '$2y$10$WZ5NRVsJviblXOmrWeS0jeC1Oc6/cq1/fgxEAjeGaBnlnjvZbSU.i', 'Officer');

CREATE TABLE `archive_docs` (
  `id` int(255) AUTO_INCREMENT PRIMARY KEY,
  `inserted_at` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `no_of_year` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `docs` (
  `id` int(255) AUTO_INCREMENT PRIMARY KEY,
  `inserted_at` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `no_of_year` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
