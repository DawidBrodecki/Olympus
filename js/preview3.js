  var loadFile3 = function(event) {
    var preview3 = document.getElementById('preview3');
    preview3.src = URL.createObjectURL(event.target.files[0]);
    preview3.onload = function() {
      URL.revokeObjectURL(preview3.src) 
    }
  };