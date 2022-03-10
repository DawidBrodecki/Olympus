  var loadFile4 = function(event) {
    var preview3 = document.getElementById('preview4');
    preview4.src = URL.createObjectURL(event.target.files[0]);
    preview4.onload = function() {
      URL.revokeObjectURL(preview4.src) 
    }
  };