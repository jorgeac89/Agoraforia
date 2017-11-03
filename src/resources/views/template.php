<?php
$forums=selectQuery("SELECT id, name FROM forums WHERE visible=TRUE AND gid IS NULL ")
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<base href="<?php echo PAGE_DIR; ?>"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link rel="shortcut icon" href="resources/images/favicon.ico" />
		<link rel="stylesheet" href="resources/css/agoraforia.css" type="text/css"/>
		<script type="text/javascript" src="resources/js/agoraforia.js"></script>
		<title>Agoraforia</title>
	</head>
	<body>
		<h1>
			<a href="index.php"><img src="resources/images/logo.png"/></a>
		</h1>
		<div id="navigationBar">
			<span class="pullLeft">
				<span><a href="index.php"><img src="resources/images/homeIcon.png" class="icon"/></a></span>
<?php if(isset($_REQUEST["group"])){ ?>
				<span><a href="group.php?id=<?php echo $_REQUEST["group"][0]["id"]; ?>"><?php echo $_REQUEST["group"][0]["name"]; ?></a></span>
<?php } ?>
<?php if(isset($_REQUEST["forum"])){ ?>
				<span><a href="forum.php?id=<?php echo $_REQUEST["forum"][0]["id"]; ?>"><?php echo $_REQUEST["forum"][0]["name"]; ?></a></span>
<?php } ?>
<?php if(isset($_REQUEST["post"])){ ?>
				<span><a href="post.php?id=<?php echo $_REQUEST["post"][0]["id"]; ?>"><?php echo $_REQUEST["post"][0]["title"]; ?></a></span>
<?php } ?>
			</span>
			<span class="pullRight">
<?php if(isset($_SESSION["uid"])){ ?>
				<span><a href="createmessage.php"><img src="resources/images/messageIcon.png" class="icon"/></a></span>
				<span><a href="createpost.php"><img src="resources/images/newPostIcon.png" class="icon"/></a></span>
				<span><a href="drive.php"><img src="resources/images/driveIcon.png" class="icon"/></a></span>
				<span><a href="creategroup.php"><img src="resources/images/addGroupIcon.png" class="icon"/></a></span>
				<span><a href="user.php?id=<?php echo $_SESSION["uid"]; ?>"><img src="resources/images/userIcon.png" class="icon"/></a></a></span>
				<span>
					<form action="" method="post">
						<input type="hidden" name="reloadSession"/>
						<input type="image" src="resources/images/reloadIcon.png" class="icon"/>
					</form>
				</span>
				<span>
					<form action="" method="post">
						<input type="hidden" name="logout"/>
						<input type="image" src="resources/images/logoutIcon.png" class="icon"/>
					</form>
				</span>
				<span id="userNick"><?php echo $_SESSION["nick"]; ?></span>
<?php }else{ ?>
				<span>
					<form action="" method="post">
						<input type="hidden" name="login"/>
						<input type="text" name="nick" size="7"/>
						<input type="password" name="password" size="7"/>
						<input type="image" src="resources/images/loginIcon.png" class="icon"/>
					</form>
				</span>
				<span>
					<a href="reg.php"><img src="resources/images/regIcon.png" class="icon"/></a>
				</span>
<?php } ?>
			</span>
		</div>
		<div id="content">
			<div id="mainBar">
<?php include($FORWARD); ?>
			</div>
			<div id="vertBars">
				<div class="vertBar">
					<h3>Foros</h3>
<?php foreach($forums as $forum){ ?>
					<div>
						<a href="forum.php?id=<?php echo $forum["id"]; ?>"><?php echo $forum["name"]; ?></a>
					</div>
<?php } ?>
				</div>
<?php if(isset($_SESSION["uid"])){ ?>
				<div class="vertBar">
					<h3>Grupos propios</h3>
<?php	if(count($_SESSION["ownGroupsIds"])>0){ ?>
					<form action="" method="post">
<?php		for($i=0; $i<count($_SESSION["ownGroupsIds"]); $i++){ ?>
						<div>
							<a href="group.php?id=<?php echo $_SESSION["ownGroupsIds"][$i]; ?>"><?php echo $_SESSION["ownGroupsNames"][$i]; ?></a>
							<button type="submit" name="deleteGroup" value="<?php echo $_SESSION["ownGroupsIds"][$i]; ?>" class="button">
								<img src="resources/images/deleteIcon.png" class="smallIcon"/>
							</button>
						</div>
<?php		} ?>
					</form>
<?php	} else{ ?>
					<div>
						<p>No tienes grupos propios</p>
					</div>
<?php	} ?>
				</div>
				<div class="vertBar">
					<h3>Grupos</h3>
<?php 	if(count($_SESSION["groupsIds"])>0){?>
					<form action="" method="post">
<?php		for($i=0; $i<count($_SESSION["groupsIds"]); $i++){ ?>
						<div>
							<a href="group.php?id=<?php echo $_SESSION["groupsIds"][$i]; ?>"><?php echo $_SESSION["groupsNames"][$i]; ?></a>
							<button type="submit" name="leaveGroup" value="<?php echo $_SESSION["groupsIds"][$i]; ?>" class="button">
								<img src="resources/images/deleteIcon.png" class="smallIcon"/>
							</button>
						</div>
<?php		} ?>
					</form>
<?php 	}else{?>
					<div>
						<p>No perteneces a ningún grupo</p>
					</div>
<?php 	}?>
				</div>
<?php 	if(count($_SESSION["invitationsGroupsIds"])>0){?>
				<div class="vertBar">
					<h3>Invitaciones</h3>
					<form action="" method="post">
<?php		for($i=0; $i<count($_SESSION["invitationsGroupsIds"]); $i++){ ?>
						<div>
							<p><?php echo $_SESSION["invitationsGroupsNames"][$i]; ?></p>
							<button type="submit" name="acceptInvitation" value="<?php echo $_SESSION["invitationsGroupsIds"][$i]; ?>" class="button">
								<img src="resources/images/acceptIcon.png" class="smallIcon"/>
							</button>
						</div>
<?php		} ?>
					</form>
				</div>
<?php 	} ?>
<?php } ?>
			</div>
		</div>
	</body>
</html>
