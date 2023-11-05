<?php


class EventController {
    private $events = [];

    public function addEvent($event) {
        // Check if the user has admin privileges (you need to implement this logic)
        if ($this->isAdmin()) {
            $this->events[] = $event;
            $query = "insert into eventi (attendees, nome_evento, description) values ('$event->attendees','$event->title', '$event->description')";
            include("./server.php");
            mysqli_query($connection, $query);
            header("Location: admin-view.php");
        } else {
            echo "You do not have permission to add events.";
        }
    }

    public function updateEvent($currentTitle, $newTitle, $newAttendees, $newDescription) {
        // Check if the user has admin privileges (you need to implement this logic)
        if ($this->isAdmin()) {
            include("./server.php");
            $query = "UPDATE eventi SET nome_evento = '$newTitle', attendees = '$newAttendees', description = '$newDescription' WHERE nome_evento = '$currentTitle'";
            mysqli_query($connection, $query);
            header("Location: admin-view.php");
        } else {
            echo "You do not have permission to edit this event or the event does not exist.";
        }
    }

    public function deleteEventByTitle($title) {
        // Check if the user has admin privileges (you need to implement this logic)
        if ($this->isAdmin()) {
            $query = "delete from eventi where nome_evento = '$title'";
            include("./server.php");
            mysqli_query($connection, $query);
            header("Location: admin-view.php");
        } else {
            echo "You do not have permission to delete this event or the event does not exist.";
        }
    }

    private function isAdmin() {
        // Implement logic to check if the user is an admin
        // You may use sessions or another authentication mechanism
        //var_dump($_SESSION["nome"]);
        //die;
        if($_SESSION["nome"] === "Admin"){
            return true; // Change this logic as per your requirements
        }
    }

    public function getEvents() {
        return $this->events;
    }
}
