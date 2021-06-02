var currentYear = '';
var currentAward = '';
var newPlaceToGo = '';


var zmlcon = function(pmessage) {
    window.name = 'michelangeloawards';
   // console.log(pmessage);
}; 
var zshow = function (elem) {
	elem.style.display = 'block';
};
var zhide = function (pElem) {
	pElem.style.display = 'none';
};

function checkYearAlert(evt) {
    zmlcon('checkAlert-Year pressed');
    if (evt) {
      //console.clear();  
      currentYear = evt.target.value;
      zmlcon('Current Year:' + currentYear + ' on window ' + window.name);
      zmlYear(evt.target.value);
      showResult('');  //clean out the search area - for incase they search before
    } else {
      zmlcon('that year wont work');
    }
    zmlcon('YEAR: - Current year Selected is ' + currentYear);
    document.getElementById('searchresults').innerHTML = "";
    if (testjQuery() === 0) { testjQuery(); }
       
}

function checkAwardAlert(evt) {
    //we need to build the id name
    //t2018Trop
    //and send it to zmlTrophy with id.
    zmlcon('checkAlert-Award pressed');
    if (evt) {
      currentAward = evt.target.value.substring(0,4);
      zmlcon('currentAward:' + currentAward);
      newPlaceToGo = document.getElementById('t' + currentYear + currentAward);
    } else {
      zmlcon('that award wont work..');    
    }
    zmlcon('AWARD : - Current award Selected is ' + currentAward);
    document.getElementById('searchresults').innerHTML = "";
}

function ShowIt() {
    //Double check if our values are filled in somewhere - ie. If back button
    //was pressed, the selected values are not loaded.
    if (!currentYear) {
       x = document.getElementsByClassName("yeardrop");
       console.log('yea' + x.length);
       if  (x[0].innerHTML)  currentYear = x[0].innerHTML.trim();
    }
    if (!currentAward) {
       x = document.getElementsByClassName("awarddrop");
       console.log('awa' + x.length);
       if  (x[0].innerHTML)  currentAward = x[0].innerHTML.trim().substring(0,4);
    }    
    
    
    //Show the search when year and award was selected
    zmlcon('SEARCH CLICKED : - with ' + currentYear + 'and ' + currentAward + ' on window ' + window.name);
    newPlaceToGo = document.getElementById('t' + currentYear + currentAward);
    if (newPlaceToGo) {
        //zmlcon('Going to ' + newPlaceToGo.id);
        zmlTrophy(newPlaceToGo);
    } else {
        zmlcon('we have no good selection' + '(t' + currentYear + currentAward + ')');
        alert('You need to select a year and a award before pressing the search button! If you really want to know the results for '+currentYear+', please reserve a seat for the Awards Function.');
    }
}


function zmlYear(syear) {
  var id = syear;
  //zmlcon('zmlyear clicked - id = ' + id);
  if (testjQuery() === 0) return;
  //clean out the saechresults if used before..
  $("#searchresults").html('');

   t2017trophees.hide();
   w2017wines.hide();
   t2018trophees.hide();
   w2018wines.hide();
   t2019trophees.hide();
   w2019wines.hide();
   t2020trophees.hide();
   w2020wines.hide();   
  if(id === '2017'){
   t2017trophees.show();
   w2017wines.show();
   zmlcon('show 2017! ');
  }
  if (id === '2018') {   
   t2018trophees.show();
   w2018wines.style.display = "block";
   zmlcon('show 2018! ');
  }
  else if (id === '2019') {   
   t2019trophees.style.display = "block";
   w2019wines.style.display = "block";
   zmlcon('show 2019! ');
  }
  else if (id === '2020') {   
   t2020trophees.style.display = "block";
   w2020wines.style.display = "block";
   zmlcon('show 2020! ');
  }  
}


function zmlTrophy(t) {
   var winetodisplay = "w" + t.id.substring(1,10);
   zmlcon('zmlTrophy ' + t.id + ' ' + winetodisplay);
   var theelement = document.getElementById(winetodisplay);
   if (theelement == "undefined") {
       alert("Not available yet!");
       return;
   }
   var theparent = theelement.parentElement;
   var thechildren = theparent.childNodes;
   //zmlcon('theparent=' + theparent.id);
   
   for (i = 0; i < thechildren.length; i++) {
      if (thechildren[i].tagName == "DIV") {
       thechildren[i].style.display  = "none";
       //zmlcon('zmlTrophy HideAllTheChildren: ' + thechildren[i].id);

    }
       }
   theelement.style.display = "inherit";
   //zmlcon('theVisibleOne=' + theelement.id);
   zmlScrollTo(winetodisplay);
   //zmlcon('zmlTrophy End: ' + winetodisplay + 'is active');
 }

function sProducer(t) {
    zmlcon('sProducer ' + t.dataset.wid);
    pakkie = {t_dataset_wid: t.dataset.wid,
              method: "AwardWinery"};
    getData(pakkie);
}

function doit(wineid) {
  zmlcon('doit - wineid');
  href = 'https://maiwsa.co.za/qr/index.php?product=' + wineid;
  window.open(href , 'michelangeloawardsqrpage');
}

//-------------------------------------------------
//Take the user to s place on the screen
function zmlScrollTo(pid) {
document.getElementById('KomOnsScrollTotHier').scrollIntoView({behavior: 'smooth'});
// will scroll to element with id=pid
}



function saveLog(str) {
     zmlcon('saveLog');
   pakkie =  {method:"dolog",
             user:"zmlfolder",
             message:"SearchCriteria: " + str + " used"};
   logData(pakkie);
}

//-------------------------------------------------
//Show search results when user type in search box.
function showResult(str) {
 zmlcon('SR: ' + str + str.length );
 if (str.length === 0) {
    document.getElementById("searchresults").style.display = "none";
    document.getElementById("howmany").style.display = "none";
 }
 else
     t2017trophees.style.display = "none";
     w2017wines.style.display = "none";
     t2018trophees.style.display = "none";
     w2018wines.style.display = "none";
     t2019trophees.style.display = "none";
     w2019wines.style.display = "none";
     t2020trophees.style.display = "none";
     w2020wines.style.display = "none";
     if (str == "daarbo") {
         getSearchData (document.getElementById("searchvalue").value);
     } else {
         getSearchData(str);
     }
}

function doit(wineid) {
   href = 'https://maiwsa.co.za/qr/index.php?product=' + wineid;
   window.open(href);
}

function testjQuery() {
    if (typeof $ == 'undefined') {
        //alert('no jquery - ajax will not work');
        zmlcon('jq not loaded');
        loadjQueryOnTheFly();
        return(0);
    }
    if ((typeof $ !=- 'undefined') && ($.fn.jquery[0] !== '3')) {
      //alert('jQuery version to low : ' + $.fn.jquery);
      zmlcon('jq version low ' + $.fn.jquery);
      loadjQueryOnTheFly();
      return(0);
    }
   // zmlcon('jq version good ' + $.fn.jquery);
    return(1);
}

function loadjQueryOnTheFly() {
  zmlcon('load my jQuery');    
  var zScript = document.createElement( 'script' ); 
  zScript.type = 'text/javascript'; 
  zScript.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js';
  document.documentElement.childNodes[0].appendChild( zScript );
  //zmlcon('test my jQuery ' +  $('div').length);
  var jQuery3 = jQuery;
  if (jQuery) {
     jQuery.noConflict(true);
  }
  setTimeout(function(){
    var zScript = document.createElement( 'script' ); 
    zScript.type = 'text/javascript'; 
    zScript.src = 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js';
    document.documentElement.childNodes[0].appendChild( zScript ); 
    zmlcon('booty?');
  },3000);
  
  
  //zmlcon('test my jQuery ' +  jQuery3('div').length);
  return;
}


//---------------------
//ajax read award data
function award(t) {
    zmlcon('Award ' + t.dataset.name);
    pakkie = {t_dataset_name: t.dataset.name,
              method: "Award"};
    getData(pakkie);
}

//---------------------
//ajax read trophy data
function trophy(t) {
    zmlcon('Trophy ' + t.dataset.name);
    pakkie = { src: t.src,
             t_dataset_name: t.dataset.name,
             method: "Trophy"};
    getData(pakkie);
}



//---------------------
//process search data
function getSearchData(str) {
    if (testjQuery() === 0) testjQuery();
    if (testjQuery() === 0) {
        zmlcon('jQuery not loaded yet!');
    } else {
        $('#loader-image').show();
            
    }  

    pakkie = {t_dataset_name: str,
               method: "searchawards"};
    $.ajax({
         type: "POST",
         url: "/zml/php/zmlquery.php",
         data: JSON.stringify(pakkie),
         success: function(response)
         {
             $('#loader-image').hide();
             response = JSON.parse(response);
             if (typeof response.error == "undefined"){
                //generate the payload
                 var fillme = '<br>'
                 + '<div class="row" style="height: 40px; background-color: #333332;">'
				 + ' <div class="col-6 text-left text-white">'
				 + '  <h5 class="h5-responsive fw600 ml-1 pt-1 mb-0 text-orange">'
				 + '  Produced By</h5>'
				 + ' </div>'
				 + ' <div class="col-6 text-left text-white">'
				 + '  <h5 class="h5-responsive fw600 ml-1 pt-1 mb-0">'
				 + '   Winners with ' + str + '</h5></div>'
				 + ' </div>'
				 + '</div>'				 
                 for(var i = 0; i < response.length; i++) {
                     var row = response[i];
                     let titleInfo = '';
                     if (row.winenotes) {
                         titleInfo = row.winenotes;
                     }
                     if (row.foodnotes) {
                         if (titleInfo) { titleInfo + '\n' + row.foodnotes;} else {titleInfo = row.foodnotes;}
                     }
                     fillme += ''
					  + '<div class="row">'
					  + ' <div class="col-6 mt-3"> '
					  + ' <p class="text-left my-1"></p>'
					  + ' <p class="text-left my-1">'
					  + '  <a style="color: #B99C31;" target="_winery" '
					  + 'title="Go to winemaker : "+row.producer onclick="sProducer(this);" data-wid="'+ row.wineryid +'" role="button">'
					  + row.producer
					  + ' </a></p></div>'

					  + ' <div class="col-6 mt-3">'
					  + '  <p class="text-left my-1">'
                      + '   <a style="color: #868686; font-weight: 600;" target=_wine'
					  + '   href=https://maiwsa.co.za/qr/?product='+row.wineid + ' title="' + titleInfo + '"> '
					  +     row.product + ' ' + row.year
					  + ' </a></p>'
					  + ' </div>'
					  + '</div>'					  
					  + '<hr>'				  
                }
                fillme += '';
              
                $('#howmany').html(response.length).show();
                $("#searchresults").html(fillme).show();
                //saveLog(str);
                return true;
            } else {
                //alert('error on ajax : ' + response.error + "\n" + JSON.stringify(response) + JSON.stringify(pakkie));
                var goodone = str.substring(0,str.length-1);
                $("#searchvalue").val(goodone).show();
                //alert(goodone);
                return false;
            }
              },
      error: function(response) {
           //$('#loader-image').hide(); //edge complaint
           zmlcon('some error');
      }
          });
}

//Image Mapping
function zmlimap(str,year) {
    if (year == "2017") {
        return ("https://maiwsa.co.za/wp-content/themes/betheme/assets/images/" + str);
    }
    switch (str) {
    case "award-trophy.png":
        str = "award-2018-trophy-w160.png";
        break;
    case "award-platinum.png":
        str = "award-2018-platinum-w160.png";
        break;
    case "award-doublegold.png":
        str = "award-2018-doublegold-w160.png";
        break;
    case "award-gold.png":
        str = "award-2018-gold-w160.png";
        break;
    case "award-silver.png":
        str = "award-2018-silver-w160.png";
        break;
    }
	return ("https://maiwsa.co.za/wp-content/themes/betheme/assets/images/" + str);
}


//---------------------
//process search data - AwardWinery or Medal
function getData(udata){
  if (testjQuery() === 0) return;
  if (udata.method == '') alert("we need a method!");
  zmlcon('fetch:'+udata.method);
  $.ajax({
      type: 'POST',
      url: '/zml/php/zmlquery.php',
      data: JSON.stringify(udata),
      contentType: 'application/json',
      success: function(response) {
       response = JSON.parse(response);
       if (typeof response.error == "undefined") {
        if(udata.method == "AwardWinery") {
         document.getElementById("wineModalHead").innerHTML = "<h3 class=h3-responsive text-black>" + response[0].producer +  "</h3>";
         var fillme = '<table class="table table-striped table-compact">';
         for (var i = 0; i < response.length; i++) {
           var row = response[i];
           fillme += '<tr><td align=left><a onclick="doit('
                  + row.wineid 
                  + ')" > '
                  + row.product + ' ' 
                  + row.vintageyear 
                  + '</a> <td class="text-left">' 
                  + row.competitionyear + "&nbsp" + row.award ;
         }
         fillme += '</table>';
         document.getElementById("wineModalTxt").innerHTML =
            "<div> <b>Competition Winners</b><br> " + fillme + "</div>"
            +"<hr><p class=text-center>"
            +response[0].website + "</p>";
            
        document.getElementById("wineModalImg").src = response[0].picture;
        
        document.getElementById("wineModalImg").title = response[0].notes;
        
        $('#wineModal').modal('show');
      } else {
        document.getElementById("medalModalHead").innerHTML = "<h3 class='h3-responsive text-black'>"
                                                            + response[0].name
                                                            +  "</h3>";
        document.getElementById("medalModalTxt").innerHTML ="<blockquote class=blockquote>"	
                                                            + response[0].notes
                                                            + "<footer class=blockquote-footer>Provided by <cite title=Lorraine Immelman>Lorraine Immelman</cite></footer>"
                                                            + "</blockquote>";
        document.getElementById("medalModalImg").src =  response[0].picture;
        //zmlcon('show medalemodal for ' + response[0].name);
        jQuery('#medalModal').modal('show');
      }
        return true;
    } else
    {
      zmlcon('error on ajax : ' + response.error + "/n" + JSON.stringify(response) + JSON.stringify(udata));
      return false;
          }
     }});
}
