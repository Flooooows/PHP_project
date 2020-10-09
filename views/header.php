<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Presence</title>

    <!-- Bootstrap -->
    <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
		<meta charset="utf-8" >
		<link rel="stylesheet" type="text/css" href="<?php echo VIEWS_WAY ?>css/form.css" media="all" >
	</head>
	<body>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-lg-offset-9 col-lg-1">
						<?php if(!empty($_SESSION['allowed'])){
							$user = unserialize($_SESSION['user']) ?>

							<form method="POST" action="index.php?action=logout">
								<input type="submit" class="btn btn-info" name="deco" value="<?php echo $user->email() ?> || Deconnexion" >
							</form>
					<?php } ?>
					</div>
				</div>
			</div>
		</header>
