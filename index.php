<?php
session_start();
// если нет активной сессии то редирект на страницу авторизации login.php
if (empty($_SESSION['user'])) {
	header('Location: login.php');
}
// если есть сессионная перменная то выводим
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Админ панель</title>
</head>
<body>
<ul>
	<li>
		<?=
			'Вы вошли как '.'<b>'.$_SESSION['user']['login'].'</b>';
		?>
	</li>
	<li><a href="logout.php">Выход</a></li>
	<li><a href="user_list.php" >Список пользователей</a></li>
</ul>
</body>
</html>