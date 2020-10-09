<?php
class SessionsController{

	public function __construct() {

	}

	public function run(){

	# If not logged in
		if (empty($_SESSION['allowed'])) {
			header("Location: index.php?action=home");
			die();
		} # If logged on the wrong page
		elseif ($_SESSION['allowed'] !== 'block' && $_SESSION['allowed'] !== 'blocks') {
			header('Location: index.php?action='.$_SESSION['allowed'].'');
			die();
		}

		# Putting current user infos into vars
		$user = unserialize($_SESSION['user']);

		$email = $user->email();
		$name = $user->name();
		$firstName = $user->firstName();
		$responsability = $user->responsability();

		# ----------------------------------------------
		# Choosing a block
			if(isset($_POST['block1'])){
				$_SESSION['block'] = 'bloc1';
				header('Location: index.php?action=block');
				die();
			} elseif(isset($_POST['block2'])){
				$_SESSION['block'] = 'bloc2';
				header('Location: index.php?action=block');
				die();
			} elseif(isset($_POST['block3'])){
				$_SESSION['block'] = 'bloc3';
				header('Location: index.php?action=block');
				die();
			} elseif(isset($_POST['blocks'])){
				header('Location: index.php?action=blocks');
				die();
			}
		# ----------------------------------------------
		# Initializing some var
		$tableSeries = Db::getInstance()->select_series($_SESSION['block']);
		$tableStudents = Db::getInstance()->select_students($_SESSION['block']);
		$tableCourses = Db::getInstance()->select_courses($_SESSION['block']);
		$notif1 = '';
		# ----------------------------------------------
		# Managing sessions
		if(isset($_POST['add_session'])){
			if(!isset($_POST['serie'])){
				$notif1 = '<span class="alert alert-warning">Choose one or more series ! </span>';
			} elseif(empty($_POST['sessionName'])){
				$notif1 = '<span class="alert alert-warning">Enter a name for the session ! </span>';
			} else{
				$name = htmlspecialchars($_POST['sessionName']);
				$code = $_POST['selCourses'];
				$type = $_POST['selType'];
				$series = array();
				foreach($_POST['serie'] as $serie){
					$series[] = $serie;
				}
				$num1 = rand(1, 500);
				$num2 = rand(501,999);
				$id = $num1.$num2;
			 	Db::getInstance()->insert_sessions($id,$code,$name,$type);
				for ($i=0;$i<count($series);$i++) {
				 	Db::getInstance()->insert_programs($series[$i],$id);
				}
				$notif1 = '<span class="alert alert-success">Session added ! </span>';
			}
		}
		# ----------------------------------------------
		require_once(VIEWS_WAY . 'sessions.php');
	}

}
?>
