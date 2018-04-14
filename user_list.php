<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Список пользователей</title>
</head>
<body>
<?php
// если роль пользователя не админская выодим сообщение и завершаем скрипт
if (empty($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
	echo 'У вас не хватает прав';
	die;
}
else {
	//соединение с базой
	$base = 'myfirstbd';
	$mysql = @new mysqli('localhost', 'mysql', 'mysql', $base); // подключаемся к базе
	if (mysqli_connect_errno()){die(mysqli_connect_error());}; //проверка на ошибки и закрытие скрипта в случае error
	$sql = "set names 'utf8'"; // задаем кодировку
	$result = $mysql->query($sql); // посылаем запрос в переменой $result на случай ошибки запроса
	if (!$result) die($mysql->error);
	// делаем запрос и обрабатываем ответ
	$sql = " SELECT * FROM `users`";
	$result = $mysql->query($sql); if (!$result) die($mysql->error);
	$data = $result->fetch_all(MYSQLI_ASSOC);

	function drawTable2($data) {
		$result = '';
		$result .= '
		<table border="1" cellpadding="10">
			<tr>
		';
		foreach($data[0] as $key => $val) {
			$result .= '<th>'.$key.'</th>';
		}
		$result .= '
			</tr>
		';
		foreach($data as $k => $row){
			$result .= '<tr>';
			foreach($row as $key => $val) {
				$result .= '<td>'.$val.'</td>';
			}
			$result .= '</tr>';
		}
		$result .= '</table>';
		return $result;
	}
	// отрисовываем данные из базы на страницу
	echo drawTable2($data);
}
?>

</body>
</html>