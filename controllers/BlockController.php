<?php
class BlockController{

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

		$user = unserialize($_SESSION['user']);

		$email = $user->email();
		$name = $user->name();
		$firstName = $user->firstName();
		$responsability = $user->responsability();
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
			} elseif(isset($_POST['goteacher'])){
				header('Location: index.php?action=teachers');
				die();
			}
		#------------------------------------------
		# Adding csv files --------------------------------------------
		$seecourses = '';
		if (!empty($_GET['see']) && $_GET['see'] == 'addcourses') {
			$seecourses = 'ok';
		}
		#------------------------------------------
		# Insertion of the courses from a csv file
		$testCourses = Db::getInstance()->select_courses($_SESSION['block']);
		$tabcourses = array();
		$notifadd = '';
		if(isset($_POST['form_add_courses'])){
	 		$content_dir = 'conf/'; // arrival directory

			$tmp_file = $_FILES['csv']['tmp_name'];

			if( !is_uploaded_file($tmp_file) ) {
				exit("File not found");
			}

			// copy to the destination
			$name_file = $_FILES['csv']['name'];

			if( !move_uploaded_file($tmp_file, $content_dir . $name_file) ){
				exit("Impossible to copy");
			}else{ $notifadd = '<span  class="alert alert-success" >Upload well done</span>';}


			$tabcourses = $this->getallcourses('conf/'.$name_file) ;

			foreach ($tabcourses as $key => $courses) {
				if($key !== 0){
						if(Db::getInstance()->course_exists($courses->code()) === false){
				 				Db::getInstance()->insert_courses($courses->name(),$courses->code(),$courses->term(),$courses->ueAa(),$courses->ects(),$courses->abbreviation());
						}
				}
			}

		}
		require_once(VIEWS_WAY . 'block.php');
	}

	function getallcourses($csvfile) {
		$table = array();
		if (file_exists ($csvfile)) {
			$fcontents = file($csvfile); # read the file and put all of it in a table
			foreach ($fcontents as $i => $icontent) {
				preg_match('/(.*);(.*);(.*);(.*);(.*);(.*)/', $icontent, $result);
				$table[$i] = new Course($result[1],$result[2],$result[3],$result[4],$result[5],$result[6]);

			}
		}
		return $table;
	}

}
?>
