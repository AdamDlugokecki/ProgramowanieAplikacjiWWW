<?php
// ==========================================
// Klasa: Contact
// ==========================================
class Contact {
    // ==========================================
    // Metoda: PokazKontakt
    // Wyświetla formularz kontaktowy z opcją
    // przypomnienia hasła.
    // ==========================================
    public function PokazKontakt() {
        echo '<form action="contact.php" method="POST" class="contact-form">
                <label for="name">Imię:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">Wiadomość:</label>
                <textarea id="message" name="message" required></textarea>
                
                <button type="submit" name="send">Wyślij</button>
              </form>
              <a href="contact.php?action=przypomnij" class="reminder-link">Przypomnij hasło</a>';
    }

    // ==========================================
    // Metoda: WyslijMailKontakt
    // Wysyła wiadomość e-mail z danymi z
    // formularza kontaktowego.
    // ==========================================
    public function WyslijMailKontakt() {
        // Sprawdzenie, czy formularz został przesłany metodą POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
            $to = "admin@example.com";
            $subject = "Wiadomość z formularza kontaktowego";
            // Budowanie treści wiadomości z danych przesłanych w formularzu
            $message = "Imię: " . htmlspecialchars($_POST['name']) . "\n" .
                       "E-mail: " . htmlspecialchars($_POST['email']) . "\n" .
                       "Wiadomość: \n" . htmlspecialchars($_POST['message']);
            $headers = "From: no-reply@example.com\r\n";

            // Wysyłanie e-maila i obsługa wyników
            if (mail($to, $subject, $message, $headers)) {
                echo "Wiadomość została wysłana pomyślnie!";
            } else {
                echo "Wystąpił błąd podczas wysyłania wiadomości.";
            }
        }
    }

    // ==========================================
    // Metoda: PrzypomnijHaslo
    // Wysyła przypomnienie hasła na wskazany e-mail.
    // ==========================================
    public function PrzypomnijHaslo() {
        $to = "admin@example.com";
        $subject = "Przypomnienie hasła";
        $password = "Twoje aktualne hasło to: haslo123"; // Przykładowe hasło
        $headers = "From: no-reply@example.com\r\n";

        // Wysyłanie e-maila z hasłem i obsługa wyników
        if (mail($to, $subject, $password, $headers)) {
            echo "Hasło zostało wysłane na e-mail!";
        } else {
            echo "Wystąpił błąd podczas wysyłania hasła.";
        }
    }
}

// ==========================================
// Logika sterująca
// ==========================================
$contact = new Contact();

// Sprawdzanie, czy użytkownik przesłał formularz lub wybrał opcję przypomnienia hasła
if (isset($_POST['send'])) {
    // Obsługa wysyłania formularza kontaktowego
    $contact->WyslijMailKontakt();
} elseif (isset($_GET['action']) && $_GET['action'] == 'przypomnij') {
    // Obsługa przypomnienia hasła
    $contact->PrzypomnijHaslo();
} else {
    // Wyświetlanie formularza kontaktowego
    $contact->PokazKontakt();
}
?>
