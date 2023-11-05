<?php
session_start();
include("server.php");
include("functions.php");
include("./Admin/event_controller.php");
include("./Admin/event_model.php");

$events = get_events_for_admin($connection);
//check if the user is admin
if($_SESSION['nome'] != 'Admin') {
    header('Location: not-found.php');
} 

if (isset($_POST['addEvent'])) {
    $title = $_POST['title'];
    $attendees = $_POST['attendees'];
    $description = $_POST['description'];
    if (!empty($title) && !empty($attendees) && !empty($description)) {
        $event = new Event($title, $attendees, $description);
        $eventController = new EventController();
        $eventController->addEvent($event);
    }
}
if (isset($_POST['deleteEvent'])) {
    $title = $_POST['deleteTitle'];
    if (!empty($title)) {
        $eventController = new EventController();
        $eventController->deleteEventByTitle($title);
    }
}
if (isset($_POST['updateEvent'])) {
    $oldTitle = $_POST["old_title"];
    $title = $_POST['title'];
    $attendees = $_POST['attendees'];
    $description = $_POST['description'];

    // Check if all fields are filled
    if (!empty($title) && !empty($attendees) && !empty($description)) {
        $eventController = new EventController();

        // Update the event in the EventController
        $eventController->updateEvent($oldTitle, $title, $attendees, $description);

    } 
}



?>

<?php include("head_page.php"); ?>

<body class="login-signup index">
    <header>
        <img src="./assets/img/logo.svg" alt="logo">
        <h3 id="admin">Admin</h3>
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <a href="index.php">Vedi i tuoi eventi</a>
        <div class="row">
            <div class="table-responsive">
                <h3>Eventi</h3>
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Titolo</th>
                            <th scope="col">Partecipanti</th>
                            <th scope="col">Descrizione</th>
                            <th scope="col">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                        <?php foreach ($events as $event) : ?>
                            <tr class="">
                                <td scope="row">
                                    <?php echo $event["nome_evento"]; ?>
                                </td>
                                <td title="<?php echo $event["attendees"]; ?>">
                                    <?php echo $event["attendees"]; ?>
                                </td>
                                <td>
                                    <?php echo $event["description"]; ?>
                                </td>
                                <td class="d-flex">
                                    <input type="button" value="Modifica">
                                    <form action="" method="post">
                                        <div class="edit-modal">
                                            <div class="modal-body">
                                                <h3>Modifica</h3>
                                                <input type="hidden" name="old_title" value="<?php echo $event["nome_evento"]?>">
                                                <input type="text" name="title" value="<?php echo $event["nome_evento"]?>" required>
                                                <input type="text" name="attendees" value="<?php echo $event["attendees"]?>" required>
                                                <input type="text" name="description" value="<?php echo $event["description"]?>" required>
                                                <div class="body-form">
                                                    <input type="button" value="back">
                                                    <input type="submit" name="updateEvent" value="Aggiorna">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <input type="button" value="Cancella">
                                    <form action="" method="post">
                                        <div class="modal">
                                            <div class="modal-body">
                                                <h3>Sei sicuro di eliminare <?php echo $event["nome_evento"]; ?></h3>
                                                <form action="" method="post">
                                                    <input type="hidden" name="deleteTitle" value="<?php echo $event["nome_evento"]; ?>">
                                                    <input type="submit" value="SI" name="deleteEvent">
                                                    <input type="button" value="INDIETRO">
                                                </form>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <form method="POST" class="form admin">
                <h3>Aggiungi Evento</h3>
                <div class="body-form">
                    <input type="text" placeholder="Inserisci titolo" name="title">
                    <input type="text" placeholder="Aggiungi partecipanti" name="attendees">
                </div>
                <div class="description">
                    <textarea type="text" placeholder="Descrivi l'evento" name="description"></textarea>
                </div>
                <input type="submit" value="Aggiungi" name="addEvent">
            </form>
        </div>
    </main>
    <?php include('graphic.php'); ?>
    <script src="./assets/js/admin.js"></script>
</body>

</html>