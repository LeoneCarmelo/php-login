<?php
session_start();

include("server.php");
include("functions.php");

//if the user sent the request
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //save users input to variables
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    //checking if they are empty
    if (!empty($first_name) && $first_name != 'Admin' && !empty($last_name) && !empty($email) && !empty($password)) {
        //hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        //save to database
        $query = "insert into utenti (nome, cognome, email, password) values ('$first_name','$last_name', '$email','$hashed_password')";
        //execute the query
        mysqli_query($connection, $query);
        //redirect to login view
        header('Location: login.php');
        die;
    } else {
        $error =  "Enter some valid informations. You can't set the name to Admin";
    }
}

?>
<?php include("head_page.php"); ?>
<body class="login-signup">
    <header>
        <img src="./assets/img/logo.svg" alt="logo">
    </header>
    <main>
        <h3>Crea il tuo account</h3>
        <?php if($error) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post" class="signup form">
            <label for="name">Inserisci il nome</label>
            <input required type="text" placeholder="Mario" name="first_name">
            <label for="name">Inserisci il cognome</label>
            <input required type="text" placeholder="Rossi" name="last_name">
            <label for="email">Inserisci la tua email</label>
            <input required type="email" name="email" placeholder="name@example.com">
            <label for="password">Inserisci la tua password
                <i class="fa-solid fa-eye" style="color: #0057ff;"></i>
            </label>
            <input required type="password" name="password" placeholder="Scrivila qui">
            <input required type="submit" value="REGISTRATI">
            <a href="login.php">Hai gia un account? <span>Accedi</span></a>
        </form>
    </main>
    <?php include("graphic.php") ?>
    <script src="./assets/js/script.js"></script>
</body>

</html>