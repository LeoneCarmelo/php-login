<?php
class Event {
    public $title;
    public $attendees;
    public $description;

    public function __construct($title, $attendees, $description) {
        $this->title = $title;
        $this->attendees = $attendees;
        $this->description = $description;
    }
}


