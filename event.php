<?php

class event {
 private string $nome_evento;
 private string $attendees;
 private string $data_evento;

 public function __construct($nome_evento, $attendees, $data_evento) {
  $this -> setName($nome_evento);
  $this -> setAttendees($attendees);
  $this -> setDate($data_evento);
 }

 public function setName($nome_evento) {
  if (strlen($nome_evento) < 1) {
   throw new Exception("Name must must have at least 1 characters");
  }
  
  $this -> nome_evento = $nome_evento;
 }
 
 public function getName() {
  return $this -> nome_evento;
 }

 public function setAttendees($attendees) {  
  $this -> attendees = $attendees;
 }
 
 public function getAttendees() {
  return $this -> attendees;
 }

  public function setDate($data_evento) {  
  $this -> data_evento = $data_evento;
 }
 
 public function getDate() {
  return $this -> data_evento;
 }

}

?>