-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 14, 2025 at 04:06 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moja_strona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `matka` int(11) DEFAULT 0,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id`, `matka`, `nazwa`) VALUES
(1, 0, '1'),
(3, 1, 'ng'),
(4, 15, 'g'),
(5, 0, 'g'),
(6, 0, 'f'),
(7, 0, 'sdfs'),
(8, 0, 'dfssd'),
(14, 0, 'g'),
(15, 4, 'n'),
(16, 4, 'n');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'Abradzal-Bajt', '    <h2>Abradż al-Bajt</h2>\r\n    <p><b>Miasto:</b> Mekka</p>\r\n     <p><b>Państwo:</b> Arabia Saudyjska</p>\r\n     <p><b>Wysokość (w metrach):</b> 601</p>\r\n     <p><b>Liczba kondygnacji:</b> 120</p>\r\n     <p><b>Rok budowy:</b> 2012</p>\r\n     <p><b>Powierzchnia (w tys. m²):</b> 1500</p>\r\n     <img src=\"img/Abraj-al-Bait-Towers_1.jpg\">\r\n     <p>Abradż al-Bajt – kompleks hotelowy w Mekce, w Arabii Saudyjskiej, postmodernistyczny, wzniesiony w latach 2004–2011 według projektu zespołu architektów biura architektonicznego SL Rasch; znajduje się w bezpośrednim sąsiedztwie Świętego Meczetu.\r\n\r\n     Abradż al-Bajt znajduje się w pobliżu największego na świecie meczetu i najświętszego miejsca islamu, Al-Masdżid al-Haram.\r\n\r\n     Kompleks posiada kilka światowych rekordów, w tym najwyższy hotel na świecie, najwyższy zegar wieżowy na świecie, największa na świecie tarcza zegara, i największy na świecie budynek pod względem powierzchni.\r\n\r\n     Kompleks stał się drugim pod względem wysokości budynkiem na świecie w 2011 roku, ustępował tylko Burdż Chalifa w Dubaju. Od 2015 roku zajmuje 3. miejsce. Projektantem i wykonawcą obiektu jest Saudi Binladin Group, największa firma budowlana królestwa.</p>\r\n     <img src=\"img/Abraj-al-Bait-Towers_2.jpg\">\r\n     <img src=\"img/Abraj-al-Bait-Towers_3.jpg\">\r\n', 1),
(2, 'BurdzChalifa', '     <h2>Burdż Chalifa</h2>\r\n     <p><b>Miasto:</b> Dubaj</p>\r\n     <p><b>Państwo:</b> Zjednoczone Emiraty Arabskie</p>\r\n     <p><b>Wysokość (w metrach):</b> 828</p>\r\n     <p><b>Liczba kondygnacji:</b> 163</p>\r\n     <p><b>Rok budowy:</b> 2010</p>\r\n     <p><b>Powierzchnia (w tys. m²):</b> 309</p>\r\n     <img src=\"img/Burj_Khalifa_1.jpg\">\r\n     <p>Burdż Chalifa, po polsku także: Wieża Chalify – wieżowiec w Dubaju, w Zjednoczonych Emiratach Arabskich, zbudowany przez przedsiębiorstwa Samsung Constructions, BESIX i Arabtec, o wysokości 828 metrów. Najwyższy budynek świata, który pobił rekord wysokości dla budowli dzierżony wcześniej przez polski Maszt radiowy w Konstantynowie (646m). Jego nazwa pochodzi od imienia szejka Chalify ibn Zajida Al Nahajjana, byłego prezydenta Zjednoczonych Emiratów Arabskich.\r\n\r\n     Budowa, rozpoczęta 21 września 2004, zakończyła się 16 sierpnia 2009. Wysokość 827,9 metrów została osiągnięta 17 stycznia 2009, a oficjalne otwarcie nastąpiło 4 stycznia 2010. Budynek ma 163 piętra użytkowe. Koszt jego budowy wyniósł 1,5 miliarda dolarów.</p>\r\n     \r\n     <img src=\"img/Burj_Khalifa_2.jpg\">\r\n     <img src=\"img/Burj_Khalifa_3.jpg\">\r\n', 1),
(3, 'glowna', '\r\n     <h1 style=\"text-align:center\">Największe budynki świata</h1>\r\n     <p class=\"wiez\"><a href=\"index.php?page=BurdzChalifa\">1. Burdż Chalifa</a></p>\r\n    <p class=\"wiez\"><a href=\"index.php?page=Merdeka118\">2. Merdeka 118</a></p>\r\n    <p class=\"wiez\"><a href=\"index.php?page=ShanghaiTower\">3. Shanghai Tower</a></p>\r\n    <p class=\"wiez\"><a href=\"index.php?page=Abradzal-Bajt\">4. Abradż al-Bajt</a></p>\r\n    <p class=\"wiez\"><a href=\"index.php?page=PingAnFinanceCenter\">5. Ping An Finance Center</a></p>\r\n     <img class=\"budynki\" src=\"img/budynki.png\">\r\n     <form method=\"post\" name=\"backgroud\">\r\n', 1),
(4, 'kontakt', '	<h1>KONTAKT</h1>\r\n	<a href=\"mailto:fym80562@dcobe.com\">Wyślij wiadomosc e-mail</a>\r\n	<form>\r\n	<label>E-MAIL</label>\r\n	<input type=\"email\" required>\r\n	<p>WIADOMOSC</p>\r\n	<textarea id=\"wiadomosc\" required></textarea>\r\n	<p></p>\r\n	<input type=\"submit\">\r\n    </form>', 1),
(5, 'Merdeka118', '    <h2>Merdeka 118</h2>\r\n    <p><b>Miasto:</b> Kuala Lumpur</p>\r\n     <p><b>Państwo:</b> Malezja</p>\r\n     <p><b>Wysokość (w metrach):</b> 678,9</p>\r\n     <p><b>Liczba kondygnacji:</b> 118</p>\r\n     <p><b>Rok budowy:</b> 2024</p>\r\n     <p><b>Powierzchnia (w tys. m²):</b> 292</p>\r\n     <img src=\"img/Merdeka_118_1.jpg\">\r\n     <p>Merdeka 118, także PNB 118 – wieżowiec w Kuala Lumpur, stolicy Malezji. Budynek ma 678,9 metra wysokości oraz 118 pięter. Prace nad budynkiem zaczęły się w 2014 roku. Budowa została ukończona w 2023 roku, a 15 stycznia 2024 wieżowiec został oddany do użytku.\r\n\r\n     Rozwój Merdeki 118 jest finansowany przez Permodalan Nasional Berhad. Konstrukcja jest obecnie najwyższym budynkiem w Malezji, wyprzedzając Petronas Towers oraz drugim najwyższym budynkiem na świecie.\r\n\r\n     80 ze 118 pięter zajmą biura, z czego 60 zajętych będzie przez inwestora obiektu. Poza tym w budynku znaleźć się mają hotele, prywatne apartamenty, placówki administracyjne, a także parking, restauracja, vip club (na ostatnim piętrze) oraz centrum handlowe i rozrywkowe.</p>\r\n     <img src=\"img/Merdeka_118_2.jpg\">\r\n     <img src=\"img/Merdeka_118_3.jpg\">\r\n', 1),
(6, 'PingAnFinanceCenter', '\r\n    <h2>Ping An Finance Center</h2>\r\n    <p><b>Miasto:</b> Shenzhen</p>\r\n     <p><b>Państwo:</b> Chiny</p>\r\n     <p><b>Wysokość (w metrach):</b> 599</p>\r\n     <p><b>Liczba kondygnacji:</b> 115</p>\r\n     <p><b>Rok budowy:</b> 2017</p>\r\n     <p><b>Powierzchnia (w tys. m²):</b> 386</p>\r\n     <img src=\"img/PingA%20FinanceCentre_1.jpg\">\r\n     <p>Ping An Finance Center – wieżowiec w Shenzhen, w prowincji Guangdong, w Chińskiej Republice Ludowej. Wysokość całkowita budynku wynosi 599 m co czyni go najwyższym wieżowcem w Shenzhen i drugim co do wielkości w Chinach, został otwarty w 2017 roku. Stał się najwyższym wieżowcem biurowym na świecie.\r\n\r\n     Koszt budynku to ok. 5,49 miliarda złotych ($ 1,5 miliarda) co przy 385 918 metrach kwadratowych powierzchni użytkowej daje ok. 14225,81 złotych za metr kwadratowy.</p>\r\n     <img src=\"img/PingA%20FinanceCentre_2.jpg\">\r\n     <img src=\"img/PingA%20FinanceCentre_3.jpg\">\r\n', 1),
(7, 'ShanghaiTower', '    <h2>Shanghai Tower</h2>\r\n    <p><b>Miasto:</b> Szanghaj</p>\r\n     <p><b>Państwo:</b> Chiny</p>\r\n     <p><b>Wysokość (w metrach):</b> 632</p>\r\n     <p><b>Liczba kondygnacji:</b> 128</p>\r\n     <p><b>Rok budowy:</b> 2015</p>\r\n     <p><b>Powierzchnia (w tys. m²):</b> 380</p>\r\n     <img src=\"img/ShanghaiTower_1.jpg\">\r\n     <p>Shanghai Tower – wieżowiec znajdujący się w dzielnicy Pudong w Szanghaju w bezpośrednim sąsiedztwie Jin Mao oraz SWFC. Budowa zaczęła się w 2008 r. jej zakończenie zaplanowano na rok 2015, ostatecznie budynek został oddany do użytku w roku 2017. Inwestorem oraz wykonawcą jest Shanghai Tower Construction Development Co., Ltd. reprezentująca trzy firmy: Shanghai Chengtou Corp., Luijiazui Finance Trade Zone Development Co., Ltd., oraz Shanghai Construction Group. Wieżowiec zaprojektowało biuro architektoniczne Gensler. Koszt budowy wyniósł 2,4 mld $.\r\n\r\n     Wieżowiec jest najwyższym w Chinach oraz trzecim pod względem wysokości na świecie, niższym tylko od Burdż Chalifa w Dubaju w Zjednoczonych Emiratach Arabskich i Merdeka 118 w Kuala Lumpur w Malezji.</p>\r\n     <img src=\"img/ShanghaiTower_2.jpg\">\r\n     <img src=\"img/ShanghaiTower_3.jpg\">\r\n', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `opis` text DEFAULT NULL,
  `data_utworzenia` datetime DEFAULT current_timestamp(),
  `data_modyfikacji` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `data_wygasniecia` datetime DEFAULT NULL,
  `cena_netto` decimal(10,2) NOT NULL,
  `podatek_vat` decimal(5,2) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `status_dostepnosci` tinyint(1) DEFAULT 1,
  `kategoria_id` int(11) DEFAULT NULL,
  `gabaryt` varchar(255) DEFAULT NULL,
  `zdjecie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id`, `tytul`, `opis`, `data_utworzenia`, `data_modyfikacji`, `data_wygasniecia`, `cena_netto`, `podatek_vat`, `ilosc`, `status_dostepnosci`, `kategoria_id`, `gabaryt`, `zdjecie`) VALUES
(1, 'produkt11', 'opis produktu1', '2025-01-07 14:41:30', '2025-01-07 15:02:58', '2025-01-18 14:40:00', 200.00, 30.00, 2, 1, 1, '---', 'https://hagleysbeauty.com/wp-content/uploads/2023/03/test-button-1.jpg'),
(4, 'frg', 'gerf', '2025-01-07 15:21:17', '2025-01-07 15:27:01', '2025-01-02 15:21:00', 321.00, 12.00, 1, 1, 1, '321', '213');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoria_id` (`kategoria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
