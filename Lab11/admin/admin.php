<html>
<head>
    <!-- Styl CSS -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body id="admin">
<?php
session_start();

/**
 * Funkcja wyświetlająca formularz logowania.
 */
function FormularzLogowania() {
    echo '<h1 style="padding-left=0px;">Logowanie do panelu admina</h1>
            <form method="post">
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
        echo "Podstrona zaktualizowana. </br> <a href=admin.php?lista>Powrót</a>";
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
                </br><a href=admin.php?lista>Powrót</a>
                
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
        echo "Podstrona dodana. </br> <a href=admin.php?lista>Powrót</a>";
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
                </br><a href=admin.php?lista>Powrót</a>
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

/**
 * Funkcja wyświetlająca kategorie w formie drzewa z opcjami edycji i usunięcia.
 */
function PokazKategorie($matka = 0, $poziom = 0) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $sql = "SELECT id, nazwa FROM kategorie WHERE matka=$matka";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo str_repeat('--', $poziom) . htmlspecialchars($row['nazwa']) .
             ' <a href="admin.php?edytuj_kategorie=' . $row['id'] . '">Edytuj</a> | ' .
             '<a href="admin.php?usun_kategorie=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć tę kategorię?\')">Usuń</a><br>';
        PokazKategorie($row['id'], $poziom + 1); // Rekurencja dla podkategorii
    }

    $conn->close();
}
/**
 * Funkcja do dodawania kategorii.
 */
function DodajKategorie() {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nazwa = $conn->real_escape_string($_POST['nazwa']);
        $matka = (int)$_POST['matka'];

        $sql = "INSERT INTO kategorie (nazwa, matka) VALUES ('$nazwa', $matka)";
        $conn->query($sql);
        echo "Kategoria dodana. </br> <a href=admin.php?pokaz_kategorie>Powrót</a>";
    } else {
        echo '<form method="post">
                <label>Nazwa:</label>
                <input type="text" name="nazwa" required><br>
                <label>Kategoria nadrzędna:</label>
                <select name="matka">
                    <option value="0">Brak</option>';
        WypiszKategorieDoWyboru(); // Wyświetlanie listy kategorii nadrzędnych
        echo '</select><br>
                <button type="submit">Dodaj</button>
            </form>';
    }
    $conn->close();
}
/**
 * Funkcja do edytowania kategorii.
 */
function EdytujKategorie($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nazwa = $conn->real_escape_string($_POST['nazwa']);
        $matka = (int)$_POST['matka'];

        $sql = "UPDATE kategorie SET nazwa='$nazwa', matka=$matka WHERE id=$id";
        $conn->query($sql);
        echo "Kategoria zaktualizowana. </br> <a href=admin.php?pokaz_kategorie>Powrót</a>";
    } else {
        $sql = "SELECT * FROM kategorie WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        echo '<form method="post">
                <label>Nazwa:</label>
                <input type="text" name="nazwa" value="' . htmlspecialchars($row['nazwa']) . '" required><br>
                <label>Kategoria nadrzędna:</label>
                <select name="matka">
                    <option value="0">Brak</option>';
        WypiszKategorieDoWyboru(0, 0, $row['matka']); // Wyświetlanie listy z zaznaczoną wartością
        echo '</select><br>
                <button type="submit">Zapisz</button>
            </form>';
    }
    $conn->close();
}
/**
 * Funkcja do usuwania kategorii oraz jej podkategorii.
 */
function UsunKategorie($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    // Najpierw usuń podkategorie
    $sql = "SELECT id FROM kategorie WHERE matka=$id";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        UsunKategorie($row['id']); // Rekurencja
    }

    // Usuń kategorię
    $sql = "DELETE FROM kategorie WHERE id=$id LIMIT 1";
    $conn->query($sql);

    echo "Kategoria usunięta. </br> <a href=admin.php>Powrót</a>";
    $conn->close();
}
/**
 * Funkcja pomocnicza do wyświetlania kategorii w <select>.
 */
function WypiszKategorieDoWyboru($matka = 0, $poziom = 0, $wybrana = 0) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    $sql = "SELECT id, nazwa FROM kategorie WHERE matka=$matka";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $selected = ($row['id'] == $wybrana) ? 'selected' : '';
        echo '<option value="' . $row['id'] . '" ' . $selected . '>' .
             str_repeat('--', $poziom) . htmlspecialchars($row['nazwa']) . '</option>';
        WypiszKategorieDoWyboru($row['id'], $poziom + 1, $wybrana);
    }
    $conn->close();
}
    
/**
 * Funkcja wyświetlająca produkty.
 */
function PokazProdukty() {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $sql = "SELECT p.id, p.tytul, p.cena_netto, p.ilosc, p.status_dostepnosci, 
                   p.zdjecie, p.data_wygasniecia, k.nazwa AS kategoria
            FROM produkty p
            LEFT JOIN kategorie k ON p.kategoria_id = k.id";
    $result = $conn->query($sql);

    echo '<table border="1">';
    echo '<tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Cena netto</th>
            <th>Ilość</th>
            <th>Dostępność</th>
            <th>Kategoria</th>
            <th>Zdjęcie</th>
            <th>Akcje</th>
          </tr>';

    $current_date = date('Y-m-d H:i:s'); // Pobierz bieżącą datę w formacie zgodnym z MySQL

    while ($row = $result->fetch_assoc()) {
        // Oblicz dostępność produktu
        $dostepny = $row['status_dostepnosci'] &&
                    $row['ilosc'] > 0 &&
                    (empty($row['data_wygasniecia']) || $row['data_wygasniecia'] > $current_date);

        echo '<tr>
                <td>' . htmlspecialchars($row['id']) . '</td>
                <td>' . htmlspecialchars($row['tytul']) . '</td>
                <td>' . htmlspecialchars($row['cena_netto']) . '</td>
                <td>' . htmlspecialchars($row['ilosc']) . '</td>
                <td>' . ($dostepny ? 'Dostępny' : 'Niedostępny') . '</td>
                <td>' . htmlspecialchars($row['kategoria']) . '</td>
                <td>';
        if (!empty($row['zdjecie'])) {
            echo '<img src="' . htmlspecialchars($row['zdjecie']) . '" alt="Zdjęcie produktu" style="max-width:100px;max-height:100px;">';
        } else {
            echo 'Brak zdjęcia';
        }
        echo '</td>
                <td>
                    <a href="admin.php?edytuj_produkt=' . $row['id'] . '">Edytuj</a> |
                    <a href="admin.php?usun_produkt=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć ten produkt?\')">Usuń</a>
                </td>
              </tr>';
    }
    echo '</table>';
    echo '<a href="admin.php?dodaj_produkt">Dodaj nowy produkt</a>';
    $conn->close();
}

    
/**
 * Funkcja do dodawania nowego produktu.
 */
function DodajProdukt() {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tytul = $conn->real_escape_string($_POST['tytul']);
        $opis = $conn->real_escape_string($_POST['opis']);
        $data_wygasniecia = $conn->real_escape_string($_POST['data_wygasniecia']);
        $cena_netto = (float)$_POST['cena_netto'];
        $podatek_vat = (float)$_POST['podatek_vat'];
        $ilosc = (int)$_POST['ilosc'];
        $status_dostepnosci = isset($_POST['status_dostepnosci']) ? 1 : 0;
        $kategoria_id = (int)$_POST['kategoria_id'];
        $gabaryt = $conn->real_escape_string($_POST['gabaryt']);
        $zdjecie = $conn->real_escape_string($_POST['zdjecie']);

        $sql = "INSERT INTO produkty (tytul, opis, data_wygasniecia, cena_netto, podatek_vat, ilosc, status_dostepnosci, kategoria_id, gabaryt, zdjecie) 
                VALUES ('$tytul', '$opis', '$data_wygasniecia', $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria_id, '$gabaryt', '$zdjecie')";
        $conn->query($sql);
        echo "Produkt został dodany. </br> <a href=admin.php?pokaz_produkty>Powrót</a>";
    } else {
        echo '<form method="post">
                <label>Tytuł:</label><br>
                <input type="text" name="tytul" required><br>
                <label>Opis:</label><br>
                <textarea name="opis" required></textarea><br>
                <label>Data wygaśnięcia:</label><br>
                <input type="datetime-local" name="data_wygasniecia"><br>
                <label>Cena netto:</label><br>
                <input type="number" step="0.01" name="cena_netto" required><br>
                <label>Podatek VAT (%):</label><br>
                <input type="number" step="0.01" name="podatek_vat" required><br>
                <label>Ilość:</label><br>
                <input type="number" name="ilosc" required><br>
                <label>Status dostępności:</label>
                <input type="checkbox" name="status_dostepnosci"><br>
                <label>Kategoria:</label><br>
                <select name="kategoria_id">';
        WypiszKategorieDoWyboru();
        echo '</select><br>
                <label>Gabaryt:</label><br>
                <input type="text" name="gabaryt"><br>
                <label>Zdjęcie (link):</label><br>
                <input type="text" name="zdjecie"><br>
                <button type="submit">Dodaj produkt</button>
            </form>';
    }
    $conn->close();
}

/**
 * Funkcja do edytowania produktu.
 */
function EdytujProdukt($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tytul = $conn->real_escape_string($_POST['tytul']);
        $opis = $conn->real_escape_string($_POST['opis']);
        $data_wygasniecia = $conn->real_escape_string($_POST['data_wygasniecia']);
        $cena_netto = (float)$_POST['cena_netto'];
        $podatek_vat = (float)$_POST['podatek_vat'];
        $ilosc = (int)$_POST['ilosc'];
        $status_dostepnosci = isset($_POST['status_dostepnosci']) ? 1 : 0;
        $kategoria_id = (int)$_POST['kategoria_id'];
        $gabaryt = $conn->real_escape_string($_POST['gabaryt']);
        $zdjecie = $conn->real_escape_string($_POST['zdjecie']);

        $sql = "UPDATE produkty 
                SET tytul='$tytul', opis='$opis', data_wygasniecia='$data_wygasniecia',
                    cena_netto=$cena_netto, podatek_vat=$podatek_vat, ilosc=$ilosc,
                    status_dostepnosci=$status_dostepnosci, kategoria_id=$kategoria_id, 
                    gabaryt='$gabaryt', zdjecie='$zdjecie'
                WHERE id=$id";
        $conn->query($sql);
        echo "Produkt zaktualizowany. </br> <a href=admin.php?pokaz_produkty>Powrót</a>";
    } else {
        $sql = "SELECT * FROM produkty WHERE id=$id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        echo '<form method="post">
                <label>Tytuł:</label><br>
                <input type="text" name="tytul" value="' . htmlspecialchars($row['tytul']) . '" required><br>
                <label>Opis:</label><br>
                <textarea name="opis" required>' . htmlspecialchars($row['opis']) . '</textarea><br>
                <label>Data wygaśnięcia:</label><br>
                <input type="datetime-local" name="data_wygasniecia" value="' . htmlspecialchars($row['data_wygasniecia']) . '"><br>
                <label>Cena netto:</label><br>
                <input type="number" step="0.01" name="cena_netto" value="' . htmlspecialchars($row['cena_netto']) . '" required><br>
                <label>Podatek VAT (%):</label><br>
                <input type="number" step="0.01" name="podatek_vat" value="' . htmlspecialchars($row['podatek_vat']) . '" required><br>
                <label>Ilość:</label><br>
                <input type="number" name="ilosc" value="' . htmlspecialchars($row['ilosc']) . '" required><br>
                <label>Status dostępności:</label>
                <input type="checkbox" name="status_dostepnosci" ' . ($row['status_dostepnosci'] ? 'checked' : '') . '><br>
                <label>Kategoria:</label><br>
                <select name="kategoria_id">';
        WypiszKategorieDoWyboru(0, 0, $row['kategoria_id']);
        echo '</select><br>
                <label>Gabaryt:</label><br>
                <input type="text" name="gabaryt" value="' . htmlspecialchars($row['gabaryt']) . '"><br>
                <label>Zdjęcie (link):</label><br>
                <input type="text" name="zdjecie" value="' . htmlspecialchars($row['zdjecie']) . '"><br>
                <button type="submit">Zapisz zmiany</button>
            </form>';
    }
    $conn->close();
}


/**
 * Funkcja do usuwania produktu.
 */
function UsunProdukt($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");
    $sql = "DELETE FROM produkty WHERE id=$id LIMIT 1";
    $conn->query($sql);
    echo "Produkt został usunięty. </br> <a href=admin.php?pokaz_produkty>Powrót</a>";
    $conn->close();
}


// Główna logika obsługi panelu
if (isset($_GET['lista'])) {
    ListaPodstron();
    echo '<a href="admin.php?dodaj">Dodaj podstronę</a><br>';
    echo "<a href=admin.php>Powrót</a></br>";
} elseif (isset($_GET['dodaj'])) {
    DodajNowaPodstrone();
} elseif (isset($_GET['edytuj'])) {
    EdytujPodstrone((int)$_GET['edytuj']);
} elseif (isset($_GET['usun'])) {
    UsunPodstrone((int)$_GET['usun']);
} elseif (isset($_GET['pokaz_kategorie'])) {
    PokazKategorie();
    echo '<a href="admin.php?dodaj_kategorie">Zarządzaj kategoriami</a><br>';
    echo "<a href=admin.php?pokaz_kategorie>Powrót</a></br>";
} elseif (isset($_GET['dodaj_kategorie'])) {
    DodajKategorie();
    echo "<a href=admin.php>Powrót</a></br>";
} elseif (isset($_GET['edytuj_kategorie'])) {
    EdytujKategorie((int)$_GET['edytuj_kategorie']);
} elseif (isset($_GET['usun_kategorie'])) {
    UsunKategorie((int)$_GET['usun_kategorie']);
}   elseif (isset($_GET['pokaz_produkty'])) {
    PokazProdukty();
    echo "</br><a href=admin.php>Powrót</a></br>";
} elseif (isset($_GET['dodaj_produkt'])) {
    DodajProdukt();
} elseif (isset($_GET['edytuj_produkt'])) {
    EdytujProdukt((int)$_GET['edytuj_produkt']);
} elseif (isset($_GET['usun_produkt'])) {
    UsunProdukt((int)$_GET['usun_produkt']);
} else {
    echo '<a href="admin.php?pokaz_produkty"><h1>Produkty</h1></a><br>';
    echo '<a href="admin.php?pokaz_kategorie"><h1>Kategorie</h1></a><br>';
    echo '<a href="admin.php?lista"><h1>Podstrony</h1></a><br>';
}

?>
</body>
</html>
