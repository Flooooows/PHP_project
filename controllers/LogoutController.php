<?php
class LogoutController{

	public function __construct() {

	}

	public function run(){
		# Clean the Session array
		$_SESSION = array();

		# Completly destroy the session
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(),'', time() - 42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
		}

		session_destroy();

		# Redirect to homepage
		header("Location: index.php");
		die();
	}

}
?>
