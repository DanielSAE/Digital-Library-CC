-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: 172.10.10.143
-- Erstellungszeit: 06. Mai 2012 um 17:36
-- Server Version: 5.1.61
-- PHP-Version: 5.2.17-pl0-gentoo

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `digital_library`
--
CREATE DATABASE `digital_library` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `digital_library`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dl_books`
--

CREATE TABLE IF NOT EXISTS `dl_books` (
  `b_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `b_articlenumber` int(4) NOT NULL,
  `b_name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `b_price` decimal(6,2) unsigned NOT NULL,
  `b_quantity` int(10) NOT NULL,
  `b_genre` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `b_totalrent` int(11) NOT NULL DEFAULT '0',
  `b_releasedate` date DEFAULT NULL,
  `b_content` text COLLATE utf8_unicode_ci,
  `b_author` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `b_publisher` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `b_isbn` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`b_id`),
  UNIQUE KEY `a_artikelnr` (`b_articlenumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Daten für Tabelle `dl_books`
--

INSERT INTO `dl_books` (`b_id`, `b_articlenumber`, `b_name`, `b_price`, `b_quantity`, `b_genre`, `b_totalrent`, `b_releasedate`, `b_content`, `b_author`, `b_publisher`, `b_isbn`) VALUES
(1, 1, 'Das Alphabethaus', 0.55, 93, 'Thriller', 7, '2012-03-01', 'Der Absturz zweier britischer Piloten hinter den feindlichen Linien...\r\nEin Krankenhaus im Breisgau, in dem psychisch Kranke als Versuchskaninchen für Psychopharmaka dienen...\r\nDie dramatische Suche eines Mannes nach seinem Freund, den er dreißig Jahre zuvor im Stich gelassen hat...', 'Adler Olsen', 'Dtv', '9783423248945'),
(2, 2, 'Unter Haien', 0.69, 49, 'Romane', 1, '2012-02-01', 'New York, 1998: Die junge Investmentbankerin Alex Sontheim ist durch harte Arbeit und Zielstrebigkeit dort angekommen, wo sie immer hinwollte: ganz oben. Als sie den milliardenschweren Geschäftsmann Sergio Vitali kennenlernt, beginnt eine heiße Affäre. Alex genießt es, am Leben der wirklich Mächtigen teilzuhaben und gibt zunächst nichts auf die Stimmen, die sie vor Vitali warnen. Doch dann bringt eine ungeheuerliche Entdeckung Alex in tödliche Gefahr. ', 'Nele Neuhaus ', 'Ullstein Tb', '9783548284798'),
(3, 3, 'Grabesstille / Jane Rizzoli Bd.9', 0.39, 47, 'Thriller', 3, '2012-02-03', 'Wohliger Schauer oder nackte Angst. Was, wenn die Geistergeschichten Ihrer Kindheit wahr würden?\r\n\r\nJahraus, jahrein werden sie an den schrecklichen Tag erinnert, da in einem kleinen Restaurant in Chinatown ein Amokläufer ihre Angehörigen hinrichtete. Doch wer schreibt die Briefe, die besagen, dass der wahre Täter noch immer nicht gefasst sei? Erst als neunzehn Jahre später bei einer Stadtführung durch Boston die Leiche einer Frau gefunden wird, die mit einem antiken chinesischen Ritualschwert verstümmelt wurde, wird der alte Fall wiederaufgerollt. Und nicht immer haben Jane Rizzoli und Maura Isles bei den Ermittlungen das Gefühl, es mit einem leibhaftigen Gegner aus Fleisch und Blut zu tun zu haben ... ', 'Tess Gerritsen ', 'Limes', '9783809025771'),
(4, 4, 'Der Junge, der Träume schenkte', 0.65, 30, 'Romane ', 7, '2011-02-01', 'New York, 1909. Aus einem transatlantischen Frachter steigt eine junge Frau mit ihrem Sohn Natale. Sie kommen aus dem tiefsten Süden Italiens - mit dem Traum von einem besseren Leben in Amerika. Doch in der von Armut, Elend und Kriminalität gezeichneten Lower East Side gelten die gnadenlosen Gesetze der Gangs. Nur wer über ausreichend Robustheit und Durchsetzungskraft verfügt, kann sich hier behaupten. So wie der junge Natale, dem überdies ein besonderes Charisma zu eigen ist, mit dem er die Menschen zu verzaubern vermag...', 'Luca Di Fulvio ', 'Bastei Lübbe', '9783404160617'),
(5, 5, 'Sterbenskalt', 0.69, 9, 'Krimi', 11, '2012-02-10', 'Niemand lotet Charaktere gnadenloser aus, niemand zieht die Leser tiefer in die Atmosphäre: der dritte Irland-Kriminalroman der jungen irischen Literatin Tana French.\r\nFrank Mackey, Undercover-Ermittler, hat seine Familie seit 22 Jahren nicht gesehen. Die vier Geschwister, den trinkenden, gewalttätigen Vater, die ruppige Mutter. Er wollte der Armut und Perspektivlosigkeit seines Viertels für immer entfliehen zusammen mit seiner ersten großen Liebe Rosie. Doch die hatte ihn versetzt und war allein nach England aufgebrochen, so hat Frank es jedenfalls immer gedacht. Bis Rosies Koffer und ihre Fährtickets in dem alten Abbruchhaus in der Straße seiner Kindheit gefunden werden. Frank muss zurück nach Faithful Place und feststellen, dass er diesen dunklen Ort immer in sich getragen hat.', 'Tana French ', 'Fischer (Tb.), F', '9783596188345'),
(6, 6, 'Todesmelodie', 0.99, 49, 'Krimi', 1, '2011-12-20', 'Gleich der erste Fall nach ihrer Rückkehr in den aktiven Dienst verlangt Julia Durant, die immer noch unter dem Trauma ihrer Entführung leidet, wieder alles ab: In einem WG-Zimmer wird eine Studentin aufgefunden. Sie wurde grausam gequält und schließlich getötet, am Tatort läuft der Song Stairway to Heaven . Verbissen ermittelt das K11 die mutmaßlichen Verdächtigen, und das Gericht verurteilt sie zu hohen Haftstrafen. Zwei Jahre lang wähnen sich alle in dem Glauben, dass der Gerechtigkeit Genüge getan wurde. Doch dann taucht ein weiterer toter Student auf, und wieder spielt dasselbe Lied ', 'Franz, Andreas, Holbe, Daniel ', 'Droemer/Knaur', '9783426639443'),
(7, 7, 'Gefährliche Liebe / Die Tribute von Panem Bd.2', 0.59, 49, 'Romane ', 1, '2010-10-01', 'Spürst du, was sie wirklich fühlt? Seitdem Katniss und Peeta sich geweigert haben, einander in der Arena zu töten, werden sie vom Kapitol als Liebespaar durch das ganze Land geschickt. Doch da ist auch noch Gale, der Jugendfreund von Katniss. Und mit einem Mal weiß sie nicht mehr, was sie wirklich fühlt oder fühlen darf. Als immer mehr Menschen in ihr und Peeta ein Symbol des Widerstands sehen, geraten sie alle in große Gefahr. Und Katniss muss sich entscheiden zwischen Peeta und Gale, zwischen Freiheit und Sicherheit, zwischen Leben und Tod.', 'Suzanne Collins ', 'Oetinger', '9783789132193'),
(8, 8, 'Flammender Zorn / Die Tribute von Panem Bd. 3', 0.69, 48, 'Romane ', 2, '2011-02-01', 'Möge das Gute siegen! Möge die Liebe siegen! Das grandiose Finale! Katniss gegen das Kapitol! Schwer verletzt wurde Katniss von den Rebellen befreit und in Distrikt 13 gebracht. Doch ihre einzige Sorge gilt Peeta, der dem Kapitol in die Hände gefallen ist. Die Regierung setzt alle daran, seinen Willen zu brechen, um ihn als Waffe gegen die Rebellen einsetzen zu können. Gale hingegen kämpft weiterhin an der Seite der Aufständischen, und das, zu Katniss Schrecken, ohne Rücksicht auf Verluste. Als sie merkt, dass auch die Rebellen versuchen, sie für ihre Ziele zu missbrauchen, wird ihr klar, dass sie alle nur Figuren in einem perfiden Spiel sind. Es scheint ihr fast unmöglich, die zu schützen, die sie liebt. ', 'Suzanne Collins ', 'Oetinger', '9783789132209'),
(9, 9, 'Tödliche Spiele / Die Tribute von Panem Bd.1', 0.49, 49, 'Romane', 1, '2009-10-01', 'Überwältigend! Von der Macht der Liebe in grausamer Zeit... Nordamerika existiert nicht mehr. Kriege und Naturkatastrophen haben das Land zerstört. Aus den Trümmern ist Panem entstanden, geführt von einer unerbittlichen Regierung. Alljährlich finden grausame Spiele statt, bei denen nur ein Einziger überleben darf. Als die sechzehnjährige Katniss erfährt, dass ihre kleine Schwester ausgelost wurde, meldet sie sich an ihrer Stelle und nimmt Seite an Seite mit dem gleichaltrigen Peeta den Kampf auf. Wider alle Regeln rettet er ihr das Leben. Katniss beginnt zu zweifeln - was empfindet sie für Peeta? Und kann wirklich nur einer von ihnen überleben? Eine faszinierende Gesellschaftsutopie über eine unsterbliche Liebe und tödliche Gefahren, hinreißend gefühlvoll und super spannend. ', 'Suzanne Collins ', 'Oetinger', '9783841501349'),
(10, 10, 'Erbarmen / Der erste Fall für Carl Mørck Bd.1', 0.55, 48, 'Biographien ', 2, '2011-09-01', 'Der Albtraum einer Frau.\r\nEin dämonischer Psychothriller.\r\nDie verzerrte Stimme kam aus einem Lautsprecher irgendwo im Dunklen: Herzlichen Glückwunsch zu deinem Geburtstag, Merete. Du bist jetzt hier seit 126 Tagen, und das ist unser Geburtstagsgeschenk: Das Licht wird von nun an ein Jahr lang eingeschaltet bleiben. Es sei denn, du weißt die Antwort: Warum halten wir dich fest?\r\nAm 2. März 2002 verschwindet eine Frau spurlos auf der Fähre von Rødby nach Puttgarden, man vermutet Tod durch Ertrinken. Doch sie ist nicht tot, sondern wird in einem Gefängnis aus Beton gefangen gehalten.\r\nWer sind die Täter?\r\nWas wollen sie von dieser Frau?\r\nUnd: Kann ein Mensch ein solches Martyrium überleben?\r\nDer erste Fall für Carl Mørck, Spezialermittler des neu eingerichteten Sonderdezernats Q bei der Kopenhagener Polizei, und seinen syrischen Assistenten Hafez el-Assad, der seinen Chef nicht nur durch unkonventionelle Ermittlungsmethoden überrascht ... ', 'Jussi Adler-Olsen ', 'Dtv', '9783423212625'),
(11, 11, 'Schlank im Schlaf', 0.39, 10, 'Gesundheit ', 0, '2006-03-02', 'Der Schlaf ist die längste Fettverbrennungsphase am Tag. Lernen Sie, diese effektiv für sich zu nutzen. Entscheidend ist, den Körper morgens, mittags und abends jeweils mit dem richtigen Nährstoff-Mix zu versorgen, damit er das bekommt, was er gemäß seinem Biorhythmus optimal verwerten kann.\r\n\r\nAm Tag sind vor allem Kohlenhydrate als Energiequelle wichtig, um leistungsfähig zu sein. Die Nacht nutzt der Körper zur Erholung und für Reparaturen - eine eiweißreiche Mahlzeit sorgt dafür, dass die Energie dafür aus den Fettzellen kommt.\r\n\r\nWer also das Richtige zum richtigen Zeitpunkt isst, macht bald nicht nur im Traum eine gute Figur! Das Buch erklärt, wie man den Einfluss des Dickmacherhormons Insulin hemmt und die Schlankmacher-Hormone gezielt aktiviert. Interessante Vorgänge, die sich Tag für Tag im Körper abspielen, werden veranschaulicht. Sattmacher-Rezepte werden ideal kombiniert mit Kraft- und Ausdauertraining für optimale Fettverbrennung. ', 'Detlef Pape Rudolf Schwarz, Helmut Gillessen, ', 'Gräfe & Unzer', '9783774287792'),
(12, 12, 'The Casual Vacancy', 0.99, 30, 'Romane', 0, '2012-04-27', 'When Barry Fairweather dies unexpectedly in his early forties, the little town of Pagford is left in shock.\r\n\r\nPagford is, seemingly, an English idyll, with a cobbled market square and an ancient abbey, but what lies behind the pretty façade is a town at war.\r\n\r\nRich at war with poor, teenagers at war with their parents, wives at war with their husbands, teachers at war with their pupils...Pagford is not what it first seems.\r\n\r\nAnd the empty seat left by Barry on the parish council soon becomes the catalyst for the biggest war the town has yet seen. Who will triumph in an election fraught with passion, duplicity and unexpected revelations? ', 'Joanne K. Rowling ', 'Little, Brown Bo', '9781408704202'),
(13, 13, 'Blender', 0.59, 29, 'Romane', 1, '2012-02-02', 'Intriganten, Pöstchenjäger, Luftpumpen und Schlipswichser: Sie alle gehören zum Inventar einer ganz normalen Karriere von Frauen, die eigentlich nur eines wollen: die Aufgabe besonders gut und zuverlässig erledigen. Dabei treffen sie auf männliche Platzhalter, die sich, schlechter ausgebildet, sozial wenig kompetent und längst nicht so engagiert wie ihre weiblichen Kolleginnen, durch den Büroalltag mogeln. Dafür sahnen Blender mehr Lohn ab und fallen auf magische Weise die Karriereleiter hinauf. Schonungslos entlarvt Roman Maria Koidl Strategien, Rhetorik und Taktik der Schaumschläger und erklärt, warum Frauen Blendern auch noch gern zuarbeiten, statt an die eigene Karriere zu denken. ', 'M. Koidl ', 'Hoffmann Und Cam', '9783455502183'),
(14, 14, 'Ziemlich beste Freunde', 0.49, 20, 'Biographien ', 0, '2012-03-01', 'Der bewegende autobiographische Bericht Philippe Pozzo di Borgos, der den Stoff für einen sensationellen Kinoerfolg lieferte. Der Autor ist Geschäftsführer der Firma Champagnes Pommery, als er mit dem Gleitschirm abstürzt und querschnittsgelähmt bleibt. Er ist 42 Jahre alt und braucht einen Intensivpfleger. Der arbeitslose Ex-Sträfling Abdel kriegt den Job. Mit seiner lebensfrohen und authentischen Art wird Abdel zu Philippes Schutzteufel. Zehn Jahre lang pflegt er ihn und gibt ihm die Lebensfreude zurück. Von O. Nakache und E. Toledano verfilmt, ist diese Geschichte einer Freundschaft, die auf Respekt und Toleranz gründet, zu einem der erfolgreichsten französischen Filme aller Zeiten geworden.\r\n\r\nPhilippe Pozzo di Borgo ist Geschäftsführer der Firma Champagnes Pommery, als er mit dem Gleitschirm abstürzt und vom Hals ab querschnittsgelähmt bleibt. Er ist 42 Jahre alt und braucht einen Intensivpfleger. Der arbeitslose Ex-Sträfling Abdel erscheint zum Vorstellungsgespräch eigentlich nur, um eine Unterschrift fürs Sozialamt zu bekommen. Und kriegt den Job. Mit seiner mitleidslosen, lebensfrohen, ungehobelten und authentischen Art wird Abdel zu Philippes Schutzteufel. Zehn Jahre lang begleitet er ihn durch alle dramatischen und komischen Momente seines Lebens und gibt ihm die Lebensfreude zurück.\r\nVon Olivier Nakache und Eric Toledano verfilmt, ist dieses moderne Märchen zu einem der erfolgreichsten französischen Filme aller Zeiten geworden. Eine wahre Geschichte, die man sich nur unter höchstem Kitschverdacht hätte ausdenken können. ', 'Philippe Pozzo di Borgo ', 'Hanser Berlin', '9783446240445'),
(15, 15, 'Das Weight Watchers® Kochbuch', 0.29, 20, 'Gesundheit', 0, '2012-02-15', 'Von wärmenden Suppen und Eintöpfen bis zu süßen Speisen und Kuchen - einfach ein Hochgenuss!\r\n\r\nGesundes Abnehmen mit viel Genuss: Dafür steht Weight Watchers. Mit dem ProPoints® Plan haben die Ernährungsexperten das Abnehmen noch leichter gemacht. Er ist alltagstauglich, präzise und bietet dabei ein Höchstmaß an Flexibilität. Jetzt präsentiert Weight Watchers die leckersten Rezepte mit ProPoints® Werten - abwechslungsreich und einfach nachzukochen.\r\n\r\nDas Weight Watchers Ernährungsprogramm gilt weltweit als ausgewogene und erfolgreiche Methode der langfristigen Gewichtsreduktion. Millionen haben damit ihr Wunschgewicht erreicht. Der bereits bestens erprobte ProPoints® Plan zeigt, dass entspanntes Abnehmen mühelos in jeden Alltag passt - lästiges Kalorienzählen gehört endgültig der Vergangenheit an. Mit köstlichen Gerichten wie Karotten-Ingwer-Suppe, Entenbrust mit Brokkoli und Mandeln oder feinem Walnusskuchen bleiben keine Wünsche offen: Hier findet jeder seine Lieblingsrezepte. Das Weight Watchers Kochbuch weist den Weg in eine federleichte Zukunft. Nie war es einfacher, gesund und dauerhaft schlank zu werden!', 'Weight Watchers ', 'Heyne', '9783453200173'),
(16, 16, 'Die besten Breie für Ihr Baby', 0.29, 15, 'Gesundheit', 0, '2010-10-15', 'Gesund, frisch und lecker - so sollten Baby-Breie sein. Viele Eltern wollen ihren Kindern keine Fertiggerichte vorsetzen, haben oft aber nicht genug Zeit, um stundenlang in der Küche zu stehen. Der überarbeitete Ratgeber bietet viele leckere Rezepte, die schnell zubereitet sind und für die wenige Zutaten gebraucht werden. Für die Neuauflage wurde die Bildsprache modernisiert. Zur einfachen Orientierung durch das Buch dient ein pfiffiges Farbleitsystem. Die Tipps zur Allergieprävention wurden auf den neuesten Stand gebracht. ', 'Anne Iburg ', 'Trias', '9783830435563');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dl_rent`
--

CREATE TABLE IF NOT EXISTS `dl_rent` (
  `r_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `r_articlenumber` int(10) unsigned NOT NULL,
  `r_days` int(10) unsigned NOT NULL DEFAULT '1',
  `r_quantity` int(11) NOT NULL,
  `r_usernumber` int(10) unsigned NOT NULL COMMENT 'Usernumber',
  `r_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`r_id`),
  KEY `b_artikelnr` (`r_articlenumber`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Daten für Tabelle `dl_rent`
--

INSERT INTO `dl_rent` (`r_id`, `r_articlenumber`, `r_days`, `r_quantity`, `r_usernumber`, `r_date`) VALUES
(13, 5, 8, 1, 152, '2012-05-06 14:51:35');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dl_reserve`
--

CREATE TABLE IF NOT EXISTS `dl_reserve` (
  `res_id` int(11) NOT NULL AUTO_INCREMENT,
  `res_articlenumber` int(10) unsigned NOT NULL,
  `res_days` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Dauer des Leihvorgangs',
  `res_quantity` int(11) NOT NULL,
  `res_usernumber` int(10) unsigned NOT NULL COMMENT 'Kundennummer',
  `res_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Uhrzeit des Eintrages',
  PRIMARY KEY (`res_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Daten für Tabelle `dl_reserve`
--

INSERT INTO `dl_reserve` (`res_id`, `res_articlenumber`, `res_days`, `res_quantity`, `res_usernumber`, `res_timestamp`) VALUES
(18, 4, 1, 1, 151, '2012-05-06 14:40:16'),
(17, 5, 2, 1, 151, '2012-05-06 14:40:12'),
(15, 1, 1, 1, 151, '2012-05-06 14:35:44'),
(19, 10, 1, 1, 151, '2012-05-06 14:40:18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dl_user`
--

CREATE TABLE IF NOT EXISTS `dl_user` (
  `u_usernumber` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `u_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Username',
  `u_firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User Firstname',
  `u_postcode` varchar(6) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Postcode',
  `u_city` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'City',
  `u_street` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Street',
  `s_postcode` varchar(6) COLLATE utf8_unicode_ci NOT NULL COMMENT 'shipping postcode',
  `s_city` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'shipping city',
  `s_street` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'shipping street',
  `u_email` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'E-Mail ',
  `u_password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `u_nickname` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `u_userid` int(1) NOT NULL COMMENT 'User Level',
  `u_registerdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `u_activatecode` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_resetcode` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`u_usernumber`),
  UNIQUE KEY `u_email` (`u_email`),
  UNIQUE KEY `u_nickname` (`u_nickname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `dl_user`
--

INSERT INTO `dl_user` (`u_usernumber`, `u_name`, `u_firstname`, `u_postcode`, `u_city`, `u_street`, `s_postcode`, `s_city`, `s_street`, `u_email`, `u_password`, `u_nickname`, `u_userid`, `u_registerdate`, `u_activatecode`, `u_resetcode`) VALUES
(1, 'Daniel', 'Böttcher', '04451', 'Borsdorf', 'Zu den Badstuben 2', '04451', 'Borsdorf', 'Zu den Badstuben 2', 'daniel_boettcher@gmx.net', '01b114342d7fc811669eb24dbe609cc4', 'test_admin', 1, '2012-05-06 12:25:52', NULL, NULL),
(2, 'Mustermann', 'Max', '04451', 'Borsdorf', 'Zu den Badstuben 2', '04451', 'Borsdorf', 'Zu den Badstuben 2', 'sunshine_le_81@gmx.net', '9da1f8e0aecc9d868bad115129706a77', 'test_user', 2, '2012-05-06 14:59:13', NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
