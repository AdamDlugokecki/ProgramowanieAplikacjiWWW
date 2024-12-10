// ==========================================
// Funkcja: getthedate
// Opis: Pobiera dzisiejszą datę i wyświetla ją w formacie MM/DD/YY
//       w elemencie o ID "data".
// ==========================================
function getthedate() {
    var todays = new Date(); // Tworzenie obiektu Date dla bieżącego dnia
    var theDate = "" + (todays.getMonth() + 1) + " / " + todays.getDate() + " / " + (todays.getFullYear() % 100);
    document.getElementById("data").innerHTML = theDate; // Wyświetlenie daty w elemencie HTML
}

// ==========================================
// Zmienne globalne do obsługi zegara
// ==========================================
var timerID = null; // Przechowuje identyfikator timera
var timerRunning = false; // Flaga informująca, czy timer jest uruchomiony

// ==========================================
// Funkcja: stopclock
// Opis: Zatrzymuje aktualnie uruchomiony zegar.
// ==========================================
function stopclock() {
    if (timerRunning) {
        clearTimeout(timerID); // Zatrzymanie timera
    }
    timerRunning = false; // Ustawienie flagi na false
}

// ==========================================
// Funkcja: startclock
// Opis: Uruchamia zegar, wyświetlając aktualną datę i czas.
// ==========================================
function startclock() {
    stopclock(); // Zatrzymanie zegara, jeśli był uruchomiony
    getthedate(); // Pobranie i wyświetlenie dzisiejszej daty
    showtime(); // Uruchomienie funkcji pokazującej czas
}

// ==========================================
// Funkcja: showtime
// Opis: Wyświetla aktualny czas w formacie 12-godzinnym
//       i aktualizuje go co sekundę.
// ==========================================
function showtime() {
    var now = new Date(); // Tworzenie obiektu Date dla bieżącego czasu
    var hours = now.getHours(); // Pobranie godzin
    var minutes = now.getMinutes(); // Pobranie minut
    var seconds = now.getSeconds(); // Pobranie sekund
    
    // Formatowanie czasu w systemie 12-godzinnym
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
    timeValue += (hours >= 12) ? " P.M." : " A.M.";
    
    // Wyświetlenie czasu w elemencie HTML o ID "zegarek"
    document.getElementById("zegarek").innerHTML = timeValue;
    
    // Ustawienie funkcji aktualizującej czas co sekundę
    timerID = setTimeout(showtime, 1000);
    timerRunning = true; // Ustawienie flagi na true
}
