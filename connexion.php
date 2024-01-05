<?php
session_start();

// Définissez les informations de connexion à la base de données
$serveur = "127.0.0.1:3306";
$nom_utilisateur = "u559440517__wiss";
$mot_de_passe = "Themigi69-";
$nom_base_de_donnees = "u559440517_wissem";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Connexion à la base de données
    $mysqli = new mysqli($serveur, $nom_utilisateur, $mot_de_passe, $nom_base_de_donnees);

    if ($mysqli->connect_error) {
        die("Erreur de connexion à la base de données: " . $mysqli->connect_error);
    }

    // Vérifiez les informations de connexion depuis votre base de données
    // Remplacez 'votre_table_utilisateurs' par le nom de votre table d'utilisateurs
    $query = "SELECT * FROM votre_table_utilisateurs WHERE username = ? AND password = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // L'authentification a réussi, générez un token d'authentification et stockez-le en session
        $_SESSION["username"] = $username;
        header("Location: page_accueil.php");
        exit();
    } else {
        // L'authentification a échoué, affichez un message d'erreur
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }

    $stmt->close();
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<?php
if (isset($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="submit">Se Connecter</button>
</form>

</body>
</html>
