<?php
class Book{ ### Buchbestand Actions

### Admin Area -------------------------------------------------------------------------------------------------

	public static function setBookData($data){ ### Buch hinzufügen (Admin)
		
		if (!is_array($data)){
			return false;
		}
		
		$data['book_releasedate'] = functions::date_german2mysql($data['book_releasedate']); ### Datum formatieren
		
		try {
			$sql = "INSERT INTO dl_books (b_articlenumber, b_name, b_price, b_quantity, b_genre, b_releasedate, b_content, b_author, b_publisher, b_isbn) 
					VALUES (:book_articlenumber, :book_name, :book_price, :book_quantity, :book_genre, :book_releasedate, :book_content, :book_author, :book_publisher, :book_isbn)";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':book_articlenumber', $data['book_articlenumber'], PDO::PARAM_STR, 4);
			$result->bindParam(':book_name', $data['book_name'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_price', $data['book_price'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_quantity', $data['book_quantity'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_genre', $data['book_genre'], PDO::PARAM_STR, 6);
			$result->bindParam(':book_releasedate', $data['book_releasedate'], PDO::PARAM_STR, 20);
			$result->bindParam(':book_content', $data['book_content'], PDO::PARAM_STR);
			$result->bindParam(':book_author', $data['book_author'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_publisher', $data['book_publisher'], PDO::PARAM_STR, 16);
			$result->bindParam(':book_isbn', $data['book_isbn'], PDO::PARAM_STR, 16);
			$result->execute();
			
			if ($result->rowCount() == 1) {
				return true;
			} 
			else {
				return false;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function changeBookData($data) ### Buchdaten ändern (Admin)
	{
		if (!is_array($data)) {
			return false;
		}
		
		$data['book_releasedate'] = functions::date_german2mysql($data['book_releasedate']); ### Datum formatieren
		
		try { 
			$sql = "UPDATE dl_books 
					SET b_name = :book_name, b_price = :book_price, b_quantity = :book_quantity, b_genre = :book_genre, b_releasedate = :book_releasedate, b_content = :book_content, b_author = :book_author, b_publisher = :book_publisher, b_isbn = :book_isbn
					WHERE b_articlenumber = :book_articlenumber";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':book_articlenumber', $data['book_articlenumber'], PDO::PARAM_STR, 4);
			$result->bindParam(':book_name', $data['book_name'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_price', $data['book_price'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_quantity', $data['book_quantity'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_genre', $data['book_genre'], PDO::PARAM_STR, 6);
			$result->bindParam(':book_releasedate', $data['book_releasedate'], PDO::PARAM_STR, 20);
			$result->bindParam(':book_content', $data['book_content'], PDO::PARAM_STR);
			$result->bindParam(':book_author', $data['book_author'], PDO::PARAM_STR, 30);
			$result->bindParam(':book_publisher', $data['book_publisher'], PDO::PARAM_STR, 16);
			$result->bindParam(':book_isbn', $data['book_isbn'], PDO::PARAM_STR, 16);
			$result->execute();
			
			if ($result->rowCount() == 1) {
				return true;
			} 
			else {
				return false;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function deleteBook($articleId) ### Buch löschen (Admin)
	{
		try {
			$sql = "DELETE 
					FROM dl_books 
					WHERE b_articlenumber = :articleId";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':articleId', $articleId, PDO::PARAM_INT);
			$result->execute();
			
			if ($result->rowCount() == 1) {
				unlink(FULL_DIR . $articleId . '.jpg'); ### Artikelbild löschen
				unlink(THUMB_DIR . 'thumb_' . $articleId . '.jpg'); ### Artikelthumbnail löschen
				return true;
			} 
			else {
				return false;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
### User Area -------------------------------------------------------------------------------------------------
	
	public static function reserveBook($articleId) ## Artikel vormerken
	{
		if (!empty($articleId) && !empty($_SESSION['userNumber'])) {
			try {
				$sql = "UPDATE dl_reserve
						SET res_days = res_days + 1
						WHERE res_articlenumber = :articleId
						AND res_usernumber = :userNumber";
				
				$result = Database::getInstance()->prepare($sql);
				$result->bindParam(':articleId', $articleId, PDO::PARAM_INT);
				$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
				$result->execute();
				
				if ($result->rowCount() == 1) {
					return true;
				}
				
				$sql = "INSERT INTO dl_reserve(res_articlenumber, res_usernumber, res_days, res_quantity)
						VALUES (:articleId, :userNumber, 1, 1)";
				
				$result = Database::getInstance()->prepare($sql);
				$result->bindParam(':articleId', $articleId, PDO::PARAM_INT);
				$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
				$result->execute();
				
				if ($result->rowCount() == 1) {
					return true;
				}
				else return false;
			}
			catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
	
	public static function order() ### Ausleihe aufgeben
	{
		try {
			$sql = "SELECT res_usernumber, res_articlenumber, res_quantity, res_days
					FROM dl_reserve
					WHERE res_usernumber = :userNumber";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($tmp as $key => $value) {
				
				$sql = "INSERT INTO dl_rent (r_usernumber, r_articlenumber, r_quantity, r_days)
						VALUES (:userNumber, :artikel, :menge, :days)";
				
				$result = Database::getInstance()->prepare($sql);
				$result->execute(array(':userNumber' => (int)$value['res_usernumber'], ':artikel' => (int)$value['res_articlenumber'], ':menge' => $value['res_quantity'], ':days' => $value['res_days']));
				
				if ($result->rowCount() == 1) {
					
					$sql1 = "UPDATE dl_books
							SET b_quantity = b_quantity - :anzahl, b_totalrent = b_totalrent + :anzahl
							WHERE b_articlenumber = :artikel";
							
					$result1 = Database::getInstance()->prepare($sql1);
					$result1->bindParam(':anzahl', $value['res_quantity'], PDO::PARAM_INT);
					$result1->bindParam(':artikel', $value['res_articlenumber']);
					$result1->execute();
					
					if ($result1->rowCount() == 1) {
						
						$sql2 = "DELETE FROM dl_reserve
								WHERE res_usernumber = :userNumber
								AND res_articlenumber = :artikel";
								
						$sth2 = Database::getInstance()->prepare($sql2);
						$sth2->execute(array(':userNumber' => $_SESSION['userNumber'], ':artikel' => (int)$value['res_articlenumber']));
						return true;
					}
				}
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function getBooksCount() ### aktuelle Anzahl Artikel im Vormerkliste
	{	
		if($_SESSION['userId'] != 1) {
			
			if(!empty($_SESSION['userId'])){
				try{
					$sql = "SELECT * 
							FROM dl_reserve 
							WHERE res_usernumber = :userNumber";
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
					$result->execute();
					$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
					$num = count($tmp);
					$menge = $num;
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
			else {
				$menge = '-';
			}
			return $menge;
		}
	}
	
	public static function clearTrash()
	{	
		try {
			$sql = "DELETE 
					FROM dl_rent 
					WHERE (r_days-DATEDIFF(NOW(), r_date)) > 30"; ### Ausleihen löschen 30 Tagen nach Ablauf
					
			$result = Database::getInstance()->prepare($sql);
			$result->execute();
			$sql = "DELETE 
					FROM dl_reserve 
					WHERE DATEDIFF(NOW(), res_timestamp) > 14"; ### Vormerkliste löschen nach 14 Tagen
					
			$result = Database::getInstance()->prepare($sql);
			$result->execute();
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function clearAll($page) ### Vormerkliste löschen
	{	
		try{
			$sql = "DELETE 
					FROM dl_reserve 
					WHERE res_usernumber = :userNumber";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
			$result->execute();
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function clearSeparate($articleNumber, $page) ### Einzeln Artikel aus Vormerkliste entfernen
	{	
		try{
			$sql = "DELETE 
					FROM dl_reserve 
					WHERE res_usernumber = :userNumber 
					AND res_articlenumber = :articleNumber";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
			$result->bindParam(':articleNumber', $articleNumber, PDO::PARAM_INT);
			$result->execute();
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}		
	}
}
?>