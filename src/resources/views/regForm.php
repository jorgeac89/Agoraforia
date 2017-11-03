<div id="regForm">
	<h2>Registro de usuarios</h2>
	<form action="reg.php" method="post">
		<table class="horizontalTable formTable">
			<tbody>
				<tr>
					<td>Nick</td>
					<td><input type="text" name="regNick" class="textInput" value="<?php if(isset($_REQUEST["regNick"])){echo $_REQUEST["regNick"];}?>"/></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="regPassword" class="textInput" value="<?php if(isset($_REQUEST["regPassword"])){echo $_REQUEST["regPassword"];}?>"/></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input type="text" name="regEmail" class="textInput" value="<?php if(isset($_REQUEST["regEmail"])){ echo $_REQUEST["regEmail"];}?>"/></td>
				</tr>
				<tr>
					<td>Nombre</td>
					<td><input type="text" name="regName" class="textInput" value="<?php if(isset($_REQUEST["regName"])){ echo $_REQUEST["regName"];}?>"/></td>
				</tr>
				<tr>
					<td>Apellidos</td>
					<td><input type="text" name="regSurname" class="textInput" value="<?php if(isset($_REQUEST["regSurname"])){ echo $_REQUEST["regSurname"];}?>"/></td>
				</tr>
				<tr>
					<td>Fecha de nacimiento</td>
					<td><input type="text" name="regDate" class="textInput" value="<?php if(isset($_REQUEST["regDate"])){ echo $_REQUEST["regDate"];}?>"/></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"><input type="submit" name="register" value="Registrarse" class="button"/></td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>

