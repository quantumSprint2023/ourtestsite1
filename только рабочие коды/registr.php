<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nickname = $_POST['nickname'];
$email = $_POST['email_reg'];
$password = $_POST['password_reg'];
$referral_code = $_POST['referral_code'];

// Шифруем пароль (рекомендуется использовать более безопасные методы)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Проверка, не зарегистрирован ли уже аккаунт с таким email
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
$user_count = $stmt->num_rows;
$stmt->close();

if ($user_count > 0) {
    // Аккаунт с таким email уже существует
    echo "Этот аккаунт уже зарегистрирован. Войдите в него или зарегистрируйте новый.";
} else {
    // Продолжаем регистрацию без проверки реферального кода
    $sql = "INSERT INTO users (nickname, email, password, referral_code) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $nickname, $email, $hashed_password, $referral_code);
    
    if ($stmt->execute()) {
        // Успешная регистрация
        $user_id = $conn->insert_id; // Получаем ID только что зарегистрированного пользователя

        // Вставляем информацию о пользователе в таблицу user_information
        $sql_info = "INSERT INTO test1 (user_id, first_name, last_name, position) VALUES (?, '', '', '')";
        $stmt_info = $conn->prepare($sql_info);
        $stmt_info->bind_param('i', $user_id);
        $stmt_info->execute();
        
        echo "Регистрация прошла успешно. Теперь вы можете войти.";
        // Перенаправление на main.html
        echo '<script>window.location.href = "obzormain.html";</script>';
    } else {
        echo "Ошибка: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
