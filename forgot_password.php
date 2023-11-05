<?php 
session_start();

if (isset($_SESSION['message_reset'])) {
    $message_reset = $_SESSION['message_reset'];
    unset($_SESSION['message_reset']); // Remove the message from the session to prevent it from being displayed again
}
?>
<?php include("head_page.php"); ?>

<body class="login-signup">
<?php if(!empty($message_reset)) :?>
            <p><?php echo $message_reset; ?></p>
        <?php endif; ?>
    <h3>Reimposta la tua password</h3>
    <form action="send_password_reset.php" class="form" method="POST">
        <label for="email">
            Inserisci la tua email
        </label>
        <input type="email" name="email" required>
        <input type="submit" value="RESET">
    </form>
    <?php include("graphic.php"); ?>
    <script src="./assets/js/script.js"></script>
</body>

</html>