<?
 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="pl" />
<meta name="Author" content="Adam Długokęcki" />
<title>Najwieksze budynki swiata</title>
<link rel="stylesheet" href="css/style.css">
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
<table>
<tr>
 <td class="menu">
  <div class="zegar">
      <div id="zegarek"></div>
     <div id="data"></div>
  </div>
   
    <a href="index.php?page=glowna">
            <div class="pole animacjaTestowa">STRONA GŁÓWNA</div>
        </a>
        <a href="index.php?page=kontakt">
            <div class="pole animacjaTestowa">KONTAKT</div>
	    </a>
     <img src="img/moon.png" class="moon" onclick="changeBackground('#FFFFFF','#000000')">
 </td>
 </tr>
 <tr>
     <td class="content">
        <?php
        require_once 'cfg.php';
         require_once 'showpage.php';
         
         $page = $_GET['page'] ?? 'glowna';
         $allowed_pages = ['glowna', 'kontakt', 'Abradzal-Bajt', 'BurdzChalifa', 'Merdeka118', 'PingAnFinanceCenter', 'ShanghaiTower'];

         if (in_array($page, $allowed_pages)) {
        $content = PokazPodstrone($pdo, $page);

             if ($content) {
                 echo $content;
             } else {
                 echo "<p>Strona nie została znaleziona w bazie danych.</p>";
             }
         } else {
             echo "<p>Strona nie istnieje.</p>";
         }
        ?>
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
</table>
</body>
<html>