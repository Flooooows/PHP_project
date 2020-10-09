<?php
	ob_start();
	# Start the connection
	session_start();


	# Globals
	define('VIEWS_WAY','views/');
	define('EMAILFLO','florian.timmermans@student.vinci.be');
	define('SESSION_ID',session_id());
	define('TODAY',date("j/m/Y"));

	# Auto-require
	function LoadClass($class) {
		require_once('models/' . $class . '.class.php');
	}
	spl_autoload_register('LoadClass');


	# Header for all pages
	require_once(VIEWS_WAY . 'header.php');

	# What's the page asked in the 'Get' parameter ?
	$action = (isset($_GET['action'])) ? htmlentities($_GET['action']) : 'default';
	# Which action  is being asked ?
	switch($action) {
		case 'students':
			require_once('controllers/StudentsController.php');
			$controller = new StudentsController();
			break;
		case 'teachers':
			require_once('controllers/TeachersController.php');
			$controller = new TeachersController();
			break;
		case 'admin':
			require_once('controllers/AdminController.php');
			$controller = new AdminController();
			break;
		case 'block':
				require_once('controllers/BlockController.php');
				$controller = new BlockController();
				break;
		case 'blocks':
			require_once('controllers/BlocksController.php');
			$controller = new BlockController();
			break;
		case 'series':
			require_once('controllers/SeriesController.php');
			$controller = new SeriesController();
			break;
		case 'sessions':
			require_once('controllers/SessionsController.php');
			$controller = new SessionsController();
			break;
		case 'logout':
			require_once('controllers/LogoutController.php');
			$controller = new LogoutController();
			break;
		default: # Home by default if no parameter
			require_once('controllers/HomeController.php');
			$controller = new HomeController();
			break;
	}
	# Running the controller of the right page
	$controller->run();

	# Footer for all pages
	require_once(VIEWS_WAY . 'footer.php');

	ob_end_flush();
?>
