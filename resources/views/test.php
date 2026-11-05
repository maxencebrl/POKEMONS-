<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<style>
		* { background: #FF7700;
		}
	</style>
</head>
<body>


<?php

require_once 'model/UserDAO.php';
$daoUser = new UserDAO;
$u = $daoUser->getById(4);


/*
require_once 'model/User.php';

$u = new User(7, 'bob', 'bib', '2026-09-10');
echo $u;

echo '<br><br>';

$u = new User();
echo $u;
*/

?>

<h1>Bonjour <?= $u->getUsername() ?></h1>

</body>
</html>