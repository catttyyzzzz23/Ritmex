-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           10.4.28-MariaDB - mariadb.org binary distribution
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para ritmex
CREATE DATABASE IF NOT EXISTS `ritmex` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `ritmex`;

-- A despejar estrutura para tabela ritmex.albuns
CREATE TABLE IF NOT EXISTS `albuns` (
  `id_Album` int(11) NOT NULL AUTO_INCREMENT,
  `nome_album` varchar(70) NOT NULL,
  PRIMARY KEY (`id_Album`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.albuns: ~12 rows (aproximadamente)
INSERT INTO `albuns` (`id_Album`, `nome_album`) VALUES
	(12, 'Reputation'),
	(13, 'Reputation'),
	(14, 'Reputation'),
	(15, 'Reputation'),
	(16, 'Evermore'),
	(17, 'Paradise - EP'),
	(18, 'Guts'),
	(19, 'GUTS'),
	(20, 'GUTS'),
	(21, 'Lol'),
	(22, 'Sour');

-- A despejar estrutura para tabela ritmex.artistas
CREATE TABLE IF NOT EXISTS `artistas` (
  `id_Artista` int(11) NOT NULL AUTO_INCREMENT,
  `nome_artista` varchar(70) DEFAULT NULL,
  `email` varchar(70) NOT NULL,
  `senha` varchar(70) NOT NULL,
  `termos` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_Artista`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.artistas: ~4 rows (aproximadamente)
INSERT INTO `artistas` (`id_Artista`, `nome_artista`, `email`, `senha`, `termos`) VALUES
	(2, 'joana', 'joana@gmail.com', 'joana', 1),
	(3, 'Taylor Swift', 'taylorswift@gmail.com', 'taylorswift', 1),
	(4, 'Chase Atlantic ', 'chase@gmail.com', 'chase', 1),
	(5, 'Olivia Rodrigo', 'OliviaROficial@hotmail.com', 'oliviarodrigo', 1);

-- A despejar estrutura para tabela ritmex.avaliacoes
CREATE TABLE IF NOT EXISTS `avaliacoes` (
  `id_Avaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `avaliacao` int(11) DEFAULT NULL,
  `id_Musica` int(11) NOT NULL,
  `id_Utilizador` int(11) NOT NULL,
  PRIMARY KEY (`id_Avaliacao`),
  KEY `id_Musica` (`id_Musica`),
  KEY `id_Utilizador` (`id_Utilizador`),
  CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`id_Musica`) REFERENCES `musica` (`id_Musica`),
  CONSTRAINT `avaliacoes_ibfk_2` FOREIGN KEY (`id_Utilizador`) REFERENCES `utilizadores` (`id_Utilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.avaliacoes: ~5 rows (aproximadamente)
INSERT INTO `avaliacoes` (`id_Avaliacao`, `avaliacao`, `id_Musica`, `id_Utilizador`) VALUES
	(2, 5, 1, 1),
	(4, 5, 2, 1),
	(6, 4, 3, 3),
	(10, 5, 6, 3),
	(11, 5, 8, 3);

-- A despejar estrutura para tabela ritmex.detalhesalbum
CREATE TABLE IF NOT EXISTS `detalhesalbum` (
  `id_Album` int(11) NOT NULL,
  `id_Genero` int(11) NOT NULL,
  KEY `id_Album` (`id_Album`),
  KEY `id_Genero` (`id_Genero`),
  CONSTRAINT `fk_chave_estrangeira_album` FOREIGN KEY (`id_Album`) REFERENCES `albuns` (`id_Album`),
  CONSTRAINT `fk_chave_estrangeira_genero` FOREIGN KEY (`id_Genero`) REFERENCES `generos` (`id_Genero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.detalhesalbum: ~11 rows (aproximadamente)
INSERT INTO `detalhesalbum` (`id_Album`, `id_Genero`) VALUES
	(12, 12),
	(13, 13),
	(14, 14),
	(15, 15),
	(16, 16),
	(17, 17),
	(18, 18),
	(19, 19),
	(20, 20),
	(21, 21),
	(22, 22);

-- A despejar estrutura para tabela ritmex.detalhesplaylist
CREATE TABLE IF NOT EXISTS `detalhesplaylist` (
  `id_Playlist` int(11) NOT NULL,
  `id_Musica` int(11) NOT NULL,
  KEY `id_Playlist` (`id_Playlist`),
  KEY `id_Musica` (`id_Musica`),
  CONSTRAINT `fk_chave_estrangeira_musica` FOREIGN KEY (`id_Musica`) REFERENCES `musica` (`id_Musica`),
  CONSTRAINT `fk_chave_estrangeira_playlist` FOREIGN KEY (`id_Playlist`) REFERENCES `playlists` (`id_Playlist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.detalhesplaylist: ~9 rows (aproximadamente)
INSERT INTO `detalhesplaylist` (`id_Playlist`, `id_Musica`) VALUES
	(2, 1),
	(4, 1),
	(4, 2),
	(1, 2),
	(1, 1),
	(3, 1),
	(3, 1),
	(10, 6),
	(10, 8);

-- A despejar estrutura para tabela ritmex.favoritos
CREATE TABLE IF NOT EXISTS `favoritos` (
  `id_Utilizador` int(11) NOT NULL,
  `id_Musica` int(11) NOT NULL,
  KEY `id_Musica` (`id_Musica`),
  KEY `id_Utilizador` (`id_Utilizador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.favoritos: ~6 rows (aproximadamente)
INSERT INTO `favoritos` (`id_Utilizador`, `id_Musica`) VALUES
	(2, 1),
	(2, 1),
	(1, 2),
	(2, 2),
	(1, 3),
	(3, 6);

-- A despejar estrutura para tabela ritmex.generos
CREATE TABLE IF NOT EXISTS `generos` (
  `id_Genero` int(11) NOT NULL AUTO_INCREMENT,
  `nome_genero` varchar(70) NOT NULL,
  PRIMARY KEY (`id_Genero`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.generos: ~11 rows (aproximadamente)
INSERT INTO `generos` (`id_Genero`, `nome_genero`) VALUES
	(12, 'Eletropop'),
	(13, 'Eletropop'),
	(14, 'Eletropop'),
	(15, 'Eletropop'),
	(16, 'Pop'),
	(17, 'R&B'),
	(18, 'gótico-pop'),
	(19, 'Gotic Pop'),
	(20, 'Gotic pop'),
	(21, 'LAJD'),
	(22, 'indie pop');

-- A despejar estrutura para tabela ritmex.musica
CREATE TABLE IF NOT EXISTS `musica` (
  `id_Musica` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(70) NOT NULL,
  `id_Artista` int(11) NOT NULL,
  `duracao` int(11) DEFAULT NULL,
  `id_Album` int(11) NOT NULL,
  `id_Genero` int(11) NOT NULL,
  `data_lancamento` varchar(70) DEFAULT NULL,
  `caminho_mp3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_Musica`),
  KEY `fk_chave_estrangeira_artista` (`id_Artista`),
  KEY `fk_chave_estrangeira_album3` (`id_Album`),
  KEY `fk_chave_estrangeira_genero3` (`id_Genero`),
  CONSTRAINT `fk_chave_estrangeira_album3` FOREIGN KEY (`id_Album`) REFERENCES `albuns` (`id_Album`),
  CONSTRAINT `fk_chave_estrangeira_artista` FOREIGN KEY (`id_Artista`) REFERENCES `artistas` (`id_Artista`),
  CONSTRAINT `fk_chave_estrangeira_genero3` FOREIGN KEY (`id_Genero`) REFERENCES `generos` (`id_Genero`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.musica: ~5 rows (aproximadamente)
INSERT INTO `musica` (`id_Musica`, `titulo`, `id_Artista`, `duracao`, `id_Album`, `id_Genero`, `data_lancamento`, `caminho_mp3`) VALUES
	(1, ' Look What You Made Me Do', 2, 255, 15, 15, '2017-11-10', 'Taylor Swift - Look What You Made Me Do.mp3'),
	(2, 'Willow', 3, 221, 16, 16, '2020-12-10', 'Taylor Swift - willow (Official Music Video).mp3'),
	(3, 'Moonlight', 4, 252, 17, 17, '2016-01-01', 'Kali Uchis - Moonlight.mp3'),
	(6, 'Vampire', 5, 244, 20, 20, '30-06-2023', 'Olivia Rodrigo - vampire (Official Video).mp3'),
	(8, 'Drivers License', 5, 247, 22, 22, '08-01-2021', 'Olivia Rodrigo - drivers license (Official Video).mp3');

-- A despejar estrutura para tabela ritmex.playlists
CREATE TABLE IF NOT EXISTS `playlists` (
  `id_Playlist` int(11) NOT NULL AUTO_INCREMENT,
  `nome_playlist` varchar(70) NOT NULL,
  `descricao` varchar(70) NOT NULL,
  `id_Utilizador` int(11) NOT NULL,
  PRIMARY KEY (`id_Playlist`),
  KEY `id_Utilizador` (`id_Utilizador`),
  CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`id_Utilizador`) REFERENCES `utilizadores` (`id_Utilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.playlists: ~8 rows (aproximadamente)
INSERT INTO `playlists` (`id_Playlist`, `nome_playlist`, `descricao`, `id_Utilizador`) VALUES
	(1, 'music', 'music', 1),
	(2, 'nova playlist', '', 1),
	(3, 'playlist editada 2', 'editada', 1),
	(4, 'playlist teste', 'testar', 1),
	(5, 'Som', 'Bem bom', 1),
	(10, 'MY LOVE', 'LOOAOA', 3),
	(11, 'AMOR DA JOANA', 'VDD', 3),
	(13, 'BURACASOM', 'sssd', 2);

-- A despejar estrutura para tabela ritmex.utilizadores
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `id_Utilizador` int(11) NOT NULL AUTO_INCREMENT,
  `nome_utilizador` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `senha` varchar(70) NOT NULL,
  `termos` int(11) NOT NULL,
  PRIMARY KEY (`id_Utilizador`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela ritmex.utilizadores: ~3 rows (aproximadamente)
INSERT INTO `utilizadores` (`id_Utilizador`, `nome_utilizador`, `email`, `senha`, `termos`) VALUES
	(1, 'Carolina', 'carolina.r@gmail.com', 'carolina', 1),
	(2, 'joão', 'joão.r@gmail.com', 'joao', 1),
	(3, 'Catarina', 'catarina.sobral23@gmail.com', '1234', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
