<?php
session_start(); // Access to session
session_unset(); // Clears session variables
session_destroy(); // Destroys session

echo "Logged out";
?>
