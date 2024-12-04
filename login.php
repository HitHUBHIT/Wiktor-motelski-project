<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Połączenie z bazą danych
    $conn = new mysqli("localhost", "root", "", "salon_samochodowy");

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Błąd połączenia z bazą danych."]));
    }

    // Pobieranie danych z formularza
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Sprawdzanie użytkownika w bazie
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Weryfikacja hasła
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(["success" => true, "message" => "Zalogowano pomyślnie!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Nieprawidłowe hasło."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Nie znaleziono konta z podanym emailem."]);
    }

    // Zamknięcie połączenia
    $conn->close();
}
?>
