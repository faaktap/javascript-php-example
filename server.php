<?php
//---------------------------------------------------------------------------------
// Hierdie funksie myLaaiDataDinge - lees die menuClick, en laai iets ooreenkomstig
//----------------------------------------------------------------------------------
function myLaaiDataDinge($data) {
  if (!array_key_exists('menuClick',$data)) { 
      return  ['error' => 'We need a menuClick buddy!']; 
  }
  //Get the instruction, and lowercase it..
  $menuClick = $data['menuClick'];
  $c = strtolower($menuClick);
  
  //Get our global menusctructure
  global $menuObj;
  
  //check if it is a valid object, if not our json is damaged.
  if ($menuObj == null) {
      global $menuCommands;
      return  ['error' => 'We need a better, more json good menu buddy!', 'payload' => 'error in json : ' . $menuCommands . '. Please test in lint!']; 
  }
  
  //Get the menu object that link to our menuclick
  //if (!is_object($menuObj[0]->$c)) {
  if (!chkObject($menuObj[0], $c)) {  
    return  ['error' => 'We need a better, more defined menuClick buddy!', 'payload' => '<i>'. $c . '</i> not good']; 
  } else {
    $menuArr = $menuObj[0]->$c;
  }
  
  //Check if we have a valid type - like text,php or htm
  if ($menuArr->type == null) {
      return  ['error' => 'this menu obj does not have a type buddy!', 'payload' => 'oops ' . $c]; 
  }
  
  //execute our instructions and return result.
  switch ($menuArr->type) {
  case 'menu' : 
        global $menuCommands;
        $result = ['payload' =>  jsonToDebug($menuCommands) ];
        return $result;
  case 'text' : 
        $result = ['payload' =>  $menuArr->result ];
        return $result;
  case 'php' : 
        $result = [];
        ob_start();
        include($menuArr->result);
        $result['payload'] = ob_get_clean();  
        return $result;
  case 'htm':
  case 'html':
        $result['payload'] = file_get_contents($menuArr->result);
        return $result;
  case 'ip':
        $result['payload'] = getIPAddress();
        return $result;        
  case 'data':
        $result['payload'] = "Here we will use a sql statement in result, and fetch stuff from database...eventually";
        return $result;
  default: 
       $result = ['payload' => 'weet noggie wat nie? - kennie vir ' . $menuClick  . ' nie!'
                 ,'error' => 'That option not in our switch statement - bad/misspelled parameter (server.php)!!'];
       return $result;
  }

  //Groot fout, ons het deurgeval, en geen result gekry nie...
  $result = ['errorcode' => 999
             ,'result' => 'error'
             ,'error' => json_encode($data)
             ,'desc' => 'We fell thru our switch statement'];
  return $result;          
}

function jsonToDebug($jsonText = '')
{
    $arr = json_decode($jsonText, true);
    $html = "";
    if ($arr && is_array($arr)) {
        $html .= _arrayToHtmlTableRecursive($arr);
    }
    return $html;
}

function _arrayToHtmlTableRecursive($arr) {
    $str = "<table class='table text-reset'><tbody>";
    foreach ($arr as $key => $val) {
        $str .= "<tr>";
        $str .= "<td>$key</td>";
        $str .= "<td>";
        if (is_array($val)) {
            if (!empty($val)) {
                $str .= _arrayToHtmlTableRecursive($val);
            }
        } else {
            $str .= "<strong>$val</strong>";
        }
        $str .= "</td></tr>";
    }
    $str .= "</tbody></table>";

    return $str;
}

?>