<?php

class Event
{
    public $title;
    public $attendees;
    public $date;

    public function __construct($title, $attendees, $date)
    {
        $this->title = $title;
        $this->attendees = $attendees;
        $this->date = $date;
    }
}