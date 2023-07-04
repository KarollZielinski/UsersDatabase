<?php
function removeFromJSON($userId) {
    $json_file = "dataset/users.json";
    
    // read json
    $json_data = file_get_contents($json_file);
    $users = json_decode($json_data, true);

    //  userId users id
    $index = null;
    foreach ($users as $key => $user) {
        if ($user['id'] == $userId) {
            $index = $key;
            break;
        }
    }

    // if found remove 
    if ($index !== null) {
        unset($users[$index]);
        
        // save new array
        file_put_contents($json_file, json_encode($users, JSON_PRETTY_PRINT));
    }
}

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    removeFromJSON($userId);
    
}
?>