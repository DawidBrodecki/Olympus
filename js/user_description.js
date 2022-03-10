function myFunction_description() {
  var x = document.getElementById("descritpion_show");
  if (x.style.display === "block") {
    x.style.display = "none";
	
  } else {
    x.style.display = "block";
	
  }

}

  document.addEventListener('mouseup', function(e) {
    var descritpion_show = document.getElementById('descritpion_show');
    if (!descritpion_show.contains(e.target)) {
        descritpion_show.style.display = 'none';
    }
});

	$(document).ready(function(){
		$("#makeClick").click(function(){
		$("#make_focus").focus();
		$("#make_focus").click();
		});
	});
											
	$(document).ready(function(){
	$("#makeClick").click(function(){
	$("#description_add_toggle").show();
	color = button.style.backgroundColor = color === '#57595b' ? '#3a3b3c' : '#57595b';
	$("#make_focus2").focus();
	$("#make_focus2").click();
		});
	});


$(document).ready(function(){
  $(".js_toggle").click(function(){
    $("#description_add_toggle").toggle();
	 $("#make_focus2").focus();
	 $("#make_focus2").click();
  });
});

var button = document.getElementById('description_add_btn');
var color = button.style.backgroundColor;
button.addEventListener('click', function () {
  // this function executes whenever the user clicks the button
  color = button.style.backgroundColor = color === '#57595b' ? '#3a3b3c' : '#57595b';
});



