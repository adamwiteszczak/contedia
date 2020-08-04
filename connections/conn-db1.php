<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

try {
  $mysqli = new mysqli("localhost", "", "", "", 3306);
  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    die();
  }else{
    echo "<!-- Connection Made Successfully -->";
  }
} catch(PDOException $e) {
  $mysqli = NULL;
  echo "Connection failed: " . $e->getMessage();
}