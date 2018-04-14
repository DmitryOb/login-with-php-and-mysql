<?php
session_start();

// если есть авторизированная сессия то переходим на index.php
if (!empty($_SESSION['user'])) {
	header('Location: index.php');
}

// если есть данные из POST
if (!empty($_POST['login']) && !empty($_POST['password'])) {

	//соединяемся с базой
	$base = 'myfirstbd';
	$mysql = @new mysqli('localhost', 'mysql', 'mysql', $base); // подключаемся к базе
	if (mysqli_connect_errno()){die(mysqli_connect_error());}; //проверка на ошибки и закрытие скрипта в случае error
	$sql = "set names 'utf8'"; // задаем кодировку
	$result = $mysql->query($sql); // посылаем запрос в переменой $result на случай ошибки запроса
	if (!$result) die($mysql->error);

	// делаем запрос и обрабатываем ответ
	$mylogin = $_POST['login'];
	$mypass = $_POST['password'];
	$sql = " SELECT * FROM `users` WHERE login='$mylogin' AND pass='$mypass' ";
	$result = $mysql->query($sql); if (!$result) die($mysql->error); // отправляет запрос
	$data = $result->fetch_all(MYSQLI_ASSOC); // получает ответ на запрос

	// если данные из инпутов верные
	if (!empty($data)) {
		// создаем сессионную перменную со строкой из таблицы mysql
		$_SESSION['user'] = $data[0];
		// редирект в index.php и остановка скрипта
		header('Location: index.php');
		die;
	}
	$errors = 'Неверный логин или пароль';
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Вход</title>
</head>
<body>

<?php if (!empty($errors)) echo $errors ?>

<form method="POST">
	<div>
		<label for="login">Логин</label>
		<input id="login" name="login">
	</div>
	<div>
		<label for="password">Пароль</label>
		<input id="password" name="password">
	</div>
	<div>
		<button type="submit">Вход</button>
	</div>
</form>
</body>
</html>