<div id="forums">
<?php if(isset($_REQUEST["group"][0], $_REQUEST["owner"][0])){ ?>
	<h2><?php echo $_REQUEST["group"][0]["name"]; ?></h2>
	<span>Grupo de <a href="user.php?id=<?php echo $_REQUEST["owner"][0]["id"]; ?>"><?php echo $_REQUEST["owner"][0]["nick"]; ?></a></span>
<?php }else{ ?>
	<h2>Índice de foros</h2>
<?php } ?>
	<table id="forumsTable" class="verticalTable">
		<thead>
			<tr>
				<th>Foro</th>
				<th>Posts</th>
				<th>Comentarios</th>
<?php if(isset($_REQUEST["group"][0]) && isOwner($_REQUEST["group"][0]["id"])){ ?>
				<th>Administración</th>
<?php } ?>
			</tr>
		</thead>
		<tbody>
<?php if(count($_REQUEST["forums"]) == 0){ ?>
			<tr>
				<td colspan="3">No existen foros en este momento.</td>
			</tr>
<?php }else{ ?>
<?php 	foreach($_REQUEST["forums"] as $forum){ ?>
<?php 		if(isset($_REQUEST["editForum"]) && $_REQUEST["editForum"]==$forum["id"]){ ?>
			<form action="" method="post">
				<tr>
					<td>
						<input type="text" name="forumName" value="<?php echo $forum["name"]; ?>" class="textInput"/>
						<input type="text" name="forumDescription" value="<?php echo $forum["description"]; ?>" class="largeTextInput"/>
					</td>
					<td><?php echo $forum["posts"]; ?></td>
					<td><?php echo $forum["comments"]; ?></td>
<?php 			if(isset($_REQUEST["group"][0]) && isOwner($_REQUEST["group"][0]["id"])){ ?>
					<td>
						<button type="submit" name="forumId" value="<?php echo $forum["id"]; ?>" class="button">
							<img src="resources/images/saveIcon.png" class="mediumIcon"/>
						</button>
						<button type="submit" name="cancel" value="<?php echo $forum["id"]; ?>" class="button">
							<img src="resources/images/cancelIcon.png" class="mediumIcon"/>
						</button>
					</td>
<?php 			} ?>
				</tr>
			</form>
<?php 		}else{ ?>
			<tr>
				<td>
					<h3><a href="forum.php?id=<?php echo $forum["id"]; ?>"><?php echo $forum["name"]; ?></a></h3>
					<?php echo $forum["description"]; ?>
				</td>
				<td><?php echo $forum["posts"]; ?></td>
				<td><?php echo $forum["comments"]; ?></td>
<?php 			if(isset($_REQUEST["group"][0]) && isOwner($_REQUEST["group"][0]["id"])){ ?>
				<td>
				<form action="" method="post">
					<button type="submit" name="editForum" value="<?php echo $forum["id"]; ?>" class="button">
						<img src="resources/images/editIcon.png" class="mediumIcon"/>
					</button>
					<button type="submit" name="deleteForum" value="<?php echo $forum["id"]; ?>" class="button">
						<img src="resources/images/deleteIcon.png" class="mediumIcon"/>
					</button>
				</form>
				</td>
<?php 			} ?>
			</tr>
<?php 		} ?>
<?php 	} ?>
<?php } ?>
		</tbody>
	</table>
<?php if(isset($_REQUEST["group"][0]) && isOwner($_REQUEST["group"][0]["id"])){?>
	<h4>Añadir Foro</h4>
	<form action="" method="post">
		<table class="horizontalTable formTable">
			<tbody>
				<tr>
					<td>Nombre</td>
					<td><input type="text" name="forumName" class="textInput"/></td>
				</tr>
				<tr>
					<td>Descripción</td>
					<td><input type="text" name="forumDescription" class="largeTextInput"/></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<input type="submit" name="addForum" value="Añadir foro" class="button"/>
					</td>
				</tr>
			</tfoot>
		</table>		
	</form>
<?php } ?>
</div>
<?php if(isset($_REQUEST["members"])){?>
<div>
	<h3>Miembros</h3>
	<form action="" method="post">
		<span>
<?php 	foreach($_REQUEST["members"] as $member){?>
			<a href="user.php?id=<?php echo $member["id"]; ?>"><?php echo $member["nick"];?></a>
<?php 		if(isOwner($_REQUEST["group"][0]["id"])){?>
			<button type="submit" name="deleteMember" value="<?php echo $member["id"]; ?>" class="button">
				<img src="resources/images/deleteIcon.png" class="smallIcon"/>
			</button>
<?php 		} ?>
<?php 	} ?>
		</span>
	</form>
<?php 	if(isOwner($_REQUEST["group"][0]["id"])){?>
	<h4>Añadir miembros</h4>
	<form action="" method="post">
		<input type="text" name="newMembers" class="textInput"/>
		<input type="submit" name="addMembers" value="Añadir miembros" class="button"/>
	</form>
<?php 	} ?>
</div>
<?php } ?>
