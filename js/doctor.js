// alert("Hello World")

$('.update').click(function () {
    // alert('hello world');
  var request = $.ajax({
    url: "../admin/editdoctor.php",
    method: "GET",
    data: {
      id: this.value
    },
    dataType: "json"
  });
   
  request.done(function( msg ) {
    console.log(msg);
    $("#id").val(msg.id);
    $("#fname").val(msg.docname);
    $("#oldemail").val(msg.docemail);
    $("#mail").val(msg.docemail);
    $("#dspecial").val(msg.specialties);
    $("#tel").val(msg.doctel);
  });
});


// View Doctor
$('.view').click(function () {
    // alert('hello world');
  var request = $.ajax({
    url: "../admin/editdoctor.php",
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


