<?php
if (isset($_GET['target'])) {
    $target = escapeshellcmd($_GET['target']);
    $ping = shell_exec("ping -c 4 $target");
    echo nl2br($ping);
} else {
    echo "No target provided.";
}
?>
