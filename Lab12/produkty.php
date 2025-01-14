<?php
session_start();

// Połączenie z bazą danych
$conn = new mysqli("localhost", "root", "", "moja_strona");
if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

// Pobieranie kategorii
$kategorie = $conn->query("SELECT * FROM kategorie");

// Pobieranie produktów na podstawie wybranej kategorii
$kategoria_id = isset($_GET['kategoria']) ? (int)$_GET['kategoria'] : 0;
$sql = "SELECT * FROM produkty";
if ($kategoria_id > 0) {
    $sql .= " WHERE kategoria_id = $kategoria_id";
}
$produkty = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Internetowy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .buttons {
            margin-bottom: 20px;
        }
        .buttons a {
            display: inline-block;
            margin-right: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }
        .buttons a:hover {
            background-color: #0056b3;
        }
        .kategorie-form {
            margin-bottom: 20px;
        }
        .produkty-container {
            display: flex;
            flex-wrap: wrap;
        }
        .produkt-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            width: 200px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .produkt-card img {
            max-width: 100%;
            max-height: 150px;
            margin-bottom: 10px;
        }
        .produkt-card h3 {
            font-size: 16px;
            margin: 10px 0;
        }
        .produkt-card p {
            font-size: 14px;
            margin: 5px 0;
        }
        .produkt-card button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .produkt-card button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Sklep Internetowy</h1>

    <!-- Przyciski do nawigacji -->
    <div class="buttons">
        <a href="index.php">Powrót do strony głównej</a>
        <a href="koszyk.php">Przejdź do koszyka</a>
    </div>

    <h2>Wybierz kategorię:</h2>
    <form method="get" action="produkty.php" class="kategorie-form">
        <select name="kategoria">
            <option value="0">Wszystkie</option>
            <?php while ($kategoria = $kategorie->fetch_assoc()): ?>
                <option value="<?= $kategoria['id'] ?>" <?= $kategoria_id == $kategoria['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kategoria['nazwa']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Filtruj</button>
    </form>

    <h2>Produkty:</h2>
    <div class="produkty-container">
        <?php while ($produkt = $produkty->fetch_assoc()): ?>
            <?php 
                $cena_brutto = $produkt['cena_netto'] * (1 + $produkt['podatek_vat'] / 100); 
                $zdjecie = !empty($produkt['zdjecie']) ? $produkt['zdjecie'] : 'placeholder.png'; // Obrazek zastępczy
            ?>
            <div class="produkt-card">
                <img src="<?= htmlspecialchars($zdjecie) ?>" alt="<?= htmlspecialchars($produkt['tytul']) ?>">
                <h3><?= htmlspecialchars($produkt['tytul']) ?></h3>
                <p><?= number_format($cena_brutto, 2) ?> PLN</p>
                <form method="post" action="koszyk.php">
                    <input type="hidden" name="produkt_id" value="<?= $produkt['id'] ?>">
                    <input type="hidden" name="akcja" value="dodaj">
                    <button type="submit">Kup</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
<?php $conn->close(); ?>
