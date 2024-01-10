<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Mi perfil</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="CRUD_Carrusel/js/EliminarCarrusel.js"></script>
</head>

<body>

    <?php include_once("menu.php"); 
    include_once("footer.php");

    if (isset($_SESSION["Rol_usuario"]) && (strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0)) { ?>
        <?php 
        $SelectCarrusel = $base->prepare("SELECT * FROM tbl_carrusel");
        $SelectCarrusel->execute();

        $CantCarrusel = $SelectCarrusel->rowCount();
        $rowCarrusel = $SelectCarrusel->fetchAll();

        ?>
        <div class="CjCarrusel">
            <h1>Carrusel</h1>
            <?php if ($CantCarrusel >= 0) { 
                foreach ($rowCarrusel as $row) { 
                    $SelectProducto = $base->prepare("SELECT * FROM productos WHERE ID = :id_producto");
                    $SelectProducto->execute(array(":id_producto" => $row['ID_PRODUCTO']));
                    $rowProducto = $SelectProducto->fetch(); 

                    $ExistImagen = $rowProducto['FOTO'];

                    if (!file_exists($ExistImagen)){
                        $ExistImagen = "Fotos/NoFoto.png";
                    }

                    ?>

                    <div class="border border-dark border-2 mt-4">
                        <img src="<?php echo $ExistImagen; ?>" width="140px" height="140px">
                        <h3 style="display:inline-block;"><?php echo $rowProducto['NOMBRE']; ?></h3>
                        <h6 class="ms-5" style="display:inline-block;"><?php echo $row['DESCRIPCION']; ?></h6>
                        <button class="btn btn-xl btn-danger float-end m-5" data-bs-toggle="modal" data-bs-target="#EliminarCarrusel<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash-can"></i></button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="EliminarCarrusel<?php echo $row['ID']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="code.php" method="POST">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" style="border:none;">Eliminar carrusel</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="idEliminarCarrusel" value="<?php echo $row['ID']; ?>">
                                        <div class="form-group">
                                            <label class="col-form-label">¿Deseas eliminar el carrusel?</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger" name="btn_EliminarCarrusel">Eliminar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php }

                if ($CantCarrusel > 0 && $CantCarrusel < 5) { ?>
                    <button type="button" class="btn btn-primary mt-3 mb-1" data-bs-toggle="modal" data-bs-target="#CrearCarrusel"><i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Añadir otra carrusel</button>
                <?php } else if ($CantCarrusel == 0) { ?>
                    <button type="button" class="btn btn-primary mt-3 mb-1" data-bs-toggle="modal" data-bs-target="#CrearCarrusel"><i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Añadir una carrusel</button>
                <?php }
            } ?>

            <!-- Modal -->
            <div class="modal fade" id="CrearCarrusel" tabindex="-1" aria-labelledby="CrearCarruselLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="code.php" method="POST">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" style="border:none;" id="CrearCarruselLabel">Insertar carrusel</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="Nombre" class="col-form-label">Categorias:</label>
                                    <select name="selec" id="tipo" class="form-select" >
                                        <option value="">SELECCIONAR...</option>
                                        <option value="Alimentacion">ALIMENTACION</option>
                                        <option value="Bebida">BEBIDA</option>
                                        <option value="Papeleria">PAPELERIA</option>
                                        <option value="Limpieza">LIMPIEZA</option>
                                        <option value="Herramientas">HERRAMIENTAS</option>
                                        <option value="Cosmetico">COSMÉTICO</option>
                                        <option value="Juego">JUEGO</option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="Productos" class="form-label">Productos:</label>
                                    <div id="ProductosLista"></div>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="descrip" class="form-label">Descripción:</label>
                                    <textarea name="descripcion" id="descrip" class="form-control" rows="3" ></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="btn_AgregarCarrusel">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <h4 class="text-center p-3 m-5 bg-danger bg-gradient">Acceso denegado</h4>
    <?php } ?>

    <script src="bootstrap-5.1.3-dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            recargarProducto();
            $('#tipo').change(function(){
                recargarProducto();
            });
        })

        function recargarProducto() {
            $.ajax({
                type: "POST",
                url: "CRUD_Productos/DatosProducto.php",
                data: "tipoproducto=" + $('#tipo').val(),
                success: function(r) {
                    $('#ProductosLista').html(r);
                }
            });
        }

    </script>

</body>
</html>