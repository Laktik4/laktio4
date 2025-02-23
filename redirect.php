<?php
$servername = "localhost";
$username = "root"; // или ваш пользователь базы данных
$password = ""; // или ваш пароль
$dbname = "ip_codes";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ip_address = $_SERVER['REMOTE_ADDR']; // Получаем IP-адрес пользователя
$verification_code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6); // Генерируем случайный 6-значный код

// Проверка, был ли код уже получен для этого IP
$sql = "SELECT * FROM users WHERE ip_address = '$ip_address'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Если код уже получен
    echo "Вы уже получили код!";
} else {
    // Если кода нет, добавляем новый
    $sql = "INSERT INTO users (ip_address, verification_code) VALUES ('$ip_address', '$verification_code')";

    if ($conn->query($sql) === TRUE) {
        echo "Ваш код: " . $verification_code;
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
