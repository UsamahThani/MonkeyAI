<?php
$output = shell_exec('python C:/xampp/htdocs/MonkeyAI/app.py> /dev/null 2>&1 &');
echo "<script>window.open('http://192.168.1.100:5000');</script>";
echo "Flask app started!";

echo "<script>window.close();</script>";

exit();
?>
