<?php
class TeachersController{

	public function __construct() {

	}

	public function run(){

		# If not logged in
		if (empty($_SESSION['allowed'])) {
			header("Location: index.php?action=home");
			die();
		} # If logged on the wrong page
		elseif ($_SESSION['allowed'] !== 'teachers' && $_SESSION['allowed'] !== 'block' && $_SESSION['allowed'] !== 'blocks') {
			header('Location: index.php?action='.$_SESSION['allowed'].'');
			die();
		}

		$user = unserialize($_SESSION['user']);

		$email = $user->email();
		$name = $user->name();
		$firstName = $user->firstName();
		$responsability = $user->responsability();

		# Tables needed ---------------------------------------------------
			$tableWeeks  =  Db::getInstance()->select_weeks();
			$tableTeachers = Db::getInstance()->select_teachers();
			$tableSessions = Db::getInstance()->select_sessions();
			$admin =  Db::getInstance()->select_admin()->email();

		# -----------------------------------------------------------------
		# Adding the presences sheets in sql
		$notifPre = '';
		if(isset($_POST['add_presence_sheet'])){
			$session = $_POST['selSessions'];
			$teacher = $_POST['selTeachers'];
			$week = $_POST['selWeeks'];
			Db::getInstance()->insert_presences_sheets($session,$teacher,$week);
			$notifPre = '<span class="alert alert-success">Well added ! </span>';

		}

		# -----------------------------------------------------------------
		require_once(VIEWS_WAY . 'teachers.php');
	}

}
?>
