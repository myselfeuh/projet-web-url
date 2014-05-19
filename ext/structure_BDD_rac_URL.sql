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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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


INSERT INTO `racurl`.`membres` (`id`, `nom`, `prenom`, `pseudo`, `mail`, `mdp`, `activation`, `profil`) VALUES
  (NULL, 'penaud', 'guillaume', 'sephres', 'guillaume.penaud@gmail.com', 'us8.ughl5bQqs', 'ok', 'admin'),
  (NULL, 'dosch', 'philippe', 'eldiablo', 'philippe.dosch@gmail.com', 'us8.ughl5bQqs', 'ok', 'member'),
  (NULL, 'lalaoui', 'yann', 'yanneuh', 'yann.lalaoui@gmail.com', 'us8.ughl5bQqs', 'ok', 'member');

INSERT INTO `racurl`.`urls` (`id`, `source`, `courte`, `creation`, `auteur`) VALUES
  (NULL, 'http://www.google.fr', '854f8a6a', CURRENT_TIMESTAMP, NULL),
  (NULL, 'http://www.yahoo.fr', '2b66e83b', CURRENT_TIMESTAMP, NULL),
  (NULL, 'http://www.jeuxvideo.fr', '85027200', CURRENT_TIMESTAMP, NULL),

  (NULL, 'http://www.google.fr', 'b6a85411', CURRENT_TIMESTAMP, '1'),
  (NULL, 'http://www.yahoo.fr', '4c4377bc', CURRENT_TIMESTAMP, '1'),
  (NULL, 'http://www.jeuxvideo.fr', '2bfd87c0', CURRENT_TIMESTAMP, '1'),

  (NULL, 'http://www.google.fr', '7fe8db52', CURRENT_TIMESTAMP, '2'),
  (NULL, 'http://www.yahoo.fr', 'ab16cb48', CURRENT_TIMESTAMP, '2'),
  (NULL, 'http://www.jeuxvideo.fr', 'beca00ff', CURRENT_TIMESTAMP, '2'),

  (NULL, 'http://www.google.fr', 'fbafddd6', CURRENT_TIMESTAMP, '3'),
  (NULL, 'http://www.yahoo.fr', 'e8fe7043', CURRENT_TIMESTAMP, '3'),
  (NULL, 'http://www.jeuxvideo.fr', '072f7dca', CURRENT_TIMESTAMP, '3');