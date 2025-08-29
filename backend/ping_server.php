<?php
if (isset($_GET['target'])) {
    // Only allow domain names / IP addresses
    $target = $_GET['target'];

    // Validate hostname / IP (basic check)
    if (!filter_var($target, FILTER_VALIDATE_IP) && !preg_match('/^[a-zA-Z0-9.-]+$/', $target)) {
        die("Invalid target.");
    }

    // Detect OS
    $os = strtoupper(substr(PHP_OS, 0, 3));
    if ($os === 'WIN') {
        $cmd = "ping -n 4 " . escapeshellarg($target);
    } else {
        $cmd = "ping -c 4 " . escapeshellarg($target);
    }

    // Run command safely
    $ping = shell_exec($cmd);

    // Show output
    echo "<pre>" . htmlspecialchars($ping) . "</pre>";
} else {
    echo "No target provided.";
}
?>
