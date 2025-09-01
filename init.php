<?php
session_start();
header('Content-Type: application/json');

// if the session is just started, fill it with default values
if(!isset($_SESSION['sessionId'])) {
    $_SESSION['sessionId'] = session_id();
    $_SESSION['balance'] = 10;
    $_SESSION['fruits'] = ['?','?','?'];
    $_SESSION['note'] = 'NEW SESSION STARTED, you got 10 credits';
}

// return the session data to frontend
echo json_encode($_SESSION);