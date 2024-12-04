<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Połączenie z bazą danych
    $conn = new mysqli("localhost", "root", "", "salon_samochodowy");

    // Sprawdzenie połączenia
    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Błąd połączenia z bazą danych."]));
    }

    // Pobieranie danych z żądania
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Sprawdzenie, czy email już istnieje
    $checkEmail = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($checkEmail->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Email już istnieje."]);
        $conn->close();
        exit;
    }

    // Wstawianie danych do bazy
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Rejestracja zakończona sukcesem!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Błąd podczas zapisywania danych."]);
    }

    // Zamknięcie połączenia
    $conn->close();
}
?>
