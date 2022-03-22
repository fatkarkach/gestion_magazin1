<?php
session_start();
// Destruction de toutes les sessions
if(session_destroy())
{
// Redirection vers la page d'accueil
header("Location: login.php");
}
?>