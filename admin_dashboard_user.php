<?php
// Include the database connection file
include('db_connection.php');
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["nom_prof"];
    $password = $_POST["password"];

    // Hash the password (for security)

    // Insert data into the "user" table
    $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $password); // Bind the parameters

    if ($stmt->execute()) {
        // Insertion successful, you can redirect or display a success message here
        header("Location: admin_dashboard_user.php"); // Redirect to a success page
        exit();
    } else {
        // Insertion failed, you can redirect or display an error message here
        header("Location: admin_dashboard_user.php"); // Redirect to an error page
        exit();
    }

    $stmt->close();
}

// Fetch data from the database
$sql = "SELECT * FROM user";
$result = $mysqli->query($sql);

// Initialize an array to store the fetched data
$studentData = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add each row of data to the $studentData array
        $studentData[] = $row;
    }
}

// fetch data


// Close the database connection
$mysqli->close();

// Now, you can use the $mysqli object for database operations in this page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>User Dashboard</title>
    <style>
        .leftSide {
            background-color: #ee1c25;
        }

        .item-selected {
            background-color: white;
            border-radius: 30px;
            padding: 10px;
            color: #ee1c25;
        }

        .item {
            border-radius: 30px;
            padding: 10px;
            color: white;
        }

        a {
            color: inherit !important;
            /* Inherit the color from the parent element */
            text-decoration: none !important;
            /* Remove underline */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-md-3 leftSide">
                <h5 class="text-white mt-3">Bonjour Anas</h5>
                <div class="items mt-5">
                    <div class="item text-center mt-3 d-flex align-items-startr">
                        <img src="./images/dashboard-white.png" alt="dashboard" />
                        <span class="ml-3">Gestion des Etudiant</span>
                    </div>
                    <div class="item text-center mt-3 d-flex align-items-start">
                        <img src="./images/dashboard-white.png" alt="dashboard" />
                        <span class="ml-3"><a href="./StudentNotification.html">Gestion des
                                professeur</a></span>
                    </div>
                    <div class="item-selected text-center mt-3 d-flex align-items-start">
                        <img src="./images/dashboard-blue.png" alt="dashboard" />
                        <span class="ml-3"><a class="" href="./StudentChat.html">Gestion des
                                utilisateur</a></span>
                    </div>
                    <div class="item text-center mt-3 d-flex align-items-start">
                        <img src="./images/logout.png" alt="dashboard" />
                        <span class="ml-3">Se deconnecter</span>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <h5 class="mt-5">Gestion des utilisateur</h5>
                <button class="btn btn-info" data-toggle="modal" data-target="#myModal">
                    Ajouter un user
                </button>

                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Ajouter un utilisateur</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <form method="POST" action="admin_dashboard_user.php">
                                    <!-- Replace "insert_professor.php" with the actual PHP script that will handle the form submission -->
                                    <div class="form-group">
                                        <label for="nomEtudiant">login</label>
                                        <input type="text" class="form-control" id="nomEtudiant" name="nom_prof"
                                            placeholder="Entrez le nom du professeur" />
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Mot de passe:</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Entrez le mot de passe" />
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </form>


                            </div>
                            <!-- Modal footer -->

                        </div>
                    </div>
                </div>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">id</th>

                            <th scope="col">login</th>
                            <th scope="col">mot de passe</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <?php
                    // Loop through the $studentData array to display the data in the table
                    foreach ($studentData as $student) {
                        echo "<tr>";
                        echo "<td>" . $student["id"] . "</td>";
                        echo "<td>" . $student["username"] . "</td>";
                        echo "<td>" . $student["password"] . "</td>";
                        echo '<td>
            <a href="deleteUser.php?user_id=' . $student["id"] . '" class="btn btn-danger">supprimer</a>
        </td>';
                        echo "</tr>";
                    }

                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>