<?php


if(isset($_SESSION)){
    if(!$_SESSION["usuarioActivo"]){
        header("location:ingresar_ok");
    }
}else{
    header("location:ingresar_error");
    exit();
}

$editar = new MvcController();
$editar -> SubirFotoController();
?>


<!DOCTYPE html>
<html dir="ltr" lang="es">

<?php
include "head.php";
?>

        <body>
            <!-- ============================================================== -->
            <!-- Preloader - style you can find in spinners.css -->
            <!-- ============================================================== -->
            <div class="preloader">
                <div class="lds-ripple">
                    <div class="lds-pos"></div>
                    <div class="lds-pos"></div>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- Main wrapper - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <div id="main-wrapper">
                <!-- ============================================================== -->
                <?php
            include "navegacion.php";
            ?>
                <!-- ============================================================== -->
                
                <!-- ============================================================== -->
                <!-- Page wrapper  -->
                <!-- ============================================================== -->
                <div class="page-wrapper">
            
                    <!-- Container fluid  -->
                    <!-- ============================================================== -->
                    <div class="container-fluid">
                        <!-- ============================================================== -->
                        <!-- Start Page Content -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title m-b-0">Subir fotos</h5>
                                    </div>
                                        
                                    <form class="form-horizontal m-t-20" id="loginform" method="post" >
                                    <div class="row p-b-30">
                                        <div class="col-12">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                                </div>
                                                    <input type="file" class=" form-control-lg" id= "archivo" onchange= "subir_archivo();" ></input>
                                                   
                                                  
                                                    <input type="hidden" class=" form-control-lg" name= "ruta" id= "archivo_subido"></input>
                                                </div>
                                                <input type="text" class=" form-control-lg" name="nombre" placeholder= "Nombre del Archivo" ></input>
                                                <button class="btn btn-success " type="submit"> Guardar foto </button>
                                            </div>
                                           
                                        </div>
                                        
                                </form>
                                <div for="mensaje_error">
                                            </div>
                                            <?php
                                            if (isset($_GET["action"])){
                                                if($_GET["action"]== "foto_subida_ok"){
                                                    echo "Archivo guardado correctamente";
                                            
                                                }elseif ($_GET["action"]=="foto_subida_error"){
                                                    echo "Ocurrio un error al subir archivo";
                                                }
                                            } 
                                            
                                            ?>
                                   </div>
   
                                </div>
                                
                                
                            </div>
                            
                        </div>

                         

                       
                        <!-- ============================================================== -->
                        <!-- End PAge Content -->
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Page wrapper  -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Wrapper -->
            <?php
            include "footer.php";
            ?>
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            
            

        </body>

</html>
