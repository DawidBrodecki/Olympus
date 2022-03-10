var modal = document.getElementById("incoming_invitations");
var modal1 = document.getElementById("outgoing_invitations");

var myBtn = document.getElementById("myBtn");
var TogleToOutgoing = document.getElementById("TogleToOutgoing");
var TogleToIncoming = document.getElementById("TogleToIncoming");

var closeX = document.getElementsByClassName("closeX")[0];
var closeX2 = document.getElementsByClassName("closeX2")[0];
var CloseIncoming = document.getElementsByClassName("CloseIncoming")[0];
var CloseOutgoing = document.getElementsByClassName("CloseOutgoing")[0];

myBtn.onclick = function() {
  incoming_invitations.style.display = "block";
}

closeX.onclick = function() {
  incoming_invitations.style.display = "none";
}

CloseIncoming.onclick = function() {
 incoming_invitations.style.display = "none";
}

TogleToOutgoing.onclick = function() {
  outgoing_invitations.style.display = "block";
}

closeX2.onclick = function() {
  outgoing_invitations.style.display = "none";
}

CloseOutgoing.onclick = function() {
 outgoing_invitations.style.display = "none";
}

TogleToIncoming.onclick = function() {
  incoming_invitations.style.display = "block";
}



window.onclick = function(event) {
  if (event.target == container) {
    incoming_invitations.style.display = "none";
  }
}

