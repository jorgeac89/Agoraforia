<div id="userInfo">
<?php if(isset($_SESSION["uid"]) && $_REQUEST["user"][0]["id"]==$_SESSION["uid"]){ ?>
	<div class="toolBar">
		<form action="" method="post">
			<button type="submit" name="editUser" value="<?php echo $_REQUEST["user"][0]["id"]; ?>" class="button">
				<img src="resources/images/editIcon.png" class="icon"/>
			</button>
<?php 	if(isset($_SESSION["uid"]) && isset($_REQUEST["editUser"])&& $_REQUEST["user"][0]["id"]==$_SESSION["uid"]){ ?>
			<button type="submit" class="button" form="userInfoForm">
				<img src="resources/images/saveIcon.png" class="icon"/>
			</button>
<?php 	} ?>
		</form>
	</div>
<?php } ?>
	<form action="" method="post" id="userInfoForm">
		<table class="horizontalTable">
			<tbody>
				<tr>
					<th>Nick</th>
<?php if(isset($_SESSION["uid"]) && isset($_REQUEST["editUser"])&& $_REQUEST["user"][0]["id"]==$_SESSION["uid"]){ ?>	
					<td><input type="text" name="newNick" value="<?php echo $_REQUEST["user"][0]["nick"]; ?>" class="textInput"/></td>
<?php } else{ ?>
					<td><?php echo $_REQUEST["user"][0]["nick"]; ?></td>
<?php } ?>
				</tr>
				<tr>
					<th>Nombre</th>
<?php if(isset($_SESSION["uid"]) && isset($_REQUEST["editUser"])&& $_REQUEST["user"][0]["id"]==$_SESSION["uid"]){ ?>	
					<td><input type="text" name="newName" value="<?php echo $_REQUEST["user"][0]["name"]; ?>" class="textInput"/></td>
<?php } else{ ?>
					<td><?php echo $_REQUEST["user"][0]["name"]; ?></td>
<?php } ?>
				</tr>
				<tr>
					<th>Apellido</th>
<?php if(isset($_SESSION["uid"]) && isset($_REQUEST["editUser"])&& $_REQUEST["user"][0]["id"]==$_SESSION["uid"]){ ?>	
					<td><input type="text" name="newSurname" value="<?php echo $_REQUEST["user"][0]["surname"]; ?>" class="textInput"/></td>
<?php } else{ ?>
					<td><?php echo $_REQUEST["user"][0]["surname"]; ?></td>
<?php } ?>
				</tr>
				<tr>
					<th>Fecha de nacimiento</th>
<?php if(isset($_SESSION["uid"]) && isset($_REQUEST["editUser"])&& $_REQUEST["user"][0]["id"]==$_SESSION["uid"]){ ?>	
					<td><input type="text" name="newDate" value="<?php echo $_REQUEST["user"][0]["date"]; ?>" class="textInput"/></td>
<?php } else{ ?>
					<td><?php echo $_REQUEST["user"][0]["date"]; ?></td>
<?php } ?>
				</tr>
				<tr>
					<th>Email</th>
<?php if(isset($_SESSION["uid"]) && isset($_REQUEST["editUser"])&& $_REQUEST["user"][0]["id"]==$_SESSION["uid"]){ ?>	
					<td><input type="text" name="newEmail" value="<?php echo $_REQUEST["user"][0]["email"]; ?>" class="textInput"/></td>
<?php } else{ ?>
				<td><?php echo $_REQUEST["user"][0]["email"]; ?></td>
<?php } ?>
				</tr>
				<tr>
					<th>Post creados</th>
					<td><?php echo $_REQUEST["user"][0]["posts"]; ?></td>
				</tr>
				<tr>
					<th>Comentarios creados</th>
					<td><?php echo $_REQUEST["user"][0]["comments"]; ?></td>
				</tr>
				<tr>
					<th>Ha creado los siguientes grupos</th>
					<td>
<?php if(count($_REQUEST["ownGroups"])==0){?>
						No ha creado ningún grupo.
<?php }else{?>
<?php 	foreach($_REQUEST["ownGroups"] as $group){?>
						<a href="group.php?id=<?php echo $group["id"]; ?>"><?php echo $group["name"]; ?></a>
<?php 	}?>
<?php } ?>
					</td>
				</tr>
				<tr>
					<th>Pertenece a los siguientes grupos</th>
					<td>
<?php if(count($_REQUEST["groups"])==0){?>
						No es miembro de ningún grupo
<?php }else{?>
<?php	foreach($_REQUEST["groups"] as $group){?>
						<a href="group.php?id=<?php echo $group["id"]; ?>"><?php echo $group["name"]; ?></a>
<?php 	}?>
<?php }?>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php if(isset($_REQUEST["messages"])){?>
<div>
	<h3>Mensajes</h3>
	<table class="verticalTable">
		<thead>
			<tr>
				<th>Título</th>
				<th>Usuario</th>
				<th>Fecha</th>
				<th>Borrar</th>
			</tr>
		</thead>
		<tbody>
<?php 	if(count($_REQUEST["messages"])==0){?>
			<tr>
				<td colspan="4">No tienes mensajes</td>
			</tr>
<?php 	}else{?>
<?php		foreach($_REQUEST["messages"] as $message){?>
			<tr>
				<td><?php echo $message["title"]?></td>
				<td><?php echo $message["sender_nick"]?></td>
				<td><?php echo $message["creation_date"]?></td>
				<td>Borrar</td>
			</tr>
<?php 		}?>
<?php 	}?>
		</tbody>
	</table>
</div>
<?php }?>
