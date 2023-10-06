CREATE TABLE IF NOT EXISTS utenti (
id int NOT NULL AUTO_INCREMENT,
nome varchar(45),
cognome varchar(45),
email varchar(255),
password varchar(255),
reset_token varchar(64) DEFAULT NULL,
reset_token_expire_at datetime DEFAULT NULL,
is_admin boolean DEFAULT 0,
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS eventi (
id int NOT NULL AUTO_INCREMENT,
attendees text,
nome_evento varchar(255),
data_evento datetime,
PRIMARY KEY (id)
);

INSERT INTO `eventi`(`attendees`, `nome_evento`, `data_evento`) VALUES ('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 1', '2022-10-13 14:00'), ('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00'), ('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00');

INSERT INTO `utenti` (`nome`, `cognome`, `email`, `password`, `reset_token`, `reset_token_expire_at`, `is_admin`) VALUES
('Marco', 'Rossi', 'ulysses200915@varen8.com', '$2y$10$O4MZNUheokSC9rf.bObNZul3N8yU2sTjNHUFMsOM7IiIP5Feg8TVO', NULL, NULL, 1),
('Filippo', 'D\'Amelio', 'qmonkey14@falixiao.com','$2y$10$ldNwyWxM9WuMXLhlbsYVeeFepLpflS4CTpb3gMsC6kxOalHPfc5yC', NULL, NULL, 1),
('Gian Luca', 'Carta', 'mavbafpcmq@hitbase.net', '$2y$10$L9Z/M8EcVOoyAbs.sK6xBu1r92eJbZkwtucuyGwu0ZUa8RGipsH1K', NULL, NULL, 1),
('Stella', 'De Grandis', 'dgipolga@edume.me', '$2y$10$4NYlXvy2Xt/CkBLJcF4RouiHVTcGhzaU.cUZn4PSAtEwreJNrt.Du', NULL, NULL, 1);