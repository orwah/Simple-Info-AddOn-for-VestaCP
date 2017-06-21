<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: /list/info/");
} else {
    header("Location: /login/");
}
?>
