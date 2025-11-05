<?php
$file = 'code.txt';
$msg = '';
$current = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new = $_POST['num'] ?? '';
    file_put_contents($file, $new);
    $saved = trim(@file_get_contents($file));
    if ($saved === trim($new)) {
        $msg = "✅ Updated successfully!";
    } else {
        $msg = "❌ Update failed!";
    }
    $current = $saved;
} else {
    if (file_exists($file)) $current = trim(file_get_contents($file));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Update</title>
<style>
  body {
    margin: 0;
    font-family: sans-serif;
    background: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  form {
    width: 90%;
    max-width: 360px;
    background: #fff;
    padding: 16px;
    border-radius: 10px;
    box-sizing: border-box;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    text-align: center;
  }
  input, button {
    width: 100%;
    font-size: 18px;
    padding: 12px;
    margin: 6px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
    box-sizing: border-box;
  }
  button {
    background: #007bff;
    color: white;
    border: none;
  }
  .msg {
    margin-top: 8px;
    font-weight: bold;
  }
  .val {
    margin-top: 6px;
    font-size: 16px;
  }
</style>
</head>
<body onload="document.getElementById('num').focus()">
<form method="post">
  <h3>Update</h3>
  <input type="number" id="num" name="num" inputmode="numeric" pattern="[0-9]*" placeholder="Enter Code here">
  <button type="submit">Update</button>

  <?php if ($msg): ?>
    <div class="msg"><?= $msg ?></div>
  <?php endif; ?>

  <div class="val">Current Value: <b><?= htmlspecialchars($current) ?></b></div>
</form>
</body>
</html>
