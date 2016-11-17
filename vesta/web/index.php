<?php
session_start();
if (isset($_SESSION['user'])) {
	if($_SESSION['user'] == 'admin')
    header("Location: /list/user/");
else
 header("Location: /list/info/");	
} else {
    header("Location: /login/");
}
