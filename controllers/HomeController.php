<?php
class HomeController{

	public function __construct() {

	}

	public function run(){

		# if already logged in
		if (!empty($_SESSION['allowed'])) {
			header('Location: index.php?action='.$_SESSION['allowed'].'');
			die();
		}

		# To notify something
		$notification='';

		if (isset($_POST['form_login'])){

				if(empty($_POST['userMail'])){
					# Did he complete the form ?
						$notification='<div class="alert alert-warning "><strong>Oops ! </strong>You forgot to write something !</div>';
				}
					# Checking the connection of someone and put his mail in a variable
				 elseif (($mailuser = Db::getInstance()->allowed_admin($_POST['userMail'])) !== 'NE') {
						# Admin allowed
						# Create a session allowed
						$_SESSION['allowed'] = 'admin';
						# Save admin
						$user = Db::getInstance()->select_teacher($mailuser);
						$_SESSION['user'] = serialize($user);
						# Redirect
						header("Location: index.php?action=admin");
						die();
				} elseif (($mailuser = Db::getInstance()->allowed_responsible($_POST['userMail'])) !== 'NE') {
						# Save responsible
						$user = Db::getInstance()->select_teacher($mailuser);
						$resp = $user->responsability();
						$_SESSION['user'] = serialize($user);
						# Redirect
						if(preg_match('/^.*bloc1.*$/',$resp)){
							# Responsible allowed
							# Create a session allowed
							$_SESSION['allowed'] = 'block';
							$_SESSION['block'] = 'bloc1';
							header("Location: index.php?action=block");
							die();
						} elseif(preg_match('/^.*bloc2.*$/',$resp)){
							# Responsible allowed
							# Create a session allowed
							$_SESSION['allowed'] = 'block';
							$_SESSION['block'] = 'bloc2';
							header("Location: index.php?action=block");
							die();
						}elseif(preg_match('/^.*bloc3.*$/',$resp)){
							# Responsible allowed
							# Create a session allowed
							$_SESSION['allowed'] = 'block';
							$_SESSION['block'] = 'bloc3';
							header("Location: index.php?action=block");
							die();
						} else{
							# Responsible allowed
							# Create a session allowed
							$_SESSION['allowed'] = 'blocks';
							#bloc1 default
							$_SESSION['block'] = 'bloc1';
							header("Location: index.php?action=blocks");
							die();
						}
				} elseif (($mailuser = Db::getInstance()->allowed_teacher($_POST['userMail'])) !== 'NE') {
						# Teacher allowed
						# Create a session allowed
						$_SESSION['allowed'] = 'teachers';
						# Save teacher
						$user = Db::getInstance()->select_teacher($mailuser);
						$_SESSION['user'] = serialize($user);
						# Redirect
						header("Location: index.php?action=teachers");
						die();
				} elseif (($mailuser = Db::getInstance()->allowed_student($_POST['userMail'])) !== 'NE') {
						# Student allowed
						# Create a session allowed
						$_SESSION['allowed'] = 'students';
						# Save student
						$user = Db::getInstance()->select_student($mailuser);
						$_SESSION['user'] = serialize($user);
						# Redirect
						header("Location: index.php?action=students");
						die();
				} else {
					$notification = '<div class="alert alert-danger"><strong>Wrong ! </strong>This email doesn\'t exist </div>';
				}
		}
		require_once(VIEWS_WAY . 'home.php');
	}

}
?>
