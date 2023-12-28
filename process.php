<?php
// Подключение к базе данных (замените данными вашей базы данных)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы
$contract_number = $_POST['contract_number'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$position = $_POST['position'];

// Вставка данных в базу данных
$sql = "INSERT INTO test1 (contract_number, first_name, last_name, position) VALUES ('$contract_number', '$first_name', '$last_name', '$position')";

if ($conn->query($sql) === TRUE) {
    echo "Информация успешно добавлена в базу данных";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
