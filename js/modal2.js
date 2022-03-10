var modalBox = document.getElementById("modalBox");

var uploadbtn = document.getElementById("uploadbtn");

var closeBox = document.getElementsByClassName("closeBox")[0];

uploadbtn.onclick = function() {
  modalBox.style.display = "block";
}

closeBox.onclick = function() {
  modalBox.style.display = "none";
}

//window.onclick = function(event) {
 // if (event.target == modal) {
  //  modalBox.style.display = "none";
 // }
//}