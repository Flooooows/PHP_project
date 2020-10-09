<?php
class AdminController{

	public function __construct() {

	}

	public function run(){


		# If not logged in
		if (empty($_SESSION['allowed'])) {
			header("Location: index.php?action=home");
			die();
		} # If logged on the wrong page
		elseif ($_SESSION['allowed'] !== 'admin') {
			header('Location: index.php?action='.$_SESSION['allowed'].'');
			die();
		}

		$user = unserialize($_SESSION['user']);

		$email = $user->email();
		$name = $user->name();
		$firstName = $user->firstName();
		$responsability = $user->responsability();

		# ---------------------------------------
		$seeteach = '';
		if (!empty($_GET['see']) && $_GET['see']=='addteachers') {
			$seeteach = 'ok';
		}

		$seeweeks = '';
		if (!empty($_GET['see']) && $_GET['see']=='addweeks') {
			$seeweeks = 'ok';
		}

		# ---------------------------------------
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
		# Insertion of the weeks from a properties file

		$testweeks = Db::getInstance()->select_weeks();
		$notif = '';
		$tabweeks= array();

		if(isset($_POST['form_add_agenda'])){

	 		$content_dir = 'conf/'; // arrival directory

			$tmp_file = $_FILES['agenda']['tmp_name'];

			if( !is_uploaded_file($tmp_file) ) {
				exit($notif = 'File not found');
			}

			// copy to the destination
			$name_file = $_FILES['agenda']['name'];

			if( !move_uploaded_file($tmp_file, $content_dir . $name_file) ){
				exit($notif = 'Impossible to copy');
			}else{ $notif = 'Upload well done';}


			$tabweeks = $this->getallweeks('conf/'.$name_file) ;
			foreach ($tabweeks as $key => $week) {
						if(Db::getInstance()->week_exists($week->id()) === false){
				 				Db::getInstance()->insert_weeks($week->term(),$week->id(),$week->startdate());
						}
			}
		}

		$testweeks = Db::getInstance()->select_weeks();

		# ------------------------------------------
		# Insertion of the teachers from a csv file
		$notifteacher = '';
		$tabteachers = array();

		if(isset($_POST['form_add_csv'])){

	 		$content_dir = 'conf/'; // arrival directory

			$tmp_file = $_FILES['csv']['tmp_name'];

			if( !is_uploaded_file($tmp_file) ) {
				exit($notifteacher = 'File not found');
			}

			// copy to the destination
			$name_file = $_FILES['csv']['name'];

			if( !move_uploaded_file($tmp_file, $content_dir . $name_file) ){
				exit($notifteacher = 'Impossible to copy');
			}else{ $notifteacher = '<p class="alert alert-success">Upload well done</p>';}


			$tabteachers = $this->getallteachers('conf/'.$name_file) ;
			foreach ($tabteachers as $key => $tea) {
					if($key !== 0){
						if(Db::getInstance()->teachers_exists($tea->email()) === false){
							if (preg_match('/^.*false.*$/',$tea->responsability())){
								$res = 'No responsability';
								Db::getInstance()->insert_teacher($tea->email(),$tea->name(),$tea->firstName(),$res);
							} else{
				 				Db::getInstance()->insert_teacher($tea->email(),$tea->name(),$tea->firstName(),$tea->responsability());
							}
						}
					}
			}

		}
		#-------------------------------------------

		require_once(VIEWS_WAY . 'admin.php');
	}

		function getallteachers($csvfile) {
			$table = array();
			if (file_exists ($csvfile)) {
				$fcontents = file($csvfile); # read the file and put all of it in a table
				foreach ($fcontents as $i => $icontent) {
					preg_match('/(.*);(.*);(.*);(.*)/', $icontent, $result);
					$table[$i] = new Teacher($result[1],$result[2],$result[3],$result[4]);
				}
			}
			return $table;
		}

		function getallweeks($agendafile) {
			$table = array();
			if (file_exists ($agendafile)) {
				$fcontents = file($agendafile); # read the file and put all of it in a table
				foreach ($fcontents as $i => $icontent) {
					preg_match('/q([12]{1})_semaine([0-9]{1,2})=([0-9]{1,2}\/[0-9]{2}\/[0-9]{4})/', $icontent, $result);
					$table[$i] = new Week($result[2],$result[3],$result[1]);
				}
			}
			return $table;
		}
}
?>
