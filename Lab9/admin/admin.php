<?php
session_start();

/**
 * Funkcja wyświetlająca formularz logowania.
 */
function FormularzLogowania() {
    echo '<form method="post">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required><br>
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required><br>
            <button type="submit" name="zaloguj">Zaloguj</button>
        </form>';
}

// Obsługa logowania
if (isset($_POST['zaloguj'])) {
    include '../cfg.php'; // Pobranie konfiguracji logowania

    // Weryfikacja danych logowania
    if ($_POST['login'] === $login && $_POST['password'] === $pass) {
        $_SESSION['zalogowany'] = true;
    } else {
        echo 'Błędne dane logowania.<br>';
        FormularzLogowania();
        exit;
    }
}

// Jeśli użytkownik nie jest zalogowany, wyświetl formularz logowania i zakończ
if (!isset($_SESSION['zalogowany'])) {
    FormularzLogowania();
    exit;
}

/**
 * Funkcja wyświetlająca listę podstron.
 */
function ListaPodstron() {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $sql = "SELECT id, page_title FROM page_list";
    $result = $conn->query($sql);

    echo '<table>';
    echo '<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['id']) . '</td>
                <td>' . htmlspecialchars($row['page_title']) . '</td>
                <td>
                    <a href="admin.php?edytuj=' . $row['id'] . '">Edytuj</a> |
                    <a href="admin.php?usun=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć tę podstronę?\')">Usuń</a>
                </td>
              </tr>';
    }
    echo '</table>';

    $conn->close();
}

/**
 * Funkcja do edytowania podstrony.
 */
function EdytujPodstrone($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obsługa zapisania zmian
        $tytul = $conn->real_escape_string($_POST['tytul']);
        $tresc = $conn->real_escape_string($_POST['tresc']);
        $aktywny = isset($_POST['aktywny']) ? 1 : 0;

        $sql = "UPDATE page_list SET page_title='$tytul', page_content='$tresc', status=$aktywny WHERE id=$id LIMIT 1";
        $conn->query($sql);
        echo "Podstrona zaktualizowana. </br> <a href=admin.php>Powrót</a>";
    } else {
        // Formularz edycji podstrony
        $sql = "SELECT * FROM page_list WHERE id=$id LIMIT 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        echo '<form method="post">
                <label>Tytuł:</label>
                <input type="text" name="tytul" value="' . htmlspecialchars($row['page_title']) . '" required><br>
                <label>Treść:</label>
                <textarea name="tresc">' . htmlspecialchars($row['page_content']) . '</textarea><br>
                <label>Aktywny:</label>
                <input type="checkbox" name="aktywny" ' . ($row['status'] ? 'checked' : '') . '><br>
                <button type="submit">Zapisz</button>
            </form>';
    }

    $conn->close();
}

/**
 * Funkcja do dodania nowej podstrony.
 */
function DodajNowaPodstrone() {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tytul = $conn->real_escape_string($_POST['tytul']);
        $tresc = $conn->real_escape_string($_POST['tresc']);
        $aktywny = isset($_POST['aktywny']) ? 1 : 0;

        $sql = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$tytul', '$tresc', $aktywny)";
        $conn->query($sql);
        echo "Podstrona dodana. </br> <a href=admin.php>Powrót</a>";
    } else {
        // Formularz dodawania podstrony
        echo '<form method="post">
                <label>Tytuł:</label>
                <input type="text" name="tytul" required><br>
                <label>Treść:</label>
                <textarea name="tresc"></textarea><br>
                <label>Aktywny:</label>
                <input type="checkbox" name="aktywny"><br>
                <button type="submit">Dodaj</button>
            </form>';
    }

    $conn->close();
}

/**
 * Funkcja do usuwania podstrony.
 */
function UsunPodstrone($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    $sql = "DELETE FROM page_list WHERE id=$id LIMIT 1";
    $conn->query($sql);

    echo "Podstrona usunięta. </br> <a href=admin.php>Powrót</a>";
    $conn->close();
}

// Główna logika obsługi panelu
if (isset($_GET['lista'])) {
    ListaPodstron();
} elseif (isset($_GET['dodaj'])) {
    DodajNowaPodstrone();
} elseif (isset($_GET['edytuj'])) {
    EdytujPodstrone((int)$_GET['edytuj']);
} elseif (isset($_GET['usun'])) {
    UsunPodstrone((int)$_GET['usun']);
} else {
    ListaPodstron();
    echo '<a href="admin.php?dodaj">Dodaj podstronę</a><br>';
}
?>
