<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  exit;
}

$JSON = json_decode(file_get_contents('php://input'), true);

if ($JSON)  {
  if (array_key_exists('task',$JSON)) {
	header('Content-Type: application/json');
	handleRequest($JSON);  //inside here we will echo our answer, should never come back!
  }
} else {
	header('Content-Type: application/json');
	echo json_encode(['error'=>'nos json send - ons werk net met json hier' ]);
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

//---------------------------------------------------------------------------------
// Hierdie funksie myLaaiDataDinge - lees die menuClick, en laai iets ooreenkomstig
//----------------------------------------------------------------------------------
function myLaaiDataDinge($data) {
  if (!array_key_exists('menuClick',$data)) {
      return  ['error' => 'We need a menuClick buddy!'];
  }
  $menuClick = $data['menuClick'];
  switch (strtolower($menuClick)) {
/*
    case 'home' :
        $result = ['payload' => 'This is stuff to display if they click on home'  ];
        return $result;
  case 'contact' :
       $result = ['payload' => 'This is stuff to display if they click on contact'  ];
        return $result;
*/
  case 'home':
        $result = [];
        ob_start();
        include('home.php');
        $result['payload'] = ob_get_clean();
        return $result;
    case 'enter':
        $result = [];
        ob_start();
        include('enter.php');
        $result['payload'] = ob_get_clean();
        return $result;
  case 'results':
        $result = [];
        ob_start();
        include('results.php');
        $result['payload'] = ob_get_clean();
        return $result;
  case 'judging':
        $result = [];
        ob_start();
        include('judging.php');
        $result['payload'] = ob_get_clean();
        return $result;
  case 'judging':
        $result = [];
        ob_start();
        include('judging.php');
        $result['payload'] = ob_get_clean();
        return $result;
  case 'media':
        $result = [];
        ob_start();
        include('media.php');
        $result['payload'] = ob_get_clean();
        return $result;
  case 'magazine':
        $result = [];
        ob_start();
        include('magazine.php');
        $result['payload'] = ob_get_clean();
        return $result;
case 'travelandstay':
        $result = [];
        ob_start();
        include('travelandstay.php');
        $result['payload'] = ob_get_clean();
        return $result;
case 'about':
        $result = [];
        ob_start();
        include('about.php');
        $result['payload'] = ob_get_clean();
        return $result;
case 'contact':
        $result = [];
        ob_start();
        include('contact.php');
        $result['payload'] = ob_get_clean();
        return $result;
case 'press':
        $result = [];
        ob_start();
        include('press.php');
        $result['payload'] = ob_get_clean();
        return $result;
case '2020winners':
        $result = [];
        ob_start();
        include('2020-winners.php');
        $result['payload'] = ob_get_clean();
        return $result;

  default:
       $result = ['payload' => 'weet noggie wat nie? - kennie vir ' . $menuClick  ];
       return $result;
  }
  $result = ['errorcode' => 999
             ,'result' => 'error'
             ,'error' => json_encode($json)
             ,'desc' => 'some descrip'];
  return $result;
}
?>