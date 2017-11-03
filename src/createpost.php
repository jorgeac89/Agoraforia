<?php
include("scripts/init.php");

if(!isset($_SESSION["uid"])){
	header("Location: index.php");
	exit;
}

if(isset($_REQUEST["title"], $_REQUEST["content"], $_REQUEST["forum"]) && isPoster($_REQUEST["forum"])){
	if(addPost($_REQUEST["title"], $_REQUEST["content"], $_SESSION["uid"], $_REQUEST["forum"])){
		$post = selectQuery("SELECT MAX(p.id) id FROM posts p ");
		header("Location: post.php?id=".$post[0]["id"]."");
		exit;
	}
}
$_REQUEST["posterIds"] = $_SESSION["posterIds"];
$FORWARD = $FORWARD = findForward("postEditor");
include(TEMPLATE_FILE);
?>
