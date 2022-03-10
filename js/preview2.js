  var loadFile2 = function(event) {
    var preview2 = document.getElementById('preview2');
    preview2.src = URL.createObjectURL(event.target.files[0]);
    preview2.onload = function() {
      URL.revokeObjectURL(preview2.src) 
    }
  };