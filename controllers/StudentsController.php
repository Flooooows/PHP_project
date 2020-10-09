<?php
class StudentsController{

	public function __construct() {

	}

	public function run(){

		# If not logged in
		if (empty($_SESSION['allowed'])) {
			header("Location: index.php?action=home");
			die();
		} # If logged on the wrong page
		elseif ($_SESSION['allowed'] !== 'students') {
			header('Location: index.php?action='.$_SESSION['allowed'].'');
			die();
		}

				$user = unserialize($_SESSION['user']);
				$email = $user->email();
				$name = $user->name();
				$firstName = $user->firstName();
				$block= $user->block();
		# --------------------------------------------------
		# Tables needed ------------------------------------

		$tablePrecenses =  Db::getInstance()->select_presences($email);
		# --------------------------------------------------
			require_once(VIEWS_WAY . 'students.php');
	}

}
?>
