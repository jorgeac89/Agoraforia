<div id="forum">
	<h2><?php echo $_REQUEST["forum"][0]["name"]; ?></h2>
	<table class="verticalTable" id="forumTable">
		<thead>
			<tr>
				<th>Título</th>
				<th>Fecha de creación</th>
				<th>Comentarios</th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($_REQUEST["posts"] as $post){ ?>
			<tr>
				<td><h3><a href="post.php?id=<?php echo $post["id"]; ?>"><?php echo $post["title"]; ?></a></h3></td>
				<td><?php echo $post["creation_date"]; ?></td>
				<td><?php echo $post["comments"]; ?></td>
			</tr>
<?php } ?>
		</tbody>
	</table>
</div>
<div>
	<h3>Administradores</h3>
	<form action="" method="post">
		<span>
<?php foreach($_REQUEST["admins"] as $admin){?>
			<a href="user.php?id=<?php echo $admin["id"]; ?>"><?php echo $admin["nick"];?></a>
<?php 	if($_REQUEST["forum"][0]["gid"]!=null && isOwner($_REQUEST["forum"][0]["gid"])){ ?>
			<button type="submit" name="deleteAdmin" value="<?php echo $admin["id"]; ?>" class="button">
				<img src="resources/images/deleteIcon.png" class="smallIcon"/>
			</button>
<?php 	} ?>
<?php } ?>
		</span>
	</form>
<?php if($_REQUEST["forum"][0]["gid"]!=null && isOwner($_REQUEST["forum"][0]["gid"])){ ?>
	<h4>Añadir administradores</h4>
<?php 	if(count($_REQUEST["members"])>0){ ?>
	<form action="" method="post">
		<select type="text" name="newAdmin" class="button">
			<option></option>
<?php 		foreach($_REQUEST["members"] as $member){?>
			<option value="<?php echo $member["id"]; ?>"><?php echo $member["nick"]; ?></option>
<?php 		} ?>
		</select>
		<input type="submit" name="addAdmin" value="Añadir Administradores" class="button"/>
	</form>
<?php 	}else{ ?>
	<p>Debe añadir miembros al grupo antes</p>
<?php 	} ?>
<?php } ?>
</div>