<?php
// ✅ Server lo unna IP
echo $_SERVER['SERVER_ADDR']; 

// If you want external/public IP instead of local private IP:
// echo file_get_contents("https://api.ipify.org");
?>
