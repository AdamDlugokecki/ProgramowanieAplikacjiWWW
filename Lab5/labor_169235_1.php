<?php

$nr_indeksu='169235';
$nrGrupy = '1';

echo 'Adam Długokęcki '.$nr_indeksu.' grupa'.$nrGrupy.'<br/><br/>';
     
echo "Punkt a) Demonstracja działania include() oraz require_once() <br/>";
include('labor2.php');
require_once('labor2.php');
echo "Punkt b) Demonstracja warunków if, else, elseif, switch<br/>";

$liczba = 10;

if ($liczba > 10) {
    echo "Liczba jest większa niż 10<br/>";
} elseif ($liczba == 10) {
    echo "Liczba jest równa 10<br/>";
} else {
    echo "Liczba jest mniejsza niż 10<br/>";
}

$kolor = "czerwony";

switch ($kolor) {
    case "czerwony":
        echo "Kolor to czerwony<br/>";
        break;
    case "zielony":
        echo "Kolor to zielony<br/>";
        break;
    case "niebieski":
        echo "Kolor to niebieski<br/>";
        break;
    default:
        echo "Kolor nie jest zdefiniowany<br/>";
}

echo "Punkt c) Demonstracja pętli while() i for()<br/>";

$i = 1;
while ($i <= 5) {
    echo "To jest iteracja while numer: $i<br/>";
    $i++;
}

for ($j = 1; $j <= 5; $j++) {
    echo "To jest iteracja for numer: $j<br/>";
}

echo "Punkt d) Demonstracja zmiennych superglobalnych: \$_GET, \$_POST, \$_SESSION<br/>";

if (isset($_GET['nazwa'])) {
    echo "Wartość przekazana przez \$_GET['nazwa']: " . $_GET['nazwa'] . "<br/>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nazwa'])) {
    echo "Wartość przekazana przez \$_POST['nazwa']: " . $_POST['nazwa'] . "<br/>";
}

session_start();
$_SESSION['user'] = "Adam Długokęcki";
echo "Wartość zmiennej sesji \$_SESSION['user']: " . $_SESSION['user'] . "<br/>";

?>
