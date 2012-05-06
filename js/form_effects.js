function checkForm() {

    var strFehler = '';

	// Prüft Name
    if ((document.forms[0].name.value == "") || (document.forms[0].name.value == "Ihr Name und Vorname"))
    strFehler += "Feld Name ist leer.\n";

	// Prüft Email
    if (!validEmail(document.forms[0].email.value) || (document.forms[0].email.value == "Ihre Email Adresse")) 
        strFehler += "In der E-Mail-Adresse steckt der Wurm drin!\n";
	
	// Prüft Strasse
    if ((document.forms[0].strasse.value == "") || (document.forms[0].strasse.value == "Ihre Strasse, Hausnummer"))
    strFehler += "Feld Straße, Hausnummer ist leer.\n";

	// Prüft Ort, PLZ
    if ((document.forms[0].plz_ort.value == "") || (document.forms[0].plz_ort.value == "PLZ, Ort"))
    strFehler += "Feld PLZ, Ort leer.\n";	
	
	// Prüft Ort, PLZ
    if ((document.forms[0].text.value == "") || (document.forms[0].text.value == "Ihre Nachricht"))
    strFehler += "Bitte schreiben Sie uns Ihr Anliegen!\n";	
	
	
	// Prüft Fehleranzahl und gibt ggf. Fehler aus
    if (strFehler.length > 0) {
        alert("Festgestellte Probleme: \n\n" + strFehler);
        return (false);
    }
}

function validEmail(email) {
	
	// Legt Syntax für Email fest
    var strReg = "^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$";
    var regex = new RegExp(strReg);
    return (regex.test(email));
}

function activate(element,vorbelegung) {  //Diese Funktion benötigt zwei Angaben: Die erste (element) dient dazu, auf das entsprechende Formularfeld zuzugreifen. Hier ist im Formular immer this anzugeben (siehe Formular). Die zweite (vorbelegung) enthält den gleichen Text, der auch bei dem jeweiligen <input>-Feld unter value="" bzw. bei <textarea> zwischen <textarea> und </textarea> angegeben ist.
  if (element.value == vorbelegung) {  //Hier wird überprüft, ob der derzeitige Inhalt der Vorbelegung entspricht.
    element.value = '';  //Ist das der Fall, dann wird der Inhalt gelöscht und
    element.className = 'normal';  //wieder normal dargestellt (die Klasse des Feldes wird auf 'normal' geändert).
  }
}

function leave(element,vorbelegung) {  //Diese Funktion benötigt die gleichen Angaben wie activate().
  if (element.value == '') {  //Hier wird überprüft, ob das Feld bereits durch den User ausgefüllt wurde.
    element.value = vorbelegung;  //Wenn nicht, dann wird die Vorbelegung wiederhergestellt und
    element.className = 'vorbelegung';  //der Text wieder grau und kursiv dargestellt (erneute Änderung der Klasse).
  }
}

function zuruecksetzen() {
  for(i=0;i<2;i++) {  //die Zahl 2 in dieser Zeile ist durch die Gesamtanzahl der Eingabefelder zu ersetzen
    document.kontakt.elements[i].className = 'vorbelegung';  //So wird jedes Formularfeld wieder grau und kursiv dargestellt. Die Vorbelegungen werden automatisch wiederhergestellt.
  }
}
