<?php
// Wyłączenie raportowania niektórych błędów
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Adam Długokęcki" />
    <title>Największe budynki świata</title>
    
    <!-- Styl CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Skrypty JavaScript -->
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
    <table>
        <!-- Sekcja menu -->
        <tr>
            <td class="menu">
                <!-- Zegar i data -->
                <div class="zegar">
                    <div id="zegarek"></div>
                    <div id="data"></div>
                </div>

                <!-- Linki nawigacyjne -->
                <a href="index.php?page=glowna">
                    <div class="pole animacjaTestowa">STRONA GŁÓWNA</div>
                </a>
                <a href="index.php?page=kontakt">
                    <div class="pole animacjaTestowa">KONTAKT</div>
                </a>
                <a href="admin/admin.php">
                    <div class="pole animacjaTestowa">ZALOGUJ</div>
                </a>

                <!-- Przełącznik kolorów tła -->
                <img src="img/moon.png" class="moon" onclick="changeBackground('#FFFFFF', '#000000')">

                <!-- Animacje dla przycisków menu -->
                <script>
                    $(".animacjaTestowa").on({
                        "mouseenter": function() {
                            $(this).animate({
                                height: 30
                            }, 800);
                        },
                        "mouseleave": function() {
                            $(this).animate({
                                height: 20
                            }, 800);
                        }
                    });
                </script>
            </td>
        </tr>

        <!-- Sekcja zawartości -->
        <tr>
            <td class="content">
                <?php
                // Dołączenie plików konfiguracyjnych i funkcji
                require_once 'cfg.php';
                require_once 'showpage.php';

                // Pobranie parametru strony
                $page = $_GET['page'] ?? 'glowna';

                // Dozwolone strony
                $allowed_pages = ['glowna', 'kontakt', 'Abradzal-Bajt', 'BurdzChalifa', 'Merdeka118', 'PingAnFinanceCenter', 'ShanghaiTower'];

                // Sprawdzenie, czy strona jest dozwolona i pobranie zawartości
                if (in_array($page, $allowed_pages)) {
                    $content = PokazPodstrone($pdo, $page); // Funkcja pobierająca zawartość strony z bazy

                    if ($content) {
                        echo $content; // Wyświetlenie zawartości strony
                    } else {
                        echo "<p>Strona nie została znaleziona w bazie danych.</p>";
                    }
                } else {
                    echo "<p>Strona nie istnieje.</p>";
                }
                ?>
            </td>
        </tr>
    </table>
</body>
</html>
