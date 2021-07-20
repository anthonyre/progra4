<?php

class MvcController{

	#LLAMADA A LA PLANTILLA
	#-------------------------------------

	static public function pagina(){	

		include "views/template.php";

	}

	#ENLACES
	#-------------------------------------

	static public function enlacesPaginasController(){

		if(isset( $_GET['action'])){

			$enlaces = $_GET['action'];

		}

		else{

			$enlaces = "index";
		}

		$respuesta = Paginas::enlacesPaginasModel($enlaces);

		include $respuesta;

	}
	#REGISTRO DE USUARIOS
	public static function  registroUsuarioController()
	{
		if (
			isset($_POST["nombre"]) &&
			isset($_POST["password"]) &&
			isset ($_POST["email"])
		) {
			if (!empty($_POST["nombre"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
				if (preg_match('/^[A-Za-z0-9\_\-\.]{3,20}$/', $_POST["nombre"]) &&
					preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $_POST["email"]) &&
					preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', $_POST["password"])){
					$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
					$datos = array(
						"nombre" => $_POST["nombre"],
						"password" => $password,
						"email" => $_POST["email"]


					);
					$respuesta = Datos::registroUsuarioModel($datos, "usuarios");

					if ($respuesta == "success"){
						header("location:index.php?action=registro_ok");

					}else{
						header("location:index.php?action=registro_error");
					}
				}
			}
		}
	}
	#Vista Usuario

	public static function vistaUsuariosController()
	{
		$respuesta = Datos::vistaUsuariosModel("usuarios");

		foreach ($respuesta as $key => $value){
			echo ' <tr>
				<td>'.$value["nombre"].'</td>
				<td>*****************</td>
				<td>'.$value["email"].'</td>
				<td>
					<a href="editar&idEditar='.$value["id"].'">
					
					<button class = "btn btn-success float-right"><i class="fas fa-pencil-alt"></i>
						Editar
					</button>
					</a>
				</td>
				<td>
					<a href="usuarios&idBorrar='.$value["id"].'">
					<button class = "btn btn-success float-right"><i class="far fa-trash-alt"></i>
						Borrar
					</button>
					</a>
				</td>
			</tr>
			';
		}
	}
	#borrar usuarios
	public static function borrarUsuarioController(){
		if (isset($_GET["idBorrar"]) ){
			$datos = $_GET["idBorrar"];
			$respuesta = Datos::borrarUsuarioModel ($datos, "usuarios");
			if ( $respuesta=="success"){
				header("location:eliminado_ok");
			}else{
				header("location:eliminado_error");
			}


		}
	}
	#editar usuarios
	public static function editarUsuarioController()
	{
		if (isset($_GET["idEditar"])) {
			$datos = $_GET["idEditar"];
			$respuesta = Datos::editarUsuarioModel($datos, "usuarios");
			echo '
	<input type="hidden" name="id" value="'.$respuesta["id"].'" required>
	<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
	</div>

	<input type="text" class="form-control form-control-lg"  placeholder="Usuario" name="nombre" id="nombre_registro" value="'.$respuesta["nombre"].'" aria-label="Username" aria-describedby="basic-addon1" required>
	</div>
	<!-- email -->
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
		</div>
		<input type="email" class="form-control form-control-lg" placeholder="Email" name="email" id="email_registro" value="'.$respuesta["email"].'" aria-label="Username" aria-describedby="basic-addon1" required>
	</div>
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
		</div>
		<input type="password" class="form-control form-control-lg" placeholder="Contraseña" name="password" aria-label="Password" aria-describedby="basic-addon1" required>
	</div>




	<button class="btn btn-primary float-left" type="submit">Editar</button>';
		}
	}

	#ACTUALIZAR USUARIO
	public static function actualizarUsuarioController(){
		if (
			isset($_POST["id"]) &&
			isset($_POST["nombre"]) &&
			isset($_POST["password"]) &&
			isset ($_POST["email"])
		) {
			//$password = crypt($_POST['password'], '$2a$07assxx54ahjppf45sd87a5a4dDDGsystemdev$');

			$password = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$datos = array(
				"id" => $_POST["id"],
				"nombre" => $_POST["nombre"],
				"password" => $password,
				"email" => $_POST["email"]

			);
			$respuesta = Datos::actualizarUsuarioModel($datos, "usuarios");

			if ($respuesta == "success"){
				header("location:actualizado_ok");

			}else{
				header("location:actualizado_error");
			}

		}
	}
	#INGRESO DE USUARIOS
	public static function ingresarUsuarioController(){
		if  (

			isset($_POST["nombre"]) &&
			isset($_POST["password"])
		){
			if( !empty($_POST["nombre"]) && !empty($_POST["password"])) {
				if (preg_match('/^[A-Za-z0-9\_\-\.]{3,20}$/', $_POST["nombre"]) &&
					preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/', $_POST["password"])) {


					//$password = crypt($_POST['password'], '$2a$07assxx54ahjppf45sd87a5a4dDDGsystemdev$');
					//$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

					$password = $_POST["password"];
					$datos = array(

						"nombre" => $_POST["nombre"],
						"password" => $password
					);
					$respuesta = Datos::ingresarUsuarioModel($datos, "usuarios");


					if ($respuesta["nombre"] == $datos["nombre"] && password_verify($_POST["password"], $respuesta["password"])) {
						$_SESSION["usuarioActivo"] = true;
						header("location:ingresar_ok");

					}else{
						header("location:ingresar_error");
					}
				}else{
					header("location:ingresar_error_invalido");
				}
			}else{
				header("location:ingresar_error_vacio");
			}
		}
	}

	public static function validarUsuarioController($datos){
		$respuesta = 0;
		if( !empty($datos)){
			if (preg_match('/^[A-Za-z0-9\_\-\.]{3,20}$/', $datos) )  {
				$respuesta = Datos::validarUsuarioModel($datos);
				if($respuesta[0] > 0){
					$respuesta = 1;
				}else{
					$respuesta = 0;
				}
			}
		}   
		return $respuesta;
	}

	public static function validarEmailController($datos){
		$respuesta = 0;
		if( !empty($datos)){
			if (preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $datos) )  {
				$respuesta = Datos::validarEmailModel($datos);
				if($respuesta[0] > 0){
					$respuesta = 1;
				}else{
					$respuesta = 0;
				}
			}
		}   
		return $respuesta;
	}

// -------------------------------------------------
// guardar en bd la ruta de foto
	public static function SubirFotoController(){
		if (
			isset($_POST["ruta"]) &&
			isset($_POST["nombre"])
		) {
		
			if ( !empty($_POST["ruta"]) && !empty($_POST["nombre"]) ) {
				if (preg_match('/^[A-Za-z0-9\_\-\.]{1,100}$/', $_POST["ruta"]) &&
					preg_match('/^[A-Za-z0-9\_\-\.]{1,100}$/', $_POST["nombre"] ) ){
				
				$datos = array(
					"ruta" => $_POST["ruta"],
					"nombre" => $_POST["nombre"]


				);
			


			$respuesta = Datos::SubirFotoModel($datos, "fotos");

				if ($respuesta == "success"){
					header("location:foto_subida_ok");

				}else{
					header("location:foto_subida_error");
				}
			}

			}
		}

	}


// mostrar img

public static function mostrarFotosController(){

		$respuesta = Datos::mostrarFotosModel("fotos");
		echo '
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
		';


		$contador = 0;
		foreach ($respuesta as $key => $value){ 
			if ($contador == 0){
				echo ' 
			<div class="carousel-item active">
			<img class="d-block w-100" src="uploads/'.$value["ruta"].'" alt="'.$value["nombre"].'">
			<div class="carousel-caption d-none d-md-block">
			<h5>'.$value["nombre"].'</h5>
			</div>
			</div>
			';

			} else {
				echo ' 
				<div class="carousel-item">
				<img class="d-block w-100" src="uploads/'.$value["ruta"].'" alt="'.$value["nombre"].'">
				<div class="carousel-caption d-none d-md-block">
				<h5>'.$value["nombre"].'</h5>
				</div>
				</div>
				';
			}
			
			$contador++;
		}
		echo '
		</div>
			<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		';
		
	}
}

