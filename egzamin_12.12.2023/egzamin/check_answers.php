<?php
$servername = "localhost"; // Nazwa serwera bazy danych
$username = "root"; // Nazwa użytkownika bazy danych
$password = ""; // Hasło użytkownika bazy danych
$database = "egzamin"; // Nazwa bazy danych

// Połączenie z bazą danych
$conn = new mysqli($servername, $username, $password, $database);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
} else {

    // Sprawdzamy, czy formularz został wysłany
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Pobieramy dane z formularza
        $login = $_POST["login"];
        $haslo = $_POST["password"];

        // Sprawdzamy unikalność loginu
        $query_sprawdz = "SELECT * FROM accounts WHERE login = '$login'";
        $result = $conn->query($query_sprawdz);

        if ($result->num_rows > 0) {
            echo "Błąd: login '$login' już istnieje. Proszę wybrać inny login.";
        } else {
            // Używamy zapytania przygotowanego, aby zapobiec atakom SQL injection
            $stmt = $conn->prepare("INSERT INTO accounts (login, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $login, $haslo);

            if ($stmt->execute()) {
                header("Location: main.html");
                exit();
            } else {
                echo "Błąd: " . $stmt->error;
            }

            $stmt->close();
        }

        $result->close();
    }

    // Zamykamy połączenie
    $conn->close();
}
?>