// This script is for the navigation in header.php and loader.php
    function loader(whereTo) {
        let laaiDitHier = document.getElementById('body');

        kryDitVanServer(whereTo, laaiDitHier)

    }

    function kryDitVanServer(stuffToLoad, placeToPutIt) {
        let praatmetserver = {
        task: 'laaiData',
        menuClick: stuffToLoad
    }

    let hoeOnsDitWilTerugkry = {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=UTF-8'
        },
        body: JSON.stringify(praatmetserver)
    }

    fetch('loader.php', hoeOnsDitWilTerugkry)
        .then(response => {
            if (!response.ok) {
                console.log('Serion Error:', response)
                alert('some serious error')
            }
            return response.json()
        })
        .then(responseAsJson => {
            placeToPutIt.innerHTML = responseAsJson.payload
        })
    }

// This script is used in home.php for the sponsor links

    function goTo(link) {
        let answer = window.open(link, 'sponsor');
        console.log(answer, link)
    }

// This script is used in home.php to display the countdown timer

    // Set the date we're counting down to
    var countDownDate = new Date("Jun 1, 2021 00:00:01").getTime();

    // Update the count down every 1 second
    var x = setInterval(function () {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="countdown"
    if (!document.getElementById("countdown")) return;
        document.getElementById("countdown").innerHTML =
            "<div class='row'>" +
            "<div class='col-3 silver text-center'>" +
            "<h3>" + days + "</h3></div>" +
            "<div class='col-3 silver text-center'>" +
            "<h3>" + hours + "</h3></div>" +
            "<div class='col-3 silver text-center'>" +
            "<h3>" + minutes + "</h3></div>" +
            "<div class='col-3 silver text-center'>" +
            "<h3>" + seconds + "</h3></div>" +
            "</div>" +
            "<div class='row'>" +
            "<div class='col-3 old-gold text-center'>" +
            "<h4>days</h4></div>" +
            "<div class='col-3 old-gold text-center'>" +
            "<h4>hours</h4></div>" +
            "<div class='col-3 old-gold text-center'>" +
            "<h4>minutes</h4></div>" +
            "<div class='col-3 old-gold text-center'>" +
            "<h4>seconds</h4></div>" +
            "</div>";

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "EXPIRED";
    }
    }, 1000);

// This script is for enter.php Special Entries

    function openTab(evt, tabName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }