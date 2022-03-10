var modalBox_user_photo = document.getElementById("modalBox_user_photo");

var Btn_user_photo = document.getElementById("Btn_user_photo");

var closeBox_user_photo = document.getElementsByClassName("closeBox_user_photo")[0];

Btn_user_photo.onclick = function() {
  modalBox_user_photo.style.display = "block";
}

closeBox_user_photo.onclick = function() {
  modalBox_user_photo.style.display = "none";
}

//window.onclick = function(event) {
 // if (event.target == modal) {
  //  modalBox_user_photo.style.display = "none";
 // }
//}