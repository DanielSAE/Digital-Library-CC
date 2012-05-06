<?php
include("inc/class_pdf.inc.php");

class Display_Library ### Anzeige der Bibliothek-Oberfläche in HTML
{	
	private $pdf;
	
	public function __construct()
	{
		$this->pdf = new pdf();
	}
	
	public function latestBooks($numbers) ### Neueste 10 Bücher anzeigen auf Startseite, $numbers => Tage Bücher
	{
		try {
			$sql = "SELECT b_articlenumber, b_name FROM dl_books 
					WHERE b_quantity > 0 
					ORDER BY b_releasedate desc 
					LIMIT 0, :numbers";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':numbers', $numbers, PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll();
		
			$contentWeb = '<!-- DYNAMIC CONTENT -->
			<div class="headline"><!-- HEADLINE -->
				<h2>Aktuelle B&uuml;cher-Neuerscheinungen</h2>
			</div>
			<div id="newestBooks">';
			
			foreach ($tmp as $row) {
				$contentWeb .= '
				<div class="new">
					<a href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '"><img src="' . THUMB_DIR . 'thumb_' . $row['b_articlenumber'] . '.jpg" alt="' . $row['b_name'] . '" 	height = "125" width = "97" /></a>
					<a href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">' . substr($row['b_name'], 0, 15) . '...' . '</a>
				</div>';
			}
			
			$contentWeb .= '
				<div class="clear"></div>
			</div>
			';
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
	
	public function search($searchtext, $arrMaxEntries, $arrOrderBy, $arrStatus = 0) //Gesuchte  Artikel anzeigen
	{
		$datensaetze_pro_seite = $arrMaxEntries[$_SESSION['maxEntries_1']]; 
		$select = Functions::order($_SESSION['orderBy_1']);
		
		try {
			$sql2 = "SELECT * 
					FROM dl_books 
					WHERE b_name LIKE :searchtext
					OR b_isbn LIKE :searchtext";
					
			$searchtextTotal = '%' . $searchtext . '%';
					
			$resultTotal = Database::getInstance()->prepare($sql2);
			$resultTotal->bindParam(':searchtext', $searchtextTotal, PDO::PARAM_STR, 20);
			$resultTotal->execute();
			$tmp2 = $resultTotal->fetchAll(PDO::FETCH_ASSOC);
			$total = count($tmp2);
			
			$arrNavi = Functions::naviBar($total, $datensaetze_pro_seite);
			$start = $arrNavi['start'];
	
			$sql = "SELECT b_name, b_articlenumber, b_quantity, b_price, b_genre 
					FROM dl_books 
					WHERE b_name 
					LIKE '%" . $searchtext . "%'
					OR b_isbn LIKE '%" . $searchtext . "%'
					" . $select . " 
					LIMIT " . $start . "," . $datensaetze_pro_seite;
			
			$result = Database::getInstance()->query($sql);
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			
			$contentWeb = '<!-- HEADLINE -->
			<div class="headline">
				<h2>Ihre Suche</h2>
			</div>';
	
			if($arrStatus != 0){
				$contentWeb .= Functions::errorMessaging($arrStatus);
				$contentWeb .= '
				<p>Suchbegriff: ' . $searchtext . '</p>
				<p>Ihre Suche ergab leider keine Treffer!</p>';
			}
			else {
				$contentWeb .= '<p>Tage Treffer: ' . $total . ', Suchbegriff: ' . $searchtext . '</p>';
				if($total > 0) {
					$contentWeb .= Functions::bookListTable($tmp, $arrMaxEntries, $arrOrderBy, $arrNavi);
				}
				else $contentWeb .= '
				<p>Ihre Suche ergab leider keine Treffer!</p>';
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
	
	public function displayUsers($page, $arrMaxEntries, $arrOrderBy = 0){
		
		$datensaetze_pro_seite = $arrMaxEntries[$_SESSION['maxEntries_2']]; 
			
		try{
			$sql2 = "SELECT * 
					FROM dl_user
					WHERE u_usernumber != " . $_SESSION['userNumber'];
					
			$resultGesamt = Database::getInstance()->query($sql2);
			$tmp2 = $resultGesamt->fetchAll(PDO::FETCH_ASSOC);
			$total = (count($tmp2)); 
			
			$arrNavi = Functions::naviBar($total, $datensaetze_pro_seite); ### Navi Bar unten
			$start = $arrNavi['start'];
			
			$select = Functions::order2($_SESSION['orderBy_2']);
		
			$sql = "SELECT u_nickname, u_name, u_firstname, u_email, u_userid, u_usernumber, u_registerdate
					FROM dl_user
					WHERE u_usernumber != " . $_SESSION['userNumber'] . "
					" . $select . "
					LIMIT
					" . $start . "," . $datensaetze_pro_seite;
			   
			$result = Database::getInstance()->query($sql);
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
		
			$contentWeb =  '<!-- HEADLINE -->
			<div class = "headline">
				<h2>Alle Benutzer</h2>
			</div> ';
			if($total > 0) {
				$contentWeb .= Functions::userListTable($tmp, $arrMaxEntries, $arrOrderBy, $arrNavi, $page);
			}
			else $contentWeb .= '
			<p>Es ist leider noch kein User angemeldet!</p>';
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
		
	public function displayBooks($page, $arrMaxEntries, $arrOrderBy = 0){
		
		$datensaetze_pro_seite = $arrMaxEntries[$_SESSION['maxEntries_1']]; 
				
		if(isset($_GET['categorie'])){
			
			$categorie = $_GET['categorie'];
			
			if($categorie == "Charts") {
				$select = " WHERE b_quantity > 0 
							ORDER BY b_totalrent desc";
							
				$headline = "B&uuml;cher-Charts";
			}
			else {
				$select = " WHERE b_genre = '" . $categorie . "' 
							AND b_quantity > 0 " . Functions::order($_SESSION['orderBy_1']);
							
				$headline = $categorie;
			}
		}
		
		if($page == "allBooks"){
			$select = "WHERE b_quantity > 0 " . Functions::order($_SESSION['orderBy_1']);
			$headline = "Alle B&uuml;cher";
		}
		
		try{
			$sql2 = "SELECT * 
					FROM dl_books " . $select; ### Ermittelt die Gesamtzahl der Datensätze
			
			$resultGesamt = Database::getInstance()->query($sql2);
			$tmp2 = $resultGesamt->fetchAll(PDO::FETCH_ASSOC);
			$total = (count($tmp2)); 
			
			$arrNavi = Functions::naviBar($total, $datensaetze_pro_seite); ### Navi Bar unten
			
			$start = $arrNavi['start'];
		
			$sql = "SELECT b_articlenumber, b_name, b_price, b_quantity, b_articlenumber, b_genre, b_releasedate 
					FROM dl_books " . $select . "
					LIMIT
				   " . $start . "," . $datensaetze_pro_seite;
				   
			$result = Database::getInstance()->query($sql);
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
		
			$contentWeb =  '<!-- HEADLINE -->
			<div class = "headline">
				<h2>' . $headline . '</h2>
			</div>';
			
			if($total > 0) {
				$contentWeb .= Functions::bookListTable($tmp, $arrMaxEntries, $arrOrderBy, $arrNavi, $page);
			}
			else $contentWeb .= '
			<p>Es ist leider kein Buch in dieser Kategorie vorrätig!</p>';
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
	
	public function displayAllRentings($page, $arrMaxEntries, $arrOrderBy = 0){ ### Alle Ausleihen einsehen (Admin)
		
		$datensaetze_pro_seite = $arrMaxEntries[$_SESSION['maxEntries_3']]; 
		
		$select = Functions::order3($_SESSION['orderBy_3']);	
		
		try{
			$sql2 = "SELECT * 
					FROM dl_rent";
					
			$resultGesamt = Database::getInstance()->query($sql2);
			$tmp2 = $resultGesamt->fetchAll(PDO::FETCH_ASSOC);
			$total = (count($tmp2)); 
			
			$arrNavi = Functions::naviBar($total, $datensaetze_pro_seite); ### Navi Bar unten
			
			$start = $arrNavi['start'];
			
			$sql = "SELECT u_nickname, u_usernumber, b_name, b_articlenumber, date_format(r_date,\"%d.%m.%Y\") AS r_date, DATEDIFF(NOW(), r_date) AS r_timediff, r_days, r_id 
					FROM dl_books, dl_rent, dl_user
					WHERE dl_books.b_articlenumber = dl_rent.r_articlenumber 
					AND dl_rent.r_usernumber = dl_user.u_usernumber
					" . $select . "
					LIMIT
					" . $start . "," . $datensaetze_pro_seite;
				   
			$result = Database::getInstance()->query($sql);
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
		
			$contentWeb =  '<!-- HEADLINE -->
			<div class = "headline">
				<h2>Alle User-Ausleihen</h2>
			</div>';
			
			if($total > 0) {
				$contentWeb .= Functions::rentListTable($tmp, $arrMaxEntries, $arrOrderBy, $arrNavi, $page);
			}
			else $contentWeb .= '
			<p>Es ist leider keine Ausleihe getätigt worden!</p>';
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
	
	public function reserveList() ### Vormerkliste
	{
		try{
			$sql = "SELECT b_name, res_days, b_articlenumber, b_price, res_quantity
					FROM dl_reserve, dl_books
					WHERE res_usernumber = :userNumber
					AND res_articlenumber = b_articlenumber";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			$num = count($tmp);
			
			$contentWeb = '<!-- HEADLINE -->
			<div class="headline">
				<h2>Vorgemerkte Titel</h2>
			</div>';
			$gesamtPreis = 0;
			if ($num > 0) { ### Prüft, ob Vormerkliste -->$row 
				$contentWeb .= '
				<table width="100%">
					<colgroup>
						<col />
						<col width="65" />
						<col width="75" />
						<col width="75" />
						<col width="50" />
					</colgroup>
					<tr>
						<th>Titel</th>
						<th>Tage</th>
						<th>Preis/ Tag</th>
						<th>+1 Tag</th>
						<th></th>
					</tr>';
				foreach ($tmp as $row) {
					$contentWeb .= '
					<tr>
						<td>
							<p>
								<a href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">' . $row['b_name'] . '</a>
							</p>
						</td>
						<td>
							<p>' . $row['res_days'] . '</p>
						</td>
						<td>
							<p>' . Functions::calculatePrice($row['b_price'], $row['res_days']) . ' €</p>
						</td>
						<td>
							<p>
								<a class="opacityLink" href="' . BASE_URL . $_SESSION['currentUrl'] . '&amp;action=reserveBook&amp;articleId=' . $row['b_articlenumber'] . '">
									<img src="images/btn_day_plus.png" title="+1" alt="+1" />
								</a>
							</p>
						</td>
						<td>
							<p>
								<a href="' . BASE_URL .  $_SESSION['currentUrl'] . '&amp;action=clearE&amp;articleId=' . $row['b_articlenumber'] . '">
									<img src="images/btn_delete.png" title="Datensatz l&ouml;schen" alt="Datensatz l&ouml;schen" />
								</a>
							</p>
						</td>
					</tr>';
					$gesamtPreis += Functions::calculatePrice($row['b_price'], $row['res_days']);
					$gesamtPreis = Functions::formatPrice($gesamtPreis, 2,",", ".");
				}
				$contentWeb .= '
				</table>
				<p>Gesamtpreis: ' . $gesamtPreis . ' €</p>
				<a class="shadowLink" href="' . BASE_URL . '?page=paymentOverview"><img src="images/btn_accept.png" title="zur Kasse" alt="zur Kasse" /></a>
				<a class="shadowLink" href="' . BASE_URL .  $_SESSION['currentUrl'] . '&amp;action=clear"><img src="images/btn_clear_list.png" title="Vormerkliste löschen" alt="Vormerkliste löschen" /></a>';
			} 
			else {
				$contentWeb .= 
				'<p>Keine Artikel in der Vormerkliste gefunden.</p>';
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		echo $contentWeb;
	}
	
	public function details($articleId) ### Detailansicht der Bücher
	{
		try{
			$sql = "SELECT b_name, b_price, b_articlenumber, b_content, b_author, b_releasedate, b_quantity, b_publisher, b_isbn
					FROM dl_books
					WHERE b_articlenumber = :articleId";	
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':articleId', $articleId, PDO::PARAM_INT);
			$result->execute();			
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);		
			
			foreach ($tmp as $row) {
				$contentWeb = '<!-- HEADLINE -->
				<div class="headline">
					<h2>' . $row['b_name'] . '</h2>
				</div>
				<table id="detail">
					<colgroup>
						<col width="120" />
						<col />
						<col width="150" />
						<col width="75" />
					</colgroup>
					<tr>
						<th></th>
						<th>Daten</th>
						<th>Author</th>
						<th>Preis/ Tag</th>
					</tr>
					<tr>
						<td>
							<a class="fancybox" href="images_art/' . $row['b_articlenumber'] . '.jpg"><img src="' . THUMB_DIR . 'thumb_' . $row['b_articlenumber'] . '.jpg" alt="' . $row['b_name'] . '" height="170" width="120" /></a>
						</td>
						<td>
							<p>Veröffentlicht am: ' . Functions::date_mysql2german($row['b_releasedate']) . '</p>
							<p>Verlag: ' . $row['b_publisher'] . '</p>
							<p>Artikelnummer: ' . $row['b_articlenumber'] . '</p>
							<p>ISBN 13: ' . $row['b_isbn'] . '</p>
							<p>Verfügbarkeit: ';
				if($_SESSION['userId'] != admin){ 
					$contentWeb .= Functions::productStatus($row['b_quantity']);
				} 
				elseif($_SESSION['userId'] == admin){
					$contentWeb .= $row['b_quantity'];
				}
				$contentWeb .= '</p>
						</td>
						<td><p>' . $row['b_author'] . '</p></td>
						<td><p>' . $row['b_price'] . ' €</p></td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<th>Inhalt</th>
					</tr>
					<tr>
						<td><p>' . str_replace(chr(10),'<br />',$row['b_content']) . '</p></td>
					</tr>
				</table>';
				if($_SESSION['userId'] != admin) {
					$contentWeb .= '
				<a class="shadowLink" href="' . BASE_URL . $_SESSION['currentUrl'] . '&amp;action=reserveBook "><img src="images/btn_reserve.png" title="Artikel vormerken" alt="Artikel vormerken" /></a>';
				}
				elseif($_SESSION['userId'] == admin) {
					$contentWeb .= '
				<a class="shadowLink" href="' . BASE_URL . '?page=editBook&amp;articleId=' . $row['b_articlenumber'] . '"><img src="images/btn_edit.png" title="Daten editieren" alt="edit" /></a>';
				}
			}
			$contentWeb .= '
				<a class="shadowLink" href="' . BASE_URL . $_SESSION['currentUrl'] . '&amp;action=createPdf"><img src="images/btn_pdf.png" title="als PDF anzeigen" alt="als PDF" /></a>
				<a class="shadowLink" href="' . $_SESSION['refererUrl'] . '"><img src="images/btn_back.png" title="zurück" alt="zurück" /></a>';
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
	
	public function userDetails($userNumber) ### Detailansicht der Bücher
	{
		try{
			$sql = "SELECT u_nickname, u_name, u_firstname, u_email, u_street, u_city, u_postcode, s_street, s_city, s_postcode, u_userid, u_registerdate
					FROM dl_user
					WHERE u_usernumber = :userNumber";	
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
			$result->execute();			
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);		
			
			foreach ($tmp as $row) {
				$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>User-Details zu "' . $row['u_nickname'] . '"</h2>
		</div>
		<table width="100%">
			<tr>
				<th colspan="2">Persönlichen Daten</th>
			</tr>
			<tr>
				<td>
					<p>User-Nummer: 
				</td>
				<td>
					<p>' . $userNumber . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Anmeldename: 
				</td>
				<td>
					<p>' . $row['u_nickname'] . '</p>
				</td>
			</tr>
			<tr>
				<td width="200px">
					<p>Name: 
				</td>
				<td>
					<p>' . $row['u_name'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Vorname: </p>
				</td>
				<td>
					<p>' . $row['u_firstname'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Email: </p>
				</td>
				<td>
					<p>' . $row['u_email'] . '</p>
				</td>
			</tr>
			<tr>
				<td width="200px">
					<p>Strasse: </p>
				</td>
				<td>
					<p>' . $row['u_street'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Ort: </p>
				</td>
				<td>
					<p>' . $row['u_city'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Postleitzahl: </p>
				</td>
				<td>
					<p>' . $row['u_postcode'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Anmeldedatum: </p>
				</td>
				<td>
					<p>' . Functions::date_mysql2german($row['u_registerdate']) . '</p>
				</td>
			</tr>
		</table>';
		if($row['u_userid'] != admin){
			$contentWeb .= '
		<table width="100%">
			<tr>
				<th colspan="2">Lieferadresse</th>
			</tr>
			<tr>
				<td width="200px">
					<p>Strasse: </p>
				</td>
				<td>
					<p>' . $row['s_street'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Ort: 
				</td>
				<td>
					<p>' . $row['s_city'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Postleitzahl: 
				</td>
				<td>
					<p>' . $row['s_postcode'] . '</p>
				</td>
			</tr>
		</table>
		';
		}
		$contentWeb .= '
		<table width="100%">
			<tr>
				<th colspan="2">Rang-Management</th>
			</tr>
			<tr>
				<td width="200px">
					<p>Rang: </p>
				</td>
				<td>
					<p>' . Functions::userRank($row['u_userid']) . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Rang-Änderung: </p>
				</td>';
				if($row['u_userid'] == user){
					$contentWeb .=
				'<td>
					<p><a href="' . BASE_URL . '?page=userDetails&amp;userNumber=' . $userNumber . '&amp;action=changeRank2Admin"><span class="red">"Admin"</span>-Rang zuweisen</a></p>
				</td>';
				}
				elseif($row['u_userid'] == admin){
					$contentWeb .=
				'<td>
					<p><a href="' . BASE_URL . '?page=userDetails&amp;userNumber=' . $userNumber . '&amp;action=changeRank2User"><span class="red">"Benutzer"</span>-Rang zuweisen</a></p>
				</td>';
				}
			$contentWeb .= '
			</tr>
		</table>';
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		$contentWeb .= '
			<a class="shadowLink" href="' . $_SESSION['refererUrl'] . '"><img src="images/btn_back.png" title="zurück" alt="zurück" /></a>';
		echo $contentWeb;
	}

	public function lastRent() { ### Ausleihstatus
	
		try{
			$sql = "SELECT b_name, b_articlenumber, date_format(r_date,\"%d.%m.%Y\") AS r_date, DATEDIFF(NOW(), r_date) AS r_timediff, r_days 
					FROM dl_books, dl_rent 
					WHERE dl_books.b_articlenumber = dl_rent.r_articlenumber 
					AND dl_rent.r_usernumber = :userNumber";
	
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			$num = (count($tmp));
		
			$contentWeb = '<!-- HEADLINE -->
			<div class="headline">
				<h2>Ihre Ausleihen der letzten 30 Tage:</h2>
			</div>';
			
			if ($num == 0){ ### Prüft, ob der Nutzer bereits Bestellungen getätigt hat
				$contentWeb .= '
			<p>Sie haben noch keine Ausleihen getätigt!</p>';
			}
			else { 
			$contentWeb .= '
			<table border="0" width="100%">
				<colgroup>
					<col/>
					<col width="130" />
					<col width="75" />
					<col width="110" />
				</colgroup>				
				<tr>
					<th>Titel</th>
					<th>Verbleibende Tage</th>
					<th>Ausleihdauer</th>
					<th>Ausleihdatum</th>
				</tr>';
			foreach ($tmp as $row) { 
				
				$remainingDays = (int)$row['r_days'] - (int)$row['r_timediff'];
				if($remainingDays <= 0){
					$remainingDays = '<span class="red">abgelaufen</span>';
				}
				else $remainingDays = 'Noch ' . $remainingDays . ' Tag/e';
				
				$contentWeb .= '
				<tr>
					<td>
						<p>
							<a href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">' . $row['b_name'] . '</a>
						</p>
					</td>
					<td>
						<p>' . $remainingDays . '</p>
					</td>
					<td>
						<p>' . $row['r_days'] . ' Tag/e</p>
					</td>
					<td>
						<p>'  . $row['r_date'] . '</p>
					</td>
				</tr>';
			}
			$contentWeb .= '
			</table>';
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
		
	public function navigation($naviListMain, $page){
		
		$naviList = $naviListMain[$_SESSION['userId']];
		
		if(isset($_GET['categorie'])){ ### Ausnahme: Kategorien einbinden!!!
			$page = $_SERVER['QUERY_STRING'];
			$page = str_replace('&', '&amp;', $page);
		}
		else $page = 'page=' . $page;
		$contentWeb = '<!-- NAVIGATION -->
		<div id="navigation">
			<ul>
				' . Functions::navigation($naviList, $page) . '
			</ul>
		</div>
		';
		echo $contentWeb;
	}
		
	public function SidebarNavigation($naviList, $page){
		
		if(isset($_GET['categorie'])){  ### Ausnahme: Kategorien einbinden!!!
			$page = $_SERVER['QUERY_STRING'];
			$page = str_replace('&', '&amp;', $page);
		}
		else $page = 'page=' . $page;
		
		$contentWeb = '<!-- SIDEBAR NAVIGATION -->
		<div class="heading">
			<h2>Kategorien</h2>
		</div>
		<ul class="cats">
			' . Functions::navigation($naviList, $page) . '
		</ul>
		';
		echo $contentWeb;
	}
	
	public function AdminSidebarNavigation($naviList, $page){
		
		$page = 'page=' . $page;
		
		$contentWeb = '<!-- SIDEBAR NAVIGATION -->
		<div class="heading">
			<h2>Benutzerverwaltung</h2>
		</div>
		<ul class="cats">
			' . Functions::navigation($naviList, $page) . '
		</ul>
		';
		echo $contentWeb;
	}
	
	public function reserveListIcon($articleCount) {
	
		if($_SESSION['userId'] != admin) {
			$contentWeb = '<!-- RESERVELIST ICON -->
		<div class="right">
			<div id="reserveList_icon">
				<div id="reserveList_bg">
					<p class = "big">' . $articleCount . '</p>
					<div style="float:left; text-align:center;">
						<p><a href="' . BASE_URL . '?page=reserveList">Titel<br />vorgemerkt</a></p>
					</div>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	';
		}
		elseif($_SESSION['userId'] == admin) {
			$contentWeb = '
			<div class="clear"></div>
		</div>
		';
		}
		echo $contentWeb;
	}
	
	public  function forms($formType, $arrStatus = 0, $articleId = 0) {
	
		$random_number1 = intval(rand(1, 9));  
		$random_number2 = intval(rand(1, 9)); 
		
		if($formType == 'EditPasswort') {
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Ihr Passwort ändern</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::changeDataFormDisplay($_SESSION['userId'], $random_number1, $random_number2, $formType);
		}
		elseif($formType == 'EditAdress') {
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Ihre Postadresse ändern</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::changeDataFormDisplay($_SESSION['userId'], $random_number1, $random_number2, $formType);
		}
		elseif($formType == "EditShippingAdress") {
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Ihre Lieferadresse ändern</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::changeDataFormDisplay($_SESSION['userId'], $random_number1, $random_number2, $formType);
		}
		elseif($formType == "wrongLogin"){
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Sie sind noch nicht angemeldet</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::loginFormMain($_SESSION['userId'], $random_number1, $random_number2);
		}
		elseif($formType == "loginLeft"){
			$contentWeb = Display_Form::loginFormLeft($_SESSION['userId']);
		}
		elseif($formType == "register") {
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Anmeldung</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::registerFormDisplay($_SESSION['userId'], $random_number1, $random_number2);
		}
		elseif($formType == "addBook") {
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Buch hinzufügen</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::addBookDisplay();
		}
		elseif($formType == "editBook") {
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Buch editieren</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::changeDataBookDisplay($articleId);
		}
		elseif($formType == "resetPassword") {
			$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Sie haben Ihr Passwort vergessen? Jetzt neues Passwort anfordern.</h2>
		</div>
			' . Functions::errorMessaging($arrStatus) . '
			' . Display_Form::resetPassword($random_number1, $random_number2);
		}
		elseif($formType == "confirmPassword") {
			$contentWeb = '<!-- HEADLINE -->
			<div class="headline">
				<h2>Bitte legen Sie Ihre neues Passwort an</h2>
			</div>
				' . Functions::errorMessaging($arrStatus) . '
				' . Display_Form::confirmPassword();
		}
		
		echo $contentWeb;
	}
	
	public function setup() {
	
		$contentWeb = '<!-- HEADLINE -->
		<div class="headline">
			<h2>Ihre persönlichen Daten</h2>
		</div>
		<table width="100%">
			<colgroup>
				<col width="200" />
				<col />
			</colgroup>
			<tr>
				<th colspan="2">Ihre persönlichen Daten</th>
			</tr>
			
			<tr>
				<td>
					<p>User-Number: </p>
				</td>
				<td>
					<p>' . $_SESSION['userNumber'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Anmeldename: </p>
				</td>
				<td>
					<p>' . $_SESSION['nickname'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Name: </p>
				</td>
				<td>
					<p>' . $_SESSION['name'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Vorname: </p>
				</td>
				<td>
					<p>' . $_SESSION['firstname'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Email: </p>
				</td>
				<td>
					<p>' . $_SESSION['email'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Strasse: </p>
				</td>
				<td>
					<p>' . $_SESSION['street'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Ort: </p>
				</td>
				<td>
					<p>' . $_SESSION['city'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
					<p>Postleitzahl: </p>
				</td>
				<td>
					<p>' . $_SESSION['postcode'] . '</p>
				</td>
			</tr>
		</table>
		<a class="shadowLink" href="' . BASE_URL . '?page=setup&amp;action=EditAdress">
			<img src="images/btn_edit.png" title="Daten editieren" alt="edit" />
		</a>';
		
		if($_SESSION['userId'] == user) {
			$contentWeb .= '
		<table width="100%">
			<colgroup>
				<col width="200" />
				<col />
			</colgroup>
			<tr>
				<th colspan="2">Lieferadresse</th>
			</tr>
			<tr>
				<td>
					<p>Strasse: </p>
				</td>
				<td>
					<p>' . $_SESSION['shipping_street'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
				Ort: 
				</td>
				<td>
					<p>' . $_SESSION['shipping_city'] . '</p>
				</td>
			</tr>
			<tr>
				<td>
				Postleitzahl: 
				</td>
				<td>
					<p>' . $_SESSION['shipping_postcode'] . '</p>
				</td>
			</tr>
			</table>
			<a class="shadowLink" href="' . BASE_URL . '?page=setup&amp;action=EditShippingAdress">
				<img src="images/btn_edit.png" title="Daten editieren" alt="edit" />
			</a>';
		}
		$contentWeb .= '
			<table width="100%">
				<colgroup>
					<col width="200" />
					<col />
				</colgroup>				
				<tr>
					<th colspan="2">Passwort</th>
				</tr>
				<tr>
					<td>
						<p>Passwort: </p>
					</td>
					<td>
						<p>********</p>
					</td>
				</tr>
			</table>
			<a class="shadowLink" href="' . BASE_URL . '?page=setup&amp;action=EditPasswort">
				<img src="images/btn_edit.png" title="Daten editieren" alt="edit" />
			</a>';
		echo $contentWeb;
	}
	
	public function paymentOverview() {
		
		try{
			$sql = "SELECT b_name, res_quantity, b_articlenumber, b_price, res_days
					FROM dl_reserve, dl_books
					WHERE res_usernumber = :userNumber
					AND res_articlenumber = b_articlenumber";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			$num = count($tmp);
			$gesamtPreis = 0;
			
			$contentWeb = '<!-- HEADLINE -->
			<div class="headline">
				<h2>1. Bitte prüfen Sie Ihre perönlichen Angaben</h2>
			</div>
			<table width="100%">
				<colgroup>
					<col width="200" />
					<col />
				</colgroup>
				<tr>
					<th colspan="2">Lieferadresse</th>
				</tr>
				<tr>
					<td>
						<p>Name: </p>
					</td>
					<td>
						<p>' . $_SESSION['firstname'] . ' ' . $_SESSION['name'] . '</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Strasse: </p>
					</td>
					<td>
						<p>' . $_SESSION['shipping_street'] . '</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Ort:</p>
					</td>
					<td>
						<p>' . $_SESSION['shipping_city'] . '</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Postleitzahl: </p>
					</td>
					<td>
						<p>' . $_SESSION['shipping_postcode'] . '</p>
					</td>
				</tr>
			</table>
			<a class="shadowLink" href="' . BASE_URL . '?page=setup&amp;action=EditShippingAdress">
				<img src="images/btn_edit.png" title="Daten editieren" alt="edit" />
			</a>
			<div class="headline"><!-- HEADLINE -->
				<h2>2. Bitte prüfen Sie Ihre Artikel</h2>
			</div>';
			
			if ($num > 0) {
				$contentWeb .= '
			<table width="100%">
				<colgroup>
					<col />					
					<col width="65" />
					<col width="75" />
				</colgroup>
				<tr>
					<th>Titel</th>
					<th>Tage</th>
					<th>Preis/ Tag</th>
				</tr>';
				foreach ($tmp as $row) {
					$contentWeb .= '
				<tr>
					<td>
						<p>
							<a href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">' . $row['b_name'] . '</a>
						</p>
					</td>
					<td>
						<p>' . $row['res_days'] . '</p>
					</td>
					<td>
						<p>' . Functions::calculatePrice($row['b_price'], $row['res_days']) . ' €</p>
					</td>
				</tr>';
					$gesamtPreis += Functions::calculatePrice($row['b_price'], $row['res_days']);
					$gesamtPreis = Functions::formatPrice($gesamtPreis, 2,',', '.');
				}
				$contentWeb .= '
			</table>
			<a class="shadowLink" href="' . BASE_URL . '?page=reserveList">
				<img src="images/btn_edit.png" title="Daten editieren" alt="edit" />
			</a>';
			} 
			$contentWeb .= '
			<div class="headline"><!-- HEADLINE -->
				<h2>3. Bitte bestätigen Sie die Bestellung</h2>
			</div>
			<table width="100%">
				<colgroup>
					<col />					
					<col width="140" />
				</colgroup>
				<tr>
					<th>Bezeichnung</th>
					<th>Summe</th>
				</tr>
				<tr>
					<td>
						<p>Summe inkl. MwSt:</p>
					</td>
					<td>
						<p>' . $gesamtPreis . ' €</p>
					</td>
				</tr>
				<tr>
					<td>
						<p>Versand und Verpackung:</p>
					</td>
					<td>
						<p>' . Shipping . ' €</p>
					</td>
				</tr>
				<tr class="strong">
					<td>
						<p>Gesamtbetrag:</p>
					</td>
					<td>
						<p><span class="red">' . (Shipping + $gesamtPreis) . ' €</span></p>
					</td>
				</tr>
			</table>';
			### Paypal Button
			
			$contentWeb .= '
			<a class="shadowLink" href="' . BASE_URL . '?page=order">
				<img src="images/btn_rent.png" title="Jetzt ausleihen" alt="rent" />
			</a>';
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		echo $contentWeb;
	}
	
	private function setArticle($data)
		{
		$this->pdf->SetLeftMargin(30);
		$this->pdf->SetFillColor(237,237,237);
		$this->pdf->Cell(20, 7, "Art-Nr.", 1, 0, 'C',1);
		$this->pdf->Cell(100, 7, "Titel", 1, 0, 'C',1);
		$this->pdf->Cell(30, 7, "Preis/ Tag", 1, 0, 'C',1);
		foreach ($data as $key => $value) {
			$this->pdf->ln();
			$this->pdf->Cell(20, 7, $key, 1, 0, 'C');
			$this->pdf->Cell(100, 7, iconv('UTF-8', 'ISO-8859-15', $value['name']), 1);
			$this->pdf->Cell(30, 7, $value['price'] . " Euro", 1, 0, 'C');
			$this->pdf->ln();
			$this->pdf->Ln(5); 
			$this->pdf->SetFillColor(237,237,237);
			$this->pdf->Cell(150, 7, "Author", 1, 0, 'C', 1);
			$this->pdf->ln();
			$this->pdf->MultiCell(150, 7, iconv('UTF-8', 'ISO-8859-15', $value['author']) , 1, 'L'); 
			$this->pdf->Ln(5); 
			$this->pdf->SetFillColor(237,237,237);
			$this->pdf->Cell(150, 7, "Inhalt", 1, 0, 'C', 1);
			$this->pdf->ln();
			$this->pdf->MultiCell(150, 6, iconv('UTF-8', 'ISO-8859-15', $value['content']), 1, 'L'); 
		}
	}
	  
	public function pdfDetail($articleId)
	{
		$this->pdf->setTitel("Digital Library");
		$this->pdf->AliasNbPages();
		$this->pdf->AddPage();
		$this->pdf->SetFont('Times', '', 12);
		$text = "Sehr geehrter Kunde,\n\nvielen Dank, dass Sie sich" . " für diesen Titel interessieren.\n";
		$this->pdf->setText($text);
		
		try{
			$sql = "SELECT b_articlenumber, b_name, b_price, b_author, b_content
					FROM dl_books
					WHERE b_articlenumber = :articleId";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':articleId', $articleId, PDO::PARAM_INT);
			$result->execute();
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($tmp as $key => $row) {
				foreach ($row as $k => $v) {
					$name = explode("_", $k);
					if ($k != 'b_articlenumber')
						$this->pdfArray[$row['b_articlenumber']][$name[1]] = $v;
				}
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		$this->setArticle($this->pdfArray);
		$text = "\n\nIhre Digital Library.";
		$this->pdf->setText($text);
		$this->pdf->Output();
	}
}
?>