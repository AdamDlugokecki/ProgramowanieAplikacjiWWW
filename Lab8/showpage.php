<?php
function PokazPodstrone($pdo, $page) {
    $stmt = $pdo->prepare("SELECT page_content FROM page_list WHERE page_title = :page AND status = 1 LIMIT 1");
    $stmt->execute(['page' => $page]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['page_content'] ?? null; // Zwraca treść strony lub null, jeśli brak
}
?>
