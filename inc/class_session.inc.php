<?php
require_once("inc/class_site.inc.php");

class Session extends Site
{
	public function __construct() {
		ini_set('session.gc_maxlifetime', TIMEOUT);
		session_start();

		if ((isset($_SESSION['timeout_idle']) && $_SESSION['timeout_idle'] < time()) || isset($_GET['action']) && $_GET['action'] == 'logout') {
			session_destroy();
			session_start();
			session_regenerate_id();
			$_SESSION = array();
		}
		$_SESSION['timeout_idle'] = time() + TIMEOUT;
		
		for($i=1; $i<=3; $i++){
			
			if(isset($_POST["maxEntries_$i"])){
				$_SESSION["maxEntries_$i"] = $_POST["maxEntries_$i"];
			}
			elseif(!isset($_SESSION["maxEntries_$i"])) { 
				$_SESSION["maxEntries_$i"] = 1;
			}
			
			if(isset($_POST["sort_$i"])) { 
				$_SESSION["orderBy_$i"] = $_POST["sort_$i"];
			}
			elseif(!isset($_SESSION["orderBy_$i"])){
				$_SESSION["orderBy_$i"] = 0;
			}
		}
	}
	
	public function setCurrentUrl(){
		$_SESSION['currentUrl'] = '?'. htmlentities($_SERVER['QUERY_STRING']);
	}
	
	public function setRefererUrl(){
		if(!(isset($_GET['action']) && ($_GET['action'] == 'reserveBook' || $_GET['action'] == 'createPdf' || $_GET['action'] == 'EditAdress' || $_GET['action'] == 'EditShippingAdress' || $_GET['action'] == 'EditPasswort') || isset($_GET['articleId']) || $_GET['page'] == 'userDetails'))
		{
			$_SESSION['refererUrl'] = $_SESSION['currentUrl'];
		}
	}
}

?>