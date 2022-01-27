<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "scrap";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "database connection successfull"; 
$data = array();
$html = file_get_contents('https://raw.githubusercontent.com/meetDeveloper/freeDictionaryAPI/master/meta/wordList/english.txt');
$doc = new DOMDocument();
libxml_use_internal_errors(true);
if(!empty($html)){
    $doc->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$html);
    libxml_clear_errors();
    $xpath = new DOMXPath($doc);
    $entries = $xpath->query('//table[@class="stat"]');
    foreach($entries as $key => $value) {
		   $data[] = array(
		 'data' => trim($value->getElementsByTagName('font')->item(0)->nodeValue),
            
        );
    }
}


echo "<pre>";

print_r($data);
echo "</pre>";
      
          
          $sql = "INSERT INTO data (data) VALUES ('$data')";
          if ($conn->query($sql) === TRUE) {
              echo "New record created successfully";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
          
   
?>
