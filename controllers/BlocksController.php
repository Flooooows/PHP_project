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
		elseif ($_SESSION['allowed'] !== 'blocks') {
			header('Location: index.php?action='.$_SESSION['allowed'].'');
			die();
		}

		$user = unserialize($_SESSION['user']);

		$email = $user->email();
		$name = $user->name();
		$firstName = $user->firstName();
		$responsability = $user->responsability();

		# Deleting every data
		$ndelete = '';
		if(isset($_POST['form_delete_all'])){
			Db::getInstance()->delete_precenses();
			Db::getInstance()->delete_precenses_sheets();
			Db::getInstance()->delete_students();
			Db::getInstance()->delete_programs();
			Db::getInstance()->delete_weeks();
			Db::getInstance()->delete_teachers();
			Db::getInstance()->delete_sessions();
			Db::getInstance()->delete_courses();
			Db::getInstance()->delete_series();
			$path = 'conf/';
			$rep=opendir($path);
			while($file = readdir($rep)){
				if($file != '..' && $file !='.' && $file !='' && $file!='.htaccess' && $file!='.htpasswd' && $file!='scripts.sql' && $file!='bdproject.sql'){
					unlink($path.$file);
				}
			}
			$ndelete = '<span  class="alert alert-success" >Delete well done</span>';
		}
		# Adding csv files --------------------------------------------
			$seestud = '';
			if (!empty($_GET['see']) && $_GET['see']=='addstud') {
				$seestud = 'ok';
			}
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
			} elseif(isset($_POST['goteacher'])){
				header('Location: index.php?action=teachers');
				die();
			}
		#------------------------------------------

		# Insertion of the students from a csv file
		$tabstu = array();
		$notifadd = '';
		if(isset($_POST['form_add_students'])){

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


			$tabstu = $this->getallstudents('conf/'.$name_file) ;
			foreach ($tabstu as $key => $stu) {
				if($key !== 0){
					if(Db::getInstance()->student_exists($stu->email()) === false){
				 			Db::getInstance()->insert_student($stu->email(),$stu->name(),$stu->firstName(),$stu->block());
			 		}
			 }
			}

		}
		# --------------------------------------------

		# Managing of series
		$seeseries ='';
		$tableseries = Db::getInstance()->select_series();
		$tableStudents = array();
		$notif1 = '';
		$notif2 = '';
		$notif3 = '';
		if(isset($_POST['form_manage_series'])){
			$seeseries = 'ok';
		}
		if(isset($_POST['hide_series'])){
			$seeseries = '';
		}
		# Adding a serie
		if(isset($_POST['add_serie'])){
			if(empty($_POST['num']) || empty($_POST['block'])){
				$tableseries = Db::getInstance()->select_series();
				$seeseries = 'ok';
				$notif1 = 'Complete the form please';
			}elseif((Db::getInstance()->serie_exists($_POST['num'],$_POST['block'])) === true) {
				$tableseries = Db::getInstance()->select_series();
				$seeseries = 'ok';
				$notif1 = 'Already exists';
			} else{
				Db::getInstance()->insert_serie($_POST['num'],$_POST['block']);
				$tableseries = Db::getInstance()->select_series();
				$seeseries = 'ok';
			}
		}

		# Deleting a serie
		if(isset($_POST['delete_serie'])){
			if(empty($_POST['num']) || empty($_POST['block'])){
				$tableseries = Db::getInstance()->select_series();
				$seeseries = 'ok';
				$notif2 = 'Complete the form please';
			}else{
				Db::getInstance()->delete_serie($_POST['num'],$_POST['block']);
				$tableseries = Db::getInstance()->select_series();
				$seeseries = 'ok';
			}
		}
		# --------------------------------------------
		# Liking students to series

		if(isset($_POST['link_serie'])){
			if(!isset($_POST['serieblock'])){
				$notif3 = 'Choose a line ! ';
				$seeseries = 'ok';
			}else{

				$serienum =  $_POST['serienum'];
				$serieblock = $_POST['serieblock'];
				$tableseries = Db::getInstance()->select_series($serieblock);
				$seeseries = 'ok';
				$tableStudents = Db::getInstance()->select_students($serieblock);
			}
		}

		# --------------------------------------------
		require_once(VIEWS_WAY . 'blocks.php');
	}


	function getallstudents($csvfile) {
		$tableau = array();
		if (file_exists ($csvfile)) {
			$fcontents = file($csvfile); # lire tout le fichier et mettre chaque ligne du fichier dans une case d'un tableau de 0 à ...
			foreach ($fcontents as $i => $icontent) {
				preg_match('/(.*);(.*);(.*);(.*)/', $icontent, $result);
				$tableau[$i] = new Student($result[4],null,$result[2],$result[3],$result[1]);
			}
		}
		return $tableau;
	}
}
?>
