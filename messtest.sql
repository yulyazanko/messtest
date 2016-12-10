-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 10 2016 г., 17:57
-- Версия сервера: 5.6.22-log
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `messtest`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Comments1`
--

CREATE TABLE IF NOT EXISTS `Comments1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment1` varchar(2048) NOT NULL,
  `messid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `datecomm` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messid` (`messid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `Comments1`
--

INSERT INTO `Comments1` (`id`, `comment1`, `messid`, `userid`, `datecomm`) VALUES
(6, 'Это 1 комментарий к 1 сообщению Светланы!!!', 9, 5, '2016-12-10 17:46:00'),
(9, 'Это 1 комментарий Юли', 11, 5, '2016-12-10 17:50:10'),
(10, 'Это 2 комментарий Юли', 11, 5, '2016-12-10 17:50:21'),
(11, 'Это комментарий к моему же сообщению!!!', 11, 6, '2016-12-10 17:51:07');

-- --------------------------------------------------------

--
-- Структура таблицы `Comments2`
--

CREATE TABLE IF NOT EXISTS `Comments2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment2` varchar(2048) NOT NULL,
  `comm1id` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `datecomm` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  KEY `comm1id` (`comm1id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `Comments2`
--

INSERT INTO `Comments2` (`id`, `comment2`, `comm1id`, `userid`, `datecomm`) VALUES
(8, 'Это комментарий к комментарию!!!', 10, 6, '2016-12-10 17:50:42');

-- --------------------------------------------------------

--
-- Структура таблицы `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(2048) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `datemess` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `Messages`
--

INSERT INTO `Messages` (`id`, `message`, `userid`, `datemess`) VALUES
(8, 'Это мое 1 сообщение!!', 5, '2016-12-10 17:38:55'),
(9, 'А это мое 1 сообщение!!!', 6, '2016-12-10 17:45:29'),
(10, 'Это 2 сообщение Юли!!!!', 5, '2016-12-10 17:49:26'),
(11, 'Это 2 сообщение Светланы!!!', 6, '2016-12-10 17:49:48');

-- --------------------------------------------------------

--
-- Структура таблицы `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `Users`
--

INSERT INTO `Users` (`id`, `user_id`, `name`, `link`, `path`) VALUES
(5, '1274030135994402', 'Юля Занько', 'http://facebook.com/1274030135994402', 'http://graph.facebook.com/1274030135994402/picture?type=large"'),
(6, '211825135934072', 'Светлана Луговая', 'http://facebook.com/211825135934072', 'http://graph.facebook.com/211825135934072/picture?type=large"');

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Comments1`
--
ALTER TABLE `Comments1`
  ADD CONSTRAINT `comments1_ibfk_1` FOREIGN KEY (`messid`) REFERENCES `Messages` (`id`),
  ADD CONSTRAINT `comments1_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `Users` (`id`);

--
-- Ограничения внешнего ключа таблицы `Comments2`
--
ALTER TABLE `Comments2`
  ADD CONSTRAINT `comments2_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `comments2_ibfk_2` FOREIGN KEY (`comm1id`) REFERENCES `Comments1` (`id`);

--
-- Ограничения внешнего ключа таблицы `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `Users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
