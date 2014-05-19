--
-- Structure de la table `utilisations`
--

DROP TABLE IF EXISTS `utilisations`;
CREATE TABLE IF NOT EXISTS `utilisations` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`url` int(11) NOT NULL,
	`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Structure de la table `urls`
--

DROP TABLE IF EXISTS `urls`;
CREATE TABLE IF NOT EXISTS `urls` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`source` varchar(1024) NOT NULL,
	`courte` varchar(10) NOT NULL,
	`creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`auteur` int(11) DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `courte` (`courte`),
	KEY `auteur` (`auteur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Structure de la table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`nom` varchar(64) NOT NULL,
	`prenom` varchar(64) NOT NULL,
	`pseudo` varchar(64) NOT NULL,
	`mail` varchar(64) NOT NULL,
	`mdp` varchar(40) NOT NULL,
	`activation` varchar(40) NOT NULL,
	`profil` varchar(16) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `urls`
--
ALTER TABLE `urls`
	ADD CONSTRAINT `urls_ibfk_1` FOREIGN KEY (`auteur`) REFERENCES `membres` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;
--
-- Contraintes pour la table `utilisations`
--
ALTER TABLE `utilisations`
	ADD CONSTRAINT `utilisations_ibfk_1` FOREIGN KEY (`url`) REFERENCES `urls` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;


-- Donnees dexemple a inserer pour creer des graphiques statistiques

-- Membres
INSERT INTO `racurl`.`membres` (`id`, `nom`, `prenom`, `pseudo`, `mail`, `mdp`, `activation`, `profil`) VALUES 
	(NULL, 'penaud', 'guillaume', 'sephres', 'guillaume.penaud@gmail.com', 'us8.ughl5bQqs', 'ok', 'admin'),
	(NULL, 'lalaoui', 'yann', 'yanneuh', 'yann.lalaoui@gmail.com', 'us8.ughl5bQqs', 'ok', 'admin'),
	(NULL, 'dosch', 'philippe', 'eldiablo', 'philippe.dosch@gmail.com', 'us8.ughl5bQqs', 'ok', 'member'),
	(NULL, 'dupond', 'martin', 'martind', 'martin@dupond.fr', 'us8.ughl5bQqs', 'ok', 'member');

-- URLs
INSERT INTO `racurl`.`urls` (`id`, `source`, `courte`, `creation`, `auteur`) VALUES 
	-- urls anonymes
	(NULL, 'http://www.google.fr', '854f8a6a', '2014-04-18 15:04:16', NULL), 
	(NULL, 'http://www.yopmail.fr', '2b66e83b', '2014-04-18 16:04:16', NULL),
	(NULL, 'http://www.jeuxvideo.fr', '85027200', '2014-04-18 17:04:16', NULL),
	-- urls de guillaume
	(NULL, 'http://www.google.fr', 'b6a85411', '2014-04-20 12:04:16', '1'), 
	(NULL, 'http://www.yahoo.fr', '4c4377bc', '2014-04-20 18:04:16', '1'),
	(NULL, 'https://gitter.im', '2bfd87c0', '2014-04-21 21:04:16', '1'),
	-- urls de yann
	(NULL, 'http://www.google.fr', '7fe8db52', '2014-04-25 21:04:16', '2'),
	(NULL, 'http://www.gmail.fr', 'ab16cb48', '2014-04-26 10:04:16', '2'),
	(NULL, 'http://github.com', 'beca00ff', '2014-04-26 13:04:16', '2'),
	-- urls de philippe
	(NULL, 'http://www.google.fr', 'fbafddd6', '2014-04-29 09:04:16', '3'),
	(NULL, 'http://ent.univ-lorraine.fr', 'e8fe7043', '2014-04-29 12:04:16', '3'),
	(NULL, 'http://arche.univ-lorraine.fr', '072f7dca', '2014-04-29 14:04:16', '3'),
	-- urls de martin
	(NULL, 'http://www.google.fr', 'fbafeeee', '2014-04-29 09:04:16', '4'),
	(NULL, 'http://www.dailymotion.fr', 'e8fe1234', '2014-04-29 12:04:16', '4'),
	(NULL, 'http://www.youtube.fr', '072f5678', '2014-04-29 14:04:16', '4')
;

-- utilisations
INSERT INTO `racurl`.`utilisations` (`id`, `url`, `date`) VALUES
	-- utilisations de google.fr anonyme
	(NULL, 1, '2014-05-18 15:04:16'),
	(NULL, 1, '2014-05-18 15:05:58'),
	(NULL, 1, '2014-05-19 10:05:58'),
	(NULL, 1, '2014-05-19 16:05:58'),
	(NULL, 1, '2014-05-19 19:05:58'),
	(NULL, 1, '2014-05-20 09:05:58'),
	-- utilisations de yopmail.fr anonyme
	(NULL, 2, '2014-06-10 10:05:58'),
	(NULL, 2, '2014-06-12 12:05:58'),
	-- utilisations de jeuxvidoes.fr anonyme
	(NULL, 3, '2014-04-18 17:14:16'),
	(NULL, 3, '2014-04-18 17:24:16'),
	(NULL, 3, '2014-04-18 18:04:16'),
	(NULL, 3, '2014-04-19 10:04:16'),
	(NULL, 3, '2014-04-20 20:04:16'),
	-- utilisations de google.fr guillaume
	(NULL, 4, '2014-04-21 12:25:16'),
	(NULL, 4, '2014-04-22 11:25:16'),
	(NULL, 4, '2014-04-23 10:25:16'),
	(NULL, 4, '2014-04-23 14:25:16'),
	(NULL, 4, '2014-04-23 15:25:16'),
	(NULL, 4, '2014-04-23 21:25:16'),
	(NULL, 4, '2014-04-25 18:25:16'),
	-- utilisations de yahoo.fr guillaume
	(NULL, 5, '2014-04-24 17:04:16'),
	(NULL, 5, '2014-04-24 20:04:16'),
	(NULL, 5, '2014-04-24 21:04:16'),
	(NULL, 5, '2014-04-29 08:04:16'),
	(NULL, 5, '2014-04-29 09:04:16'),
	(NULL, 5, '2014-04-29 09:30:16'),
	(NULL, 5, '2014-05-02 10:04:16'),
	(NULL, 5, '2014-05-02 10:14:16'),
	(NULL, 5, '2014-05-02 10:24:16'),
	-- utilisations de gitter.im guillaume
	(NULL, 6, '2014-04-21 21:34:16'),
	(NULL, 6, '2014-04-21 21:44:16'),
	(NULL, 6, '2014-04-21 21:54:16'),
	(NULL, 6, '2014-04-21 22:04:16'),
	(NULL, 6, '2014-04-21 22:14:16'),
	(NULL, 6, '2014-04-23 10:04:16'),
	(NULL, 6, '2014-04-23 11:04:16'),
	(NULL, 6, '2014-04-23 11:24:16'),
	(NULL, 6, '2014-04-23 11:44:16'),
	(NULL, 6, '2014-04-23 12:04:16'),
	(NULL, 6, '2014-04-24 10:04:16'),
	(NULL, 6, '2014-04-24 10:04:16'),
	(NULL, 6, '2014-04-25 08:34:16'),
	(NULL, 6, '2014-04-25 08:44:16'),
	(NULL, 6, '2014-04-25 08:54:16'),
	-- utilisations de google.fr de yann
	(NULL, 7, '2014-04-27 22:04:16'),
	(NULL, 7, '2014-04-27 22:14:16'),
	(NULL, 7, '2014-04-27 23:24:16'),
	(NULL, 7, '2014-04-27 23:34:16'),
	(NULL, 7, '2014-04-28 00:04:16'),
	(NULL, 7, '2014-04-28 01:04:16'),
	(NULL, 7, '2014-04-29 09:04:16'),
	-- utilisations de gmail.fr de yann
	(NULL, 8, '2014-04-26 10:34:16'),
	(NULL, 8, '2014-04-26 10:44:16'),
	(NULL, 8, '2014-04-26 10:54:16'),
	(NULL, 8, '2014-04-26 12:04:16'),
	(NULL, 8, '2014-04-26 13:04:16'),
	(NULL, 8, '2014-04-29 09:04:16'),
	(NULL, 8, '2014-04-29 10:04:16'),
	(NULL, 8, '2014-04-29 11:04:16'),
	(NULL, 8, '2014-04-30 12:04:16'),
	(NULL, 8, '2014-04-30 13:04:16'),
	(NULL, 8, '2014-04-30 13:24:16'),
	-- utilisations de github.com de yann
	(NULL, 9, '2014-04-26 13:05:16'),
	(NULL, 9, '2014-04-26 13:34:16'),
	(NULL, 9, '2014-04-26 14:24:16'),
	(NULL, 9, '2014-05-20 10:04:16'),
	(NULL, 9, '2014-05-20 11:04:16'),
	(NULL, 9, '2014-05-20 13:04:16'),
	(NULL, 9, '2014-05-21 18:04:16'),
	(NULL, 9, '2014-05-21 19:04:16'),
	(NULL, 9, '2014-05-21 20:04:16'),
	-- utilisations de www.google.fr de philippe
	(NULL, 10, '2014-04-29 09:04:16'),
	(NULL, 10, '2014-04-29 10:04:16'),
	(NULL, 10, '2014-04-29 10:14:16'),
	(NULL, 10, '2014-04-29 10:24:16'),
	(NULL, 10, '2014-04-29 11:04:16'),
	(NULL, 10, '2014-04-30 09:04:16'),
	(NULL, 10, '2014-05-01 09:04:16'),
	(NULL, 10, '2014-05-03 09:04:16'),
	(NULL, 10, '2014-05-10 09:04:16'),
	-- utilisations de ent.univ-lorraine.fr de philippe
	(NULL, 11, '2014-06-02 07:34:16'),
	(NULL, 11, '2014-06-02 07:04:16'),
	(NULL, 11, '2014-06-02 08:04:16'),
	(NULL, 11, '2014-06-02 09:04:16'),
	(NULL, 11, '2014-06-12 12:04:16'),
	(NULL, 11, '2014-06-12 13:04:16'),
	(NULL, 11, '2014-06-29 10:04:16'),
	-- utilisations de arche.univ-lorraine.fr de philippe
	(NULL, 12, '2014-04-29 14:14:16'),
	(NULL, 12, '2014-04-29 14:24:16'),
	(NULL, 12, '2014-04-30 16:04:16'),
	(NULL, 12, '2014-04-30 17:04:16'),
	-- utilisations de www.google.fr de martin
	(NULL, 13, '2014-04-29 09:05:16'),
	(NULL, 13, '2014-04-29 09:14:16'),
	(NULL, 13, '2014-04-29 09:34:16'),
	(NULL, 13, '2014-04-29 10:04:16'),
	(NULL, 13, '2014-04-29 11:04:16'),
	(NULL, 13, '2014-04-29 11:09:16'),
	(NULL, 13, '2014-04-29 12:04:16'),
	-- utilisations de www.dailymotion.fr de martin
	(NULL, 14, '2014-04-29 12:05:16'),
	(NULL, 14, '2014-04-29 13:04:16'),
	(NULL, 14, '2014-04-29 13:14:16'),
	(NULL, 14, '2014-04-29 13:34:16'),
	(NULL, 14, '2014-04-29 14:00:16'),
	(NULL, 14, '2014-04-30 10:04:16'),
	(NULL, 14, '2014-04-30 15:04:16'),
	(NULL, 14, '2014-04-30 16:04:16'),
	(NULL, 14, '2014-04-30 17:04:16'),
	-- utilisations de www.youtube.fr de martin
	(NULL, 15, '2014-04-29 14:04:16'),
	(NULL, 15, '2014-05-01 10:04:16'),
	(NULL, 15, '2014-05-02 10:04:16'),
	(NULL, 15, '2014-05-03 10:04:16'),
	(NULL, 15, '2014-05-04 10:04:16'),
	(NULL, 15, '2014-05-05 10:34:16'),
	(NULL, 15, '2014-05-06 11:04:16'),
	(NULL, 15, '2014-05-07 11:04:16'),
	(NULL, 15, '2014-05-08 11:04:16'),
	(NULL, 15, '2014-06-01 09:04:16'),
	(NULL, 15, '2014-06-02 09:04:16'),
	(NULL, 15, '2014-06-03 09:04:16'),
	(NULL, 15, '2014-06-04 10:04:16'),
	(NULL, 15, '2014-06-05 10:04:16'),
	(NULL, 15, '2014-06-06 11:04:16')
;