<body style="background:#eee;">
	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script src="ckeditor/_samples/sample.js" type="text/javascript"></script>
	<link href="ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />
	
	<div class='menu' style='float:right;margin-right:20px;'>
		<a href="javascript:void(0);" onclick="javascript:atualiza('serviços.php', null);"><img src='imagens/voltar.png' title="Voltar" width='50px' height='50px'></a>
	</div>

	<div align='center'>
		<form action="salvarServiço.php" method="post"  enctype="multipart/form-data">
			<table width='700px' style="font:14px 'Arial';">
				<tr></tr>
				<tr>
					<td>Título do Serviço:</td><td><input type="text" name="titulo" size="32"></td>
				</tr>
				<tr>
					<td>Foto do Serviço:</td><td><input type="file" name="foto"></td>
				</tr>
				<tr>
					<td>Descrição do Serviço:</td><td><p><textarea class='ckeditor' COLS="35" rows="8" name="descricao"></textarea></p></td>
				</tr>
				<tr>						
					<td></td><td><input type="submit" value="Salvar" text="Salvar serviço"><input type="reset" value="Cancelar"></td>
				</tr>
			
			</table>
		</form>
	</div>
</body>
