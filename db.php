<?php
$conn = new mysqli('localhost', 'root', '', 'portapage');

if (!$conn->error) {
  // echo "It worked!";
} else {
  echo "The database connection failed.";
}
?>
