<?php
$staticHtml = array(); //Statische HTML Inhalte

//NEUANMELDUNG USER------------------------------------------------------------------

//LOGO EINBINDEN -------------------------------------------------------------------------------------

$staticHtml[1][0] = '<!-- HEADER -->
	<div id="header">
		<div class="left">
			<div id="logo">
				<a href="' . BASE_URL . '"><img src="images/logo.png" alt="Digial Library Logo" /></a>
			</div>
		</div>
		';

//LeftColumn ---------------------------------------------------------------------------

$staticHtml[2][0] = '<!-- CONTENT -->
	<div id="content">
		<div id="leftColumn">
			<div id="leftColumn2">
				<h1>Willkommen</h1>
				<p class="welcome">
					Wir sind die grösste digitale Bibliothek in Leipzig. &Uuml;berzeugen Sie sich von unserem Angebot.
				</p>
				';

//LeftColumn schließen + MainColumn öffnen------------------------------------------------------

$staticHtml[4][0] = '
		</div>
	</div>    
	<div id="mainColumn">
	';


//Slideshow------------------------------------------------------

$staticHtml[5][0] = '<!-- SLIDESHOW -->
	<div id="slideshow">
		<div class="slider-wrapper theme-default">
			<div class="ribbon"></div>
			<div id="slider" class="nivoSlider">
				<img src="slideshow/verblendung.jpg" alt="verblendung"/>
				<img src="slideshow/adlerhaus.jpg" alt="das_adlerhaus"/>
				<img src="slideshow/tattoo_girl.jpg" alt="tribute"/>
			</div>
		</div>
	</div>
	';

//MainColumn schließen ------------------------------------------------------

$staticHtml[6][0] = '
		</div>
		<div class="clear"></div>
	</div>
	';

//Ausleihvorgang abschließen (vorläufig) ------------------------------------------------------

$staticHtml[7][0] = '
	<div class="headline">
		<h2>Ihr Ausleihvorgang wurde aufgenommen.</h2>
	</div>
	<p>Ihr Ausleihvorgang wurde erfolgreich aufgenommen. Bitte verfolgen Sie den Status ihrer Ausleihe unter "Ihr Ausleihstatus".</p>
	<p>Vielen Dank für Ihren Besuch.</p>
	<a class="shadowLink" href="' . BASE_URL . '">
		<img src="images/btn_back.png" title="zurück" alt="zurück" />
	</a>
';

//Passwort Reset - Bestätigungslink ------------------------------------------------------

$staticHtml[8][0] = '
<div class="headline">
	<h2>Bestätigunglink an Ihre E-Mail Adresse versandt</h2>
</div>
<p>Wir haben eine E-Mail mit einem Bestätigungslink an Ihre E-Mail Adresse gesandt. Mit Hilfe dieses Links können Sie sich innerhalb von zwei Tagen ein neues Passwort einrichten.</p>
<p>Wenn Sie diese E-Mail nicht erhalten, sehen Sie bitte in Ihrem Spam-Ordner nach oder besuchen Sie unsere Hilfeseiten. Dort steht Ihnen unser Kundenservice gerne zur Verfügung. </p>
';

//Passwort Reset - Neues Passwort eintragen ------------------------------------------------------

$staticHtml[9][0] = '
<div class="headline">
	<h2>Ihr neues Passwort wurde eingetragen</h2>
</div>
<p>Wir haben Ihr neues Passwort eingetragen.</p>
<p>Sie können sich nun wie gewohnt mit Ihren neuen Login-Daten in unserer Bibliothek einloggen. </p>
';

//Account freischalten  -------------------------------------------------------------------------

$staticHtml[10][0] = '
<div class="headline">
	<h2>Bestätigunglink an Ihre E-Mail Adresse versandt</h2>
</div>
<p>Wir haben eine E-Mail mit einem Bestätigungslink an Ihre E-Mail Adresse gesandt. Mit Hilfe dieses Links können Sie Ihren neuen Account innerhalb von zwei Tagen freischalten.</p>
<p>Wenn Sie diese E-Mail nicht erhalten, sehen Sie bitte in Ihrem Spam-Ordner nach oder besuchen Sie unsere Hilfeseiten. Dort steht Ihnen unser Kundenservice gerne zur Verfügung. </p>
';

$staticHtml[11][0] = '
<div class="headline">
	<h2>Ihr neuer Account wurde freigeschaltet</h2>
</div>
<p>Ihr neuer Account wurde freigeschaltet.</p>
<p>Sie können sich nun mit Ihren neuen Login-Daten in unserer Bibliothek einloggen. </p>
';

//Suchformular -------------------------------------------------------------------------------------

$staticHtml[12][0] = '<!-- SEARCHFORM -->
		<div class="left">
			<div id="searchform">
				<form  id="search" method="post" action="' . BASE_URL . '?page=search" onsubmit="return showWait();">
					<div class="left">
						<input type="text" name="search" value="Titel/ ISBN suchen..." title=" Suchbegriff hier eingeben " onfocus="activate(this,\'Titel/ ISBN suchen...\')" onblur="leave(this,\'Titel/ ISBN suchen...\')" class="vorbelegung"/>
					</div>
					<div class="right">
						<input type="image" src="images/search.png" class="search_btn" />
					</div>
					<div class="clear"></div>
				</form>
			</div>
		</div>
		';

//Meldungen Datenbankaktualisierung ----------------------------------------------------------------

$staticHtml[13][0] = '
<div class="headline">
	<h2>Das Buch wurde hinzugefügt</h2>
</div>
<p>Das neue Buch wurde erfolgreich hinzugefügt.</p>
';

$staticHtml[14][0] = '
<div class="headline">
	<h2>Das Buch wurde aktualisiert</h2>
</div>
<p>Die Daten für das Buch wurden erfolgreich aktualisiert.</p>
';

$staticHtml[15][0] = '
<div class="headline">
	<h2>Ihre Daten wurden aktualisiert</h2>
</div>
<p>Ihre persönlichen Daten wurden erfolgreich aktualisiert.</p>
';

?>