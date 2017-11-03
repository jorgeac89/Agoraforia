<div id="drive">
	<h2>Almacenamiento</h2>
	<form action="drive.php" method="post" enctype="multipart/form-data">
		<div id="driveBar" class="toolBar">
			<span class="pullLeft">
				<a href="drive.php?path=/"><img src="resources/images/homeFolderIcon.png" class="icon"/></a>
				<!-- <span><?php echo $_SESSION["path"]; ?></span> -->
				<span>Nueva carpeta</span>
				<span>Mis peliculas</span>
			</span>
			<span class="pullRight">
				<span class="customFileInput">
					<input type="file" name="file" multiple="multiple"/>
					Buscar archivos
				</span>
				<button type="submit" class="button">
					<img src="resources/images/uploadIcon.png" class="icon"/>
				</button>
				<button type="submit" name="directory" class="button">
					<img src="resources/images/newFolderIcon.png" class="icon"/>
				</button>
			</span>
		</div>
		<div>
			Tienes ocupados <?php echo  number_format(getDriveSize()/(1024*1024), 2, ',', '.'); ?> megabytes de tu espacio.
		</div>
		<table id="driveTable" class="verticalTable formTable">
			<thead>
				<tr>
					<th>Selecionar</th>
					<th>Tipo</th>
					<th>Nombre</th>
					<th>Compartir</th>
					<th>Borrar</th>
				</tr>
			</thead>
			<tbody>
<?php if($_REQUEST["files"]==NULL){ ?>
				<tr>
					<td colspan="5" id="driveMessage">Carpeta Vacía</td>
				</tr>
<?php }else{ ?>
<?php 	foreach($_REQUEST["files"] as $file){ ?>
				<tr>
<?php 		if(isset($_SESSION["select"]) && in_array($_SESSION["path"].$file, $_SESSION["select"])){?>
					<td>
						<input type="checkbox" name="select[]" value="<?php echo $_SESSION["path"].$file; ?>"  checked="checked"/>
					</td>
<?php 		}else{ ?>
					<td>
						<input type="checkbox" name="select[]" value="<?php echo $_SESSION["path"].$file; ?>"/>
					</td>
<?php 		} ?>
<?php 		if(is_file($_SESSION["home"].$_SESSION["path"].$file)){ ?>
					<td><?php echo mime_content_type(PAGE_ROOT.$_SESSION["home"].$_SESSION["path"].$file); ?></td>
					<td><a href="drive.php?download=<?php echo $file; ?>"><?php echo $file; ?></a></td>
<?php 			if(in_array($_SESSION["home"].$_SESSION["path"].$file, $_REQUEST["sharedPaths"])){ ?>
					<td>
						<a href="drive.php?share=<?php echo $file; ?>"><img src="resources/images/unshareIcon.png" class="icon"/></a>
						<br/>
						<a href="download.php?file=<?php echo $_REQUEST["sharedFiles"][array_search($_SESSION["home"].$_SESSION["path"].$file, $_REQUEST["sharedPaths"])]["hash"]; ?>">Enlace</a>
					</td>
<?php 			}else{ ?>
					<td><a href="drive.php?share=<?php echo $file; ?>"><img src="resources/images/shareIcon.png" class="icon"/></a></td>
<?php 			} ?>
					<td><a href="drive.php?delete=<?php echo $file; ?>"><img src="resources/images/deleteIcon.png" class="icon"/></a></td>
<?php 		}else if(is_dir($_SESSION["home"].$_SESSION["path"].$file)){ ?>
					<td><?php echo mime_content_type(PAGE_ROOT.$_SESSION["home"].$_SESSION["path"].$file); ?></td>
					<td><a href="drive.php?path=<?php echo $_SESSION["path"].$file; ?>/"><?php echo $file; ?></a></td>
					<td></td>
					<td><a href="drive.php?delete=<?php echo $file; ?>"><img src="resources/images/deleteIcon.png" class="icon"/></a></td>
<?php 		} ?>
				</tr>
<?php	 } ?>

<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<input type="submit" name="doSelection" value="Seleccionar" class="button"/>
<?php if(isset($_SESSION["select"])){ ?>
						<input type="submit" name="move" value="Mover" class="button"/>
						<input type="submit" name="noSelect" value="Deseleccionar Todo" class="button"/>
<?php } ?>
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>
