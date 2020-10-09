<?php
class SeriesController{

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

		# Initializing some var
		$tableseries = Db::getInstance()->select_series($_SESSION['block']);
		$tableStudents = Db::getInstance()->select_students($_SESSION['block']);
		$notif1 = '';
		$notif2 = '';
		$notif3 = '';

		#------------------------------------------
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
		#------------------------------------------
		# Adding a serie
		if(isset($_POST['add_serie'])){
			if(empty($_POST['num'])){
				$notif1 = '<span class="alert alert-warning">Complete the num please</span>';
			}elseif(!(preg_match('/^[0-9]{1,2}$/',$_POST['num']))){
				$notif1 = '<span class="alert alert-warning">Enter a correct number</span>';
			}elseif((Db::getInstance()->serie_exists($_POST['num'],$_SESSION['block'])) === true) {
				$notif1 = '<span class="alert alert-warning">Already exists</span>';
			} else{
				Db::getInstance()->insert_serie($_POST['num'],$_SESSION['block']);
				$tableseries = Db::getInstance()->select_series($_SESSION['block']);
			}
		}

		# Deleting a serie
		if(isset($_POST['delete_serie'])){
			if(empty($_POST['num'])){
				$notif2 = '<span class="alert alert-warning">Complete the num please</span>';
			} elseif(!(preg_match('/^[0-9]{1,2}$/',$_POST['num']))){
				$notif2 = '<span class="alert alert-warning">Enter a correct number</span>';
			} elseif((Db::getInstance()->serie_exists($_POST['num'],$_SESSION['block'])) === false) {
				$notif2 = '<span class="alert alert-warning">Doesn\'t exist</span>';
			} else{
				for ($i=0;$i<count($tableStudents);$i++) {
					if($_POST['num'] === $tableStudents[$i]->serieNum()){
						Db::getInstance()->update_students($tableStudents[$i]->email());
						$tableStudents = Db::getInstance()->select_students($_SESSION['block']);
					}
				}
				Db::getInstance()->delete_serie($_POST['num'],$_SESSION['block']);
				$tableseries = Db::getInstance()->select_series($_SESSION['block']);
			}
		}
		# --------------------------------------------
		# Liking students to series

		if(isset($_POST['save_series'])){
			for ($i=0;$i<count($tableStudents);$i++) {
				if(!empty($_POST['line'.$i])){
					Db::getInstance()->update_students($tableStudents[$i]->email(),$_POST['line'.$i]);
				}
			}
			$notif3 = '<span class="alert alert-success">Series saved</span>';
			$tableStudents = Db::getInstance()->select_students($_SESSION['block']);
		}
		# --------------------------------------------
		require_once(VIEWS_WAY . 'series.php');
	}


}
?>
