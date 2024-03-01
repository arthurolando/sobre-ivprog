<?php

/*
 * LInE - Laboratory of Informatics in Education
 * http://line.ime.usp.br
 * 
 * PHP script to simulate the server side (to register the iLM content), here the iVProgH content.
 * Actually, this code only list the content sent by the iLM/iVProgH.
 * 
 */

session_start();
if (isset($_POST["src"])){
  $src = $_POST["src"];
  $id = time();
  $_SESSION["src_".$id] = $src;
  print $id;
  exit;
 }

print "ERROR";

?>