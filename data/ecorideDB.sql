SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Structure de la table `Commentaire`
--

CREATE TABLE `Commentaire` (
  `id` int UNSIGNED NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `user_covoiturage_id` int UNSIGNED NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Commentaire`
--

INSERT INTO `Commentaire` (`id`, `commentaire`, `user_covoiturage_id`) VALUES
(4, 'Voici un test comme quoi cette partie fonctionne, test 2', 24),
(5, 'Le conducteur a utilisé son téléphone pendant le trajet.', 84);

-- --------------------------------------------------------

--
-- Structure de la table `Covoiturage`
--

CREATE TABLE `Covoiturage` (
  `id` int UNSIGNED NOT NULL,
  `nb_place_disponible` tinyint UNSIGNED NOT NULL,
  `prix` decimal(8,2) UNSIGNED NOT NULL,
  `date_heure_depart` datetime NOT NULL,
  `date_heure_arrivee` datetime NOT NULL,
  `adresse_depart` varchar(255) NOT NULL,
  `adresse_arrivee` varchar(255) NOT NULL,
  `voiture_id` int UNSIGNED NOT NULL,
  `statut_id` int UNSIGNED NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Covoiturage`
--

INSERT INTO `Covoiturage` (`id`, `nb_place_disponible`, `prix`, `date_heure_depart`, `date_heure_arrivee`, `adresse_depart`, `adresse_arrivee`, `voiture_id`, `statut_id`) VALUES
(10, 1, 40, '2025-02-04 21:29:00', '2025-02-04 22:29:00', 'Lyon', 'Barcelona', 20, 1),
(11, 2, 5, '2025-02-16 19:42:00', '2025-02-17 22:42:00', 'lyon', 'Paris', 21, 1),
(12, 1, 6, '2025-02-04 22:03:00', '2025-02-08 22:03:00', 'lyon', 'Barcelona', 21, 3),
(13, 2, 2, '2025-03-09 23:09:00', '2025-03-10 02:08:00', 'lyon', 'barcelona', 21, 1),
(14, 12, 11, '2025-02-04 23:31:00', '2025-02-05 03:34:00', 'lyon', 'barcelona', 21, 1),
(15, 3, 4, '2025-01-02 18:50:00', '2025-01-02 21:53:00', 'lyon', 'barcelona', 21, 1),
(18, 3, 10, '2025-03-22 11:43:00', '2025-03-22 21:43:00', 'lyon', 'voreppe', 23, 1),
(19, 3, 6, '2025-02-16 19:24:00', '2025-02-16 22:24:00', 'lyon', 'barcelona', 9, 1),
(20, 6, 10, '2025-07-23 18:59:00', '2025-07-23 22:59:00', 'lyon', 'barcelona', 23, 1),
(21, 4, 10, '2025-03-22 08:59:00', '2025-03-22 18:59:00', 'lyon', 'voreppe', 18, 1),
(22, 4, 6, '2025-05-08 19:47:00', '2025-05-08 19:47:00', 'paris', 'colombia', 12, 1),
(23, 4, 15, '2025-07-15 19:50:00', '2025-07-15 20:53:00', 'Marseille', 'Paris', 30, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Energie`
--

CREATE TABLE `Energie` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Energie`
--

INSERT INTO `Energie` (`id`, `libelle`) VALUES
(1, 'Électrique'),
(2, 'Hybride'),
(3, 'Diesel - Gazole'),
(4, 'Essence'),
(5, 'GPL');

-- --------------------------------------------------------

--
-- Structure de la table `Preference`
--

CREATE TABLE `Preference` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Preference`
--

INSERT INTO `Preference` (`id`, `libelle`) VALUES
(1, 'Fumeur'),
(2, 'Animal'),
(3, 'Non_fumeur'),
(4, 'Non_animal');

-- --------------------------------------------------------

--
-- Structure de la table `Preference_Personnelle`
--

CREATE TABLE `Preference_Personnelle` (
  `id` int UNSIGNED NOT NULL,
  `preference` varchar(255) NOT NULL,
  `user_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Preference_Personnelle`
--

INSERT INTO `Preference_Personnelle` (`id`, `preference`, `user_id`) VALUES
(1, 'ceci est une preuve, ca fonctionne!!!', 47),
(2, 'Je ne parle pas', 65);

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Role`
--

INSERT INTO `Role` (`id`, `libelle`) VALUES
(1, 'Passager'),
(2, 'chauffeur'),
(3, 'chauffeur - Passager'),
(4, 'Employé'),
(5, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `Statut`
--

CREATE TABLE `Statut` (
  `id` int UNSIGNED NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Statut`
--

INSERT INTO `Statut` (`id`, `libelle`) VALUES
(1, 'Crée'),
(2, 'Démarré'),
(3, 'Arrivé'),
(4, 'Validé'),
(5, 'Annulé');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id` int UNSIGNED NOT NULL,
  `nb_credits` int UNSIGNED DEFAULT 20,
  `pseudo` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `photo_uniqId` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `login_attempts` tinyint UNSIGNED DEFAULT 0,
  `locked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`id`, `nb_credits`, `pseudo`, `mail`, `password`, `photo`, `role_id`, `photo_uniqId`, `active`) VALUES
(44, 20, 'pedri', 'pedri@mail.com', '$2y$10$2Zf4ELm5u6CyyOlaRuiqAeiDkN9o9jm1M7THDesPCn/2J.n3VGYHm', NULL, 2, NULL, 0),
(46, 20, 'drive', 'drvie@gmail.com', '$2y$10$GmSpKM0jMTHWp/URIMIMGeOju1CzuK1/h9XcIx41U7bpQ.UEn/97i', NULL, 2, NULL, 0),
(47, 129, 'car', 'carlitospro12457@gmail.com', '$2y$10$FgXHSRp7Le.apy5kpleJ6.l3NBqZfezeZakrEzUbATJnu1FYDbOoa', NULL, 2, NULL, 1),
(48, 20, 'juan', 'juan@mail.comeae', '$2y$10$o6ja2Uh5sym5jLCqYU74I.Q0e2vt.eDltCIxb2cKKiF3OlZeuIofK', NULL, 2, NULL, 1),
(49, 20, 'juan', 'pepe@mail.comadzd', '$2y$10$KhRBeaU8hZIymT7PKNnqrekTwFmm8hrGigx6GAkVrWknlUMBbb1ka', NULL, 2, NULL, 1),
(50, 20, 'jose', 'Jose@gmail.com', '$2y$10$nuzDqTHBon2rsiBJ8GW1ou32RONQJqZ6QNAXTuSp6RIbJqfKCS6k.', NULL, 3, NULL, 1),
(51, 20, 'pepe', 'juan@mail.comqsq', '$2y$10$GK.2RAaAX5lM/lci3cGepuNZJSip3O0/a6XNZizhs0LxEdWEns.hm', NULL, 1, NULL, 0),
(53, 20, 'foto', 'foto@k.cdd', '$2y$10$HQnEp1bAaJaAQJXBntdp0eWpLlZ0deGxkWnuAaH4qjsLL1z9XOQQG', 'emoji.png', 2, NULL, 1),
(54, 20, 'mate', 'mate@gmail.com', '$2y$10$sUYODHs8nPqnKEqSjyXO1OOyUGWTQVrFjoqpKq/0nsye2enTtD/nG', 'js.png', 2, NULL, 1),
(55, 20, 'dd', 'sdspepe@mail.com', '$2y$10$5p6iHS6Mz.d.kvkMTXXAt.akTWoYOG0.5XeTiDOkGRWOaZGuRWsfO', NULL, 1, NULL, 1),
(56, 20, 'pepe', 'juan@mail.comd', '$2y$10$IU5fDNWk6zALqxxI/qDpSeaxL2HQevth.CLP/r/pNcNYKacF7YZpi', NULL, 1, NULL, 1),
(57, 20, 'juan', 'tete@g.comxx', '$2y$10$ULnzxxaUHoKghNP/SIm63e2Q3zqTEhG6AnsLJYLasckws1CRmfNMC', 'raton-laveur.jpg', 2, NULL, 1),
(58, 20, 'juan', 'drvie@gmail.comdq', '$2y$10$h7J2Ll3B4ziJ/ydp7neeW.bqlBtO0AMwtwomoPMAmXhnM0vIOVpmW', NULL, 1, NULL, 1),
(59, 19, 'passager', 'passager734@gmail.com', '$2y$10$TPpwvjShwUwX78TtOVoDSeJD6jYjhioe2S75NKldTnijcP1xZospu', NULL, 1, NULL, 1),
(60, 20, 'juan', 'nocarro@gmail.com', '$2y$10$jtWtlXWGt..r.9c/XfK8GOHCYU4aNmLQftdWrVmxHgFS6Wu4hI0cG', 'emoji.png', 2, NULL, 1),
(61, 20, 'cdss', 'tete@g.comc', '$2y$10$Ww1r29Zn/7IcXyeGKL/ZK.2R.D4LtOPgqSWH.0NXlmX/K59xRdXQi', NULL, 1, NULL, 1),
(62, 20, 'juan', 'sincarro@gmaiml.com', '$2y$10$UI6M6wIq0mjfi2vSSoqFKenvG/fgbD4vjO48JeEwy9qtyq2XGM1NS', 'emoji.png', 3, NULL, 1),
(63, 20, 'juan', 'sincarro@gmail.com', '$2y$10$2EvZiDKMQudXi4QkTeWQQ.C3yniarFqmDAej481BnIDx7IADTqOuu', 'emoji.png', 2, NULL, 1),
(64, 20, 'Juanes', 'juanes@gmail.com', '$2y$10$33D4UPT.4if4GK5N3ayE.e0OnBRMC3W4UQhaUegkpLzI8c1Ya8Yoi', 'emoji.png', 3, NULL, 1),
(65, 29, 'Pepito', 'pepitopro214@gmail.com', '$2y$10$W52X8HJ1zDECoou1WoOfaeyeM66lvs1Opvg111zJ6.Byhvx.q1dqa', 'emoji.png', 3, '67b2308aa76212.23436902.png', 1),
(66, 20, 'Employé', 'employe@gmail.com', '$2y$12$FUqcA6UYdAM5l0xC6KBxIOYohLFB2GCQYjKRPtTfJ0V7goQAQQObC', NULL, 4, NULL, 1),
(67, 5, 'Admin', 'admin@gmail.com', '$2y$12$.sKPwBdcKYHz2ahb9wBkR.z9S9V/LHqdXCs5LqDOtE29YW5Fqt3Y2', NULL, 5, NULL, 1),
(68, 20, 'Employe_2', 'Employe_2@gmail.com', '$2y$12$KlFdyGjjIqVskVKB.Hv9quWNMdLNQgAYvp5t.BYuuNn6ZoBDBHNlK', NULL, 4, NULL, 0),
(69, 20, 'Employe_3', 'Employe_3@gmail.com', '$2y$12$xqdPEPSaxuIEViEaF5QMselKsKMDEFD/lgVP/cQwHYcbAihg3fJmy', NULL, 4, NULL, 1),
(70, 20, 'Employe_4', 'Employe_4@gmail.com', '$2y$12$QsQjXep2/AQrqv/dSRTs8uAIHJoCvJoL/nD6jSp79iQ4QqMArgUiO', NULL, 4, NULL, 1),
(71, 20, 'nameCheap', 'nameCheap@gmail.com', '$2y$12$g2stEeEWI8j0E.c3Eqgm6OiuQsG777.kIhwZJwG59o7dmtwaG19Si', 'js.png', 3, '682a4aeae55ad9.55359770.png', 1),
(72, 20, 'test', 'test@gmail.com', '$2y$12$bbdlmABEExSefQH.Li3Nc.5cCwbxaLf1spARJxlYstfiuf4G3xbEm', NULL, 1, NULL, 1),
(73, 20, 'juan', 'juan2@gmail.com', '$2y$12$o5ggUgNb6fOrK9w04bIBn.i7oZAb4k9DVuNQszUCaDxHirCEORkjC', 'js.png', 2, '682a4d670a26b1.05322966.png', 1),
(75, 20, 'juan', 'juan@mail.com', '$2y$12$C/Vp20cjrYFdmpB7ojgYKOwxq.CU5SQWEFZt600msJct0TSgEWeca', NULL, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `User_Covoiturage`
--

CREATE TABLE `User_Covoiturage` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `covoiturage_id` int UNSIGNED NOT NULL,
  `statut_id` int UNSIGNED NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User_Covoiturage`
--

INSERT INTO `User_Covoiturage` (`id`, `user_id`, `covoiturage_id`, `statut_id`) VALUES
(24, 59, 14, 1),
(25, 59, 12, 4),
(79, 47, 11, 1),
(81, 59, 15, 1),
(84, 47, 12, 1),
(85, 67, 23, 1);

-- --------------------------------------------------------

--
-- Structure de la table `User_Preference`
--

CREATE TABLE `User_Preference` (
  `id` int UNSIGNED NOT NULL,
  `preference_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `User_Preference`
--

INSERT INTO `User_Preference` (`id`, `preference_id`, `user_id`) VALUES
(1, 3, 47),
(2, 4, 47),
(3, 1, 65),
(4, 2, 65);

-- --------------------------------------------------------

--
-- Structure de la table `Voiture`
--

CREATE TABLE `Voiture` (
  `id` int UNSIGNED NOT NULL,
  `modele` varchar(255) NOT NULL,
  `couleur` varchar(50) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `immatriculation` varchar(9) NOT NULL,
  `date_premiere_immatriculation` date NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `energie_id` int UNSIGNED NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Voiture`
--

INSERT INTO `Voiture` (`id`, `modele`, `couleur`, `marque`, `immatriculation`, `date_premiere_immatriculation`, `user_id`, `energie_id`) VALUES
(9, 'mercedes', 'rojo', 'benz', 'AA-123-BC', '2025-01-17', 47, 3),
(12, 'cars', 'rojo', 'toyota', 'AA-123-DC', '2025-01-04', 47, 3),
(13, 'mc4', 'Blue', 'ferrari', 'BB-123-BC', '2005-05-14', 50, 3),
(14, 'XM3', 'rojo', 'lambo', 'AA-123-DN', '2025-01-30', 54, 3),
(15, 'zasas', 'sas', 'azsazs', 'AA-123-AM', '2025-02-12', 60, 2),
(16, 'mamma', 'csdcds', 'csdcd', 'AA-123-BM', '2025-02-06', 63, 3),
(17, 'mb06', 'Negro', 'Chevrolet', 'BB-123-BX', '2010-06-17', 47, 3),
(18, 'Max12', 'Grise', 'Volvo', 'AA-123-MN', '2025-01-28', 47, 3),
(19, 'md23', 'rojo', 'BMW', 'AA-123-NM', '2025-02-03', 47, 1),
(20, 'XM33', 'Rouge', 'Lambo', 'BB-123-BB', '2025-01-30', 64, 1),
(21, 'XM234', 'Noir', 'lambo', 'CC-123-BC', '2025-01-27', 65, 1),
(22, 'A8', 'Grise', 'Audi', 'AA-123-FF', '2024-10-17', 47, 1),
(23, 'AC45', 'Rouge', 'Nissan', 'AA-123-MW', '2025-02-25', 65, 3),
(24, 'X-Trail', 'noir', 'Nissan', 'AA-123-ZZ', '2011-01-01', 71, 3),
(25, 'X-Trail', 'Blanc', 'Nissan', 'BB-123-MM', '2025-01-01', 73, 3),
(30, 'X-Trail', 'Grise', 'Nissan', 'BB-123-MS', '2018-01-02', 47, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_covoiturage_id` (`user_covoiturage_id`);

--
-- Index pour la table `Covoiturage`
--
ALTER TABLE `Covoiturage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voiture_id` (`voiture_id`),
  ADD KEY `statut_id` (`statut_id`);

--
-- Index pour la table `Energie`
--
ALTER TABLE `Energie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Preference`
--
ALTER TABLE `Preference`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Preference_Personnelle`
--
ALTER TABLE `Preference_Personnelle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Statut`
--
ALTER TABLE `Statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Index pour la table `User_Covoiturage`
--
ALTER TABLE `User_Covoiturage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_covoiturage_ibfk_2` (`covoiturage_id`),
  ADD KEY `statut_id` (`statut_id`);

--
-- Index pour la table `User_Preference`
--
ALTER TABLE `User_Preference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `preference_id` (`preference_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `Voiture`
--
ALTER TABLE `Voiture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Covoiturage`
--
ALTER TABLE `Covoiturage`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `Energie`
--
ALTER TABLE `Energie`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Preference`
--
ALTER TABLE `Preference`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Preference_Personnelle`
--
ALTER TABLE `Preference_Personnelle`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Role`
--
ALTER TABLE `Role`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Statut`
--
ALTER TABLE `Statut`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT pour la table `User_Covoiturage`
--
ALTER TABLE `User_Covoiturage`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT pour la table `User_Preference`
--
ALTER TABLE `User_Preference`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT pour la table `Voiture`
--
ALTER TABLE `Voiture`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Commentaire`
--
ALTER TABLE `Commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`user_covoiturage_id`) REFERENCES `User_Covoiturage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Covoiturage`
--
ALTER TABLE `Covoiturage`
  ADD CONSTRAINT `covoiturage_ibfk_1` FOREIGN KEY (`voiture_id`) REFERENCES `Voiture` (`id`),
  ADD CONSTRAINT `covoiturage_ibfk_2` FOREIGN KEY (`statut_id`) REFERENCES `Statut` (`id`);

--
-- Contraintes pour la table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Role` (`id`);

--
-- Contraintes pour la table `Preference_Personnelle`
--
ALTER TABLE `Preference_Personnelle`
  ADD CONSTRAINT `preference_personnelle_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `User_Covoiturage`
--
ALTER TABLE `User_Covoiturage`
  ADD CONSTRAINT `user_covoiturage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_covoiturage_ibfk_2` FOREIGN KEY (`covoiturage_id`) REFERENCES `Covoiturage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_covoiturage_ibfk_3` FOREIGN KEY (`statut_id`) REFERENCES `Statut` (`id`);

--
-- Contraintes pour la table `User_Preference`
--
ALTER TABLE `User_Preference`
  ADD CONSTRAINT `user_preference_ibfk_1` FOREIGN KEY (`preference_id`) REFERENCES `Preference` (`id`),
  ADD CONSTRAINT `user_preference_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

