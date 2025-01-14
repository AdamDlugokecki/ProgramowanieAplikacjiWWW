<?php
// ==========================================
// Funkcja: PokazPodstrone
// Opis: Pobiera zawartość podstrony z bazy danych na podstawie jej tytułu.
// Parametry:
//  - $pdo: obiekt PDO do komunikacji z bazą danych.
//  - $page: tytuł podstrony, której zawartość ma zostać pobrana.
// Zwraca: Treść podstrony (string) lub null, jeśli podstrona nie istnieje.
// ==========================================
function PokazPodstrone($pdo, $page) {
    // Przygotowanie zapytania SQL do pobrania zawartości podstrony
    $stmt = $pdo->prepare("
        SELECT page_content 
        FROM page_list 
        WHERE page_title = :page 
          AND status = 1 
        LIMIT 1
    ");
    
    // Wykonanie zapytania z podanym tytułem podstrony
    $stmt->execute(['page' => $page]);
    
    // Pobranie wyniku zapytania
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Zwraca treść strony lub null, jeśli brak wyników
    return $result['page_content'] ?? null;
}
?>
