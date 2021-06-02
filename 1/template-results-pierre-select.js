//Geen effek. die onderste event listener steek die select weg 9sit 'n DIV bo oor'
//jaar.addEventListener('change', function (e) { checkYearAlert(e); });
//trofee.addEventListener('change', function (e) { checkAwardAlert(e); });


var x, i, j, selElmnt, a, b, c;
var useID;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
 
  useID = x[i].id;
  
  selElmnt = x[i].getElementsByTagName("select")[0];
  
  //console.log('found custom-select :' + useID);
  if (!useID) {
	  console.log('please give your element an ID!!!');
	  useID = 'poep'+i;
  }
  
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.setAttribute("class", useID);
  a.setAttribute("id", useID + "-m" + i);
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  //console.log('Created DIV under custom-select with ' + a.innerHTML);
  x[i].appendChild(a);
  
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  b.setAttribute("id", useID +"-o" + i);
  for (j = 1; j < selElmnt.length; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.setAttribute("id", useID +"-n" + i + j);
    c.innerHTML = selElmnt.options[j].innerHTML;
    //console.log('Created INSIDEDIV and evtListener with ' + c.ID + ':' + c.innerHTML);
    c.addEventListener("click", function(evt) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        console.log('clicked on event id ' + this.id);
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            
//zml code to pass the selected data to template-results.js function            
            console.log('Found the selection -' + h.ID + ':' + h.innerText + '-');
            if (h.innerText.substring(0,1) == '2') { 
               currentYear = h.innerText;
               console.log('currentYear ' + currentYear);
               zmlYear(currentYear);              
            } else {
              currentAward = h.innerText;
              console.log('currentAward:' + currentAward);
              currentAward = currentAward.substring(0,4);
              console.log('currentAward:' + currentAward);
              newPlaceToGo = document.getElementById('t' + currentYear + currentAward);
            }
//end of zml code to pass the selected data to template-results.js function

            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}

function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);