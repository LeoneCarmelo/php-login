<?php
session_start();
include("server.php");
include("functions.php");
$user_data = check_login($connection);
$events = get_events_for_user($connection);



?>
<?php include("head_page.php"); ?>

<body class="login-signup index">
    <header>
        <img src="./assets/img/logo.svg" alt="logo">
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <?php if ($_SESSION['nome'] === 'Admin') : ?>
            <a href="admin-view.php">Vai alla dashboard</a>
        <?php endif; ?>
        <h3>Ciao <?php echo $user_data["nome"] . " " . $user_data["cognome"] ?>, ecco i tuoi eventi</h3>
        <ul class="container">
            <?php if (is_string($events)) : ?>
                <li><?php echo $events ?></li>
            <?php else : ?>
                <?php foreach ($events as $event) : ?>
                    <li class="events">
                        <h4><?php echo $event["nome_evento"] ?></h4>
                        <p><?php echo $event["data_evento"] ?></p>
                        <input type="submit" value="JOIN">
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </main>
    <?php include("graphic.php") ?>
    <script src="./assets/js/script.js"></script>
</body>

</html>