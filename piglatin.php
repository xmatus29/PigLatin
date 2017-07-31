<!DOCTYPE HTML> 
<html lang="en"> 
<head>
  <title>English to Pig Latin</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
	// play pig sound
	function playSound()
	{
		var audio = new Audio('sounds/PigSound.mp3');
		audio.play();
	}
	document.getElementById("clickMe").onclick = playSound();
  </script>
</head>
<body>  

<?php
ini_set('memory_limit','32M');
$temp_text = $text = $comment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["comment"])) {
    $text = $comment = "Enter the English text that you want translated into Pig Latin.";
	$temp_text = translate($text);  
  } else {
    $text = $comment = test_input($_POST["comment"]); 
	$temp_text = translate($text);  
  }

}

// test input text
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function translate($inputToTranslate) {
	//divide English text into words
    $words =  explode(" ", $inputToTranslate); 
	$tmp_pigLatin = "";

	// translate words to pigLatin
    for ($i = 0; $i < count($words); $i++) {  
		$tmp_pigLatin .= pigLatin($words[$i]);  
    }  
    return($tmp_pigLatin);
}  
 
// translate word 
function pigLatin($word) { 
	if (is_numeric($word)){
		return "$word";
	}
    elseif (isVowel(substr($word,0,1))) {  
		return isDot("$word" . "'way ");
    }  
    else {  
		return isDot(moveLetter($word) . "ay ");			
    }  
}  
 
// set dot to the end of the word
function isDot($word)
{
	if (preg_match('/[.]/', $word))
	{
		$temp_word = str_replace(".", "", $word);
		$temp_word = str_replace(" ", "", $temp_word);
		return $temp_word . ".";
	}
	else
	{
		return $word;
	}
}		
 
// move letters until vowel is found 
function moveLetter(&$word) {  
$counter = 0;
do {
	$counter++;
    $character = strtolower(substr($word,0,1));  
	$word = substr($word,1) . $character;
	if (isVowel(substr($word,0,1))) {
		break;
	}
} while(0);
return substr_replace($word, "-", strlen($word)-$counter, 0);	
}  
 
// check if character is vowel 
function isVowel($character) {  
	switch(strtolower($character))
	{
		case 'a':
		case 'e':
		case 'i':
		case 'o':
		case 'u':
		case 'y';
			return true;
		break;
		default;
			return false;
		break;
	}
}  


?>

<div class="container">
  <div class="jumbotron" style="text-align: center">
    <h1>English to Pig Latin translator</h1>      
    <p>Enter the English text that you want translated into Pig Latin.</p>
  </div>    
  
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <textarea placeholder="Enter the English text here that you want translated into Pig Latin." class="form-control" rows="5" name="comment" ></textarea>
  <br>
  <input id="clickMe" onclick="playSound();" type="submit" class="btn btn-primary btn-block" name="submit" value="Translate">
</form>
</div>

<?php
echo '<br>';
echo '<div class="container">';
echo '<div class="row">';
  echo '<div class="col-sm-6">';
	echo '<img src="images/uk.gif" class="img-circle center-block" width="304" height="236">';
	echo '<br>';
	echo '<p style="text-align: justify">';
	echo ' ' .$text.'<br><br>';
	echo '</p>';
  echo '</div>';
  echo '<div class="col-sm-6">';
	echo '<img src="images/pig.gif" class="img-circle center-block" width="304" height="236">';
	echo '<br>';
	echo '<p style="text-align: justify">';
	echo ' ' .$temp_text.'<br><br>';
	echo '</p>';
  echo '</div>';
echo '</div>';
?>

</body>
</html>