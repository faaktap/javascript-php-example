<div class="container-fluid">
    <div class="row">
        <div class="col-12 bg-dark text-white py-2">
            <h1 class="text-center">Michelangelo International Wine & Spirits Awards presents the 2020 Winners</h1>
        </div>
    </div>
</div>

<?php

$yearToShow = ' and c.competitionyear = "2020" ';

function i($str,$year) {
    if ($year == "2017") {
        return ("assets/img/" . $str);
    }

    if ($year == "2019") {
        return ("assets/img/" . $str);
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
        //Assume that string in good as is...(for 2020)
        //echo "We do not understand:" . $str . "<br>";
    }
    //echo $pic . " " . $str . "<br>";
	return ("assets/img/" . $str);
}

$qrsite =   get_site_url() . '/qr/index.php?product=';

//**************************************************************
//Load all the data into divs'
      $sqlawards = "select a.awardname
      , a.awardorder
      , a.awardpicture
      , a.awardnotes
      , c.competitionid
      , c.competitionname
      , c.competitionyear
      , count(*) wines
      from wp_award a
      , wp_competition c
      , wp_competitionwine s
      , rbexbesy_wpold.wp_awardwinner w
      where a.awardid = w.awardid
      and c.competitionid = w.competitionid
      $yearToShow
      and s.competitionwineid = w.competitionwineid
      group by a.awardname, c.competitionname,c.competitionyear
      order by c.competitionyear,a.awardorder";

      $awards = $wpdb->get_results($sqlawards);
      //echo "we retrieved " .$wpdb->num_rows . " awards";

      $tab2 = array();
      $prev = "";
      //opening div for each year's trophees  id=t2018trophees


      foreach ($awards as $award) {
       if ($prev == $award->competitionyear)  continue;
          $tab2[$award->competitionyear]  .= PHP_EOL . '<div id="t'. $award->competitionyear  .'trophees" class="mx-auto pb-3">';
          $tab2[$award->competitionyear]  .= PHP_EOL . 	'<div class="row">';
          $tab2[$award->competitionyear]  .= PHP_EOL . 		'<div class="col mx-auto mt-3">';
          $tab2[$award->competitionyear]  .= PHP_EOL . 		'</div>';
          $tab2[$award->competitionyear]  .= PHP_EOL . 	' </div>';
    	  $tab2[$award->competitionyear]  .= PHP_EOL . 	'<div class="row">';
    	  $tab2[$award->competitionyear]  .= PHP_EOL . 		'<div class="col mx-auto">';
    	  $tab2[$award->competitionyear]  .= PHP_EOL . 		'</div>';
	      $tab2[$award->competitionyear]  .= PHP_EOL . 	'</div>';
          $tab2[$award->competitionyear]  .= PHP_EOL . ' <div class="row mx-1">';
         $prev = $award->competitionyear;
      }

      $prev = "";
      //closing div for each year's trophees (we loop to many times, threfore we use the prev"-continue)
      foreach ($awards as $award) {
          //if ($prev == $award->competitionyear)  continue;
          $tab2[$award->competitionyear] .= PHP_EOL . '</div></div zml=divcloseyearandtrophee>'; //zml end two divs at award yearend here was a div close
          $prev = $award->competitionyear;
      }

//**************************************************************


//**************************************************************

       $sqlawardwinners = "select a.awardid
         , a.awardname
      , c.competitionyear
      , concat(w.winename,' ',w.vintageyear) winename
      , w.wineclassnotes
      , w.competitionwineid
      , f.website
      , f.wineryname
      , f.wineryid
      , a.awardorder
      , a.awardpicture
      , a.awardnotes
      from rbexbesy_wpold.wp_awardwinner m
      ,  wp_award a
      ,  wp_competition c
      ,  wp_competitionwine w
      ,  wp_winery f
      where a.awardid = m.awardid
      and c.competitionid = m.competitionid
      and m.competitionwineid = w.competitionwineid
      $yearToShow
      and f.wineryid = w.wineryid
      order by c.competitionyear, a.awardorder, f.wineryname";

       $awardwinners = $wpdb->get_results($sqlawardwinners);
  //echo "we retrieved " .$wpdb->num_rows . " award winners";


       $sqltrophywinners = "select a.trophyid
         , a.trophydesc
      , c.competitionyear
      , concat(w.winename,' ',w.vintageyear) winename
      , w.wineclassnotes
      , w.competitionwineid
      , f.website
      , f.wineryname
      , f.wineryid
      , a.trophypicture
      , a.trophynotes
      from  rbexbesy_wpold.wp_trophywinner m
      ,  wp_trophy a
      ,  wp_competition c
      ,  wp_competitionwine w
      ,  wp_winery f
      where a.trophyid = m.trophyid
      and c.competitionid = m.competitionid
      $yearToShow
      and m.competitionwineid = w.competitionwineid
      and f.wineryid = w.wineryid
      order by c.competitionyear,substr(a.trophyid,1,1), f.wineryname";

      $trophywinners = $wpdb->get_results($sqltrophywinners);
      $tab3 = array();
      $prev = "";

      foreach ($awardwinners as $winner) {
       if ($prev == $winner->competitionyear)  continue;
       $tab3[$winner->competitionyear]  = PHP_EOL . '<div id="w'. $winner->competitionyear . 'wines" style="display:block" zml=divopenyear_w>';
       $prev = $winner->competitionyear;
      }


      //--------------------------TROPHEES------------------------
      $prev = '';
      $cnt = 0;
      foreach ($trophywinners as $winner) {
        //   $cnt ++;
        //   echo $cnt . "w" .$winner->competitionyear . "Trop" . $winner->trophydesc. "<br>";
           if ($prev != $winner->competitionyear)  {
           $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="mx-auto" id="w' .$winner->competitionyear . 'Trop">';
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
          $tab3[$winner->competitionyear] .= '</a>';

          $tab3[$winner->competitionyear] .= '</p>';
          $tab3[$winner->competitionyear] .=	'  </div>';
          $tab3[$winner->competitionyear] .=  PHP_EOL . '  <div class="col-6 text-left">';
          $tab3[$winner->competitionyear] .=  ' <p class="text-left my-1">';
          $tab3[$winner->competitionyear] .=	'<p class="text-left my-1 text-orange fw600">' . $winner->trophydesc . ' WINNER</p>';
     $tab3[$winner->competitionyear] .= 		'<img style="max-width: 160px; height: auto;"  src="'. i($winner->trophypicture,$winner->competitionyear) .'">';
          $tab3[$winner->competitionyear] .= ' </div>';
          $tab3[$winner->competitionyear] .= PHP_EOL . '</div zml=divclosetrophy><hr><!--TrophyEndingDiv-->';
          $prev = $winner->competitionyear;
      }
      //we might need an closing div for the last  trophy
      $prev = '';
      foreach ($trophywinners as $winner) {
       if ($prev == $winner->competitionyear)  continue;
        $tab3[$winner->competitionyear]  .= PHP_EOL . '</div zml=divcloselasttrophy><!--END DIV FOR LAST TROPHY-->';
        $prev = $winner->competitionyear;
       }

      //--------------------------AWARDS------------------------
      $prev = "";
      $prevyear = "";
      $cnt = 0;
      foreach ($awardwinners as $winner) {
           if ($winner->awardname == "Trophy") {
             //echo "we leave this one<br>";
             continue; //We handle all trophies in the loop above
            }
       if ($prev != $winner->awardid) {
           if ($prev != "" && $prevyear == $winner->competitionyear) {
             $tab3[$winner->competitionyear] .= PHP_EOL . '</div><!--END DIV PreviousAwardListr-->' . PHP_EOL;
           }
           $tab3[$winner->competitionyear] .= PHP_EOL .'<div class="mx-auto" id="w' .$winner->competitionyear . substr($winner->awardname,0,4) . '" zml=divopenwyear>';
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
      foreach ($awardwinners as $winner) {
       if ($prev == $winner->competitionyear)  continue;
            $tab3[$winner->competitionyear] .= PHP_EOL . '</div><!--LastAwardEndingDiv-->';
            $tab3[$winner->competitionyear] .= PHP_EOL . '</div zml=divcloseyear><!--YearEndingDiv-->';
            $prev = $winner->competitionyear;
      }

//End of Load all the data into divs
//**********************************
?>


<section>


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


<script type="text/javascript" src="assets/js/template-results-pierre-select.js"></script>