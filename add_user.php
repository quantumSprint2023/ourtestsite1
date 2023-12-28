<?php
// add_user.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$position = $_POST['position'];

$sql = "INSERT INTO quantumusers (first_name, last_name, position) VALUES ('$firstName', '$lastName', '$position')";

if ($conn->query($sql) === TRUE) {
    echo "Данные успешно добавлены";

    // Вызываем функцию для загрузки данных пользователя на страницу
    echo "<script>loadUserProfile();</script>";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
