<?php
class formValidation
{
	private static $emailpattern = '/^[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+$/i';
	private static $namePattern = '/[^a-zA-Z-äöüÄÖÜéàèÉÈ]/';
	private static $pattern = '#\\<(.*)\\>#';
	private static $nicknamePattern = '/[^0-9_a-zA-Z]/';
	private static $datePattern = '/^\d{2}\.\d{2}\.(\d{2}|\d{4})$/';
	private static $dir = 'images_art/';
	private static $arrExtension = array('jpg'); ### Zugelassene Upload Datei-Endungen
	
	public static function getExtension($filename) {
		$ext = substr($filename, strrpos($filename, '.')+1); // strrpos Gibt Numerische Position des Punktes zurück, dieser ist Startwert für substr
		return strtolower($ext);
	}
	
	public static function formValidate($entry, $formType) {
		
		if($formType == 'search'){
			if(strlen($entry) <= 2 || $entry == 'Titel/ ISBN suchen...'){
				$arrStatus[] = 'Geben Sie mindestens 3 Zeichen in das Suchfeld ein.';
			}
		}
		else {
			foreach($entry as $k => $v){
				$$k = strip_tags($v);
			}
		}
		
		if($formType == 'register'){ ### Nur Neuanmeldung
			if(empty($name) || $name == 'Nachname...' || preg_match(self::$namePattern, $name)){ 
				$arrStatus[] = 'Bitte Nachname angeben.';
			}
			
			if(empty($firstname) || $firstname == 'Vorname...' || preg_match(self::$namePattern, $firstname)){ 
				$arrStatus[] = 'Bitte Vorname angeben.';
			}
			
			if(empty($agb)) {
				$arrStatus[] = 'Bitte den AGB zustimmen.';
			}
		}
		
		if($formType == 'register' || $formType == 'EditPasswort' || $formType == 'confirmPassword') {
			
		
			if(empty($password) ||  preg_match(self::$pattern, $password)){ 
				$arrStatus[] = 'Bitte Passwort angeben.';
			}
			
			if(empty($confirm_password) || preg_match(self::$pattern, $confirm_password) || $confirm_password != $password){ 
				$arrStatus[] = 'Bitte Ihr Passwort korrekt bestätigen.';
			}
			
			if($formType == 'confirmPassword'){
				try{
					$sql = 'SELECT 
							u_password
							FROM dl_user 
							WHERE u_resetcode = :code'; 
	
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':code', $_GET['code'], PDO::PARAM_STR, 16);
					$result->execute();
					$tmp = $result->fetchAll();
					
					foreach ($tmp as $row) {
						if($row['u_password'] == md5($password)){
							$arrStatus[] = 'Ihr neues Passwort entspricht Ihrem alten Passwort.';
						}
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}

			if($formType == 'EditPasswort'){
				
				try{
					$sql = 'SELECT u_password 
							FROM dl_user 
							WHERE u_usernumber = :userNumber';
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
					$result->execute();
					$tmp = $result->fetchAll();
					$num = count($tmp);
						
					foreach ($tmp as $row) {
						if($num > 0){
							if($row['u_password'] != md5($current_password)){
								$arrStatus[] = 'Bitte Ihr aktuelles Passwort eingeben.';
							}
						}
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
		
		if($formType == 'register' || $formType == 'EditAdress' || $formType == 'EditShippingAdress'){				
		
			if($formType != 'EditShippingAdress'){
		
				if(empty($nickname) || $nickname == 'Kennung...'){ 
					$arrStatus[] = 'Bitte Kennung angeben.';
				}
				
				elseif(preg_match(self::$nicknamePattern, $nickname)){
					$arrStatus[] = 'Bitte korrekten Anmeldenamen angeben: Es sind nur Buchstaben (A-Z, a-z) sowie Unterstriche erlaubt.';
				}
				
				else {
					try{
						$sql = 'SELECT u_nickname 
								FROM dl_user 
								WHERE u_nickname = :nickname';
								
						$result = Database::getInstance()->prepare($sql);
						$result->bindParam(':nickname', $nickname, PDO::PARAM_STR, 20);
						$result->execute();
						$tmp = $result->fetchAll();
						$num = count($tmp);
				  
						foreach ($tmp as $row) {
							if($num > 0){
								if(isset($_SESSION['nickname']) && $row['u_nickname'] != $_SESSION['nickname']){
									$arrStatus[] = 'Anmeldename schon vergeben.';
								}
								elseif (!isset($_SESSION['nickname'])){
									$arrStatus[] = 'Anmeldename schon vergeben.';
								}
							}
						}
					}
					catch (PDOException $e) {
						echo $e->getMessage();
					}
				}
				
				if(empty($email) || $email == 'E-Mail Adresse...' || !preg_match(self::$emailpattern, $email)){
					$arrStatus[] = 'Bitte E-Mail Adresse angeben.';	
				}		
				else {
					try{
						$sql = 'SELECT u_email 
								FROM dl_user 
								WHERE u_email = :email';
		  
						$result = Database::getInstance()->prepare($sql);
						$result->bindParam(':email', $email, PDO::PARAM_STR, 30);
						$result->execute();
						$tmp = $result->fetchAll();
						$num = count($tmp);
		
						foreach ($tmp as $row) {
							if($num > 0){
								if(isset($_SESSION['email']) && $row['u_email'] != $_SESSION['email']){
										$arrStatus[] = 'E-Mail Adresse schon vergeben.';
								}
								elseif (!isset($_SESSION['email'])){
									$arrStatus[] = 'E-Mail Adresse schon vergeben.';
								}
							}
						}
					}
					catch (PDOException $e) {
						echo $e->getMessage();
					}
				}
			}

			if(empty($city)|| $city == 'Ort...' || preg_match(self::$namePattern, $city)){ 
				$arrStatus[] = 'Bitte Ort angeben.';
			}
		
			if(empty($postcode)|| $postcode == 'Postleitzahl...' || preg_match(self::$pattern, $postcode) || !is_numeric($postcode)){ 
				$arrStatus[] = 'Bitte Postleitzahl angeben.';
			}
		
			if(empty($street) || $street == 'Straße...' || preg_match(self::$pattern, $street)){ 
				$arrStatus[] = 'Bitte Straße angeben.';
			}
		}
		
		if($formType == 'addBook' || $formType == 'editBook'){ ### Prüfen, ob Buchtitel angegeben){ ### Prüfen, ob Buchtitel angegeben
		
			if(empty($book_name) || $book_name == 'Buchtitel...' || preg_match(self::$pattern, $book_name)){ 
				$arrStatus[] = 'Bitte Buchtitel angeben.';
			}
			
			elseif($formType == 'addBook') { ### Prüfen, ob Buchtitel schon vergeben ist
				
				try{
					$sql = 'SELECT COUNT(*) AS num 
							FROM dl_books 
							WHERE b_name = :book_name';
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':book_name', $book_name, PDO::PARAM_STR, 300);
					$result->execute();
					$tmp = $result->fetchAll();
		
					foreach ($tmp as $row) {
						if($row['num'] > 0){
							$arrStatus[] = 'Buchtitel ist schon vergeben.';
						}
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
			
			if(empty($book_price) || $book_price == 'Buchpreis...' || preg_match(self::$pattern, $book_price) || !is_numeric($book_price)){ 
				$arrStatus[] = 'Bitte Preis angeben. (Syntax: xx oder xx.xx)';
			}
			
			if(empty($book_quantity) || $book_quantity == 'Menge...' || preg_match(self::$pattern, $book_quantity) || !is_numeric($book_quantity)){ 
				$arrStatus[] = 'Bitte Menge angeben.';
			}
			
			if(empty($book_isbn) || $book_quantity == 'ISBN 13...' || preg_match(self::$pattern, $book_isbn) || !is_numeric($book_isbn)){ 
				$arrStatus[] = 'Bitte korrekte ISBN13 angeben.';
			}
			elseif(strlen($book_isbn) != 13){
				$arrStatus[] = 'ISBN13 muss 13 Stellen haben.';
			}
			
			if(empty($book_genre) || $book_genre == 'Genre...' || preg_match(self::$pattern, $book_genre)){ 
				$arrStatus[] = 'Bitte Genre angeben.';
			}
			
			if(empty($book_releasedate) || $book_releasedate == 'Veröfftl.date... dd.mm.YYYY' || !preg_match(self::$datePattern, $book_releasedate)){  ### Syntax Datum prüfen
				$arrStatus[] = 'Bitte Veröffentlichungsdate angeben. (Syntax. dd.mm.YYYY)';
			}
			
			elseif(functions::checkDate($book_releasedate) == false){ ### Existenz Datum prüfen
				$arrStatus[] = 'Das Veröffentlichungsdate ist nicht existent.';
			}
			
			if(empty($book_content) || $book_content == 'Inhalt...' || preg_match(self::$pattern, $book_content)){ 
				$arrStatus[] = 'Bitte Inhalt angeben.';
			}
			
			if(empty($book_author) || $book_author == 'Author...' || preg_match(self::$pattern, $book_author)){ 
				$arrStatus[] = 'Bitte Author angeben.';
			}
			
			if(empty($book_publisher) || $book_publisher == 'Verlag...' || preg_match(self::$pattern, $book_publisher)){ 
				$arrStatus[] = 'Bitte Verlag angeben.';
			}
			
			if($formType == 'addBook' || $formType == 'editBook') {
				
				if(empty($_FILES['upload']['tmp_name']) && $formType == 'addBook'){
					$arrStatus[] = 'Datei auswählen';
				}
				
				elseif(!empty($_FILES['upload']['tmp_name'])){
					
					if($_FILES['upload']['size'] > MAX_FILE_SIZE){
						$arrStatus[] = 'Datei zu groß';
					}
					
					if(!in_array(self::getExtension($_FILES['upload']['name']), self::$arrExtension)){
						$arrStatus[] = 'Datei hat falschen Dateinamen';
					}
				
					if(empty($arrStatus)){
						$fullStatus = Functions::createThumbnail($_FILES['upload']['tmp_name'], FULL_DIR, $_SESSION['articleId'] . '.' . self::$arrExtension[0] , FULL_WIDTH, JPG_QUALITY);
						$thumbStatus = Functions::createThumbnail($_FILES['upload']['tmp_name'], THUMB_DIR, 'thumb_' . $_SESSION['articleId'] . '.' . self::$arrExtension[0] , THUMB_HEIGHT, JPG_QUALITY, 'width');
						if($fullStatus == false || $thumbStatus == false){
							$arrStatus[] = 'Fehler beim Erzeugen der Thumbnails';
						}
					}
				}
			}
		}
		
		if($formType == 'wrongLogin'){
			
			if(!empty($nickname) && $nickname != 'Username...'){
				
				try{
					$sql = 'SELECT COUNT(*) AS num 
							FROM dl_user 
							WHERE u_nickname = :nickname';
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':nickname', $nickname, PDO::PARAM_STR, 20);
					$result->execute();
					$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($tmp as $row) {
						if($row['num'] == 0){
							$arrStatus[] = 'Username nicht vergeben.';
						}
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
			else $arrStatus[] = 'Bitte Username angeben.';
			
			if(empty($password)){ 
				$arrStatus[] = 'Bitte Passwort angeben.';
			}
			else {
				
				try{
					$sql = 'SELECT 
							COUNT(*) AS num 
							FROM dl_user 
							WHERE u_password = :password 
							AND u_nickname = :nickname';
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':nickname', $_POST['nickname'], PDO::PARAM_STR, 20);
					$result->bindParam(':password', $_POST['password'], PDO::PARAM_STR, 32);
					$result->execute();
					$tmp = $result->fetchAll();
	
					foreach ($tmp as $row) {
						if($row['num'] == 0){
							$arrStatus[] = 'Falsches Passwort oder Benutzername.';
						}
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
			
			if(!empty($nickname) && !empty($password)){
				
				try{
					$sql = 'SELECT 
							COUNT(*) AS num 
							FROM dl_user 
							WHERE u_password = :password 
							AND u_nickname = :nickname
							AND u_activatecode IS NOT NULL';
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':nickname', $_POST['nickname'], PDO::PARAM_STR, 20);
					$result->bindParam(':password', $_POST['password'], PDO::PARAM_STR, 32);
					$result->execute();
					$tmp = $result->fetchAll();
		
					foreach ($tmp as $row) {
						if($row['num'] == 1){
							$arrStatus[] = 'Ihr Account ist noch nicht freigeschaltet. Bitte klicken Sie auf Ihren E-Mail Bestätigungslink.';
						}
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
		
		if($formType == 'register' || $formType == 'resetPassword'){
			
			if($number != md5($arithmetic)){  
				$arrStatus[] ='Die Rechenaufgabe wurde falsch gel&ouml;st!';  
			}
		}
		
		if($formType == 'resetPassword'){
			
			if(!empty($resetUser) && !empty($resetEmail) && $resetUser != 'Ihr Anmeldename...' && $resetEmail != 'Ihre Email-Adresse...'){
				
				try{
					$sql = 'SELECT COUNT(*) AS num  
							FROM dl_user 
							WHERE u_nickname = :resetUser 
							AND u_email = :resetEmail'; 
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':resetUser', $resetUser, PDO::PARAM_STR, 20);
					$result->bindParam(':resetEmail', $resetEmail, PDO::PARAM_STR, 30);
					$result->execute();
					$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
					
					foreach ($tmp as $row) {
						if($row['num'] == 0){
							$arrStatus[] = 'Authentifizierung fehlgeschlagen. Bitte prüfen Sie Ihre E-Mail Adresse und Ihren Anmeldenamen.';
						}
					}
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
			else $arrStatus[] = 'Bitte Username und E-Mail Adresse angeben.';
		}

		if(!empty($arrStatus)) {
			return $arrStatus;
		}
	}
}
?>