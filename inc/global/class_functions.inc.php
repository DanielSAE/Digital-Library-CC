<?php
class Functions ### Globale Funktionen
{
	public static function naviBar($total, $datensaetze_pro_seite){
		
		if(isset($_GET['categorie'])){
			$page = '?page=' . $_GET['page'] . '&amp;categorie=' . $_GET['categorie'];
		} 
		elseif(isset($_GET['search'])){
			$page = '?page=' . $_GET['page'] . '&amp;search=' . $_GET['search'];
		}
		else $page = '?page=' . $_GET['page'];
		
		$seiten = ceil($total / $datensaetze_pro_seite);     ### Berechnet die Seitenanzahl insgesamt

		if(empty($_GET['site'])){ ### korrigieren der aktuellen Seite
			$site = 1;             ### Sofern $site nicht uebergeben wurde
		}
		elseif($_GET['site'] <= 0 || $_GET['site'] > $seiten){
			$site = 1;         ### Variable definieren
		}
		else{ ### Wenn Obiges nicht zutraf
			$site = $_GET['site'];     ### Variable definieren
		}
		
		$links = array(); ### Linkkette bilden
		### Seite die vor der aktuellen Seite kommt definieren
		if(($site - NAV_BAR) < 1){ 
			$davor = $site - 1;  
		}
		else{ 
			$davor = NAV_BAR; 
		}           
		### Seite die nach der aktuellen Seite kommt definieren
		if(($site + NAV_BAR) > $seiten){
			$danach = $seiten - $site; 
		}
		else{
			$danach = NAV_BAR; 
		}  
		$off = ($site - $davor); ### Variable definieren  
 
		if ($site- $davor > 1){ ### Link definieren => Zur Erste Seite springen        
			$first = 1;
		$links[] = '
				<a href="' . BASE_URL . $page . '&amp;site=' . $first . '" title="Zur ersten Seite springen">&laquo; Erste ...</a>';     	
		}     
		if($site != 1){ ### Link definieren => eine Seite zurueck blaettern         
			$prev = $site-1;
		$links[] = '
				<a href="' . BASE_URL . $page . '&amp;site=' . $prev . '" title="Eine Seite zurueck blaettern"> &laquo;</a>';    
		}  
		for($i = $off; $i <= ($site + $danach); $i++){ ### einzelne Seitenlinks erzeugen

			if ($i != $site){  ### Link definieren           
				$links[] = '
				<a href="' . BASE_URL . $page . '&amp;site=' . $i . '">' . $i . '</a>';
			}
			elseif($i == $seiten) { ### aktuelle Seite, ein Link ist nicht erforderlich            
				$links[] = '
				<span class="current">[ ' . $i . ' ]</span>'; 
			}
			elseif($i == $site){ ### aktuelle Seite, ein Link ist nicht erforderlich            
				$links[] = '
				<span class="current">[ ' . $i . ' ]</span>';
			} ### close if $i     
		}               

		if($site != $seiten){ ### Link definieren => eine Seite weiter blaettern      
			$next = $site+1;
			$links[] = '
				<a href="' . BASE_URL . $page . '&amp;site=' . $next . '" title="Eine Seite weiter blaettern"> &raquo; </a>';
		}     
		
		if($seiten - $site - NAV_BAR > 0 ){ ### Link definieren => Zur letzen Seite springen  
			$last = $seiten;
			$links[] = '
				<a href="' . BASE_URL . $page . '&amp;site=' . $last . '" title="Zur letzten Seite springen">... Letzte &raquo;</a>';
		}     
		
		$arrNavi['start'] = $start = ($site-1) * $datensaetze_pro_seite; ### Berechne den Startwert fuer die DB
		$arrNavi['link_string'] = $link_string = implode(" ", $links); ### Zusammenfuegen der einzelnen Links zu einem String
		$arrNavi['seiten'] = $seiten;
		$arrNavi['site'] = $site;
		return $arrNavi;
	}
	
	public static function productStatus($quantity) { ### Lagerampel
	
		$status_pic =  '<img src="images/lager_';
		
		if($quantity >= Status_1) {
			$status_pic .=  '1';
		}
		elseif($quantity >= Status_2) {
			$status_pic .=  '2';
		}
		elseif($quantity >= Status_3) {
			$status_pic .=  '3';
		}
		elseif($quantity > Status_4) {
			$status_pic .=  '4';
		}
	$status_pic .=  '.gif" alt ="status" />';
	return $status_pic;
	}
	
	public static function userRank($userid) { ### Lagerampel
	
		if($userid == 1) {
			$userRank = 'Admin';
		}
		elseif($userid == 2) {
			$userRank = 'Benutzer';
		}
	return $userRank;
	}
	
	public  static function order($orderBy) { ### Sortierung
	
		if (($orderBy == 0) || ($orderBy == 1)) {
			$select = " ORDER BY b_name asc ";
			return $select;
		}
		
		if ($orderBy == 2) {
			$select = " ORDER BY b_releasedate desc ";
			return $select;
		}
		
		if ($orderBy == 3) {
			$select = " ORDER BY b_price asc ";
			return $select;
		}
	}
	
	public  static function order2($orderBy) { ### Sortierung
	
		if (($orderBy == 0) || ($orderBy == 1)) {
			$select = " ORDER BY u_usernumber asc ";
			return $select;
		}
		
		if ($orderBy == 2) {
			$select = " ORDER BY u_nickname asc ";
			return $select;
		}
		
		if ($orderBy == 3) {
			$select = " ORDER BY u_registerdate desc ";
			return $select;
		}
	}
	
	public  static function order3($orderBy) { ### Sortierung
	
		if (($orderBy == 0) || ($orderBy == 1)) {
			$select = " ORDER BY r_days-r_timediff desc";
			return $select;
		}
		
		if ($orderBy == 2) {
			$select = " ORDER BY r_days-r_timediff asc";
			return $select;
		}
		
		if ($orderBy == 3) {
			$select = " ORDER BY u_usernumber asc";
			return $select;
		}
		
		if ($orderBy == 4) {
			$select = " ORDER BY u_nickname asc";
			return $select;
		}
	}
	
	public static function dropDown($arrOrderBy, $orderBy) {
			
		foreach($arrOrderBy as $k => $v){
			$contentWeb = '<option value=" ' . $k . ' "';
			if($k == $orderBy){
				$contentWeb .= ' selected="selected"';
			}
			$contentWeb .= '> ' . $v . '</option>
			';
			return $contentWeb;
		}
	}
	
	public static function date_german2mysql($datum) { ### Datum in MYSQL Format schreiben
	
		list($tag, $monat, $jahr) = explode(".", $datum);
		return sprintf("%04d-%02d-%02d", $jahr, $monat, $tag);
	}
	
	public static function date_mysql2german($datum) { ### Datum in Deutsches Format schreiben
	
		list($jahr, $monat, $tag) = explode("-", $datum); 
		return sprintf("%02d.%02d.%04d", $tag, $monat, $jahr);
	}
	
	public static function checkDate($date) {

		$parts = explode('.',$date); ### Zerlegen an den Punkten
		
		if(!checkdate($parts[1],$parts[0],$parts[2])) return false;
		else return true;
	} 
		
	public static function calculatePrice($price, $quantity) { ### Preis berechnen
		
		$total = $price * $quantity;
		$totalPrice = number_format($total, 2,".", ",");
		return $totalPrice;
	} 
		
	public static function formatPrice($price) { ### Preis formatieren
		
		$price = number_format($price, 2,".", ",");
		return $price;
	} 
	
	public static function navigation($naviList, $page) { ### Dynamische Navi
		
		$contentWeb = '';
		foreach($naviList as $k => $v){
			$contentWeb .= 
			'<li><a href= "' . BASE_URL . '?'. $k;
			if($k == $page){
				$contentWeb .= '" class="active"';
				$contentWeb .= '>' . $v . '</a> ';
			}
			else {
				$contentWeb .= '">' . $v . '</a>';
			}
			$contentWeb .= '</li>
			';
		}
		return $contentWeb;
	}
	
	public static function errorMessaging($arrStatus) { ### Dynamische Fehlerausgabe
	
		if($arrStatus != 0) {
			$contentWeb = '<ul class="error">';
			foreach($arrStatus as $s){
				$contentWeb .= '<li>' . $s . '</li>';
			}
			$contentWeb .= '</ul>';
			return $contentWeb;
		}
	}
	
	public static function generatePrefix(){
		$ts = microtime();			### zufällige Größe, damit zufälliger Hash
		
		$_prefix = md5($ts);		### 32 Zeichen
		$_prefix = substr($_prefix, 0, 16);	### 16 Zeichen vom Anfang extrahieren
		$_prefix = str_shuffle($_prefix);	### geschüttelt, nicht gerührt
		
		$prefix = $_prefix.'_';
		
		return $prefix;
	}
	
	// erzeugt ein Thumbnail
	public static function createThumbnail($pic, $thumbdir, $thumbname, $targetFigure, $quality, $target = 'height'){
		// $targetFigure ist entweder die Zielhöhe oder die Zielbreite
		// je nachdem, was beim Funktionsaufruf übergeben wird
		// wenn eine Breitenberechnung ansteht, dann muss auch $target = 'width'
		
		$size = getimagesize($pic);
		
		if($target == 'height'){
		
			// Größe berechnen
			// kein resize, wenn die aktuelle Bildhöhe weniger als die neue Bildhöhe beträgt
			if($size[0] < $targetFigure){
				$width = $size[0];
				$height = $size[1];
			}
			// Bild nach Höhe anpassen
			else{
				$height = $targetFigure*$size[1]/$size[0];
				$width = $targetFigure;
			}
		}
		else{
			// Größe berechnen
			// kein resize, wenn die aktuelle Bildbreite weniger als die neue Bildbreite beträgt
			if($size[1] < $targetFigure){
				$width = $size[0];
				$height = $size[1];
			}
			// Bild nach Höhe anpassen
			else{
				$width = $targetFigure*$size[0]/$size[1];
				$height = $targetFigure;
			}
		}

		// Typ ermitteln
		if($size[2]==1) {
			// Originalbild laden als Datenstrom
			$original=imagecreatefromgif($pic);
			// leeres Thumbnail erstellen als Datenstrom
			$thumbnail=imagecreatetruecolor($width,$height);
			// Originalbild in das Thumbnail mit angepasster Größe kopieren
			// imagecopyresampled ist qualitativ viel besser als imagecopyresized, aber auch speicherintensiver
			// Empfehlung: möglichst imagecopyresampled
			imagecopyresampled($thumbnail,$original,0,0,0,0,$width,$height,$size[0],$size[1]);
			// Bild im Ziel-Ordner speichern
			imagegif($thumbnail,$thumbdir.$thumbname);
		}
		elseif($size[2]==2) {
			$original=imagecreatefromjpeg($pic);		
			$thumbnail=imagecreatetruecolor($width,$height);
			imagecopyresampled($thumbnail,$original,0,0,0,0,$width,$height,$size[0],$size[1]);
			imagejpeg($thumbnail, $thumbdir.$thumbname, $quality);
		}
		elseif($size[2]==3) {
			$original=imagecreatefrompng($pic);
			$thumbnail=imagecreatetruecolor($width,$height);
			imagecopyresampled($thumbnail,$original,0,0,0,0,$width,$height,$size[0],$size[1]);
			imagepng($thumbnail, $thumbdir.$thumbname);
		}
		else{
			return false;
		}
		return true;
	}
	
	public static function bookListTable($tmp, $arrMaxEntries, $arrOrderBy, $arrNavi, $page = 'search'){
		
		$link_string = $arrNavi['link_string'];
		$seiten = $arrNavi['seiten'];
		$site = $arrNavi['site'];
		
		$contentWeb = '';
		
		if($page == 'allBooks' || $page == 'search' || (isset($_GET['categorie']) && $_GET['categorie'] != 'Charts')){ ### Sortierung Dropdown
			$contentWeb .= 
				'<form class="dropdownBig" action="' . BASE_URL . $_SESSION['currentUrl'] . '" method="post">
					<fieldset>
						<label for="sort_1">Sortierung nach:</label>
						<select id="sort_1" name="sort_1" size="1" onchange="this.form.submit()">';
				foreach($arrOrderBy as $k => $v){
					$contentWeb .= '	<option value="' . $k . '"';
					if($k == $_SESSION['orderBy_1']){
						$contentWeb .= ' selected="selected"';
					}
					$contentWeb .= '>' . $v . '</option>';
				}
				$contentWeb .= '
						</select>
					</fieldset>
				</form>
				';
		}
		$contentWeb .= '
		<form class="dropdownSmall" action="' . BASE_URL . $_SESSION['currentUrl'] . '" method="post">
			<fieldset>
				<label for="maxEntries_1">Anzahl#:</label>
				<select id="maxEntries_1" name="maxEntries_1" size="1" onchange="this.form.submit()">';
		
		foreach($arrMaxEntries as $k => $v){
			$contentWeb .= 
				'	<option value="' . $k . '"';
			if($k == $_SESSION['maxEntries_1']){
				$contentWeb .= ' selected="selected"';
			}
			$contentWeb .= '>' . $v . 
				'	</option>';
		}
		
		$contentWeb .= '
				</select>
			</fieldset>
		</form>
		<div class="clear"></div>
		<table border="0">
			<colgroup>
				<col width="51" />
				<col />
				<col width="65" />
				<col width="75" />
				<col width="100" />
				<col width="50" />
				<col width="50" />
			</colgroup>
			<tr>
				<th></th>
				<th>Titel</th>
				<th>Status</th>
				<th>Preis/ Tag</th>
				<th>Genre</th>
				<th>Details</th>
				<th>Tage</th>
			</tr>';
			
		foreach ($tmp as $row) {
			$contentWeb .= '
			<tr>
				<td>
					<a class="opacityLink" href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">
						<img src="' . THUMB_DIR . 'thumb_' . $row['b_articlenumber'] . '.jpg" alt="' . $row['b_name'] . '" height="75" width="50" />
					</a>
				</td>
				<td>
					<p><a href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">' . $row['b_name'] . '</a></p>
				</td>';
			if(($_SESSION['userId'] != admin)) {
				$contentWeb .= '
				<td>
					<p>' . Functions::productStatus($row['b_quantity']) . '</p>
				</td>
				<td>
					<p>' . $row['b_price'] . ' €' . '</p>
				</td>
				<td>
					<p>' . $row['b_genre'] . '</p>
				</td>
				<td>
					<p>
						<a class="opacityLink" href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">
							<img src="images/btn_details.png" title="Datensatz einsehen" alt="Datensatz einsehen" />
						</a>
					</p>
				</td>
				<td>
					<p>
						<a class="opacityLink" href="' . BASE_URL . $_SESSION['currentUrl'] . '&amp;action=reserveBook&amp;articleId=' . $row['b_articlenumber'] . '">
							<img src="images/btn_day_plus.png" title="+1" alt="+1" />
						</a>
					</p>
				</td>';
			}
			else{
				$contentWeb .= '
				<td>
					<p>' . $row['b_quantity'] . '</p>
				</td>
				<td>
					<p>' . $row['b_price'] . ' €' . '</p>
				</td>
				<td>
					<p>' . $row['b_genre'] . '</p>
				</td>
				<td>
					<p>
						<a href="' . BASE_URL . '?page=details&amp;articleId=' . $row['b_articlenumber'] . '">
							<img src="images/btn_details.png" title="Datensatz einsehen" alt="Datensatz einsehen" />
						</a>
					</p>
				</td>
				<td>
					<p>
						<a href="' . BASE_URL . $_SESSION['currentUrl'] . '&amp;action=deleteBook&amp;articleId=' . $row['b_articlenumber'] . '">
							<img src="images/btn_delete.png" title="Datensatz l&ouml;schen" alt="Datensatz l&ouml;schen" />
						</a>
					</p>
				</td>';
			}
			$contentWeb .= '
			</tr>';
		}
		$contentWeb .= '
		</table>
		<div class="center"> 
			<p>Seite ' . $site . ' von ' . $seiten . '</p>
 			<p>
				' . $link_string . '
			</p>
		</div>';
		return $contentWeb;
	}
	
	public static function userListTable($tmp, $arrMaxEntries, $arrOrderBy, $arrNavi, $page = 'search'){
		
		$link_string = $arrNavi['link_string'];
		$seiten = $arrNavi['seiten'];
		$site = $arrNavi['site'];
		
		$contentWeb = '';
		
		$contentWeb .= 
			'<form class="dropdownBig" action="' . BASE_URL . $_SESSION['currentUrl'] . '" method="post">
				<fieldset>
					<label for="sort_2">Sortierung nach:</label>
					<select id="sort_2" name="sort_2" size="1" onchange="this.form.submit()">';
			foreach($arrOrderBy as $k => $v){
				$contentWeb .= '	<option value="' . $k . '"';
				if($k == $_SESSION['orderBy_2']){
					$contentWeb .= ' selected="selected"';
				}
				$contentWeb .= '>' . $v . '</option>';
			}
			$contentWeb .= '
					</select>
				</fieldset>
			</form>
			';

$contentWeb .= '
		<form class="dropdownSmall" action="' . BASE_URL . $_SESSION['currentUrl'] . '" method="post">
			<fieldset>
				<label for="maxEntries_2">Anzahl#:</label>
				<select id="maxEntries_2" name="maxEntries_2" size="1" onchange="this.form.submit()">';
		
		foreach($arrMaxEntries as $k => $v){
			$contentWeb .= 
				'	<option value="' . $k . '"';
			if($k == $_SESSION['maxEntries_2']){
				$contentWeb .= ' selected="selected"';
			}
			$contentWeb .= '>' . $v . 
				'	</option>';
		}
		
		$contentWeb .= '
				</select>
			</fieldset>
		</form>
		<div class="clear"></div>
		<table border="0">
			<colgroup>
				<col width="40" />
				<col />
				<col width="80" />
				<col width="80" />
				<col width="45" />
				<col width="45" />
			</colgroup>
			<tr>
				<th>User-Nr.</th>
				<th>User-Name</th>
				<th>User-Rang</th>
				<th>Aktiv seit</th>
				<th>Details</th>
				<th>Löschen</th>
			</tr>';
		foreach ($tmp as $row) {
			$contentWeb .= '
			<tr>
				<td>
					<p>' . $row['u_usernumber'] . '</p>
				</td>
				<td>
					<p>
						<a href="' . BASE_URL . '?page=userDetails&amp;userNumber=' . $row['u_usernumber'] . '">' . $row['u_nickname'] . '</a>
					</p>
				</td>
				<td>
					<p>' . Functions::userRank($row['u_userid']) . '</p>
				</td>
				<td>
					<p>' . self::date_mysql2german($row['u_registerdate']) . '</p>
				</td>
				<td>
					<p>
						<a href="' . BASE_URL . '?page=userDetails&amp;userNumber=' . $row['u_usernumber'] . '">
							<img src="images/btn_details.png" title="Datensatz einsehen" alt="Datensatz einsehen" />
						</a>
					</p>
				</td>
				<td>
					<p>
						<a href="' . BASE_URL . $_SESSION['currentUrl'] . '&amp;action=deleteUser&amp;userNumber=' . $row['u_usernumber'] . '">
							<img src="images/btn_delete.png" title="Datensatz l&ouml;schen" alt="Datensatz l&ouml;schen" />
						</a>
					</p>
				</td>
			</tr>';
		}
		$contentWeb .= '
		</table>
		<div class="center"> 
			<p>Seite ' . $site . ' von ' . $seiten . '</p>
 			<p>
				' . $link_string . '
			</p>
		</div>';
		return $contentWeb;
	}
	
	public static function rentListTable($tmp, $arrMaxEntries, $arrOrderBy, $arrNavi, $page = 'search'){
		
		$link_string = $arrNavi['link_string'];
		$seiten = $arrNavi['seiten'];
		$site = $arrNavi['site'];
		
		$contentWeb = 
			'<form class="dropdownBig" action="' . BASE_URL . $_SESSION['currentUrl'] . '" method="post">
				<fieldset>
					<label for="sort_3">Sortierung nach:</label>
					<select id="sort_3" name="sort_3" size="1" onchange="this.form.submit()">';
			foreach($arrOrderBy as $k => $v){
				$contentWeb .= '	<option value="' . $k . '"';
				if($k == $_SESSION['orderBy_3']){
					$contentWeb .= ' selected="selected"';
				}
				$contentWeb .= '>' . $v . '</option>';
			}
			$contentWeb .= '
					</select>
				</fieldset>
			</form>
			';

		$contentWeb .= '
		<form class="dropdownSmall" action="' . BASE_URL . $_SESSION['currentUrl'] . '" method="post">
			<fieldset>
				<label for="maxEntries_3">Anzahl#:</label>
				<select id="maxEntries_3" name="maxEntries_3" size="1" onchange="this.form.submit()">';
		
		foreach($arrMaxEntries as $k => $v){
			$contentWeb .= 
				'	<option value="' . $k . '"';
			if($k == $_SESSION['maxEntries_3']){
				$contentWeb .= ' selected="selected"';
			}
			$contentWeb .= '>' . $v . 
				'	</option>';
		}
		
		$contentWeb .= '
				</select>
			</fieldset>
		</form>
		<div class="clear"></div>
		<table border="0">
			<colgroup>
				<col width="130" />
				<col/>
				<col width="130" />
				<col width="75" />
				<col width="110" />
				<col width="45" />
				<col width="45" />
			</colgroup>	
			<tr>
				<th>User-Name</th>
				<th>Titel</th>
				<th>Verbleibende Tage</th>
				<th>Ausleihdauer</th>
				<th>Ausleihdatum</th>
				<th>Details</th>
				<th>Löschen</th>
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
							<a href="' . BASE_URL . '?page=userDetails&amp;userNumber=' . $row['u_usernumber'] . '">' . $row['u_nickname'] . '</a>
						</p>
					</td>
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
					<td>
						<p>
							<a href="' . BASE_URL . '?page=userDetails&amp;userNumber=' . $row['u_usernumber'] . '">
								<img src="images/btn_details.png" title="Datensatz einsehen" alt="Datensatz einsehen" />
							</a>
						</p>
					</td>
					<td>
						<p>
							<a href="' . BASE_URL . $_SESSION['currentUrl'] . '&amp;action=deleteRenting&amp;rentingId=' . $row['r_id'] . '">
								<img src="images/btn_delete.png" title="Datensatz l&ouml;schen" alt="Datensatz l&ouml;schen" />
							</a>
						</p>
					</td>
				</tr>';
			}
			$contentWeb .= '
		</table>
		<div class="center"> 
			<p>Seite ' . $site . ' von ' . $seiten . '</p>
 			<p>
				' . $link_string . '
			</p>
		</div>';
		return $contentWeb;
	}
}
?>