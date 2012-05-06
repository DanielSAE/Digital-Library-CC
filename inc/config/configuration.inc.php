<?php

### Konstanten und Variablen

### Startskript definieren
define('BASE_URL', $_SERVER['PHP_SELF']); 

### Datenbank definieren
/*
define ('DB_HOST','localhost');
define ('DB_DATABASE','library'); 
define ('DB_PORT',3306); 
define ('DB_USER','root'); 
define ('DB_PASSWORD',''); 
*/
### Datenbank definieren
define ('DB_HOST','db11.net-server.de');
define ('DB_DATABASE','digital_library'); 
define ('DB_PORT',3306); 
define ('DB_USER','sae3'); 
define ('DB_PASSWORD','netsh105137'); 


###Timeout nach Inaktivität (in Sekunden)
define ('TIMEOUT','1200'); ### 20 Minuten

###User Level
define ('offline',0);
define ('admin',1);
define ('user',2);

### Maximale Dateiupload- Größe

define('MAX_FILE_SIZE', 0.5 * 1024 * 1024);

### Sortieren Dropdown Menü Bücher (User)
$arrOrderBy = array(
				"Bitte w&auml;hlen",
				"Buchtitel A-Z",
				"Neueste B&uuml;cher zuerst",
				"Preis aufsteigend"
);

### Sortieren Dropdown Menü User (Admin)
$arrOrderBy2 = array(
				"Bitte w&auml;hlen",
				"Benutzer-Nr. aufsteigend",
				"Benutzer-Name A-Z",
				"Neueste User zuerst"
);

### Sortieren Dropdown Menü Ausleihen (Admin)
$arrOrderBy3 = array(
				"Bitte w&auml;hlen",
				"Ausleih-Tage absteigend",
				"Ausleih-Tage aufsteigend",
				"Benutzer-Nr. aufsteigend",
				"Benutzer-Name A-Z"
);

### Startwert Sortierung
$orderBy = 0; 

### Links + Navigationpunkte nach User
$naviList = array(	offline => array( //Offline
						"page=start" => "Home",
						"page=selection&amp;categorie=Charts" => "B&uuml;cher Charts",
						"page=allBooks" => "Alle B&uuml;cher",
						"page=lastRent" => "Ihr Ausleihstatus",
						"page=reserveList" => "Vorgemerkte Titel",
						"page=setup" => "Meine Daten"
						),
					admin => array( //Admin
						"page=start" => "Home",
						"page=allBooks" => "Alle B&uuml;cher",
						"page=addBook" => "Buch hinzuf&uuml;gen",
						"page=allRentings" => "Alle User-Ausleihen",
						"page=setup" => "Meine Daten"
						),
					user => array( // User
						"page=start" => "Home",
						"page=selection&amp;categorie=Charts" => "B&uuml;cher Charts",
						"page=allBooks" => "Alle B&uuml;cher",
						"page=lastRent" => "Ihr Ausleihstatus",
						"page=reserveList" => "Vorgemerkte Titel",
						"page=setup" => "Meine Daten"
						)  
);

### Links + Navigationpunkte LeftColumn

$adminNaviList = array(
				"page=allUsers" => "Alle Benutzer",
);



$sidebarNaviList = array(
				"page=selection&amp;categorie=Biographien" => "Biographien",
				"page=selection&amp;categorie=Gesundheit" => "Gesundheit",
				"page=selection&amp;categorie=Horror" => "Horror",
				"page=selection&amp;categorie=Thriller" => "Thriller",
				"page=selection&amp;categorie=Krimi" => "Krimi",
				"page=selection&amp;categorie=Romane" => "Romane",
				"page=selection&amp;categorie=Science-Fiction" => "Science-Fiction",
				"page=selection&amp;categorie=Politik" => "Politik",
);

$pageTitel = array( ### Dynamische Seitentitel Anzeige
				"register" => "Neuanmeldung",
				"start" => "Home",
				"selection&amp;categorie=Charts" => "B&uuml;cher Charts",
				"allBooks" => "Alle B&uuml;cher Charts",
				"lastRent" => "Ihr Ausleihstatus",
				"reserveList" => "Vorgemerkte Titel",
				"setup" => "Meine Daten",
				"start" => "Home",
				"allBooks" => "Alle B&uuml;cher",
				"addBook" => "Buch hinzuf&uuml;gen",
				"editBook" => "Buch bearbeiten",
				"setup" => "Meine Daten",
				"order" => "Ihre Ausleihe",
				"selection" => "B&uuml;cherauswahl",
				"paymentOverview" => "Ausleih&uuml;bersicht",
				"paypalConfirmation" => "Ihre Zahlungsbest&auml;tigung",
				"wrongLogin" => "Falsche Nutzerdaten",
				"details" => "Buchdetails",
				"search" => "Ihre Suche",
				"resetPassword" => "Passwortservice",
				"confirmPassword" => "Passwortservice",
				"activateAccount" => "Freischaltservice",
				"allRentings" => "Alle User-Ausleihen",
				"allUsers" => "Benutzerverwaltung - Alle Benutzer",
				"searchUser" => "Benutzerverwaltung - Benutzer-Suche",
				"userDetails" => "Benutzerverwaltung - Benutzer-Details"
);

### Anzahl letzte Bücher auf Startseite
$numberLastBooks = 10;

### Anzahl Suchergebnisse pro Seite

$arrMaxEntries = array(
					5,
					10,
					15,
					20
);

define("NAV_BAR",11);

### Lagerbestand Anzeige (Menge der noch verfügbaren Bücher)

define("Status_1", 60);
define("Status_2", 40);
define("Status_3", 10);
define("Status_4", 0);

### Kosten für Versand

define("Shipping", 2.95);

### Image Folders

define('FULL_DIR', 'images_art/');
define('THUMB_DIR', 'images_art/thumbs/');

### Image Size

define('FULL_WIDTH', 305);
define('THUMB_WIDTH', 120);
define('THUMB_HEIGHT', 170);

### Image Quality
define('JPG_QUALITY', 90);

?>