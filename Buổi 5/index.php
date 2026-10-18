<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: product_list.php");
} else {
    header("Location: login.php");
}
exit;
?>