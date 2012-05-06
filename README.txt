Daniel B�ttcher, Student SAE Institute Leipzig (Webdesign & Development, 1. Studienjahr)


Dokumentation "Digital Library", Coding Contest


Einleitung

Die Aufgabenstellung des Coding-Contest (04.04. - 06.05.2012) habe ich f�r mich so interpretiert, dass eine Digitale Bibliothek (bzw. Online-Bibliothek) gefordert ist, an der sich User anmelden/ einloggen, nach B�chern recherchieren und diese f�r einen Geldbetrag/ Tag ausleihen k�nnen. Ein oder mehrere Administrato/ren verwalten den Buchbestand und die User. Die Preise/ Tag sind fiktiv.

Die Ausleihe erfolgt in Form einer Postsendung, in der das gew�nschte Material enthalten ist. Der Ausleihzeitraum beginnt ab Erhalt der Postsendung und endet bei Abgabe der Sendung beim Versandservice. Die Leihdauer der B�cher ist frei w�hlbar.

Die Administration der Bibliothek erfolgt �ber ein oder mehrere Administrator/en, die �ber einen "Admin-Zugang" alle notwendigen Buchinformationen(Erscheinungsdatum, Autor, Inhalt, ISBN etc.) sicherstellen, und halten diese auf dem aktuellen Stand. Desweiteren hat der Administrator Zugang zu allen Nutzerprofilen und kann alle offenen Ausleihvorg�nge einsehen, um deren Ablauf zu verfolgen.

Ich habe eine grafische Oberfl�che f�r die Bibliothek mit den nachfolgend (in Punkt 2) beschriebenen Features erstellt.


1. Installation


Es wird eine Entwicklungsumgebung ben�tigt, die PHP interpretieren kann (z.B. PHP 5.3). Desweiteren wird eine MySQL Datenbank ben�tigt, die im Ordner "Datenbank" im Root hinterlegt ist. Die Datenbankeinstellungen erfolgen �ber das File "configuration.inc.php" im Ordner "inc/config/".

Die Applikation muss in der vorliegenden Ordnerstruktur in die Entwicklungsumgebung �bernommen sowie die Datenbankeinstellungen vorgenommen werden.


2. Aufbau der Applikation


2.1 Offline Modus:

Der Offline-User hat Zugriff auf die Buch-Rechereche (Suche, Kategorien, etc.), kann aber keine Titel vormerken bzw. ausleihen. Die Kriterien f�r die Volltextsuche sind Buchtitel oder ISBN (-13) Nummer.

Um sich zu registrieren muss der Offline-User ein Formular ausf�llen sowie seine E-Mail Adresse per Link best�tigen.


2.2 Online-Modus - User

Der Online-User kann alle verf�gbaren Features nutzen: B�cher vormerken, ausleihen sowie den aktuellen Ausleihstatus einsehen. Es gibt grunds�tzlich keine Vorgabe f�r die maximale Ausleihdauer eines Buches. Weiterhin kann der Online-User seine pers�nlichen Daten (Adresse, Lieferadresse und Passwort) �ndern. Auch vorhanden: Das "Passwort-Vergessen"-Feature.


2.3 Online-Modus - Administrator

Der Administrator kann selbst keine B�cher ausleihen. Er ist f�r die Verwaltung des Buchbestandes zust�ndig. So hat er die M�glichkeit unter "Buch hinzuf�gen" neues Material hinzuzuf�gen bzw. unter "Editieren"/ "Daten �ndern" Aktualisierungen vorzunehmen.
Er hat Zugriff auf alle aktuellen Ausleihvor�nge.
In der Benutzerverwaltung lassen sich s�mtliche Adressdaten und Accountinformationen einsehen. Hier ist es ebenfalls m�glich, an einen "normalen User" Adminrechte zu vergeben. Dieser Fall tritt z.B. dann ein, wenn weitere Admin's mit der Verwaltung der Bibliothek beauftragt werden sollen. Diese melden sich zuerst als User und werden zum "Admin" ernannt.

Information: Es wurden in dieser Version bereits zwei User angelegt:

Username: test_user  // (Nutzer der Bibliothek)
Passwort: test_user

Username: test_admin //(Admin)
Passwort: test_admin

Mindestens ein Administrator muss mit g�ltigem Account standardm��ig immer in der Datenbank vorhanden sein, um die Betreuung der Bibliotheks-Oberfl�che zu gew�hrleisten.

Desweiteren wurden ca. 15 B�cher unterschiedlicher Kategorien hinzugef�gt.


3. Vorhandener Quellcode


S�mtlicher Quellcode (PHP, Javascript, HTML) sowie das Layout wurden von mir selbst erstellt und getestet. Ausnahme: Die Javascript-Plugins "Fancybox" (Lightbox Plugin) und "Nivo-Slider" (Slideshow-Plugin).


4. Layout/ HTML


Das Layout wurde im XHTML Strict Standard erstellt. Der Footer ist bis auf die Kategorie "Links" mit Platzhaltern besetzt. 


5. Ausblick: Bezahlsystem


Als Bezahlsystem w�rde ich Paypal aufgrund des z�gigen Geldtransfers integrieren. Ich habe davon abgesehen, die Paypal-Sandbox-Technologie in dieser Applikation zu integrieren, da sich der Bestellvorgang dadurch nur recht aufw�ndig testen l�sst. Im Endeffekt l�uft es bei der Integration darauf hinaus, den Paypal-Bezahlbutton (Formular mit Hidden-Feldern) mit allen notwendigen Informationen zu "versorgen" und die Paypal-Informationen nach dem Bezahlvorgang zu validieren und auszuwerten.

In dieser Version der Applikation wird durch den Klick auf den "Ausleihen"-Button der Ausleihvorgang abgeschlossen, ohne eine reelle finanzielle Transaktion durchzuf�hren.


6. Ordnerstruktur


Eine kurze Erkl�rung der Funktionen der Dateien im Ordner "inc" (includes):

actions
	class_book.inc.php 	// Aktionen zur Verwaltung des Buchbestandes (z.B. L�schen, Hinzuf�gen, Aktualisieren) 
	class_user.inc.php	// Aktionen zur Verwaltung der User (z.B. L�schen, Hinzuf�gen, Aktualisieren) 
	class_mailer.inc.php	// Mailversand

config
	configuration.inc.php	// Konstanten, Variablen, Arrays, die der Konfiguration dienen

database
	class_database.inc.php	// Klasse zur Anbindung der Datenbank

display
	class_display_form.inc.php	// HTML Formulare
	class_display_library.inc.php	// dynamische HTML-Ausgabe der Bibliothek

global 
	class_functions.inc.php	// Hilfsfunktionen (Datumsformatierungen, Bl�tterfunktionen,�)

html
	static_html.inc.php	// Statisches HTML

validation
	class_form_validation.inc.php //	Formularvalidierung
	class_url_validation.inc.php //	URL, GET, POST Validierung

class_pdf.inc.php // Erzeugen PDF-Ausgabe
class_session.php // Erzeugen Session, Session-Variablen, Timeout
class_site.inc.php // Erzeugen statisches HTML Grundger�st


7. Testserver


Die Webapplikation l�uft auf meinem Testserver und ist unter folgenden Zugangsdaten voll verf�gbar:

FTP:

Server: web12.net-server.de
User: coding_contest
PW: coding_contest

Datenbank:

URL: https://www.net-server.de/phpMyAdmin/index.php
User: sae3
PW: netsh105137
Server: db11.net-server.de (im Dropdown ausw�hlen)

Live-Betrieb-URL: www.daniel-boettcher.com/library




06.05.2012 Daniel B�ttcher
E-Mail: daniel_boettcher@gmx.net

