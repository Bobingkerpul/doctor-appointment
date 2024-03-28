// View Doctor Patient Side
$('.view').click(function () {
    // alert('hello world');
  var request = $.ajax({
    url: "../patient/viewdoctors.php",
    method: "GET",
    data: {
      id: this.value
    },
    dataType: "json"
  });
   
  request.done(function( msg ) {
    $("#id").val(msg.id);
    $("#fullname").val(msg.docname);
    $("#oldemail").val(msg.docemail);
    $("#email").val(msg.docemail);
    $("#position").val(msg.specialties);
    $("#cnumber").val(msg.doctel);
  });
})