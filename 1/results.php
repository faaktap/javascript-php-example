<?php
// DATABASE STUFF TO GET AWAY FROM WORDPRESS START
define('DB_NAME', 'rbexbesy_wpall');
define('DB_USER', 'rbexbesy_wpall');
define('DB_PASSWORD', 'pD[S12OI3(');
function zmlgetdata($psql) {
	$servername = "localhost";
	$username = DB_USER;
	$password = DB_PASSWORD;
	$dbname = DB_NAME;
    /* Database connection start */
    try {
      $pconn = new PDO("mysql:host=" . $servername . ";dbname=" . $dbname . ';charset=UTF8', $username, $password);
    } catch(PDOException $exception){
      nicedie("Connection error: " . $exception->getMessage());
    }

	// set the PDO error mode to enable exceptions
    $pconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// set the PDO emulate prepares to false
    //$pconn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    /* Database connection end */

  $query = $pconn->prepare($psql);
  $query->execute();
  $pdata = $query->fetchAll(PDO::FETCH_ASSOC);
//$pdata = $query->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP);
//$pdata = $query->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'objArr');
  $object = (object) $pdata;

/*
ob_flush();
ob_start();
var_dump($object);
file_put_contents("var_dump_werner_object.txt", ob_get_flush());
*/
  return $object;
}
// DATABASE STUFF TO GET AWAY FROM WORDPRESS END


function i($str,$year) {
    if ($year == "2017") {
        return ("https://maiwsa.co.za/wp-content/themes/betheme/images/" . $str);
    }

    if ($year == "2019") {
        return ("https://maiwsa.co.za/wp-content/themes/betheme/images/" . $str);
    }
    if ($year == "2020") {
        return ("https://maiwsa.co.za/entry/awards/" . $str);
    }
    switch ($str) {
    case "award-trophy.png":
        $str = "award-2018-trophy-w160.png";
        break;
    case "award-platinum.png":
        $str = "award-2018-platinum-w160.png";
        break;
    case "award-doublegold.png":
        $str = "award-2018-doublegold-w160.png";
        break;
    case "award-gold.png":
        $str = "award-2018-gold-w160.png";
        break;
    case "award-silver.png":
        $str = "award-2018-silver-w160.png";
        break;
    default:
        echo "We do not understand:" . $str . "<br>";
    }
    //echo $pic . " " . $str . "<br>";
	return ("https://maiwsa.co.za/wp-content/themes/betheme/images/" . $str);
}

$qrsite =   'https:/www.maiwsa.co.za/qr/index.php?product=';

//**************************************************************
//Load all the data into divs'
      $sqlawards = 'select a.awardname
      , a.awardorder
      , a.awardpicture
      , a.awardnotes
      , c.competitionid
      , c.competitionname
      , c.competitionyear
      , count(*) wines
      from  wp_award a
      , wp_competition c
      , wp_competitionwine s
      , wp_awardwinner w
      where a.awardid = w.awardid
      and c.competitionid = w.competitionid
      and s.competitionwineid = w.competitionwineid
      group by a.awardname, c.competitionname,c.competitionyear, a.awardorder , a.awardpicture, a.awardnotes, c.competitionid
      order by c.competitionyear,a.awardorder';

      // (old Wordpress code) $awards = $wpdb->get_results($sqlawards);
      $awards = zmlgetdata($sqlawards);


/*
      file_put_contents("award_werner.txt",json_encode($awards));
       foreach ($awards as $award) {
           echo $award->competitionyear . $award->competitionname . '\n<br>';
       }
        echo "/n/n\n\n";
       foreach ($awards as $award) {
           $aw = (object) $award;
           echo $aw->competitionyear . $aw->competitionname . '\n<br>';
       }
*/

      $tab2 = array();
      $prev = "";
      //opening div for each year's trophees  id=t2018trophees


      foreach ($awards as $aw) {
       $award = (object) $aw;
       $yy = $award->competitionyear;
       //echo $yy . $yy.$yy . $yy.$yy . $yy.$yy . $yy.$yy . $yy.$yy . $yy;
       if ($prev == $award->competitionyear)  continue;
       $tab2[ $yy ] = '';
       $tab2[ $yy ]  .= PHP_EOL . '<div id="t' . $yy  .'trophees" class="mx-auto pb-3" style="display:none">';
       $tab2[ $yy ]  .= PHP_EOL . 	'<div class="row">';
       $tab2[ $yy ]  .= PHP_EOL . 		'<div class="col mx-auto mt-3">';
       $tab2[ $yy ]  .= PHP_EOL . 		'</div>';
       $tab2[ $yy ]  .= PHP_EOL . 	' </div>';
       $tab2[ $yy ]  .= PHP_EOL . 	'<div class="row">';
       $tab2[ $yy ]  .= PHP_EOL . 		'<div class="col mx-auto">';
       $tab2[ $yy ]  .= PHP_EOL . 		'</div>';
	   $tab2[ $yy ]  .= PHP_EOL . 	'</div>';
       $tab2[ $yy ]  .= PHP_EOL . ' <div class="row mx-1">';
       $prev = $yy;
      }

      foreach ($awards as $aw) {
          $award = (object) $aw;
          $yy = $award->competitionyear;
          $tab2[$yy] .= PHP_EOL . '<div class="col-medal mx-auto" style="display:none">';
          $tab2[$yy] .= PHP_EOL . ' <button class="btn btn-trophy rgba-white-light animated rotateIn blue-grey-text view overlay zoom bullshit"';
          $tab2[$yy] .= PHP_EOL . ' id="t'. $award->competitionyear . substr($award->awardname,0,4) . '" onclick="zmlTrophy(this)" >';
          $tab2[$yy] .= PHP_EOL . ' </button>';
          $tab2[$yy] .= PHP_EOL . '</div>';
      }
      $prev = "";
      //closing div for each year's trophees (we loop to many times, threfore we use the prev"-continue)
      foreach ($awards as $aw) {
          $award = (object) $aw;
          $yy = $award->competitionyear;
          //if ($prev == $award->competitionyear)  continue;
          $tab2[$yy] .= PHP_EOL . '</div></div zml=divcloseyearandtrophee>'; //zml end two divs at award yearend here was a div close
          $prev = $yy;
      }

//**************************************************************


//**************************************************************

       $sqlawardwinners = 'select a.awardid
         , a.awardname
      , c.competitionyear
      , concat(w.winename," ",w.vintageyear) winename
      , w.wineclassnotes
      , w.competitionwineid
      , f.website
      , f.wineryname
      , f.wineryid
      , a.awardorder
      , a.awardpicture
      , a.awardnotes
      from wp_awardwinner m
      ,  wp_award a
      ,  wp_competition c
      ,  wp_competitionwine w
      ,  wp_winery f
      where a.awardid = m.awardid
      and c.competitionid = m.competitionid
      and m.competitionwineid = w.competitionwineid
      and f.wineryid = w.wineryid
      order by c.competitionyear, a.awardorder, f.wineryname';

       //$awardwinners = $wpdb->get_results($sqlawardwinners);
       $awardwinners = zmlgetdata($sqlawardwinners);


       $sqltrophywinners = 'select a.trophyid
         , a.trophydesc
      , c.competitionyear
      , concat(w.winename," ",w.vintageyear) winename
      , w.wineclassnotes
      , w.competitionwineid
      , f.website
      , f.wineryname
      , f.wineryid
      , a.trophypicture
      , a.trophynotes
      from  wp_trophywinner m
      ,  wp_trophy a
      ,  wp_competition c
      ,  wp_competitionwine w
      ,  wp_winery f
      where a.trophyid = m.trophyid
      and c.competitionid = m.competitionid
      and m.competitionwineid = w.competitionwineid
      and f.wineryid = w.wineryid
      order by c.competitionyear,substr(a.trophyid,1,1), f.wineryname';

       //$trophywinners = $wpdb->get_results($sqltrophywinners);
       $trophywinners = zmlgetdata($sqltrophywinners);

      $tab3 = array();
      $prev = "";
      //we need an opening div for each year
      foreach ($awardwinners as $win) {
          $winner = (object) $win;
       if ($prev == $winner->competitionyear)  continue;
       $tab3[$winner->competitionyear]  = PHP_EOL . '<div id="w'. $winner->competitionyear . 'wines" style="display:block" zml=divopenyear_w>';
       $prev = $winner->competitionyear;
      }


      //echo "tab3 values = " . count($tab3) . "<br>";
      //we need all the years wines in the div mentioned above
      //but first we need to load the trophies - since they have names, and should also be in the top of the list


      //--------------------------TROPHEES------------------------
      $prev = '';
      $cnt = 0;
      foreach ($trophywinners as $win) {
          $winner = (object) $win;
        //   $cnt ++;
        //   echo $cnt . "w" .$winner->competitionyear . "Trop" . $winner->trophydesc. "<br>";
           if ($prev != $winner->competitionyear)  {
           $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="mx-auto" id="w' .$winner->competitionyear . 'Trop" style="display:none">';
		   $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="row">'; //Here we display the trophy
		   $tab3[$winner->competitionyear] .= 	'<div class="col-12 mx-auto text-center mt-4">';
		   $tab3[$winner->competitionyear] .= 		'<img style="max-width: 160px; height: auto;"  src="'. i($winner->trophypicture,$winner->competitionyear) .'">';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End of trophy display
		   $tab3[$winner->competitionyear] .= '<div class="row">'; //Here we display the trophy name and year
		   $tab3[$winner->competitionyear] .= 	'<div class="col-12 mx-auto text-center mt-4">';
		   $tab3[$winner->competitionyear] .= 		'<h2 class="h2-responsive fw600">Trophy '. $winner->competitionyear . '</h2>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End of trophy name and year
		   $tab3[$winner->competitionyear] .= '<div class="row">'; //Here we display the awardnote
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 mx-auto text-center mt-4">';
		   $tab3[$winner->competitionyear] .= 		'<p class="mb-0">' . $winner->trophynotes . '</p>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End of awardnote
		   $tab3[$winner->competitionyear] .= '<div class="row">'; //Start Back to Search
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 mx-auto text-center my-4">';
		   $tab3[$winner->competitionyear] .= 		'<a href="#alles" class="text-orange">Back to Search</a>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End Back to Search
		   $tab3[$winner->competitionyear] .= '<div class="row" style="height: 40px; background-color: #333332;">'; //Start dark heading
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 text-left text-white">';
		   $tab3[$winner->competitionyear] .= 		'<h5 class="h5-responsive fw600 ml-1 pt-1 mb-0">Winners A-Z</h5>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 text-left">';
		   $tab3[$winner->competitionyear] .= 		'<h5 class="h5-responsive fw600 text-orange ml-1 pt-1 mb-0">Trophy</h5>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>' . PHP_EOL; //End dark heading
          }
          $trophyimg = '<img class="btn-trophy z-depth-1" align="left" src="' . i($winner->trophypicture,$winner->competitionyear) . '" title="'.$winner->trophydesc.'">';
          $tab3[$winner->competitionyear] .=  PHP_EOL . ' <div class="row">'; //Start of results
          $tab3[$winner->competitionyear] .=  PHP_EOL . '  <div class="col-6 text-left">';
          $tab3[$winner->competitionyear] .=  ' <p class="text-left my-1" style="font-family: Roboto">';
          $tab3[$winner->competitionyear] .=  '   <a title="View more information about '. $winner->winename .'"';
          $tab3[$winner->competitionyear] .=  '    href="' . $qrsite . $winner->competitionwineid  .'" style="color: #868686; font-weight: 600;">';
          $tab3[$winner->competitionyear] .=  $winner->winename . '</a></p>';
          $tab3[$winner->competitionyear] .=  '<p class="text-left my-1" style="color: #868686;">  Produced by ';
          $tab3[$winner->competitionyear] .=  '<a style="color: #B99C31;" target=_winery';
          $tab3[$winner->competitionyear] .=	'   onclick="sProducer(this);" data-wid="' . $winner->wineryid  .'" role="button">' . $winner->wineryname;
          $tab3[$winner->competitionyear] .= '</a></p>';
          $tab3[$winner->competitionyear] .=	'  </div>';
          $tab3[$winner->competitionyear] .=  PHP_EOL . '  <div class="col-6 text-left">';
          $tab3[$winner->competitionyear] .=  ' <p class="text-left my-1">';
          $tab3[$winner->competitionyear] .=	'<p class="text-left my-1 text-orange fw600">' . $winner->trophydesc . ' WINNER</p>';
          $tab3[$winner->competitionyear] .= ' </div>';
          $tab3[$winner->competitionyear] .= PHP_EOL . '</div zml=divclosetrophy><hr><!--TrophyEndingDiv-->';
          $prev = $winner->competitionyear;
      }
      //we might need an closing div for the last  trophy
      $prev = '';
      foreach ($trophywinners as $win) {
       $winner = (object) $win;
       if ($prev == $winner->competitionyear)  continue;
	    $tab3[$winner->competitionyear] .= '<div class="row">'; //Start Back to search
	    $tab3[$winner->competitionyear] .= 	'<div class="col-6 mx-auto text-center my-4">';
	    $tab3[$winner->competitionyear] .= 		'<a href="#alles" class="text-orange">Back to Search</a>';
	    $tab3[$winner->competitionyear] .= 	'</div>';
	    $tab3[$winner->competitionyear] .= '</div>'; //End Back to search
        $tab3[$winner->competitionyear]  .= PHP_EOL . '</div zml=divcloselasttrophy><!--END DIV FOR LAST TROPHY-->';
        $prev = $winner->competitionyear;
       }

      //--------------------------AWARDS------------------------
      $prev = "";
      $prevyear = "";
      $cnt = 0;
      foreach ($awardwinners as $win) {
           $winner = (object) $win;
           if ($winner->awardname == "Trophy") {
             //echo "we leave this one<br>";
             continue; //We handle all trophies in the loop above
            }
           if ($prev != $winner->awardid) {
           if ($prev != "" && $prevyear == $winner->competitionyear) {
	         $tab3[$winner->competitionyear] .= '<div class="row">'; //Start Back to search
	         $tab3[$winner->competitionyear] .= 	'<div class="col-6 mx-auto text-center my-4">';
	         $tab3[$winner->competitionyear] .= 		'<a href="#alles" class="text-orange">Back to Search</a>';
	         $tab3[$winner->competitionyear] .= 	'</div>';
	         $tab3[$winner->competitionyear] .= '</div>'; //End Back to search
             $tab3[$winner->competitionyear] .= PHP_EOL . '</div><!--END DIV PreviousAwardListr-->' . PHP_EOL;
           }
           $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="mx-auto" id="w' .$winner->competitionyear . substr($winner->awardname,0,4) . '" style="display:none" zml=divopenwyear>';
 		   //$tab3[$winner->competitionyear] .= '<h1 class="' . $styleh1 . '">' . $winner->awardname . ' Awards for ' . $winner->competitionyear . '</h1>';
		   $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="row">'; //Here we display the award
		   $tab3[$winner->competitionyear] .= 	'<div class="col-12 mx-auto text-center mt-4">';
		   $tab3[$winner->competitionyear] .= 		'<img style="max-width: 160px; height: auto;"  src="'. i($winner->awardpicture,$winner->competitionyear) .'">';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End of award display
		   $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="row">'; //Here we display the award name and year
		   $tab3[$winner->competitionyear] .= 	'<div class="col-12 mx-auto text-center mt-4">';
		   $tab3[$winner->competitionyear] .= 		'<h2 class="h2-responsive fw600">' . $winner->awardname .' '. $winner->competitionyear . '</h2>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End of award name and year
		   $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="row">'; //Here we display the awardnote
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 mx-auto text-center mt-4">';
		   $tab3[$winner->competitionyear] .= 		'<p class="mb-0">' . $winner->awardnotes . '</p>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End of awardnote
		   $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="row">'; //Start Back to search
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 mx-auto text-center my-4">';
		   $tab3[$winner->competitionyear] .= 		'<a href="#alles" class="text-orange">Back to Search</a>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= '</div>'; //End Back to search
		   $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="row" style="height: 40px; background-color: #333332;">'; //Start dark heading
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 text-left text-white">';
		   $tab3[$winner->competitionyear] .= 		'<h5 class="h5-responsive fw600 ml-1 pt-1 mb-0 text-orange">Produced By</h5>';
		   $tab3[$winner->competitionyear] .= 	'</div>';
		   $tab3[$winner->competitionyear] .= 	'<div class="col-6 text-left text-white">';
		   $tab3[$winner->competitionyear] .= 		'<h5 class="h5-responsive fw600 ml-1 pt-1 mb-0">Winners A-Z</h5>';
		   $tab3[$winner->competitionyear] .= 	'</div>';		   $tab3[$winner->competitionyear] .= PHP_EOL .'</div>'; //End dark heading
 		    }
 		    //Load the wines - one by one
            $trophyimg = '<img class="btn-medal z-depth-1 " align="left" width=100 src="' . i($winner->awardpicture,$winner->competitionyear) . '" title="'.$winner->wineryname.'">';
 			$tab3[$winner->competitionyear] .=  PHP_EOL .'<div class="row">';
			$tab3[$winner->competitionyear] .= PHP_EOL .'<div class="col-6 mt-3"><p class="text-left my-1">';
 			$temptitle = 'Go to winemaker : ' . str_replace($winner->wineryname,'"','`');
 			$temptitle = 'Go to winemaker : ' . str_replace($temptitle,"'",'`');
			$tab3[$winner->competitionyear] .=  '<p class="text-left my-1"><a style="color: #B99C31;" target=_winery title="' . $temptitle . '"';
 			$tab3[$winner->competitionyear] .=	'   onclick="sProducer(this);" data-wid="' . $winner->wineryid  .'" role="button">' . $winner->wineryname;
 			$tab3[$winner->competitionyear] .= '</a></p>' .PHP_EOL . '</div>';
 			$tab3[$winner->competitionyear] .= '<div class="col-6 mt-3"><p class="text-left my-1"><a style="color: #868686; font-weight: 600;" xxxtarget=_wine title="View more information about '. $winner->winename .'"';
 			$tab3[$winner->competitionyear] .= ' href="' . $qrsite . $winner->competitionwineid .'">';
 			$tab3[$winner->competitionyear] .=  $winner->winename . '</a></p>';
			$tab3[$winner->competitionyear] .=  '</div>';
 			$tab3[$winner->competitionyear] .= '</div><hr>'.PHP_EOL;

      $prev = $winner->awardid;
      $prevyear = $winner->competitionyear;

      }

      $prev = "";
      //we need an closing div for each year
      foreach ($awardwinners as $win) {
       $winner = (object) $win;
       if ($prev == $winner->competitionyear)  continue;
	   		$tab3[$winner->competitionyear] .= PHP_EOL .'<div class="row">'; //Start Back to search
	        $tab3[$winner->competitionyear] .= 	'<div class="col-6 mx-auto text-center my-4">';
	        $tab3[$winner->competitionyear] .= 		'<a href="#alles" class="text-orange">Back to Search</a>';
	        $tab3[$winner->competitionyear] .= 	'</div>';
	        $tab3[$winner->competitionyear] .= PHP_EOL .'</div>'; //End Back to search
            $tab3[$winner->competitionyear] .= PHP_EOL . '</div><!--LastAwardEndingDiv-->';
            $tab3[$winner->competitionyear] .= PHP_EOL . '</div zml=divcloseyear><!--YearEndingDiv-->';
            $prev = $winner->competitionyear;
      }

//End of Load all the data into divs
//**********************************

//**Main Code Start Here **//
    $styleh1 = 'h1-responsive black-text text-center animated fadeInUp my-0';

    $sqlyears = 'select * from wp_competition where competitionentryclose < now() order by competitionid DESC';
    $compyears = zmlgetdata($sqlyears);

    $sqlawards = 'select distinct awardname from wp_award ';
    $awardname = zmlgetdata($sqlawards);

//Building Dropdown Buttons
    $btn = '';
	$btn .= PHP_EOL . '<div class="row">'; //Start year box row
	$btn .= PHP_EOL . 	'<div class="col-10 col-md-3 col-lg-2 offset-1 offset-md-3 offset-lg-4 mb-3 mb-md-0">';
    $btn .= PHP_EOL . 		'<div id=yeardrop class="custom-select search-box">';
    $btn .= PHP_EOL . 			'<select id=jaar onchange="checkYearAlert(event)">';
    $btn .= PHP_EOL . 				'<option value="0">Choose a Year...</option>';
    foreach ($compyears as $yarr) {
       $y = (object) $yarr;
       $btn .= PHP_EOL . 				'<option value="'  .$y->competitionyear . '">' . $y->competitionyear . '</option>';
    }
	$btn .= PHP_EOL . 			'</select>';
    $btn .= PHP_EOL . 		'</div>'; // End year-box
    $btn .= PHP_EOL . 	'</div>'; //End col-10
    $btn .= PHP_EOL . 	'<div class="col-10 col-md-3 col-lg-2 offset-1 offset-md-0 offset-lg-0">';	//Start award selection box
    $btn .= PHP_EOL . 		'<div id=awarddrop  class="custom-select search-box">';
    $btn .= PHP_EOL . 			'<select id=trofee onchange="checkAwardAlert(event)">';
    $btn .= PHP_EOL . 				'<option selected>Choose an Award...</option>';

//Building more Dropdown Buttons
    foreach ($awardname as $aArr) {
        $a = (object) $aArr;
        $btn .= PHP_EOL . 				'<option value="'  .$a->awardname . '">' . $a->awardname . ' </option>';
 	}
    $btn .= PHP_EOL . 			'</select>';
    $btn .= PHP_EOL . 		'</div></div>'; // End award-box and col
	$btn .= PHP_EOL . '</div>'; // End row
	$btn .= PHP_EOL . '<div class="row pt-3">'; // Start search button row for year and award
	$btn .= PHP_EOL . 	'<div class="col-10 col-md-6 col-lg-4 offset-1 offset-md-3 offset-lg-4">';
	$btn .= PHP_EOL . 		'<button type="button" onclick="ShowIt();" class="btn btn-block results-search ml-0 mt-3 mt-md-0">Search</button>';
	$btn .= PHP_EOL .  	'</div>';
	$btn .= PHP_EOL .  '</div>'; // End search button row for year and award

//add the search here...
//first the small cross to clear
        $btn .= PHP_EOL . '<style> input[type="search"]::-webkit-search-cancel-button {'.
                 '-webkit-appearance: searchfield-cancel-button;'.
                 '}</style>';
        $btn .= PHP_EOL . '<div class="row pt-5">'; //Start individual search heading
	    $btn .= PHP_EOL . 	'<div class="col text-center text-white">Seach all Michelangelo Award Winners';
		$btn .= PHP_EOL . 		'<h2 class="h2-responsive text-white"><strong>SEARCH FOR AN INDIVIDUAL ENTRY</strong></h2>';
        $btn .= PHP_EOL . 	'</div>';
		$btn .= PHP_EOL . '</div>'; //End individual search heading
		$btn .= PHP_EOL . '<div class="row">'; //Start individual search box area
		$btn .= PHP_EOL . 	'<div class="col-10 col-md-3 col-lg-2 offset-1 offset-md-3 offset-lg-4">'; //Start individual search box input
		$btn .= PHP_EOL . 		'<div class="search-box" style="height: 53px;">';
        $btn .= PHP_EOL . 			'<form style="height: 53px;">';
        $btn .= PHP_EOL . 				'<div class="input-group" style="height: 53px;">';
        $btn .= PHP_EOL . 					'<input id=searchvalue type="search" placeholder="Search" class="form-control input-group" style="height: 53px;" onkeyup="showResult(this.value);">';
        $btn .= PHP_EOL . 						'<div class="input-group-append">';
        $btn .= PHP_EOL . 							'<span class="input-group-text blue-grey lighten-5 rounded-right black-text">';
        $btn .= PHP_EOL . 								'<i class="fa fa-minus-square" role=button title="click to close search" onclick="showResult(\'\');"></i>';
        $btn .= PHP_EOL . 							'</span>';
        $btn .= PHP_EOL . 							'<span id=howmany></span>';
        $btn .= PHP_EOL . 							'<img src="/zml/images/ajaxload.gif" style="display:none" id="loader-image">';
        $btn .= PHP_EOL . 						'</div>'; //End input-group-append
        $btn .= PHP_EOL . 					'</div>'; //End input-group
        $btn .= PHP_EOL . 				'</form>';
        $btn .= PHP_EOL . 			'</div>'; //End search-box
        $btn .= PHP_EOL . 		'</div>'; //End individual search box input
		$btn .= PHP_EOL . 	'<div class="col-10 col-md-3 col-lg-2 offset-1 offset-md-0 offset-lg-0">'; //Start individual search button
		$btn .= PHP_EOL . 		'<button type="button" class="btn btn-block results-search ml-0 mt-3 mt-md-0" onclick="showResult(\'daarbo\');">Search</button>';
        $btn .= PHP_EOL . 		'</div>'; //End individual search button
        $btn .= PHP_EOL . 	'</div>'; //End individual search box area
		//$btn .= PHP_EOL . '</div><!--End animated-->'; //End animated
		$btn .= PHP_EOL;
?>

<section>

<div id=alles>
<script type="text/javascript" src="xxxxassets/js/template-results.js"></script>
  <div class="container-results">
	<div class="row pt-5">
	</div>
	<div class="row pt-5">
	</div>
	<div class="row pt-5">
		<div class="col text-center pt-5">
			<h2 class="h2-responsive text-white">
			<strong>SEARCH FOR RESULTS BY YEAR</strong>
			</h2>
		</div>
	</div>
    <div class="row">
		<div class="col mx-auto">
          <?php echo $btn; ?>
        </div>
    </div>
  </div>
</div>


<div id=searchresults class="container align-center">
</div>

<div id=d2 class="container-fluid" zml=beginvantrofee>
  <div class="container white limit px-0 py-0 rounded text-center mx-auto">
   <?php
   foreach ($tab2 as $howzit) {
       echo $howzit .PHP_EOL;
   }
    ?>
  </div>
</div zml=eindevantrofee>

<div id="KomOnsScrollTotHier">
</div>

<div id=d3 class="container">
  <div class="red-bg limit mx-auto rounded" zml=beginvantab3>
   <?php
   foreach ($tab3 as $howzit) {
       echo $howzit;
   }
    ?>
  </div zml=eindevantab3>
</div>

</div><!--End All Winners-->
</div><!--En Alles-->
</section>

<section id=winemodelNov2018>
<div class="modal fade gradientcirc" id="wineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
	          <img src="" alt="WineryLogo" id=wineModalImg class="white px-1" style="min-width: 150px; max-width: 200px">
      </div>
      <div class="modal-body text-center">
		<h5 class="mt-1 mb-2 text-black" id="wineModalHead">WineryName</h5>
	  </div>
        <div class="md-form ml-0 mr-0 mt-1 text-center">
           <p id="wineModalTxt"></p>
        </div>
        <div class="text-center mb-2">
          <button class="results-search mt-1"  data-toggle="modal" data-target="#wineModal" role="button">Exit</button>
        </div>
      </div>
    </div>
  </div>
</div>
</section>


<section><!-- medalModal  -->
<div class="modal fade" id="medalModal" tabindex="-1"
     role="dialog" aria-labelledby="medalModalLabel" aria-hidden="true">
<div class="modal-dialog" modal role="document">
  <div class="modal-content form-elegant">
    <div class="modal-header">
      <p id="medalModalHead">Award Modal title</p>
      <img width=250  id=medalModalImg align=right src="" class="img-responsive rounded-circle">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>

    </div>
    <div class="modal-body mx-4">
        <div class=row>
          <div  class="col">
              <p id="medalModalTxt"></p>
          </div>
        </div>
    </div>
  </div>
</div>
</div>
</section>