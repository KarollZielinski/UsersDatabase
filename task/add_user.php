<?php
function generateUniqueId() {
    $json_file = "dataset/users.json";
    
    // Odczytaj zawartość pliku JSON
    $json_data = file_get_contents($json_file);
    $users = json_decode($json_data, true);

    // Sprawdź, czy są już użytkownicy w pliku JSON
    if (!empty($users)) {
        // Pobierz ostatni ID użytkownika
        $lastUserId = end($users)['id'];
        // Wygeneruj nowe ID, zwiększając o 1
        $newUserId = $lastUserId + 1;
    } else {
        // Jeśli nie ma żadnych użytkowników, ustaw ID na 1
        $newUserId = 1;
    }

    // Zwróć wygenerowane ID
    return $newUserId;
}

function addToJSON($userData) {
    $json_file = "dataset/users.json";
    
    // Odczytaj zawartość pliku JSON
    $json_data = file_get_contents($json_file);
    $users = json_decode($json_data, true);

    // Dodaj nowego użytkownika do tablicy
    $users[] = $userData;
    
    // Zapisz zmodyfikowaną tablicę z powrotem do pliku JSON
    file_put_contents($json_file, json_encode($users, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz dane nowego użytkownika z żądania POST
    $newUser = array(
        'id' => generateUniqueId(), // Wywołaj funkcję do generowania unikalnego ID
        'name' => $_POST['name'],
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'address' => array(
            'street' => $_POST['street'],
            'suite' => $_POST['suite'],
            'city' => $_POST['city'],
            'zipcode' => $_POST['zipcode'],
        ),
        'phone' => $_POST['phone'],
        'company' => array(
            'name' => $_POST['company']
        )
    );

    // Dodaj nowego użytkownika do pliku JSON
    addToJSON($newUser);

    // Przekieruj użytkownika na stronę główną lub wyświetl potwierdzenie dodania użytkownika
    header("Location: index.php");
    exit();
}
?>
