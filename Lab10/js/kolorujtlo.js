// ==========================================
// Funkcja: changeBackground
// Opis: Zmienia kolor tła dokumentu HTML naprzemiennie
//       pomiędzy dwoma podanymi kolorami w formacie szesnastkowym.
// ==========================================

// Zmienna globalna do śledzenia stanu przełączania kolorów
var time = 0;

function changeBackground(hexNumber, hexNumber2) {
    // Sprawdzenie aktualnego stanu i ustawienie odpowiedniego koloru tła
    if (time == 0) {
        document.body.style.background = hexNumber; // Ustawienie pierwszego koloru
        time = 1; // Zmiana stanu
    } else {
        document.body.style.background = hexNumber2; // Ustawienie drugiego koloru
        time = 0; // Powrót do pierwotnego stanu
    }
}
