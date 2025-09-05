<?php
session_name("HUB_SESSION");
session_start();
session_destroy();
header("location:index.php");
exit;
?>