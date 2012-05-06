<?php
class Display_Form ### Anzeige aller Formulare
{
	private static $arrGenre = array('Biographien', 'Gesundheit', 'Horror', 'Thriller',	'Krimi', 'Romane', 'Science-Fiction', 'Politik');

	public static function registerFormDisplay($userId, $random_number1, $random_number2){
	
		$name = 'Nachname...';
		$firstname = 'Vorname...';
		$postcode = 'Postleitzahl...';
		$city = 'Ort...';
		$street = 'Straße...';
		$email ='E-Mail Adresse...';
		$nickname = 'Anmeldename...';
		
		if(isset($_POST)){
			foreach($_POST as $k => $v){
				$$k = strip_tags($v); 
			}
		}
		
			$contentWeb = '<!-- REGISTER USER FORM -->
		<form id="form" method="post" action="'.BASE_URL.'?page=register&amp;action=register" accept-charset="utf-8">
			<fieldset>
				<label for="name" class="left">
					Ihr Nachname:*
				</label>
				<div class="right">
					<input id="name" name="name" type="text" value="' . $name . '" onfocus="activate(this,\'Nachname...\')" onblur="leave(this,\'Nachname...\')" class="vorbelegung" />
				</div>
				<div class="clear"></div>
				<label for="firstname" class="left">
					Ihr Vorname:*
				</label>
				<div class="right">
					<input id="firstname" name="firstname" type="text" value="' . $firstname . '" onfocus="activate(this,\'Vorname...\')" onblur="leave(this,\'Vorname...\')" class="vorbelegung" />
				</div>
				<div class="clear"></div>
				<label for="postcode" class="left">
					Ihre Postleitzahl:*
				</label>
				<div class="right">
					<input id="postcode" type="text" name="postcode" value="' . $postcode . '" onfocus="activate(this,\'Postleitzahl...\')" onblur="leave(this,\'Postleitzahl...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="city" class="left">
					Ihr Ort:*
				</label>
				<div class="right">
					<input id="city" name="city" type="text" value="' . $city . '" onfocus="activate(this,\'Ort...\')" onblur="leave(this,\'Ort...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="street" class="left">
					Ihre Stra&szlig;e und Hausnummer:*
				</label>
				<div class="right">
					<input id="street" name="street" type="text" value="'.$street.'" onfocus="activate(this,\'Straße...\')" onblur="leave(this,\'Straße...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="email" class="left">
					Ihre E-Mail-Adresse:*
				</label>
				<div class="right">
					<input id="email" name="email" type="text" value="' . $email . '" onfocus="activate(this,\'E-Mail Adresse...\')" onblur="leave(this,\'E-Mail Adresse...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="nickname" class="left">
					Ihr Anmeldename:*
				</label>
				<div class="right">
					<input id="nickname" name="nickname" type="text" value="' . $nickname . '" onfocus="activate(this,\'Anmeldename...\')" onblur="leave(this,\'Anmeldename...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="password" class="left">
					Ihr Passwort:*
				</label>
				<div class="right">
					<input id="password" name="password" type="password" />
				</div>
				<div class="clear"></div>
				<label for="confirm_password" class="left">
					Ihr Passwort bestätigen:*
				</label>
				<div class="right">
					<input id="confirm_password" name="confirm_password" type="password" />
				</div>
				<div class="clear"></div>
				<label for="arithmetic" class="left">
					Sicherheitsfrage:* ' . $random_number1 . ' plus ' . $random_number2 . ' = 
				</label>
				<input name="number" type="hidden" id="number"  value="' . md5($random_number1 + $random_number2) . '"/>
				<div class="right">
					<input id="arithmetic" name="arithmetic" type="text" value="Ihr Ergebnis..." onfocus="activate(this,\'Ihr Ergebnis...\')" onblur="leave(this,\'Ihr Ergebnis...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>	
				<label for="agb" class="left">
					Bitte akzeptieren Sie die AGB\'s:*
				</label>
				<div class="left">
					<input id="agb" name="agb" type="checkbox" class="checkbox" />
				</div>
				<div class="clear"></div>
				<input name="register" type="submit" class="register" value=" "/>
			</fieldset>
		</form>
		<p>* Pflichtfelder</p>';
		return $contentWeb;
	}

	public static function changeDataFormDisplay($userId, $random_number1, $random_number2, $formType){
	
		$postcode = $_SESSION['postcode'];
		$city = $_SESSION['city'];
		$street = $_SESSION['street'];
		$shipping_postcode = $_SESSION['shipping_postcode'];
		$shipping_city = $_SESSION['shipping_city'];
		$shipping_street = $_SESSION['shipping_street'];
		$email = $_SESSION['email'];
		$nickname = $_SESSION['nickname'];
		$password = $_SESSION['password'];
		
		if(isset($_POST)){
			foreach($_POST as $k => $v){
				$$k = strip_tags($v); 
			}
		}
		
		$contentWeb = '<!-- EDIT PERSONAL FORM -->
		<form id="form" method="post" action="' . BASE_URL . '?page=setup&amp;action=' . $formType . '" accept-charset="utf-8">
			<fieldset>';
	
		if($formType == 'EditPasswort'){
			$contentWeb .= '<!-- EDIT PASSWORD -->
				<label for="password" class="left">
					Neues Passwort:*
				</label>
				<div class="right">
					<input id="password" name="password" type="password"/>
				</div>
				<div class="clear"></div>
				<label for="confirm_password" class="left">
					Ihr Passwort bestätigen:*
				</label>
				<div class="right">
					<input id="confirm_password" name="confirm_password" type="password" />
				</div>
				<div class="clear"></div>
				<label for="current_password" class="left">
					Aktuelles Passwort:*
				</label>
				<div class="right">
					<input id="current_password" name="current_password" type="password" value=""/>
				</div>
				<div class="clear"></div>';
		}
		
		elseif($formType == 'EditAdress'){
			$contentWeb .= '<!-- EDIT ADRESS -->
				<label for="nickname" class="left">
					Anmeldename:*
				</label>
				<div class="right">
					<input id="nickname" name="nickname" type="text" value="' . $nickname . '" onblur="leave(this,\'' . $_SESSION['nickname'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="email" class="left">
					E-Mail-Adresse:*
				</label>
				<div class="right">
					<input id="email" name="email" type="text" value="' . $email . '" onblur="leave(this,\'' . $_SESSION['email'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="postcode" class="left">
					Postleitzahl:*
				</label>
				<div class="right">
					<input type="text" id="postcode" name="postcode" value="' . $postcode . '" onblur="leave(this,\'' . $_SESSION['postcode'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="city"class="left">
					Ort:*
				</label>
				<div class="right">
					<input id="city" name="city" type="text" value="' . $city . '" onblur="leave(this,\'' . $_SESSION['city'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="street" class="left">
					Stra&szlig;e:*
				</label>
				<div class="right">
					<input id="street" name="street" type="text" value="' . $street . '" onblur="leave(this,\'' . $_SESSION['street'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>';
		}
		
		elseif($formType == 'EditShippingAdress'){
				$contentWeb .= '<!-- EDIT SHIPPING ADRESS -->
				<label for="postcode" class="left">
					Postleitzahl:*
				</label>
				<div class="right">
					<input id="postcode" type="text" name="postcode" value="' . $shipping_postcode . '" onblur="leave(this,\'' . $_SESSION['shipping_postcode'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="city" class="left">
					Ort:*
				</label>
				<div class="right">
					<input id="city" name="city" type="text" value="' . $shipping_city . '" onblur="leave(this,\'' . $_SESSION['shipping_city'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="street" class="left">
					Stra&szlig;e:*
				</label>
				<div class="right">
					<input id="street" name="street" type="text" value="' . $shipping_street . '" onblur="leave(this,\'' . $_SESSION['shipping_street'] . '\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>';
		}
		$contentWeb .= '
				<div class="left" style="width: 150px">
					<input class="register" name="changeUserData" type= "submit" value=" " />
				</div>
				<div class="left">
	 				<a class="shadowLink" href="' . $_SESSION['refererUrl'] . '"><img src="images/btn_back.png" title="zurück" alt="zurück" /></a>
				</div>
			</fieldset>
		</form>
		<div class="clear"></div>
		<p>* Pflichtfelder</p>';
		return $contentWeb;
	}

	public static function loginFormMain($userId, $random_number1, $random_number2) {
	
		$contentWeb = '<!-- LOGIN FORM MAIN -->
		<p>Wenn Sie bei uns ein Benutzerkonto besitzen, melden Sie sich bitte an.</p>
		<form  id="form" method="post" action="' . BASE_URL . '" accept-charset="utf-8" onsubmit="return showWait();">
			<fieldset>
				<label for="UsernameMain" class="left">
					Username:
				</label>
				<div class="right">
					<input type="text" id="UsernameMain" name="nickname" value="Username..." title=" Username eingeben " onfocus="activate(this,\'Username...\')" onblur="leave(this,\'Username...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="PasswordMain" class="left">
					Password:
				</label>
				<div class="right">
					<input type="password" name="password" id="PasswordMain" title=" Suchbegriff hier eingeben " class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<input type="submit" class="loginMain" name="loginMain" value=" "/>
			</fieldset>
		</form>
		<div class="trennung"></div>
		<div class="headline">
			<h2>Sie haben noch kein Kundenkonto?</h2>
		</div>
		<p>Sie benötigen ein Kundenkonto, um bei Digital-Library Leihvorgänge durchzuführen.</p>
		<p>Werden Sie Kunde bei einem der erfolgreichsten Online-Bibliotheken und kommen Sie in den Genuß der neuesten B&uuml;cher.</p>
		<a class="shadowLink" href="' . BASE_URL . '?page=register"><img src="images/btn_register.png" title="Kundenkonto einrichten" alt="Kundenkonto einrichten" /></a>';
		return $contentWeb;
	}
	
	public static function loginFormLeft($userId) {
	
		if($userId == offline) {
			$contentWeb = '<!-- LOGIN FORM LEFT -->
			<div class="heading"><h2>Login Formular</h2></div>
			<div class="leftContent">
				<div id="loginform">
					<form  id="login" method="post" action="' . BASE_URL . '" accept-charset="utf-8" onsubmit="return showWait();">
						<fieldset>
							<label for="Username">Username:</label>
							<input type="text" id="Username" name="nickname" value="Username..." title=" Username eingeben " onfocus="activate(this,\'Username...\')" onblur="leave(this,\'Username...\')" class="vorbelegung"/>
							<label for="Password">Password:</label>
							<input type="password" name="password" id="Password" title=" Suchbegriff hier eingeben " class="vorbelegung"/>
							<input type= "submit" name="login" value=" " class="login" />
						</fieldset>
					</form>
				</div>
				<ul>
					<li><a class="login" href="' . BASE_URL . '?page=resetPassword">Passwort vergessen</a></li>
					<li><a class="login" href="' . BASE_URL . '?page=register">Neu anmelden</a></li>
				</ul>
			</div>
			';
		}
		else {
			$contentWeb = '
			<div class="heading"><h2>Sie sind eingeloggt</h2></div>
			<div class="leftContent">
				<div id="loginform">
					<p>Hallo ' . $_SESSION['firstname'] . ' ' . $_SESSION['name'] . '!</p>
					<div class="logout"><a href="' . BASE_URL . '?page=start&amp;action=logout"><img src="images/logout_btn.png" alt="logout" /></a></div>
				</div>
			</div>
			';
		}
		return $contentWeb;
	}

	public static function addBookDisplay() { ### Buch hinzufügen Formular
		
		$book_name = 'Buchtitel...';
		$book_price = 'Preis in €...';
		$book_quantity = 'Menge...';
		$book_releasedate = 'Veröfftl.datum... dd.mm.YYYY';
		$book_content ='Inhalt...';
		$book_author = 'Author...';
		$book_publisher = 'Verlag...';
		$book_isbn = 'ISBN 13...';
		$book_genre = ''; ### Genre Variable deklarieren
	
		try{
			$sql = "SELECT b_articlenumber 
					FROM dl_books 
					ORDER BY b_articlenumber 
					DESC LIMIT 1";
					
			$result = Database::getInstance()->query($sql);
			$tmp = $result->fetchAll(PDO::FETCH_NUM);
			$articleId = $tmp[0][0] + 1;
			
			$_SESSION['articleId'] = $articleId; ### Speichern der Artikel-Id zur Benennung des Vorschaubildes in der Form-Validation Klasse
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
			
		if(isset($_POST)){
			foreach($_POST as $k => $v){
				$$k = strip_tags($v); 
			}
		}

		$contentWeb = '<!-- ADD BOOK FORM -->
		<form id="form" method="post" action="' . BASE_URL . '?page=addBook&amp;action=addBook" accept-charset="utf-8" enctype="multipart/form-data" onsubmit="return showWait();">
			<fieldset>
				<label class="left">
					Artikelnummer:
				</label>
				<div class="right">
					<p>' . $articleId . '</p>
				</div>
				<div class="clear"></div>
				<input type="hidden" name="book_articlenumber" value="' . $articleId . '" />
				<label for="book_name" class="left">Buchtitel:*</label>
				<div class="right">
					<input type="text" id="book_name" name="book_name" value="' . $book_name . '" onfocus="activate(this,\'Buchtitel...\')" onblur="leave(this,\'Buchtitel...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_price" class="left">
					Preis in €:*
				</label>
				<div class="right">
					<input id="book_price" name="book_price" type="text" value="' . $book_price . '" onfocus="activate(this,\'Preis in €...\')" onblur="leave(this,\'Preis in €...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_quantity" class="left">
					Menge:*
				</label>
				<div class="right">
					<input id="book_quantity" name="book_quantity" type="text" value="' . $book_quantity . '" onfocus="activate(this,\'Menge...\')" onblur="leave(this,\'Menge...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_genre" class="left">
					Genre:*
				</label>
				<div class="right">
					<select size="1" name="book_genre" id="book_genre">';
					foreach(self::$arrGenre as $k){
						$contentWeb.= '<option value="' . $k . '"';
						if($book_genre == $k){
							$contentWeb.= ' selected="selected"';
						}
						$contentWeb.= '>' . $k . '</option>';
					}
					$contentWeb.= '
					</select>
				</div>
				<div class="clear"></div>
				<label for="book_releasedate" class="left">
					Veröffentlichungsdatum:*
				</label>
				<div class="right">
					<input id="book_releasedate" name="book_releasedate" type="text" value="' . $book_releasedate . '" onfocus="activate(this,\'Veröfftl.datum... dd.mm.YYYY\')" onblur="leave(this,\'Veröfftl.datum... dd.mm.YYYY\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_content" class="left">
					Inhalt:*
				</label>
				<div class="right">
					<textarea id="book_content" name="book_content" cols="5" rows="3" onfocus="activate(this,\'Inhalt...\')" onblur="leave(this,\'Inhalt...\')" class="vorbelegung">' . $book_content . '</textarea>
				</div>
				<div class="clear"></div>
				<label for="book_publisher" class="left">
					Verlag:*
				</label>
				<div class="right">
					<input id="book_publisher" name="book_publisher" type="text" value="' . $book_publisher. '" onfocus="activate(this,\'Verlag...\')" onblur="leave(this,\'Verlag...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_author" class="left">
					Author:*
				</label>
				<div class="right">
					<input id="book_author" name="book_author" type="text" value="' . $book_author . '" onfocus="activate(this,\'Author...\')" onblur="leave(this,\'Author...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_isbn" class="left">
					ISBN:*
				</label>
				<div class="right">
					<input id="book_isbn" name="book_isbn" type="text" value="' . $book_isbn . '" onfocus="activate(this,\'ISBN 13...\')" onblur="leave(this,\'ISBN 13...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="upload" class="left">
					Vorschaubild (*.jpg):*
				</label>
				<div class="file_input_div">
					<img src="images/upload.png" alt="upload_pic" />
					<input type="file" id="upload" name="upload" class="file_input_hidden" />
				</div>
				<div class="clear"></div>
				<input name="addBook" type="submit" class="register" value=" "/>
			</fieldset>
		</form>
		<p>* Pflichtfelder</p>';
		return $contentWeb;
	}

	public static function changeDataBookDisplay($articleId) {
	
		try{
			$sql = "SELECT b_articlenumber, b_name, b_price, b_quantity, b_genre, b_releasedate, b_content, b_author , b_publisher, b_isbn
					FROM dl_books 
					WHERE b_articlenumber = :articleId";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':articleId', $articleId, PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			
			$_SESSION['articleId'] = $articleId;### Speichern der Artikel-Id zur Benennung des Vorschaubildes in der Form-Validation Klasse
		
			foreach ($tmp as $row) {
				$book_name = $row['b_name'];
				$book_price = $row['b_price'];
				$book_quantity = $row['b_quantity'];
				$book_releasedate = $row['b_releasedate'];
				$book_releasedate = functions::date_mysql2german($book_releasedate); ### Datum formatieren
				$book_content = $row['b_content'];
				$book_author = $row['b_author'];
				$book_publisher = $row['b_publisher'];
				$book_genre = $row['b_genre'];
				$book_isbn = $row['b_isbn'];
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		if(isset($_POST)){
			foreach($_POST as $k => $v){
				$$k = strip_tags($v); 
			}
		}
		
		$contentWeb = '<!-- EDIT BOOK FORM -->
		<form id="form" method="post" action="' . BASE_URL . '?page=editBook&amp;action=editBook&amp;articleId=' . $articleId . '" accept-charset="utf-8" enctype="multipart/form-data" onsubmit="return showWait();">
			<fieldset>
				<label class="left">
					Artikelnummer:
				</label>
				<div class="right">
					<p>' . $articleId . '</p>
				</div>
				<div class="clear"></div>
					<input type="hidden" name="book_articlenumber" value="' . $articleId . '" />
				<label for="book_name" class="left">
					Buchtitel:*
				</label>
				<div class="right">
					<input type="text" id="book_name" name="book_name" value="' . $book_name . '" onblur="leave(this,\'Buchtitel...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_price" class="left">
					Preis in €:*
				</label>
				<div class="right">
					<input id="book_price" name="book_price" type="text" value="' . $book_price . '" onblur="leave(this,\'Preis in €...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_quantity" class="left">
					Menge:*
				</label>
				<div class="right">
					<input id="book_quantity" name="book_quantity" type="text" value="' . $book_quantity . '" onblur="leave(this,\'Menge...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_genre" class="left">
					Genre:*
				</label>
				<div class="right">
					<select size="1" id="book_genre" name="book_genre">';
						foreach(self::$arrGenre as $k){
							$contentWeb.= '<option value="' . $k . ' "';
							if($book_genre == $k){
								$contentWeb.= ' selected="selected"';
							}
							$contentWeb.= '>' . $k . '</option>';
						}
						$contentWeb.= '
					</select>
				</div>
				<div class="clear"></div>
				<label for="book_releasedate" class="left">
					Veröffentlichungsdatum:*
				</label>
				<div class="right">
					<input id="book_releasedate" name="book_releasedate" type="text" value="' . $book_releasedate . '" onblur="leave(this,\'Veröfftl.datum... dd.mm.YYYY\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_content" class="left">
					Inhalt:*
				</label>
				<div class="right">
					<textarea id="book_content" name="book_content" cols="5" rows="3" onblur="leave(this,\'Inhalt...\')" class="vorbelegung">' . $book_content  . '</textarea>
				</div>
				<div class="clear"></div>
				<label for="book_author" class="left">
					Author:*
				</label>
				<div class="right">
					<input id="book_author" name="book_author" type="text" value="' . $book_author . '" onblur="leave(this,\'Author...\')" class="vorbelegung"/>
				</div>
				<label for="book_publisher" class="left">
					Verlag:*
				</label>
				<div class="right">
					<input id="book_publisher" name="book_publisher" type="text" value="' . $book_publisher. '" onfocus="activate(this,\'Verlag...\')" onblur="leave(this,\'Verlag...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="book_isbn" class="left">
					ISBN:*
				</label>
				<div class="right">
					<input id="book_isbn" name="book_isbn" type="text" value="' . $book_isbn . '" onfocus="activate(this,\'ISBN 13...\')" onblur="leave(this,\'ISBN 13...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>
				<label for="upload" class="left">
					Vorschaubild (*.jpg):
				</label>
				<div class="file_input_div">
					<img src="images/upload.png" alt="upload_pic" />
					<input type="file" id="upload" name="upload" class="file_input_hidden" />
				</div>
				<div class="clear"></div>
				<input name="editBook" type="submit" class="register" value=" "/>
			</fieldset>
		</form>
		<p>* Pflichtfelder</p>';
		return $contentWeb;
	}
	
	public static function resetPassword($random_number1, $random_number2) {
		
		$resetEmail = 'Ihre Email-Adresse...';
		$resetUser = 'Ihr Anmeldename...';
		
		if(isset($_POST)){
			foreach($_POST as $k => $v){
				$$k = strip_tags($v); 
			}
		}
		
		$contentWeb = '<!-- PASSWORT RESET -->
		<p>Geben Sie die zu Ihrem Digital-Library-Konto gehörende E-Mail-Adresse ein. Klicken Sie dann auf "Weiter".</p>
		<p> Wir senden Ihnen per E-Mail einen Link zu unserer Webseite, auf der Sie ganz einfach Ihr neues Passwort anlegen können.</p>
		<form id="form" action="' . BASE_URL . '?page=resetPassword&amp;action=resetPassword" method="post" accept-charset="utf-8">
			<fieldset>
				<div class="left">
					<p>E-Mail-Adresse:</p>
				</div>			
				<div class="right">
					<input type="text" id="resetEmail" name="resetEmail" value="' . $resetEmail . '" onfocus="activate(this,\'Ihre Email-Adresse...\')" onblur="leave(this,\'Ihre Email-Adresse...\')" class="vorbelegung" />
				</div>
				<div class="clear"></div>
				<div class="left">
					<p>Benutzername:</p>
				</div>			
				<div class="right">
					<input type="text" id="resetUser" name="resetUser" value="' . $resetUser . '" onfocus="activate(this,\'Ihr Anmeldename...\')" onblur="leave(this,\'Ihr Anmeldename...\')" class="vorbelegung" />
				</div>
				<div class="clear"></div>
				<div class="left">
					<p>Sicherheitsfrage: ' . $random_number1 . ' plus ' . $random_number2 . ' = </p>
				</div>
				<input name="number" type="hidden" id="number"  value="' . md5($random_number1 + $random_number2) . '"/>
				<div class="right">
					<input name="arithmetic" type="text" value="Ihr Ergebnis..." onfocus="activate(this,\'Ihr Ergebnis...\')" onblur="leave(this,\'Ihr Ergebnis...\')" class="vorbelegung"/>
				</div>
				<div class="clear"></div>	
				<input type="submit" name="resetSave" class="register" value=" "/>
			</fieldset>
		</form>';
		return $contentWeb;
	}
	
	public static function confirmPassword() {
		
		$code = $_GET['code'];
		
		$contentWeb = '<!-- PASSWORT RESET -->
		<p>Bitte legen Sie jetzt Ihr neues Passwort an.</p>
		<form id="form" action="' . BASE_URL . '?page=confirmPassword&amp;action=confirmPassword&amp;code=' . $code . '" method="post" accept-charset="utf-8">
			<div class="left">
				<p>Neues Passwort:</p>
			</div>
			<div class="right">
				<input name="password" type="password"/>
			</div>
			<div class="clear"></div>
			<div class="left">
				<p>Ihr Passwort bestätigen:</p>
			</div>
			<div class="right">
				<input name="confirm_password" type="password" />
			</div>
			<div class="clear"></div>
			<input type="submit" name="confirmSave" type="submit" class="register" value=" "/>
		</form>';
		return $contentWeb;
	}
}
?>