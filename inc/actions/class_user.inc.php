<?php
require("inc/class_session.inc.php");

class User extends Session ### Userverwaltung Actions
{
	public function __construct()
	{
		parent::__construct();
			if (!isset($_SESSION['userNumber']) || !isset($_SESSION['userId'])) {
				$_SESSION['userNumber'] = 0;
				$_SESSION['userId'] = 0;
			}
	}

	public function getUserData()
	{
		if(isset($_POST['login']) || isset($_POST['loginMain'])){
			
			if(!empty($_POST['nickname']) && !empty($_POST['password'])){
				
				$nickname = $_POST['nickname'];
				$password = $_POST['password'];
				
				try {
					$sql = "SELECT u_usernumber, u_userid, u_password, u_name, u_firstname, u_postcode, u_city, u_street, s_postcode, s_city, s_street, u_email, u_userid, u_password
							FROM dl_user
							WHERE u_nickname = :nickname
							AND u_password = :password
							AND u_activatecode IS NULL";
							
					$result = Database::getInstance()->prepare($sql);
					$result->bindParam(':nickname', $_POST['nickname'], PDO::PARAM_STR, 20);
					$result->bindParam(':password', md5($_POST['password']), PDO::PARAM_STR, 32);
					$result->execute();
					$tmp = $result->fetchAll();
					
					if ($result->rowCount() == 1) {
						foreach ($tmp as $row) {
							$_SESSION['userNumber'] =	$row['u_usernumber'];
							$_SESSION['userId'] =	$row['u_userid'];
							$_SESSION['name'] = $row['u_name'];
							$_SESSION['firstname'] = $row['u_firstname'];
							$_SESSION['postcode'] = $row['u_postcode'];
							$_SESSION['city'] = $row['u_city'];
							$_SESSION['street'] = $row['u_street'];
							$_SESSION['shipping_postcode'] = $row['s_postcode'];
							$_SESSION['shipping_city'] = $row['s_city'];
							$_SESSION['shipping_street'] = $row['s_street'];
							$_SESSION['email'] = $row['u_email'];
							$_SESSION['userid'] = $row['u_userid'];
							$_SESSION['userid'] = $row['u_userid'];
							$_SESSION['password'] = $row['u_password'];
							$_SESSION['nickname'] = $nickname;
						}
						return true;
					}
					else return false;
				}
				catch (PDOException $e) {
					echo $e->getMessage();
				}
			}
		}
		else return true;
	}
	
	public function setUserData($data, $userId) ### Register
	{
		if (!is_array($data)) {
			return false;
		}
		
		$activateCode = rtrim(Functions::generatePrefix(), '_');
		
		try {
			$sql = "INSERT INTO dl_user (u_name, u_firstname, u_postcode, u_city, u_street, s_postcode, s_city, s_street, u_email, u_password, u_nickname, u_userid, u_activatecode) 
					VALUES (:name, :firstname, :postcode, :city, :street, :postcode, :city, :street, :email, :password, :nickname, :userid, :activateCode)";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':name', $data['name'], PDO::PARAM_STR, 30);
			$result->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR, 30);
			$result->bindParam(':postcode', $data['postcode'], PDO::PARAM_STR, 6);
			$result->bindParam(':city', $data['city'], PDO::PARAM_STR, 20);
			$result->bindParam(':street', $data['street'], PDO::PARAM_STR, 30);
			$result->bindParam(':email', $data['email'], PDO::PARAM_STR, 30);
			$result->bindParam(':password', md5($data['password']), PDO::PARAM_STR, 32);
			$result->bindParam(':nickname', $data['nickname'], PDO::PARAM_STR, 20);
			$result->bindParam(':userid', $userId, PDO::PARAM_STR, 20);
			$result->bindParam(':activateCode', $activateCode, PDO::PARAM_STR, 16);
			$result->execute();
			
			if ($result->rowCount() == 1) {
				if(Mailer::activateAccount($activateCode, $data['email']) == true){
					return true;
				}
				else return false;
			}
			else {
				return false;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function changeUserData($data, $formType)
	{
		if (!is_array($data)){
			return false;
		}
		
		if($formType == "EditPasswort"){
			try {
				$sql = "UPDATE dl_user 
						SET u_password = :password 
						WHERE u_usernumber = :userNumber";
						
				$result = Database::getInstance()->prepare($sql);
				$result->bindParam(':password', md5($data['password']), PDO::PARAM_STR, 20);
				$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
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
		
		if($formType == "EditAdress"){
			try {
				$sql = "UPDATE dl_user 
						SET u_email = :email, u_nickname = :nickname, u_postcode = :postcode, u_city = :city, u_street = :street 
						WHERE u_usernumber = :userNumber";
						
				$result = Database::getInstance()->prepare($sql);
				$result->bindParam(':email', $data['email'], PDO::PARAM_STR, 30);
				$result->bindParam(':nickname', $data['nickname'], PDO::PARAM_STR, 20);
				$result->bindParam(':postcode', $data['postcode'], PDO::PARAM_STR, 6);
				$result->bindParam(':city', $data['city'], PDO::PARAM_STR, 20);
				$result->bindParam(':street', $data['street'], PDO::PARAM_STR, 30);
				$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
				$result->execute();
				
				if ($result->rowCount() == 1) {
					$_SESSION['email'] = $data['email'];
					$_SESSION['nickname'] = $data['nickname'];
					$_SESSION['postcode'] = $data['postcode'];
					$_SESSION['city'] = $data['city'];
					$_SESSION['street'] = $data['street'];
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
		
		if($formType == "EditShippingAdress"){
			try {
				$sql = "UPDATE dl_user 
						SET s_postcode = :postcode, s_city = :city, s_street = :street 
						WHERE u_usernumber = :userNumber";
						
				$result = Database::getInstance()->prepare($sql);
				$result->bindParam(':postcode', $data['postcode'], PDO::PARAM_STR, 6);
				$result->bindParam(':city', $data['city'], PDO::PARAM_STR, 20);
				$result->bindParam(':street', $data['street'], PDO::PARAM_STR, 30);
				$result->bindParam(':userNumber', $_SESSION['userNumber'], PDO::PARAM_INT);
				$result->execute();
				
				if ($result->rowCount() == 1) {
					$_SESSION['shipping_postcode'] = $data['postcode'];
					$_SESSION['shipping_city'] = $data['city'];
					$_SESSION['shipping_street'] = $data['street'];
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
	}
	
	public function resetPassword($data)
	{
		if (!is_array($data)) {
			return false;
		}
		
		$code = rtrim(Functions::generatePrefix(), '_');
		
		try {
			$sql = "SELECT u_usernumber 
					FROM dl_user 
					WHERE u_email = '" . $data['resetEmail'] . "' 
					AND u_nickname = '" . $data['resetUser'] . "'";
					
			$result = Database::getInstance()->query($sql);
			$tmp = $result->fetchAll(PDO::FETCH_ASSOC);
			
			if (isset($tmp[0]['u_usernumber']) && !empty($tmp[0]['u_usernumber'])){
				$loginData = $tmp[0]['u_usernumber'];
			}
		
			if(!empty($loginData)){
			
				$sql = "UPDATE dl_user 
						SET u_resetcode = :code 
						WHERE u_usernumber = :loginData";
						
				$result = Database::getInstance()->prepare($sql);
				$result->bindParam(':code', $code, PDO::PARAM_STR, 16);
				$result->bindParam(':loginData', $loginData, PDO::PARAM_STR, 30);
				$result->execute();
				
				if ($result->rowCount() == 1) {
					if(Mailer::resetPassword($code, $data['resetEmail']) == true){
						return true;
					}
					else return false;
				}
				else {
					return false;
				}
			}
			else return false;
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function confirmPassword($data, $code)
	{
		if (!is_array($data)) {
			return false;
		}
		
		try {
			$sql = "UPDATE dl_user 
					SET u_password = :password 
					WHERE u_resetcode = :code";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':password', md5($data['password']), PDO::PARAM_STR, 20);
			$result->bindParam(':code', $code, PDO::PARAM_STR, 16);
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
	
	public function clearCode($code)
	{
		try {
			$sql = "UPDATE dl_user 
					SET u_resetcode = NULL 
					WHERE u_resetcode = :code";
	
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':code', $code, PDO::PARAM_STR, 16);
			$result->execute();
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public function clearActivateCode($activateCode)
	{
		try {
			$sql = "UPDATE dl_user 
					SET u_activatecode = NULL 
					WHERE u_activatecode = :activateCode";
	
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':activateCode', $activateCode, PDO::PARAM_STR, 16);
			$result->execute();
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	### Admin Area --------------------------------------------------------------------------------------------------
	
	public static function deleteUser($userNumber) ### User löschen (Admin)
	{
		try {
			$sql = "DELETE 
					FROM dl_user 
					WHERE u_usernumber = :userNumber";
					
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
			$result->execute();
			
			if ($result->rowCount() == 1) {
				$sql = "DELETE 
						FROM dl_rent 
						WHERE r_usernumber = :userNumber";	
				
				$result = Database::getInstance()->prepare($sql);
				$result->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
				$result->execute();
			} 
			else {
				return false;
			}
		}
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	public static function changeRank2Admin($userNumber)
	{
		$admin = admin;
		
		try {
			$sql = "UPDATE dl_user 
					SET u_userid = :admin 
					WHERE u_usernumber = :userNumber";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
			$result->bindParam(':admin', $admin, PDO::PARAM_INT);
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
	
	public static function changeRank2User($userNumber)
	{
		$user = user;

		try {
			$sql = "UPDATE dl_user 
					SET u_userid = :user 
					WHERE u_usernumber = :userNumber";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':userNumber', $userNumber, PDO::PARAM_INT);
			$result->bindParam(':user', $user, PDO::PARAM_INT);
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
	
	public static function deleteRenting($rentingId)
	{
		try {
			$sql = "DELETE 
					FROM dl_rent 
					WHERE r_id = :rentingId";
			
			$result = Database::getInstance()->prepare($sql);
			$result->bindParam(':rentingId', $rentingId, PDO::PARAM_INT);
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
}
?>