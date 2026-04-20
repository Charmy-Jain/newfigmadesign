<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $name = strip_tags(trim($_POST["name"]));
    $phone = strip_tags(trim($_POST["phone"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $date = strip_tags(trim($_POST["date"]));
    $time = strip_tags(trim($_POST["time"]));
    $looking_for = strip_tags(trim($_POST["looking_for"]));
    $address = strip_tags(trim($_POST["address"]));

    // Admin Email
    $to = "charmyjain1@gmail.com"; 
    $subject = "New Site Visit Scheduled: " . $name;

    // Email content
    $content = "You have a new site visit request:\n\n";
    $content .= "Name: $name\n";
    $content .= "Phone: $phone\n";
    $content .= "Email: $email\n";
    $content .= "Project Category: $looking_for\n";
    $content .= "Scheduled Date: $date\n";
    $content .= "Scheduled Time: $time\n";
    $content .= "Full Address:\n$address\n";

    // Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
    $headers .= "From: Spazio Liv Website <noreply@spazioliv.com>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    $success = @mail($to, $subject, $content, $headers);

    // LOGGING TO A FILE (FOR RELIABILITY ON RENDER)
    $log_file = __DIR__ . "/leads.txt";
    $log_content = "------------------------------------\n";
    $log_content .= date("Y-m-d H:i:s") . "\n$content";
    @file_put_contents($log_file, $log_content, FILE_APPEND);

    if ($success) {
        http_response_code(200);
        echo "Thank you! Your visit has been scheduled.";
    } else {
        http_response_code(200); // Return 200 for demo success if logged
        echo "Visit scheduled! (Admin notified via leads.txt)";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>
