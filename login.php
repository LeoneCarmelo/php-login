<?php
session_start();
if (isset($_SESSION['success_message'])) {
    $message_reset = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Remove the message from the session to prevent it from being displayed again
}
include("server.php");
include("functions.php");

//if the user sent the request
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //assign user's inputs to variables
    $email = $_POST["email"];
    $naked_password = $_POST["password"];
    //checking if they are empty
    if (!empty($email) && !empty($naked_password)) {
        //Read from database
        $query = "select * from utenti where email = '$email' limit 1";
        /* execute the query that will compare if the email the user sent, is the same of the email he saved previously to the db */
        //save everything into a variable
        $result = mysqli_query($connection, $query);
        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                //store the hashed password from the database in a variable
                $hashed_pass = $user_data['password'];
                //check if the password from the db is the same as the password input
                //if ($user_data['password'] === $password) {
                if (password_verify($naked_password, $hashed_pass)) {
                    //assign the user name and email to the Session and redirect to index.php
                    $_SESSION['nome'] = $user_data['nome'];
                    $_SESSION['email'] = $user_data['email'];
                    if ($_SESSION['nome'] === 'Admin') {
                        $_SERVER['PHP_AUTH_USER'] = 'Admin';
                    }
                    if ($_SERVER['PHP_AUTH_USER'] === 'Admin') {
                        header('Location: admin-view.php');
                    } else {
                        header('Location: index.php');
                    }
                    /* if($_SESSION['nome'] === 'Admin'){
                    } else{
                    } */
                } else {
                    echo 'Wrong';
                }
                //}
            }
        }
        echo "Wrong informations.";
    } else {
        echo "Wrong informations.";
    }
}
include("head_page.php");
?>

<body class="login-signup">
    <header>
        <img src="./assets/img/logo.svg" alt="logo">
    </header>
    <main>
        <?php if ($message_reset) : ?>
            <p><?php echo $message_reset; ?></p>
        <?php endif; ?>
        <h3>Hai già un account?</h3>
        <form action="" method="post" class="login form">
            <label for="email">Inserisci la tua email
            </label>
            <input type="email" name="email" placeholder="name@example.com" required>
            <label for="password">Inserisci la tua password
                <i class="fa-solid fa-eye" style="color: #0057ff;"></i>
            </label>
            <input type="password" name="password" placeholder="Scrivila qui" required>
            <input type="submit" value="ACCEDI">
            <a href="signup.php">Non hai ancora un profilo? <span>Registrati</span></a>
            <a href="forgot_password.php">Password dimenticata?</a>
        </form>
    </main>
    <?php include("graphic.php") ?>
    <script src="./assets/js/script.js"></script>
</body>

</html>