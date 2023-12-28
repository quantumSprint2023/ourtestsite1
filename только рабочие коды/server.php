<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение реферального кода для текущего пользователя
// Предполагается, что у вас есть механизм аутентификации пользователя (например, сессии)
// Используйте свои собственные методы для безопасности
$userId = 1; // Замените на реальный идентификатор пользователя
$sql = "SELECT referral_code FROM users WHERE id = $userId";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $referralCode = $row["referral_code"];

    // Возвращаем реферальный код в формате JSON
    echo json_encode(["referralCode" => $referralCode]);
} else {
    // Обработка ошибки, если пользователь не найден
    echo json_encode(["error" => "User not found"]);
}

$conn->close();
?>
