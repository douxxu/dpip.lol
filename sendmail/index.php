<?php
include '../utils/secrets.php';

$token = $_GET['token'] ?? null;
$event = $_GET['event'] ?? null;
$subdomain = $_GET['subdomain'] ?? null;

if ($token !== TOKEN) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if (!in_array($event, ['add', 'remove'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid event']);
    exit;
}

$htmlFile = ($event === 'add') ? 'add.html' : 'remove.html';

$htmlContent = file_get_contents($htmlFile);
if ($htmlContent === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to read HTML file']);
    exit;
}

$htmlContent = str_replace('VALU£', $subdomain, $htmlContent);

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$result = $mysqli->query("SELECT email FROM emails");
if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed']);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $to = $row['email'];
    
    $personalizedHtmlContent = str_replace('£MAIL', $to, $htmlContent);

    $subject = 'DPIP.lol update - Automatic message';
    $headers = 'Content-Type: text/html; charset=UTF-8' . "\r\n";

    if (!mail($to, $subject, $personalizedHtmlContent, $headers)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to send email to ' . $to]);
        exit;
    }
}

$mysqli->close();

echo json_encode(['success' => 'Emails sent successfully']);
?>
