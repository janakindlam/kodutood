<?php session_start();
include_once("head.html");
$pildid = array("nameless1.jpg", "nameless2.jpg", "nameless3.jpg", "nameless1.jpg", "nameless5.jpg", "nameless6.jpg");
$page = "pealeht";
if (!empty($_GET)){
    $page = $_GET["page"];
}
switch ($page){
    case "pealeht":
        include_once("pealeht.php");
        break;
    case "galerii":
        include_once("galerii.php");
        break;
    case "vote":
        include_once("vote.php");
        break;
    case "tulemus":
        include_once("tulemus.php");
        break;
}
include_once("foot.html");
?>