<?php
include("scripts/init.php");

$forums=selectQuery("
		SELECT 
			f.id id, 
			f.name name, 
			f.description description, 
			(SELECT 
				count(p.id) 
			FROM 
				posts p 
			WHERE 
				p.fid = f.id AND
				p.visible = TRUE) posts, 
			(SELECT 
				count(c.id) 
			FROM 
				comments c, 
				posts p 
			WHERE 
				p.fid = f.id AND
				c.pid = p.id AND
				c.visible = TRUE) comments 
		FROM 
			forums f 
		WHERE 
			f.visible = TRUE AND
			f.gid IS NULL ");

$_REQUEST["forums"]=$forums;
$FORWARD = findForward("forums");
include(TEMPLATE_FILE);
?>
