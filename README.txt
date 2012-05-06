Daniel Böttcher, Student SAE Institute Leipzig (Webdesign & Development, 1. Studienjahr)


Dokumentation "Digital Library", Coding Contest


Einleitung

Die Aufgabenstellung des Coding-Contest (04.04. - 06.05.2012) habe ich für mich so interpretiert, dass eine Digitale Bibliothek (bzw. Online-Bibliothek) gefordert ist, an der sich User anmelden/ einloggen kann, nach Büchern recherchieren und diese für einen Geldbetrag/ Tag ausleihen können. Ein oder mehrere Administrato/ren verwalten den Buchbestand und die User. Die Preise/ Tag sind fiktiv.

Die Ausleihe erfolgt in Form einer Postsendung, in der das gewünschte Material enthalten ist. Der Ausleihzeitraum beginnt ab Erhalt der Postsendung und endet bei Abgabe der Sendung beim Versandservice. Die Leihdauer der Bücher ist frei wählbar.

Die Administration der Bibliothek erfolgt über ein oder mehrere Administrator/en, die über einen "Admin-Zugang" alle notwendigen Buchinformationen(Erscheinungsdatum, Autor, Inhalt, ISBN etc.) sicherstellen, und halten diese auf dem aktuellen Stand. Desweiteren hat der Administrator Zugang zu allen Nutzerprofilen und kann alle offenen Ausleihvorgänge einsehen, um deren Ablauf zu verfolgen.

Ich habe eine grafische Oberfläche für die Bibliothek mit den nachfolgend (in Punkt 2) beschriebenen Features erstellt.


1. Installation


Es wird eine Entwicklungsumgebung benötigt, die PHP interpretieren kann (z.B. PHP 5.3). Desweiteren wird eine MySQL Datenbank benötigt, die im Ordner "Datenbank" im Root hinterlegt ist. Die Datenbankeinstellungen erfolgen über das File "configuration.inc.php" im Ordner "inc/config/".

Die Applikation muss in der vorliegenden Ordnerstruktur in die Entwicklungsumgebung übernommen sowie die Datenbankeinstellungen vorgenommen werden.


2. Aufbau der Applikation


2.1 Offline Modus:

Der Offline-User hat Zugriff auf die Buch-Rechereche (Suche, Kategorien, etc.), kann aber keine Titel vormerken bzw. ausleihen. Die Kriterien für die Volltextsuche sind Buchtitel oder ISBN (-13) Nummer.

Um sich zu registrierenn muss der Offline-User ein Formular ausfüllen sowie seine E-Mail Adresse per Link bestätigen.


2.2 Online-Modus - User

Der Online-User kann alle verfügbaren Features nutzen: Bücher vormerken, ausleihen sowie den aktuellen Ausleihstatus einsehen. Es gibt grundsätzlich keine Vorgabe für die maximale Ausleihdauer eines Buches. Weiterhin kann der Online-User seine persönlichen Daten (Adresse, Lieferadresse und Passwort) ändern. Auch vorhanden: Das "Passwort-Vergessen"-Feature.


2.3 Online-Modus - Administrator

Der Administrator kann selbst keine Bücher ausleihen. Er ist für die Verwaltung des Buchbestandes zuständig. So hat er die Möglichkeit unter "Buch hinzufügen" neues Material hinzuzufügen bzw. unter "Editieren"/ "Daten ändern" Aktualisierungen vorzunehmen.
Er hat Zugriff auf alle aktuellen Ausleihvoränge.
In der Benutzerverwaltung lassen sich sämtliche Adressdaten und Accountinformationen einsehen. Hier ist es ebenfalls möglich, an einen "normalen User" Adminrechte zu vergeben. Dieser Fall tritt z.B. dann ein, wenn weitere Admin's mit der Verwaltung der Bibliothek beauftragt werden sollen. Diese melden sich zuerst als User und werden zum "Admin" ernannt.

Information: Es wurden in dieser Version bereits zwei User angelegt:

Username: test_user  // (Nutzer der Bibliothek)
Passwort: test_user

Username: test_admin //(Admin)
Passwort: test_admin

Mindestens ein Administrator muss mit gültigem Account standardmäßig immer in der Datenbank vorhanden sein, um die Betreuung der Bibliotheks-Oberfläche zu gewährleisten.

Desweiteren wurden ca. 15 Bücher unterschiedlicher Kategorien hinzugefügt.


3. Vorhandener Quellcode


Sämtlicher Quellcode (PHP, Javascript, HTML) sowie das Layout wurden von mir selbst erstellt und getestet. Ausnahme: Die Javascript-Plugins "Fancybox" (Lightbox Plugin) und "Nivo-Slider" (Slideshow-Plugin).


4. Layout/ HTML


Das Layout wurde im XHTML Strict Standard erstellt. Der Footer ist bis auf die Kategorie "Links" mit Platzhaltern besetzt. 


5. Ausblick: Bezahlsystem


Als Bezahlsystem würde ich Paypal aufgrund des zügigen Geldtransfers integrieren. Ich habe davon abgesehen, die Paypal-Sandbox-Technologie in dieser Applikation zu integrieren, da sich der Bestellvorgang dadurch nur recht aufwändig testen lässt. Im Endeffekt läuft es bei der Integration darauf hinaus, den Paypal-Bezahlbutton (Formular mit Hidden-Feldern) mit allen notwendigen Informationen zu "versorgen" und die Paypal-Informationen nach dem Bezahlvorgang zu validieren und auszuwerten.

In dieser Version der Applikation wird durch den Klick auf den "Ausleihen"-Button der Ausleihvorgang abgeschlossen, ohne eine reelle finanzielle Transaktion durchzuführen.


6. Ordnerstruktur


Eine kurze Erklärung der Funktionen der Dateien im Ordner "inc" (includes):

actions
	class_book.inc.php 	// Aktionen zur Verwaltung des Buchbestandes (z.B. Löschen, Hinzufügen, Aktualisieren) 
	class_user.inc.php	// Aktionen zur Verwaltung der User (z.B. Löschen, Hinzufügen, Aktualisieren) 
	class_mailer.inc.php	// Mailversand

config
	configuration.inc.php	// Konstanten, Variablen, Arrays, die der Konfiguration dienen

database
	class_database.inc.php	// Klasse zur Anbindung der Datenbank

display
	class_display_form.inc.php	// HTML Formulare
	class_display_library.inc.php	// dynamische HTML-Ausgabe der Bibliothek

global 
	class_functions.inc.php	// Hilfsfunktionen (Datumsformatierungen, Blätterfunktionen,…)

html
	static_html.inc.php	// Statisches HTML

validation
	class_form_validation.inc.php //	Formularvalidierung
	class_url_validation.inc.php //	URL, GET, POST Validierung

class_pdf.inc.php // Erzeugen PDF-Ausgabe
class_session.php // Erzeugen Session, Session-Variablen, Timeout
class_site.inc.php // Erzeugen statisches HTML Grundgerüst


7. Testserver


Die Webapplikation läuft auf meinem Testserver und ist unter folgenden Zugangsdaten voll verfügbar:

FTP:

Server: web12.net-server.de
User: coding_contest
PW: coding_contest

Datenbank:

URL: https://www.net-server.de/phpMyAdmin/index.php
User: sae3
PW: netsh105137
Server: db11.net-server.de (im Dropdown auswählen)

Live-Betrieb-URL: www.daniel-boettcher.com/library




06.05.2012 Daniel Böttcher
E-Mail: daniel_boettcher@gmx.net

