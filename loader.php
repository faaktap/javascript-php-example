<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  exit;
}
require ("server.php");
$JSON = json_decode(file_get_contents('php://input'), true);

  
//These are all the commands we are capable of.
//We can add extra ones - just be careful of the format of the json structure
$menuCommands = '[{"name": "menus"
   ,"version": "v1.0"
   ,"documentation"      : { "type" : "htm"  , "result" : "testForPierre.htm"}   
   ,"menu"     		     : { "type" : "menu" , "result" : "table"}   
   ,"home"               : { "type" : "text" , "result" : "<h1>Home</h1> Information we display for home"}
   ,"contact"            : { "type" : "text" , "result" : "<h2>Contact</h2> Information we display for contact"}
   ,"leesphp"            : { "type" : "php"  , "result" : "testrun.php"}
   ,"htmlees"            : { "type" : "htm"  , "result" : "https://www.php.net/manual/en/function.file-get-contents.php"}
   ,"test"               : { "type" : "htm"  , "result" : "test.htm"}
   ,"hallo"              : { "type" : "text" , "result" : "Nog bietjie <h2>text</h2> soos hallo world"}
   ,"ip"                 : { "type" : "ip"   , "result" : "Get the users IPAddress"}
   ,"somedata"           : { "type" : "data" , "result" : "select * from "}
   ,"badtype"            : { "type" : "xxx"  , "result" : "this type does not exist. should give an error"}
}]';
//Here we decode the json as a php object, to be used like $menuObj->name etc..
$menuObj = json_decode($menuCommands);   //force an object


//Get our json instructions here
if ($JSON)  {
  if (array_key_exists('task',$JSON)) {
	header('Content-Type: application/json');
	handleRequest($JSON);  //inside here we will echo our answer, should never come back!
  }
} else {
	header('Content-Type: application/json');
	echo json_encode(['error'=>'no json send - ons werk net met json hier' ]);
	exit;
}




//--------------------------------------------------------------
// Hierdie funskie kyk watter "task" is gestuur, en prosesseer dit
//--------------------------------------------------------------
function handleRequest($data) {   
  if(isset($data['task'])) {
	  switch ($data['task']) {
	  case "laaiData":
	     $answer = myLaaiDataDinge($data);
         echo json_encode($answer,1);
	     return;
      default:
         $result = [ 'payload' => 'weet noggie waarvoor hierdie is nie?' . $data['task'] ];
         return $result;
       }      
  }
}



//------------------------------------------------------
function chkObject($obj, $property) {
    foreach ($obj as $key => $value) {
      if ($property == $key) return true;
    }
    return false;   
}

//------------------------------------------------------       
function getIPAddress() {  
  //whether ip is from the share internet  
  if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
    $ip = $_SERVER['HTTP_CLIENT_IP'];  
  }  
  //whether ip is from the proxy  
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
   }  
  //whether ip is from the remote address  
  else{  
   $ip = $_SERVER['REMOTE_ADDR'];  
  }  
  return $ip;  
}
?>