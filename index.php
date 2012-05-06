<?php

/**
 * @copyright	Copyright (C) Daniel Böttcher, 2012. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
**/

### INCLUDES ----------------------------------------------------------------------------------------------

include('inc/display/class_display_library.inc.php'); ### Bibliothek DISPLAY -> Ausgabe von HTML
include('inc/display/class_display_form.inc.php'); ### Dynamische Formulare DISPLAY -> Rückgabe von HTML an 'Bibliothek DISPLAY'
include('inc/actions/class_book.inc.php'); ### Action / Buchbestand
include('inc/actions/class_user.inc.php'); ### Action / Userverwaltung
include('inc/actions/class_mailer.inc.php'); ### Mailfunktionen
include('inc/database/class_database.inc.php'); ### Datenbank
include('inc/config/configuration.inc.php'); ### Config / Grundkonfiguration
include('inc/html/static_html.inc.php'); ### statische HTML Inhalte inkludieren
include('inc/validation/class_url_validation.inc.php'); ### URL + Sucheingaben validieren
include('inc/validation/class_form_validation.inc.php'); ### Formular Validierung
include('inc/global/class_functions.inc.php'); ### Globale Funktionen

foreach($_REQUEST as $k => $v){
	$$k = strip_tags($v);
}

### Neuer User + Bibliothek instanziieren + Session start ---------------------------------------------------------------

$user = new user;
$display_library = new Display_Library; ### Bibliothek DISPLAY -> Ausgabe von dynamischem HTML

Book::clearTrash(); ### Vorgemerkte Titel bereinigen nach 14 Tagen, abgelaufene Ausleihlisten bereinigen nach 30 Tagen

$user->getUserData(); ### Authentifizierung des Users

$page = validate::validateHandler($_SESSION['userId']); ### Handler zur Validierung sämtlicher GET-Eingaben
$searchtext = validate::validateSearch($page); ### Sucheinträge validieren und parsen
$user->setCurrentUrl(); ### Current Url setzen

if (isset($action) && $action == 'createPdf') { ### PDF erstellen -> Headerinformation
	$display_library->pdfDetail($articleId);
}

### AUSGABE WEBSITE ---------------------------------------------------------------------------------------

if(isset($categorie)){ ### Dynamische Seitentitel setzen
	$user->setTitel($pageTitel[$page], $categorie);
} 
else $user->setTitel($pageTitel[$page]);

$user->head(); ### HTML Kopf laden
$user->content($staticHtml[1]); ### Logo zeigen
$user->content($staticHtml[12]); ### Suchfeld
$display_library->reserveListIcon(Book::getBooksCount()); ### Vormerkliste Icon -> Anzeige Anzahl Bücher vergemerkt
$user->content($staticHtml[2]); ### Div 'Content' und Div 'LeftColumn' öffnen
$display_library->forms('loginLeft'); ### Login + Logout laden
if($_SESSION['userId'] == admin){
	$display_library->AdminSidebarNavigation($adminNaviList, $page); ### LeftColumn 'Navigation' für Admin laden
}
$display_library->SidebarNavigation($sidebarNaviList, $page); ### LeftColumn 'Navigation' laden
$user->content($staticHtml[4]); ### LeftColumn schließen + MainColumn öffnen
$display_library->navigation($naviList, $page); ### Navigation laden

### Handler -------------------------------------------------------------------------------------------------

### USER + ADMIN --------------------------------------------------------------------------------------------

if ($page == 'setup') { ### Persönliche Einstellungen anzeigen
	if (isset($action) && ($action == 'EditPasswort' || $action == 'EditAdress' || $action == 'EditShippingAdress')) { ###Persönliche Einstellungen ändern
		if(isset($changeUserData)) {
			if(is_array(formValidation::formValidate($_POST, $action))){
				$display_library->forms($action, formValidation::formValidate($_POST, $action));
			}
			else {
				$user->changeUserData($_POST, $action);
				$user->content($staticHtml[15]);
			}
		}
		else {
			$display_library->forms($action);
		}
	}
	else {
	$display_library->setup(); ### Persönliche Daten anzeigen
	}
}

if (isset($action) && ($action == 'reserveBook')){ ### Buch vormerken
	Book::reserveBook($articleId);
}

elseif ($page == 'lastRent') { ### Ausleihstatus (alle geliehenen Bücher der letzten 30 Tage mit Restzeit)
	$display_library->lastRent();
}

elseif ($page == 'reserveList'){ ### Vormerkliste einsehen
	if (isset($action) && ($action == 'clearE')) { ### Buch aus Vormerkliste einzeln entfernen
		Book::clearSeparate($articleId);
	}
	if (isset($action) && ($action == 'clear')) { ### alle Bücher aus Vormerkliste entfernen
		Book::clearAll();
	}
	$display_library->reserveList(); ### Vormerkliste einsehen
}

elseif ($page == 'paymentOverview' && Book::getBooksCount($_SESSION['userNumber']) > 0){ ### Ausleihübersicht wenn Buch in Vormerkliste
	$display_library->paymentOverview($page); ### Persönliche Daten anzeigen
}

elseif ($page == 'paymentOverview' && Book::getBooksCount($_SESSION['userNumber']) == 0){ ### URL Manipulation umleiten auf Startseite
	$page = 'start';
}

elseif ($page == 'order') { ### Ausleihe absenden
	if(Book::order() == true){
		$user->content($staticHtml[7]);
	}
	else $page = 'start';
}

### ADMIN --------------------------------------------------------------------------------------------

if ($page == 'addBook') { ### Buch hinzufügen
	if(isset($addBook)) {
		if(is_array(formValidation::formValidate($_POST, $action))){
			$display_library->forms($action, formValidation::formValidate($_POST, $action));
		}
		else {
			Book::setBookData($_POST);
			$user->content($staticHtml[13]);
		}
	}
	else {
		$display_library->forms($page);
	}
}

if(isset($action) && $action == 'deleteBook'){ ### Buch löschen
	Book::deleteBook($articleId);
}

if($page == 'editBook') { ### Buch editieren
	if(isset($editBook)) {
		if(is_array(formValidation::formValidate($_POST, $action))){
			$display_library->forms($action, formValidation::formValidate($_POST, $action), $articleId);
		}
		else {
			Book::changeBookData($_POST);
			$user->content($staticHtml[14]);
		}
	}
	else {
		$display_library->forms($page, 0, $articleId);
	}	
}

if($page == 'allRentings'){ ### Alle Ausleihvorgänge von Nutzer einsehen
	$display_library->displayAllRentings($page, $arrMaxEntries, $arrOrderBy3);
}

if($page == 'userDetails'){ ### User Details einsehen
	$display_library->userDetails($userNumber);
}

if($page == 'allUsers') { ### Link 'Alle Bücher' bzw. Auswahl nach Genre/ Charts
	$display_library->displayUsers($page, $arrMaxEntries, $arrOrderBy2);
}

if(isset($action) && $action == 'deleteUser'){ ### User löschen
	User::deleteUser($userNumber);
}

if(isset($action) && $action == 'changeRank2Admin'){ ### Rangänderung von User zu Admin
	User::changeRank2Admin($userNumber);
}

if(isset($action) && $action == 'changeRank2User'){ ### Rangänderung von Admin zu User
	User::changeRank2User($userNumber);
}

if(isset($action) && $action == 'deleteRenting'){ ### Ausleihe löschen
	User::deleteRenting($rentingId);
}
		
### OFFLINE ------------------------------------------------------------------------------------------

if($page == 'wrongLogin'){ ### Fehlgeschlagenes Einloggen abfangen
	if(isset($loginMain) || isset($login)){
		if(is_array(formValidation::formValidate($_POST, $page))){
			$display_library->forms($page, formValidation::formValidate($_POST, $page));
		}
	}
	else {
		$display_library->forms($page);
	}
}

elseif ($page == 'register')	{ ### Neuanmeldung Formular
	if(isset($register)) 
	{
		if(is_array(formValidation::formValidate($_POST, $action))){
			$display_library->forms($action, formValidation::formValidate($_POST, $action));
		}
		else {
			if($user->setUserData($_POST, user) == true){
				$user->content($staticHtml[8]);
			}
		}
	}
	else {
		$display_library->forms($page);
	}
}

elseif ($page == 'resetPassword'){ ### Passwort-Vergessen Funktion -> Bestätigungslink zusenden lassen
	if(isset($resetSave)) 
	{
		if(is_array(formValidation::formValidate($_POST, $action))){
			$display_library->forms($action, formValidation::formValidate($_POST, $action));
		}
		else {
			if($user->resetPassword($_POST) == true){
				$user->content($staticHtml[8]);
			}
		}
	}
	else {
		$display_library->forms($page);
	}
}

elseif ($page == 'confirmPassword'){ ### Passwort-Vergessen Funktion -> Neues Passwort setzen
	if(isset($confirmSave))
	{
		if(is_array(formValidation::formValidate($_POST, $action))){
			$display_library->forms($action, formValidation::formValidate($_POST, $action));
		}
		else {
			if($user->confirmPassword($_POST, $code) == true){
				$user->content($staticHtml[9]);
				$user->clearCode($code);
			}
		}
	}
	else {
		$display_library->forms($page);
	}
}

elseif ($page == 'activateAccount'){ ### Account aktivieren nach Neuanmeldung
	$user->clearActivateCode($activateCode);
	$user->content($staticHtml[11]);
}
	
### ALL USERS ------------------------------------------------------------------------------------------

if ($page == 'allBooks' || $page == 'selection') { ### Link 'Alle Bücher' bzw. Auswahl nach Genre/ Charts
	$display_library->displayBooks($page, $arrMaxEntries, $arrOrderBy);
}

elseif ($page == 'details') { ### Link Detailansicht
	$display_library->details($articleId);
}

elseif ($page == 'search'){ ### suche
	$display_library->search($searchtext, $arrMaxEntries, $arrOrderBy, formValidation::formValidate($searchtext, $page));
}

elseif ($page == 'start') { ### Startseite
	$user->content($staticHtml[5]); ### Slideshow
	$display_library->latestBooks($numberLastBooks); ### Neueste 10 Bücher
}
	
$user->content($staticHtml[6]); ### Div Content + Div Maincolumn schließen
$user->foot(); ### Footer laden
$user->setRefererUrl(); ### Referer URL setzen
?>