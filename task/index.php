<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users</title>
    <link rel="stylesheet" href="styles.css"> 
</head>

<body>
    <main>
        <h2>Users</h2>
    
        <table>
            <!-- The table header -->
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Company</th>
                <th>Actions</th>
            </tr>
    
            <!-- Generate table rows based on users data -->
            <?php
            $json_data = file_get_contents("dataset/users.json");
            $users = json_decode($json_data, true);
    
            // Function to remove a user from JSON
            function removeFromJSON($userId) {
                $json_file = "dataset/users.json";
                
                // Read JSON file
                $json_data = file_get_contents($json_file);
                $users = json_decode($json_data, true);
            
                // Check if user with given userId exists
                $index = null;
                foreach ($users as $key => $user) {
                    if ($user['id'] == $userId) {
                        $index = $key;
                        break;
                    }
                }
            
                // If user found, remove from array
                if ($index !== null) {
                    unset($users[$index]);
                    
                    // Save modified array back to JSON file
                    file_put_contents($json_file, json_encode($users, JSON_PRETTY_PRINT));
                }
            }
    
            if (count($users) != 0) {
                foreach ($users as $user) {
                    $street = $user['address']['street'];
                    $zipcode = $user['address']['zipcode'];
                    $city = $user['address']['city'];
                    $cname = $user['company']['name'];
    
                    ?>
                    <tr>
                        <td><?php echo $user['name']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $street, $zipcode, $city; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td><?php echo $cname; ?></td>
                        <td>
                            <!-- Button to remove the user -->
                            <button onclick="removeUser(<?php echo $user['id']; ?>)" type="button" class="button" value="Remove"> Remove </button>
                        </td>
                    </tr>
    
                    <?php
                }
            } else {
                // Show message when there are no users
            }
            ?>
    
        </table>
    
        <!-- Form to add a new user -->
        <form action="add_user.php" method="post" class="form" id="addUserForm">
        <h3>Add User</h3>
            <label for="name">Name:</label>
            <input type="text" name="name" required><br>
    
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
    
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
    
            <label for="street">Street:</label>
            <input type="text" name="street" required><br>
    
            <label for="suite">Suite:</label>
            <input type="text" name="suite" required><br>
    
            <label for="city">City:</label>
            <input type="text" name="city" required><br>
    
            <label for="zipcode">Zipcode:</label>
            <input type="text" name="zipcode" required><br>
    
            <label for="phone">Phone:</label>
            <input type="text" name="phone" required><br>
    
            <label for="company">Company:</label>
            <input type="text" name="company" required><br>
    
            <!-- Button to submit the form and add a new user -->
            <button type="submit" class="button" value="Create">Create</button>
        </form>
    
        <script>
            // Function to remove a user
            function removeUser(userId) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        window.location.reload();
                    }
                };
                xhttp.open("GET", "remove_user.php?userId=" + userId, true);
                xhttp.send();
            }
    
            // Function to add a user
            function addUser() {
                var form = document.getElementById("addUserForm");
                var formData = new FormData(form);
    
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var newUserId = this.responseText;
                        // Increment the newUserId by 1
                        newUserId += 1;
                        window.location.reload();
                    }
                };
                xhttp.open("POST", "add_user.php", true);
                xhttp.send(formData);
            }
        </script>
    </main>
</body>
</html>