//Scroll bar at top
(function() {
  let inputs = "";
  $(window).keypress(function(key) {
    let i = String.fromCharCode(key.which);
    inputs += i;
    if (inputs.toLowerCase().includes("*rainbow*")) {
      inputs = "";
      alert('If you are an epileptic, please close this tab and never type the word "rainbow" again.');
      setInterval(function() {
        $('*').css('background', 'rgba(' + Math.random() * 256 + ',' + Math.random() * 256 + ',' + Math.random() * 256 + ',0.15)');
      }, 80);
    } else if (inputs.toLowerCase().includes("*firebird*")) {
      inputs = "";
      $('body').append('<div id="firebird"></div>');
      let path = 'url(firebird.gif)';
      $('div#firebird').css('z-index', '10000');
      $('div#firebird').css('background-image', path);
      $('div#firebird').css('position', 'absolute');
      $('div#firebird').css('height', '50vh');
      $('div#firebird').css('width', '50vw');
      $('div#firebird').css('background-repeat', 'no-repeat');
      $('div#firebird').css('background-size', 'contain');
      $('div#firebird').css('left', '0');
      $('div#firebird').css('top', '10%');
      setTimeout(function() {
        $("div#firebird").animate({
          left: "+=" + ($(document).width() * 1.25)
        }, 1000, function() {
          $('div#firebird').fadeOut('fast');
        });
      }, 8000);
    } else if (inputs.toLowerCase().includes('*invert*')) {
      $('html').css('filter','invert(100%)');
    }
  });

  function Scrollify() {
    var line = document.querySelector(".scroll-line"),
      scrollpos = window.pageYOffset,
      docheight = document.body.clientHeight,
      winheight = window.outerHeight,
      scrolled = (scrollpos / (docheight - winheight)) * 100;
    if (scrolled >= 100) {
      scrolled = 100;
    }
    line.style.width = (scrolled + '%');
  }
  window.addEventListener("scroll", Scrollify);
})();

//Always checking for actions
$(document).ready(function() {

  //Do not show drag button if device is mobile
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    document.getElementById("drag-label").style.display = 'none';
    document.getElementById("drag-switch").style.display = 'none';
  }

  //Fade away alerts
  $('body').fadeIn(200);
  $("#display").fadeTo(2500, 500).slideUp(500, function() {
    $("#display").slideUp(500);
  });

  //Set dark theme toggle
  if (getCookie("dark") == "true") {
    document.getElementById("dark-toggle").checked = true;
  }

  //Set theme toggle
  if (getCookie("theme") == "true") {
    document.getElementById("theme-toggle").checked = true;
  }

  //Set drag toggle
  if (getCookie("drag") == "true") {
    document.getElementById("drag-toggle").checked = true;
    $('img.drag').show("fast");
    $('.card-container').sortable({
      scroll: true,
      scrollSensitivity: 50,
      scrollSpeed: 5
    });
    $('.card-container').sortable("enable");
    $('.card-container').disableSelection();
    $('br.ui-sortable-handle').remove();
    $('.card').hover(function() {
      $('.card').css('cursor', 'grab');
    });
    $('.card').mousedown(function() {
      $('.card').css('cursor', 'grabbing');
    });

    $('.card').mouseup(function() {
      $('.card').css('cursor', 'grab');
    });

    $('.card').mouseleave(function() {
      $('.card').css('cursor', 'default');
    });
  } else if ($('#drag-toggle').prop("checked") == false) {
    $('img.drag').hide();
    $('.card-container').sortable({
      cancel: ".card-container"
    });
    $('.card-container').enableSelection();
    $('.card').hover(function() {
      $('.card').css('cursor', 'default');
    });
    $('.card').mousedown(function() {
      $('.card').css('cursor', 'default');
    });

    $('.card').mouseup(function() {
      $('.card').css('cursor', 'default');
    });
  }
});

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

//Allow popover for Help buttons
$(function() {
  $('[data-toggle="popover"]').popover()
})
