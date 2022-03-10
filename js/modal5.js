var backgroundphotoUploadModal = document.getElementById("backgroundphotoUploadModal");

var backgroundphotoBtn = document.getElementById("backgroundphotoBtn");

var close_backgroundphoto_modal = document.getElementsByClassName("close_backgroundphoto_modal")[0];

backgroundphotoBtn.onclick = function() {
  backgroundphotoUploadModal.style.display = "block";
}

close_backgroundphoto_modal.onclick = function() {
  backgroundphotoUploadModal.style.display = "none";
}

//window.onclick = function(event) {
 // if (event.target == modal) {
  //  backgroundphotoUploadModal.style.display = "none";
 // }
//}