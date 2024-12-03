
<?php
session_start();
function FormularzLogowania() {
    echo '<form method="post">
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required><br>
            <label for="password">Hasło:</label>
            <input type="password" name="password" id="password" required><br>
            <button type="submit" name="zaloguj">Zaloguj</button>
        </form>';
}

if (isset($_POST['zaloguj'])) {
    include '../cfg.php';
    if ($_POST['login'] === $login && $_POST['password'] === $pass) {
        $_SESSION['zalogowany'] = true;
    } else {
        echo 'Błędne dane logowania.<br>';
        FormularzLogowania();
        exit;
    }
}

if (!isset($_SESSION['zalogowany'])) {
    FormularzLogowania();
    exit;
}

function ListaPodstron() {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    $sql = "SELECT id, page_title FROM page_list";
    $result = $conn->query($sql);

    echo '<table>';
    while ($row = $result-> fetch_assoc()) {
        echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['page_title'] . '</td>
                <td><a href="admin.php?edytuj=' . $row['id'] . '">Edytuj</a></td>
                <td><a href="admin.php?usun=' . $row['id'] . '">Usuń</a></td>
              </tr>';
    }
    echo '</table>';

    $conn->close();
}

function EdytujPodstrone($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tytul = $_POST['tytul'];
        $tresc = $_POST['tresc'];
        $aktywny = isset($_POST['aktywny']) ? 1 : 0;

        $sql = "UPDATE page_list SET page_title='$tytul', page_content='$tresc', status=$aktywny WHERE id=$id LIMIT 1";
        $conn->query($sql);
        echo "Podstrona zaktualizowana. </br> <a href=../index.php>powrót</a>";
    } else {
        $sql = "SELECT * FROM page_list WHERE id=$id LIMIT 1";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        echo '<form method="post">
                <label>Tytuł:</label>
                <input type="text" name="tytul" value="' . $row['page_title'] . '" required><br>
                <label>Treść:</label>
                <textarea name="tresc">' . $row['page_content'] . '</textarea><br>
                <label>Aktywny:</label>
                <input type="checkbox" name="aktywny" ' . ($row['status'] ? 'checked' : '') . '><br>
                <button type="submit">Zapisz</button>
            </form>';
    }

    $conn->close();
}

function DodajNowaPodstrone() {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tytul = $_POST['tytul'];
        $tresc = $_POST['tresc'];
        $aktywny = isset($_POST['aktywny']) ? 1 : 0;

        $sql = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$tytul', '$tresc', $aktywny)";
        $conn->query($sql);
        echo "Podstrona dodana. </br> <a href=../index.php>powrót</a>";
    } else {
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

function UsunPodstrone($id) {
    $conn = new mysqli("localhost", "root", "", "moja_strona");

    $sql = "DELETE FROM page_list WHERE id=$id LIMIT 1";
    $conn->query($sql);

    echo "Podstrona usunięta. </br> <a href=../index.php>powrót</a>";
    $conn->close();
}
if (isset($_GET['lista'])) {
    ListaPodstron();
} elseif (isset($_GET['dodaj'])) {
    DodajNowaPodstrone();
} elseif (isset($_GET['edytuj'])) {
    EdytujPodstrone((int)$_GET['edytuj']);
} elseif (isset($_GET['usun'])) {
    UsunPodstrone((int)$_GET['usun']);
}
if($_SESSION['zalogowany'] = false)
         {
             FormularzLogowania();
         }
         else
         {
             ListaPodstron();
             echo '<a href="admin.php?dodaj">Dodaj podstrone</a></br>';
         }
?>
