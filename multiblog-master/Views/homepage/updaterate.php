<?php
include_once("../../Config/db.php");

$instance = db::getInstance();
$bdd = $instance->getConnect();

$query = "UPDATE article SET likes = likes + 1 WHERE id = ".$_POST['article_id']."";
$search = $bdd->prepare($query);
$search->execute();


$res = $_POST['rate'] + 1

echo "test"; 


?>