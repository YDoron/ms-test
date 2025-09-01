<?php
session_start();
if(!isset($_SESSION['sessionId'])) {
    echo 'Hey, you cant cash out without playing first!';
    exit;
}

$handle = fopen('cashouts.csv', 'a');
fputcsv($handle, [session_id(), $_SESSION['balance']]);
fclose($handle);

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

?>

Cashed out successfully!<br>
Your unique session ID and balance saved to CSV file<br>
Contact our support to claim the reward!