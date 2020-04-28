$(document).ready(function() {
  let prev_val = '';
  $('#searchbar').focus(function(){
    $('#searchbar').val('');
  });
  $(".searchForm").submit(function(e) {
    let date = new Date();
    e.preventDefault();
    $('.footer-bottom').hide();
    $('div.card-container').fadeOut(100);
    $('div.card-container').empty();

    var form = $(this);
    var url = form.attr('action');
    let inputval = $('#searchbar').val();

    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(), // serializes the form's elements.
      success: function(data) {
        $('div.card-container').append(data);
        if(data.length < 1){
          $('div.card-container').append("<h3 class='center'>Search Term: '"+inputval+"' Not Found in Database</h3>");
        }
        $('div.card-container').fadeIn(100);
        if($('h3').is(':visible') && data.length > 0){
          $('h3').fadeOut(25);
          $('hr').remove();
        }
      }
    });
    $('.footer-bottom').fadeIn(100);
    $('#searchbar').val('');
    if($(window).width() < 992) {
      $('.navbar-toggler').click();
    }
  });
});
