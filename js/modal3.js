var modalBox_confirm_delete = document.getElementById("modalBox_confirm_delete");

var Btn_user_delete = document.getElementById("Btn_user_delete");

var closeBox = document.getElementsByClassName("closeBox")[0];

Btn_user_delete.onclick = function() {
  modalBox_confirm_delete.style.display = "block";
}

closeBox.onclick = function() {
  modalBox_confirm_delete.style.display = "none";
}

window.onclick = function(event) {
 if (event.target == Mainbar) {
    modalBox_confirm_delete.style.display = "none";
  }
}