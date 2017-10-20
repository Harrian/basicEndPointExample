<?php
$mysqli = new mysqli('localhost', 'userManager', 'Mm96YWwcs6Wfek25', 'playerInformation');

//check if we connected
if ($mysqli->connect_errno) {
    echo "Error Number: " . $mysqli->connect_errno . "\n";
    echo "Error information: " . $mysqli->connect_error . "\n";
    exit;
}
//confirm that playerId is a number
//if not exit otherwise convert to int
$playerId = $_GET["playerId"];
if(!is_numeric($playerId)){
  echo "Player ID is not a valid";
  exit;
}else{
  $playerId=intval($playerId);
}
//confirm that coinsWon is a number
$coinsWon = $_GET["coinsWon"];
if(!is_numeric($coinsWon)){
  echo "Coins Won is not a valid";
  exit;
}else{
  $coinsWon=intval($coinsWon);
  //coins won cannot be less than zero
  if($coinsWon<0){
    echo "Coins Won is not a valid";
    exit;
  }
}
//confirm that coinsBet is a number
$coinsBet = $_GET["coinsBet"];
if(!is_numeric($coinsBet)){
  echo "Coins Bet is not a valid";
  exit;
}else{
  $coinsBet=intval($coinsBet);
  //coins bet cannot be a negative value or equal to zero
  if($coinsBet<=0){
    echo "Coins Bet is not a valid";
    exit;
  }
}

//coins return is the net `profit` between coinsWon and coinsBet
$coinsReturn = $coinsWon-$coinsBet;

//find out if player id is real and get it's salt value to confirm hash and grab credits to find out if the player had enough coins to make the bet
if (!$result = $mysqli->query("SELECT `Player ID`, `Credits`, `Salt Value` FROM `players` WHERE `Player ID` = $playerId")) {
    echo "Something failed";
    $result->close();
    exit;
}
if($result->num_rows==0){
    echo "No matching player id found";
    $result->close();
    exit;
}
//grab player information from result
$playerInfo = $result->fetch_assoc();
//database results from this query are no longer needed so close them
$result->close();
//if not enough coins to make bet exit
if(intval($playerInfo['Credits'])<$coinsBet){
  echo "Not enough coins to complete bet";
  exit;
}
//grab player salt
$playerSaltValue = $playerInfo['Salt Value'];
//generate hash to validate if the passed hash is correct
$calculatedHash = hash('sha512',$playerSaltValue.$playerId.$playerSaltValue.$coinsBet.$playerSaltValue.$coinsWon.$playerSaltValue);
//if no has was given or the calculated hash doesn't match the input hash then terminate
if(!$_GET['hash']||!hash_equals($calculatedHash,$_GET['hash'])){
  echo "Invalid Hash";
  exit;
}
//update the values in the table
if (!$result = $mysqli->query("UPDATE `players` SET `Credits` = `Credits` + $coinsReturn, `Lifetime Spins` = `Lifetime Spins` + 1, `Lifetime Return` = `Lifetime Return` + $coinsReturn WHERE `Player ID` = $playerId")) {
    echo "Something failed";
    exit;
}
//grab values for json return
if (!$result = $mysqli->query("SELECT `Player ID`, `Name`, `Credits`, `Lifetime Spins`, `Lifetime Average Return` FROM `players` WHERE `Player ID` = $playerId")) {
    echo "Something failed";
    exit;
}
echo json_encode($result->fetch_assoc());
//clean up
$result->close();
$mysqli->close();
?>