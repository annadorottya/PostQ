<?php
//Usage: register.php?username=email@adfs.hu&password=iExmLmGEgXVDPfGjI%2Fk5Iw%3D%3D&privatekey=privatekey880Ll66NrAEvD4hs85x2qA%3D%3D&publickey=publickey
include_once("sqlconnect.php");
include_once("helpers.php");
if(!$_POST['username'] || !$_POST['password'] || !$_POST['privatekey'] || !$_POST['publickey'])
  die("Error - one of the parameters is not set.");

//check if user already exists
if(userExists($conn, $_POST['username']))
  die("Error - user already exists. Try to login instead.");


// prepare, bind and execute
$stmt = $conn->prepare("INSERT INTO users (username, password, privatekey, publickey) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $_POST['username'], password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['privatekey'], base64_decode($_POST['publickey']));
$stmt->execute();
if ($stmt->errno) {
    die("Error during the execution of the SQL query");
}

echo "1";

$stmt->close();
$conn->close();
?>
