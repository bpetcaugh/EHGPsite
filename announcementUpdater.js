$(document).ready(function() {
  setInterval(function() {
    $.ajax({
      type: "POST",
      url: 'showAnnouncements.php',
      data: '',
      success: function(data) {
        $('div.card-container').append(data);
      }
    });
  }, 1000);
});
