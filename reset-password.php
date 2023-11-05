<?php
session_start();
include('./functions.php');
include('./server.php');

if (isset($_SESSION['message_reset'])) {
    $message_reset = $_SESSION['message_reset'];
    unset($_SESSION['message_reset']); // Remove the message from the session to prevent it from being displayed again
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (!empty($email) && !empty($password) && !empty($confirm_password)) {
        //Check if the email exist in the db
        $query_for_email = "SELECT * FROM utenti WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($connection, $query_for_email);
        if ($result && mysqli_num_rows($result) > 0) { {
                //if exist let's check the password are the same
                if (check_password($password, $confirm_password)) {
                    //if yes then hash password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    //get the date the token was generated
                    $query_for_date = "SELECT reset_token_expires_at FROM utenti WHERE email = '$email'";
                    $result_of_date = mysqli_query($connection, $query_for_date);
                    if ($result_of_date && mysqli_num_rows($result_of_date) > 0) {
                        //get the date from the db
                        $db_date = mysqli_fetch_assoc($result_of_date)['reset_token_expires_at'];
                        //set the exact timezone and get the real date
                        date_default_timezone_set('Europe/Amsterdam');
                        $real_date = date("Y-m-d H:i:s", time());
                        //convert the date in timestamps
                        $timestamp_real_date = strtotime($real_date);
                        $timestamp_db_date = strtotime($db_date);
                        if ($timestamp_db_date && $timestamp_real_date) {
                            //calculate the difference in seconds
                            $time_difference = abs($timestamp_real_date - $timestamp_db_date);
                            //calculate 30 minutes in seconds
                            if ($time_difference <= 1800) {
                                //you can now change the password
                                //update the database with the new value
                                $query_for_password = "UPDATE utenti SET password = '$hashed_password' WHERE email = '$email'";
                                //execute the query
                                mysqli_query($connection, $query_for_password);
                                //send success message
                                //save a message to the SESSION
                                $_SESSION['message_reset'] = 'La password è stata cambiata correttamente.';
                                // Redirect to login views if the use is not logged in
                                header("Location: login.php");
                            } else {
                                //ask again your password
                                $_SESSION['message_reset'] = 'Il link è scaduto. Richiedi una nuova password.';
                                //redirect to this page
                                header('Location: forgot_password.php');
                            }
                        }
                    }
                } else {
                    // message for wrong password
                    $_SESSION['message_reset'] = 'Le password inserite non coincidono.';
                    //redirect to the same page to refresh and see the message
                    header('Location: reset-password.php');
                }
            }
        } else {
            //message for wrong email
            $_SESSION['message_reset'] = 'La tua email non è stata trovata o è sbagliata. Prova a riscriverla o vai alla pagina di registrazione per creare un nuovo account.';
            //redirect to the same page to refresh and see the message
            header('Location: reset-password.php');
        }
    } else {
        //message for the unfilled field of the form
        $_SESSION['message_reset'] = 'Compila tutti i campi.';
        //redirect to the same page to refresh and see the message
        header('Location: reset-password.php');
    }
}


?>


<?php include("./head_page.php"); ?>

<body class="login-signup index">
    <header>
        <img src="./assets/img/logo.svg" alt="logo">
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <?php if(!empty($message_reset)) :?>
            <p><?php echo $message_reset; ?></p>
        <?php endif; ?>
        <h3>Resetta la tua password</h3>
        <form action="" method="post" class="login form">
            <label for="email">Inserisci la tua email
            </label>
            <input type="email" name="email" placeholder="name@example.com" required>
            <label for="password">Inserisci la tua nuova password
                <i class="fa-solid fa-eye" style="color: #0057ff;"></i>
            </label>
            <input type="password" name="password" placeholder="Scrivila qui" required>
            <label for="confirm_password">Conferma password
            </label>
            <input type="password" name="confirm_password" placeholder="Scrivila qui" required>
            <input type="submit" value="INVIA" name="password_reset">
        </form>
    </main>
    <?php include("graphic.php") ?>
    <script src="./assets/js/script.js"></script>
</body>

</html>