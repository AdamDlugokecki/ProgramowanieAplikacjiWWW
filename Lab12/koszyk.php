<?php
session_start();

// Połączenie z bazą danych
$conn = new mysqli("localhost", "root", "", "moja_strona");
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

// Inicjalizacja koszyka
if (!isset($_SESSION['koszyk'])) {
    $_SESSION['koszyk'] = [];
}

// Pobranie akcji
$akcja = $_POST['akcja'] ?? '';
$produkt_id = isset($_POST['produkt_id']) ? (int)$_POST['produkt_id'] : null;

switch ($akcja) {
    case 'dodaj':
        if ($produkt_id) {
            if (!isset($_SESSION['koszyk'][$produkt_id])) {
                $_SESSION['koszyk'][$produkt_id] = 1; // Dodaj 1 sztukę
            } else {
                $_SESSION['koszyk'][$produkt_id]++;
            }
        }
        break;

    case 'usun':
        if ($produkt_id && isset($_SESSION['koszyk'][$produkt_id])) {
            unset($_SESSION['koszyk'][$produkt_id]);
        }
        break;

    case 'zmien_ilosc':
        $ilosc = (int)($_POST['ilosc'] ?? 0);
        if ($produkt_id && $ilosc > 0) {
            $_SESSION['koszyk'][$produkt_id] = $ilosc;
        } elseif ($produkt_id) {
            unset($_SESSION['koszyk'][$produkt_id]);
        }
        break;
}

// Pobranie danych produktów w koszyku
$koszyk = $_SESSION['koszyk'];
$produkty = [];
if (!empty($koszyk)) {
    $ids = implode(',', array_keys($koszyk));
    $sql = "SELECT * FROM produkty WHERE id IN ($ids)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $row['ilosc'] = $koszyk[$row['id']];
        $produkty[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koszyk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #f4f4f4;
        }
        .koszyk-empty {
            font-size: 18px;
            margin: 20px 0;
            text-align: center;
        }
        .koszyk-summary {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body style="">
    <h1>Koszyk</h1>
    <a href="produkty.php" class="button">Powrót do produktów</a>

    <?php if (empty($produkty)): ?>
        <p class="koszyk-empty">Twój koszyk jest pusty.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Zdjęcie</th>
                <th>Tytuł</th>
                <th>Cena netto</th>
                <th>VAT</th>
                <th>Cena brutto</th>
                <th>Ilość</th>
                <th>Wartość brutto</th>
                <th>Akcje</th>
            </tr>
            <?php 
            $suma = 0;
            foreach ($produkty as $produkt): 
                $cena_brutto = $produkt['cena_netto'] * (1 + $produkt['podatek_vat'] / 100);
                $wartosc_brutto = $cena_brutto * $produkt['ilosc'];
                $suma += $wartosc_brutto;
                $zdjecie = !empty($produkt['zdjecie']) ? $produkt['zdjecie'] : 'placeholder.png';
            ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($zdjecie) ?>" alt="Zdjęcie" style="max-width: 100px; max-height: 100px;"></td>
                    <td><?= htmlspecialchars($produkt['tytul']) ?></td>
                    <td><?= number_format($produkt['cena_netto'], 2) ?> PLN</td>
                    <td><?= htmlspecialchars($produkt['podatek_vat']) ?>%</td>
                    <td><?= number_format($cena_brutto, 2) ?> PLN</td>
                    <td>
                        <form method="post" action="koszyk.php" style="display: inline;">
                            <input type="hidden" name="akcja" value="zmien_ilosc">
                            <input type="hidden" name="produkt_id" value="<?= $produkt['id'] ?>">
                            <input type="number" name="ilosc" value="<?= $produkt['ilosc'] ?>" min="1" style="width: 50px;">
                            <button type="submit" class="button">Zmień</button>
                        </form>
                    </td>
                    <td><?= number_format($wartosc_brutto, 2) ?> PLN</td>
                    <td>
                        <form method="post" action="koszyk.php" style="display: inline;">
                            <input type="hidden" name="akcja" value="usun">
                            <input type="hidden" name="produkt_id" value="<?= $produkt['id'] ?>">
                            <button type="submit" class="button" style="background-color: red;">Usuń</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p class="koszyk-summary">Suma: <?= number_format($suma, 2) ?> PLN</p>
    <?php endif; ?>

</body>
</html>
<?php $conn->close(); ?>
