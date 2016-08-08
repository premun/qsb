-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Počítač: wh03.farma.gigaserver.cz
-- Vygenerováno: Úte 15. říj 2013, 20:30
-- Verze serveru: 5.1.69
-- Verze PHP: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `qsb_cz_base`
--
-- CREATE DATABASE IF NOT EXISTS `qsb_cz_base` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- USE `qsb_cz_base`;

-- --------------------------------------------------------

--
-- Struktura tabulky `ankety`
--

DROP TABLE IF EXISTS `ankety`;
CREATE TABLE IF NOT EXISTS `ankety` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otazka` text COLLATE utf8_czech_ci NOT NULL,
  `odpovedi` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `banky`
--

DROP TABLE IF EXISTS `banky`;
CREATE TABLE IF NOT EXISTS `banky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(24) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vlastnik` int(11) NOT NULL DEFAULT '0',
  `ir1` double NOT NULL DEFAULT '0',
  `ir2` double NOT NULL DEFAULT '0',
  `kapital` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `banky`
--

INSERT INTO `banky` (`id`, `jmeno`, `vlastnik`, `ir1`, `ir2`, `kapital`) VALUES
(1, 'Centrální Banka', 0, 8, 2, 268776147);

-- --------------------------------------------------------

--
-- Struktura tabulky `boti`
--

DROP TABLE IF EXISTS `boti`;
CREATE TABLE IF NOT EXISTS `boti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL,
  `rasa` int(11) NOT NULL,
  `kluzak` int(11) NOT NULL,
  `prestiz` int(11) NOT NULL,
  `vyhry` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `boti_jmena`
--

DROP TABLE IF EXISTS `boti_jmena`;
CREATE TABLE IF NOT EXISTS `boti_jmena` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1728 ;

--
-- Vypisuji data pro tabulku `boti_jmena`
--

INSERT INTO `boti_jmena` (`id`, `jmeno`) VALUES
(1, 'Sharan'),
(2, 'Hortrayn'),
(3, 'Lanreen'),
(4, 'Sancin'),
(5, 'Ardn'),
(6, 'Loell'),
(7, 'Melos'),
(8, 'Soon'),
(9, 'Skyeema'),
(10, 'Narus'),
(11, 'Jon'),
(12, 'Loloinne'),
(13, 'Leine'),
(14, 'Quelprin'),
(15, 'Eldo'),
(16, 'Selqus'),
(17, 'Keless'),
(18, 'Nelloinne'),
(19, 'Oorek'),
(20, 'Arderre'),
(21, 'Jokef'),
(22, 'Loqus'),
(23, 'Skymel'),
(24, 'Nexus'),
(25, 'Nurax'),
(26, 'Lorng'),
(27, 'Coren'),
(28, 'Nahrn'),
(29, 'Rhynia'),
(30, 'Qualell'),
(31, 'Karia'),
(32, 'Kradres'),
(33, 'Morek'),
(34, 'Quelkin'),
(35, 'Shikin'),
(36, 'Nayik'),
(37, 'Akadge'),
(38, 'Anterre'),
(39, 'Sritrian'),
(40, 'Darkran'),
(41, 'Joia'),
(42, 'Santrayn'),
(43, 'Modra'),
(44, 'Tunhrn'),
(45, 'Johuff'),
(46, 'Darkus'),
(47, 'Akareen'),
(48, 'Tavray'),
(49, 'Meller'),
(50, 'Qualker'),
(51, 'Melbus'),
(52, 'Tavng'),
(53, 'Ooron'),
(54, 'Mothant'),
(55, 'Anash'),
(56, 'Sello'),
(57, 'Dakbatt'),
(58, 'Oerre'),
(59, 'Ceddo'),
(60, 'Antbaoth'),
(61, 'Anaodia'),
(62, 'Makik'),
(63, 'Savos'),
(64, 'Faqus'),
(65, 'Zakef'),
(66, 'Sohek'),
(67, 'Moreema'),
(68, 'Lous'),
(69, 'Tennah'),
(70, 'Kutezsh'),
(71, 'Jonah'),
(72, 'Faprin'),
(73, 'Celann'),
(74, 'Maksyn'),
(75, 'Mite'),
(76, 'Nama'),
(77, 'Keller'),
(78, 'Naberre'),
(79, 'Landge'),
(80, 'Dryms'),
(81, 'Trgent'),
(82, 'Helprin'),
(83, 'Dakodia'),
(84, 'Lortrin'),
(85, 'Mona'),
(86, 'Nabran'),
(87, 'Lendge'),
(88, 'Nercken'),
(89, 'Oogent'),
(90, 'Ardbaoth'),
(91, 'Rygent'),
(92, 'Ohrn'),
(93, 'Kareema'),
(94, 'Anthek'),
(95, 'Skyess'),
(96, 'Helik'),
(97, 'Lanmel'),
(98, 'Talrus'),
(99, 'Haron'),
(100, 'Torturus'),
(101, 'Hakin'),
(102, 'Torrus'),
(103, 'Nabbatt'),
(104, 'Helvold'),
(105, 'Nunah'),
(106, 'Makin'),
(107, 'Ben'),
(108, 'Fadine'),
(109, 'Cedy'),
(110, 'Tryel'),
(111, 'Trnica'),
(112, 'Berik'),
(113, 'Oona'),
(114, 'Norsyn'),
(115, 'Hacen'),
(116, 'Qualgana'),
(117, 'Srios'),
(118, 'Tarkrott'),
(119, 'Jekef'),
(120, 'Tunell'),
(121, 'Lenron'),
(122, 'Ardrott'),
(123, 'Shicen'),
(124, 'Terrdine'),
(125, 'Jodra'),
(126, 'Sanhrn'),
(127, 'Ely'),
(128, 'Darkel'),
(129, 'Ceden'),
(130, 'Orwalker'),
(131, 'Aen'),
(132, 'Ordine'),
(133, 'Monah'),
(134, 'Terrlo'),
(135, 'Alkef'),
(136, 'Horus'),
(137, 'Ooia'),
(138, 'Krarott'),
(139, 'Zake'),
(140, 'Terrturus'),
(141, 'Tenron'),
(142, 'Kutlo'),
(143, 'Nuron'),
(144, 'Norgana'),
(145, 'Jebatt'),
(146, 'Orerre'),
(147, 'Becen'),
(148, 'Nexrak'),
(149, 'Renah'),
(150, 'Nexilles'),
(151, 'Alnah'),
(152, 'Selik'),
(153, 'Tenos'),
(154, 'Cyneran'),
(155, 'Ellis'),
(156, 'Mothgana'),
(157, 'Ganmi'),
(158, 'Naytrin'),
(159, 'Jelis'),
(160, 'Mothhek'),
(161, 'Pabus'),
(162, 'Olo'),
(163, 'Dakron'),
(164, 'Norma'),
(165, 'Shaka'),
(166, 'Sarma'),
(167, 'Jareen'),
(168, 'Archayen'),
(169, 'Tyrodia'),
(170, 'Nabray'),
(171, 'Marbatt'),
(172, 'Darkker'),
(173, 'Mibatt'),
(174, 'Loin'),
(175, 'Palena'),
(176, 'Lorsyn'),
(177, 'Lanhuff'),
(178, 'Leecin'),
(179, 'Lenron'),
(180, 'Soma'),
(181, 'Wecus'),
(182, 'Tarkezsh'),
(183, 'Jeen'),
(184, 'Anttrin'),
(185, 'Savn'),
(186, 'Tungana'),
(187, 'Bedge'),
(188, 'Zarsiri'),
(189, 'Sharan'),
(190, 'Lightvold'),
(191, 'Morke'),
(192, 'Naydres'),
(193, 'Wilia'),
(194, 'Darkms'),
(195, 'Zado'),
(196, 'Berrus'),
(197, 'Lun'),
(198, 'Tryng'),
(199, 'Rylena'),
(200, 'Selsiri'),
(201, 'Jaron'),
(202, 'Noronel'),
(203, 'Lenmi'),
(204, 'Risdine'),
(205, 'Oona'),
(206, 'Ardus'),
(207, 'Ooreen'),
(208, 'Bercken'),
(209, 'Alin'),
(210, 'Archles'),
(211, 'Ryran'),
(212, 'Krasyn'),
(213, 'Srinah'),
(214, 'Krakin'),
(215, 'Parek'),
(216, 'Leeezsh'),
(217, 'Nabron'),
(218, 'Nerhek'),
(219, 'Pate'),
(220, 'Tryma'),
(221, 'Cellena'),
(222, 'Terrloinne'),
(223, 'Morek'),
(224, 'Andin'),
(225, 'Celmi'),
(226, 'Riserre'),
(227, 'Marsati'),
(228, 'Rislan'),
(229, 'Cedbatt'),
(230, 'Fang'),
(231, 'Paken'),
(232, 'Gunrus'),
(233, 'Kelmi'),
(234, 'Thrarak'),
(235, 'Jokin'),
(236, 'Ardma'),
(237, 'Ben'),
(238, 'Helhek'),
(239, 'Joeema'),
(240, 'Lorrak'),
(241, 'Ardlla'),
(242, 'Sokin'),
(243, 'Ardkin'),
(244, 'Faqus'),
(245, 'Luos'),
(246, 'Kraturus'),
(247, 'Tensh'),
(248, 'Soilles'),
(249, 'Anaodia'),
(250, 'Berrott'),
(251, 'Aedo'),
(252, 'Thrain'),
(253, 'Savdra'),
(254, 'Lorturus'),
(255, 'Aekin'),
(256, 'Horturus'),
(257, 'Mien'),
(258, 'Talilles'),
(259, 'Trgent'),
(260, 'Andbaoth'),
(261, 'Nugent'),
(262, 'Riserre'),
(263, 'Shiria'),
(264, 'Mothrak'),
(265, 'Aeric'),
(266, 'Mothloinne'),
(267, 'Lanler'),
(268, 'Eldine'),
(269, 'Shalena'),
(270, 'Cynerak'),
(271, 'Besati'),
(272, 'Terrker'),
(273, 'Rein'),
(274, 'Makkin'),
(275, 'Meln'),
(276, 'Beronel'),
(277, 'Marmel'),
(278, 'Horrott'),
(279, 'Rhyna'),
(280, 'Mothprin'),
(281, 'Oolla'),
(282, 'Horlo'),
(283, 'Lenbus'),
(284, 'Tunma'),
(285, 'Zay'),
(286, 'Ardwol'),
(287, 'Mon'),
(288, 'Sarus'),
(289, 'Anabus'),
(290, 'Andbaoth'),
(291, 'Jete'),
(292, 'Lightms'),
(293, 'Dakeema'),
(294, 'Terrlan'),
(295, 'Corcus'),
(296, 'Kraross'),
(297, 'Mon'),
(298, 'Krakin'),
(299, 'Jeria'),
(300, 'Makhrn'),
(301, 'Karkra'),
(302, 'Me''hen'),
(303, 'Bornar'),
(304, 'Lor''rel'),
(305, 'Lisrith'),
(306, 'Rynn''fro'),
(307, 'Rettrel'),
(308, 'Tayl''klo'),
(309, 'Rettkav'),
(310, 'Is''ryn'),
(311, 'Norf'),
(312, 'Y''kor'),
(313, 'Gast'),
(314, 'Trecskae'),
(315, 'Belshk'),
(316, 'Trec''ela'),
(317, 'Liskar'),
(318, 'Gir''lon'),
(319, 'Qurrith'),
(320, 'Uu''tey'),
(321, 'Raynek'),
(322, 'Bree''sor'),
(323, 'Larsel'),
(324, 'Nan''lia'),
(325, 'Lisan'),
(326, 'Rka''leb'),
(327, 'Dennar'),
(328, 'Rynn''fro'),
(329, 'Niayel'),
(330, 'Mal''shyk'),
(331, 'Qurreb'),
(332, 'Del''tey'),
(333, 'Brerith'),
(334, 'Kry''kre'),
(335, 'Gareb'),
(336, 'Kry''lie'),
(337, 'Vurra'),
(338, 'Y''lar'),
(339, 'Liaryn'),
(340, 'Tayl''skar'),
(341, 'Vurrith'),
(342, 'Y''kji'),
(343, 'Kruoreb'),
(344, 'Kar''lon'),
(345, 'Aspor'),
(346, 'Y''sor'),
(347, 'Asarn'),
(348, 'Loren''locc'),
(349, 'Kurnek'),
(350, 'Yi''kji'),
(351, 'Vurnek'),
(352, 'Dza''kav'),
(353, 'Lisra'),
(354, 'Den''skar'),
(355, 'Asnir'),
(356, 'Sho''skar'),
(357, 'Dirrnir'),
(358, 'Lyu''ag'),
(359, 'Bempor'),
(360, 'Ranklin'),
(361, 'Denroc'),
(362, 'Vil''cor'),
(363, 'Grepsk'),
(364, 'Dza''limm'),
(365, 'Denyr'),
(366, 'Vil''lia'),
(367, 'Yebst'),
(368, 'Fey''leb'),
(369, 'Eurkar'),
(370, 'Y''kre'),
(371, 'Pesnir'),
(372, 'Tre''tey'),
(373, 'Bosbek'),
(374, 'Rayl''bre'),
(375, 'Kurra'),
(376, 'Yi''ryn'),
(377, 'Terrth'),
(378, 'Vil''lia'),
(379, 'Kom'),
(380, 'Vil''shyk'),
(381, 'Asrsk'),
(382, 'Velnyy'),
(383, 'Morkra'),
(384, 'Nan''lon'),
(385, 'Norka'),
(386, 'Fey''rel'),
(387, 'Velf'),
(388, 'Lor''vel'),
(389, 'Ourliam'),
(390, 'Bree''vel'),
(391, 'Brebek'),
(392, 'Mal''lan'),
(393, 'Norkar'),
(394, 'Trec''kav'),
(395, 'Kast'),
(396, 'Yi''vel'),
(397, 'Lissku'),
(398, 'Tre''rov'),
(399, 'Inir'),
(400, 'Is''kre'),
(401, 'Velkav'),
(402, 'Nacck''sar'),
(403, 'Breka'),
(404, 'Sho''lya'),
(405, 'Jorkett'),
(406, 'Vel''bre'),
(407, 'Akaamm'),
(408, 'Rynn''rag'),
(409, 'Kopor'),
(410, 'Loren''sku'),
(411, 'Akara'),
(412, 'Fey''fey'),
(413, 'Norryn'),
(414, 'Uu''kre'),
(415, 'Velnir'),
(416, 'Drak''sar'),
(417, 'Denssk'),
(418, 'Nan''skar'),
(419, 'Dirrroc'),
(420, 'Sho''vel'),
(421, 'Ganan'),
(422, 'Rayl''lie'),
(423, 'Densel'),
(424, 'Bos''rag'),
(425, 'Terrka'),
(426, 'Aam''sku'),
(427, 'Morren'),
(428, 'Rank''bre'),
(429, 'Bemkav'),
(430, 'Sei''kre'),
(431, 'Denpor'),
(432, 'Rynn''leb'),
(433, 'Morshk'),
(434, 'Fre''lik'),
(435, 'Kruoamm'),
(436, 'Bkar''rel'),
(437, 'Karith'),
(438, 'Bree''leb'),
(439, 'Vursig'),
(440, 'Rayllin'),
(441, 'Ceyr'),
(442, 'Vel''cor'),
(443, 'Jorka'),
(444, 'Oruo''lik'),
(445, 'Jorkra'),
(446, 'Dan''kel'),
(447, 'Garen'),
(448, 'Nay''skar'),
(449, 'Jorra'),
(450, 'Kre''shyk'),
(451, 'Grepyr'),
(452, 'Sho''tey'),
(453, 'Askett'),
(454, 'Cl''leb'),
(455, 'Test'),
(456, 'Fey''rel'),
(457, 'Celiam'),
(458, 'Fey''tey'),
(459, 'Akaok'),
(460, 'Lyu''tey'),
(461, 'Norkett'),
(462, 'Trec''bre'),
(463, 'Teka'),
(464, 'Rank''sar'),
(465, 'Morsk'),
(466, 'Yansana'),
(467, 'Asyyk'),
(468, 'Sei''sro'),
(469, 'Kurrith'),
(470, 'Loren''kav'),
(471, 'Girnah'),
(472, 'Sei''kel'),
(473, 'Abyr'),
(474, 'Kayl''rel'),
(475, 'Karsku'),
(476, 'Kaylskae'),
(477, 'Asnan'),
(478, 'Tayl''sku'),
(479, 'Akaf'),
(480, 'Drak''sey'),
(481, 'Gaka'),
(482, 'Lyu''lik'),
(483, 'Kokar'),
(484, 'Trec''sey'),
(485, 'Cem'),
(486, 'Rank''kre'),
(487, 'Girlekk'),
(488, 'Draknyy'),
(489, 'Iyr'),
(490, 'Tayl''tey'),
(491, 'Belann'),
(492, 'Uu''kor'),
(493, 'Karm'),
(494, 'Dza''skar'),
(495, 'Vellekk'),
(496, 'Kayl''tey'),
(497, 'Eurkav'),
(498, 'Mal''sro'),
(499, 'Dirrbey'),
(500, 'Tre''lan'),
(501, 'Kisk'),
(502, 'Ask''vel'),
(503, 'Qurrith'),
(504, 'Tre''vel'),
(505, 'Asnar'),
(506, 'Ska''kor'),
(507, 'Celiam'),
(508, 'Kayl''kav'),
(509, 'Qurnar'),
(510, 'Ska''lio'),
(511, 'Larm'),
(512, 'Fey''sku'),
(513, 'Vurarn'),
(514, 'Rynn''rel'),
(515, 'Kruoo'),
(516, 'Den''lar'),
(517, 'Asdra'),
(518, 'Fey''locc'),
(519, 'Lishf'),
(520, 'Rayl''skar'),
(521, 'Pornah'),
(522, 'Rank''vel'),
(523, 'Brest'),
(524, 'Rayl''lon'),
(525, 'Nabf'),
(526, 'Tayl''skar'),
(527, 'Velkra'),
(528, 'Lor''tey'),
(529, 'Yebra'),
(530, 'Kayl''lya'),
(531, 'Qurrith'),
(532, 'Vri''vel'),
(533, 'Jorsel'),
(534, 'Tayl''sor'),
(535, 'Gurbek'),
(536, 'Aam''kre'),
(537, 'Ourssk'),
(538, 'Sho''lya'),
(539, 'Liakar'),
(540, 'Ask''lon'),
(541, 'Cenan'),
(542, 'Ask''kre'),
(543, 'Lorsel'),
(544, 'Oruo''lon'),
(545, 'Nabliam'),
(546, 'Bos''shyk'),
(547, 'Khiran'),
(548, 'Sei''rel'),
(549, 'Ceryn'),
(550, 'Del''lie'),
(551, 'Niaok'),
(552, 'Oruolin'),
(553, 'Vurok'),
(554, 'Rayl''rag'),
(555, 'Terrkav'),
(556, 'Fre''klo'),
(557, 'Stam'),
(558, 'Fey''syk'),
(559, 'Lorok'),
(560, 'Kayl''rov'),
(561, 'Inir'),
(562, 'Vil''shyk'),
(563, 'Esov'),
(564, 'Fey''bre'),
(565, 'Ourrynn'),
(566, 'Krylin'),
(567, 'Abill'),
(568, 'Kayl''lon'),
(569, 'Rettill'),
(570, 'Bkar''kre'),
(571, 'Assku'),
(572, 'Sho''rag'),
(573, 'Greprith'),
(574, 'Nan''rov'),
(575, 'Cenah'),
(576, 'Trec''lan'),
(577, 'Qurkar'),
(578, 'Bree''lan'),
(579, 'Teroc'),
(580, 'Rynn''ia'),
(581, 'Lorf'),
(582, 'Fey''bre'),
(583, 'Khirazs'),
(584, 'Aam''kav'),
(585, 'Eurnan'),
(586, 'Aam''kre'),
(587, 'Kuro'),
(588, 'Rka''tey'),
(589, 'Ikra'),
(590, 'Dan''lan'),
(591, 'Asann'),
(592, 'Sei''skar'),
(593, 'Lorsku'),
(594, 'Me''sar'),
(595, 'Assku'),
(596, 'Me''lie'),
(597, 'Porth'),
(598, 'Kry''lia'),
(599, 'Yebkra'),
(600, 'Fey''ryn'),
(601, 'Nooty''epp'),
(602, 'Zakbi'),
(603, 'Koant'),
(604, 'Zendi''mad'),
(605, 'Jabe''orn'),
(606, 'Wynred'),
(607, 'Miuna'),
(608, 'Gulnor''sac'),
(609, 'Kazool''har'),
(610, 'Tred'),
(611, 'Thoorr'),
(612, 'Lise'),
(613, 'Diona'),
(614, 'Docva''una'),
(615, 'Gaela''lib'),
(616, 'Kth''il'),
(617, 'Kapsan'),
(618, 'Gerlib'),
(619, 'Zakva''kunn'),
(620, 'Hamoh''oree'),
(621, 'Toirr'),
(622, 'Kiine'),
(623, 'Racmi''ib'),
(624, 'Zenlaes''lar'),
(625, 'Gaetru''bec'),
(626, 'Aru'),
(627, 'Basil'),
(628, 'Aram''ik'),
(629, 'Kaptan''la'),
(630, 'Maltho''niei'),
(631, 'Nicmub''an'),
(632, 'Agsan'),
(633, 'Tanlen'),
(634, 'Agla''ette'),
(635, 'Math''ugi'),
(636, 'Filla''ugi'),
(637, 'Liyi'),
(638, 'Gerus'),
(639, 'Cyrssi''irn'),
(640, 'Zennal''us'),
(641, 'Bgel''bec'),
(642, 'Gaemi''epp'),
(643, 'Bnoc''orr'),
(644, 'Gulkoo''ido'),
(645, 'Docald''kunn'),
(646, 'Diav''rin'),
(647, 'Doclot''an'),
(648, 'Naba''la'),
(649, 'Gaena'),
(650, 'Notepp'),
(651, 'Natiza'),
(652, 'Olik'),
(653, 'Nanal''yan'),
(654, 'Zaknot''ma'),
(655, 'Carki''orn'),
(656, 'Rovmo''ee'),
(657, 'Torssi''kunn'),
(658, 'Noent'),
(659, 'Notik'),
(660, 'Fielo''nas'),
(661, 'Mava''orn'),
(662, 'Gaety''irn'),
(663, 'Kmoh''lib'),
(664, 'Lao''ido'),
(665, 'Haool''ant'),
(666, 'Linee''ona'),
(667, 'Kapool''orn'),
(668, 'Doccl''sin'),
(669, 'Kohko''il'),
(670, 'Naee''rin'),
(671, 'Cyrra'),
(672, 'Mubian'),
(673, 'Lynko''ik'),
(674, 'Oula''ette'),
(675, 'Aula''tak'),
(676, 'Docnoc''niei'),
(677, 'Rovvar''niei'),
(678, 'Lohgel''una'),
(679, 'Ko''ugi'),
(680, 'Cyra''nas'),
(681, 'Diao''ine'),
(682, 'Remo''denn'),
(683, 'Agnel''niei'),
(684, 'Nuna'),
(685, 'Lahar'),
(686, 'Kapula''orr'),
(687, 'Tkai''ette'),
(688, 'Nuu''lan'),
(689, 'Hava''an'),
(690, 'Lynnoc''ette'),
(691, 'Gaeula''or'),
(692, 'Zenipa'),
(693, 'Tusin'),
(694, 'Diarac''epp'),
(695, 'Redi''yan'),
(696, 'Zenmub''una'),
(697, 'Nicnot''oo'),
(698, 'Torbb'),
(699, 'Vasin'),
(700, 'Gulmub''ee'),
(701, 'Agli'),
(702, 'Baoo'),
(703, 'Daruk'),
(704, 'Gerra'),
(705, 'Laty''lan'),
(706, 'Malara'),
(707, 'Augi'),
(708, 'Linla''or'),
(709, 'Noolot''ette'),
(710, 'Malaa'),
(711, 'Vakunn'),
(712, 'Wynli'),
(713, 'Ulanas'),
(714, 'Noool''nas'),
(715, 'Nusan'),
(716, 'Aemm'),
(717, 'Linki''ine'),
(718, 'Ova''irn'),
(719, 'Arami''an'),
(720, 'Nicmoh''denn'),
(721, 'Racnor''na'),
(722, 'Dianot''lar'),
(723, 'Tov''oo'),
(724, 'Arbe''sil'),
(725, 'Linana'),
(726, 'Kius'),
(727, 'Tormax'),
(728, 'Mimad'),
(729, 'Zaknal''yan'),
(730, 'Taa''an'),
(731, 'Natee''len'),
(732, 'Argel''ra'),
(733, 'Manot''ra'),
(734, 'Linam''una'),
(735, 'Lohlot''kunn'),
(736, 'Jaald''niei'),
(737, 'Filbe''sil'),
(738, 'Gulkoo''ette'),
(739, 'Nool''lik'),
(740, 'Loo''ili'),
(741, 'Cyrtak''il'),
(742, 'Noomi''lik'),
(743, 'Gultru''rin'),
(744, 'Latho''en'),
(745, 'Arbel''ik'),
(746, 'Liula''na'),
(747, 'Docne'),
(748, 'Amoree'),
(749, 'Jath''mad'),
(750, 'Fitru''ian'),
(751, 'Toko''nas'),
(752, 'Natgre''sac'),
(753, 'Filkoo''len'),
(754, 'Nukai''la'),
(755, 'Zakol''epp'),
(756, 'Zenrac''an'),
(757, 'Docmi''ma'),
(758, 'Doca''lib'),
(759, 'Wynmer''epp'),
(760, 'Doccl''orr'),
(761, 'Bna'),
(762, 'Bealin'),
(763, 'Wynger''ma'),
(764, 'Ficl''oo'),
(765, 'Arla''lar'),
(766, 'Kamoh''sin'),
(767, 'Gulnot''ant'),
(768, 'Kapron'),
(769, 'Takkunn'),
(770, 'Koham''len'),
(771, 'Niclot''bec'),
(772, 'Diamub''ugi'),
(773, 'Nuula''bec'),
(774, 'Nadon'),
(775, 'Uus'),
(776, 'Gullaes''sil'),
(777, 'Zentu''ona'),
(778, 'Nicko''niei'),
(779, 'Teeto'),
(780, 'Navdux'),
(781, 'Kavata'),
(782, 'Sookoorni'),
(783, 'Meelux'),
(784, 'Qoocla'),
(785, 'Qiila'),
(786, 'Qoockas'),
(787, 'Droboo'),
(788, 'Bodova'),
(789, 'Qioorni'),
(790, 'Donro'),
(791, 'Bodotor'),
(792, 'Gadvo'),
(793, 'Qino'),
(794, 'Feeoush'),
(795, 'Frothdux'),
(796, 'Harvaro'),
(797, 'Looak'),
(798, 'Pqweeoorni'),
(799, 'Drono'),
(800, 'Dorux'),
(801, 'Dheendo'),
(802, 'Horno'),
(803, 'Dwekool'),
(804, 'Hornu'),
(805, 'Gornu'),
(806, 'Dweveid'),
(807, 'Bodoku'),
(808, 'Doto'),
(809, 'Dwenu'),
(810, 'Thunu'),
(811, 'Kooreek'),
(812, 'Reeno'),
(813, 'Dheenreek'),
(814, 'Paroiv'),
(815, 'Andvat'),
(816, 'Dheenata'),
(817, 'Dodis'),
(818, 'Reidoo'),
(819, 'Malva'),
(820, 'Donu'),
(821, 'Reezo'),
(822, 'Gruku'),
(823, 'Droto'),
(824, 'Grouwieedo'),
(825, 'Grouvek'),
(826, 'Beeno'),
(827, 'Doik'),
(828, 'Dolno'),
(829, 'Loood'),
(830, 'Dheento'),
(831, 'Koose'),
(832, 'Loose'),
(833, 'Navdak'),
(834, 'Navdro'),
(835, 'Bodokas'),
(836, 'Pqweebis'),
(837, 'Neeboo'),
(838, 'Reeto'),
(839, 'Feeno'),
(840, 'Koovo'),
(841, 'Chidak'),
(842, 'Dwedux'),
(843, 'Treela'),
(844, 'Neeveid'),
(845, 'Beero'),
(846, 'Gruux'),
(847, 'Feekool'),
(848, 'Pqweeku'),
(849, 'Neevat'),
(850, 'Qoocla'),
(851, 'Dodro'),
(852, 'Availa'),
(853, 'Meelod'),
(854, 'Neeaf'),
(855, 'Beedro'),
(856, 'Qoocveid'),
(857, 'Lookas'),
(858, 'Neeida'),
(859, 'Qoocwieedo'),
(860, 'Hyod'),
(861, 'Teeboo'),
(862, 'Reiaf'),
(863, 'Dwela'),
(864, 'Meeloush'),
(865, 'Thuoush'),
(866, 'Kavto'),
(867, 'Gadoush'),
(868, 'Grouzo'),
(869, 'Goriv'),
(870, 'Doina'),
(871, 'Teeva'),
(872, 'Dheenvaro'),
(873, 'Qoocvo'),
(874, 'Teequux'),
(875, 'Avase'),
(876, 'Teedak'),
(877, 'Keevo'),
(878, 'Cevku'),
(879, 'Harvek'),
(880, 'Bodonro'),
(881, 'Stanku'),
(882, 'Cevtor'),
(883, 'Dwetor'),
(884, 'Drokas'),
(885, 'Cevoorni'),
(886, 'Keebis'),
(887, 'Pqweevaro'),
(888, 'Kavmo'),
(889, 'Treeaf'),
(890, 'Dheento'),
(891, 'Gorto'),
(892, 'Meelvat'),
(893, 'Gadoorni'),
(894, 'Feeoorni'),
(895, 'Prereek'),
(896, 'Doila'),
(897, 'Dheenno'),
(898, 'Reiboo'),
(899, 'Chorva'),
(900, 'Garina'),
(901, 'Pqweeod'),
(902, 'Thuno'),
(903, 'Garvat'),
(904, 'Pqweeku'),
(905, 'Treezo'),
(906, 'Cevbis'),
(907, 'Dormo'),
(908, 'Dovo'),
(909, 'Dovek'),
(910, 'Qoocbis'),
(911, 'Grouida'),
(912, 'Dheenquux'),
(913, 'Skoorni'),
(914, 'Qoocku'),
(915, 'Dovo'),
(916, 'Stanvat'),
(917, 'Neemo'),
(918, 'Beeak'),
(919, 'Standan'),
(920, 'Dobis'),
(921, 'Gruboo'),
(922, 'Pqweese'),
(923, 'Andku'),
(924, 'Avavaro'),
(925, 'Treeod'),
(926, 'Malvat'),
(927, 'Meelzo'),
(928, 'Chiida'),
(929, 'Dorkas'),
(930, 'Qinro'),
(931, 'Avato'),
(932, 'Stanva'),
(933, 'Droboo'),
(934, 'Dweoush'),
(935, 'Chiku'),
(936, 'Horzo'),
(937, 'Greeiv'),
(938, 'Dorla'),
(939, 'Cevno'),
(940, 'Sookzo'),
(941, 'Avaoorni'),
(942, 'Keenro'),
(943, 'Qiku'),
(944, 'Qoocess'),
(945, 'Cevvaro'),
(946, 'Juovat'),
(947, 'Meelod'),
(948, 'Needoo'),
(949, 'Looak'),
(950, 'Sniila'),
(951, 'Treedo'),
(952, 'Gadvo'),
(953, 'Pqweedak'),
(954, 'Beeik'),
(955, 'Dweno'),
(956, 'Feeno'),
(957, 'Dweveid'),
(958, 'Andvo'),
(959, 'Neeto'),
(960, 'Malvo'),
(961, 'Harno'),
(962, 'Gorkool'),
(963, 'Paroquux'),
(964, 'Treeto'),
(965, 'Juoto'),
(966, 'Keeto'),
(967, 'Koozo'),
(968, 'Treedan'),
(969, 'Avato'),
(970, 'Qidan'),
(971, 'Reiak'),
(972, 'Qoocvat'),
(973, 'Droboo'),
(974, 'Needis'),
(975, 'Gorreek'),
(976, 'Skdan'),
(977, 'Dorwieedo'),
(978, 'Spetmun'),
(979, 'Nawdik'),
(980, 'Tararac'),
(981, 'Chewanta'),
(982, 'Kerrikazza'),
(983, 'Ralbow'),
(984, 'Tarartu'),
(985, 'Jipanta'),
(986, 'Jowbacca'),
(987, 'Wirappia'),
(988, 'Grozarac'),
(989, 'Geyymapia'),
(990, 'Kiatha'),
(991, 'Lofbacca'),
(992, 'Drytocca'),
(993, 'Tamlambac'),
(994, 'Arrchir'),
(995, 'Spetbow'),
(996, 'Shobeca'),
(997, 'Grakanta'),
(998, 'Lumpamapia'),
(999, 'Grakrhynn'),
(1000, 'Tamak'),
(1001, 'Jowkazza'),
(1002, 'Lumpatalon'),
(1003, 'Chendrrl'),
(1004, 'Lumpaika'),
(1005, 'Dryika'),
(1006, 'Shobow'),
(1007, 'Wirtocca'),
(1008, 'Mallatyrra'),
(1009, 'Grayshuc'),
(1010, 'Kallalynn'),
(1011, 'Katbacca'),
(1012, 'Gaardik'),
(1013, 'Dryarac'),
(1014, 'Geyyraccor'),
(1015, 'Urbeca'),
(1016, 'Chalrirr'),
(1017, 'Mahtamba'),
(1018, 'Chalahab'),
(1019, 'Katmapia'),
(1020, 'Lumpava'),
(1021, 'Gaarbaca'),
(1022, 'Graran'),
(1023, 'Gorrrao'),
(1024, 'Wrrlevbow'),
(1025, 'Monrhynn'),
(1026, 'Katbukk'),
(1027, 'Lofyshuc'),
(1028, 'Graydrrl'),
(1029, 'Katthar'),
(1030, 'Buahab'),
(1031, 'Shodrrl'),
(1032, 'Gorryrra'),
(1033, 'Katbukk'),
(1034, 'Jipral'),
(1035, 'Gaarthar'),
(1036, 'Nagara'),
(1037, 'Grakartu'),
(1038, 'Nawrhynn'),
(1039, 'Snoatha'),
(1040, 'Grakabukk'),
(1041, 'Wirbukk'),
(1042, 'Wirhitchuk'),
(1043, 'Grozlynn'),
(1044, 'Urobuk'),
(1045, 'Lofatha'),
(1046, 'Groznik'),
(1047, 'Raabaorrack'),
(1048, 'Jipmun'),
(1049, 'Snotamba'),
(1050, 'Tarsurra'),
(1051, 'Frobow'),
(1052, 'Jowbeca'),
(1053, 'Jipara'),
(1054, 'Katchir'),
(1055, 'Jipbaca'),
(1056, 'Katyshuc'),
(1057, 'Bulambac'),
(1058, 'Chewika'),
(1059, 'Grayartu'),
(1060, 'Graylambac'),
(1061, 'Lofrump'),
(1062, 'Arrtalon'),
(1063, 'Dryyshuc'),
(1064, 'Kerribow'),
(1065, 'Graanta'),
(1066, 'Lamera'),
(1067, 'Kerridik'),
(1068, 'Enobow'),
(1069, 'Krurran'),
(1070, 'Naghitchuk'),
(1071, 'Tarkyysh'),
(1072, 'Utraccor'),
(1073, 'Mallatkabukk'),
(1074, 'Urbukk'),
(1075, 'Urbow'),
(1076, 'Utmapia'),
(1077, 'Buika'),
(1078, 'Chenera'),
(1079, 'Monartu'),
(1080, 'Tardrrl'),
(1081, 'Geyyhitchuk'),
(1082, 'Salykam'),
(1083, 'Chenkazza'),
(1084, 'Gaarchir'),
(1085, 'Krurporrin'),
(1086, 'Kroika'),
(1087, 'Froevge'),
(1088, 'Urak'),
(1089, 'Krolambac'),
(1090, 'Kroruun'),
(1091, 'Shoevge'),
(1092, 'Graraccor'),
(1093, 'Enodik'),
(1094, 'Isshamapia'),
(1095, 'Dewlanorrack'),
(1096, 'Drylambac'),
(1097, 'Gaartocca'),
(1098, 'Katmapia'),
(1099, 'Katobuk'),
(1100, 'Mallatthar'),
(1101, 'Lamporrin'),
(1102, 'Kattamba'),
(1103, 'Wirbukk'),
(1104, 'Jowrhynn'),
(1105, 'Chewnik'),
(1106, 'Krurran'),
(1107, 'Attiobuk'),
(1108, 'Lofara'),
(1109, 'Wrrlanta'),
(1110, 'Buara'),
(1111, 'Tartalon'),
(1112, 'Frochir'),
(1113, 'Nawahab'),
(1114, 'Mallatyrra'),
(1115, 'Grozbaca'),
(1116, 'Gaartalon'),
(1117, 'Shoobuk'),
(1118, 'Ralbow'),
(1119, 'Raabaporrin'),
(1120, 'Grakyysh'),
(1121, 'Krurrirr'),
(1122, 'Grakral'),
(1123, 'Chewika'),
(1124, 'Geyytamba'),
(1125, 'Nawyshuc'),
(1126, 'Attithar'),
(1127, 'Dryran'),
(1128, 'Ballagor'),
(1129, 'Naknok'),
(1130, 'Corron'),
(1131, 'Borska'),
(1132, 'Dunok'),
(1133, 'Yaka'),
(1134, 'Mordor'),
(1135, 'Rocnac'),
(1136, 'Grownok'),
(1137, 'Kradga'),
(1138, 'Rukzek'),
(1139, 'Orukdel'),
(1140, 'Ballakkal'),
(1141, 'Krevla'),
(1142, 'Freknorr'),
(1143, 'Prakhen'),
(1144, 'Morron'),
(1145, 'Felskka'),
(1146, 'Morsk'),
(1147, 'Corkkal'),
(1148, 'Vargor'),
(1149, 'Boron'),
(1150, 'Attraur'),
(1151, 'Rukga'),
(1152, 'Roplok'),
(1153, 'Kradgen'),
(1154, 'Corron'),
(1155, 'Ballajo'),
(1156, 'Lunklya'),
(1157, 'Frekdor'),
(1158, 'Raknok'),
(1159, 'Scugor'),
(1160, 'Yarukk'),
(1161, 'Lankcck'),
(1162, 'Druknok'),
(1163, 'Drellguss'),
(1164, 'Ruuncek'),
(1165, 'Oruktor'),
(1166, 'Drukkhen'),
(1167, 'Attrarha'),
(1168, 'Krevdel'),
(1169, 'Ruknac'),
(1170, 'Wynkha'),
(1171, 'Kyrnorr'),
(1172, 'Krevjo'),
(1173, 'Drukrua'),
(1174, 'Durnok'),
(1175, 'Bosrschk'),
(1176, 'Durtha'),
(1177, 'Gurkkev'),
(1178, 'Rakska'),
(1179, 'Bonik'),
(1180, 'Pakla'),
(1181, 'Lacmha'),
(1182, 'Nakalok'),
(1183, 'Roptor'),
(1184, 'Lankgen'),
(1185, 'Pranar'),
(1186, 'Growryuc'),
(1187, 'Dukpor'),
(1188, 'Vardel'),
(1189, 'Ruunnac'),
(1190, 'Ruuntrak'),
(1191, 'Gurkcek'),
(1192, 'Bokkal'),
(1193, 'Rocska'),
(1194, 'Yaur'),
(1195, 'Nakask'),
(1196, 'Porlua'),
(1197, 'Kradrha'),
(1198, 'Frekda'),
(1199, 'Junur'),
(1200, 'Dutha'),
(1201, 'Growkev'),
(1202, 'Norsur'),
(1203, 'Frokla'),
(1204, 'Fuykha'),
(1205, 'Krevgen'),
(1206, 'Naktrak'),
(1207, 'Wynron'),
(1208, 'Ruunla'),
(1209, 'Fuynar'),
(1210, 'Porur'),
(1211, 'Lankgen'),
(1212, 'Duguss'),
(1213, 'Rukga'),
(1214, 'Ropgak'),
(1215, 'Drellskka'),
(1216, 'Gurksk'),
(1217, 'Wynlok'),
(1218, 'Krevrukk'),
(1219, 'Dukssk'),
(1220, 'Dutha'),
(1221, 'Junzek'),
(1222, 'Botrak'),
(1223, 'Lankdor'),
(1224, 'Froksk'),
(1225, 'Bosrlaa'),
(1226, 'Krevssk'),
(1227, 'Kyrron'),
(1228, 'Fuydel'),
(1229, 'Froknac'),
(1230, 'Pakguss'),
(1231, 'Druklaa'),
(1232, 'Scuguss'),
(1233, 'Scutha'),
(1234, 'Lankpor'),
(1235, 'Porrha'),
(1236, 'Lunkaron'),
(1237, 'Grertor'),
(1238, 'Junryuc'),
(1239, 'Corlya'),
(1240, 'Vortor'),
(1241, 'Pranok'),
(1242, 'Freklya'),
(1243, 'Gurkrha'),
(1244, 'Gukdel'),
(1245, 'Fuygor'),
(1246, 'Attrapor'),
(1247, 'Wynur'),
(1248, 'Pakga'),
(1249, 'Vornok'),
(1250, 'Paknar'),
(1251, 'Corlua'),
(1252, 'Lankcek'),
(1253, 'Ropyul'),
(1254, 'Scugak'),
(1255, 'Rukssk'),
(1256, 'Pakska'),
(1257, 'Durvrak'),
(1258, 'Yukkvrak'),
(1259, 'Moraron'),
(1260, 'Dukmha'),
(1261, 'Rocryuc'),
(1262, 'Fuylaa'),
(1263, 'Borlya'),
(1264, 'Grerdor'),
(1265, 'Gurklua'),
(1266, 'Bosrda'),
(1267, 'Vartha'),
(1268, 'Bosrdor'),
(1269, 'Grerkhen'),
(1270, 'Bosk'),
(1271, 'Lacnac'),
(1272, 'Guktrak'),
(1273, 'Pakron'),
(1274, 'Rocga'),
(1275, 'Morlua'),
(1276, 'Varnorr'),
(1277, 'Orukskka'),
(1278, 'Niowan'),
(1279, 'Chorhan'),
(1280, 'Crutan'),
(1281, 'Narrnk'),
(1282, 'Hutkai'),
(1283, 'Kodor'),
(1284, 'Drakk'),
(1285, 'Limian'),
(1286, 'Luthuul'),
(1287, 'Lumraa'),
(1288, 'Raria'),
(1289, 'Karkis'),
(1290, 'Sarzek'),
(1291, 'Mordar'),
(1292, 'Mrosk'),
(1293, 'Morei'),
(1294, 'Gredph'),
(1295, 'Aaren'),
(1296, 'Shran'),
(1297, 'Vakzon'),
(1298, 'Saitok'),
(1299, 'Bekvam'),
(1300, 'Gratok'),
(1301, 'Dilnk'),
(1302, 'Rokria'),
(1303, 'Kren'),
(1304, 'Sarien'),
(1305, 'Bekkrre'),
(1306, 'Kyas'),
(1307, 'Remdue'),
(1308, 'Luthphek'),
(1309, 'Khsan'),
(1310, 'Crudrr'),
(1311, 'Naath'),
(1312, 'Rkoras'),
(1313, 'Prular'),
(1314, 'Kazkik'),
(1315, 'Dulren'),
(1316, 'Largra'),
(1317, 'Chonk'),
(1318, 'Kazsuk'),
(1319, 'Vuhian'),
(1320, 'Sanya'),
(1321, 'Dulrhan'),
(1322, 'Cruya'),
(1323, 'Morker'),
(1324, 'Drlaar'),
(1325, 'Narag'),
(1326, 'Gredic'),
(1327, 'Tordup'),
(1328, 'Nitika'),
(1329, 'Zabwyr'),
(1330, 'Qaaria'),
(1331, 'Fokkvam'),
(1332, 'Kazzul'),
(1333, 'Narrkel'),
(1334, 'Kydrr'),
(1335, 'Vuhrhan'),
(1336, 'Mlarzek'),
(1337, 'Krous'),
(1338, 'Xeddle'),
(1339, 'Koarl'),
(1340, 'Saruun'),
(1341, 'Bekeli'),
(1342, 'Lokai'),
(1343, 'Yuuieli'),
(1344, 'Rokcle'),
(1345, 'Saian'),
(1346, 'Weiien'),
(1347, 'Dildue'),
(1348, 'Gredran'),
(1349, 'Remwen'),
(1350, 'Nedran'),
(1351, 'Fokkbil'),
(1352, 'Roaph'),
(1353, 'Narrker'),
(1354, 'Kazdle'),
(1355, 'Toreli'),
(1356, 'Kyic'),
(1357, 'Keargar'),
(1358, 'Wortok'),
(1359, 'Uei'),
(1360, 'Rokuun'),
(1361, 'Narrwyr'),
(1362, 'Sralth'),
(1363, 'Dingon'),
(1364, 'Eeakk'),
(1365, 'Pruarl'),
(1366, 'Vier'),
(1367, 'Ukis'),
(1368, 'Xisbei'),
(1369, 'Wodxeq'),
(1370, 'Khanule'),
(1371, 'Vakmorr'),
(1372, 'Viuun'),
(1373, 'Koev'),
(1374, 'Belic'),
(1375, 'Kno'),
(1376, 'Nidur'),
(1377, 'Kemen'),
(1378, 'Doner'),
(1379, 'Koxeq'),
(1380, 'Rokdhyr'),
(1381, 'Yuuileev'),
(1382, 'Zarsk'),
(1383, 'Dilbil'),
(1384, 'Clerhur'),
(1385, 'Lukrhan'),
(1386, 'Luthphek'),
(1387, 'Targon'),
(1388, 'Veshgen'),
(1389, 'Dinric'),
(1390, 'Tryuun'),
(1391, 'Vekkis'),
(1392, 'Kahpran'),
(1393, 'Vekrhan'),
(1394, 'Xedrin'),
(1395, 'Gekkker'),
(1396, 'Kidhyr'),
(1397, 'Fokkkrre'),
(1398, 'Nitok'),
(1399, 'Pruvam'),
(1400, 'Xedlak'),
(1401, 'Kearth'),
(1402, 'Roaowan'),
(1403, 'Sabil'),
(1404, 'Nhphek'),
(1405, 'Lekkgon'),
(1406, 'Limth'),
(1407, 'Narrkel'),
(1408, 'Kahptika'),
(1409, 'Sertor'),
(1410, 'Khanran'),
(1411, 'Woddup'),
(1412, 'Donas'),
(1413, 'Kargon'),
(1414, 'Gredtek'),
(1415, 'Vuhrous'),
(1416, 'Zarkai'),
(1417, 'Dulbrea'),
(1418, 'Khaarrn'),
(1419, 'Dulsan'),
(1420, 'Gredlan'),
(1421, 'Naadue'),
(1422, 'Xedhu'),
(1423, 'Narrkis'),
(1424, 'Kurtan'),
(1425, 'Juokel'),
(1426, 'Santan'),
(1427, 'Bedric'),
(1428, 'Kahuul'),
(1429, 'Dmarous'),
(1430, 'Huthu'),
(1431, 'Serxeq'),
(1432, 'Kazas'),
(1433, 'Morkis'),
(1434, 'Rokith'),
(1435, 'Vekno'),
(1436, 'Kahpkik'),
(1437, 'Vekkis'),
(1438, 'Kyria'),
(1439, 'Juotor'),
(1440, 'Beldle'),
(1441, 'Kanwyr'),
(1442, 'Qotphek'),
(1443, 'Dilren'),
(1444, 'Smeq'),
(1445, 'Keei'),
(1446, 'Kihur'),
(1447, 'Dinrakk'),
(1448, 'Larle'),
(1449, 'Lekknk'),
(1450, 'Saihran'),
(1451, 'Lukmer'),
(1452, 'Sarphek'),
(1453, 'Shudar'),
(1454, 'Roktek'),
(1455, 'Naaren'),
(1456, 'Sangen'),
(1457, 'Bedei'),
(1458, 'Mrohur'),
(1459, 'Kearmen'),
(1460, 'Kahpphek'),
(1461, 'Narrth'),
(1462, 'Khansk'),
(1463, 'Narrnk'),
(1464, 'Clerria'),
(1465, 'Lumsan'),
(1466, 'Khadhyr'),
(1467, 'Limynel'),
(1468, 'Viuun'),
(1469, 'Dulnnh'),
(1470, 'Mlarphek'),
(1471, 'Utor'),
(1472, 'Mrosuk'),
(1473, 'Choker'),
(1474, 'Cleric'),
(1475, 'Vuhei'),
(1476, 'Weith'),
(1477, 'Morwyr'),
(1478, 'Kahtok'),
(1479, 'Torkis'),
(1480, 'Nitok'),
(1481, 'Veknk'),
(1482, 'Khaicia'),
(1483, 'Bekeli'),
(1484, 'Rulran'),
(1485, 'Bedkis'),
(1486, 'Qotsuk'),
(1487, 'Juoker'),
(1488, 'Kahzek'),
(1489, 'Kkis'),
(1490, 'Khacle'),
(1491, 'Vuhkel'),
(1492, 'Graph'),
(1493, 'Shuric'),
(1494, 'Loria'),
(1495, 'Lukdor'),
(1496, 'Ruluul'),
(1497, 'Dilker'),
(1498, 'Limhran'),
(1499, 'Dulren'),
(1500, 'Kahplak'),
(1501, 'Barawyr'),
(1502, 'Eeran'),
(1503, 'Remrakk'),
(1504, 'Roagra'),
(1505, 'Duldup'),
(1506, 'Eezek'),
(1507, 'Bedbil'),
(1508, 'Clerlar'),
(1509, 'Lekkynel'),
(1510, 'Kuricia'),
(1511, 'Fokknnh'),
(1512, 'Limtok'),
(1513, 'Zabarl'),
(1514, 'Drria'),
(1515, 'Tharic'),
(1516, 'Beldur'),
(1517, 'Dilmorr'),
(1518, 'Khansk'),
(1519, 'Dinlre'),
(1520, 'Limule'),
(1521, 'Fokkkel'),
(1522, 'Niicia'),
(1523, 'Narrvam'),
(1524, 'Kahpria'),
(1525, 'Vekdup'),
(1526, 'Radhyr'),
(1527, 'Kosan'),
(1528, 'Khaule'),
(1529, 'Mithynel'),
(1530, 'Kahowan'),
(1531, 'Vuhkel'),
(1532, 'Limdur'),
(1533, 'Sawyr'),
(1534, 'Sanuul'),
(1535, 'Shuren'),
(1536, 'Saidhyr'),
(1537, 'Noukrre'),
(1538, 'Nhic'),
(1539, 'Zabzon'),
(1540, 'Raphek'),
(1541, 'Nouleev'),
(1542, 'Xissuk'),
(1543, 'Chodor'),
(1544, 'Yemtika'),
(1545, 'Gekkeli'),
(1546, 'Marnimn'),
(1547, 'Kanraa'),
(1548, 'Luthkik'),
(1549, 'Prurepp'),
(1550, 'Khanicia'),
(1551, 'Prurepp'),
(1552, 'Nhta'),
(1553, 'Kanei'),
(1554, 'Cruakk'),
(1555, 'Kewen'),
(1556, 'Mlarle'),
(1557, 'Dmaarl'),
(1558, 'Worgra'),
(1559, 'Naakrre'),
(1560, 'Nhle'),
(1561, 'Juoeli'),
(1562, 'Lolar'),
(1563, 'Nouxeq'),
(1564, 'Kiien'),
(1565, 'Aadup'),
(1566, 'Rokle'),
(1567, 'Dulev'),
(1568, 'Yemmeq'),
(1569, 'Krous'),
(1570, 'Lorin'),
(1571, 'Gekkmorr'),
(1572, 'Rokuul'),
(1573, 'Narrei'),
(1574, 'Eenimn'),
(1575, 'Karzon'),
(1576, 'Lozul'),
(1577, 'Narrdor'),
(1578, 'Nuukkrak'),
(1579, 'Libphen'),
(1580, 'Opkush'),
(1581, 'Tuzbrac'),
(1582, 'Cligfan'),
(1583, 'Arbro'),
(1584, 'Lofan'),
(1585, 'Mekba'),
(1586, 'Tokmin'),
(1587, 'Reru'),
(1588, 'Refan'),
(1589, 'Rehal'),
(1590, 'Sesfan'),
(1591, 'Tukaga'),
(1592, 'Mekqual'),
(1593, 'Legaga'),
(1594, 'Nermal'),
(1595, 'Omon'),
(1596, 'Onoaga'),
(1597, 'Sessth'),
(1598, 'Nesmek'),
(1599, 'Tresfal'),
(1600, 'Aaklar'),
(1601, 'Tuzol'),
(1602, 'Aaknesh'),
(1603, 'Ralgan'),
(1604, 'Nesmoor'),
(1605, 'Nesnel'),
(1606, 'Akanmor'),
(1607, 'Mligba'),
(1608, 'Tekol'),
(1609, 'Libmoor'),
(1610, 'Leernel'),
(1611, 'Ralseh'),
(1612, 'Tresqual'),
(1613, 'Kalbrac'),
(1614, 'Opba'),
(1615, 'Nuukkrak'),
(1616, 'Rebrac'),
(1617, 'Upnin'),
(1618, 'Ackassi'),
(1619, 'Tekqual'),
(1620, 'Jheralli'),
(1621, 'Upoga'),
(1622, 'Leerma'),
(1623, 'Opsth'),
(1624, 'Cligru'),
(1625, 'Remal'),
(1626, 'Ipmal'),
(1627, 'Neralli'),
(1628, 'Mralbrac'),
(1629, 'Nermoor'),
(1630, 'Retab'),
(1631, 'Gunaiser'),
(1632, 'Mralbrac'),
(1633, 'Opkrak'),
(1634, 'Gungan'),
(1635, 'Aakroush'),
(1636, 'Tukkha'),
(1637, 'Arbaga'),
(1638, 'Kalnoasam'),
(1639, 'Neba'),
(1640, 'Ragtor'),
(1641, 'Arbseh'),
(1642, 'Onooga'),
(1643, 'Reszh'),
(1644, 'Gunqual'),
(1645, 'Nuuklor'),
(1646, 'Ononoasam'),
(1647, 'Legol'),
(1648, 'Tonoasam'),
(1649, 'Ipnoasam'),
(1650, 'Rekara'),
(1651, 'Libsam'),
(1652, 'Kalmal'),
(1653, 'Nemor'),
(1654, 'Tresru'),
(1655, 'Cligmal'),
(1656, 'Akanaiser'),
(1657, 'Acktor'),
(1658, 'Mekkush'),
(1659, 'Reot'),
(1660, 'Akanseh'),
(1661, 'Tektor'),
(1662, 'Ipqual'),
(1663, 'Tralpphen'),
(1664, 'Arbru'),
(1665, 'Tralplalli'),
(1666, 'Nekrak'),
(1667, 'Mralmiti'),
(1668, 'Gunot'),
(1669, 'Traltor'),
(1670, 'Legseh'),
(1671, 'Onolar'),
(1672, 'Aakma'),
(1673, 'Upassi'),
(1674, 'Tuzqual'),
(1675, 'Nuuknar'),
(1676, 'Leermiti'),
(1677, 'Ralnar'),
(1678, 'Ibtiba'),
(1679, 'Akanaiser'),
(1680, 'Gorthma'),
(1681, 'Cligmor'),
(1682, 'Rouru'),
(1683, 'Tralnor'),
(1684, 'Legszh'),
(1685, 'Leernesh'),
(1686, 'Tralrit'),
(1687, 'Clignar'),
(1688, 'Opaga'),
(1689, 'Mekgan'),
(1690, 'Aakaga'),
(1691, 'Tralpassi'),
(1692, 'Peba'),
(1693, 'Leermin'),
(1694, 'Mrallor'),
(1695, 'Mutab'),
(1696, 'Sesnesh'),
(1697, 'Akanbar'),
(1698, 'Uckbar'),
(1699, 'Upnel'),
(1700, 'Maannar'),
(1701, 'Nerol'),
(1702, 'Nerlalli'),
(1703, 'Tokmon'),
(1704, 'Kaltor'),
(1705, 'Ragnel'),
(1706, 'Maanphen'),
(1707, 'Remoor'),
(1708, 'Ragbar'),
(1709, 'Ibtikha'),
(1710, 'Nuukaga'),
(1711, 'Tresmoor'),
(1712, 'Raglalli'),
(1713, 'Nelor'),
(1714, 'Uplalli'),
(1715, 'Mralfal'),
(1716, 'Cligkush'),
(1717, 'Altnor'),
(1718, 'Tukba'),
(1719, 'Arbma'),
(1720, 'Cligqual'),
(1721, 'Ackrit'),
(1722, 'Kalma'),
(1723, 'Ackmon'),
(1724, 'Retmin'),
(1725, 'Nuuksam'),
(1726, 'Leermek'),
(1727, 'Seskush');

-- --------------------------------------------------------

--
-- Struktura tabulky `boti_kluzaky`
--

DROP TABLE IF EXISTS `boti_kluzaky`;
CREATE TABLE IF NOT EXISTS `boti_kluzaky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typ` int(11) NOT NULL,
  `cena` int(11) NOT NULL,
  `kategorie` int(11) NOT NULL,
  `odolnost` int(11) NOT NULL,
  `ovladatelnost` int(11) NOT NULL,
  `podvozky` int(11) NOT NULL,
  `motory` int(11) NOT NULL,
  `drzaky` int(11) NOT NULL,
  `chladice` int(11) NOT NULL,
  `desky` int(11) NOT NULL,
  `brzdy` int(11) NOT NULL,
  `zdroje` int(11) NOT NULL,
  `suspenzory` int(11) NOT NULL,
  `p_motory` int(11) NOT NULL,
  `pancerovani` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=101 ;

--
-- Vypisuji data pro tabulku `boti_kluzaky`
--

INSERT INTO `boti_kluzaky` (`id`, `typ`, `cena`, `kategorie`, `odolnost`, `ovladatelnost`, `podvozky`, `motory`, `drzaky`, `chladice`, `desky`, `brzdy`, `zdroje`, `suspenzory`, `p_motory`, `pancerovani`) VALUES
(1, 3, 1, 1, 45, 38, 21, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(2, 3, 2, 1, 45, 38, 21, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(3, 3, 1, 2, 45, 41, 21, 1, 1, 2, 1, 3, 1, 0, 0, 0),
(4, 3, 2, 2, 45, 41, 21, 1, 1, 2, 1, 3, 1, 0, 0, 0),
(5, 3, 1, 3, 45, 44, 21, 1, 1, 2, 1, 5, 1, 0, 0, 0),
(6, 3, 2, 3, 45, 44, 21, 1, 1, 2, 1, 5, 1, 0, 0, 0),
(7, 3, 2, 4, 45, 44, 21, 3, 1, 3, 1, 6, 1, 0, 0, 0),
(8, 3, 3, 4, 45, 44, 21, 3, 1, 3, 1, 6, 1, 0, 0, 0),
(9, 3, 2, 5, 47, 45, 22, 4, 1, 3, 1, 6, 1, 0, 0, 0),
(10, 3, 3, 5, 47, 45, 22, 4, 1, 3, 1, 6, 1, 0, 0, 0),
(11, 3, 3, 6, 47, 50, 22, 5, 4, 4, 1, 9, 4, 0, 0, 0),
(12, 3, 4, 6, 47, 50, 22, 5, 4, 4, 1, 9, 4, 0, 0, 0),
(13, 3, 3, 7, 50, 53, 23, 6, 4, 4, 1, 10, 4, 0, 0, 0),
(14, 3, 4, 7, 50, 53, 23, 6, 4, 4, 1, 10, 4, 0, 0, 0),
(15, 3, 4, 10, 59, 68, 25, 7, 4, 10, 1, 13, 13, 0, 5, 0),
(16, 3, 5, 10, 59, 68, 25, 7, 4, 10, 1, 13, 13, 0, 5, 0),
(17, 3, 4, 8, 53, 54, 23, 5, 4, 8, 1, 10, 11, 0, 2, 0),
(18, 3, 5, 8, 53, 54, 23, 5, 4, 8, 1, 10, 11, 0, 2, 0),
(19, 3, 4, 9, 56, 59, 24, 7, 4, 9, 1, 10, 12, 0, 3, 0),
(20, 3, 5, 9, 56, 59, 24, 7, 4, 9, 1, 10, 12, 0, 3, 0),
(21, 3, 5, 11, 63, 68, 26, 7, 4, 11, 1, 14, 13, 0, 6, 0),
(22, 3, 5, 12, 63, 66, 26, 13, 4, 11, 1, 13, 12, 0, 4, 0),
(23, 3, 5, 13, 63, 71, 26, 13, 4, 13, 2, 14, 15, 0, 6, 0),
(24, 3, 5, 14, 68, 79, 28, 11, 9, 14, 2, 15, 17, 0, 7, 0),
(25, 3, 6, 15, 68, 79, 28, 15, 9, 14, 2, 15, 17, 0, 7, 0),
(26, 3, 6, 16, 74, 85, 30, 15, 9, 16, 2, 15, 20, 2, 7, 0),
(27, 3, 6, 17, 75, 86, 30, 15, 9, 18, 2, 15, 22, 2, 15, 0),
(28, 3, 6, 18, 74, 85, 30, 15, 9, 23, 2, 15, 24, 11, 17, 0),
(29, 3, 6, 19, 73, 86, 30, 15, 8, 27, 2, 17, 25, 21, 20, 0),
(30, 3, 6, 20, 72, 90, 30, 45, 27, 32, 2, 20, 30, 25, 20, 0),
(31, 3, 6, 21, 96, 96, 30, 15, 32, 39, 2, 20, 30, 25, 20, 20),
(32, 1, 1, 4, 19, 10, 1, 2, 5, 2, 11, 1, 5, 0, 0, 0),
(33, 1, 2, 4, 19, 10, 1, 2, 5, 2, 11, 1, 5, 0, 0, 0),
(34, 1, 2, 4, 20, 13, 2, 2, 1, 3, 11, 6, 1, 0, 0, 0),
(35, 1, 2, 4, 20, 13, 2, 2, 1, 3, 11, 6, 1, 0, 0, 0),
(36, 1, 2, 5, 20, 11, 2, 5, 1, 2, 11, 3, 4, 0, 0, 0),
(37, 1, 2, 5, 20, 11, 2, 5, 1, 2, 11, 3, 4, 0, 0, 0),
(38, 1, 3, 6, 21, 19, 2, 6, 1, 2, 12, 3, 4, 0, 0, 0),
(39, 1, 4, 6, 21, 19, 2, 6, 1, 2, 12, 3, 4, 0, 0, 0),
(40, 1, 3, 7, 22, 20, 3, 8, 4, 3, 12, 3, 7, 0, 0, 0),
(41, 1, 4, 7, 22, 20, 3, 8, 4, 3, 12, 3, 7, 0, 0, 0),
(42, 1, 4, 8, 22, 22, 3, 10, 6, 5, 12, 10, 8, 0, 0, 0),
(43, 1, 5, 8, 22, 22, 3, 10, 6, 5, 12, 10, 8, 0, 0, 0),
(44, 1, 4, 9, 24, 23, 4, 12, 6, 6, 12, 10, 8, 0, 0, 0),
(45, 1, 5, 9, 24, 23, 4, 12, 6, 6, 12, 10, 8, 0, 0, 0),
(46, 1, 5, 10, 25, 31, 5, 13, 6, 6, 13, 10, 10, 0, 0, 0),
(47, 1, 6, 10, 25, 31, 5, 13, 6, 6, 13, 10, 10, 0, 0, 0),
(48, 1, 5, 11, 25, 31, 5, 13, 17, 9, 13, 11, 13, 0, 0, 0),
(49, 1, 6, 11, 25, 31, 5, 13, 17, 9, 13, 11, 13, 0, 0, 0),
(50, 1, 5, 12, 26, 33, 5, 13, 21, 11, 13, 15, 15, 0, 0, 0),
(51, 1, 5, 12, 26, 33, 5, 13, 21, 11, 13, 15, 15, 0, 0, 0),
(52, 1, 5, 13, 26, 39, 6, 13, 25, 13, 13, 17, 15, 0, 0, 0),
(53, 1, 6, 13, 26, 39, 6, 13, 25, 13, 13, 17, 15, 0, 0, 0),
(54, 1, 5, 14, 26, 41, 6, 14, 26, 13, 15, 18, 19, 0, 0, 0),
(55, 1, 6, 14, 26, 41, 6, 14, 26, 13, 15, 18, 19, 0, 0, 0),
(56, 1, 5, 19, 34, 63, 10, 15, 32, 24, 14, 20, 28, 1, 16, 0),
(57, 1, 6, 19, 34, 63, 10, 15, 32, 24, 14, 20, 28, 1, 16, 0),
(58, 1, 6, 15, 26, 41, 6, 14, 32, 14, 15, 18, 20, 0, 0, 0),
(59, 1, 6, 16, 32, 53, 8, 14, 32, 16, 14, 19, 20, 0, 1, 0),
(60, 1, 6, 17, 32, 53, 8, 14, 32, 20, 14, 19, 23, 0, 7, 0),
(61, 1, 6, 18, 33, 68, 9, 14, 32, 21, 14, 20, 25, 0, 13, 0),
(62, 1, 6, 20, 34, 63, 10, 45, 32, 29, 15, 20, 30, 13, 20, 0),
(63, 1, 6, 21, 33, 61, 10, 45, 32, 34, 14, 20, 30, 25, 20, 0),
(64, 1, 1, 1, 19, 10, 1, 16, 1, 2, 11, 1, 1, 0, 0, 0),
(65, 1, 2, 1, 19, 10, 1, 16, 1, 2, 11, 1, 1, 0, 0, 0),
(66, 1, 1, 2, 19, 10, 1, 17, 1, 2, 11, 1, 1, 0, 0, 0),
(67, 1, 2, 2, 19, 10, 1, 17, 1, 2, 11, 1, 1, 0, 0, 0),
(68, 1, 1, 3, 19, 12, 1, 17, 1, 3, 11, 6, 1, 0, 0, 0),
(69, 1, 2, 3, 19, 12, 1, 17, 1, 3, 11, 6, 1, 0, 0, 0),
(70, 2, 1, 1, 29, 21, 11, 31, 1, 1, 6, 3, 1, 0, 0, 0),
(71, 2, 2, 1, 29, 21, 11, 31, 1, 1, 6, 3, 1, 0, 0, 0),
(72, 2, 1, 2, 30, 22, 11, 32, 1, 3, 6, 5, 1, 0, 0, 0),
(73, 2, 2, 2, 30, 22, 11, 32, 1, 3, 6, 5, 1, 0, 0, 0),
(74, 2, 1, 3, 30, 22, 11, 32, 1, 2, 6, 5, 2, 0, 0, 0),
(75, 2, 2, 3, 30, 22, 11, 32, 1, 2, 6, 5, 2, 0, 0, 0),
(76, 2, 2, 4, 29, 22, 11, 33, 1, 5, 6, 6, 4, 0, 0, 0),
(77, 2, 3, 4, 29, 22, 11, 33, 1, 5, 6, 6, 4, 0, 0, 0),
(78, 2, 2, 5, 31, 23, 12, 33, 1, 5, 6, 5, 11, 0, 0, 0),
(79, 2, 3, 5, 31, 23, 12, 33, 1, 5, 6, 5, 11, 0, 0, 0),
(80, 2, 3, 6, 31, 23, 12, 36, 3, 6, 6, 6, 8, 0, 0, 0),
(81, 2, 4, 6, 31, 23, 12, 36, 3, 6, 6, 6, 8, 0, 0, 0),
(82, 2, 3, 7, 32, 23, 12, 36, 3, 5, 6, 5, 11, 2, 0, 0),
(83, 2, 4, 7, 32, 23, 12, 36, 3, 5, 6, 5, 11, 2, 0, 0),
(85, 2, 5, 10, 36, 36, 14, 37, 8, 10, 7, 6, 18, 3, 4, 0),
(86, 2, 4, 8, 45, 29, 12, 37, 9, 6, 7, 5, 13, 2, 0, 0),
(87, 2, 5, 8, 45, 29, 12, 37, 9, 6, 7, 5, 13, 2, 0, 0),
(88, 2, 4, 9, 34, 35, 14, 37, 9, 7, 7, 6, 16, 3, 0, 0),
(89, 2, 5, 9, 34, 35, 14, 37, 9, 7, 7, 6, 16, 3, 0, 0),
(90, 2, 5, 11, 37, 54, 15, 40, 4, 11, 7, 16, 14, 0, 5, 0),
(91, 2, 5, 12, 39, 56, 16, 41, 4, 12, 7, 16, 14, 0, 5, 0),
(92, 2, 5, 13, 39, 58, 16, 42, 4, 14, 7, 18, 15, 0, 7, 0),
(93, 2, 5, 14, 39, 60, 16, 45, 4, 14, 7, 20, 15, 0, 7, 0),
(94, 2, 5, 15, 40, 60, 16, 45, 8, 17, 7, 20, 20, 4, 7, 0),
(95, 2, 5, 16, 42, 69, 18, 45, 8, 18, 7, 20, 20, 4, 9, 0),
(96, 2, 6, 17, 42, 71, 18, 14, 32, 20, 10, 19, 24, 0, 6, 0),
(97, 2, 6, 18, 45, 76, 19, 14, 32, 20, 10, 19, 28, 2, 7, 0),
(98, 2, 6, 19, 45, 75, 19, 14, 32, 24, 10, 19, 30, 9, 11, 0),
(99, 2, 6, 20, 49, 86, 20, 15, 32, 28, 10, 20, 30, 6, 20, 0),
(100, 2, 6, 21, 47, 83, 20, 15, 32, 34, 9, 20, 30, 18, 20, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `brigadnici`
--

DROP TABLE IF EXISTS `brigadnici`;
CREATE TABLE IF NOT EXISTS `brigadnici` (
  `login` int(11) NOT NULL DEFAULT '0',
  `brigada` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0;

--
-- Vypisuji data pro tabulku `brigadnici`
--

INSERT INTO `brigadnici` (`login`, `brigada`) VALUES
(2589, 8),
(864, 7),
(2751, 5),
(2773, 8),
(2770, 5),
(2795, 8),
(2498, 8),
(2779, 8),
(2758, 8),
(2798, 8),
(371, 8),
(2168, 8);

-- --------------------------------------------------------

--
-- Struktura tabulky `brigady`
--

DROP TABLE IF EXISTS `brigady`;
CREATE TABLE IF NOT EXISTS `brigady` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `penize` int(11) NOT NULL DEFAULT '0',
  `prestiz` int(11) NOT NULL DEFAULT '0',
  `prestiz2` int(11) NOT NULL DEFAULT '0',
  `max` int(11) NOT NULL DEFAULT '0',
  `rasa` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=9 ;

--
-- Vypisuji data pro tabulku `brigady`
--

INSERT INTO `brigady` (`id`, `nazev`, `penize`, `prestiz`, `prestiz2`, `max`, `rasa`) VALUES
(1, 'Barman', 240, 25, 8, 2, 10),
(2, 'Vyhazovač', 220, 55, 5, 6, 1),
(3, 'Uklízeč', 150, 80, 10, 12, 4),
(4, 'Startér závodů', 130, 60, 8, 12, 11),
(5, 'Mechanik', 190, 35, 6, 6, 12),
(7, 'Bookmaker', 500, 75, 14, 20, 5),
(8, 'Komentátor', 500, 75, 14, 20, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `brzdy`
--

DROP TABLE IF EXISTS `brzdy`;
CREATE TABLE IF NOT EXISTS `brzdy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vaha` int(11) NOT NULL DEFAULT '0',
  `ovladat` int(11) NOT NULL DEFAULT '0',
  `chlazeni` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=21 ;

--
-- Vypisuji data pro tabulku `brzdy`
--

INSERT INTO `brzdy` (`id`, `nazev`, `vaha`, `ovladat`, `chlazeni`, `vydrz`, `podvozek`) VALUES
(1, 'Inhibeo 12', 10, 5, 10, 140, 0),
(2, 'DriftMaster R10', 12, 10, 12, 170, 0),
(3, 'Stop-Cheeftain', 14, 15, 15, 215, 0),
(4, 'DriftMaster R20', 19, 22, 15, 193, 0),
(5, 'Skiddies', 22, 28, 22, 223, 0),
(6, 'Wiry', 18, 28, 27, 245, 0),
(7, 'Inhibeo+', 20, 40, 33, 238, 0),
(8, 'Speed Slayer', 22, 42, 37, 260, 0),
(9, 'Speed Slayer II', 24, 50, 41, 320, 0),
(10, 'Breaker', 26, 56, 46, 343, 0),
(11, 'Stop Wizard', 27, 61, 50, 365, 0),
(12, 'Stop-Cheeftain II', 30, 68, 56, 388, 0),
(13, 'Atrittion Max', 32, 73, 62, 403, 0),
(14, 'DriftMaster D74', 34, 79, 68, 418, 0),
(15, 'Speed-Bender', 38, 82, 76, 440, 0),
(16, 'Gelotripsy', 38, 85, 84, 485, 0),
(17, 'Inhibeo 11G', 41, 88, 92, 530, 0),
(18, 'Atrittion Extra', 44, 90, 98, 590, 0),
(19, 'Instan-tei', 45, 94, 100, 620, 0),
(20, 'Zetor Multiplex Ultra', 42, 98, 110, 680, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `budovy`
--

DROP TABLE IF EXISTS `budovy`;
CREATE TABLE IF NOT EXISTS `budovy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `budova` int(11) NOT NULL DEFAULT '0',
  `staj` int(11) NOT NULL DEFAULT '0',
  `staveni` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=218 ;

--
-- Vypisuji data pro tabulku `budovy`
--

INSERT INTO `budovy` (`id`, `budova`, `staj`, `staveni`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 4, 1, 0),
(4, 1, 2, 0),
(5, 2, 2, 0),
(6, 2, 2, 0),
(7, 7, 2, 0),
(8, 7, 2, 0),
(9, 2, 2, 0),
(10, 1, 3, 0),
(11, 2, 3, 0),
(12, 2, 3, 0),
(16, 1, 4, 0),
(14, 7, 1, 0),
(15, 2, 3, 0),
(17, 2, 4, 0),
(31, 6, 4, 0),
(33, 6, 4, 0),
(21, 6, 4, 0),
(32, 6, 4, 0),
(29, 6, 4, 0),
(34, 1, 6, 0),
(35, 2, 6, 0),
(36, 6, 4, 0),
(37, 6, 4, 0),
(38, 6, 4, 0),
(39, 2, 6, 0),
(40, 4, 6, 0),
(41, 5, 6, 0),
(42, 6, 6, 0),
(43, 6, 4, 0),
(44, 6, 4, 0),
(45, 6, 4, 0),
(46, 6, 4, 0),
(47, 6, 4, 0),
(48, 1, 7, 0),
(54, 6, 7, 0),
(53, 6, 7, 0),
(55, 6, 7, 0),
(56, 2, 7, 0),
(57, 6, 2, 0),
(58, 6, 2, 0),
(59, 6, 2, 0),
(60, 6, 2, 0),
(61, 6, 2, 0),
(62, 6, 2, 0),
(63, 6, 2, 0),
(64, 6, 2, 0),
(65, 6, 2, 0),
(66, 6, 2, 0),
(67, 8, 2, 0),
(68, 8, 2, 0),
(69, 8, 2, 0),
(70, 8, 2, 0),
(71, 8, 2, 0),
(72, 8, 2, 0),
(73, 8, 2, 0),
(74, 8, 2, 0),
(75, 8, 2, 0),
(76, 8, 2, 0),
(77, 8, 2, 0),
(78, 8, 2, 0),
(79, 8, 2, 0),
(80, 8, 2, 0),
(81, 8, 2, 0),
(82, 8, 2, 0),
(83, 8, 2, 0),
(84, 8, 2, 0),
(85, 8, 2, 0),
(86, 8, 2, 0),
(87, 6, 2, 0),
(88, 6, 2, 0),
(89, 6, 2, 0),
(90, 6, 2, 0),
(91, 6, 2, 0),
(92, 6, 2, 0),
(93, 6, 2, 0),
(94, 6, 2, 0),
(95, 6, 2, 0),
(96, 6, 2, 0),
(126, 6, 2, 0),
(125, 6, 2, 0),
(123, 6, 2, 0),
(124, 6, 2, 0),
(122, 6, 2, 0),
(121, 6, 2, 0),
(120, 6, 2, 0),
(119, 6, 2, 0),
(118, 6, 2, 0),
(117, 6, 2, 0),
(200, 8, 2, 0),
(199, 8, 2, 0),
(198, 8, 2, 0),
(197, 8, 2, 0),
(196, 8, 2, 0),
(112, 8, 2, 0),
(113, 8, 2, 0),
(114, 8, 2, 0),
(115, 6, 2, 0),
(116, 6, 2, 0),
(127, 6, 2, 0),
(128, 6, 2, 0),
(129, 6, 2, 0),
(130, 6, 2, 0),
(131, 6, 2, 0),
(132, 6, 2, 0),
(133, 6, 2, 0),
(134, 6, 2, 0),
(135, 8, 2, 0),
(136, 8, 2, 0),
(137, 8, 2, 0),
(138, 8, 2, 0),
(139, 8, 2, 0),
(140, 8, 2, 0),
(141, 8, 2, 0),
(142, 6, 2, 0),
(143, 6, 2, 0),
(144, 6, 2, 0),
(145, 6, 2, 0),
(146, 1, 8, 0),
(147, 2, 8, 0),
(148, 5, 8, 0),
(149, 5, 8, 0),
(150, 8, 2, 0),
(151, 8, 2, 0),
(152, 8, 2, 0),
(153, 8, 2, 0),
(154, 8, 2, 0),
(155, 8, 2, 0),
(156, 8, 2, 0),
(157, 8, 2, 0),
(158, 8, 2, 0),
(159, 8, 2, 0),
(160, 8, 2, 0),
(161, 8, 2, 0),
(162, 8, 2, 0),
(163, 8, 2, 0),
(164, 8, 2, 0),
(165, 8, 2, 0),
(166, 8, 2, 0),
(167, 8, 2, 0),
(168, 8, 2, 0),
(169, 8, 2, 0),
(170, 6, 2, 0),
(171, 6, 2, 0),
(172, 6, 2, 0),
(173, 6, 2, 0),
(174, 6, 2, 0),
(175, 6, 2, 0),
(176, 6, 2, 0),
(177, 6, 2, 0),
(178, 6, 2, 0),
(179, 6, 2, 0),
(180, 6, 2, 0),
(181, 6, 2, 0),
(182, 6, 2, 0),
(183, 6, 2, 0),
(184, 6, 2, 0),
(185, 6, 2, 0),
(186, 8, 2, 0),
(187, 8, 2, 0),
(188, 8, 2, 0),
(189, 8, 2, 0),
(190, 8, 2, 0),
(191, 8, 2, 0),
(192, 8, 2, 0),
(193, 8, 2, 0),
(194, 8, 2, 0),
(195, 8, 2, 0),
(201, 8, 2, 0),
(202, 8, 2, 0),
(203, 8, 2, 0),
(204, 8, 2, 0),
(205, 8, 2, 0),
(206, 5, 2, 0),
(207, 5, 2, 0),
(208, 8, 2, 0),
(209, 8, 2, 0),
(210, 8, 2, 0),
(211, 8, 2, 0),
(212, 8, 2, 0),
(213, 8, 2, 0),
(214, 8, 2, 0),
(215, 8, 2, 0),
(216, 8, 2, 0),
(217, 8, 2, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `budovy_typy`
--

DROP TABLE IF EXISTS `budovy_typy`;
CREATE TABLE IF NOT EXISTS `budovy_typy` (
  `id` int(11) NOT NULL DEFAULT '0',
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `cena` mediumint(9) NOT NULL DEFAULT '0',
  `staveni` int(11) NOT NULL DEFAULT '0',
  `penize` int(11) NOT NULL DEFAULT '0',
  `misto` int(11) NOT NULL DEFAULT '1',
  `prestiz` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `budovy_typy`
--

INSERT INTO `budovy_typy` (`id`, `nazev`, `cena`, `staveni`, `penize`, `misto`, `prestiz`) VALUES
(1, 'Centrala staje', 0, 0, 0, 1, 0),
(2, 'Ubikace', 4500, 3, -50, 1, 25),
(3, 'Sklad paliva', 4000, 4, -50, 1, 40),
(4, 'Bar', 3500, 3, 350, 1, 40),
(5, 'Obchod se suvenýry', 7000, 5, 500, 1, 50),
(6, 'Předváděcí okruh', 20000, 8, 1400, 2, 120),
(7, 'Velký sklad paliva', 8500, 6, -120, 2, 50),
(8, 'Kanceláře obchodníků', 10000, 6, -250, 1, 70);

-- --------------------------------------------------------

--
-- Struktura tabulky `casopis`
--

DROP TABLE IF EXISTS `casopis`;
CREATE TABLE IF NOT EXISTS `casopis` (
  `val1` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `val2` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `casopis`
--

INSERT INTO `casopis` (`val1`, `val2`) VALUES
('cislo', 1),
('movitost', 0),
('nakup', 243933555),
('veci', 15380),
('zavody', 0),
('sazka2', 10000000),
('sazka', 1706);

-- --------------------------------------------------------

--
-- Struktura tabulky `chladice`
--

DROP TABLE IF EXISTS `chladice`;
CREATE TABLE IF NOT EXISTS `chladice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(90) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vykon` float NOT NULL DEFAULT '0',
  `typ` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=40 ;

--
-- Vypisuji data pro tabulku `chladice`
--

INSERT INTO `chladice` (`id`, `nazev`, `vykon`, `typ`, `vydrz`, `podvozek`) VALUES
(1, 'AquaCool AQX', 35, 1, 150, 0),
(2, 'Liquid Master Celsius', 50, 1, 165, 0),
(3, 'AquaCool C-Tank', 70, 1, 175, 0),
(4, 'Liquid Master Ice Age II', 90, 1, 185, 0),
(5, 'Liquid Master Kelvin', 100, 1, 200, 0),
(6, 'AquaCool C-Tank 2', 110, 1, 210, 0),
(7, 'Liquid Master Ice Age III', 125, 1, 215, 0),
(8, 'AquaCool Re-Fresh', 140, 1, 225, 0),
(9, 'AquaCool XH2O', 160, 1, 235, 0),
(10, 'Liquid Master NCX 300', 180, 1, 255, 0),
(11, 'AquaCool ALUWinter', 190, 1, 265, 0),
(12, 'AeroFreezer X-Blade', 200, 1, 275, 0),
(13, 'Thermal Snip DuoBlade', 220, 1, 290, 0),
(14, 'AeroFreezer X-Blade 2', 235, 2, 310, 0),
(15, 'AeroFreezer Ventil5', 250, 2, 340, 0),
(16, 'Thermal Snip TripleBlade', 275, 2, 360, 0),
(17, 'Thermal Snip Turbolence', 290, 2, 385, 0),
(18, 'Thermal Snip QuatroBlade', 310, 2, 405, 0),
(19, 'AeroFreezer Arctic', 330, 2, 420, 0),
(20, 'AeroFreezer Zero', 345, 2, 450, 0),
(21, 'Thermal Snip Tornado', 360, 2, 480, 0),
(22, 'AeroFreezer Arctic 2', 380, 2, 505, 0),
(23, 'Thermal Snip Hurricane', 400, 2, 525, 0),
(24, 'Blizz 360 DEG', 420, 2, 545, 0),
(25, 'nGuard NitroCool', 435, 2, 580, 0),
(26, 'Nitro Stream N400', 450, 2, 595, 0),
(27, 'Blizz WinOrb', 470, 3, 605, 0),
(28, 'Blizz Total', 490, 3, 630, 0),
(29, 'Nitro Stream N3', 505, 3, 655, 0),
(30, 'nGuard NitroCool+ Ultra', 520, 3, 680, 0),
(31, 'Nitro Stream N500', 540, 3, 700, 0),
(32, 'nGuard ThermalBlast', 560, 3, 715, 0),
(33, 'Nitro Stream K-Nitrion', 580, 3, 735, 0),
(34, 'nGuard Absolute', 600, 3, 755, 0),
(35, 'Nitro Stream Winter Shield II', 620, 3, 770, 0),
(36, 'T-Consumer', 640, 3, 795, 0),
(37, 'T-Consumer XL Beta', 650, 3, 810, 0),
(38, 'T-Consumer XL', 660, 3, 830, 0),
(39, 'T-Consumer Titanic', 670, 3, 850, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `chladice_typy`
--

DROP TABLE IF EXISTS `chladice_typy`;
CREATE TABLE IF NOT EXISTS `chladice_typy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(90) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=5 ;

--
-- Vypisuji data pro tabulku `chladice_typy`
--

INSERT INTO `chladice_typy` (`id`, `nazev`) VALUES
(1, 'Vodní'),
(2, 'Vzdušné'),
(3, 'Dusíkové'),
(4, 'Pohlcovače tepla');

-- --------------------------------------------------------

--
-- Struktura tabulky `desky`
--

DROP TABLE IF EXISTS `desky`;
CREATE TABLE IF NOT EXISTS `desky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vaha` int(11) NOT NULL DEFAULT '0',
  `zdroj` int(11) NOT NULL DEFAULT '0',
  `ovladat` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=16 ;

--
-- Vypisuji data pro tabulku `desky`
--

INSERT INTO `desky` (`id`, `nazev`, `vaha`, `zdroj`, `ovladat`, `vydrz`, `podvozek`) VALUES
(1, 'Acumen', 30, 20, 40, 450, 3),
(2, 'Acumen+', 40, 50, 50, 530, 3),
(3, 'Impuls', 60, 90, 60, 590, 3),
(4, 'Nervix', 70, 130, 70, 640, 3),
(5, 'Vectorion', 80, 150, 80, 700, 3),
(6, 'Flash', 30, 20, 20, 350, 2),
(7, 'Reactinus', 45, 40, 30, 420, 2),
(8, 'Navigate+', 60, 80, 40, 480, 2),
(9, 'Hairpin', 80, 110, 50, 550, 2),
(10, 'Neuron', 90, 135, 60, 600, 2),
(11, 'Straight', 30, 20, 10, 190, 1),
(12, 'Control Ultra', 50, 35, 20, 240, 1),
(13, 'Reflexion', 70, 55, 27, 290, 1),
(14, 'RideControl', 85, 100, 34, 360, 1),
(15, 'Reflexion+', 100, 120, 42, 420, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `droidi`
--

DROP TABLE IF EXISTS `droidi`;
CREATE TABLE IF NOT EXISTS `droidi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(70) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `urychleni` int(11) DEFAULT NULL,
  `sleva` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=16 ;

--
-- Vypisuji data pro tabulku `droidi`
--

INSERT INTO `droidi` (`id`, `nazev`, `urychleni`, `sleva`, `vydrz`) VALUES
(1, 'NC-50', 5, 0, 320),
(2, 'Compakt', 0, 5, 320),
(3, 'Pro-rogo', 2, 10, 190),
(4, 'Psychapod', 13, -5, 420),
(5, 'NC-80', 20, 0, 450),
(6, 'Refection', 18, 2, 540),
(7, 'Compakt II', 4, 13, 380),
(8, 'iServe', 30, 0, 450),
(9, 'Repabot', 35, 2, 450),
(10, 'Corrector', -10, 20, 650),
(11, 'Mechawiz', 45, -5, 620),
(12, 'NC-420', 25, 10, 530),
(13, 'Techadroid', 40, 5, 690),
(14, 'C3PO', -10, -5, 200),
(15, 'R2-D2', 40, 2, 500);

-- --------------------------------------------------------

--
-- Struktura tabulky `drzaky`
--

DROP TABLE IF EXISTS `drzaky`;
CREATE TABLE IF NOT EXISTS `drzaky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(90) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `typ` int(11) NOT NULL DEFAULT '0',
  `zdroj` int(11) NOT NULL DEFAULT '0',
  `ochrana` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `chlazeni` float NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=33 ;

--
-- Vypisuji data pro tabulku `drzaky`
--

INSERT INTO `drzaky` (`id`, `nazev`, `typ`, `zdroj`, `ochrana`, `vydrz`, `chlazeni`, `podvozek`) VALUES
(1, 'SEN SARINO 25 kV', 1, 10, 5, 130, 5, 0),
(2, 'NARELES MASTODONT', 1, 14, 10, 140, 8, 0),
(3, 'SEN ZUVAVI', 1, 18, 15, 150, 11, 0),
(4, 'P&K ED 2 TRANSISTOR', 1, 23, 18, 160, 14, 0),
(5, 'SEN ELEMASTER 1', 1, 27, 22, 170, 17, 0),
(6, 'SEN ELEMASTER 2', 1, 30, 25, 180, 20, 0),
(7, 'NARELES TRANZISTOR 5', 1, 34, 29, 190, 23, 0),
(8, 'NARELES SYRINX', 1, 37, 32, 200, 26, 0),
(9, 'NARELES Ultra Conductor+', 1, 42, 35, 210, 29, 0),
(10, 'ION-MASTER 14', 2, 46, 39, 220, 32, 0),
(11, 'ION-MASTER 15', 2, 49, 42, 230, 35, 0),
(12, 'P&K ID1', 2, 53, 46, 240, 38, 0),
(13, 'UIL 6500', 2, 58, 49, 250, 41, 0),
(14, 'ION-MASTER 15E', 2, 62, 54, 260, 44, 0),
(15, 'UIL 4500 Ti SE', 2, 65, 57, 270, 47, 0),
(16, 'ION-MASTER 15EL', 2, 69, 60, 280, 50, 0),
(17, 'P&K ID2', 2, 73, 64, 290, 53, 0),
(18, 'ION-MASTER 16', 2, 78, 65, 300, 56, 0),
(19, 'ION-MASTER 16 META DX', 2, 82, 68, 310, 59, 0),
(20, 'UIL 6600 GT', 2, 86, 72, 320, 62, 0),
(21, 'P&K ION-FREE', 2, 90, 75, 330, 65, 0),
(22, 'P&K SAFION', 2, 94, 78, 340, 68, 0),
(23, 'OWT 120L', 4, 97, 81, 350, 71, 0),
(24, 'GUMA SARINO B2', 4, 101, 84, 360, 74, 0),
(25, 'GravStadt KOH-II-NOOR', 4, 104, 87, 370, 77, 0),
(26, 'GUMA MURPHY V8', 4, 108, 88, 380, 80, 0),
(27, 'OWT 105', 4, 112, 89, 390, 83, 0),
(28, 'GUMA GRAVLEV 4.2G', 4, 114, 91, 400, 86, 0),
(29, 'GUMA LEVIATHAN 8', 4, 117, 93, 410, 89, 0),
(30, 'GravStadt KOH-III-NOOR', 4, 118, 95, 420, 90, 0),
(31, 'OWT Embargo', 4, 119, 96, 430, 90, 0),
(32, 'GUMA Quadra Earth', 4, 120, 97, 440, 90, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `drzaky_typy`
--

DROP TABLE IF EXISTS `drzaky_typy`;
CREATE TABLE IF NOT EXISTS `drzaky_typy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(90) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `bezpeci` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `drzaky_typy`
--

INSERT INTO `drzaky_typy` (`id`, `nazev`, `bezpeci`) VALUES
(1, 'Elektrické', 0.2),
(2, 'Iontové', 0.5),
(3, 'Gravitonové', 0.9);

-- --------------------------------------------------------

--
-- Struktura tabulky `finance`
--

DROP TABLE IF EXISTS `finance`;
CREATE TABLE IF NOT EXISTS `finance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `penize` int(11) NOT NULL DEFAULT '0',
  `zmena` smallint(6) NOT NULL DEFAULT '0',
  `typ` int(11) NOT NULL DEFAULT '0',
  `cas` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=28534 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `finance_typy`
--

DROP TABLE IF EXISTS `finance_typy`;
CREATE TABLE IF NOT EXISTS `finance_typy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=43 ;

--
-- Vypisuji data pro tabulku `finance_typy`
--

INSERT INTO `finance_typy` (`id`, `nazev`) VALUES
(1, 'Startovní peníze'),
(2, 'Sociální dávky'),
(3, 'Zisk ze závodu'),
(4, 'Zisk ze založení závodu - diváci'),
(5, 'Zisk ze založení závodu - sázky'),
(6, 'Zisk ze založení závodu - vklady'),
(7, 'Výhra sázky'),
(8, 'Vrácení sázky'),
(9, 'Vrácení vstupného'),
(10, 'Prodej předmětu'),
(11, 'Sešrotování předmětu'),
(12, 'Prodej paliva'),
(13, 'Převedení ze stáje'),
(14, 'Půjčka'),
(15, 'Výběr z banky'),
(16, 'Závod na tvé trati'),
(17, 'Zrušení závodu'),
(18, 'Nákup předmětu'),
(19, 'Oprava předmětu'),
(20, 'Předání předmětu'),
(21, 'Nákup paliva'),
(22, 'Sázka'),
(23, 'Vstup do závodu'),
(24, 'Špión'),
(25, 'Založení stáje'),
(26, 'Převedení do stáje'),
(27, 'Splacení půjčky'),
(28, 'Bankovní vklad'),
(29, 'Založení závodu'),
(30, 'Vytvoření tratě'),
(31, 'Zásah admina'),
(32, 'Zrušení stáje'),
(33, 'Vstup do stáje'),
(34, 'Mzda ze stáje'),
(35, 'Údržba paliva'),
(36, 'Výdělek z brigády'),
(37, 'Opravářská registrace'),
(38, 'Oprávářská změna'),
(39, 'Opravářský poplatek'),
(40, 'Opravářská smlouva'),
(41, 'Licence na palivo'),
(42, 'Splnění questu');

-- --------------------------------------------------------

--
-- Struktura tabulky `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `msg` text COLLATE utf8_czech_ci NOT NULL,
  `cas` int(11) NOT NULL DEFAULT '0',
  `place` varchar(11) COLLATE utf8_czech_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `hlasovani`
--

DROP TABLE IF EXISTS `hlasovani`;
CREATE TABLE IF NOT EXISTS `hlasovani` (
  `login` int(11) NOT NULL DEFAULT '0',
  `anketa` int(11) NOT NULL DEFAULT '0',
  `odpoved` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Struktura tabulky `hraci`
--

DROP TABLE IF EXISTS `hraci`;
CREATE TABLE IF NOT EXISTS `hraci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `heslo` varchar(42) COLLATE utf8_czech_ci DEFAULT NULL,
  `irc_heslo` varchar(42) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `icq` varchar(11) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `IP` varchar(20) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `cas` int(11) NOT NULL DEFAULT '0',
  `start` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `forum` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT '0,0,0,0,0,0,0',
  `skin` int(11) NOT NULL DEFAULT '0',
  `posta_zavody` tinyint(4) NOT NULL DEFAULT '1',
  `posta_zavody2` tinyint(4) NOT NULL DEFAULT '1',
  `trate` text COLLATE utf8_czech_ci NOT NULL,
  `logged` tinyint(4) NOT NULL DEFAULT '0',
  `menu` text COLLATE utf8_czech_ci NOT NULL,
  `rychle_info` varchar(42) COLLATE utf8_czech_ci NOT NULL DEFAULT '11111111111',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `nastenka`
--

DROP TABLE IF EXISTS `nastenka`;
CREATE TABLE IF NOT EXISTS `nastenka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL,
  `titulek` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `obsah` text COLLATE utf8_czech_ci NOT NULL,
  `cas` int(11) NOT NULL,
  `sekce` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=146 ;

--
-- Vypisuji data pro tabulku `nastenka`
--

INSERT INTO `nastenka` (`id`, `login`, `titulek`, `obsah`, `cas`, `sekce`) VALUES
(1, 1, 'Nový GUI', 'Určitě sis všiml nových změn v ovládání hry. S tím bude nejspíš spojeno hodně nových chyb, takže pokud na nějakou narazíš nebo by tě třeba napadlo nějaké vylepšení, tak určitě piš na fórum.', 1251470223, 1),
(2, 1, 'Nové změny', 'Tento věk budou možná probíhat určité úpravy a změny (pokud tě zajímá jaké, tak mrkni na <a href="http://world.qsb.cz/">QSB World</a>) a tak radši sleduj <a href="forum.php?place=5">oznamovací fóru</a>, kde je vše stručně potřebné.', 1251470393, 1),
(3, 1, 'QSB Cup brzy!', 'QSB pohár začne tento věk opravdu brzy, takže se zakládáním a hledáním stáje neotálej a neodkládej to.', 1251470493, 1),
(10, 1, 'Start poháru', 'QSB Cup bude odstartován v pondělí, kdy se ve 23:00 odjede první závod. Závodit se bude denně a připojit se bude moct i během QSB Cupu.', 1252704037, 1),
(22, 1, 'Nová ostrá sezóna', 'V nové ostré sezóně, která začala <strong>3.11.</strong> se už pojede podle kalendáře v sekci Home. <strong>QSB Cup se samozřejmě pojede</strong>, takže neotálejte s hledáním stájí.<br />\r\nMomentálně se pracuje na <a href="http://world.qsb.cz/clanek/88/novy_system_zavodu" target="_blank">tomto konceptu</a>, který bude definitivně velmi zajímavý. Mezitím, co admin bude tvrdě dřít, si nerušeně užívejte ostrou sezónu a ať ten pohár stojí za to!', 1257282438, 1),
(13, 1, 'Nová feature', 'Pokud si odteď rozkliknete detail některé trati (např. <a href="http://qsb.cz/showTrat.php?id=54">téhle</a>), zobrazí se vám nové možnosti náhledu trati. Flashová verze bohužel postrádá některé úseky, takže zatím lze spustit pouze ty tratě, které obsahují již překreslené úseky.\r\n\r\nZatím se nejedná o finální grafickou verzi a některé úseky budou ještě předělávány.', 1253469964, 1),
(15, 1, 'QSB sraz hráčů', 'Admin by rád zorganizoval sraz hráčů QSB. Jednalo by se o jednodenní setkání v některé z pražských restaurací a pokud máš zájem se účastnit, napiš adminovi (Dr.Hadr, ID 1) do pošty seznam dnů, které by se ti hodily. Na výběr jsou pátky a soboty ve dnech:<br />\r\n<br />\r\n<strong>6.</strong> nebo <strong>7.11.</strong><br />\r\n<strong>20.</strong> nebo <strong>21.11.</strong><br />\r\n<strong>27.</strong> nebo <strong>28.11.</strong><br />\r\n<br />\r\nNapiš všechny dny, které ti vyhovují. ', 1254655746, 1),
(16, 1, 'Mezisezóna a nové změny', 'Máme tu další konec sezóny a chtěl bych pogratulovat stáji <span style="background-color: #3e4047">&nbsp;&nbsp;</span><span style="background-color: #b7de1d">&nbsp;&nbsp;</span><span style="background-color: #3e4047">&nbsp;&nbsp;</span> <strong>Bounty Hunter Racing Team</strong>, která drtivě zvítězila. Další pořadí vypadalo <a href="http://help.qsb.cz/doku.php?id=qsb:pohar_vysledky" target="_blank">následovně</a>.<br />Co by jste ale číst měli, jsou <a href="http://world.qsb.cz/clanek/87/zmeny_ve_hre_0909_1009" target="_blank">tyto změny</a> ve hře.', 1254921402, 1),
(87, 1, 'QSB sraz podruhé', 'Oficiální začátek srazu je <strong>20.11. v 16:45</strong> na náměstí <strong>I.P. Pavlova</strong> (před KFC, naproti McDonaldu), kde se potkáme a půjdem do regenta (pro ty, kdo netrefí). Zbytek, ať si dorazí, kdy chce. Místo je zarezervováno pro 15 lidí, snad to bude stačit.<br />\r\n<br />\r\n<strong style="color: #FFCC00">Místo:</strong> Restaurace <a href="http://uregenta.cz/">U regenta</a>\r\n<br />\r\n<br />\r\n<strong style="color: #FFCC00">Konec:</strong> až bude zas svítat.', 1289327430, 1),
(21, 1, 'QSB sraz hráčů', 'Sraz byl definitivně odsouhlasen a nastaven na <strong>20.11.</strong>. Sejdeme se <strong>v Praze</strong>, až Hannibal zamluví nějakou restauraci a sraz bude trvat přibližně <strong>od 18:00 až do haleluja</strong>.<br />\r\nDetaily a mapka se objeví na nástěnce a na oznamovacím fóru.<br /><br />\r\nZatím potvrzená účast:\r\n<ul>\r\n	<li><span style="common">Dr.Hadr</span></li>\r\n	<li><span style="common">Hannibal</span></li>\r\n	<li><span style="common">Kyssi</span></li>\r\n	<li><span style="common">awersion</span></li>\r\n	<li><span style="common">OndraSter</span></li>\r\n	<li><span style="common">Any Tah Weh</span></li>\r\n	<li><span style="common">Hamster</span></li>\r\n</ul>', 1257281905, 1),
(142, 5, '', '', 0, 2),
(141, 4, '', '', 0, 2),
(92, 1, 'Listopadová sezóna', '<strong class="extra">17.11.</strong> začala první z řady sezón o hodnotné ceny! Výherce QSB Cupu vyhraje hodnotnou cenu ve formě počítačové hry. Tuto sezónu se jede o originální hru <strong class="extra">F.E.A.R.</strong>!', 1290020659, 1),
(140, 3, '', '', 0, 2),
(106, 6, 'Novoroční sezóna', '<strong><span style="color: #CA0B0B">5.1.</span></strong> začala <span style="color: #00CC00">první sezóna roku 2011</span>. Do nového roku vstupujeme s velkou změnou - výhra ze závodu je ovlivněna obchodnickým skillem rasy závodníka až o +100%! Nicméně tuto sezónu se <strong>nejede o cenu</strong>. Závěr sezóny se chystá na <span style="color: #CA0B0B">3.2.</span><br />\r\n\r\n<br />\r\nV <span class="extra">listopadové sezóně</span> zvítězil v QSB cupu hráč <span style="color: #224AEA">Rook</span> a vyhrál hodnotnou cenu: hru <strong>F.E.A.R.</strong>', 1294269496, 1),
(137, 1, '', '', 0, 2),
(138, 2, '', '[B]Kayros_cz:[/B]\nTyp kluzáku:	[M]Sport[/M]\nMax. rychlost:[M]236km/h[/M]\nRychlost kluzáku:	[M]119%[/M]\nOvladatelnost:	[M]20%[/M]\nOdolnost:	[M]22%[/M]\nZrychlení:	[M]31%[/M]\n[R]Cena kluzáku:	72 060 Is[/R]\n\n\n[B]Worm:[/B]\nTyp kluzáku:	[M]Sport[/M]\nMax. rychlost:[M]217km/h[/M]\nRychlost kluzáku:[M]110%[/M]\nOvladatelnost:	[M]19%[/M]\nOdolnost:	[M]13%[/M]\nZrychlení:	[M]28%[/M]\n[R]Cena kluzáku:	68 660 Is[/R]\n\n[B]Apofizz[/B]\nTyp kluzáku:	[M]Combi[/M]\nMax. rychlost:	[M]181 km/h[/M]\nRychlost kluzáku:	 [M]95%[/M]\nOvladatelnost:	[M]37%[/M]\nOdolnost:	[M]27%[/M]\nZrychlení:	[M]16%[/M]\n[R]Cena kluzáku:	78 560 Is[/R]\n\n[B]Trogmar:[/B]\nPodovzek: [G]Ripper[/G]\nMotor: [G]Trasher[/G]', 0, 2),
(139, 1, 'QSB resurrection!', '<span style="color: #CA0B0B"><strong>20.10.2012</strong></span> Po dlouhé odmlce byly motory kluzáků opět zažehnuty! Jede se <span style="color: #00CC00">pohár</span>, jedou se <span style="color: #00CC00">závody</span>, žije <span style="color: #00CC00">forum</span>. Noví hráči jsou vítáni, staří též. Mnoho <span class="extra">I</span>ntergalaktických <span class="extra">s</span>huntů a vyhraných závodů přeje konzul Hamster.', 1351263472, 1),
(28, 1, 'Konec ostré sezóny', 'Máme tu další konec sezóny a chtěl bych pogratulovat stáji <span style="background-color: #575757">&nbsp;&nbsp;</span><span style="background-color: #9e9e9e">&nbsp;&nbsp;</span><span style="background-color: #ffffff">&nbsp;&nbsp;</span> <strong>Kuat Drive Yards Racing Division</strong>, která drtivě zvítězila. Další pořadí vypadalo <a href="http://help.qsb.cz/doku.php?id=qsb:pohar_vysledky" target="_blank">následovně</a>.<br />Nic dalšího nového ale pro vás nemám, protože musím makat na tý nový verzi přece :P', 1259872615, 1),
(143, 6, '', '[B]Vítejte na Arrakisu![/B]\n\n[SM4]\n\nFugam victoria nescit!', 0, 2),
(82, 1, 'QSB sraz', 'Určitě jste si na Facebooku nebo v mailu přečetli, že se chystá další QSB sraz.<br />\r\n<br />\r\nSraz bude v <strong>Praze</strong> v <strong>listopadu</strong>. <strong><a href="http://doodle.com/chm4eunwuvttwyh6" style="color: #CC0000">[Zde]</a></strong> se prosím napište, pokud se chcete účastnit a kdy se vám to hodí.<br />\r\n<br />\r\nLokalitu a čas vybereme později podle účasti <img src="./skin/img/smiles/1.gif" style="vertical-align: middle" height="20" />', 1287822785, 1),
(144, 7, '', '', 0, 2),
(83, 1, 'QSB o ceny!', 'QSB získalo skvělého sponzora - internetový obchod s PC/PS/XBOX hrami (brzy bude online na <strong><a href="http://www.fuseki.cz/">www.fuseki.cz</a></strong>) a výherci QSB Cupu budou získávat hodnotné ceny!<br />\r\n<br />\r\nV příští sezóně se exkluzivně pojede o originální hru <strong>F.E.A.R.</strong>!', 1287905737, 1),
(61, 1, 'Festival Fantazie', 'Protože se blíží <a href="http://festivalfantazie.cz">Festival Fantazie 2010</a>, kam jistě pojede i mnoho hráčů, chtěl bych tam uspořádat <strong>QSB sraz</strong>.<br />Kdo se tam objeví, ať napíše adminovi do pošty a přesnější informace rozešlu až pak.', 1275225406, 1),
(88, 1, 'Říjnová sezóna', 'Říjnovou sezónu vyhrála stáj <span style="font-size: 11px;"><span style="background-color: #159435">&nbsp;&nbsp;</span><span style="background-color: #ffdd00">&nbsp;&nbsp;</span><span style="background-color: #fa0505">&nbsp;&nbsp;</span></span> <strong>Rastafariani</strong> (konkrétně hráč <strong>Rastaman</strong>) a tímto jim oficálně gratuluji! Více informací o poháru naleznete <strong><a href="http://help.qsb.cz/doku.php?id=qsb:pohar_vysledky" class="extra">zde</a></strong>.\r\n<br />\r\n<br />\r\nPříští sezóna začíná v <strong>21:00, 17.11.</strong> a už půjde do tuhého.', 1289397585, 1),
(145, 8, '', '', 0, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `new_rasy`
--

DROP TABLE IF EXISTS `new_rasy`;
CREATE TABLE IF NOT EXISTS `new_rasy` (
  `login` int(11) NOT NULL DEFAULT '0',
  `rasa` int(11) NOT NULL DEFAULT '0',
  `kluzak` smallint(6) NOT NULL DEFAULT '4'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Struktura tabulky `novinky`
--

DROP TABLE IF EXISTS `novinky`;
CREATE TABLE IF NOT EXISTS `novinky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cas` int(11) NOT NULL DEFAULT '0',
  `novinka` text COLLATE utf8_czech_ci NOT NULL,
  `titulek` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=24 ;

--
-- Vypisuji data pro tabulku `novinky`
--

INSERT INTO `novinky` (`id`, `cas`, `novinka`, `titulek`) VALUES
(1, 1217412913, 'Tak! Hra je po dvou měsících úmornýho přepisování kompletní. Týden testování s Palmou by taky měl zabrat a bugy by měly vymizet. Očekávám jich pár, ale to je detail ;)', 'Restart'),
(2, 1217413102, 'Začala práce na nových předmětech (pomáhá opět Palma). Jedná se o změnu základních 45 motorů + přidá se dalších 60 navrch. Nové motory už zase budou využívat nová paliva a bude to nářez ;) K motorům se přidělají i chladiče, zdroje a ostatní předměty, aby i ten nejrychlejší kluzák šlapal jako hodinky ;) Takže je určitě na co se těšit.', 'Nové předměty'),
(3, 1217413185, 'Jelikož prošel každý script ve hře přepisem, tak očekávám hojně bugy a zároveň doufám, že to nebude tak horký. Jinak když objevíte nesrovnalost, věc ve složených závorkách nebo prostě chybu, tak do pošty mě a nebo na chybové fórum.', 'Hlášení bugů'),
(4, 1218455544, 'Protože rasy nebyly důstojné a byly spíše pro srandu, rozhodli jsme se je změnit. Na nových rasách se největším dílem podílel hráč Abraxas, takže mu patří můj dík. Doufám, že se vám nové rasy budou líbit. Více se o nových rasách dočtete v QSB Worldu', 'Nové rasy'),
(5, 1220202545, 'Hra byla restartována a konečně začíná dlouho očekávaná ostrá sezóna!', 'Restart'),
(6, 1231021075, 'Další sezóna je za námi a ikdyž pohár vyšel zrovna na svátky a byla nižší účast, nebyla to sezóna špatná. Nyní proběhl restart a byla spuštěna mezisezóna, po níž bude začátkem druhého lednového týdne spuštěna ostrá sezóna.', 'Konec sezóny'),
(7, 1231876597, 'Máme tu další sezónu a vážně uvažuju, že tyhle novinky zrušim, protože jsou vo ničem. Jsem línej sem psát cokoli kromě restartů :))\r\n\r\nA proto teď udělám výjimku, protože jsem dokonce víc línej ty novinky odebrat.\r\n<a href="http://world.qsb.cz/clanek/49/zmeny_posledni_sezony"><strong class="extra">Tady</strong></a> jsou změny za poslední mezisezónu. Uff! ', 'Nová sezóna'),
(8, 1235680578, 'Skončila nám další jezdecká sezóna a další začne zhruba za 2 týdny. Máme před sebou hodně úprav, co se samotnéh závodění týče a tak se to musí pořádně otestovat!', 'Restart a mezisezóna'),
(9, 1235753170, 'Server přetel.cz poskytl přístřeší pro QSBota a ten teď poběží snad už 24/7 na #qsb.', 'QSBot na Přetelu'),
(10, 1238352878, 'Máme tu další ostrou sezónu a s ní přibyde i pár změn. Sezóna bude taková experimentální, protože pohár bude startovat opravdu brzy, bude možné se připojit v průběhu, závodit se bude každý třetí den a půjde tedy také o rychlost, s jakou se probojujete k založení stáje a přihlásíte své závodníky. Uvidíme, jak se to osvědčí..', 'Nová ostrá sezóna'),
(11, 1241377507, 'Pohár skončil a s ním i sezóna. V mezisezóně budeme testovat podporu nováčků přes pěstounské stáje. Více se dozvíte v úvodní poště, kterou doporučuju číst ;)', 'Restart a mezisezóna'),
(12, 1243790195, 'QSB bylo recenzováno v jednom z nejprestižnějších herních deníků v ČR!\r\n\r\nVíce informací na <a href="http://world.qsb.cz/clanek/74/recenze_na_freehrycz" class="extra"><strong class="extra">QSB Worldu</strong></a> nebo <a href="http://flashfun.doupe.cz/recenze/quadra-speed-boosters-star-wars-zavody/"><strong class="extra">zde přímo v recenzi</strong></a>.', 'Recenze na FreeHry.cz'),
(13, 1244659692, 'Ve středu 10.6. nám začala nová sezóna a opět zkusíme pohár odstartovat co nejdřív. Stáje vyučující nováčky byly pro ostrou sezónu opět zrušeny, ale během další mezisezóny bych je opět rád zavedl. Změny, které proběhly za poslední mezisezónu jsou na <strong><a href="http://world.qsb.cz/clanek/70/zmeny_ve_hre_0309_0509" target="_blank" class="extra">worldu</a></strong> a nebylo jich málo, takže čtěte.', 'Nová sezóna'),
(14, 1249324921, 'Máme tu další konec sezóny. Jak dopadl pohár si určitě najdete v <a href="http://help.qsb.cz/doku.php?id=qsb:pohar_vysledky">helpu</a> a více o nadcházející mezisezóně se dočtete výše. Dneska je to stručný, ale je to tak :)', 'Restart a mezisezóna'),
(15, 1251826624, 'Tak jako každý rok jsem zas přepsal celou hru. Tentokrát jsem se soustředil na GUI, na rychlost hraní a na zjednodušení a zpříjemnění proklikávání se hrou. Přibylo pár opravdu užitečných věcí a pak desítky menších úprav, aby hra dostala jakousi úroveň.\r\n\r\nCíle do budoucna bude zlepšení grafiky a přidání obrázků a na QSB Worldu už se nám také rýsuje pár zajímavých konceptů, takže práce bude zas nad hlavu :)\r\n\r\nS restartem přišla také nová ostrá sezóna, takže hodně štěstí! ', 'Restart a nový GUI'),
(16, 1254921285, 'Máme tu další konec sezóny. Jak dopadl pohár si určitě najdete v helpu a více o nadcházející mezisezóně se dočtete výše. Co by jste ale číst měli, jsou <strong class="extra"><a href="http://world.qsb.cz/clanek/87/zmeny_ve_hre_0909_1009" target="_blank">tyto změny</a></strong> ve hře.', 'Mezisezóna a nové změny'),
(17, 1257279158, 'Vážení a drazí spoluobčané,\r\nsešli jsme se zde, dne 3.11.2009 ve (čas restartu) hodin, abychom společně uctili památku staré sezóny QSB. Odešla čekaně a nenáhle podle plánu. Snad každého zpráva o jejím ukončení zarmoutila. \r\nPřesto ale pevně doufám, že společně pozvedneme hlavu k odkazu který nám tu zanechala a sice k odkazu zábavy.\r\nNechme slzu kanout, přátelé, a usmějme se, neboť stará sezóna QSB by si to tak přála.\r\nNadechněmě se a uvítejme zde tedy novou a pro všechny snad úspěšnou sezónu QSB, která ssebou přináší mnoho změn snad k lepšímu.\r\n\r\n- Kyssi', 'A další ostrá sezóna'),
(18, 1263041995, 'V sobotu 9.1. byl nahozen nový systém a nová verze hry. Momentálně tedy probíhá mezisezóna, jejíž účel je otestovat a doladit tuto verzi. Testování by mělo trvat zhruba týden až dva a pak přijde ostrá sezóna. Byl bych tedy rád, když by většina hráčů spíše závodila než obchodovala, ať je testování co nejrozsáhlejší.', 'Nový systém'),
(19, 1287906272, 'QSB získalo skvělého sponzora - internetový obchod s PC/PS/XBOX hrami (brzy bude online na <strong><a href="http://www.fuseki.cz/">www.fuseki.cz</a></strong>) a výherci QSB Cupu budou získávat hodnotné ceny!\r\n\r\nV příští sezóně se exkluzivně pojede o originální hru <strong class="extra">F.E.A.R.</strong>!', 'QSB o hodnotné ceny!'),
(20, 1287906387, 'Určitě jste si na Facebooku nebo v mailu přečetli, že se chystá další QSB sraz.\r\n\r\nSraz bude v <strong>Praze</strong> v <strong>listopadu</strong>. <strong><a href="http://doodle.com/chm4eunwuvttwyh6" style="color: #CC0000">[Zde]</a></strong> se prosím napište, pokud se chcete účastnit a kdy se vám to hodí.\r\n\r\nLokalitu a čas vybereme později podle účasti <img src="./skin/img/smiles/1.gif" style="vertical-align: middle" height="20" />', 'QSB sraz'),
(21, 1289328244, 'Oficiální začátek srazu je <strong class="extra">20.11. v 16:45</strong> na náměstí <strong class="extra">I.P. Pavlova</strong> (před KFC, naproti McDonaldu), kde se potkáme a půjdem do regenta (pro ty, kdo netrefí). Zbytek, ať si dorazí, kdy chce. Místo je zarezervováno pro 15 lidí, snad to bude stačit.\r\n\r\n<strong style="color: #FFCC00">Místo:</strong> Restaurace <a href="http://uregenta.cz/">U regenta</a>\r\n\r\n<strong style="color: #FFCC00">Konec:</strong> až bude zas svítat.', 'QSB sraz podruhé'),
(22, 1290020009, 'QSB bylo restartováno a začala první z řady sezón o hodnotné ceny! Výherce QSB Cupu vyhraje hodnotnou cenu ve formě počítačové hry. Tuto sezónu se jede o originální hru <strong class="extra">F.E.A.R.</strong>!\r\n\r\nSponzorem dodávajícím tyto ceny je nový internetový obchod <a href="http://fuseki.cz/" target="_blank"><strong class="extra">Fuseki.cz</strong></a>, který prodává hry pro PC/Xbox 360/PlayStation 3/Wii za bezkonkurenční ceny.', 'Restart a ostrá sezóna'),
(23, 1351248936, '<span style="color: #CA0B0B"><strong>20.10.2012</strong></span> Po dlouhé odmlce byly motory kluzáků opět zažehnuty! Jede se <span style="color: #00CC00">pohár</span>, jedou se <span style="color: #00CC00">závody</span>, žije <span style="color: #00CC00">forum</span>. Noví hráči jsou vítáni, staří též. Mnoho <span class="extra">I</span>ntergalaktických <span class="extra">s</span>huntů a vyhraných závodů přeje konzul Hamster.', 'JEDEME !!');

-- --------------------------------------------------------

--
-- Struktura tabulky `obchodnici`
--

DROP TABLE IF EXISTS `obchodnici`;
CREATE TABLE IF NOT EXISTS `obchodnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(40) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `rasa` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=12 ;

--
-- Vypisuji data pro tabulku `obchodnici`
--

INSERT INTO `obchodnici` (`id`, `nazev`, `rasa`) VALUES
(1, 'Zk-raat - Pal. desky', 12),
(2, 'Drt-tu Kaath - Podvozky', 10),
(3, 'Mungo Tol - Brzdy', 2),
(4, 'Jubatfan - Motory', 7),
(5, 'Shahdeel - Chladiče', 2),
(6, 'Fuhjin - Zdroje', 9),
(7, 'Wuntar - Příd. motory', 9),
(8, 'Flatter - Energodržáky', 8),
(9, 'Stompat - Pancéřování', 12),
(10, 'Tui-ho Bada - Suspenzory', 10),
(11, 'Motha-Vender - Opravní droidi', 9);

-- --------------------------------------------------------

--
-- Struktura tabulky `opravari`
--

DROP TABLE IF EXISTS `opravari`;
CREATE TABLE IF NOT EXISTS `opravari` (
  `login` int(11) NOT NULL,
  `procenta` int(11) NOT NULL,
  `minimum` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `p_motory`
--

DROP TABLE IF EXISTS `p_motory`;
CREATE TABLE IF NOT EXISTS `p_motory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `zdroj` int(11) NOT NULL DEFAULT '0',
  `chlazeni` int(11) NOT NULL DEFAULT '0',
  `vaha` int(11) NOT NULL DEFAULT '0',
  `zrychleni` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=21 ;

--
-- Vypisuji data pro tabulku `p_motory`
--

INSERT INTO `p_motory` (`id`, `nazev`, `zdroj`, `chlazeni`, `vaha`, `zrychleni`, `vydrz`, `podvozek`) VALUES
(1, 'Jumper', 40, 40, 40, 10, 210, 0),
(2, 'Katalyzator', 50, 48, 45, 15, 233, 0),
(3, 'Elevated', 60, 56, 49, 21, 256, 0),
(4, 'Over-clocker', 65, 60, 54, 26, 279, 0),
(5, 'Accelerator', 75, 66, 58, 30, 302, 0),
(6, 'Motion-Booster', 85, 72, 62, 34, 325, 0),
(7, 'G-breaker', 95, 78, 66, 38, 348, 0),
(8, 'Tachycardius', 100, 84, 70, 42, 371, 0),
(9, 'Redoubler', 105, 90, 74, 46, 394, 0),
(10, 'Motion-Booster II', 115, 96, 78, 50, 417, 0),
(11, 'Fastender', 120, 102, 82, 54, 440, 0),
(12, 'Impuls', 125, 108, 86, 58, 463, 0),
(13, 'Accelerator Plus', 130, 114, 90, 62, 486, 0),
(14, 'Phoenix', 135, 120, 94, 66, 509, 0),
(15, 'G-Plus', 140, 126, 98, 70, 532, 0),
(16, 'Impuls Ultra', 144, 132, 102, 74, 555, 0),
(17, 'Highacc', 148, 138, 106, 78, 578, 0),
(18, 'Speed-Haxor', 152, 144, 110, 82, 601, 0),
(19, 'Stream', 149, 148, 114, 86, 624, 0),
(20, 'Duality jump', 150, 150, 118, 90, 650, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `paliva`
--

DROP TABLE IF EXISTS `paliva`;
CREATE TABLE IF NOT EXISTS `paliva` (
  `id` int(11) NOT NULL DEFAULT '0',
  `nazev` varchar(40) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `popis` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0;

--
-- Vypisuji data pro tabulku `paliva`
--

INSERT INTO `paliva` (`id`, `nazev`, `popis`) VALUES
(1, 'Baterie', 'Baterie jsou důležitým zdrojem elektrické energie zejmnéna pro kluzáky vybavené\r\nelektrickými, magnetickýmy nebo iontovými motory. Dělí se na niklové baterie,\r\nnanobaterie a biobaterie. Niklové jsou vcelku objemné, ale kapacitně  dostačující.\r\nNanobaterie už jsou pokročilejší, ale hlavně miniaturní. Biobaterie vyrabí energii\r\npomocí odrůd bakteríí, ale kapacitně mají největší výdrž. Až několik teraampérhodin!'),
(2, 'Rašelina', 'Spalovací motory poháněné rašelinou jsou vcelku užitečné, a ačkoli v porovnání s\r\njinými druhy spalovacích motorů jsou jasně nejslabší, nejmodernější modely\r\ntěchto motorů nedají ostatním spalovacím motorům šanci. Je to způsobeno malými\r\ntepelnými ztrátámi a kvalitnímu vymáčknutí energie z rašeliny. Rašelinové palivo\r\nje také velmi levné a dobře dostupné. Motory se tedy ze spotřebové stránky vyplatí.'),
(3, 'Nafta', 'Naftové motory jsou už od dvácátého století jedny z nejvyužívanějších, díky\r\njednoduché konstrukci. Bohužel jsou všechna nová naleziště nafty rychlými\r\ntempy vypotřebovávány a tak cena tohoto ropného produktu velmi kolísá. I přesto\r\njsou naftové motory obstojnými soupeři pro motory ostatní.'),
(4, 'Benzín', 'Motory poháněné tímto velmi opojným materiálem jsou výkonostně ještě o laťku\r\nvýš než naftové a rašelinové. Cenově jsou ale díky stále se vyvýjející technologii\r\nzpracování benzínu nejdražší. Ovšem spotřeba benzínu je menší než-li u nafty a\r\nvýkonostně také nepatří mezi úplné nováčky a určitě není na škodu, když váš kluzák\r\npohání právě tento typ motoru, ať už to je motor benzínový anebo motor, teď se podržte, \r\nraketový! Ano, i tento druh motoru je poháněn benzínem, ikdyž jen jeho velmi čistou variantou.'),
(5, 'Vodík', 'Vodík je ve vesmíru nejrozšířenější prvek a tak je jasné, že jako palivo bude velmi levný. \r\nCo se ovšem prodraží jsou už vodíkové motory, které musí být odolné proti vysokým teplotám, \r\npři nichž se vodík v motorech zpracovává. Vodíkové motory jsou ale málo závádové a nabízí\r\ndobrý výkon, za cenu velké spotřeby levného vodíku.'),
(6, 'Kadmium', 'Prvek s valenčními elektrony v d-sféře (pooh ví, co to je), pohánějící kadmiové a nakhadanové \r\nmotory je karcinogenní a tudíž i docela nebezpečný. Motory ho tedy musí umět odstínit a už to \r\nje nákladné. Kadmium se prodává jako bílý až stříbřitý kov a je ho velmi málo. Svou vysokou cenu \r\novšem oplácí malou spotřebou a motory z něj dokáží vymáčknout skoro každičký joul energie.'),
(7, 'Uran', 'Uran je mnohem radioaktivnější, ale levnější než kadmium, bohužel jeho spotřeba na kilometr je \r\nvětší. Jinak je to pořád ten stejný izotop, jaký znáte z jaderných elektráren...'),
(8, 'Antihmota', 'Jedno z nejdražších paliv bylo dlouho nedosažitelné. Zápornou gravitaci využívají gravitonové \r\nmotory a odpuzují se od země. Positronové motory do něj zas vystřelují koho jiného než positrony \r\na tím ho neuvěřitelně zahřívají, pokud se tomu tak dá říkat, protože podle všeho nemá antihmota \r\nteplotu. A antihmotové motory na něj prostě jezdí ;). Malá krabička tohoto drahého čehosi zas \r\nvystačí na mnoho závodů.'),
(9, 'Reflektory', 'Reflektory jsou vlastně extrémně silné osvětlovače, protože fotonové a pulsní motory potřebují \r\nvelmi silné proudy fotonů. Vybavením vašeho miláčka fotonovými motory určitě neprohloupíte, \r\nprotože jde asi o nejrychlejší motory vůbec.');

-- --------------------------------------------------------

--
-- Struktura tabulky `paliva_ceny`
--

DROP TABLE IF EXISTS `paliva_ceny`;
CREATE TABLE IF NOT EXISTS `paliva_ceny` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(90) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `palivo` int(11) NOT NULL DEFAULT '0',
  `cena` float NOT NULL DEFAULT '0',
  `kapacita` float NOT NULL DEFAULT '0',
  `stala_cena` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=27 ;

--
-- Vypisuji data pro tabulku `paliva_ceny`
--

INSERT INTO `paliva_ceny` (`id`, `nazev`, `palivo`, `cena`, `kapacita`, `stala_cena`) VALUES
(1, 'Niklové baterie', 1, 35, 6, 35),
(2, 'Nanobaterie', 1, 78, 3, 78),
(3, 'Biobaterie', 1, 390, 1, 390),
(4, 'Rašelina', 2, 10.2, 10, 10),
(5, 'Čistá Rašelina', 2, 15.3, 9, 15),
(6, 'Znečištěná nafta', 3, 17.51, 13, 17),
(7, 'Nafta', 3, 22.66, 13, 22),
(8, 'Čistá nafta', 3, 26.78, 13, 26),
(9, 'Znečištěný benzín', 4, 18.24, 17, 19),
(10, 'Benzín', 4, 24.96, 17, 26),
(11, 'Čistý Benzín', 4, 29.76, 16, 31),
(12, 'Vodík', 5, 35.34, 15, 38),
(13, 'Čistý vodík', 5, 39.06, 17, 42),
(14, 'Kadmium', 6, 47, 16, 50),
(20, 'Uran 238', 7, 56.26, 15, 58),
(21, 'Plutonium', 7, 64.26, 15, 63),
(22, 'Antihmota', 8, 70.7, 24, 70),
(25, 'Helionové reflektory', 9, 3400, 1, 3400);

-- --------------------------------------------------------

--
-- Struktura tabulky `paliva_sklad`
--

DROP TABLE IF EXISTS `paliva_sklad`;
CREATE TABLE IF NOT EXISTS `paliva_sklad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `palivo` int(11) NOT NULL DEFAULT '0',
  `mnozstvi` int(11) NOT NULL DEFAULT '0',
  `staj` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `pancerovani`
--

DROP TABLE IF EXISTS `pancerovani`;
CREATE TABLE IF NOT EXISTS `pancerovani` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vaha` int(11) NOT NULL DEFAULT '0',
  `ochrana` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=21 ;

--
-- Vypisuji data pro tabulku `pancerovani`
--

INSERT INTO `pancerovani` (`id`, `nazev`, `vaha`, `ochrana`, `vydrz`, `podvozek`) VALUES
(1, 'Apron', 70, 10, 350, 0),
(2, 'Pooma', 85, 15, 380, 0),
(3, 'Panther', 88, 19, 410, 0),
(4, 'Grizzly', 92, 24, 430, 0),
(5, 'Oliphaunt', 96, 28, 450, 0),
(6, 'Conservator', 100, 32, 480, 0),
(7, 'Guardian', 104, 36, 500, 0),
(8, 'Shielder', 108, 40, 525, 0),
(9, 'Defender', 112, 44, 550, 0),
(10, 'Ensurion', 115, 48, 580, 0),
(11, 'Shelter', 117, 52, 600, 0),
(12, 'Protector', 120, 54, 625, 0),
(13, 'Guardian EN', 125, 55, 650, 0),
(14, 'Conservator+', 130, 58, 680, 0),
(15, 'Immunitor', 135, 62, 700, 0),
(16, 'Scutum', 140, 66, 730, 0),
(17, 'Protector+', 150, 71, 760, 0),
(18, 'Munimen', 160, 76, 790, 0),
(19, 'Fylaxis', 170, 80, 820, 0),
(20, 'Patron', 180, 90, 890, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `podvozky`
--

DROP TABLE IF EXISTS `podvozky`;
CREATE TABLE IF NOT EXISTS `podvozky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(90) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `typ` int(11) NOT NULL DEFAULT '0',
  `vaha` int(11) NOT NULL DEFAULT '0',
  `nosnost` int(11) NOT NULL DEFAULT '0',
  `ovladat` int(11) NOT NULL DEFAULT '0',
  `zrychleni` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=31 ;

--
-- Vypisuji data pro tabulku `podvozky`
--

INSERT INTO `podvozky` (`id`, `nazev`, `typ`, `vaha`, `nosnost`, `ovladat`, `zrychleni`, `vydrz`) VALUES
(1, 'Swallow', 1, 30, 75, 20, 42, 290),
(2, 'Venom', 1, 35, 100, 23, 45, 325),
(3, 'Phantom', 1, 45, 120, 25, 53, 350),
(4, 'Gonzales', 1, 52, 140, 28, 58, 385),
(5, 'Smudge', 1, 68, 170, 36, 69, 420),
(6, 'Sioux', 1, 60, 190, 42, 62, 430),
(7, 'Arrow', 1, 80, 210, 48, 72, 455),
(8, 'Tomahawk', 1, 75, 230, 55, 72, 510),
(9, 'Athlon', 1, 90, 260, 69, 78, 515),
(10, 'Dart', 1, 95, 290, 64, 85, 520),
(11, 'Vertigo', 2, 60, 110, 34, 26, 450),
(12, 'Eagle', 2, 72, 140, 35, 32, 480),
(13, 'WerWolf', 2, 85, 170, 42, 35, 510),
(14, 'Havoc', 2, 90, 200, 56, 36, 520),
(15, 'Ripper', 2, 100, 230, 60, 40, 530),
(16, 'Raven', 2, 108, 260, 62, 42, 570),
(17, 'Mustang', 2, 112, 295, 68, 49, 580),
(18, 'Tame', 2, 115, 320, 72, 55, 605),
(19, 'Wraith', 2, 115, 340, 78, 68, 635),
(20, 'Redeemer', 2, 120, 360, 86, 72, 680),
(21, 'Infidian', 3, 70, 150, 65, 15, 650),
(22, 'Atlantis', 3, 82, 175, 67, 17, 680),
(23, 'Panther', 3, 85, 200, 70, 22, 730),
(24, 'Buldozer', 3, 90, 230, 78, 20, 770),
(25, 'Mamoth', 3, 110, 260, 82, 25, 810),
(26, 'Dino', 3, 108, 290, 79, 30, 870),
(27, 'Hammer', 3, 118, 320, 82, 35, 940),
(28, 'Malcom', 3, 125, 350, 88, 40, 940),
(29, 'Terrorus', 3, 135, 380, 93, 45, 870),
(30, 'Maglev', 3, 145, 410, 96, 49, 1000);

-- --------------------------------------------------------

--
-- Struktura tabulky `podvozky_typy`
--

DROP TABLE IF EXISTS `podvozky_typy`;
CREATE TABLE IF NOT EXISTS `podvozky_typy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typ` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `podvozky_typy`
--

INSERT INTO `podvozky_typy` (`id`, `typ`) VALUES
(1, 'Sport'),
(2, 'Combi'),
(3, 'Wrecker');

-- --------------------------------------------------------

--
-- Struktura tabulky `pohar`
--

DROP TABLE IF EXISTS `pohar`;
CREATE TABLE IF NOT EXISTS `pohar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `staj` int(11) NOT NULL DEFAULT '0',
  `zavody` int(11) NOT NULL DEFAULT '0',
  `body` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `posta`
--

DROP TABLE IF EXISTS `posta`;
CREATE TABLE IF NOT EXISTS `posta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kdo` int(11) NOT NULL DEFAULT '0',
  `komu` int(11) NOT NULL DEFAULT '0',
  `msg` text COLLATE utf8_czech_ci NOT NULL,
  `cas` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `postavy`
--

DROP TABLE IF EXISTS `postavy`;
CREATE TABLE IF NOT EXISTS `postavy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `rasa` int(11) NOT NULL DEFAULT '0',
  `penize` float NOT NULL DEFAULT '0',
  `planeta` int(11) NOT NULL DEFAULT '0',
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `zavody` int(11) NOT NULL DEFAULT '0',
  `prvni` int(11) DEFAULT '0',
  `druhy` int(11) DEFAULT '0',
  `treti` int(11) DEFAULT '0',
  `prestiz` int(11) NOT NULL DEFAULT '1000',
  `vyloha` tinyint(4) NOT NULL DEFAULT '1',
  `sklad` int(11) NOT NULL DEFAULT '300',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `pujcky`
--

DROP TABLE IF EXISTS `pujcky`;
CREATE TABLE IF NOT EXISTS `pujcky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banka` int(11) NOT NULL DEFAULT '0',
  `hrac` int(11) NOT NULL DEFAULT '0',
  `ir` double NOT NULL DEFAULT '0',
  `splatnost` int(11) NOT NULL DEFAULT '0',
  `vyse` int(11) NOT NULL DEFAULT '0',
  `typ` char(2) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `questy`
--

DROP TABLE IF EXISTS `questy`;
CREATE TABLE IF NOT EXISTS `questy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(150) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `sloupec` varchar(150) COLLATE utf8_czech_ci DEFAULT NULL,
  `max` int(11) NOT NULL DEFAULT '0',
  `typ` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=99 ;

--
-- Vypisuji data pro tabulku `questy`
--

INSERT INTO `questy` (`id`, `nazev`, `popis`, `sloupec`, `max`, `typ`) VALUES
(1, 'Training', 'Odjeď 20 závodů', 'zavody', 20, 0),
(2, 'Condition driving', 'Odjeď 50 závodů', 'zavody', 50, 0),
(3, 'Le chauffeur', 'Odjeď 150 závodů', 'zavody', 150, 0),
(4, 'World traveller', 'Odjeď 400 závodů', 'zavody', 400, 0),
(5, 'Been there', 'Odjeď 5 000 traťových úseku', 'useky', 5000, 0),
(6, 'Cruel world', 'Obdrž celkově 5 000 dmg', 'total_skody', 5000, 0),
(7, 'Meat grinder', 'Obdrž celkově 15 000 dmg', 'total_skody', 15000, 0),
(8, 'Constant suffering', 'Obdrž celkově 50 000 dmg', 'total_skody', 50000, 0),
(9, 'Natural agression', 'Způsob celkově 5 000 dmg', 'total_dmg', 5000, 0),
(10, 'Vandalism', 'Způsob celkově 15 000 dmg', 'total_dmg', 15000, 0),
(11, 'Villain candidate', 'Způsob celkově 30 000 dmg', 'total_dmg', 30000, 0),
(12, 'Nice start', 'Vyhraj 20 závodů', 'vitezstvi', 20, 0),
(13, 'Career growth', 'Vyhraj 50 závodů', 'vitezstvi', 50, 0),
(14, 'Anniversary', 'Vyhraj 100 závodů', 'vitezstvi', 100, 0),
(15, 'Fair play', 'Vyvolej celkově 200 soubojů', 'total_vyvolane', 200, 0),
(16, 'Respect', 'Dojeď závod a nebuď ani jednou atakován soupeřem', '', 0, 0),
(17, 'Catch me if you can', 'Buď po celý závod na prvním místě', '', 0, 0),
(18, 'Never give up', 'Probojuj se v závodě se 4 a více závodníky z posledního místa na první', '', 0, 0),
(19, 'Amundsen', 'Dojeď jako jediný v závodě se 3 a více závodníky', '', 0, 0),
(20, 'Mosquito', 'Vyvolej jeden souboj a dojeď závod', '', 0, 0),
(21, 'Dirty drive', 'Vyvolej během 1 závodu 2 souboje a závod dokonči', '', 0, 0),
(22, 'Mr. Proper', 'Vyvolej během 1 závodu 4 a více soubojů a závod dokonči', '', 0, 0),
(23, 'Ghost rider', 'Dojeď závod bez účasti v jediném souboji', '', 0, 0),
(24, 'Coincidence', 'Dostaň se během 1 závodu do 3 a více soubojů, které se nevyvolal ty', '', 0, 0),
(25, 'Fate', 'Dostaň se během 1 závodu do 5 a více soubojů, které se nevyvolal ty', '', 0, 0),
(26, 'Like a wind', 'Vyhni se v 1 závodě 3 útočícím soupeřům', '', 0, 0),
(27, 'Matrix', 'Vyhni se v 1 závodě 5 útočícím soupeřům', '', 0, 0),
(28, 'Art of motion', 'Vyhni se celkově 30 útočícím soupeřům', 'total_uhyby', 30, 0),
(29, 'Pwnage', 'Atakováním soupeře se dostaň na první místo', '', 0, 0),
(30, 'Meeting party', 'Dostaň se do souboje s každým závodníkem v závodě se 4 a více soupeři', '', 0, 0),
(31, 'Kamikaze', 'Atakováním soupeře vás oba vyřaď ze závodu', '', 0, 0),
(32, 'Black widow', 'Během závodu vyvolej pouze jeden souboj, který bude končit vyřazením soupeře', '', 0, 0),
(33, 'Sniper', 'Vyřaď soupeře ze závodu tebou vyvolaným soubojem', '', 0, 0),
(34, 'Martial arts', 'Vyřaď 2 soupeře ze závodu tebou vyvolaným soubojem', '', 0, 0),
(35, 'Black belt', 'Vyřaď celkově ze závodů 20 soupeřů', 'vyrazeni', 20, 0),
(36, 'Defensive mechanism', 'Vyřaď soupeře ze závodu tebou nevyvolaným soubojem', '', 0, 0),
(37, 'Mostly harmless', 'Při tebou vyvolaném souboji způsob 100 dmg', '', 0, 0),
(38, 'Knock knock', 'Způsob během souboje minimálně 200 dmg', '', 0, 0),
(39, 'Planned assault', 'Způsob během 2 soubojů minimálně 300 dmg jednomu a tomu samému hráči', '', 0, 0),
(40, 'Shikana', 'Zaútoč během 1 závodu 3 a vícekrát na jednoho a toho samého hráče', '', 0, 0),
(41, 'Survival', 'Obdrž během 1 závodu alespoň 500 dmg a dokonči závod', '', 0, 0),
(42, 'Buldozer', 'Během nárazu do trati obdrž alespoň 200 dmg a dokonči závod', '', 0, 0),
(43, 'Bad habits', 'Vyřaď celkově ze závodů 30 soupeřů', 'vyrazeni', 30, 0),
(44, 'Black horse', 'Vyhraj jinému hráči sázku vyhráním závodu', '', 0, 0),
(45, 'Known as looser', 'Vyhraj jinému hráči sázku nedojetím závodu', '', 0, 0),
(46, 'Fast marketing', 'Založ první stáj v sezóně', '', 0, 2),
(47, 'Iron shirt', 'Založ celkově 4x stáje', 'staje', 4, 2),
(48, 'Family house', 'Buď ve stáji spolu s 4 jinými hráči', '', 0, 2),
(49, 'Light industry', 'Postav ve své stáji 12 budov', '', 0, 2),
(50, 'Heavy industry', 'Postav ve své stáji 25 budov', '', 0, 2),
(51, 'Smuggler', 'Pošli 20 předmětů přes stáj', 'posilani', 20, 2),
(52, 'Hereditary profession', 'Postav celkově 100 budov', 'budovy', 100, 2),
(53, 'What a bargain?', 'Prodej 15 předmětů jiným hráčům', 'prodej1', 15, 1),
(54, 'Businessman', 'Prodej 50 předmětů jiným hráčům', 'prodej1', 50, 1),
(55, 'For sale!', 'Prodej 5 předmětů systémovým obchodníkům', 'prodej2', 5, 1),
(56, 'Second hand', 'Prodej 8 předmětů s výdrží pod 75% jiným hráčům', 'prodej3', 8, 1),
(57, 'Mass destruction', 'Sešrotuj 35 předmětů', 'srot', 35, 1),
(58, 'Iron magnat', 'Sešrotuj 70 předmětů', 'srot', 70, 1),
(59, 'Renovation', 'Proveď opravu celého kluzáku alespoň za 15 000 Is', '', 0, 1),
(60, 'Art of merchantism', 'Prodej 8 předmětů za víc než je jejich systémová cena', 'prodej4', 8, 1),
(61, 'Mender', 'Oprav 50 předmětů', 'opravy1+opravy2', 50, 1),
(62, 'Handcraftman', 'Oprav 100 předmětů', 'opravy1+opravy2', 100, 1),
(63, 'F-ue-lood', 'Zaplat 20x za údržbu paliva', 'udrzba', 20, 1),
(64, 'Mr. Do-It-Yourself', 'Oprav 150 předmětů bez použití droida', 'opravy1', 150, 1),
(65, 'Lazy old man', 'Oprav 20 předmětů s pomocí droida', 'opravy2', 20, 1),
(66, 'Slaver', 'Opotřeb prací 5 droidů', 'droidi', 5, 1),
(67, 'Gambling', 'Prosázej 300 000 Is', 'prosazeno', 300000, 3),
(68, 'Take the risk', 'Vsaď 10 000 Is a vyhraj sázku', '', 0, 3),
(69, 'Certain probability', 'Vsaď minimálně 750 Is na třetí místo v závodě s alespoň 5 jezdci a vyhraj sázku', '', 0, 3),
(70, 'Four-leaf', 'Vyhraj 30 sázek', 'sazky', 30, 3),
(71, 'What the ?', 'Vyhraj 70 sázek', 'sazky', 70, 3),
(72, 'Security breach', 'Využij 10x špióna', 'spion', 10, 4),
(73, 'Pathfinder', 'Postav trať s alespoň 15 úseky', '', 0, 4),
(74, 'Politics', 'Hlasuj ve 10 anketách', '', 0, 4),
(75, 'Postman', 'Přijmi 200 nesystémových pošt', 'posta', 200, 4),
(76, 'Hard work', 'Vydělej 20 000 Is na brigádách', 'brigady1', 20000, 4),
(77, 'Homeless', 'Ztrať celkově 1 000 prestiže na brigádách', 'brigady2', 1000, 4),
(78, 'Nervosity', 'Nabouráním do trati se vyřaď ze závodu, který jsi vedl', '', 0, 0),
(79, 'Rhino skin', 'Odstiň alespoň 80 dmg pancéřováním', '', 0, 0),
(80, 'Don Salieri', 'Založ 15 závodů s dotací alespoň 35 000 Is, které se odjedou', 'zalozeni', 15, 0),
(81, 'Neighbour', 'Nech si opravit celkem 20 předmětů u jiného hráče', 'opravy4', 20, 1),
(82, 'Gimme a hand', 'Nech si opravit celkem 50 předmětů u jiného hráče', 'opravy4', 50, 1),
(83, 'Let me...', 'Uzavři jako opravář 20 opravářských smluv', 'opravy3', 20, 1),
(84, 'Debugger', 'Uzavři jako opravář 50 opravářských smluv', 'opravy3', 50, 1),
(85, 'Scratched', 'Dojeď závod s 1 předmětem s výdrží pod 25%', '', 0, 0),
(86, 'Strong will', 'Dojeď závod se 3 předměty s výdrží pod 25%', '', 0, 0),
(87, 'Trash runner', 'Dojeď závod s 5 předměty s výdrží pod 45%', '', 0, 0),
(88, 'I told ya''', '5x vyřaď ze závodu svůj preferovaný cíl', 'cile', 5, 0),
(89, 'Be There', 'Účastni se poháru', NULL, 0, 5),
(90, 'Be Almost There', 'Přihlaš jezdce ze své stáje do poháru', NULL, 0, 5),
(91, 'Rookie', 'Odjeď 10 pohárových závodů', 'poharove_zavody', 10, 5),
(92, 'Rocky', 'Odjeď 20 pohárových závodů', 'poharove_zavody', 20, 5),
(93, 'Niki Louda', 'Odjeď 50 pohárových závodů', 'poharove_zavody', 50, 5),
(94, 'Champion', 'Umísti se na prvním až třetím místě v poháru', NULL, 0, 5),
(95, 'Team work', 'Buď obchodníkem nebo závodníkem ve stáji, kde tvůj spoluhráč obsadil první až třetí místo v poháru', NULL, 0, 5),
(96, 'Master Commander', 'Buď majitelem stáje, která obsadila první až třetí místo v poháru', NULL, 0, 5),
(97, 'Friend or Foe', 'Vyřaď z pohárového závodu hráče, který je v poháru na první příčce', NULL, 0, 5),
(98, 'Oracle', '3x se během jednoho závodu vyhni hráči, od kterého jsi očekával napadnutí', '', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `rasy`
--

DROP TABLE IF EXISTS `rasy`;
CREATE TABLE IF NOT EXISTS `rasy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(40) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `r` int(11) NOT NULL DEFAULT '0',
  `a` int(11) NOT NULL DEFAULT '0',
  `o` int(11) NOT NULL DEFAULT '0',
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `kluzak` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=13 ;

--
-- Vypisuji data pro tabulku `rasy`
--

INSERT INTO `rasy` (`id`, `nazev`, `r`, `a`, `o`, `popis`, `kluzak`) VALUES
(1, 'Kent-Zaarth', 46, 96, -4, 'Extrémně agresivní rasa, jež si svým chovaním pomáhá k vítězství v závodech a zároveň se snaží ostatní závodníky odrovnat vytlačováním. Od nepaměti dobývají planety, které sousedí s jejich impériem a válečnická krev se projevuje i na závodišti. Neznají strach a dokáží vymáčknout ze svého kluzáku maximum. Samozřejmě na úkor jeho trvanlivosti. A tak se občas stane, že křehký kluzák nevydrží jejich pilotáž a exploduje, nebo vypoví službu. Právě jejich agresivita z nich ale činí skvělé jezdce, kterým mohou konkurovat jen Thylonové. Ti se snaží závodit více hlavou a nedávají takový průchod svému hněvu. Kent-Zaarthové nejsou hloupí a proto se u nich předpokládá i jistá obchodnická dovednost, jenže právě jejich povaha jakékoli obchodování znemožňuje. Navíc mnoho ras se na delší, či kratší dobu ocitlo pod nadvládou krutých Kent-Zaarthů a tak je nemají příliš v lásce, což se projevuje právě v obchodování.', 3),
(2, 'Bathol', 50, 6, 14, 'Slušný postřeh, láska k živým tvorům a neskutečně krásná tvář činí z Batholů výjimečné obchodníky. Jedině Batholové mohou konkurovat Mel-Tu Wanům v obchodních dovednostech. Vědeckým zkoumáním bylo zjištěno, že Batholové nejsou o moc krásnější, než ostatní rasy, ale že jejich krása spočívá hlavně ve vylučování směsi feromonů, které příjemně působí na většinu ostatních ras ve vesmíru. Batholové jsou si samozřejmě své přednosti vědomi, a proto se vyhýbají závodění na kluzácích, aby si nepřivodili zranění, které by je zhyzdilo, nebo jim dokonce poranilo feromonové žlázy. Pro Bathola je jeho vzhled a vůně natolik důležitá, že při zohavujícím zranění, nebo při poranění feromonové žlázy páchají sebevraždu. Právě strach o vlastní tělo činí z Batholů natolik mírumilovné bytosti. I přesto se našlo několik hrdinných Batholů, kteří si do kokpitu kluzáku sedli. Ovšem neschopnost překonat vrozený odpor k agresivitě byla důvodem, proč to po nich již nikdo neopakoval.', 0),
(3, 'Poofpuf', 53, 72, 2, 'O Poofpufech se tvrdí, že jsou lepší závodníci, než obchodníci a nelze než připustit, že tvrzení je pravdivé. Ovšem ten, kdo by pokládal Poofpufy za neschopné bussinesmany, by se velmi pletl. Pokud nakupují pro vlastní potřeby je jejich obchodní talent dostatečný. Na závodní dráze spoléhají spíše na své vyspělé reflexy, než na agresivitu, které příliš nepobrali. Spíše se snaží využívat chyb soupeřů, než se aktivně podílet na jejich destrukci. Stejně jako Matres, nebo Terrané, jsou Poofpufové vhodnou rasou pro všestranné hráče, kteří ovšem přeci jen upřednostňují závody před obchodem.', 2),
(4, 'Mentor', 90, 34, 0, 'Vzrůstem malí, ale výkonem velmi slušní závodníci. Mentorové mají jednu zvláštnost a tou je možnost využívat svůj mozek z více procent, než většina ostatních známých ras. To jim zajišťuje schopnost maximálního soustředění se při závodě. Nikdo nedokáže být tak pozorný a tak rychle reagovat na podněty, jako Mentor. Naopak, jejich malá agresivita je pro ně v závodě spíše přítěží a tam, kde se Kent-Zaarth dokáže se svým kluzákem řítit neuvěřitelnou rychlostí, Mentor bude opatrně zkoumat trať a ztrácet cenné vteřiny. Naopak v úzkých zatáčkách a složitých úsecích se Mentor cítí jako doma, jelikož má možnost uplatnit své neobyčejně vyvinuté reflexy. Jako obchodníci Mentoři nijak zvlášť neexcelují. Může za to zejména jejich neschopnost naučit se obstojně InterLingvě a mnoho obchodníkù, případně kupců, odrazuje nutnost hovořit s Mentory jejich vlastní, velice složitou řečí.', 1),
(5, 'Myriada', 50, 66, 4, 'Myriady mají jednu zvláštnost - neexistují v jejich rase samci. I přes velkou snahu mnoha dobrodruhů se dodnes nepodařilo zjistit, jakým způsobem se Myriady rozmnožují, jelikož si toto tajemství žárlivě střeží. Jsou to vyvážené závodnice s talentem pro obchod. Závodní styl ne nepodobný stylu Thylonů je zárukou respektu a dobrých výdělků. Navíc pokud mají potřebu obchodovat, dosahují lepších výsledků, než Thylonové a není tak snadné nachytat je a prodat jim komponenty za nadsazené ceny. Stejně jako Terrané, jsou Myriady vhodnou rasou pro hráče, který si není zcela jistý, jakou cestu si ve hře nakonec zvolí. Ovšem na rozdíl od Terranů, jsou Myriady lepší závodnice a mírně horší obchodnice.', 2),
(6, 'El Igosta', 45, 78, 3, 'Velmi nebezpeční závodníci, ovšem spíše svou agresivitou, než jezdeckým umem. Vědí o sobě, že nejsou příliš zdatní obchodníci a tak se sami do obchodů moc nepouštějí a spíše se snaží vydělávat si jako závodníci. Pokud se na dráze setkají s Thylonem, nebo Kent-Zaarthem, budou samozřejmě v nevýhodě, ovšem proti ostatním mají jezdecky navrch. Chováním jsou bližší spíše Kent-Zaarthům – jsou prchliví, agresivní a snaží se vyhrát za každou cenu – i když to někdy skončí vlastní havárií. Právě jejich prchlivost je důvodem, proč s nimi ostatní nepříliš rádi obchodují. Přestože mají určitý obchodní talent, často jednání zkazí jejich výbuch hněvu.', 3),
(7, 'Thylon', 67, 69, -1, 'Nejlepší a neúspěšnější závodníci kluzáků jsou právě Thylonové – společně s Kent-Zaarthy. Vyvážená agresivita a rychlé reflexy z nich činí na závodištích obávané a respektované soupeře. V podstatě se jedná o zakladatele kluzákových závodů a částečně i díky nim se velmi rychle rozšířila jejich obliba po většině známých planet. Veškerý jejich jezdecký um je ale vykoupen jejich neschopností obchodovat. Nejde o to, že by byli hloupí, ale spíše příliš zahledění do závodění a jestliže nějaký díl potřebují nebo chtějí, neváhají za něj utratit velké sumy, aniž by si zjistili, zda není někde k mání levněji. Odnepaměti totiž střežili svou planetu v malých vesmírných stíhačích, jejichž ovládání není nepodobné ovládání kluzáku, proti expanzi Kent-Zaarthů. Právě proto neměli příliš času na budování své ekonomiky a dodnes na to při obchodování doplácejí.', 2),
(8, 'Plasmanian', 65, 28, 8, 'Po dlouhém hledání vlastní historie zjistili Plasmasiané – k vlastní nechuti, že jejich rasa vznikla jako náhodný a nechtěný výsledek pokusu, který prováděla doposud neznámá civilizace. Původně chtěli tito „Neznámí“ vytvořit novou dokonalou rasu, která bude po obchodní stránce schopná konkurovat Mel-tu Wanům a v závodech se vyrovná Thylonům, nebo Kent-Zaarthům. Jedná se o jedinou biotechnologickou rasu. Těla Plasmanianů totiž obsahují i elektronické součástky, které se do nich přenášejí z matky a následně se nedefinovatelným způsobem replikují. Jak bylo řečeno, vzniklá rasa byla nechtěná, ale silně životaschopná. V obchodnických dovednostech se lehce vyrovnají H''lenooům a navíc mají – díky elektronickým senzorům lepší reflexy. Ve vesmíru se tato rasa řadí k těm nejmírumilovnějším – což z nich ovšem činí spíše průměrné piloty kluzáků. Odborníci tvrdí, že jejich mírumilovnost je spojená s obavou o křehké elektronické součástky, které obsahují jejich těla. V zásadě se tedy dá říci, že Plasmaniané jsou elektronickou verzí H’leenooů s několika drobnými odchylkami. Hlavní rozdíl je v zákaznících. Zatímco u H’leenooů je každému jedno, co jsou za rasu, u Plasmanianů se zákazníci dělí na ty, co by nikdy jinde nenakoupili a na ty, kteří je bytostně nesnášejí, protože je ani za žádnou rasu a živý druh nepovažují.', 1),
(9, 'H''lenoo', 52, 36, 10, 'Slušní obchodníci, ovšem nikterak ve srovnání s Mel-tu Wany.  Někteří z nich se dokonce snaží hledat své štěstí na závodní dráze. Zde je ovšem znevýhodňuje jejich mírumilovnost, kdy jen s nechutí narážejí do ostatních kluzáků a vystrkují je z trati. Naopak jejich postřeh je velmi slušný a tak se jen málokdy stane, že něco unikne jejich pozornosti. Vcelku vyrovnaná rasa, která se uplatní jak při obchodování, tak při závodění. Díky slušné inteligenci se z mnohých H''lenooů stali manažeři, kteří připravují týmovou strategii a starají se o rozvíjení stáje. Dalo by se říci, že jejich schopnosti jsou podobné Poofpufùm, ovšem u H''lenooů spíše zaměřené na obchod.', 0),
(10, 'Mel-tu Wan', 4, 35, 17, 'Někdo je nazývá nejlepšími obchodníky ve vesmíru, někdo zas největšími podvodníky. V zásadě jsou to intrikáni spoléhající na znalosti psychických stránek ostatních ras. Na druhou stranu je váže silná obchodnická čest. Tato čest je pozůstatkem z dob, kdy se ještě Mel-tu Wané spojovali do obchodnických cechů. S nástupem éry kluzákového závodění se ale cechy rozpadly, protože nebyly dostatečně flexibilní. Spolu s jejich rozpadem upadly do zapomnění i obchodnické kodexy – právě ty, kvůli kterým se cechy rozpadly. Ovšem při uzavírání obchodů se jich stále řada Mel-tu Wanů drží a považují je za jakási nepsaná pravidla. Obchod, sázení a vymýšlení ekonomických teorií je pro většinu Mel-tu Wanů nejen povoláním, ale i zábavou, na kterou nedají dopustit. Naopak závodění považují za hloupou zábavu pro hlupáky. Možná je to ale zapříčiněno tím, že jejich jezdecké schopnosti jsou naprosto ubohé.', 0),
(11, 'Chuuckoo', 19, 89, 6, 'V meziplanetární příručce Stopařův průvodce galaxií jsou Chuuckooové uváděni jako časoprostorová anomálie. Podle Bertholdových tabulek ras je hodnocena indexem 4,2 z 10. Jedná se tedy o méně vyvinutou rasu, která inteligenčně zaostává za průměrem. Přesto dokázali odkrýt tajemství mezihvězdných letů, jaderné fúze a dalších vynálezů, které jsou obvyklé pro mnohem vyspělejší rasy. Největším hendikepem oproti ostatním jsou jejich opožděné reflexy. Při závodech je ovšem často vynahrazují svou – až živočišnou – agresivitou. Někdy je to velmi dobrá strategie, jindy jde naopak o krok ke zničení vlastního kluzáku. Jejich zvýšená agresivita z nich ovšem činí vyhledávané a hýčkané „wreckery“. O co jsou ovšem ochuzeni na reflexech, to jim bylo přidáno v obchodnických dovednostech. Při obchodech je opouští jejich přímočará zuřivost a jsou schopni velmi dobře vyjednávat a uzavírat výhodné (pro ně) obchody.', 3),
(12, 'Terran', 51, 58, 6, 'Přímí potomci Terranù, kterým se podařilo opustit planetu Zemi těsně před zhroucením jejího jádra. Na evakuačních lodích proběhlo v průběhu staletí několik vln eugenických pokusů. Rasa, která se nyní nazývá Terrany tak ve skutečnosti nemá s původními obyvateli Země mnoho společného. Terrané jsou díky své inteligenci  a jezdeckým schopnostem obstojnými závodníky i obchodníky. Dokáží adekvátně a dostatečně rychle reagovat a přijímat správná rozhodnutí – jedno, zda  na závodní trati, nebo nad burzovními tabulkami. Ideální rasa pro hráče, který si buď není jistý, čím přesně se chce živit, nebo naopak pro hráče, který ví, že chce jezdit a zároveň se vrhnout do víru obchodu.', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `registrace`
--

DROP TABLE IF EXISTS `registrace`;
CREATE TABLE IF NOT EXISTS `registrace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `login` int(11) NOT NULL DEFAULT '0',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `sablony`
--

DROP TABLE IF EXISTS `sablony`;
CREATE TABLE IF NOT EXISTS `sablony` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL,
  `nazev` varchar(42) COLLATE utf8_czech_ci NOT NULL,
  `podvozky` int(11) NOT NULL DEFAULT '0',
  `motory` int(11) NOT NULL DEFAULT '0',
  `drzaky` int(11) NOT NULL DEFAULT '0',
  `chladice` int(11) NOT NULL DEFAULT '0',
  `desky` int(11) NOT NULL DEFAULT '0',
  `brzdy` int(11) NOT NULL DEFAULT '0',
  `zdroje` int(11) NOT NULL DEFAULT '0',
  `suspenzory` int(11) NOT NULL DEFAULT '0',
  `pancerovani` int(11) NOT NULL DEFAULT '0',
  `p_motory` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `sazky`
--

DROP TABLE IF EXISTS `sazky`;
CREATE TABLE IF NOT EXISTS `sazky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `zavod` int(11) NOT NULL DEFAULT '0',
  `sazka` float NOT NULL DEFAULT '0',
  `zavodnik` int(11) NOT NULL DEFAULT '0',
  `misto` int(11) NOT NULL DEFAULT '0',
  `vyhra` int(11) NOT NULL DEFAULT '0',
  `penize` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `sklad`
--

DROP TABLE IF EXISTS `sklad`;
CREATE TABLE IF NOT EXISTS `sklad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) DEFAULT NULL,
  `zbozi` int(11) DEFAULT NULL,
  `typ` int(11) DEFAULT NULL,
  `cena` int(11) DEFAULT '0',
  `cena2` int(11) DEFAULT '0',
  `umisteni` int(11) DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `staje`
--

DROP TABLE IF EXISTS `staje`;
CREATE TABLE IF NOT EXISTS `staje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `zkratka` varchar(5) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vlajka` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `prestiz` int(11) NOT NULL DEFAULT '0',
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `kasa` int(11) NOT NULL DEFAULT '0',
  `pozemek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `staje_stavy`
--

DROP TABLE IF EXISTS `staje_stavy`;
CREATE TABLE IF NOT EXISTS `staje_stavy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stav` varchar(50) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `staje_stavy`
--

INSERT INTO `staje_stavy` (`id`, `stav`) VALUES
(1, 'Vlastník'),
(2, 'Závodník'),
(3, 'Obchodník');

-- --------------------------------------------------------

--
-- Struktura tabulky `stajovnici`
--

DROP TABLE IF EXISTS `stajovnici`;
CREATE TABLE IF NOT EXISTS `stajovnici` (
  `login` int(11) NOT NULL DEFAULT '0',
  `staj` int(11) NOT NULL DEFAULT '0',
  `stav` int(11) NOT NULL DEFAULT '0',
  `penize` int(11) NOT NULL DEFAULT '0',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `pomer` int(11) NOT NULL DEFAULT '50',
  `forum` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Struktura tabulky `stats`
--

DROP TABLE IF EXISTS `stats`;
CREATE TABLE IF NOT EXISTS `stats` (
  `login` int(11) NOT NULL AUTO_INCREMENT,
  `questy` text COLLATE utf8_czech_ci NOT NULL,
  `total_dmg` int(11) NOT NULL DEFAULT '0',
  `total_skody` int(11) NOT NULL DEFAULT '0',
  `max_dmg` int(11) NOT NULL DEFAULT '0',
  `max_skody` int(11) NOT NULL DEFAULT '0',
  `total_vyvolane` int(11) NOT NULL DEFAULT '0',
  `total_nevyvolane` int(11) NOT NULL DEFAULT '0',
  `max_vyvolane` int(11) NOT NULL DEFAULT '0',
  `max_nevyvolane` int(11) NOT NULL DEFAULT '0',
  `total_uhyby` int(11) NOT NULL DEFAULT '0',
  `max_uhyby` int(11) NOT NULL DEFAULT '0',
  `zavody` int(11) NOT NULL DEFAULT '0',
  `poharove_zavody` int(11) NOT NULL DEFAULT '0',
  `zalozeni` int(11) NOT NULL DEFAULT '0',
  `vitezstvi` int(11) NOT NULL DEFAULT '0',
  `vyrazeni` int(11) NOT NULL DEFAULT '0',
  `nedojeti` int(11) NOT NULL DEFAULT '0',
  `useky` int(11) DEFAULT '0',
  `prosazeno` int(11) NOT NULL DEFAULT '0',
  `sazky` int(11) NOT NULL DEFAULT '0',
  `spion` int(11) NOT NULL DEFAULT '0',
  `posta` int(11) NOT NULL DEFAULT '0',
  `brigady1` int(11) DEFAULT '0',
  `brigady2` int(11) NOT NULL DEFAULT '0',
  `opravy1` int(11) NOT NULL DEFAULT '0',
  `opravy2` int(11) NOT NULL DEFAULT '0',
  `opravy3` int(11) NOT NULL DEFAULT '0',
  `opravy4` int(11) NOT NULL DEFAULT '0',
  `droidi` int(11) NOT NULL DEFAULT '0',
  `prodej1` int(11) NOT NULL DEFAULT '0',
  `prodej2` int(11) NOT NULL DEFAULT '0',
  `prodej3` int(11) NOT NULL DEFAULT '0',
  `prodej4` int(11) NOT NULL DEFAULT '0',
  `udrzba` int(11) NOT NULL DEFAULT '0',
  `srot` int(11) NOT NULL DEFAULT '0',
  `budovy` int(11) NOT NULL DEFAULT '0',
  `staje` int(11) NOT NULL DEFAULT '0',
  `posilani` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `suspenzory`
--

DROP TABLE IF EXISTS `suspenzory`;
CREATE TABLE IF NOT EXISTS `suspenzory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vaha` int(11) NOT NULL DEFAULT '0',
  `zdroj` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `chlazeni` int(11) NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=26 ;

--
-- Vypisuji data pro tabulku `suspenzory`
--

INSERT INTO `suspenzory` (`id`, `nazev`, `vaha`, `zdroj`, `vydrz`, `chlazeni`, `podvozek`) VALUES
(1, 'Lurid', 20, 60, 70, 30, 0),
(2, 'Lifter', 20, 50, 70, 25, 0),
(3, 'Astirion', 20, 58, 80, 30, 0),
(4, 'Flight', 25, 68, 90, 40, 0),
(5, 'MechaWings', 30, 72, 100, 50, 0),
(6, 'Stream-up', 35, 76, 110, 55, 0),
(7, 'Sub-volvo', 40, 80, 120, 60, 0),
(8, 'AntiGraviton', 45, 86, 130, 70, 0),
(9, 'Ascendion', 50, 92, 150, 85, 0),
(10, 'Lightness', 55, 98, 170, 95, 0),
(11, 'Sustineo', 60, 103, 190, 105, 0),
(12, 'Akarian', 65, 110, 210, 108, 0),
(13, 'Hawk', 70, 107, 230, 115, 0),
(14, 'MechaWings II', 75, 114, 250, 120, 0),
(15, 'Exhalion', 80, 114, 270, 125, 0),
(16, 'Raven', 85, 118, 280, 130, 0),
(17, 'Sub-duco', 95, 110, 290, 135, 0),
(18, 'Leviathan', 100, 110, 310, 140, 0),
(19, 'Angel', 105, 100, 320, 145, 0),
(20, 'Cercurus', 110, 105, 330, 150, 0),
(21, 'MechaWings III', 115, 110, 340, 155, 0),
(22, 'Sus-tollo', 120, 105, 370, 155, 0),
(23, 'Leviathan II', 125, 115, 370, 140, 0),
(24, 'Repulsion', 130, 105, 380, 160, 0),
(25, 'Venial', 140, 120, 400, 160, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `sys`
--

DROP TABLE IF EXISTS `sys`;
CREATE TABLE IF NOT EXISTS `sys` (
  `entity` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `val` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `sys`
--

INSERT INTO `sys` (`entity`, `val`) VALUES
('zavody', 5475),
('stav_hry', 1),
('etapa', 5),
('19:00 15.10.', -42),
('pohar_zavod', 20),
('casopis', 1),
('restart', 1350755944),
('pohar', 7);

-- --------------------------------------------------------

--
-- Struktura tabulky `tipy`
--

DROP TABLE IF EXISTS `tipy`;
CREATE TABLE IF NOT EXISTS `tipy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tip` text COLLATE utf8_czech_ci NOT NULL,
  `sekce` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=90 ;

--
-- Vypisuji data pro tabulku `tipy`
--

INSERT INTO `tipy` (`id`, `tip`, `sekce`) VALUES
(1, 'Ceny paliv se každý přepočet hýbou, takže jejich vhodným překupováním můžeš vydělat.', 'obchod-paliva'),
(2, 'Nákup paliva do stáje je se slevou, takže se vyplatí.', 'obchod-paliva'),
(3, 'Pokud chceš hodně obchodovat z palivem, je výhodné si koupit licensi, abys měl větší sklad (až 2 000 jednotek)', 'obchod-paliva'),
(4, 'Najetím na čas opravy můžeš opravu zrušit. Výdrž se sice zvýší, peníze se ti ale nevrátí.', 'obchod-sklad'),
(5, 'Při sestavování kluzáku si dávej pozor aby ti stačil tvůj chladič a zdroj.', 'obchod-sklad'),
(6, 'Nejlepší je nechat si předmět opravit u člověka, který je právě online a dává nejvyšší slevu.', 'obchod-opravari'),
(7, 'Jako opravář si pořiď několik droidů abys na opravách vydělával.', 'obchod-opravari'),
(8, 'Jako opravář si dobře rozmysli, jak velkou slevu dáš. Každá další změna stojí 500 Is.', 'obchod-opravari'),
(9, 'Najetím na čas opravy můžeš opravu zrušit. Výdrž se sice zvýší, ale peníze se ti ale nevrátí.', 'obchod-opravari'),
(10, 'Systémoví obchodníci také nakupují, ale za 40-70% původní ceny. Toto nastavení změníš ve výloze.', 'obchod-vyloha'),
(11, 'Obchodnické rasy (Mel-tu Wan, Bathol, ..) mají předměty výrazněji levnější. Řekni nějakému obchodníkovi, aby ti předmět koupil, a vyděláš.', 'obchod'),
(12, 'Na opravu můžeš použít maximálně 2 droidy. Bonusy se sčítají.', 'obchod'),
(13, 'Droida nelze opravit.', 'obchod'),
(14, 'Systémoví obchodníci také nakupují, ale za 40-70% původní ceny. Toto nastavení změníš ve výloze.', 'obchod'),
(15, 'V sekci nákupu předmětu je dostupný přehled všech předmětů ve výlohách.', 'obchod'),
(16, 'Nakupovat předměty se vyplatí spíše u hráčů než u systémových obchodníků.', 'obchod'),
(17, 'Najetím na čas opravy můžeš opravu zrušit. Výdrž se sice zvýší, ale peníze se ti ale nevrátí.', 'obchod'),
(18, 'S překupováním paliva se dá hodně vydělat.', 'obchod'),
(19, 'Nákup paliva do stáje je se slevou, takže se vyplatí.', 'staj'),
(20, 'Manipulovat se stájovým palivem může pouze stájový obchodník.', 'staj'),
(21, 'Pokud se třeba neodjel závod nebo byl jiný problém, vyplatí se sledovat čas posledního přepočtu nahoře v sekci Home. Je možné, že přepočet z technických problému neproběhl vůbec.', 'vitejte'),
(22, 'Pokud není tvůj kluzák jízdy schopný, v depu se vždy dovíš důvod. Ale pozor: toto se netýká nedostatečného chlazení.', 'depo'),
(23, 'Dávej si pozor, jestli máš dost silný chladič.', 'depo'),
(24, 'Rychlost kluzáku/motoru značí, jak moc je využíván motor v kluzáku.', 'depo'),
(25, 'Každý kluzák musí mít minimálně 7 základních součástí. Další 3 (pancéřování, suspenzor a přídavný motor) už jsou dobrovolné. ', 'depo'),
(26, 'Závody jsou dobrým zdrojem peněz.', 'zavody'),
(27, 'Dávej si pozor na výši vkladu, někdy může být příliš vysoká.', 'zavody'),
(28, 'Sledujte, kdy se má váš závod odjet. Může to být jindy než nadcházející přepočet.', 'zavody'),
(29, 'Za závod na tvojí trati dostaneš 500 Is.', 'zavody'),
(30, 'Pokud chceš jezdit QSB Cup musíš být ve stáji. Zkus se domluvit s nějakým vlastníkem stáje.', 'pohar'),
(31, 'Výsledky všech předchozích QSB Cupů jsou na helpu.', 'pohar'),
(32, 'Dobře si rozmysli kolik si chceš půjčit a s jakým úrokem. Pokud se jedná o menší půjčku, půjčuj si s menším úrokem a menší dobou splatnosti a naopak.', 'bakny'),
(33, 'Hned po vložení peněz ti budou odečteny 2%, nelekej se! O hlavním přepoču se to dorovná a poté další přepočty začneš vydělávat.', 'bakny'),
(34, 'Úročí se každý hlavní přepočet.', 'bakny'),
(35, 'Exekutora opravdu potkat nechceš, splácej tedy své dluhy bance včas.', 'bakny'),
(36, 'Exekutor je opravdu krutý. Pokud nesplatíš dluh, zabaví ti peníze, paliva a součástky.', 'bakny'),
(37, 'Pokud jsi obchodník, nehleď na prestiž a vyber si brigádu, která dává nejvíce peněz.', 'brigady'),
(38, 'Pokud máš brigádu, nemůžeš jezdit závody.', 'brigady'),
(39, 'Jako závodník se pokus udržet si svojí prestiž.', 'brigady'),
(40, 'Odměna z brigády se vyplácí každý přepočet.', 'brigady'),
(41, 'Za závod na tvojí trati dostaneš finanční odměnu.', 'trate'),
(42, 'Postav si také svou trať a ponechej jí zde jako svůj pomník.', 'trate'),
(43, 'Šedé číslo za názvem fóra říká, kolik nepřečtených příspěvků tam na tebe čeká.', 'forum'),
(44, 'Svůj vlastní příspěvek ve fóru můžeš smazat a opravit pouze, pokud je poslední na daném fóru.', 'forum'),
(45, 'Neboj se zde zeptat na vše, co ti není jasné. Nebo můžeš jen pokecat s dalšími lidmi z QSB.', 'forum'),
(46, 'Opravdu se vyplatí sledovat adminské fórum (Oznámení hráčům).', 'forum'),
(47, 'Pečlivě vyber fórum, které se hodí pro účel tvé zprávy.', 'forum'),
(48, 'Na systémovém fóru se řeší změny hry, nové koncepty a pravidla.', 'forum'),
(49, 'Pokud objevíš chybu ve hře, chybové fórum je to pravé místo, kde ji můžeš ohlásit.', 'forum'),
(50, 'Hráčské fórum slouží k chatování o všem možném i mimo hru.', 'forum'),
(51, 'Přes burzovní fórum nebo poštu se vyplatí shánět všechny součástky do kluzáku.', 'forum'),
(52, 'Na burzovním fóru můžeš inzerovat své předměty.', 'forum'),
(53, 'K nalezení stáje je nejlepší použít sekce fóra ''Ohlaš. závodů/hledání stájí''.', 'forum'),
(54, 'Fórum ''Oznámení hráčům'' spravuje pouze admin a vyvěšuje tam všechny důležité informace a změny. Vyplatí se tedy sledovat každý příspěvek.', 'forum'),
(55, '[B] znamená tučné písmo, [I] je kurzíva, [O] je oranžové a [S] šedé písmo.', 'forum'),
(56, 'Hráči se žlutým čtverečkem jsou zkušení starší hráči, u kterých můžeš určitě čekat pomoc.', 'forum'),
(57, '[B] znamená tučné písmo, [I] je kurzíva, [O] je oranžové a [S] šedé písmo.', 'posta'),
(58, 'K odeslání pošty více hráčům piš jejich ID oddělená čárkou.', 'posta'),
(59, 'ID hráče zjistíš v jeho profilu.', 'posta'),
(60, 'HTML kód nelze v poště z bezpečnostních důvodů užívat.', 'posta'),
(61, 'Hlasováním v anketách si plníš quest Politics.', 'ankety'),
(62, 'Hlasováním v anketách ti přibývá prestiž.', 'ankety'),
(63, 'V přehledech najdeš spoustu důležitých věcí, jako například finance.', 'prehledy'),
(64, 'Za každý splněný quest dostaneš 2 000 Is.', 'prehledy-questy'),
(65, 'Jsi-li začátečník, sleduj tipy. Vždy se váží ke konkrétní sekci ve hře. Často jsou sepsány na základě zkušeností ostatních hračů.', 'obecne'),
(66, 'QSB World (world.qsb.cz) obsahuje spoustu skvělých tipů a rad, zábavných článků a dalších informací.', 'obecne'),
(67, 'Pokud si nevíš rady, nahlédni do Helpu popř. zkus hráčské nebo systémové fórum.', 'obecne'),
(68, 'S novými nápady se neboj přijít na fórum, ostatní hráči i admin to ocení.', 'obecne'),
(69, 'Tipy najdete pokaždé dole na stránce.', 'obecne'),
(70, 'Pokud se třeba neodjel závod nebo byl jiný problém, vyplatí se sledovat čas posledního přepočtu nahoře v sekci Home. Je možné, že přepočet z technických problému neproběhl vůbec.', 'home'),
(71, 'Jsi-li začátečník, sleduj tipy. Vždy se váží ke konkrétní sekci ve hře. Často jsou sepsány na základě zkušeností ostatních hračů.', 'home'),
(72, 'Jsi-li začátečník, sleduj tipy. Vždy se váží ke konkrétní sekci ve hře. Často jsou sepsány na základě zkušeností ostatních hračů.', 'vitejte'),
(73, 'Hráč má přístup jen do své a do o jeden stupeň vyšší cenové kategorie (podle ceny kluzáku).', 'zavody-zalozit'),
(74, 'Výběr tratí je omezený podle dotace závodu. Maximální dotace je v profilu každé trati.', 'zavody-zalozit'),
(75, 'V hráčském profilu najdeš například ID, které pak můžeš používat při odesílání pošty.', 'hrac'),
(76, 'Odjeté závody v hráčském profilu jsou ve formátu Celkem-první-druhý-třetí.', 'hrac'),
(77, 'Autor hry doporučuje pro lepší hraní aktuální verzi prohlížeče FireFox.', 'obecne'),
(78, 'QSB je primárně optimalizováno pro nejnovější verzi prohlížeče FireFox.', 'obecne'),
(79, 'Rasa i startovní kluzák lze změnit v nastavení.', 'obecne'),
(80, 'Maximální výhra je desetinásobek vsazené částky.', 'sazky'),
(81, 'Při odchodu závodníka ze závodu jsou sázky na tohoto závodníka zrušeny se 100% návratností.', 'sazky'),
(82, 'Při sázení vždy kontroluj celkovou vsazenou částku a přizpůsob tak výši své sázky.', 'sazky'),
(83, 'Na výhry sázek se rozděluje 15% dotace závodu a ostatní neúspěšné sázky.', 'sazky'),
(84, 'Zakládání stájí se doporučuje pokročilejším hráčům, ale není zas tak náročné.', 'staje'),
(85, 'Předat můžeš přes stáj pouze předmět, který je volně umístěn ve skladu. Tzn. není ve výloze, neopravuje se a není část kluzáku.', 'staje'),
(86, 'Přihlásit do QSB Cupu můžeš až 2 jezdce z jedné stáje.', 'staje'),
(87, 'Pokud jsou v závodě alespoň 2 jezdci, můžou se účastnit 2 jezdci ze stejné stáje.', 'staje'),
(88, 'Pokud jsou v závodě alespoň 2 jezdci, můžou se účastnit 2 jezdci ze stejné stáje.', 'zavody'),
(89, 'Čím vícekrát změníte styl jízdy, tím více dáváta nepřátelským špiónům šancí na odhalení vašeho stylu jízdy.', 'zavody');

-- --------------------------------------------------------

--
-- Struktura tabulky `trate`
--

DROP TABLE IF EXISTS `trate`;
CREATE TABLE IF NOT EXISTS `trate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(40) COLLATE utf8_czech_ci DEFAULT NULL,
  `login` int(11) NOT NULL DEFAULT '0',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `trat` text COLLATE utf8_czech_ci NOT NULL,
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `useky` int(11) NOT NULL DEFAULT '0',
  `delka` int(11) NOT NULL DEFAULT '0',
  `pro` int(11) NOT NULL DEFAULT '0',
  `proti` int(11) NOT NULL DEFAULT '0',
  `mezi` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=435 ;

--
-- Vypisuji data pro tabulku `trate`
--

INSERT INTO `trate` (`id`, `nazev`, `login`, `datum`, `trat`, `popis`, `useky`, `delka`, `pro`, `proti`, `mezi`) VALUES
(27, 'Longhorn', 1, '2006-09-01', '1,9,31,37,60,43,46,8,48,49,15,16,36,3', 'Dlouha a obtizna trat, plna nebezpecnych zatacek a propasti', 14, 1, 8, 2, 2),
(24, 'Extrémní jízda', 0, '2006-08-22', '1,5,30,33,53,60,59,29,28,42,45,15,16,5,34,37,28,24,28,37,23,25,53,19,3', 'Hodně dlouhá trať. Pokud si chcete rozflákat kluzák, máte příležitost. Kde jinde, než na nepřehledném měsíci Europě plné všelijakých rýh, byste se mohli zabít??', 25, 0, 16, 2, 2),
(34, 'EuKeshAsh', 0, '2006-11-18', '1,60,6,23,53,41,22,37,47,22,28,49,18,3', 'Tato trat se jezdi v troskach jedne z mnoha mistech poznamenaných mezigalaktickymi nepokoji... O stare znicene trosky lodi v trati neni nouze a je proto velmi nebezpecna!', 14, 1, 13, 2, 2),
(31, 'Zero Gravity', 1, '2006-10-06', '1,26,40,44,8,48,29,41,63,6,8,20,3', 'Trať je umístěna na menším měsíci a gravitace je tedy nižší. Je tedy ideální pro velké skoky.', 13, 0, 7, 0, 3),
(20, 'Labyrinthos', 0, '2006-08-20', '1,6,26,61,5,28,21,37,19,14,16,60,48,26,24,24,28,21,5,39,5,25,20,62,3', 'Spousta zatáček, která tato trať obsahuje, preferuje jezdce se zvýšenou opatrností. Přírodní prostředí bažin a vysokých skal, mezi kterými se trať klikatí jakoby bludištěm, už pohřbila mnoho nadaných jezdců.', 25, 0, 7, 1, 2),
(9, 'Valles Marineris', 0, '2006-08-18', '1,7,8,29,35,30,33,50,53,41,45,7,37,3', 'Údolí na Marsu - časté kaňony a zákruty.', 14, 0, 8, 3, 4),
(35, 'Dapper Drake', 0, '2006-11-18', '1,4,5,6,20,56,49,36,35,25,41,52,60,37,26,57,3', 'Trat rovnako dobra ako Ubuntu 6.06 Dapper Drake', 17, 1, 2, 2, 1),
(36, 'MechaRuins', 1, '2006-11-23', '1,5,8,31,26,60,39,19,9,27,35,37,51,29,57,6,8,55,3', 'Trať se skládá ze spletitých ulic jednoho opuštěného města, kdysi obydleného převážně roboty. Po drsném začátku v troskách budov se vyjíždí ven a město se objede kolem dokola. Celá trať je nakonec zakončena úzkou skalní skulinou...', 19, 0, 7, 1, 3),
(37, 'pláň rozbytých kluzáku', 0, '2006-12-10', '1,6,27,49,21,57,19,39,56,31,7,43,32,47,60,3', 'Extrémně náročná trať ... Máte rádi svůj kluzák ??? pak se do tohohle zavodu nepřihlašujte ...', 16, 1, 12, 0, 3),
(38, 'Boonta Training Course', 0, '2006-12-10', '1,4,61,19,25,39,7,57,20,33,13,16,58,47,20,29,3', 'Lehká trať, pro lidi kteří mají až moc rádi svůj kluzák ...', 17, 2, 1, 0, 1),
(40, 'fliaskacka kaktusom', 0, '2006-12-10', '1,20,27,4,6,19,60,40,6,58,49,3', 'Trat v odlahlej casti Tatooinu kde je vela kaktusov ktore zavadzaju pri pretekoch.', 12, 0, 1, 0, 0),
(41, 'PP4C3', 0, '2006-12-13', '1,20,20,20,23,43,62,9,36,25,49,60,48,19,3', '', 15, 0, 3, 1, 1),
(53, 'O třesně M alá  Grenadina', 0, '2006-12-25', '1,38,41,42,43,46,52,53,56,57,37,57,57,36,31,34,29,20,20,20,20,56,60,52,57,61,3', 'snad to někdo dojede :D', 27, 0, 2, 1, 2),
(43, 'easy', 0, '2006-12-15', '1,4,18,7,40,26,22,6,5,4,20,19,20,59,5,3', 'Pro ty co ještě namaj moc dobrej motor a chtěj taky vyhrávát, takže jen pro ty slabé kluzáky.\r\ntahle trať je velmi lehká skoro jako na rovince...', 16, 0, 8, 2, 4),
(44, 'Rigor Mortis', 0, '2006-12-16', '1,20,21,47,8,19,19,19,26,59,22,5,7,8,9,6,5,3', '', 18, 0, 2, 0, 1),
(45, 'Just for you', 0, '2006-12-17', '1,5,6,27,24,48,6,6,20,40,20,30,25,6,19,38,5,60,24,3', 'taková normální rychlá přiměřeně dlouhá trať DR.Hadr: a chci za ni peníze... ;)', 20, 0, 12, 1, 3),
(46, 'Stony Queen', 0, '2006-12-17', '1,7,8,9,52,53,30,29,19,8,35,34,50,3', '', 14, 0, 5, 2, 4),
(47, 'Keep yourself alive', 0, '2006-12-17', '1,21,22,23,22,30,31,37,26,27,33,35,26,37,24,4,3', 'Marry-go-round ;o))', 17, 0, 3, 2, 6),
(48, 'No tengo el dia bueno', 0, '2006-12-17', '1,9,41,46,57,37,35,57,55,57,20,59,20,61,43,43,3', 'Damy a panove, ceka vas spatny den. ztratite se v lese, malem se utopite v jezere a to nejhorsi, to nejhorsi je tak neobycejne osklivy, nepekna vec, ze to sem ani nebudu psat. ale mozna, mozna skoncite nekde v nebi. a nebo taky ne...\r\n\r\nZavet mate?', 17, 0, 3, 2, 3),
(49, 'Bueno', 0, '2006-12-17', '1,9,61,60,50,62,27,62,53,20,62,26,63,9,51,62,3', 'Welcome to the lake land!\r\njedna vec je jista. po tomhle zavode nebudete muset umyvat vaseho milacka :o))', 17, 0, 2, 1, 1),
(52, 'killing', 0, '2006-12-25', '1,9,35,23,28,42,58,25,4,18,27,24,18,20,3', '', 15, 0, 0, 1, 0),
(51, 'Drag', 0, '2006-12-22', '1,18,5,6,18,20,18,6,6,59,3', 'Fast&Furios style! (kdo nezna tak NfS:U a vejs)', 11, 0, 6, 1, 2),
(54, 'Zatáčka', 0, '2006-12-25', '1,37,37,37,37,37,37,37,37,37,37,3', 'serpentiny', 12, 0, 1, 2, 0),
(55, 'Sprint', 0, '2006-12-28', '1,4,5,59,18,19,6,20,25,20,42,3', 'Trať je pro kluzáky které vydrží je na plný výkon od startu do cíle a vyhraje jenom ten co jede nejrychleji protože tady brzdit nemusi..', 12, 1, 1, 1, 0),
(56, 'DMR_EH80VEGS', 0, '2006-12-29', '1,4,21,28,58,19,19,5,54,57,25,24,37,7,25,58,3', '', 17, 0, 8, 1, 1),
(57, 'Mon Gazza Speedway', 0, '2006-12-31', '1,20,23,61,42,56,42,27,19,3', 'trať pro toho komu sa nechce platit palivo!', 10, 0, 0, 1, 0),
(69, 'Jambo Track', 0, '2007-04-02', '1,18,18,19,19,5,37,37,28,24,18,20,20,59,9,9,19,31,35,6,24,28,19,43,6,19,27,37,37,37,60,6,48,52,47,18,58,18,27,23,37,37,37,20,18,38,18,63,6,36,20,3', '', 52, 2, 2, 2, 2),
(59, 'Hate Race', 0, '2007-01-02', '1,7,35,31,19,34,31,9,3', 'No neni to zas tak moc dlouho je stredni ale myslim ze se na tom nekdo pekne vyradi', 9, 1, 0, 0, 0),
(60, 'kopilo', 0, '2007-01-11', '1,9,28,20,23,42,60,38,3', '', 9, 0, 0, 0, 0),
(62, 'OBAN', 0, '2007-01-13', '1,28,57,42,37,63,43,46,60,52,56,3', 'zůčastni se největšího závodu v galaxii!', 12, 1, 2, 1, 1),
(63, 'ooo', 0, '2007-02-09', '1,5,9,42,30,34,8,3', 'n', 8, 0, 0, 0, 0),
(64, 'Beedo''s Wild Ride', 0, '2007-02-13', '1,28,9,28,50,37,32,19,62,49,51,31,32,32,42,44,11,17,38,44,32,28,42,47,49,52,22,31,6,6,3', 'nazelatenit hnedky a jedem!', 31, 1, 5, 2, 0),
(65, 'diamantová rokle', 14, '2007-02-17', '1,6,37,24,23,8,35,8,8,34,32,3', '', 12, 2, 2, 0, 4),
(66, 'Radexel', 0, '2007-02-25', '1,18,22,27,4,43,28,24,53,8,8,40,5,23,3', '', 15, 1, 1, 1, 0),
(67, 'Krystl', 0, '2007-03-10', '1,4,20,18,25,23,28,56,54,56,4,41,20,27,21,23,5,50,50,31,50,3', '', 22, 1, 1, 1, 2),
(68, 'Grandprix Afrodites III', 0, '2007-03-27', '1,4,26,20,23,22,27,21,27,58,37,37,23,24,20,26,18,19,27,24,23,18,21,22,26,18,37,23,19,28,20,3', 'Vitejte na jednom z nejnovejsich zavodnich okruhu spolecnosti Pacific Ocean! Nachazime se na krasne pozitkarske planete Afrodites III, jejiz romanticka zakouti a privetivi obyvatele vaa zbavi vsech vasich starosti. Krome mnohych atrakci a zabavnych zarizeni se tato idelicka turisty vyhledavana planeta nyni muze pysnit take nejmodernejsi zavodni trati v tomto kvadrantu galaxie!!', 32, 1, 0, 1, 1),
(70, 'Molehill', 0, '2007-04-02', '1,51,51,33,51,54,51,55,30,51,33,19,52,34,55,52,29,52,20,21,5,18,58,18,18,26,18,20,57,57,57,21,57,22,18,18,3', '', 37, 1, 2, 0, 1),
(73, 'Cool', 0, '2007-04-10', '1,35,37,37,31,42,46,36,32,54,55,56,35,20,41,44,3', '', 17, 0, 4, 0, 2),
(75, 'Aquilaris Classic', 0, '2007-04-14', '1,56,49,37,37,37,37,60,56,37,37,37,20,42,46,36,37,37,37,63,57,56,37,56,32,37,37,37,56,3', 'další super těžká trať...', 30, 0, 1, 0, 0),
(76, 'proč_musel_zemřít_Jan_Tleskač', 0, '2007-04-20', '1,37,43,56,37,31,60,37,37,23,42,15,16,37,56,37,9,38,32,56,37,3', 'trať se klikatí stínadelskými uločkami, plných nenadálých skoků a uzkých mezer.', 22, 1, 0, 0, 1),
(77, 'Vengeance', 0, '2007-04-27', '1,5,18,20,26,13,16,18,20,63,20,62,20,61,25,23,6,59,56,3', '', 20, 0, 0, 0, 0),
(78, 'Taurin Canyon C', 0, '2007-04-29', '1,18,20,40,20,40,59,20,35,31,20,41,37,20,39,34,20,55,39,53,20,61,3', 'Závod se jede velice rychle směrem dolů největším kaňonem v Galaxii na prašné planetě Taurin... tak si dejte bacha ať nepřepadnete dolů :oP ', 23, 0, 0, 0, 0),
(79, 'CLION', 0, '2007-05-01', '1,4,26,23,24,8,6,53,33,42,4,3', 'Těžká', 12, 2, 13, 0, 3),
(80, 'HARD', 0, '2007-05-01', '1,37,56,57,60,43,46,3', '', 8, 0, 0, 0, 0),
(81, 'Pískoviště po dešti', 51, '2007-05-01', '1,7,29,36,15,16,63,20,32,62,33,52,9,61,29,39,46,3', '', 18, 0, 4, 1, 4),
(82, 'Spice Mine Run', 0, '2007-05-03', '1,6,37,63,62,61,57,56,55,54,53,52,51,50,43,45,34,37,56,3', 'záleží na něm', 20, 0, 1, 0, 0),
(83, 'Sunken City', 0, '2007-05-03', '1,20,20,20,57,56,53,57,56,53,57,56,53,57,56,53,19,19,19,3', 'nezáleží na tom', 20, 0, 0, 0, 0),
(84, 'Kvalifikace CC_rychlost', 0, '2007-05-07', '1,4,18,19,4,59,6,58,9,42,44,20,25,21,41,44,3', '', 17, 1, 0, 0, 0),
(85, 'Kvalifikace CC_dovednost', 0, '2007-05-07', '1,37,57,61,56,37,56,53,35,31,62,48,37,3', '', 14, 1, 3, 1, 0),
(86, 'Head and sholders', 0, '2007-05-10', '1,8,28,24,40,18,40,34,26,54,22,20,19,28,26,39,26,3', '', 18, 1, 0, 0, 0),
(87, 'Dove', 0, '2007-05-11', '1,20,7,40,28,22,4,26,42,40,24,58,29,57,26,18,42,54,20,3', 'V boxech muzete vyzkouset vzorek zdarma dove ;)...', 20, 1, 2, 0, 1),
(88, 'Howler Gorge', 0, '2007-05-13', '1,4,21,57,5,27,24,63,62,61,20,35,36,55,4,37,37,37,51,56,36,52,31,26,6,53,57,26,21,3', 'kdo umí ten umí, kdo neumí ten čumí', 30, 0, 2, 0, 0),
(89, 'haribo', 0, '2007-05-14', '1,60,37,37,57,56,42,46,53,37,60,3', 'cestou ze zastavte ve stankach haribo ;)', 12, 0, 1, 1, 0),
(91, 'GuMa', 0, '2007-05-14', '1,18,40,24,59,16,26,40,52,20,31,51,25,52,3', '', 15, 0, 0, 1, 0),
(92, 'Taurin Canyon B', 0, '2007-05-15', '1,5,9,41,20,41,55,20,35,31,20,42,56,37,8,41,31,5,30,20,42,60,20,62,33,52,61,3', 'Trať Taurinského kaňonu s označením B je prodloužená varianta "Céčka". Je ale i oněco těžší - kamenitější :o)', 28, 0, 3, 1, 0),
(93, 'Mega GuMa', 0, '2007-05-15', '1,4,38,44,35,24,54,8,51,26,49,19,25,37,37,8,18,60,35,51,9,30,24,8,38,45,19,39,45,7,57,3', '', 32, 0, 0, 0, 0),
(94, 'Dug Derby', 0, '2007-05-16', '1,20,63,37,32,48,35,53,42,45,32,36,37,57,61,48,53,37,19,3', 'normální krátká trať (obtížná)', 20, 0, 0, 0, 0),
(95, 'MazeC', 0, '2007-05-16', '1,57,37,42,46,37,56,37,56,60,49,37,57,3', '', 14, 1, 0, 0, 0),
(96, 'Ficak', 0, '2007-05-16', '1,24,41,30,9,53,22,6,4,23,20,24,57,3', 'No proste lolec...', 14, 0, 0, 0, 0),
(97, 'Scrapper''s Run', 0, '2007-05-16', '1,58,4,29,39,25,37,37,18,28,8,3', 'Trat pro hmmmy...', 12, 0, 2, 0, 2),
(98, 'Salsa', 0, '2007-05-16', '1,37,53,60,35,4,55,38,49,42,45,62,57,61,24,28,60,23,41,47,43,46,48,24,53,20,56,37,37,37,56,3', 'Tale trať nese název po tanci, který je bezpochyb jedním z tanců které si užijete i když neumíte tancovat. A proč? Protože tenhle závod si užijete i když neumíte jezdit!', 32, 1, 2, 0, 1),
(99, 'Paso Doble', 969, '2007-05-16', '1,28,28,24,37,56,43,46,56,37,37,39,38,6,60,53,61,57,57,28,9,41,42,43,3', 'Jeho původ je ve Španělsku v lidových tancích oslavujících vítězného toreadora. Tanečník je toreador a tanec je býk. Toreador se snaží býka zkrotit, ale to jestli se mu to povede záleží jen na jeho zkuěenostech a odvaze...\r\n\r\nDokážete zkrotit tuhle trať, nebo trať zkrotí vás?', 25, 2, 1, 0, 1),
(100, 'Waltz', 0, '2007-05-16', '1,39,43,43,42,38,48,56,49,32,28,43,45,42,44,40,46,36,42,61,6,37,57,53,60,6,32,37,3', 'Páry se ve waltzu vznáší po parketu a to budete i vy na téhle trati... Je to téměř jeden velký skok. Radši si před tím dejte něco, co vám dá křídla...', 29, 1, 0, 0, 1),
(105, 'Samba', 0, '2007-05-19', '1,4,58,60,8,37,56,42,62,32,5,48,39,45,53,54,55,56,57,37,21,19,19,42,44,43,46,40,45,49,38,18,27,20,53,41,42,46,62,60,57,61,22,36,42,38,38,6,37,20,58,3', 'Samba je tanec pocházející z Brazílie.Pro tento tanec je typický tzv. sambový pohup a pohyby pánví.\r\nA jinak otmu nebude ani na téhle trati. velice rychlá ale plná pohupů. Rozhodně se zapotíte a dojedou jen ti nejlepší.', 52, 1, 5, 4, 3),
(102, 'route 66', 0, '2007-05-17', '1,4,28,24,42,62,59,31,38,44,7,8,6,41,55,22,21,23,14,16,4,3', 'pozor na casty vyskyt nekrokoal!!!', 22, 0, 3, 0, 1),
(103, 'HARD1', 0, '2007-05-18', '1,5,49,23,35,54,32,55,35,56,53,49,20,42,45,62,57,57,57,52,36,31,26,60,56,41,44,56,48,3', 'delší a obtížná trať', 30, 0, 0, 1, 0),
(106, 'Tango', 969, '2007-05-19', '1,4,5,6,7,8,9,18,19,20,58,59,60,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,44,41,46,42,45,43,47,49,48,50,51,52,53,37,56,55,56,57,61,62,63,56,56,37,37,37,37,56,56,30,6,9,60,43,45,49,38,19,18,20,20,43,48,42,44,28,32,24,37,49,24,39,6,4,62,63,61,57,57,57,56,6,28,33,18,20,20,43,3', 'Pochází z Argentiny, ale obsahuje i mnohé prvky kubánských a černošských tanců.\r\nVíc než sto let bylo tango pokládané za tanec "velmi hříšný" pro společenské sály, ale přesto se stalo velmi populárním.\r\nSnad se stane i tahle trať populární, rozhodně je dlouhá a obtížná.', 102, 0, 5, 0, 3),
(107, 'Quickstep', 969, '2007-05-20', '1,24,28,43,42,38,38,37,27,56,56,56,56,56,56,56,37,37,59,18,39,38,49,43,46,32,28,28,28,28,53,63,18,18,20,52,61,32,36,54,42,48,53,32,5,60,56,37,6,42,43,40,38,58,6,22,25,47,38,44,19,20,43,3', 'Je to rychlá forma foxtrotu a nejrychlejší standardní tanec.\r\npokud máte rádi Quickstepové figury jako jsou: čtvrtotáčky, letové figury a polkové poskoky a to vše ve velmi rychlém tempu, tak na téhle trati se budete cítit dobře.', 64, 1, 4, 2, 2),
(108, 'Zugga Challenge', 71, '2007-05-20', '1,56,37,56,37,56,37,56,37,56,37,56,37,56,37,56,37,56,37,56,37,56,37,56,37,56,37,56,37,3', 'mega hard', 30, 0, 3, 4, 0),
(109, 'Podracer Track', 969, '2007-05-20', '1,56,56,56,56,37,56,56,56,56,37,56,56,56,37,56,56,56,37,37,3', '', 21, 1, 4, 1, 0),
(110, 'Corusant Run', 969, '2007-05-20', '1,62,61,63,62,57,57,49,18,37,26,7,55,43,33,54,27,18,28,28,3', '', 21, 2, 2, 0, 1),
(111, 'Sandcrawler Track', 969, '2007-05-20', '1,18,24,25,33,38,38,46,36,4,37,47,62,61,57,19,28,43,48,56,53,37,33,60,3', '', 25, 0, 0, 0, 0),
(112, 'Sith Rally', 969, '2007-05-20', '1,32,36,32,36,32,36,32,36,32,36,32,36,56,32,36,3', '', 17, 2, 1, 0, 1),
(113, 'dual sabre', 969, '2007-05-20', '1,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,3', 'Opravdu náročná trať', 102, 1, 1, 1, 1),
(114, 'Super bagr', 0, '2007-05-21', '1,5,25,38,22,39,55,9,37,19,24,27,20,40,56,48,26,40,38,53,59,21,37,61,4,57,34,41,49,19,42,3', '', 32, 0, 1, 0, 1),
(115, 'Kyssi', 969, '2007-05-21', '1,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,37,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,54,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,3', 'Opravdu dlouhá trať na QSB.\r\nJe to opravdu pravá Clubová trať.\r\n\r\nNEUVĚŘITELNÝCH 1 000 ÚSEKŮ!!!!\r\n\r\nNeuvěřitelná piplačka to naklikat.\r\n\r\nENDŽOJ', 1002, 2, 26, 9, 3),
(116, 'Baroo Coast', 71, '2007-05-21', '1,48,36,56,53,37,32,57,57,57,37,48,53,55,9,36,37,56,36,56,37,5,37,37,37,37,37,57,61,57,61,36,32,36,32,56,55,56,55,48,37,37,37,36,53,56,37,37,56,3', 'good trať', 50, 2, 2, 1, 2),
(117, 'Bumpy''s Breakers', 969, '2007-05-21', '1,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,56,37,52,52,52,52,52,52,52,52,52,52,52,52,52,56,37,52,52,52,52,52,52,52,52,52,52,52,52,52,52,37,56,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,37,56,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,3', 'Další trať z dílny Kyssiho\r\nOpět velmi těžká\r\n\r\nENDŽOJ', 102, 1, 3, 4, 2),
(118, 'Executioner', 969, '2007-05-21', '1,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,3', 'trať, která je pouze částí noňak tratě', 32, 2, 4, 1, 1),
(119, 'Masarykuv okruh', 0, '2007-05-22', '1,18,25,48,20,24,62,6,59,39,34,6,4,53,56,4,37,39,19,29,42,18,4,3', 'Brnensky okruh!!!', 24, 1, 9, 2, 6),
(121, 'Zarabecka', 4, '2007-05-23', '1,21,59,57,24,4,4,53,3', 'Kratka trat pro zacinajici lidi', 9, 0, 2, 0, 4),
(123, 'FastRoute', 4, '2007-05-23', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,3', 'Široká cesta', 32, 2, 6, 3, 1),
(124, 'MiddleRoute', 4, '2007-05-23', '1,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,3', 'Úzká cesta', 32, 2, 3, 2, 2),
(125, 'LongRoute', 4, '2007-05-23', '1,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,37,24,3', 'Long Route jak ma byt!', 42, 2, 1, 5, 0),
(126, 'ExaRoute', 4, '2007-05-24', '1,4,38,43,23,4,4,37,37,37,37,59,60,59,58,20,4,38,42,49,38,44,62,4,5,6,5,4,49,26,4,35,35,9,51,50,57,56,56,56,53,54,53,53,5,6,6,19,18,19,19,37,37,37,37,37,37,59,28,59,8,62,37,53,48,57,57,62,63,21,4,4,4,4,7,58,35,59,19,47,50,38,44,9,33,34,50,53,53,38,40,53,56,38,45,39,62,52,52,8,37,37,37,37,37,52,53,32,9,60,36,20,58,59,52,38,46,20,60,50,59,30,36,58,37,37,37,50,24,5,32,59,20,59,53,37,53,37,53,35,27,51,29,52,26,59,35,36,37,37,21,3', 'Trat stvorena pro zavod!', 152, 2, 2, 0, 2),
(127, '112', 0, '2007-05-24', '1,5,37,5,37,24,35,57,19,32,8,32,56,9,31,57,7,58,55,25,31,27,52,27,18,32,8,8,31,9,36,26,35,18,18,31,26,19,55,47,38,42,58,19,54,9,55,5,8,29,26,29,7,18,8,8,27,28,28,24,24,19,50,9,30,24,53,8,24,54,5,55,28,23,5,33,13,16,51,28,9,9,55,50,5,56,6,9,8,7,57,6,26,26,7,58,59,60,25,55,30,8,28,52,58,55,32,9,30,58,28,53,37,3', '', 114, 0, 19, 3, 3),
(128, 'Sebulba''s Legacy', 71, '2007-05-24', '1,37,56,37,56,37,56,37,56,3', 'krátká těžká', 10, 0, 3, 5, 0),
(132, 'Holy', 0, '2007-05-25', '1,4,32,39,19,20,60,28,57,18,29,9,48,35,6,37,38,5,5,5,22,7,58,25,47,9,32,54,18,28,54,58,21,6,33,37,8,4,59,5,28,19,23,20,52,19,20,27,7,39,4,43,44,5,5,5,24,28,59,61,21,4,20,3', 'Trat neni prilis tezka.....ale hlavne jde o zabavu!!Holy', 64, 1, 6, 1, 1),
(156, 'Frajerska', 0, '2007-05-26', '1,56,36,32,37,37,60,42,46,49,57,27,27,37,43,3', '', 16, 0, 4, 1, 1),
(155, 'OnlyOneRace', 4, '2007-05-26', '1,37,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,37,37,37,37,37,37,37,37,37,53,3', 'OnlyOneRace', 152, 1, 3, 4, 3),
(159, 'Dračí stezka', 54, '2007-11-07', '1,20,20,20,20,20,20,20,20,20,20,50,50,51,51,52,52,52,51,51,50,50,37,37,37,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,20,18,18,42,46,18,18,18,18,18,42,45,18,18,18,18,18,42,44,20,20,20,20,20,20,20,20,20,20,20,20,37,37,37,3', 'Dračí stezka je trať která kombinuje rychlost a nebezpečí!! Na začátku krátký rozjezd z kopce a už se vjíždí do kaňonu. Po výjezdu z kaňonu opět rychlá jízda z kopce a poté skoky přes propasti. Na závěr už jen poslední sešup, serpentíny a cíl!', 75, 1, 7, 1, 0),
(160, 'rychlovka', 54, '2007-11-09', '1,20,19,20,19,20,19,20,19,20,19,20,3', '', 13, 2, 1, 1, 1),
(161, 'OSRoute', 4, '2007-11-10', '1,58,31,21,53,4,4,20,20,60,61,4,37,6,21,21,48,4,4,8,60,36,37,37,6,7,19,19,38,40,62,4,4,4,4,37,4,4,4,29,36,4,4,37,32,59,38,43,21,3', 'Zavod stvoreny mnou pro me. Kratky, neni zas tak moc tezky.', 50, 1, 7, 2, 3),
(162, 'Good Bye Lenin', 71, '2007-11-13', '1,6,27,20,20,41,45,5,19,37,20,56,57,19,19,19,37,53,47,37,49,23,25,24,26,21,52,37,37,35,4,3', 'Normální trať.', 32, 0, 7, 2, 2),
(163, 'Pomsta Goalda', 14, '2007-11-13', '1,18,40,38,56,52,55,38,37,37,27,23,37,18,42,61,3', 'Goald jménem Nyrty vytvořil tuto trať aby mohl Testovat Hoktary. Dokaž že jsi nadčlověk a dojeď první :-)', 17, 2, 3, 1, 0),
(164, 'Dračí steztička', 54, '2007-11-13', '1,20,51,20,42,45,20,48,20,20,37,3', 'Na přání jsem vyrobil trať pro moje závody pro začátečníky.', 12, 0, 1, 1, 3),
(165, 'warixuv usek pro zacatecniky', 125, '2007-11-14', '1,19,20,21,18,58,3', '', 7, 0, 1, 1, 1),
(166, 'Maly okruh', 87, '2007-11-16', '1,7,9,31,42,46,18,19,60,20,25,37,18,19,20,18,18,53,48,57,57,3', 'Maly, stredne tezky okruh.', 22, 0, 6, 0, 1),
(167, 'turnament number1', 76, '2007-11-16', '1,19,34,30,6,53,59,53,18,23,27,42,28,24,9,8,7,37,37,57,5,25,21,62,7,40,24,28,5,7,5,58,28,24,54,54,23,27,18,21,25,37,58,20,3', '', 45, 1, 3, 1, 2),
(168, 'rovinka', 12, '2007-11-20', '1,5,5,5,5,5,3', 'proste rovna cesta urcena pro muj vlastne vytvoreny pohar', 7, 2, 0, 0, 0),
(169, 'rovinka2', 12, '2007-11-20', '1,60,60,60,60,60,3', 'proste rovna cesta urcena pro muj vlastne vytvoreny pohar', 7, 2, 0, 0, 0),
(170, 'rovinka3', 12, '2007-11-20', '1,4,4,60,57,5,3', 'proste rovna cesta urcena pro muj vlastne vytvoreny pohar', 7, 2, 0, 1, 0),
(171, 'zatacky', 12, '2007-11-20', '1,63,63,63,63,63,3', 'proste rovna cesta urcena pro muj vlastne vytvoreny pohar', 7, 2, 1, 1, 0),
(172, 'zatacky2', 12, '2007-11-20', '1,43,45,43,45,63,3', 'proste rovna cesta urcena pro muj vlastne vytvoreny pohar', 7, 2, 0, 1, 0),
(173, 'Nejrychlejsi rovinka', 23, '2007-11-25', '1,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,3', 'Trat kde se zjisti kdo je nejrychlejsi !!!!!', 32, 2, 1, 6, 2),
(174, 'ZPM', 14, '2007-11-27', '1,38,40,38,40,43,5,4,4,38,55,53,55,42,48,49,52,63,43,38,32,24,24,24,28,37,48,40,38,40,38,52,63,3', 'ZPM - Budeš ho potřebovat :-)', 34, 2, 4, 0, 4),
(175, 'Rok Ďábla', 71, '2007-11-28', '1,25,32,18,18,6,57,49,49,36,31,19,61,62,63,20,57,5,57,57,57,57,57,28,56,62,55,6,62,61,62,61,62,61,48,63,21,9,57,57,47,49,57,57,57,57,48,53,53,54,53,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,60,34,25,29,63,61,62,63,52,50,51,57,57,57,55,56,56,57,56,63,63,63,63,63,63,56,57,37,22,26,57,61,3', 'Trať na planetě s velkým počtem jezer a lesů.', 100, 0, 4, 0, 0),
(176, 'Madura', 71, '2007-11-28', '1,36,37,32,55,41,37,37,38,43,44,35,37,37,37,48,56,53,37,54,55,56,56,56,37,48,20,42,46,3', 'velmi těžký závod (ale na Kyssiho nemám)', 30, 0, 2, 0, 0),
(177, 'Hell', 71, '2007-11-28', '1,9,9,9,9,9,43,46,36,32,49,49,49,38,37,37,37,56,37,37,37,56,37,37,37,56,37,37,37,56,8,60,7,43,46,49,37,37,37,56,37,37,37,56,37,37,37,31,9,3', 'Závod v pekle!', 50, 0, 2, 1, 1),
(178, 'Cobra_Racing', 165, '2007-11-28', '1,19,27,49,20,42,46,23,8,57,7,32,61,19,58,37,4,27,38,52,43,53,31,60,25,4,4,57,57,20,42,3', '', 32, 1, 6, 0, 2),
(179, 'Longhard', 71, '2007-11-30', '1,6,36,32,20,37,36,32,37,36,32,56,53,53,53,57,37,20,20,20,5,43,46,38,48,49,53,53,52,36,32,24,37,36,32,49,37,36,32,52,49,37,36,32,56,62,62,62,61,62,62,62,30,36,37,32,56,53,57,57,57,56,36,37,37,37,20,60,20,9,20,43,46,26,52,52,52,41,45,37,37,6,35,33,31,29,37,56,37,36,36,37,57,57,57,35,37,60,63,3', 'Hodně zajímavá ,ale dost obyčejná trať. :D', 100, 0, 10, 5, 5),
(180, 'krata', 70, '2007-12-01', '1,57,55,48,38,52,61,49,37,37,37,3', '', 12, 2, 2, 0, 1),
(181, 'Antikové', 14, '2007-12-05', '1,4,4,4,4,5,6,7,8,9,18,19,20,58,59,60,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,40,46,40,47,48,49,50,51,52,53,54,55,56,57,61,62,63,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,5,6,7,8,9,18,19,20,58,59,60,21,22,23,24,25,26,27,27,28,29,30,31,28,3', 'Najdi Wraiha', 102, 2, 4, 0, 3),
(182, 'Studie', 14, '2007-12-05', '1,4,4,6,9,18,6,18,58,18,7,60,6,8,8,4,4,9,6,8,9,24,28,32,32,27,31,32,22,23,25,21,28,28,30,24,21,32,21,21,22,36,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,49,38,40,45,40,42,57,55,63,47,43,55,49,49,49,49,39,44,42,40,43,38,54,61,51,43,49,43,40,54,43,41,41,40,41,56,62,51,50,52,5,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,22,24,24,27,29,33,36,28,24,32,33,33,34,32,29,31,37,37,37,37,37,37,37,37,37,37,37,37,37,37,56,39,40,56,61,62,41,38,51,42,51,52,52,49,40,40,51,51,52,51,51,39,39,44,62,52,42,41,42,61,52,51,50,53,43,38,4,4,37,55,3', '', 202, 0, 3, 1, 1),
(183, 'Rattle_snake Racing', 165, '2007-12-07', '1,4,4,37,37,57,31,60,20,42,46,27,23,9,56,37,61,63,29,20,58,52,52,55,34,60,43,36,32,37,42,3', '', 32, 0, 2, 0, 1),
(184, 'iRT Quick', 8, '2007-12-09', '1,4,3', 'Nejkratší trať v dějinách! iRT Vám přeje GL.\r\n\r\nNa trati zahynul při stavbě přiměřený počet rebelů.', 3, 0, 0, 3, 0),
(185, 'Mamba_Racing', 165, '2007-12-10', '1,21,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,25,3', 'jó, moje nejrychlejší trať', 32, 2, 2, 1, 0),
(186, 'Nová_trať', 225, '2007-12-11', '1,5,33,39,36,5,19,3', '', 8, 0, 0, 2, 0),
(187, '666', 225, '2007-12-11', '1,59,21,57,55,35,31,40,63,24,53,25,41,48,28,37,41,45,28,20,60,3', '', 22, 2, 0, 1, 2),
(188, 'Eldaron', 225, '2007-12-12', '1,23,35,35,57,56,41,62,42,46,27,53,37,40,48,31,35,3', '', 18, 2, 1, 1, 1),
(189, 'Boiga_Racing', 165, '2007-12-13', '1,37,37,37,37,37,37,37,37,37,56,37,37,37,37,37,37,37,37,37,56,37,37,37,37,37,37,37,37,37,56,37,37,37,37,37,37,37,37,37,56,37,37,37,37,37,37,37,37,37,57,3', '', 52, 2, 3, 2, 1),
(190, 'Anakonda_Racing', 165, '2007-12-21', '1,37,37,37,37,37,37,56,56,56,56,56,56,37,37,37,37,37,37,4,4,42,46,4,4,42,46,4,4,20,37,3', '', 32, 2, 1, 0, 1),
(191, 'galactik final cup', 269, '2007-12-21', '1,4,4,4,4,4,4,4,4,4,4,4,43,42,4,4,4,4,4,4,4,4,4,4,4,4,3', '', 27, 1, 1, 0, 1),
(192, 'ANO', 63, '2007-12-21', '1,4,18,58,43,36,32,37,19,18,20,9,37,53,56,4,4,4,61,57,60,43,59,48,4,19,19,49,20,20,20,3', '', 32, 1, 0, 1, 2),
(193, 'Řečanskej okruh', 252, '2007-12-22', '1,60,26,22,4,35,4,57,7,34,18,31,6,61,53,55,4,4,4,4,43,3', '', 22, 1, 0, 0, 1),
(194, 'Okruh TG Masaryka', 165, '2007-12-24', '1,18,27,21,18,23,27,18,27,28,23,18,23,27,18,18,27,18,18,24,28,18,18,24,28,18,18,18,3', 'Pro fandy rychlosti a klasiky vám přinášíme pravou repliku Masarykova okruhu v Brně.', 29, 1, 7, 0, 3),
(195, 'DRAGONS', 286, '2007-12-27', '1,4,21,16,20,26,3', 'Lehka trat s mírními zatackami', 7, 0, 0, 0, 0),
(196, 'Řečanskej okruh 2', 252, '2007-12-27', '1,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,63,3', '', 52, 1, 3, 0, 1),
(197, 'Dunevilské okruhy', 274, '2007-12-28', '1,4,4,4,5,5,5,6,6,6,40,4,4,4,42,4,4,42,5,5,6,6,7,7,42,58,3', 'Účastněte se rychlostních závodů :-)', 27, 2, 1, 0, 2),
(198, 'Lenííískovi cesty', 159, '2007-12-28', '1,4,36,35,29,48,22,29,53,7,35,57,38,46,38,28,51,30,28,50,20,5,31,22,56,8,33,9,28,56,34,29,55,18,33,20,34,48,26,19,33,54,38,45,38,29,58,35,5,31,36,35,16,53,33,7,56,31,6,55,6,25,34,29,18,5,60,7,35,57,58,56,19,35,26,19,20,20,7,38,45,28,32,28,43,42,6,30,37,38,44,25,31,33,18,52,53,39,52,31,33,9,8,19,52,32,32,27,52,28,9,59,7,8,19,20,20,60,9,8,28,30,37,31,53,3', '', 126, 1, 7, 2, 1),
(199, 'Řečanskej okruh 3', 252, '2007-12-28', '1,4,4,4,57,18,6,35,61,4,19,36,47,37,4,4,4,63,8,28,24,34,4,4,4,4,54,54,23,27,4,3', '', 32, 2, 0, 1, 0),
(200, 'Dunevilské okruhy_freestylová trať', 274, '2007-12-29', '1,43,63,57,40,54,20,42,57,57,57,57,24,28,6,40,4,42,45,9,22,28,18,24,23,37,37,36,8,40,56,56,56,57,57,57,57,56,42,46,49,9,49,49,49,17,37,37,37,41,57,7,8,24,24,28,37,37,42,46,57,3', 'Tak tady je docela nebezpečno, nic pro slabé povahy.', 62, 1, 2, 1, 1),
(201, 'Grabvine Gateway', 11, '2007-12-30', '1,24,8,19,38,30,50,42,46,43,58,25,30,49,8,18,28,17,43,45,25,34,37,7,36,52,52,61,56,61,43,3', '', 32, 2, 2, 0, 0),
(202, 'Řečanskej okruh 4', 252, '2008-01-06', '1,5,5,5,5,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,4,5,6,23,27,24,4,18,60,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,22,26,23,27,37,37,37,37,22,27,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,28,26,21,24,28,37,37,4,4,24,4,3', '', 152, 2, 4, 4, 0),
(203, 'Masarykuv okruh_MEGA VERZE', 165, '2008-01-10', '1,18,18,18,18,25,25,25,25,26,18,21,18,18,18,18,18,18,18,18,18,22,22,18,26,26,18,18,18,18,18,18,18,18,18,26,26,18,18,26,25,18,22,22,18,18,18,18,22,21,18,26,26,25,18,18,18,18,18,18,18,18,18,18,26,26,25,18,18,18,18,18,22,21,26,25,18,18,18,18,18,18,18,18,18,18,18,22,21,18,26,26,26,25,18,18,18,18,18,18,18,3', 'MEGA verze mího dřívějšího výtvoru.\r\nMasarykův okruh v poměru 1:1!!!!!', 102, 1, 8, 1, 2),
(204, 'smrtonostná trat', 331, '2008-01-10', '1,43,4,57,52,3', '', 6, 1, 0, 1, 0),
(205, 'Trat sezony 2008', 290, '2008-01-10', '1,18,18,18,18,59,23,19,20,18,18,20,18,42,4,34,60,18,18,63,4,18,57,6,18,3', 'Obyčejná trať na vydělání. ', 26, 0, 0, 1, 0),
(206, 'Pouštní rostlina kaktus', 241, '2008-01-13', '1,19,34,18,29,19,31,58,28,19,29,19,30,59,32,19,29,20,28,19,26,9,33,9,20,27,27,19,58,18,27,9,31,18,18,27,18,28,9,9,28,9,7,19,20,27,18,32,8,9,30,9,30,18,9,28,18,31,18,18,31,8,28,8,7,29,18,28,8,8,27,9,7,31,18,28,19,32,18,31,19,29,9,29,9,25,9,30,9,8,29,18,28,9,8,29,18,30,15,16,3', 'vyrovnaná trať', 101, 1, 7, 1, 1),
(207, 'kaktus 99', 241, '2008-01-14', '1,60,26,18,29,59,18,31,18,27,18,18,30,58,31,9,29,19,33,20,31,9,31,19,35,6,35,59,19,28,8,33,9,28,19,28,9,28,60,37,60,37,59,37,60,36,60,37,60,60,37,60,60,37,37,37,60,37,60,37,60,37,36,60,9,60,35,60,37,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,60,60,37,37,37,37,3', 'trať pro závody kaktus pro všechny', 99, 2, 5, 1, 1),
(208, 'fungus', 174, '2008-01-15', '1,8,17,40,24,58,41,49,26,43,9,29,34,3', 'mirna trat s obcasnými výpadky tratě', 14, 0, 2, 0, 3),
(209, 'speedy25', 362, '2008-01-17', '1,5,21,26,3', 'hodně rychlá trať s mírnými zatáčkami', 5, 0, 1, 0, 0),
(210, 'Trat pro mastery', 328, '2008-01-18', '1,6,61,37,35,37,60,3', 'TO NEDATE', 8, 2, 0, 0, 0),
(211, 'Trat pro mastery2', 328, '2008-01-18', '1,49,36,27,23,30,7,36,61,56,56,53,37,53,37,60,3', 'TO NEDATE JESTE VIC', 17, 2, 1, 2, 0),
(212, 'slavná 32', 370, '2008-01-19', '1,4,37,60,42,5,35,9,3', 'trat vede vsemi ruznymi svety', 9, 1, 0, 0, 0),
(213, 'Zelena mile Orppheus', 392, '2008-01-24', '1,4,5,6,25,26,5,60,20,26,28,6,4,18,32,26,33,5,31,8,9,29,4,18,36,4,37,37,4,26,4,26,4,3', '', 32, 0, 5, 1, 2),
(214, 'Nakouslá mandarinka', 51, '2008-01-24', '1,4,4,21,22,23,61,27,26,25,42,45,38,20,20,59,37,57,23,27,61,7,8,9,54,55,56,8,32,32,4,3', '', 30, 1, 2, 0, 1),
(215, 'Cyrkus Maximus', 165, '2008-01-25', '1,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,18,26,26,18,18,18,18,18,18,18,18,18,3', 'Kdo zná Cyrkus Maximus pochopí. Kdo ne, doufám, že si i přesto rád zazávodí ve starořímském stylu. ', 100, 1, 2, 3, 0),
(216, 'Andobi Mountain Run', 392, '2008-01-26', '1,4,18,37,37,37,19,18,20,27,4,3', '', 10, 2, 3, 1, 5),
(217, 'Okruh SnakeWorm', 274, '2008-01-27', '1,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,3', '', 20, 2, 2, 1, 1),
(218, 'danilsroute', 15, '2008-02-22', '1,27,32,49,56,48,49,50,51,52,53,54,56,37,37,37,35,35,31,31,49,55,9,9,9,60,60,60,6,37,37,37,37,9,9,19,20,56,56,36,32,37,9,9,9,35,35,37,37,37,37,52,52,49,32,32,36,37,60,9,7,58,9,35,31,37,52,52,55,56,51,6,9,5,5,8,30,35,35,37,31,49,55,55,20,36,9,37,53,53,35,35,9,35,49,37,37,37,37,37,37,37,35,36,34,30,31,36,49,52,37,37,37,9,9,7,55,56,49,37,26,36,9,9,29,35,37,9,56,56,56,37,23,35,37,56,52,37,60,6,19,27,37,8,27,37,60,56,56,37,33,3', '', 150, 2, 14, 2, 1),
(219, 'The Dart Speedline', 435, '2008-02-27', '1,19,6,25,23,4,37,49,42,20,60,37,4,28,20,35,3', '', 15, 1, 2, 3, 0),
(220, 'Dethro''s Revenge', 454, '2008-03-02', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,3', '', 20, 0, 3, 2, 0),
(221, 'FiRe HiLl', 510, '2008-03-04', '1,29,34,31,36,52,56,43,33,30,35,32,56,57,60,29,34,31,36,52,56,33,30,35,32,52,36,36,32,60,43,3', '', 30, 0, 5, 1, 2),
(222, 'CorrIsant', 520, '2008-03-06', '1,5,59,5,24,28,25,21,23,60,27,60,24,5,8,20,27,6,6,27,19,24,24,5,4,38,6,58,5,5,24,24,19,24,24,59,20,4,4,25,21,4,38,28,28,19,28,28,6,40,21,3', '', 50, 1, 0, 1, 0),
(223, 'METAL FOREST', 520, '2008-03-09', '1,38,60,49,60,34,30,35,19,19,31,6,20,33,33,33,8,8,31,56,5,5,34,37,57,37,57,62,57,62,57,38,37,57,55,9,29,29,9,56,61,57,37,57,38,57,38,57,7,33,59,3', '', 50, 1, 5, 1, 3),
(224, 'Highway to hell', 528, '2008-03-09', '1,4,5,6,29,25,8,20,40,48,23,57,62,55,26,23,34,19,18,20,20,41,48,53,59,3', '', 24, 0, 1, 1, 2),
(225, 'LuXus Fly', 520, '2008-03-11', '1,58,59,24,37,28,37,5,23,23,18,28,37,24,5,5,55,6,28,37,24,58,23,23,24,20,24,5,19,21,5,55,6,28,37,37,28,27,19,60,25,60,54,20,24,37,37,28,5,24,37,56,5,55,6,23,3', '...na balkóně nad startovními pozicemi přistoupila osoba ve velice drahém oblečení, a s radostnou tváří promluvila do mikrofonu: \r\n"Děkuji Všem tvorům z celé galaxie, kteří se přijeli podílet nebo pouze podívat na velmi oblíbené závody kluzáků! Jsem velice rád že jsem vystavěl tuto trať přímo pod okny své oblíbené výletní vily, protože je ozdobou naší společnosti D Relly ...i naší Hip Hop stáje. Přeji Vám aby jste si užili mnoho adrenalinu a zažili krásné chvilky nejen na této trati, ale i na dalších uměleckých dílech Dredrigera Kaie ...a teď už závodníci! Zažehněte motory !!!" ', 55, 0, 4, 0, 2),
(226, 'Taurin Canyon Gold', 520, '2008-03-12', '1,5,59,8,20,34,20,60,55,34,9,31,20,20,36,20,32,55,35,31,20,60,20,20,42,45,55,37,37,37,56,41,45,59,32,9,55,20,20,20,31,35,56,20,20,9,20,20,62,54,62,3', 'Zlatý úsek Taurinského kaňonu spol. D Relly ...jede se jen dolů, dolů a dolů... až k jezírku :o) ', 50, 0, 1, 0, 0),
(227, 'Mirab track', 528, '2008-03-13', '1,58,59,60,19,15,16,20,42,45,5,20,37,28,37,24,18,18,18,38,46,59,56,52,55,57,62,57,37,37,32,36,18,20,42,46,38,3', '', 36, 1, 1, 0, 0),
(228, 'The Sky Flyers', 435, '2008-03-19', '1,20,60,49,27,37,23,20,57,49,18,21,4,31,53,37,25,31,55,60,28,6,19,37,19,23,6,20,20,58,27,24,21,35,37,49,25,6,58,37,28,37,23,27,24,28,37,52,20,9,35,3', '', 50, 1, 1, 0, 0),
(229, 'Kanes', 615, '2008-03-24', '1,4,25,5,39,4,22,59,28,16,4,3', '', 10, 0, 0, 0, 0),
(230, 'WiWa track', 528, '2008-03-27', '1,58,59,59,60,37,37,37,37,35,30,34,30,56,57,57,61,62,63,41,45,54,50,51,52,56,4,4,4,4,4,4,32,36,36,31,37,37,37,37,56,57,57,38,41,45,4,4,4,4,4,37,37,37,37,48,48,42,46,4,37,37,20,20,20,42,46,3', '', 66, 0, 2, 0, 0),
(231, 'highway', 528, '2008-03-28', '1,4,4,4,5,42,45,53,56,36,37,37,37,37,32,49,57,20,20,20,20,38,46,19,19,19,37,36,37,36,56,52,42,63,18,18,18,35,31,37,37,37,37,36,56,36,20,20,26,30,20,42,46,3', '', 52, 2, 2, 0, 0),
(232, 'Snake track', 501, '2008-03-31', '1,4,18,24,28,25,21,9,4,23,27,18,40,5,28,24,4,20,21,25,18,3', '', 20, 0, 0, 0, 0),
(233, 'Serpentine track', 501, '2008-03-31', '1,5,19,28,24,28,24,4,6,25,21,29,33,5,18,20,27,23,40,18,6,26,22,5,18,41,5,26,23,38,18,3', '', 30, 1, 1, 0, 1),
(234, 'Star danger track', 479, '2008-03-31', '1,6,24,28,49,50,37,37,52,53,54,56,37,37,37,9,60,18,19,20,56,54,36,36,37,37,9,6,31,35,47,52,37,37,28,24,37,32,32,6,20,29,33,37,53,36,32,9,53,54,28,24,37,53,54,38,44,6,43,31,35,6,60,28,24,38,41,37,37,60,56,56,5,57,37,32,36,29,33,57,28,24,37,37,53,54,52,52,26,24,60,60,32,36,5,37,37,20,6,38,41,52,52,52,18,32,36,24,28,4,60,29,36,5,43,20,56,56,32,32,36,36,49,52,6,43,60,32,36,38,54,24,36,6,37,37,37,37,32,36,9,37,52,52,32,36,6,52,52,27,23,3', '', 150, 2, 7, 0, 2),
(235, 'předváděcí okruh', 528, '2008-03-31', '1,4,4,4,4,32,37,37,32,58,58,58,58,32,35,37,37,19,19,19,19,19,19,56,52,52,52,52,56,20,20,20,20,42,46,61,37,37,32,18,18,18,20,42,46,3', '', 44, 2, 2, 3, 0),
(236, 'Mania track', 482, '2008-03-31', '1,27,28,29,30,37,37,24,28,39,32,36,24,52,52,37,37,37,6,34,36,32,31,25,33,5,3', '', 25, 1, 0, 1, 1),
(237, 'Serpentine race', 479, '2008-04-01', '1,23,27,32,36,37,37,37,60,9,52,52,24,28,6,31,35,32,36,37,37,19,20,37,37,52,52,60,20,36,32,24,28,32,36,52,52,35,31,6,60,37,37,32,36,37,37,5,27,37,20,3', '', 50, 2, 1, 0, 0),
(238, 'Speed race', 564, '2008-04-01', '1,6,37,37,32,36,37,37,52,52,20,42,49,31,35,32,36,37,37,37,37,52,52,60,6,36,32,37,37,36,6,58,31,35,53,54,36,32,6,37,29,36,35,31,36,32,52,6,37,37,6,3', '', 50, 1, 0, 0, 0),
(239, 'Perfect track', 564, '2008-04-01', '1,31,35,24,28,52,6,60,37,37,37,32,36,18,20,43,48,31,35,36,32,37,37,37,60,42,32,36,19,55,57,29,33,37,37,37,6,39,52,52,52,32,36,20,54,37,3', '', 45, 1, 0, 0, 0),
(241, 'Faster than never', 501, '2008-04-01', '1,5,29,32,33,37,37,52,52,32,36,18,41,19,31,35,42,38,46,56,54,49,23,27,60,37,37,32,36,52,20,3', '', 30, 0, 0, 1, 0),
(242, 'Master track', 501, '2008-04-01', '1,32,36,52,37,52,32,36,37,9,43,37,52,61,32,36,37,56,37,42,52,60,32,36,37,38,46,37,52,32,36,48,37,57,37,36,32,55,37,56,52,32,36,38,46,60,38,46,52,37,9,40,52,37,41,37,32,36,60,38,46,36,32,52,37,9,3', '', 65, 2, 0, 0, 0),
(243, 'Amazon track', 564, '2008-04-02', '1,18,9,32,33,33,60,55,42,49,37,32,36,6,30,60,29,43,39,63,57,24,6,37,52,42,3', '', 25, 0, 0, 1, 0),
(244, 'The Masters Circuit', 564, '2008-04-06', '1,33,26,20,22,27,29,6,58,30,52,3', '', 10, 0, 2, 1, 2),
(245, 'Dragon track', 564, '2008-04-07', '1,35,36,32,52,52,60,35,31,60,32,36,41,49,20,37,3', '', 15, 1, 1, 0, 0),
(246, 'Blackdeath kanon', 564, '2008-04-07', '1,52,52,52,52,52,52,52,52,37,37,37,37,32,36,37,52,52,32,36,6,3', '', 20, 2, 0, 0, 1),
(247, 'Death circuit', 564, '2008-04-07', '1,32,36,36,32,60,52,37,32,36,37,56,32,36,52,52,32,36,60,52,37,37,36,32,52,20,3', '', 25, 1, 0, 0, 0),
(248, 'Damager track', 564, '2008-04-07', '1,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,52,32,36,37,36,32,37,32,36,37,52,3', '', 50, 2, 2, 2, 1),
(249, 'timbaland racing', 338, '2008-04-18', '1,16,25,24,37,25,22,28,38,45,23,3', '', 10, 2, 0, 0, 1),
(250, 'Lopingy', 356, '2008-04-25', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,3', 'trať ze které se nikdo nikdy nevrátil, trať která láme rekordy v obtížnosti, trať která je oceněna titulem nejobtížnejší trať ve vesmíru a vy ji pojedete', 150, 2, 4, 3, 2),
(251, 'Tour de Star Wars', 663, '2008-05-13', '1,4,4,4,4,4,4,4,5,6,9,9,8,7,20,20,19,19,18,33,26,27,28,21,22,23,24,4,4,40,5,3', '', 30, 1, 3, 1, 5),
(252, 'galastic tour', 693, '2008-05-28', '1,6,31,34,5,20,29,52,9,8,19,55,58,19,54,58,18,24,51,56,9,3', '', 20, 0, 0, 1, 0),
(253, 'pro galactic tour', 693, '2008-06-03', '1,8,37,51,20,34,8,63,37,37,37,37,8,61,54,34,8,20,20,36,27,23,5,33,29,61,20,37,31,58,37,18,59,29,37,34,27,34,19,57,57,57,18,27,9,60,37,37,37,23,20,3', '', 50, 1, 4, 3, 3),
(254, 'Supersonic_Route', 763, '2008-06-24', '1,5,28,42,50,25,7,27,18,38,49,18,24,27,57,20,42,3', '', 16, 1, 1, 0, 0),
(257, 'Jízda smrti', 812, '2008-07-31', '1,9,38,46,32,9,32,9,32,19,43,20,56,60,57,9,53,3', 'pro závodníky', 16, 1, 2, 0, 0),
(255, 'Jen pro odvazne01', 7, '2008-07-27', '1,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,23,27,23,27,23,27,23,27,23,27,37,37,37,37,37,37,37,37,37,37,31,35,31,35,31,35,31,35,31,35,3', '', 50, 2, 0, 0, 0),
(256, 'Jen pro odvazne02', 7, '2008-07-27', '1,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,3', '', 50, 2, 0, 0, 0),
(258, 'Leth Taaro', 860, '2008-08-22', '1,4,32,7,57,57,14,16,9,37,28,42,62,8,29,34,40,44,7,8,7,3', 'Let them taste a rock!', 20, 1, 6, 3, 0),
(259, 'Královedvorský okruh', 116, '2008-08-23', '1,4,28,24,25,24,25,28,24,19,37,8,24,20,28,24,20,58,20,20,20,3', '', 20, 0, 1, 1, 0),
(260, 'rok 2020', 812, '2008-08-29', '1,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,56,39,56,6,60,49,38,46,57,56,43,45,56,6,6,6,6,9,9,9,9,9,49,49,49,41,44,15,16,9,37,40,3', 'co nejrychleji prosfystet', 50, 0, 1, 0, 0),
(261, 'danilsova rovinka', 15, '2008-08-31', '1,4,7,4,21,5,5,18,19,25,4,3', '', 10, 0, 2, 0, 1),
(262, 'Fire Mountain Rally', 864, '2008-08-31', '1,4,4,59,59,29,57,33,6,6,24,28,37,37,37,6,6,18,9,32,37,37,9,24,60,21,62,62,62,62,4,4,35,56,57,57,57,19,59,20,61,61,5,5,5,26,5,22,59,20,62,62,62,20,62,62,4,4,4,4,4,3', 'Trať no xD', 60, 0, 2, 2, 1),
(263, 'The Boonta Classic', 864, '2008-08-31', '1,5,5,60,60,31,57,35,6,6,24,28,37,37,37,6,6,18,9,32,37,37,9,24,60,23,63,63,63,63,6,6,35,56,57,57,57,19,60,20,63,63,6,6,6,27,6,23,60,20,63,63,63,20,63,63,6,6,6,6,6,3', '000 Track, ovšem v těžším vydání :)', 60, 0, 1, 0, 0),
(264, 'Ando Prime Centrum', 812, '2008-08-31', '1,4,4,4,4,4,4,4,4,4,4,3', 'mas dost rychle zrychleni ???', 10, 0, 2, 4, 0),
(265, 'Inferno', 812, '2008-08-31', '1,56,56,56,56,56,56,56,56,56,56,3', '', 10, 0, 1, 1, 0),
(266, 'Lose yourself', 864, '2008-09-11', '1,18,23,18,27,5,60,18,41,26,19,22,4,4,5,24,26,59,41,9,29,5,7,24,28,9,38,4,6,37,58,20,28,40,21,4,5,30,27,5,5,6,22,5,41,62,37,4,22,4,5,3', '', 50, 0, 6, 0, 1),
(267, 'Pro Track', 864, '2008-09-11', '1,4,27,21,6,5,41,5,37,24,6,22,35,5,18,62,21,57,4,24,4,28,32,58,22,19,40,28,4,5,6,18,25,6,5,30,41,25,60,20,36,8,5,59,5,18,5,18,7,58,5,3', 'Trať pro opravdové závodníky? Jsi závodník? Tak si pojď zajeď tuto trať!!!', 50, 0, 3, 0, 1),
(268, 'AX83', 864, '2008-09-11', '1,18,8,22,33,42,5,60,27,19,56,5,28,18,41,37,4,6,58,8,23,13,16,5,4,35,47,5,6,60,41,24,5,4,22,57,15,16,22,39,18,19,38,45,59,5,18,37,22,5,18,3', 'AX83? Neznáš? Poznáš.', 50, 1, 7, 1, 2),
(269, 'Not Hard', 864, '2008-09-11', '1,5,6,22,4,59,21,5,23,27,18,60,28,5,34,5,21,18,18,19,59,28,5,20,23,5,6,9,37,23,5,5,60,19,31,43,22,60,6,5,5,18,20,59,37,59,6,31,5,19,5,3', '', 50, 1, 2, 0, 0),
(270, 'SWG', 864, '2008-09-11', '1,5,22,5,27,34,19,59,60,18,27,23,5,5,62,37,5,6,60,42,14,16,4,33,5,33,31,5,19,60,18,28,23,31,5,7,13,16,18,35,43,59,5,18,20,19,8,28,18,5,4,3', 'So what, nigga?! :-P', 50, 1, 3, 0, 1),
(271, 'Zero Track', 864, '2008-09-11', '1,5,21,5,28,24,4,5,26,18,19,60,20,59,25,62,37,5,23,18,5,26,7,14,16,38,45,36,18,4,60,25,38,46,5,20,60,19,59,28,5,23,57,37,7,5,21,5,5,25,18,3', '0? :-O', 50, 2, 5, 0, 1),
(272, 'Abyss', 864, '2008-09-11', '1,4,23,60,18,19,33,18,19,62,4,57,24,4,28,5,22,59,20,59,38,45,43,5,21,20,13,16,5,28,5,40,24,4,15,16,6,39,5,5,19,9,20,58,18,14,16,5,6,18,18,3', '', 50, 0, 3, 0, 2),
(273, 'XTREME', 864, '2008-09-11', '1,5,23,18,59,8,24,6,26,4,42,58,5,28,5,37,6,40,5,19,59,60,4,23,4,31,5,22,37,42,4,13,16,21,5,4,23,35,5,4,7,18,60,19,37,24,5,18,13,16,18,3', 'XTREME TRACK!!!', 50, 1, 7, 0, 2),
(274, 'Track NO1', 864, '2008-09-11', '1,5,23,4,31,13,16,4,8,59,19,20,24,4,37,5,22,28,4,33,4,5,35,39,6,59,28,5,43,37,4,26,18,35,4,7,21,5,18,18,36,38,45,4,22,40,29,4,5,18,18,3', '', 50, 0, 2, 0, 1),
(275, 'The End', 864, '2008-09-11', '1,6,7,22,60,19,60,24,40,6,4,31,59,5,4,18,20,59,24,4,29,9,38,46,37,5,24,5,7,4,59,60,27,4,33,5,31,6,55,58,52,5,5,7,6,29,4,35,43,5,18,3', 'Konec!!', 50, 2, 4, 1, 1),
(276, 'Twister', 956, '2008-09-13', '1,4,4,42,46,24,28,24,28,6,9,4,60,59,37,37,42,56,43,4,4,42,46,42,4,6,9,9,4,4,42,3', '', 30, 1, 3, 1, 0),
(277, 'The Gauntlet', 15, '2008-09-26', '1,4,18,8,29,23,18,25,36,6,6,4,19,19,20,59,54,9,5,5,18,18,37,28,5,8,59,58,5,9,22,25,36,22,6,18,19,7,19,37,26,22,29,5,6,18,18,4,4,4,18,3', '', 50, 1, 1, 1, 0),
(278, 'Mos Espa Open', 957, '2008-09-27', '1,4,19,20,58,5,25,22,6,5,4,4,3', '', 11, 0, 0, 0, 1),
(279, 'OTrack', 864, '2008-10-04', '1,6,24,5,49,60,35,47,4,37,21,19,31,56,26,27,18,27,40,52,5,3', '', 20, 0, 2, 1, 0),
(280, 'SoroSuub Facility', 812, '2008-10-06', '1,4,4,4,4,4,4,4,4,4,4,3', '', 10, 0, 1, 1, 0),
(281, 'Rol la Bonsai  3 kola', 51, '2008-10-09', '1,4,4,19,57,21,23,20,53,53,24,21,4,4,19,57,21,23,20,53,53,24,21,4,4,19,57,21,23,20,53,53,24,21,3', 'Závod na planetě Ton-ti-pon-chuan, obývané původními obyvateli Japonska ze staré planety Terra. Teplota ovzduší je průměrná, vlhkost vzduchu nad normálem, okolo trati se rozprostírají bambusové háje, dosud nezničeny průmyslem. Závod se jede na 3 kola.', 33, 1, 2, 0, 0),
(282, 'Rol la Bonsai 5 kol', 51, '2008-10-09', '1,4,4,19,57,21,23,20,53,53,24,21,4,4,19,57,21,23,20,53,53,24,21,4,4,19,57,21,23,20,53,53,24,21,4,4,19,57,21,23,20,53,53,24,21,4,4,19,57,21,23,20,53,53,24,21,3', 'Závod na planetě Ton-ti-pon-chuan, obývané původními obyvateli Japonska ze staré planety Terra. Teplota ovzduší je průměrná, vlhkost vzduchu nad normálem, okolo trati se rozprostírají bambusové háje, dosud nezničeny průmyslem. Závod se jede na 3 kol.', 55, 1, 2, 0, 0),
(283, 'Classic Speed', 864, '2008-10-09', '1,4,6,27,57,5,22,35,9,6,57,28,62,7,22,4,3', '', 15, 0, 1, 0, 0),
(284, 'Stone Track', 864, '2008-10-09', '1,7,29,8,33,9,32,51,8,31,31,52,7,36,9,35,52,8,31,32,7,33,7,29,51,7,3', 'Jak už název trati napovídá, na této trati nenajdete nic jiného než kámen, kdo má alergii na kameny tak se určitě nezúčastňujte tohoto závodu. Děkuji za pochopení!!!', 25, 0, 1, 0, 0),
(285, 'Fusion', 864, '2008-10-10', '1,4,26,19,28,41,5,35,39,20,27,4,37,60,26,40,6,3', '', 16, 0, 3, 0, 1),
(286, 'Zatáčková', 864, '2008-10-10', '1,21,25,22,26,23,27,24,28,29,33,30,34,31,35,32,36,37,21,33,27,31,37,3', 'Trať ve které se jen a pouze zatáčí!!', 22, 0, 2, 0, 0),
(287, 'ART 1', 787, '2008-10-28', '1,4,4,37,56,52,6,4,21,43,45,4,5,5,20,59,25,26,27,25,24,5,4,19,19,57,57,37,32,30,5,6,6,5,4,20,20,36,20,42,62,5,4,4,60,56,5,5,37,6,4,3', 'ART - Advanced Race Track\r\n\r\nTrať postavená v rámci moderizace závodních okruhů firmou ART (Aeonflux Racing Technologies) pro stáj ART (Aeonflux Racing Team).\r\nTrať s pořadovým číslem 1 je projektována jako extrémně dlouhá a náročná trať, která má prověřit jak kvalitu kluzáku, tak i pilota.', 50, 2, 1, 0, 0),
(288, 'Bad feeling about your sailplane', 860, '2008-10-29', '1,5,38,24,20,43,46,22,37,37,54,55,56,38,38,40,63,57,57,4,4,5,59,37,5,28,20,28,20,28,20,5,26,25,14,16,37,37,4,19,20,19,20,18,55,54,55,20,20,3', 'Kluzák na tom po závodě asi moc dobře nebude :-)', 48, 0, 2, 0, 0),
(289, 'Shock', 864, '2008-11-01', '1,8,4,37,62,19,24,5,59,20,36,19,48,5,25,5,61,7,21,8,31,5,5,26,4,4,3', '', 25, 0, 1, 0, 0),
(290, 'Mango', 864, '2008-11-01', '1,6,8,60,28,63,58,37,9,13,16,24,18,25,27,9,24,4,18,9,59,3', '', 20, 1, 2, 0, 0),
(291, 'Ornitologicka', 832, '2008-12-12', '1,4,4,4,57,55,37,37,36,32,57,57,57,38,45,20,20,63,62,61,61,61,5,21,47,48,49,48,47,14,16,60,5,5,4,4,4,4,4,4,4,4,4,4,4,25,4,4,4,4,4,4,4,4,4,4,4,4,3', 'Trať postavená na Terranském území. Cestou byste mohli pozorovat různorodou faunu této pozoruhodné planety, ale věnujte raději pozornost řízení, ať nesrazíte nějakého srnkoida...', 57, 1, 0, 0, 0),
(292, 'Dark Zero', 322, '2008-12-17', '1,5,54,55,56,5,63,62,61,50,51,52,39,40,41,42,5,3', 'trat jak ma byt', 16, 2, 3, 1, 0),
(293, 'Rycla jizda', 1075, '2008-12-17', '1,6,41,6,43,60,4,4,38,7,59,19,62,61,54,56,47,49,63,37,4,3', '', 20, 0, 2, 1, 0),
(294, 'Phoenix playground', 1060, '2008-12-30', '1,18,19,22,8,57,33,20,23,8,59,28,4,4,31,57,57,29,4,19,19,19,4,26,5,40,44,8,50,51,8,62,34,18,19,19,19,18,59,18,20,22,20,18,42,45,18,26,18,20,3', '', 49, 0, 2, 0, 0),
(295, 'Fallen empire', 1060, '2009-01-01', '1,7,8,9,9,31,8,55,52,53,50,9,36,19,19,30,8,8,42,45,8,30,57,37,57,27,20,20,36,8,61,57,9,31,37,8,9,51,51,56,50,8,40,45,8,52,8,35,62,9,60,9,32,18,35,8,57,57,37,57,30,18,43,46,18,3', 'Trať prochází ruinami několik tisíc let starého království. Užijte si jízdu a prohlédněte si starobylé památky.', 64, 0, 1, 0, 0),
(296, 'Watchtower Run', 864, '2009-01-03', '1,4,23,6,60,33,8,35,5,43,5,5,37,6,27,55,8,32,5,5,22,26,57,58,4,4,3', '', 25, 0, 1, 0, 0);
INSERT INTO `trate` (`id`, `nazev`, `login`, `datum`, `trat`, `popis`, `useky`, `delka`, `pro`, `proti`, `mezi`) VALUES
(297, 'Class A', 864, '2009-01-03', '1,6,37,22,5,28,63,23,19,23,4,60,21,27,4,42,18,28,5,30,24,7,5,41,4,21,25,4,18,18,18,3', 'Na počest stáji Class A :)', 30, 0, 2, 0, 0),
(298, 'Pár skoků do cíle', 864, '2009-01-03', '1,39,39,40,39,41,42,40,43,43,40,39,42,42,43,41,40,40,39,43,42,3', '', 20, 1, 1, 0, 0),
(299, 'Nashledanou', 4, '2009-01-03', '1,8,9,35,61,4,4,37,37,37,19,19,19,43,57,43,6,52,8,6,19,3', '', 20, 2, 0, 1, 0),
(300, 'Rose', 864, '2009-01-03', '1,18,37,18,37,18,37,18,37,18,37,18,37,3', '', 12, 0, 1, 0, 0),
(301, 'Knock Out', 1, '2009-01-03', '1,61,61,61,62,62,61,62,61,62,62,62,62,61,62,62,62,61,61,61,61,62,62,61,62,61,61,62,62,61,62,61,61,62,62,61,62,61,61,62,62,61,62,61,3', 'Trať není nebezpečná, ale zpomaluje kluzáky na malou rychlost svým povrchem a jde tedy jen o to, přežít zběsilé útoky Wreckerů a dojet do cíle. Takovej Death-Match!', 45, 0, 5, 1, 0),
(302, 'm_ racing', 338, '2009-01-09', '1,58,37,51,5,31,53,20,21,57,37,3', '', 10, 2, 0, 0, 0),
(303, 'Circle', 955, '2009-01-13', '1,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,21,3', '', 150, 2, 1, 4, 0),
(304, 'Dark Kaňon', 14, '2009-02-01', '1,9,6,4,60,38,45,18,4,6,20,19,37,36,32,60,15,16,18,59,37,3', 'Rychlá a místy nebezpečná trať v Dark Kaňonu.', 20, 1, 1, 0, 0),
(305, 'Krátká cesta na vrakoviště', 1210, '2009-02-21', '1,9,37,52,38,46,36,9,32,37,42,45,35,37,52,9,61,57,9,37,60,3', '', 20, 0, 1, 0, 0),
(306, 'Oh_My_God', 822, '2009-03-15', '1,18,6,5,24,20,37,54,39,13,16,22,4,5,6,7,8,9,27,48,62,28,19,20,4,4,3', 'Trať s malým počtem "brutálních" zatáček,kde si můžete rozbít kluzák.\r\nBuďte buď rychlí nebo opancéřovaní(jinak vám totálně rozbíjí kluzák v "elkách")', 25, 1, 2, 0, 0),
(307, 'R I P', 860, '2009-03-27', '1,61,61,61,61,61,61,61,61,61,18,18,18,18,18,18,57,57,57,19,19,19,19,19,19,41,46,41,46,41,46,20,20,20,20,19,20,56,56,56,18,18,18,18,18,18,52,52,52,3', 'Rest in peace...', 48, 0, 1, 0, 0),
(308, 'Lukikova krátká', 1306, '2009-04-18', '1,20,63,8,26,25,59,5,57,57,7,19,19,27,4,4,3', 'Lukikova trať - krátká, má jest 15 částí, které jsou krátké, tato trať není tak náročná, proto se hodí právě pro začátečníky...', 15, 0, 1, 0, 0),
(309, 'Chilly_pol', 1214, '2009-04-19', '1,4,20,5,6,31,35,5,39,5,59,5,19,20,27,29,29,29,8,36,5,5,5,41,5,24,28,34,9,32,34,8,34,8,4,4,4,7,29,8,6,5,25,5,59,5,28,24,22,4,42,5,39,5,25,5,23,26,5,8,40,5,9,34,30,30,22,58,42,5,6,5,25,5,25,4,55,4,3', 'Ledová pláň... plná popraskaných ledovců... na ledové planetě :-)', 77, 1, 1, 0, 0),
(310, 'TrainingTriangl', 1214, '2009-04-19', '1,5,6,28,6,14,16,28,37,6,36,5,6,28,6,14,16,28,37,6,36,5,6,28,6,14,16,28,37,6,36,3', '', 30, 0, 0, 0, 0),
(311, 'Lamerova zatáčka smrti', 1317, '2009-04-27', '1,20,22,27,41,44,37,54,32,28,25,34,20,9,57,18,3', '', 15, 1, 0, 1, 0),
(312, 'The Brightlands', 1271, '2009-04-30', '1,28,38,44,8,30,53,27,60,57,35,63,18,35,42,45,3', '', 15, 0, 1, 0, 0),
(313, 'smeetyho', 1241, '2009-05-02', '1,20,20,20,21,55,55,40,40,38,41,38,61,61,61,57,57,43,20,20,20,3', '', 20, 1, 0, 0, 0),
(314, 'MichMach', 1277, '2009-05-03', '1,5,49,40,45,52,57,37,37,20,20,60,41,45,37,20,3', '', 15, 1, 0, 0, 0),
(315, 'Free of Frivolity', 962, '2009-05-23', '1,4,4,5,6,6,22,22,25,27,5,40,58,58,37,38,45,6,38,19,19,19,20,20,41,8,8,15,16,15,16,6,6,6,6,22,26,22,26,24,28,38,38,38,4,4,43,5,48,48,47,48,49,49,49,49,48,48,47,4,4,5,5,6,6,6,49,48,50,50,51,52,52,55,55,7,5,57,57,62,62,57,57,53,53,57,57,6,6,59,59,42,45,5,4,4,5,6,5,4,4,3', '', 100, 1, 1, 0, 0),
(316, 'Lemrarna', 1232, '2009-05-24', '1,4,4,22,22,48,59,62,5,5,6,60,58,22,21,4,18,20,3', '', 17, 0, 1, 0, 0),
(317, 'Free of Weakness', 962, '2009-05-24', '1,58,58,60,60,60,60,60,60,60,60,15,16,18,22,26,22,26,22,26,22,26,22,26,22,26,31,35,31,35,31,35,31,35,38,45,37,37,37,37,37,37,37,37,37,37,37,37,37,37,20,20,20,20,56,47,47,47,48,48,48,48,55,48,55,48,55,48,55,49,54,39,40,42,43,46,4,4,4,4,4,5,5,5,6,9,9,9,59,60,60,60,22,21,27,37,37,37,37,37,37,37,37,37,37,37,36,32,36,32,18,18,18,19,20,19,20,19,20,19,20,58,58,60,55,54,38,45,22,39,28,57,57,57,57,42,61,57,57,57,14,16,26,26,24,18,21,48,48,25,6,6,6,6,38,44,42,26,37,37,37,37,37,37,37,37,37,26,27,24,5,5,22,18,39,28,63,57,57,56,49,49,49,49,13,16,22,62,18,19,19,19,20,20,20,20,20,20,20,20,42,3', '', 200, 1, 4, 1, 0),
(318, 'ART Basic I', 787, '2009-05-30', '1,20,23,26,58,8,34,36,4,14,16,37,37,23,4,5,20,20,20,60,26,27,22,24,5,4,3', 'ART Basic je trat urcena pro nizsi cenove kategorie kluzaku. Pri jeji stavbe byla firmou Aeonflux Racing Technologies zohlednena nejen vydrz a vykon kluzaku stanovenych kategorii,ale take obvykle zkusenosti jezdcu. Necekejte tedy zadne extremni nerovnosti,ani zatacky.', 25, 0, 1, 0, 0),
(319, 'ART Basic II', 787, '2009-05-30', '1,4,7,9,30,31,36,37,37,8,8,60,32,7,7,14,16,30,34,8,9,37,20,20,40,7,48,53,9,8,7,19,19,35,35,30,8,34,58,4,3', 'Druhá trať ze série ART Basic určená pro jezdce na kluzácích nižších kategorií, případně pro testovací účely. Oproti ART B I, je tato trať mírně obtížnější a také delší. Kvůli této trati jsme zakoupili lukrativní pozemky okolo Warťy!Kcho - přímo vedle paláce krásných pannen. Co budete dělat po závodě...?', 39, 0, 1, 1, 0),
(320, 'ART Basic III', 787, '2009-05-30', '1,8,9,34,32,37,8,8,9,48,49,6,5,8,19,8,9,60,60,8,8,20,20,41,45,6,8,7,7,30,34,35,36,8,7,58,8,31,31,20,31,31,8,39,8,7,3', 'Trať ze série ART Basic, tentokrát s číslem III. Přestože patří do kategorie ART B, jedná se o relativně těžší trať s prvky, které se obejvují i na obtížnějších tratích určených pro výkonější kluzákové kategorie.\r\nTrať po startu mírně stoupá a ostrými serpentinami se dostává na náhorní planinu Wu''tong, na které si závodníci mohou "zblízka" prohlédnout kaňon s výraznými solnými žílamy. Po průjezdu následuje další vyvýšení, díky čemuž se závodníci řítí na okraji hluboké propasti - čistý adrenalin. Následuje chatrný mostek přes zmíněnou propast, sjezd, na kterém závodníci akcelerují, aby se pomocí skokánku přenesli přes krátkou průrvu, následuje relativně klidná pasáž, několik kliček v zatáčkách, most přes řeku Kvah, který jezdce přivede do ostrého točení z kopce, kdy se zatáčka nakonec podjíždí sama sebe a jezdci už mohou vidět cílovou rovinku, následuje poslední malý skok, forsáž a cíl.', 45, 0, 1, 0, 0),
(321, 'ART Xtreme Speed', 787, '2009-05-31', '1,18,18,18,18,18,18,18,18,18,18,25,25,25,25,25,25,18,18,18,18,18,18,18,18,18,18,25,25,25,25,25,25,3', 'Série tratí ART X (Xtreme) je designovaná pro testovací a brutálně závodní účely. Tato trať Speed je určena pro testy maximálních rychlostí kluzáků. Dlouhé rovinky podporují využití boosterů na maximum, zatáčky jsou konstuovány jako klopené, mírné a dlouhé, čímž se zabraňuje zbytečným ztrátám rychlosti a dosahuje se také vysoké bezpečnosti trati.\r\nVzhledem k novému povrchu se jedná o bezkonkurenčně nejrychlejší trať Vnitřní soustavy.', 32, 2, 1, 0, 0),
(322, 'ART Xtreme Crush', 787, '2009-05-31', '1,9,9,37,37,37,37,37,37,37,37,9,18,43,46,9,52,56,9,9,9,57,57,9,8,63,63,9,9,37,37,37,37,37,60,9,9,32,43,46,8,3', 'ART Xtreme je synonymem pro brutální tratě - ať již pro dosahované rychlosti na těchto tratích, délku těchto tratí, nebo jejich obtížnost. Právě tato trať je koncipována jako dlouho a Xtrémně náročná. Při přípravě podkladů se bral ohled zejména na požadavky nejvýkonějších wreckerů, dále na diváckou atraktivitu tratě a také dostupnost z kosmodromu.', 40, 2, 0, 0, 0),
(323, 'Litlik', 1240, '2009-06-07', '1,4,60,37,37,37,37,37,37,37,37,37,4,4,4,4,4,4,4,4,4,4,21,37,37,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,21,21,21,21,21,21,4,4,4,4,4,4,4,4,4,13,16,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,37,37,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,21,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,37,37,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,37,37,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,37,37,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,37,37,37,37,37,37,37,37,37,37,4,4,4,60,3', '', 500, 0, 2, 0, 1),
(324, 'červen', 969, '2009-06-09', '1,24,60,38,9,20,30,57,36,62,21,43,46,18,20,29,53,38,4,52,22,19,33,49,39,63,57,23,60,28,8,60,22,36,38,57,61,19,20,3', '', 38, 0, 0, 0, 0),
(325, 'Červenec', 969, '2009-06-09', '1,6,27,50,6,36,62,5,19,38,45,40,62,22,37,26,31,5,49,26,61,57,3', '', 21, 0, 0, 0, 0),
(326, 'Leden', 969, '2009-06-09', '1,24,30,32,21,36,25,23,33,22,28,21,26,34,26,26,21,37,3', '1. měsíc v roce', 17, 1, 1, 0, 0),
(327, 'Únor', 969, '2009-06-09', '1,4,5,6,7,8,9,18,19,20,58,59,60,36,28,60,43,45,38,49,52,8,25,37,3', '2. měsíc v roce', 23, 2, 0, 0, 0),
(328, 'Březen', 969, '2009-06-09', '1,38,44,39,46,40,45,41,42,43,47,48,49,50,51,52,53,54,55,56,57,61,62,63,26,5,32,20,34,24,30,37,27,6,29,5,3', '3. měsíc v roce', 35, 1, 0, 1, 0),
(329, 'Duben', 969, '2009-06-09', '1,4,21,38,5,22,39,6,23,40,7,24,41,8,25,42,9,27,29,6,43,49,38,52,25,37,31,59,27,50,30,26,5,26,36,61,57,7,47,30,28,8,34,7,37,5,59,3', '4. měsíc v roce', 46, 0, 0, 0, 0),
(330, 'Květen', 969, '2009-06-09', '1,23,27,33,38,33,8,25,51,39,51,30,40,39,7,7,31,23,41,50,3', '', 19, 2, 0, 0, 0),
(331, 'Září', 969, '2009-06-09', '1,25,35,52,24,28,34,37,21,31,36,7,19,33,52,39,57,26,47,20,9,21,40,32,35,27,34,26,59,7,21,26,50,3', '', 32, 2, 0, 0, 0),
(332, 'Srpen', 969, '2009-06-09', '1,6,27,51,38,49,42,57,56,61,24,62,42,24,32,25,50,31,23,42,20,31,36,8,9,59,8,20,3', '8. měsíc v roce', 27, 1, 0, 0, 0),
(333, 'CA Classic Short', 864, '2009-06-10', '1,5,26,38,44,5,27,39,4,4,21,63,22,59,25,5,3', '', 15, 0, 1, 0, 0),
(334, 'CA Classic Easy', 864, '2009-06-10', '1,5,4,25,25,19,40,4,21,60,25,4,7,57,21,5,25,4,58,5,5,3', '', 20, 0, 0, 0, 0),
(335, 'CA High Speed', 864, '2009-06-10', '1,5,18,29,25,4,21,4,42,4,43,4,33,4,19,25,4,43,5,54,41,21,4,42,4,5,3', '', 25, 0, 0, 0, 0),
(336, 'Star Race', 1448, '2009-07-07', '1,60,28,52,6,6,52,37,43,4,6,60,56,52,35,37,3', '', 15, 0, 0, 0, 0),
(337, 'Apocalypse Now', 1160, '2009-07-07', '1,18,18,18,22,6,6,60,26,39,23,27,23,27,19,19,18,41,46,20,42,25,25,7,7,8,8,9,9,51,50,29,25,18,18,18,41,55,57,57,62,59,22,28,49,37,37,37,18,18,18,3', '', 50, 0, 1, 0, 0),
(338, 'Truxikova stezka', 1235, '2009-07-08', '1,19,19,5,6,60,20,27,23,15,16,5,5,58,29,20,38,43,5,28,53,49,49,49,38,45,38,4,4,57,57,57,57,57,56,62,62,61,62,63,5,9,56,37,37,37,37,37,24,26,4,3', 'Trať na vyšším levelu existence.', 50, 1, 1, 0, 0),
(339, 'pekelna jizda', 1609, '2009-07-15', '1,56,56,56,56,56,56,56,56,56,56,3', '', 10, 0, 1, 0, 0),
(340, 'Drag trať', 1552, '2009-07-16', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,5,5,5,5,5,3', 'Drag trať pro všechny namakané kluzáky !', 20, 0, 1, 0, 0),
(341, 'mission mars', 1548, '2009-07-17', '1,7,4,4,18,19,19,58,20,20,25,25,21,21,47,47,53,62,41,4,4,4,4,5,18,18,4,5,5,4,42,3', '', 30, 0, 1, 0, 0),
(342, 'toxik wother', 1548, '2009-07-18', '1,20,20,61,42,56,63,62,61,61,21,27,36,63,61,57,57,39,63,61,62,20,3', 'zavod popri vode', 21, 2, 1, 0, 0),
(343, 'The Badlands', 1548, '2009-07-23', '1,20,20,21,24,36,30,32,39,38,52,38,46,63,20,20,20,43,56,57,57,63,39,41,43,56,43,56,43,56,23,33,36,37,42,3', '', 34, 2, 1, 0, 0),
(344, 'Need For Speed', 1548, '2009-07-23', '1,18,18,18,18,19,19,18,20,20,21,25,4,4,4,54,4,4,4,21,22,23,24,4,4,4,4,4,25,26,27,28,4,4,4,18,18,18,4,4,5,4,58,58,4,4,4,5,5,6,60,6,5,5,4,4,4,4,21,21,21,21,25,25,25,25,4,4,4,18,18,18,18,3', 'richlost je vsetko', 72, 2, 2, 0, 0),
(345, 'Head for the Barricade', 864, '2009-08-02', '1,6,21,40,4,25,19,62,24,5,29,4,5,18,22,8,33,5,25,7,5,4,22,4,40,4,3', '', 25, 0, 1, 0, 0),
(346, 'It will be OK _ maybe', 864, '2009-08-02', '1,6,32,30,49,60,37,29,6,6,7,40,48,60,9,29,20,56,56,56,56,56,5,27,19,33,58,18,37,37,37,50,7,25,28,9,60,23,59,4,5,3', '', 40, 1, 1, 0, 0),
(347, 'All hope is gone', 864, '2009-08-02', '1,35,40,7,22,28,27,9,24,57,6,35,25,5,30,48,59,26,9,63,37,63,8,35,7,8,28,34,20,43,28,8,26,41,26,59,8,28,41,6,26,29,20,28,31,4,27,22,18,18,37,3', '', 50, 2, 4, 0, 0),
(348, 'Scary', 864, '2009-08-02', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,3', 'Neboj se!!! Je to jen rovinka :)', 1500, 2, 4, 2, 0),
(349, 'The Ballast Complex', 1701, '2009-08-07', '1,4,24,28,37,37,14,16,22,21,22,26,34,36,34,3', '', 14, 0, 0, 0, 0),
(350, 'Milenium', 1706, '2009-08-10', '1,4,21,41,60,62,17,9,37,43,44,8,59,28,5,4,38,35,55,53,43,3', 'Malebná trať, malebná tráva, malebné nebe.\r\nOvšem toto se může velice rychle změnit v jednu velkou řež a krveprolití.\r\nZkuste a uvidíte.', 20, 0, 2, 0, 0),
(351, 'Milenium Thunderhammer', 1706, '2009-08-22', '1,4,26,5,37,4,21,27,4,6,24,6,37,25,4,25,21,22,22,4,27,5,37,28,23,6,37,21,6,5,28,25,4,4,6,4,22,25,37,5,37,6,28,6,27,21,22,23,4,4,37,37,4,6,25,21,22,5,28,4,23,37,5,24,28,4,6,25,22,37,6,6,5,4,6,22,5,23,5,24,6,25,22,6,4,6,26,5,22,5,6,37,26,4,5,21,22,5,23,4,4,3', 'Druhá trať z řad Milenium.\r\nTentokrát s označením "Thunderhammer", které označuje, že je trať o něco težší ,ale přesto je stále na přijatelné obtížnosti.\r\nMilenium Thunderhammer je středně dlouhá trať, čítající 100 úseků.', 100, 1, 4, 0, 3),
(352, 'Terminator', 1235, '2009-09-01', '1,59,59,59,59,59,59,59,59,59,59,21,21,21,21,21,37,37,37,37,37,37,37,37,37,37,21,21,21,21,21,20,19,19,20,19,20,19,20,18,18,6,6,6,6,6,60,60,60,60,60,59,59,5,59,59,5,5,5,5,5,53,53,53,53,53,38,45,38,43,38,59,59,59,59,59,41,48,48,48,6,59,59,59,59,59,21,21,21,21,21,25,25,25,25,25,18,18,3', '', 97, 2, 1, 0, 0),
(353, 'FireFly', 1235, '2009-09-01', '1,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,42,46,41,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,16,37,37,37,37,43,46,43,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,43,46,43,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,59,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,3', '', 398, 2, 1, 1, 0),
(354, 'Neobycejne obycejna', 860, '2009-09-01', '1,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,57,3', 'Cut it down! Známka: bacha na dřevo.', 198, 0, 1, 1, 1),
(355, 'Drtička', 1482, '2009-09-05', '1,57,28,38,48,15,17,5,40,38,61,49,37,37,37,20,19,52,24,60,43,48,41,31,61,15,17,49,36,15,17,38,46,57,57,57,57,40,46,18,27,23,39,49,43,37,38,45,37,20,58,3', '', 50, 2, 0, 0, 0),
(356, 'dragon race', 1548, '2009-09-19', '1,18,18,18,18,20,4,5,6,9,29,30,31,32,42,50,51,52,52,52,52,51,51,50,61,43,3', 'cesta cez dračí kanon a popri dračom jazere\nPREŽIJÚ LEN NAJLEPŠÍ!!!!!', 25, 2, 1, 0, 0),
(357, 'reddragons places', 1548, '2009-09-19', '1,8,8,9,9,9,9,8,7,4,4,18,18,18,18,42,57,57,57,57,30,34,32,36,31,9,52,52,52,52,52,52,52,52,52,52,52,51,51,51,50,51,52,51,50,57,57,43,8,18,18,3', 'skutocni boj o zivot\nPREŽIJÚ LEN NAJLEPŠÍ!!!!!', 50, 1, 1, 0, 0),
(358, 'Race Wars', 1591, '2009-09-22', '1,24,23,43,44,5,23,26,19,9,28,5,6,8,28,5,24,5,39,5,5,5,23,59,26,4,57,57,57,21,18,25,4,39,44,4,21,21,4,4,25,48,5,8,25,21,4,59,59,22,5,26,5,63,4,59,4,59,21,5,4,40,45,4,4,8,7,21,22,25,18,59,60,59,7,24,58,28,39,4,58,3', '', 80, 0, 1, 0, 0),
(359, 'Alpy', 1482, '2009-10-01', '1,37,37,37,37,37,38,45,36,32,59,37,37,37,54,38,46,15,17,63,37,37,37,37,37,37,37,37,37,37,37,3', '', 30, 2, 0, 0, 0),
(360, 'Deat Race', 1591, '2009-10-05', '1,18,18,18,18,18,4,4,4,19,19,18,20,21,18,18,25,18,18,18,18,19,20,21,25,25,21,58,18,4,5,18,18,21,18,5,4,58,25,18,18,18,18,18,58,4,4,4,21,21,25,18,25,25,5,18,21,18,19,19,18,25,25,21,58,4,18,18,25,18,18,18,18,18,21,25,4,21,4,4,4,18,18,18,21,25,18,19,20,20,4,18,21,21,4,58,18,21,18,21,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,21,18,18,25,21,18,18,18,18,18,18,4,18,58,18,18,21,21,18,18,25,18,18,18,18,18,18,58,18,58,18,18,18,4,25,21,18,18,18,18,18,18,58,58,4,18,4,4,4,4,4,4,18,25,21,18,18,18,18,18,18,18,18,18,25,21,18,18,18,18,18,19,18,18,18,18,18,18,18,21,25,18,18,18,18,18,18,18,18,18,58,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,19,20,18,18,18,18,18,18,18,21,21,4,4,18,18,19,21,4,5,4,4,4,4,4,4,21,25,25,4,4,21,4,4,4,4,18,18,18,18,19,18,18,18,25,21,4,4,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,18,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,25,25,21,4,4,4,4,4,18,18,18,19,20,20,18,4,4,4,18,21,21,25,18,4,4,4,4,4,4,4,4,18,19,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,21,25,21,25,4,4,4,4,4,4,4,4,18,19,18,18,18,18,58,4,21,4,4,4,25,4,4,4,21,25,19,20,18,18,18,4,4,4,4,4,4,4,4,4,4,18,18,18,18,4,4,4,21,25,4,4,4,21,25,21,4,4,4,4,4,4,4,4,18,18,18,18,25,18,4,18,18,4,4,4,4,4,18,18,18,4,18,4,4,21,21,18,4,18,18,18,18,18,18,18,18,18,18,18,18,4,4,4,4,4,4,4,4,18,18,18,18,4,4,4,4,21,25,18,18,18,18,19,18,19,21,4,20,25,20,4,4,4,18,4,4,25,4,25,4,4,4,4,4,4,4,4,21,18,4,4,4,4,21,4,4,4,25,4,4,4,4,18,4,4,18,21,4,25,18,18,21,25,18,18,4,4,4,4,4,4,4,4,4,4,4,4,4,21,25,18,18,19,20,4,4,4,4,4,4,4,4,4,4,18,18,18,18,18,21,21,25,4,4,4,4,4,18,18,4,4,4,4,4,4,4,18,18,18,18,18,4,4,4,4,4,4,18,18,18,19,20,18,18,19,18,18,4,4,4,4,4,18,18,18,18,18,4,18,4,18,18,4,58,58,4,4,4,4,4,4,4,4,4,4,4,4,25,21,21,25,25,4,4,4,4,4,4,21,22,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,25,18,4,4,4,4,4,4,4,21,19,20,4,4,4,21,25,4,4,4,4,4,4,4,4,4,21,25,4,4,4,4,4,4,4,4,4,4,4,4,21,25,4,4,4,4,4,4,4,4,4,4,4,4,4,18,4,4,4,4,4,18,4,4,21,25,4,4,4,4,4,4,4,19,21,26,4,4,4,4,4,4,4,21,25,18,20,19,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,18,21,25,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,21,4,4,4,25,4,4,4,4,4,4,4,4,21,25,4,4,4,4,4,4,4,21,4,25,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,18,18,4,4,4,4,25,25,25,21,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,21,25,4,4,4,4,4,4,4,4,4,18,25,4,4,4,4,4,21,25,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,18,21,4,18,19,21,25,25,21,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,21,25,5,4,4,4,4,4,4,4,4,21,25,4,4,4,4,4,4,21,25,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,21,25,4,4,4,4,4,4,4,3', '', 1010, 0, 2, 0, 0),
(361, 'Top Gear', 1706, '2009-10-20', '1,5,25,22,22,21,5,27,5,22,27,27,5,26,5,21,5,22,5,23,5,3', '', 20, 0, 2, 0, 0),
(362, 'Fear', 1749, '2009-10-30', '1,18,19,18,59,26,42,45,59,22,57,18,18,19,58,27,28,23,41,44,58,3', '', 20, 0, 0, 0, 0),
(363, 'Darkness comes', 1749, '2009-10-30', '1,18,18,22,37,21,26,54,18,18,32,4,59,18,13,17,18,18,22,26,18,47,57,57,21,18,58,18,61,18,56,3', '', 30, 0, 0, 1, 0),
(364, 'SWAT', 1856, '2009-11-06', '1,9,21,49,60,27,43,46,4,43,32,19,20,37,38,5,3', '', 15, 0, 1, 0, 0),
(365, 'Ruins of Carnuss Gorgull', 1940, '2009-12-01', '1,41,45,31,8,34,42,7,48,7,9,31,35,8,7,39,3', '', 15, 0, 0, 0, 1),
(366, 'Měsíční pláně', 1162, '2009-12-26', '1,18,21,54,8,19,27,47,48,59,27,6,53,9,4,20,32,33,13,16,9,8,4,37,56,3', 'Nově objevený měsíc v soustavě Helion má výborné předpoklady, stát se novým závodním okruhem! Pojďte ho vyzkoušet i vy!', 24, 1, 0, 0, 0),
(367, 'Smetiste', 1892, '2009-12-27', '1,4,41,37,60,20,9,38,27,29,26,4,5,18,59,56,3', '', 15, 1, 0, 0, 0),
(368, 'Represent', 1843, '2010-01-04', '1,20,6,59,43,46,21,27,49,37,14,17,9,9,28,38,46,48,34,31,19,60,14,17,38,17,18,19,20,5,52,50,40,39,41,42,43,42,48,47,48,49,52,9,8,21,36,30,37,24,37,51,18,18,18,3', '', 54, 1, 1, 0, 0),
(369, 'The Show Must Go On', 1843, '2010-01-05', '1,7,30,36,31,60,14,17,58,29,37,20,43,46,48,56,52,53,57,18,62,6,23,24,27,28,37,57,38,40,61,54,19,58,9,35,31,29,36,37,39,44,14,17,63,6,57,57,61,8,29,32,33,37,49,43,46,52,47,48,13,17,6,4,19,23,26,28,20,21,5,27,32,37,52,57,39,45,52,48,50,31,35,7,31,9,37,51,50,14,16,5,6,21,27,29,30,8,36,38,45,48,52,5,50,48,33,37,14,17,6,22,6,4,27,25,43,46,52,52,48,18,37,8,9,19,3', '', 125, 1, 2, 0, 0),
(370, 'Serres Sarrano', 2086, '2010-03-28', '1,18,60,37,18,41,23,4,13,17,35,63,57,60,3', '', 13, 1, 0, 0, 0),
(371, 'WCOR 1', 24, '2010-03-29', '1,42,21,47,4,37,20,31,59,38,13,17,25,19,19,36,37,6,6,6,57,4,63,47,39,5,3', 'Oficiální mapa WCORu je tu pro vás.', 25, 1, 0, 0, 0),
(372, 'The Grand Reefs', 2095, '2010-03-31', '1,4,32,52,33,60,35,57,40,42,13,3', '', 10, 0, 0, 0, 0),
(373, 'Twistedway', 2061, '2010-04-05', '1,20,20,40,45,27,9,8,37,37,37,4,4,39,15,16,30,48,7,33,25,48,23,7,19,5,19,20,20,38,46,21,4,20,7,32,36,61,57,53,56,7,7,5,30,35,43,28,42,5,7,33,58,49,31,31,48,8,5,5,9,9,37,37,37,18,18,8,33,29,63,53,54,32,6,24,4,4,39,38,14,17,23,31,7,43,37,6,4,4,20,3', '', 90, 1, 1, 0, 1),
(374, 'Killstreak', 2099, '2010-04-14', '1,6,39,36,40,5,5,26,21,63,35,6,24,59,42,3', '', 14, 1, 0, 0, 0),
(375, 'The Citadel', 2107, '2010-04-22', '1,18,28,42,60,36,63,5,29,53,6,36,54,19,37,17,3', 'dobra', 15, 1, 0, 0, 0),
(376, 'Trať s velkým T', 159, '2010-05-21', '1,4,8,6,22,28,58,37,37,37,19,60,20,9,39,37,48,4,37,37,37,37,37,37,37,37,6,31,8,35,24,5,37,37,37,37,38,46,9,42,25,43,6,8,15,16,37,37,37,37,37,32,58,8,20,3', 'Nejsem těžká, ani dlouhá, ani obávaná trať, ale buďte si jisti, že o mně teď hodně uslyšíte...', 54, 1, 1, 0, 0),
(377, 'Easy men', 1591, '2010-05-22', '1,5,25,5,21,21,18,18,39,18,18,21,25,18,54,21,18,26,18,18,18,21,25,25,18,63,40,18,18,21,21,25,18,18,43,3', 'easy men :D', 34, 0, 0, 0, 0),
(378, 'Milenium Hammerhead ', 1706, '2010-05-26', '1,4,4,4,4,4,4,4,4,4,23,27,41,4,43,22,32,6,20,60,5,5,6,6,4,4,4,19,28,4,8,6,18,58,19,35,60,19,63,57,9,4,5,26,5,4,37,4,59,41,6,8,33,52,9,5,25,4,5,4,31,4,5,5,6,5,50,4,32,4,31,37,37,37,8,26,38,5,4,5,4,6,5,4,6,26,43,4,31,5,58,18,43,45,6,26,23,4,6,5,29,33,18,40,9,24,7,49,22,9,8,4,6,5,4,4,24,5,4,43,4,62,7,18,37,6,60,20,43,45,5,25,5,4,6,5,4,4,4,4,5,5,19,32,47,7,37,5,4,27,4,5,5,3', 'Trať určena pro závody opilých šílenců, křečků, soniců a dalších pohádkových postav.\r\n\r\nOkraje tratě jsou ozdobeny palmami a zdravotnickou péči zajišťuje doktor Hadr.\r\n\r\nJako zpestření hraje TruxXerus a jeho Rook-enrolová skupina awersion.\r\n\r\nObčerstvení a pití je dodáváno společností OndraŠter-ovka s.r.o.', 152, 0, 3, 0, 0),
(379, 'Nightlands', 1271, '2010-06-11', '1,4,7,21,4,21,57,5,22,14,17,23,15,17,24,16,8,25,17,4,4,4,43,46,35,43,19,37,61,55,39,3', '', 30, 0, 0, 0, 0),
(380, 'Boonta Eve Classic', 1271, '2010-06-11', '1,39,56,53,43,46,15,17,60,35,61,3', 'tato trat je udelana jako můj hrob kdybych náhodou musel zkoncit a proto je velmi obtížná', 10, 0, 0, 0, 0),
(381, 'The Dreighton Triangle', 1271, '2010-06-15', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,63,63,60,37,63,60,37,63,60,60,37,63,37,60,37,37,63,63,60,37,63,60,37,37,63,37,63,60,37,3', '', 60, 0, 0, 0, 0),
(382, 'Agrilat Swamp Circuit', 1271, '2010-06-15', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,60,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,43,46,43,46,43,46,43,46,43,46,43,46,43,46,43,46,43,46,43,46,43,46,43,46,43,46,3', '', 100, 1, 0, 0, 0),
(383, 'Keren Street Race', 1271, '2010-06-17', '1,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,37,15,17,52,56,47,51,20,50,33,18,8,27,31,34,32,37,34,48,19,18,58,36,32,50,30,33,31,30,61,28,9,19,60,60,34,31,18,41,46,35,58,20,20,33,40,47,38,46,47,32,58,59,43,46,19,58,35,13,17,33,32,34,32,47,19,60,47,24,34,47,20,47,36,63,35,47,49,33,19,32,41,46,33,29,4,47,63,60,60,35,6,30,37,37,58,60,60,47,4,47,60,27,33,18,60,9,60,58,6,7,58,60,58,60,35,37,63,63,37,53,55,60,32,55,34,35,49,20,13,17,24,47,23,5,35,63,36,56,60,35,60,25,48,61,6,33,26,43,46,55,34,61,58,20,52,59,33,47,53,59,34,31,50,59,34,54,47,36,47,31,35,35,37,55,59,35,58,32,27,31,47,26,18,59,55,62,59,6,47,35,32,33,58,58,15,16,7,35,20,47,30,32,33,48,59,61,54,55,8,58,35,52,60,37,47,47,7,59,60,34,59,60,54,55,59,31,29,7,34,18,43,46,60,35,59,53,60,52,56,19,60,37,37,25,59,19,9,37,51,47,3', '', 300, 2, 2, 0, 0),
(384, 'Tarkinova chlouba', 72, '2010-06-28', '1,4,5,5,6,9,29,30,8,35,5,21,19,20,20,38,39,18,23,27,8,57,57,63,57,8,58,37,26,20,37,37,21,4,3', '', 33, 1, 0, 0, 0),
(385, 'I am Dead', 2187, '2010-07-03', '1,4,14,16,18,21,22,23,5,25,60,20,37,36,13,16,42,46,24,28,4,3', '', 20, 0, 1, 0, 0),
(386, 'Sarategie', 2178, '2010-07-17', '1,15,17,20,60,60,6,42,46,61,9,37,36,28,4,58,33,27,21,4,4,4,4,4,4,4,4,4,9,37,37,37,32,22,28,56,38,52,22,27,9,32,37,38,45,38,38,7,59,37,4,32,60,20,60,51,37,18,37,7,18,58,35,30,9,35,37,49,43,39,41,42,47,42,40,39,42,44,36,4,4,8,59,8,5,7,40,18,37,37,37,37,35,33,30,32,28,35,20,40,46,32,7,31,27,26,26,24,31,31,30,34,25,24,25,43,46,19,60,38,5,6,20,50,31,50,4,59,24,33,37,15,17,35,6,7,9,23,21,31,24,7,50,25,34,49,39,44,43,24,42,51,8,33,31,42,25,42,4,57,13,17,14,16,15,17,14,16,22,59,59,8,32,26,32,28,37,37,37,37,6,36,51,40,50,34,38,42,44,31,34,28,32,24,25,33,22,26,30,4,58,26,7,35,40,33,38,25,7,31,8,39,41,30,7,30,32,27,28,31,28,24,32,37,32,8,58,58,58,6,7,27,36,18,37,37,37,37,37,37,23,7,61,63,62,39,46,18,24,36,41,45,33,28,3', '', 253, 1, 0, 0, 0),
(387, 'Milenium Arrowhead', 1706, '2010-07-20', '1,4,5,7,21,4,4,4,4,4,4,4,5,25,4,24,38,5,5,5,5,5,5,4,4,6,4,5,6,5,6,22,24,26,4,5,7,59,59,58,5,5,5,5,5,6,5,24,9,38,24,28,37,37,37,6,5,4,51,4,37,6,5,5,5,5,5,6,4,5,5,5,6,6,6,37,4,4,22,4,26,5,25,5,5,22,4,37,6,38,5,5,6,37,25,4,5,5,5,5,37,4,5,6,4,5,5,38,38,38,38,38,38,38,4,4,4,4,5,5,5,5,5,5,5,5,5,4,24,20,4,20,5,28,5,5,5,5,5,5,5,5,5,32,4,5,5,5,6,5,60,25,4,34,5,5,23,5,37,5,5,5,5,5,4,4,4,4,4,4,4,5,5,6,23,4,4,6,23,5,6,5,5,6,5,5,5,5,5,5,5,5,37,37,25,22,27,5,40,6,4,4,4,3', 'Trať určena pro závody opilých šílenců, křečků, soniců a dalších pohádkových postav. Okraje tratě jsou ozdobeny palmami a zdravotnickou péči zajišťuje doktor Hadr. Jako zpestření hraje TruxXerus a jeho Rook-enrolová skupina awersion. Občerstvení a pití je dodáváno společností OndraŠter-ovka s.r.o.', 202, 2, 2, 0, 0),
(388, 'Galaxi Race', 1856, '2010-09-06', '1,37,37,37,37,37,23,37,37,37,9,27,37,37,23,52,23,38,52,37,37,37,37,37,23,23,27,27,23,38,37,37,37,37,37,3', '', 34, 0, 1, 0, 0),
(389, 'The Mining Facility', 2268, '2010-09-15', '1,7,25,4,42,28,28,38,23,5,30,3', '', 10, 1, 0, 0, 0),
(390, 'Classic Bantha Track', 2255, '2010-09-18', '1,4,11,17,5,4,32,29,24,5,26,24,28,40,44,3', 'newim', 16, 0, 0, 0, 0),
(391, 'oxania', 2274, '2010-09-19', '1,9,50,45,24,24,40,61,59,37,4,3', 'velmi tezka ale zabavna', 12, 0, 1, 0, 0),
(392, 'Eurostezka', 1, '2010-09-21', '1,4,6,19,25,27,22,30,31,31,44,37,25,26,35,36,57,18,5,47,11,17,27,26,29,61,63,27,34,29,60,40,49,26,45,29,35,24,27,35,27,3', ' ', 42, 0, 1, 0, 0),
(393, 'Quadra Speed Boosters', 1, '2010-09-24', '1,4,24,60,36,18,21,21,37,19,25,26,26,28,19,19,47,47,5,37,22,63,40,22,29,29,28,49,49,24,32,20,40,28,20,40,37,47,57,33,27,40,28,25,63,48,23,29,11,16,29,29,21,61,59,23,21,28,40,3', 'Trať, na které se bude tradičně dovršovat QSB Cup.', 60, 0, 3, 0, 0),
(394, 'TopGear', 1706, '2010-09-24', '1,28,27,25,4,4,4,4,4,25,25,4,4,21,4,4,21,21,4,4,21,4,21,21,21,21,4,25,25,25,25,4,25,25,26,25,25,25,25,25,4,4,4,4,4,4,4,21,25,4,4,4,4,4,4,4,21,4,4,25,25,25,25,4,25,25,4,25,25,25,4,25,4,4,25,25,25,25,4,4,4,4,4,4,4,4,4,4,4,25,25,4,4,4,25,25,4,4,4,4,4,4,4,4,4,4,4,4,4,21,4,4,4,21,4,4,4,4,4,4,21,21,4,21,4,4,4,21,21,21,4,21,25,4,3', 'Trať založena na trati světoznámé televizní show Top Gear', 135, 0, 1, 0, 0),
(395, 'Malastare 200', 2274, '2010-09-25', '1,51,35,28,57,37,44,59,61,20,23,3', '', 12, 0, 1, 0, 0),
(396, 'Gungan Track', 2274, '2010-09-25', '1,40,44,45,28,28,40,44,45,24,32,40,44,45,3', 'skoky jen skoky', 15, 0, 1, 0, 0),
(397, 'Rocky Mountains', 1904, '2010-10-05', '1,18,37,19,19,40,61,47,47,47,48,48,59,48,48,36,50,51,51,51,50,20,20,20,57,61,57,59,57,37,37,50,50,50,50,36,49,49,19,19,45,35,35,18,18,18,18,18,18,18,32,47,35,47,35,47,47,47,48,34,48,59,49,49,35,50,50,51,34,33,51,51,51,51,51,20,20,57,57,59,57,57,26,26,26,26,26,57,61,61,57,19,19,19,51,51,51,51,47,47,47,34,34,29,29,20,20,20,20,45,20,19,19,19,47,47,47,3', '', 118, 0, 1, 0, 0),
(398, 'Qwerta by Meta', 2353, '2010-11-27', '1,8,44,24,24,50,28,59,31,31,57,23,23,7,25,11,17,3', 'Standartní mapa', 18, 0, 1, 0, 1),
(399, 'The Game', 864, '2010-12-18', '1,8,47,23,21,11,17,40,40,40,9,28,33,25,45,37,37,61,63,60,27,33,24,5,5,4,57,57,57,3', '', 30, 0, 1, 0, 0),
(400, 'Bleed It Out', 864, '2010-12-18', '1,4,23,24,23,9,26,32,47,11,17,22,24,29,23,27,28,57,61,37,23,24,6,19,36,33,21,21,23,23,59,60,27,6,8,24,26,6,60,63,22,32,5,20,19,26,51,47,49,52,5,5,19,19,4,45,23,21,29,6,7,27,50,7,4,4,3', '', 67, 0, 0, 0, 0),
(401, 'Empty Spaces', 864, '2010-12-18', '1,4,28,28,4,4,4,24,24,4,4,4,4,50,50,48,48,48,48,48,40,40,40,40,40,40,6,11,16,11,16,11,16,22,24,21,8,8,9,5,59,59,5,61,28,22,23,40,40,40,11,16,11,17,61,63,63,61,61,3', '', 60, 0, 0, 0, 0),
(402, 'The Curse', 864, '2010-12-18', '1,37,37,49,4,24,24,24,59,28,8,9,6,26,11,17,51,52,26,28,27,22,37,37,36,35,22,24,29,40,40,44,28,33,35,45,45,44,45,45,26,35,28,27,28,60,23,30,29,22,40,40,40,40,40,40,45,45,45,24,26,4,4,4,3', '', 65, 0, 0, 0, 0),
(403, 'Land Of Confusion', 864, '2010-12-18', '1,5,6,49,51,24,22,21,59,63,61,60,37,4,6,23,22,21,21,25,26,21,21,11,17,20,9,21,22,21,26,50,57,57,26,33,25,63,60,6,7,9,21,22,21,22,21,21,49,61,37,26,25,11,16,5,4,23,21,21,27,26,25,25,25,57,60,21,60,4,27,27,26,25,27,3', '', 76, 0, 0, 0, 0),
(404, 'Pollution', 864, '2010-12-18', '1,37,37,37,37,37,37,37,37,37,36,9,36,37,37,37,37,37,37,37,37,37,36,9,36,37,37,37,37,37,37,37,37,3', '', 34, 0, 0, 0, 0),
(405, 'Temptation', 864, '2010-12-18', '1,50,50,50,50,50,50,36,9,36,50,50,50,50,50,50,36,9,36,50,50,50,50,50,50,3', '', 26, 0, 0, 0, 0),
(406, 'Jesus Saves', 864, '2010-12-18', '1,21,21,21,21,21,21,21,21,21,21,21,22,21,21,21,22,21,22,21,22,21,23,22,21,23,23,23,24,23,24,59,59,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,26,25,25,25,25,25,25,25,25,26,25,25,25,26,25,25,25,25,25,26,25,26,25,25,25,25,26,25,26,25,26,25,25,26,25,26,26,25,26,25,26,26,26,26,26,26,26,27,26,26,27,27,27,27,28,59,59,59,59,21,21,21,21,21,21,21,21,25,25,25,25,25,25,25,21,21,21,21,21,21,21,25,25,25,25,25,25,25,25,25,21,21,21,21,21,21,21,25,25,25,25,25,25,25,21,21,21,21,21,21,21,25,25,25,25,25,25,25,25,25,21,21,21,21,21,21,21,21,21,3', '', 183, 0, 0, 0, 0),
(407, 'Undisputed Attitude', 864, '2010-12-19', '1,57,57,60,59,21,22,23,22,40,40,40,37,61,26,25,26,27,11,17,44,44,44,27,26,23,22,37,37,57,37,11,16,48,49,21,22,23,21,6,5,26,26,25,25,26,40,44,45,37,60,63,50,50,5,6,40,60,21,21,21,4,3', '', 63, 0, 0, 0, 0),
(408, 'Nameless', 864, '2010-12-19', '1,7,7,26,25,27,25,26,48,49,27,26,11,16,57,57,60,25,26,27,40,40,40,45,51,37,37,37,36,27,26,37,37,61,48,36,35,33,26,59,37,37,37,37,40,44,44,50,48,47,48,40,40,40,40,40,27,26,25,26,11,17,11,16,48,57,60,63,63,63,26,25,26,26,40,11,16,52,52,45,40,40,40,40,22,21,48,49,26,25,26,25,49,47,7,5,8,8,20,3', '', 100, 0, 0, 0, 0),
(409, 'nvnnv', 2379, '2010-12-19', '1,19,20,24,24,44,52,50,37,61,24,32,49,63,11,16,3', 'vnv', 17, 0, 0, 0, 0),
(410, 'Jedi Style', 2395, '2011-01-02', '1,8,40,11,17,9,6,44,30,30,19,20,35,27,4,18,18,20,28,34,61,59,63,37,57,47,26,27,4,18,18,18,18,5,27,27,40,63,60,61,18,3', 'Jenom pravý Jedi zvítězí!', 42, 0, 4, 0, 1),
(411, 'Pro par IS navic', 832, '2011-01-03', '1,6,6,6,11,17,25,25,4,4,4,40,47,4,21,22,22,5,5,61,61,63,61,59,23,61,3', 'Tak sem vytvoril trat, ktera je kapanek delsi, ale prijemna na odjeti, ale zase ne moc prijemna-sanci by meli mit vsichni-od nejlehcich Sportu po nejopancerovanejsi Wreckery...', 27, 0, 0, 0, 0),
(412, 'H2O', 832, '2011-01-03', '1,6,9,49,50,49,27,26,25,6,5,63,59,63,26,26,26,26,26,27,24,61,61,23,22,26,61,59,63,61,26,26,26,4,4,26,27,28,37,3', 'Trat postavena primarne pro Combi zavodniky, parkrat si ji zajedte a zjistite proc...', 40, 0, 0, 0, 0),
(413, 'Jedi Hardcore', 2395, '2011-01-05', '1,7,35,37,57,60,57,24,40,45,49,27,27,6,19,20,59,35,26,48,51,50,9,37,61,59,63,28,34,26,57,57,6,9,19,48,28,8,7,8,40,29,31,11,17,8,7,3', 'Zkus dojet do cíle a přitom nerozmlátit kluzák. To jenom pravý Jedi dokáže.', 48, 0, 1, 0, 0),
(414, 'der Spaziergang', 969, '2011-01-09', '1,11,17,5,6,7,37,57,61,40,26,32,11,16,26,25,40,47,63,5,6,22,28,28,24,32,5,32,11,16,6,28,8,61,40,27,24,24,24,24,24,28,28,28,36,6,48,40,28,11,16,18,20,59,51,40,28,44,28,29,28,24,5,60,40,5,9,7,4,19,20,57,51,49,40,45,27,35,33,28,24,32,30,34,6,18,8,57,37,48,45,27,28,5,3', 'Nur ein ruhiger Spaziergang, nichts mehr!', 95, 0, 0, 0, 0),
(415, 'Prosinec', 969, '2011-01-11', '1,37,33,7,24,32,59,61,45,63,24,36,33,26,26,27,31,21,29,29,29,30,30,57,37,40,27,40,45,36,36,32,7,51,21,22,59,57,61,40,22,24,19,6,6,6,6,6,40,40,44,26,27,22,23,21,22,21,20,3', '12. měsíc', 60, 0, 0, 0, 0),
(416, 'Ultimate Race', 2395, '2011-01-18', '1,6,9,47,37,62,58,34,27,20,18,40,46,8,7,4,18,27,26,63,57,60,61,49,57,37,50,37,30,40,11,17,27,35,9,8,20,48,62,48,63,59,34,35,57,37,28,7,8,7,4,40,40,20,20,31,51,49,51,37,57,61,58,62,27,28,26,23,30,44,47,50,63,60,62,52,26,27,40,40,34,35,22,11,16,9,6,27,51,57,59,63,62,61,37,8,7,8,40,40,23,9,6,8,50,48,47,59,32,31,21,28,26,25,57,34,37,34,9,6,6,34,35,50,8,7,5,19,46,3', '', 130, 1, 1, 0, 0),
(417, 'Tartaros', 2395, '2011-01-19', '1,7,9,49,37,20,37,20,48,61,60,63,60,62,57,37,8,31,29,50,20,20,20,40,44,20,37,63,37,34,49,11,17,28,7,20,20,20,40,44,35,9,49,48,47,57,59,61,57,32,29,8,20,20,20,40,45,9,51,23,6,5,4,18,18,18,26,27,35,34,30,32,31,29,8,20,20,20,40,45,9,52,49,48,48,48,6,63,60,37,4,5,20,20,20,20,40,46,46,3', 'V řecké mytologii je Tartaros (Ταρταρος, 2.pád Tartaru, latinsky Tartarus) mohutná propast se železnými zdmi a branami, vzniklá z provopočátečního chaosu. Leží tak hluboko pod zemí, jak vysoko je nebe nad zemí. Železná kovadlina by ze zemského povrchu padala na její dno devět dní a nocí. Je tam třikrát větší tma než v noci na světě.', 100, 0, 1, 0, 0),
(418, 'Elite Race', 2395, '2011-02-05', '1,9,6,9,8,7,36,35,37,37,60,37,6,9,9,6,24,48,51,52,49,59,47,50,36,35,27,6,9,57,57,63,57,62,57,61,57,63,60,63,27,36,8,7,4,5,18,40,46,3', 'Vítejte na nejmodernější trati známého vesmíru. Tato trať se jede kamenitou stezkou, napříč krásnými kaňony, lesy plných nádherné zvěře a přes území jezer na hvězdě Xibalba obklopenou zářící mlhovinou. V těchto extrémních podmínkách se sjízdějí jezdci všech ras v zavodě, který přináší divákům nádhernou podívanou a obrovskou dávku adrenalinu.\nZávodníci, připravte se na své pozice...START!', 50, 2, 1, 0, 0),
(419, 'Long Run', 2395, '2011-02-06', '1,5,4,7,8,9,9,9,9,33,33,33,34,34,33,33,33,36,9,52,9,32,9,44,9,32,9,6,49,49,49,49,49,57,61,57,63,57,60,57,62,60,62,59,62,58,62,59,62,60,62,57,57,57,49,49,44,49,49,6,9,36,32,35,35,35,35,31,31,31,31,9,9,52,37,52,37,52,9,9,11,17,40,48,57,57,61,63,57,61,63,57,57,48,5,27,27,5,5,5,4,4,4,18,18,18,40,46,49,34,34,8,8,8,7,7,7,50,51,52,34,34,61,59,61,60,63,57,57,57,37,37,37,52,3', 'Dlouhá jízda do neznáma.', 135, 0, 0, 0, 0),
(420, 'Cup 1v1', 832, '2011-02-28', '1,37,27,26,26,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,25,3', '', 29, 0, 1, 0, 0),
(421, 'Cup 2v1', 832, '2011-03-01', '1,4,4,4,47,24,23,27,27,27,26,11,16,4,4,21,4,61,61,58,61,4,4,4,36,36,4,4,4,61,58,61,63,4,4,3', '', 36, 0, 1, 0, 0),
(422, 'Cup 3v1', 832, '2011-03-05', '1,40,40,11,17,4,4,22,26,26,27,25,4,4,5,6,48,49,28,27,27,48,4,9,9,4,3', '', 27, 2, 0, 0, 0),
(423, 'Heavy Metal', 1160, '2011-03-06', '1,19,19,18,19,19,11,17,19,22,47,25,26,27,21,24,25,40,20,20,19,19,40,6,36,36,32,32,36,4,4,5,5,6,6,49,49,49,7,19,22,22,5,5,25,25,26,37,37,37,20,20,26,27,49,52,61,58,61,59,61,60,61,4,4,4,57,57,57,11,16,24,4,28,4,4,28,4,4,28,28,4,23,23,24,26,4,20,20,20,19,19,4,4,5,5,5,6,6,3', 'Prostě Heavy Metal', 100, 0, 0, 0, 0),
(424, 'Mountain trip', 1160, '2011-03-09', '1,4,4,21,21,22,25,25,26,4,5,6,6,6,57,57,63,58,62,59,61,57,37,37,37,37,32,31,8,34,35,57,57,8,8,50,33,34,34,34,34,34,25,4,4,23,27,24,27,40,40,20,25,26,20,20,20,3', '', 58, 0, 0, 0, 0),
(425, 'Hills have eyes', 1160, '2011-03-09', '1,4,4,4,4,4,22,22,18,18,40,40,40,11,17,8,9,31,32,36,35,35,30,50,4,4,4,48,23,23,23,25,4,5,6,6,28,28,22,37,37,37,33,34,35,34,6,5,4,3', '', 50, 1, 0, 0, 0),
(426, 'Cup 4v1', 832, '2011-03-16', '1,4,4,4,4,49,45,40,40,40,26,26,26,26,27,23,61,61,61,61,4,4,26,11,16,26,26,57,57,57,37,22,23,23,23,27,44,6,26,50,50,6,5,4,3', '', 45, 1, 0, 0, 0),
(427, 'Cup 5v1', 832, '2011-03-16', '1,57,57,57,57,61,59,62,37,48,49,26,27,28,25,50,50,26,26,26,6,6,9,9,57,57,57,57,57,26,27,4,27,4,57,57,57,61,61,60,63,50,51,26,27,27,3', '', 47, 0, 0, 0, 0),
(428, 'Lamasground NEW', 2147, '2011-03-31', '1,18,6,24,32,44,26,37,40,5,6,9,19,19,4,3', 'Trať pro nováčky jak dělaná.', 16, 0, 1, 0, 0),
(429, 'Kanthar', 2517, '2011-05-30', '1,4,36,52,48,22,11,16,6,20,46,24,4,4,20,61,57,24,24,57,37,35,20,20,3', 'Oblasť kantaru', 25, 0, 1, 0, 0),
(430, 'Why so serious', 2385, '2011-06-26', '1,4,21,4,25,25,4,40,44,4,25,26,26,26,5,26,4,26,26,5,5,5,5,22,40,5,18,23,7,46,18,22,22,4,22,48,49,5,22,59,4,20,23,7,47,22,3', 'radši žádny popis', 47, 0, 0, 0, 0),
(431, 'metal forces', 2114, '2011-12-04', '1,5,4,36,46,44,51,59,57,58,37,11,16,5,9,61,3', 'jen nejodvážnější tuhle trať zvládnou hahaha', 17, 1, 1, 0, 0),
(432, 'Death', 2400, '2012-01-30', '1,8,8,9,27,32,11,16,61,27,27,27,4,4,37,28,6,5,4,40,3', '', 21, 1, 0, 0, 0),
(433, 'DaRlOnG', 2690, '2012-05-29', '1,6,45,36,32,32,32,36,51,11,16,32,32,62,36,59,40,34,32,32,20,19,3', 'bomba', 23, 1, 0, 0, 0),
(434, 'Blitzkrieg', 2773, '2012-11-18', '1,18,19,11,17,26,18,6,28,48,47,28,46,26,61,62,18,18,18,18,5,19,20,28,36,63,59,22,21,18,18,18,3', '', 33, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `trate_druhy`
--

DROP TABLE IF EXISTS `trate_druhy`;
CREATE TABLE IF NOT EXISTS `trate_druhy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(90) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `nebezpeci` float NOT NULL DEFAULT '0',
  `rychlost` float NOT NULL DEFAULT '0',
  `typ` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=64 ;

--
-- Vypisuji data pro tabulku `trate_druhy`
--

INSERT INTO `trate_druhy` (`id`, `nazev`, `nebezpeci`, `rychlost`, `typ`) VALUES
(1, 'Start', 7, 100, 0),
(2, 'Start s depem', 7, 100, 0),
(3, 'Cíl', 7, 100, 0),
(4, 'Široká cesta', 12, 92, 1),
(5, 'Cesta', 10, 86, 1),
(6, 'Úzká cesta', 20, 72, 1),
(7, 'Kamenitá široká cesta', 18, 82, 1),
(8, 'Kamenitá cesta', 23, 71, 1),
(9, 'Kamenitá úzká cesta', 40, 57, 1),
(10, 'Široké rozdvojení cesty', 20, 94, 3),
(11, 'Rozdvojení cesty', 23, 89, 3),
(12, 'Úzké rozdvojení cesty', 33, 81, 3),
(13, 'Kamenité široké rozdvojení cesty', 27, 86, 3),
(14, 'Kamenité rozdvojení cesty', 43, 71, 3),
(15, 'Kamenité úzké rozdvojení cesty', 60, 59, 3),
(16, 'Spojení cesty', 20, 92, 3),
(17, 'Kamenité spojení cesty', 20, 80, 3),
(18, 'Rovinka', 7, 100, 1),
(19, 'Rovinka do kopce', 10, 98, 1),
(20, 'Rovinka z kopce', 12, 98, 1),
(21, 'Levá mírná zatáčka', 13, 96, 2),
(22, 'Levá zatáčka', 20, 90, 2),
(23, 'Levá ostrá zatáčka', 37, 75, 2),
(24, 'Levé elko', 53, 33, 2),
(25, 'Pravá mírná zatáčka', 13, 96, 2),
(26, 'Pravá zatáčka', 20, 90, 2),
(27, 'Pravá ostrá zatáčka', 37, 75, 2),
(28, 'Pravé elko', 53, 33, 2),
(29, 'Kamenitá levá mírná zatáčka', 27, 85, 2),
(30, 'Kamenitá levá zatáčka', 37, 80, 2),
(31, 'Kamenitá levá ostrá zatáčka', 53, 65, 2),
(32, 'Kamenité levé elko', 70, 25, 2),
(33, 'Kamenitá pravá mírná zatáčka', 27, 85, 2),
(34, 'Kamenitá pravá zatáčka', 37, 80, 2),
(35, 'Kamenitá pravá ostrá zatáčka', 53, 65, 2),
(36, 'Kamenité pravé elko', 70, 25, 2),
(37, 'Serpentiny', 77, 35, 2),
(38, 'Práh', 17, 95, 3),
(39, 'Menší skok', 22, 89, 3),
(40, 'Skok', 28, 79, 3),
(41, 'Vetší skok', 47, 73, 3),
(42, 'Dlouhý skok', 37, 86, 3),
(43, 'Vysoký skok', 42, 75, 3),
(44, 'Malá propast', 70, 80, 3),
(45, 'Propast', 77, 80, 3),
(46, 'Velká propast', 90, 80, 3),
(47, 'Široký kaňon', 33, 92, 3),
(48, 'Kaňon', 40, 82, 3),
(49, 'Úzký kaňon', 53, 69, 3),
(50, 'Kamenitý široký kaňon', 43, 79, 3),
(51, 'Kamenitý kaňon', 63, 65, 3),
(52, 'Kamenitý úzký kaňon', 93, 48, 3),
(53, 'Průsmyk', 40, 76, 3),
(54, 'Velká škvíra', 43, 62, 3),
(55, 'Škvíra', 57, 55, 3),
(56, 'Malá škvíra', 87, 42, 3),
(57, 'Les', 63, 69, 3),
(58, 'Široký most', 27, 100, 1),
(59, 'Most', 37, 92, 1),
(60, 'Úzký most', 50, 72, 1),
(61, 'Velké jezero', 10, 60, 3),
(62, 'Jezero', 10, 60, 3),
(63, 'Malé jezero', 13, 60, 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `zavodnici`
--

DROP TABLE IF EXISTS `zavodnici`;
CREATE TABLE IF NOT EXISTS `zavodnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `zavod` int(11) NOT NULL DEFAULT '0',
  `opatrnost` smallint(6) NOT NULL,
  `agresivita` smallint(6) NOT NULL,
  `postoj` tinyint(4) NOT NULL,
  `obet` int(11) NOT NULL DEFAULT '0',
  `taktika` tinyint(4) NOT NULL DEFAULT '3',
  `poradi` int(11) NOT NULL DEFAULT '0',
  `vyhra` float DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `zavody`
--

DROP TABLE IF EXISTS `zavody`;
CREATE TABLE IF NOT EXISTS `zavody` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL DEFAULT '0',
  `nazev` varchar(40) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `popis` text COLLATE utf8_czech_ci NOT NULL,
  `vklad` float NOT NULL DEFAULT '0',
  `dotace` float NOT NULL DEFAULT '0',
  `sazky` float NOT NULL DEFAULT '0',
  `vklady` float NOT NULL DEFAULT '0',
  `datum` date NOT NULL DEFAULT '0000-00-00',
  `pocet` int(11) NOT NULL DEFAULT '0',
  `trat` int(11) NOT NULL DEFAULT '0',
  `vitez` int(11) NOT NULL DEFAULT '0',
  `cas` int(11) NOT NULL DEFAULT '0',
  `prestiz` int(11) NOT NULL DEFAULT '0',
  `prestiz2` int(11) NOT NULL DEFAULT '0',
  `divaci` int(11) NOT NULL DEFAULT '0',
  `typ` int(11) NOT NULL DEFAULT '0',
  `heslo` varchar(255) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `cena` int(11) NOT NULL DEFAULT '0',
  `minimum` int(11) NOT NULL DEFAULT '2',
  `predmet` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci PACK_KEYS=0 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `zbozi`
--

DROP TABLE IF EXISTS `zbozi`;
CREATE TABLE IF NOT EXISTS `zbozi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zbozi` int(11) NOT NULL DEFAULT '0',
  `typ` int(11) NOT NULL DEFAULT '0',
  `obchodnik` int(11) NOT NULL DEFAULT '0',
  `cena` float NOT NULL DEFAULT '0',
  `kusy` int(11) NOT NULL DEFAULT '0',
  `celkem` int(11) NOT NULL DEFAULT '0',
  `etapa` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `zdroje`
--

DROP TABLE IF EXISTS `zdroje`;
CREATE TABLE IF NOT EXISTS `zdroje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(100) COLLATE utf8_czech_ci NOT NULL DEFAULT '',
  `vykon` int(11) NOT NULL DEFAULT '0',
  `chlazeni` int(11) NOT NULL DEFAULT '0',
  `vydrz` int(11) NOT NULL DEFAULT '0',
  `podvozek` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=31 ;

--
-- Vypisuji data pro tabulku `zdroje`
--

INSERT INTO `zdroje` (`id`, `nazev`, `vykon`, `chlazeni`, `vydrz`, `podvozek`) VALUES
(1, 'Balmon light', 30, 0, 80, 0),
(2, 'Wrench battery', 35, 0, 100, 0),
(3, 'Trien lug', 40, 0, 110, 0),
(4, 'Skorpion', 45, 0, 120, 0),
(5, 'Balmon heavy', 50, 0, 140, 0),
(6, 'Leorgen half', 55, 0, 155, 0),
(7, 'Zirkonid crystal 15', 60, 0, 160, 0),
(8, 'Zirkonid crystal 25', 65, 0, 180, 0),
(9, 'Nakadrian 185', 75, 0, 185, 0),
(10, 'Fotonsyntetic', 85, 0, 190, 0),
(11, 'Solar panel', 100, 0, 200, 0),
(12, 'Compakt', 120, 0, 210, 0),
(13, 'Naolin', 135, 0, 215, 0),
(14, 'Shiroko', 140, 0, 230, 0),
(15, 'Nakadrian 250', 160, 0, 250, 0),
(16, 'Perien', 180, 0, 280, 0),
(17, 'Leorgen full', 200, 0, 300, 0),
(18, 'Labadon', 210, 0, 400, 0),
(19, 'Nakadag 10', 230, 0, 425, 0),
(20, 'Berrion', 260, 0, 460, 0),
(21, 'Carbon hell', 290, 0, 480, 0),
(22, 'Holyon 500', 300, 0, 500, 0),
(23, 'Ovis Corpus', 325, 0, 520, 0),
(24, 'Glorious energy', 350, 0, 560, 0),
(25, 'Caesarion', 375, 0, 580, 0),
(26, 'Helium explosive', 380, 0, 600, 0),
(27, 'Unrannium reactor', 400, 0, 610, 0),
(28, 'Mastodont Energy', 430, 0, 620, 0),
(29, 'Nakadag 20', 480, 0, 650, 0),
(30, 'Heaven power', 500, 0, 700, 0);
