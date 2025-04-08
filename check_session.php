<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "unauthorized";
} else {
    echo $_SESSION['username'];
}
?>