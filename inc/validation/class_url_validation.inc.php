<?php

class validate
	{
	public static function validateSearch($page){

		### URL parsen
		if($page == 'search'){
			if(!empty($_POST['search']))  { ### GET-Wert an Suche - URL anhängen, wenn nicht vorhanden
				if(preg_match("'<[\/\!]*?[^<>]*?'si", $_POST['search'])){
					header('location:' . BASE_URL);
					exit(); 
				}
				else{
					$searchtext[] = $_POST['search'];
					$url = '&amp;search=';
					$url = str_replace('&amp;', '&', $url); 
					header('location:' . BASE_URL . '?page=search' . $url . $searchtext[0]);
					exit(); 
				}
			}
			if(isset($_GET['search'])){
				return $_GET['search'];
			}
			else {
				header('location:' . BASE_URL);
				exit();
			}
		}
	}
	
	public static function validatePages($page, $userId){ ### Unerlaubte Page nach (USER ID gestaffelt) blocken
		
		$arrPages = array( 
						offline => array(	'start', 
											'selection',
											'allBooks', 
											'search', 
											'register', 
											'details',
											'wrongLogin',
											'resetPassword',
											'confirmPassword',
											'activateAccount'
									),
					  
						  user => array(	'start', 
											'selection', 
											'allBooks', 
											'search', 
											'register', 
											'order', 
											'lastRent', 
											'paymentOverview', 
											'entries',
											'wrongLogin',
											'reserveList',
											'details',
											'setup'
									),
		
						  admin => array(	'start', 
										 	'selection', 
											'allBooks', 
											'setup', 
											'logout', 
											'search', 
											'register', 
											'addBook', 
											'editBook', 
											'entries',
											'logout',
											'details',
											'wrongLogin',
											'allUsers',
											'userDetails',
											'allRentings'
									)
		);
		
		if($page == 'wrongLogin' && $userId != offline){ ### Prüfen ob ein Falsches Einloggen beim wiederholten Einloggen erfolgreich war, danach Umleitung 
			return false;
		}
		
		if($page == 'selection' && !isset($_GET['categorie'])){
			return false;
		}
		
		if($page != 'selection' && isset($_GET['categorie'])){
			return false;
		}
		
		if($page == 'confirmPassword' && !isset($_GET['code'])){
			return false;
		}
		
		if($page == 'details' && !isset($_GET['articleId'])){
			return false;
		}
		
		if($page == 'userDetails' && !isset($_GET['userNumber'])){
			return false;
		}
		
		if($page == 'activateAccount' && !isset($_GET['activateCode'])){
			return false;
		}
		
		if(!in_array($page, $arrPages[$userId])){
			return false;
		}
		else return true;
	}
		
	public static function validateCategories($categorie){ ### Unerlaubte Handlung blocken
	
		$arrCategories = array(
						'Charts', 
						'Biographien', 
						'Gesundheit', 
						'Horror', 
						'Thriller', 
						'Krimi',
						'Romane',
						'Science-Fiction', 
						'Politik', 
					);

		if(!in_array($categorie, $arrCategories)){
			return false;
		}
		else return true;
	}
	
	public static function validateActions($action, $userId){ ### Unerlaubte Handlung (nach USER ID gestaffelt) blocken
		
		$arrActions = array( 
						offline => array(	'logout',
										 	'createPdf',
											'register',
											'resetPassword',
											'confirmPassword'
									),
						  
						  user => array(	'reserveBook', 
											'clear', 
											'clearE',
											'createPdf',
											'EditPersonal',
											'EditPasswort',
											'EditAdress',
											'EditShippingAdress',
											'setup',
											'logout'
									),
		
						  admin => array(	'EditPersonal',
											'EditAdress',
											'deleteBook',
											'EditPasswort',
											'createPdf',
											'editBook',
											'addBook',
											'logout',
											'deleteUser',
											'changeRank2Admin',
											'changeRank2User',
											'deleteRenting'
									)
					);
		if($userId != offline){ ### Echtzeitaktualisierung des Vormerkliste Icons im Header
			if($action == 'reserveBook' || $action == 'clear' || $action == 'clearE' || $action == 'deleteArticle' )
			{ 
				header('location:' . $_SERVER['HTTP_REFERER']);
			}
		}
		
		if($userId == admin){
			if($action == 'deleteUser' || $action == 'changeRank2Admin' || $action == 'changeRank2User' || $action == 'deleteRenting'){
				header('location:' . $_SERVER['HTTP_REFERER']);
			}
		}
		
		if($action == 'deleteRenting' && !isset($_GET['rentingId'])){
			return false;
		}
		
		if($action == 'logout'){
			header('location:' . BASE_URL);
			exit();
		}

		if(!in_array($action, $arrActions[$userId])){
			return false;
		}
		else return true;
	}
	
	public static function validateCode($code){ ### Passwort Resetcode validieren
		
		try{
			$sql = "SELECT 
					COUNT(*) AS num 
					FROM dl_user 
					WHERE u_resetcode = :code";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':code', $code, PDO::PARAM_STR, 16);
			$result->execute();
			$tmp = $result->fetchAll();
	
			foreach ($tmp as $row) {
				if($row['num'] != 1){
					return false;
				}
				else return true;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function validateArticleId($articleId){
		try{
			$sql = "SELECT 
					COUNT(*) AS num 
					FROM dl_books 
					WHERE b_articlenumber = :articleId";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':articleId', $articleId, PDO::PARAM_STR, 4);
			$result->execute();
			$tmp = $result->fetchAll();
	
			foreach ($tmp as $row) {
				if($row['num'] != 1){
					return false;
				}
				else return true;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function validateUserNumber($userNumber){
		try{
			$sql = "SELECT 
					COUNT(*) AS num 
					FROM dl_user 
					WHERE u_usernumber = :userNumber";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll();
	
			foreach ($tmp as $row) {
				if($row['num'] != 1){
					return false;
				}
				else return true;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}	
	
	
	public static function validateActivateCode($activateCode){ ### Aktivierungscode validieren
		
		try{
			$sql = "SELECT 
					COUNT(*) AS num 
					FROM dl_user 
					WHERE u_activatecode = :activateCode";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':activateCode', $activateCode, PDO::PARAM_STR, 16);
			$result->execute();
			$tmp = $result->fetchAll();
	
			foreach ($tmp as $row) {
				if($row['num'] != 1){
					return false;
				}
				else return true;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function validatePOST($entry){ ### Aktivierungscode validieren
		
		$arrValid = array(0, 1, 2, 3, 4);
		
		foreach($entry as $v){
			if(in_array($v, $arrValid)){
				return true;
			}
			else return false;
		}
	}
	
	public static function validateHandler($userId){
		
		if((isset($_POST['login']) || isset($_POST['loginMain'])) && $userId == offline){
			return 'wrongLogin';
		}
		
		if(isset($_GET['page'])){
			if(self::validatePages($_GET['page'], $userId) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
				if($userId != offline){
					header('location:' . BASE_URL);
					exit();
				}
				else {
					header('location:' . BASE_URL . '?page=wrongLogin');
					exit();
				}
			} 
			else { ### Bei gesetzter und valider Page: ...
				
				for($i=1; $i<=3; $i++){
			
					if(isset($_POST["maxEntries_$i"])|| isset($_POST["sort_$i"])){
						if(self::validatePost($_POST) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
							header('location:' . BASE_URL);
							exit();
						}
					}
				}
				
				if(isset($_GET['categorie'])){
					if(self::validateCategories($_GET['categorie']) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
						header('location:' . BASE_URL);
						exit();
					}
				}
				if(isset($_GET['articleId'])){
					if(self::validateArticleId($_GET['articleId']) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
						header('location:' . BASE_URL);
						exit();
					}
				}
				if(isset($_GET['userNumber'])){
					if(self::validateUserNumber($_GET['userNumber']) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
						header('location:' . BASE_URL);
						exit();
					}
				}
				if(isset($_GET['code'])){
					if(self::validateCode($_GET['code']) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
						header('location:' . BASE_URL);
						exit();
					}
				}
				if(isset($_GET['activateCode'])){
					if(self::validateActivateCode($_GET['activateCode']) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
						header('location:' . BASE_URL);
						exit();
					}
				}
				if(isset($_GET['action'])){
					if(self::validateActions($_GET['action'], $userId) == false){ ### Unerlaubte Handlungen und Pages nach USER ID gestaffelt
						if($userId != offline){
							header('location:' . BASE_URL);
							exit();
						}
						else {
							header('location:' . BASE_URL . '?page=wrongLogin');
							exit();
						}
					}
				}
				return $_GET['page'];
			}
		}
		else return header('location:' . BASE_URL . '?page=start'); ### Bei nicht gesetzer Page --> Startseite
	}
}

?>