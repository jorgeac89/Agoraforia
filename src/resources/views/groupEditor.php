<div>
	<h2>Creación de grupos</h2>
	<form action="" method="post">
	<table class="horizontalTable formTable">
		<tbody>
			<tr>
				<td><b>Nombre del grupo</b></td>
				<td>
					<input type="text" class="textInput" name="groupName" value="<?php if(isset($_REQUEST["groupName"])){echo $_REQUEST["groupName"];}?>"/>
				</td>
			</tr>
			<tr>
				<td><b>Descripción del grupo</b></td>
				<td>
					<input type="text" class="largeTextInput" name="groupDescription" value="<?php if(isset($_REQUEST["groupDescription"])){echo $_REQUEST["groupDescription"];}?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="2"><h3>Foros del grupo</h3></td>
			</tr>
<?php for($i=0; $i<$_REQUEST["forumInputs"]; $i++){?>
			<tr>
				<td>Nombre del foro</td>
				<td>
					<input type="text" class="textInput" name="groupForums[<?php echo $i; ?>][name]" value="<?php if(isset($_REQUEST["groupForums"][$i]["name"])){echo $_REQUEST["groupForums"][$i]["name"];} ?>"/>
				</td>
			</tr>
			<tr>
				<td>Descripción del foro</td>
				<td>
					<input type="text" class="largeTextInput" name="groupForums[<?php echo $i; ?>][description]" value="<?php if(isset($_REQUEST["groupForums"][$i]["description"])){echo $_REQUEST["groupForums"][$i]["description"];} ?>"/>
				</td>
			</tr>		
<?php 	if($_REQUEST["forumInputs"]!=1){?>
			<tr>
				<td colspan="2">
					<button type="submit" class="button" name="deleteForumInput" value="<?php echo $i; ?>">
						<img src="resources/images/deleteIcon.png" class="icon"/>
					</button>
				</td>
			</tr>
<?php 	} ?>
<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2">
					<button type="submit" class="button" name="forumInputs" value="<?php echo ($_REQUEST["forumInputs"]+1); ?>">Más foros</button>
					<input type="submit" class="button" name="createGroup" value="Crear grupo">
				</td>
			</tr>
		</tfoot>
	</table>
	</form>
</div>