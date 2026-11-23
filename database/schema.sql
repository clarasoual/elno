-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 23 nov. 2026 à 15:19
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `elno`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formulas`
--

CREATE TABLE `formulas` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `formulas`
--

INSERT INTO `formulas` (`id`, `name`, `description`, `price`, `photo`, `video`) VALUES
(1, 'Solo', 'Pour un moment intimiste, Nino vous accompagne seul à la guitare. Idéale pour une cérémonie laïque, un vin d\'honneur ou un dîner, cette formule apporte une ambiance douce et élégante, sans jamais couvrir les conversations. Le répertoire mêle chanson française, folk et grands classiques pop, adaptés en version acoustique (Wonderwall (Oasis), La Bohème (Charles Aznavour), Fast Car (Tracy Chapman), Dreams (Fleetwood Mac), Hallelujah (Leonard Cohen). La durée et le choix des morceaux parmi une liste prédéfinie se font ensemble selon votre événement.', '100 euros', 'images/elno13.jpg', NULL),
(2, 'Duo', 'Nino et Elliott réunissent guitare et chant pour une prestation plus complète. Forts de plus de 15 ans d\'expérience, ils s\'adaptent à chaque moment de votre événement : une ouverture tout en douceur pendant le cocktail, puis une ambiance plus festive en soirée. Le duo peut aussi interpréter un morceau choisi pour un moment fort, comme l\'entrée des mariés. Le programme se construit avec vous, en fonction de vos envies. Vous pourrez y retrouver Can\'t Help Falling in Love (Elvis Presley), Jolene (Dolly Parton), Stand By Me (Ben E. King), Les Champs-Élysées (Joe Dassin) ou même Ain\'t No Sunshine (Bill Withers).', '200 euros', 'images/elno33.jpg', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `reservation_number` varchar(20) DEFAULT NULL,
  `status` enum('en_attente','refuse','annule','confirme','termine_sans_avis','termine_avec_avis') NOT NULL DEFAULT 'en_attente',
  `client_type` enum('particulier','professionnel') NOT NULL,
  `formula_id` int(11) NOT NULL,
  `event_location` varchar(300) NOT NULL,
  `event_type` varchar(100) NOT NULL,
  `event_description` text NOT NULL,
  `event_date` date NOT NULL,
  `prestation_duration` enum('moins_1h','1h_2h','2h_3h','plus_3h') NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `reservation_date` datetime DEFAULT current_timestamp(),
  `rules_accepted_at` datetime NOT NULL,
  `reservation_treatment` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `formulas`
--
ALTER TABLE `formulas`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_number` (`reservation_number`),
  ADD KEY `formula_id` (`formula_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formulas`
--
ALTER TABLE `formulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`formula_id`) REFERENCES `formulas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
