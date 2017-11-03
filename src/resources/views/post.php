<div id="<?php echo $_REQUEST["post"][0]["id"]; ?>" class="post">
<?php if(isAdmin($_REQUEST["post"][0]["fid"])){ ?>
	<div class="toolBar editBar">
		<form action="" method="post">
			<button type="submit" name="deletePost" value="<?php echo $_REQUEST["post"][0]["id"]; ?>" class="button">
				<img src="resources/images/deleteIcon.png" class="icon"/>
			</button>
<?php 	if(isset($_REQUEST["editPost"]) && $_REQUEST["editPost"] == $_REQUEST["post"][0]["id"]){?>
			<button type="submit" form="postEditorForm" class="button" value="<?php echo $_REQUEST[post][0][id]; ?>">
				<img src="resources/images/saveIcon.png" class="icon"/>
			</button>
<?php 	} else { ?>
			<button type="submit" name="editPost" value="<?php echo $_REQUEST["post"][0]["id"]; ?>" class="button">
				<img src="resources/images/editIcon.png" class="icon"/>
			</button>
<?php 	} ?>
		</form>
	</div>
<?php } ?>
<?php if(isset($_REQUEST["editPost"]) && $_REQUEST["editPost"] == $_REQUEST["post"][0]["id"]){?>
	<form action="" method="post" id="postEditorForm">
		<input type="text" name="editPostTitle" value="<?php echo $_REQUEST["post"][0]["title"]; ?>" class="textInput"/>
		<textarea name="editPostContent" class="longTextInput"><?php echo $_REQUEST["post"][0]["content"]; ?></textarea>
	</form>
<?php } else { ?>
	<h2><a href="post.php?id=<?php echo $_REQUEST["post"][0]["id"]; ?>"><?php echo $_REQUEST["post"][0]["title"]; ?></a></h2>
	<div class="postContent">
<?php 	echo preg_replace("/\n/", "<br/>\n", $_REQUEST["post"][0]["content"])."\n"; ?>
	</div>
<?php } ?>
	<div class="postDate">
		<?php echo $_REQUEST["post"][0]["creation_date"]; ?> Comentarios: <?php echo $_REQUEST["post"][0]["comments"]; ?>
	</div>
</div>
<div>
<?php if(isPoster($_REQUEST["post"][0]["id"])){?>
	<div id="commentEditor">
		<h2>Escibir comentario</h2>
		<form action="" method="post">
			<input type="text" name="newCommentTitle" value="Título" class="textInput"/>
			<textarea name="newCommentContent" class="longTextInput">Comentario</textarea>
			<input type="submit" value="Envíar" class="button"/></td>
		</form>
	</div>
<?php } ?>
<?php foreach($_REQUEST["comments"] as $comment){?>
	<div id="<?php echo $comment["id"]?>" class="comment">
<?php 	if(isAdmin($comment["fid"])){ ?>
		<div class="toolBar editBar">
			<form action="" method="post">
				<button type="submit" name="deleteComment" value="<?php echo $comment["id"]; ?>" class="button">
					<img src="resources/images/deleteIcon.png" class="icon"/>
				</button>
<?php 		if(isset($_REQUEST["editComment"]) && $_REQUEST["editComment"]==$comment["id"]){ ?>
				<button type="submit" form="commentEditorForm" name="editCommentId" value="<?php echo $comment["id"]; ?>" class="button">
					<img src="resources/images/saveIcon.png" class="icon"/>
				</button>
<?php 		} else { ?>
				<button type="submit" name="editComment" value="<?php echo $comment["id"]; ?>" class="button">
					<img src="resources/images/editIcon.png" class="icon"/>
				</button>
<?php 		} ?>
			</form>
		</div>
<?php 	} ?>
		<div class="commentInfo">
			<span class="commentUser pullLeft"><a href="user.php?id=<?php echo $comment["uid"]; ?>"><?php echo $comment["nick"]; ?></a></span>
			<span class="commentDate pullRight"><?php echo $comment["creation_date"]; ?></span>
		</div>
<?php 	if(isset($_REQUEST["editComment"]) && isAdmin($comment["fid"])){ ?>
		<form action="" method="post" id="commentEditorForm">
			<input type="text" name="editCommentTitle" value="<?php echo $comment["title"]; ?>" class="textInput"/>
			<textarea name="editCommentContent" class="longTextInput"><?php echo $comment["content"]; ?></textarea>
		</form>
<?php 	} else { ?>
		<h3><?php echo $comment["title"]; ?></h3>
		<div class="commentContent">
<?php		echo preg_replace("/\n/", "<br/>\n", $comment["content"])."\n"; ?>
		</div>
<?php 	} ?>
	</div>
<?php } ?>
</div>
