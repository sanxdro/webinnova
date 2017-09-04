<?php include 'header.php';
if (login_check($mysqli) == true ) {
	if ($_SESSION['permiso'] == 'U' OR $_SESSION['permiso'] == 'A'  OR $_SESSION['permiso'] == 'P' ){
				
	$id_pack = leerParam("xcod","");
	$nom = leerParam("xnom","");
?>
	<aside>
		<img src="../images/packv.jpg"  alt="innovatrainingcenter" width="100%" ">
	</aside>
		<div id="fh5co-team-section">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center fh5co-heading">
						<h2><?php echo  $nom; ?></h2>
					</div>
					<div class='col-md-12 fh5co-staff '>
						<div class="col-md-8">		
<?php
$x=0;



			$stmt = $mysqli->prepare("SELECT  `pack`.`factor_pack`,
											    `pack`.`descrip_pack`,
											    `pack`.`horas_pack`,
											    `pack`.`fecha_ini`
											FROM `u292000437_bdi`.`pack` WHERE `pack`.`id_pack` = ? AND `pack`.`estado`= 'A' ;");
			$stmt->bind_param("i", $id_pack );
			$stmt->execute();
            $stmt->bind_result($factor_pack, $des ,$horas, $fecha);
            $stmt->fetch();

           				echo" 
								<p>$des</p>
								<ul>
										<li><b>Duración: </b> $horas </li>
										<li><b>Fecha de Inicio: </b>"; 
										if($fecha=='0001-01-01'){
											echo "Acceso inmediato";
										}
										else{ 
											echo"$xfechini";
										}
										echo"</li>
										<li><b>Modalidad: </b> Virtual</li>
										<li><b>Docentes: </b> Instructores Certificados Autodesk</li>
										<li><b>Cursos: </b></li>
										<ul>
							";


			$stmt->close();					
			if ($stmt = $mysqli->prepare("SELECT  
											    `cursos`.`nom_cursos`
											FROM `detalle_pack`, `pack`, `grupos` ,  `cursos`
											WHERE`detalle_pack`.`id_pack` = `pack`.`id_pack` 
											AND  `detalle_pack`.`id_grupo` = `grupos`.`id_grupo`
											AND  `grupos`.`id_cursos` = `cursos`.`id_cursos`
											AND `pack`.`id_pack` = ? ;")) {
				$stmt->bind_param('i', $id_pack);
				$stmt->execute();
				/* vincular variables a la sentencia preparada */
				$stmt->bind_result($nom_c);
				
				/* obtener valores */
				while ($stmt->fetch()) {


						echo "<li>$nom_c</li>";

				}

			}
			echo " </ul>
			
			</ul>
			</div>";


			$url = "cursos_acti_pro_pack.php?xcod=".$id_pack;
			$img = str_replace(' ', '', $nom);
 			$img = str_replace(':', '', $img);
 			$pdf = $img;
 			$img= $img."_V.jpg";
 			$pdf= $pdf."_V.pdf";


				echo"<div class='col-md-4'>
							<img src='../images/pack/$img'  alt='$img' class='img-responsive'>
							<h4>PROCEDIMIENTO DE INSCRIPCIÓN</h4>	
							<ol>
								<li>Reserva Tu Matricula (PRE - INSCRIPCIÓN)</li>
								<li>Deposito: Deposito en el Banco BCP </li>
								<li>Enviar Voucher Escaneado al correo:cursos@innovatrainingperu.com</li>
								<li>Recibirán- un correo de confirmación de su Matricula.</li>
							</ol>";
								
							echo "
									<a href='matricula_pack_v.php?xcod=$id_pack' class='btn btn-primary'>Reserva tu matricula</a>
									<a href='../pdf/$pdf' download='$pdf.pdf' class='btn btn-default' >Descargar Contenido</a>
									
								
					</div>";
						
			$stmt->close();
		
		$mysqli->close();
?>




				</div>				
			</div>
	</div>
<!---------------------------------------------------------- Hmtl Seguro-------------------------------------------------------------------------------->
	<?php }
			else { 
				header('Location: ../login.php?error=2');
			} 
	} else { 

		header('Location: ../login.php?error=3');
    } 
 include 'footer.php';?>		
 
 
 