<?php
// ==========================================
// Konfiguracja bazy danych
// ==========================================
$db_host = 'localhost'; // Host bazy danych
$db_user = 'root';      // Użytkownik bazy danych
$db_pass = '';          // Hasło bazy danych
$db_name = 'moja_strona'; // Nazwa bazy danych

// ==========================================
// Nawiązanie połączenia z bazą danych przy użyciu PDO
// ==========================================
try {
    // Tworzenie obiektu PDO
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Ustawienie trybu raportowania błędów
} catch (PDOException $e) {
    // Obsługa błędu połączenia
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

// ==========================================
// Dane logowania (przykładowe)
// ==========================================
$login = "admin";  // Login użytkownika
$pass = "haslo123"; // Hasło użytkownika
?>
