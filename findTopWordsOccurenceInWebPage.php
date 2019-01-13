<?php
error_reporting(E_ERROR | E_PARSE); //ignore the warnings
echo "****************************** \n PHP program to find the top k number of occurence for a URL site\n****************************** \n";

//Function to find the top k times the words present in a site
function topFindTopktimesWords($string, $k) {
  //$string = "the hello the what is an a universe an an universe what.";
  $occurenceArray = [];
  $myStrinArray = explode("-", stringCleanUp($string));
  for ($i = 0; $i < count($myStrinArray); $i++) {
    if (!array_key_exists( $myStrinArray[$i], $occurenceArray )) {
      $occurenceArray[$myStrinArray[$i]] = 1;
    } else {
      $occurenceArray[$myStrinArray[$i]]++;
    }
  }

  //soring the occurence array
  arsort($occurenceArray);

  //printing the k times the words present
  echo "Top $k time the occurence of words are :: \n--------------------------- \n";
  $countToPrint = 0;
  foreach ($occurenceArray as $key => $value) {
    if ($key == '')
      continue;
    $countToPrint++;
    echo "Occurence of [" . $key . "] is " . $value . "\n";
    if ($countToPrint > $k - 1) {
      break;
    }
  }
}

//Function to clean up the strinf to remove the special chars
function stringCleanUp($string) {
  $string = str_replace(' ', '-', $string);
  return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function isURLValid($url) {
  if (filter_var($url, FILTER_VALIDATE_URL)) {
    return true;
  } else {
    return false;
  }
}

function isInteger($int) {
  if (filter_var($int, FILTER_VALIDATE_INT)) {
    return true;
  } else {
    return false;
  }
}

//main function
function main() {
  //valdiation of arg passed
  if(count($_SERVER['argv']) !== 3 ) {
    echo "Error: Please pass arguments\n1. url 2. k top occurence\n ex: php test.php 'http://www.example.com' 3";
    exit();
  }

  $args = $_SERVER['argv'];
  $url = $args[1];
  $k = $args[2];

  if(!isURLValid($url)) {
    echo "Error: Please enter a valid url, the 1st arg is not valid\n";
    exit();
  }

  if(!isInteger($k)) {
    echo "Error: Please enter a valid number, the 2nd arg is not valid\n";
    exit();
  }

  $readDOM = new DOMDocument;
  $updatedDOM = new DOMDocument;
  $readDOM->loadHTML(file_get_contents($url));
  $body = $readDOM->getElementsByTagName('body')->item(0);
  foreach ($body->childNodes as $child){
      $updatedDOM->appendChild($updatedDOM->importNode($child, true));
  }

  $content = $updatedDOM->saveHTML();


  topFindTopktimesWords(trim(strip_tags($content)), $k);

}

//program starts from here main()
main();

?>
