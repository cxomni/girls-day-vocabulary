-- Create a database if not exists
CREATE DATABASE IF NOT EXISTS `vocabulary_trainer` COLLATE 'utf8_general_ci';

-- Create the language table
CREATE TABLE `languages` (
  `id` varchar(192) NOT NULL,
  `title` varchar(192) NOT NULL,
  `icon` blob NULL,
  PRIMARY KEY (`id`)
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';

-- Initial date insert for language table
INSERT INTO `languages` (id, title, icon) VALUES ('de_DE', 'Deutsch', 'de.svg');
INSERT INTO `languages` (id, title, icon) VALUES ('en_UK', 'Englisch', 'gb.svg');


-- Create a table which holds all words
CREATE TABLE `words` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(192) NOT NULL,
  `language_id` varchar(192) COLLATE 'utf8_general_ci' NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `words_fk_language_id` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';


-- Create the translations table
CREATE TABLE `translations` (
   `from_id` int(11) NOT NULL,
   `to_id` int(11) NOT NULL,
   PRIMARY KEY (`from_id`,`to_id`),
   KEY `translations_ix_reverse_pk` (`to_id`,`from_id`)
) ENGINE='InnoDB' COLLATE 'utf8_general_ci';
