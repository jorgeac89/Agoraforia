<div id="preview">
</div>
<div id="editMenu">
	<form action="" method="post">
<!--  
		<div id="editBar">
			<span id="insPicture" onclick="insPicture()">Foto</span>
			<span id="bold" onclick="mStyle('b')">Bold</span>
			<span id="italic" onclick="mStyle('i')">Italic</span>
		</div>
-->
		<input type="text" name="title" value="Título" class="textInput"/>
		<textarea name="content" id="newPostContent" class="longTextInput" onkeyup="modPost();" onkeydown="modPost();"></textarea>
<?php if(isset($_REQUEST["posterIds"])){ ?>
		<select name="forum" class="button">
<?php 	for($i=0; $i<count($_REQUEST["posterIds"]); $i++){?>
			<option value="<?php echo $_SESSION["posterIds"][$i]; ?>"><?php echo $_SESSION["posterNames"][$i]; ?></option>
<?php 	}?>
		</select>
		<input type="submit" value="Crear Post" class="button"/>
<?php }else{ ?>
		<input type="text" name="recivers" class="textInput"/>
		<input type="submit" value="Envíar mensaje" class="button"/>
<?php }?>
	</form>
</div>
