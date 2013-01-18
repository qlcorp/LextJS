SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `extjs`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cars`
--

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Zrzut danych tabeli `cars`
--

INSERT INTO `cars` (`id`, `manufacturer`, `model`, `year`) VALUES
(11, 'Ford', 'Mustang', 2005),
(12, 'Chevrolet', 'Corvette', 1992),
(13, 'Lancia', 'Delta', 2000);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `extension` varchar(4) DEFAULT NULL,
  `leaf` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Zrzut danych tabeli `files`
--

INSERT INTO `files` (`id`, `parent_id`, `text`, `extension`, `leaf`) VALUES
(1, 0, 'public', '', 0),
(3, 1, 'index', 'html', 1),
(4, 0, 'application', '', 0),
(5, 4, 'paths', 'php', 1),
(6, 4, 'controllers', '', 0),
(7, 6, 'home', 'php', 1),
(9, 4, 'models', '', 0),
(11, 9, 'Files', 'php', 1),
(13, 9, 'Movies', NULL, 1),
(14, 6, 'base', NULL, 1),
(15, 1, 'css', NULL, 0),
(16, 15, 'style.css', NULL, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `director` varchar(255) NOT NULL,
  `year` int(4) DEFAULT NULL,
  `genre` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Zrzut danych tabeli `movies`
--

INSERT INTO `movies` (`id`, `title`, `director`, `year`, `genre`) VALUES
(11, 'Matrix', 'A.Wachowski', 1999, 'science fiction'),
(12, 'Titanic', 'J.Cameron', 1997, 'melodrama'),
(13, 'Die hard', 'J.McTiernan', 1988, 'action'),
(14, 'Back to the future', 'R.Zemeckis', 1985, 'comedy');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
