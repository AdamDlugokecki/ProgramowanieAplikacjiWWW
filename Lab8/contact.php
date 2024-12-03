<?php
class Contact {
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

    public function WyslijMailKontakt() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
            $to = "admin@example.com";
            $subject = "Wiadomość z formularza kontaktowego";
            $message = "Imię: " . htmlspecialchars($_POST['name']) . "\n" .
                       "E-mail: " . htmlspecialchars($_POST['email']) . "\n" .
                       "Wiadomość: \n" . htmlspecialchars($_POST['message']);
            $headers = "From: no-reply@example.com\r\n";

            if (mail($to, $subject, $message, $headers)) {
                echo "Wiadomość została wysłana pomyślnie!";
            } else {
                echo "Wystąpił błąd podczas wysyłania wiadomości.";
            }
        }
    }

    public function PrzypomnijHaslo() {
        $to = "admin@example.com";
        $subject = "Przypomnienie hasła";
        $password = "Twoje aktualne hasło to: haslo123";
        $headers = "From: no-reply@example.com\r\n";

        if (mail($to, $subject, $password, $headers)) {
            echo "Hasło zostało wysłane na e-mail!";
        } else {
            echo "Wystąpił błąd podczas wysyłania hasła.";
        }
    }
}

$contact = new Contact();

if (isset($_POST['send'])) {
    $contact->WyslijMailKontakt();
} elseif (isset($_GET['action']) && $_GET['action'] == 'przypomnij') {
    $contact->PrzypomnijHaslo();
} else {
    $contact->PokazKontakt();
}
?>
