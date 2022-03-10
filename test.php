<?php

	session_start();
	
?>

<!DOCTYPE html>
<html>
<head>
    <title>TEST</title>
<link rel="stylesheet" type="text/css" href="test.css">
<script type="text/javascript" src="jquery-1.11.1.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
#myDIV {
  width: 100%;
  padding: 50px 0;
  text-align: center;
  background-color: lightblue;
  margin-top: 20px;
  display:none;

}

textarea[name=testarea] 
{
  resize: none;
  border-radius: 20px 20px 20px 20px;
  outline:0;
  padding: 1.4vh;
  max-width:45em;
  width:61vh;
  background-color:#e9e9e9;
}

textarea:hover, textarea:focus
{
	 background-color:#f9f9f9;
}

#autoresizing 
{
  display: block;
  overflow: hidden;
  
}
</style>
</head>
<body>

<div id="container">

<body>
  <textarea id="my-input" cols="30" rows="4">
This is example text...
  </textarea>
  <br />
  <button onclick="makeFocus()">Click me and make focus on textarea</button>
  <script>
    
    var input = document.getElementById('my-input');

    function makeFocus() {
    	input.focus();
    }
   
  </script>
</body>
</html>
</body> 
</html>   
 