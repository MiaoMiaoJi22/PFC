<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Usuarios</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/menustyle.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="Fotos/IconoWeb.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="Direcciones/js/EliminarDireccion.js"></script>
</head>

<body>

    <?php include_once("menu.php"); 
    include_once("footer.php");

    if(isset($_GET['Pagina'])){
        $Pagina = $_GET['Pagina'];
    } else {
        $Pagina = 1;
    }

    $RegistrosPorPagina = 10;
    $Empieza = ($Pagina - 1) * $RegistrosPorPagina;

    $SelectUsuario = $base->prepare("SELECT * FROM usuario_pass WHERE ROL <> 'Supervisor' LIMIT $RegistrosPorPagina OFFSET $Empieza");
    $SelectUsuario->execute();
    $rowUsuario = $SelectUsuario->fetchAll();

    if (isset($_SESSION["Rol_usuario"]) && strcasecmp($_SESSION["Rol_usuario"], "Administrador") == 0 || strcasecmp($_SESSION["Rol_usuario"], "Supervisor") == 0) { ?>
        <div class="Usuario">
            <h1>Lista de usuarios</h1>

            <button type="button" class="btn btn-success mt-3 mb-4 mx-0" data-bs-toggle="modal" data-bs-target="#CrearUsuario">
                <i class="fa-solid fa-plus" style="margin-right: 10px;"></i>Nuevo usuario
            </button>

            <table class="w-100 table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Código usuario</th>
                        <th>Nombre completo</th>
                        <th>Nombre usuario</th>
                        <th>Rol</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($rowUsuario as $row) { ?>
                        <tr>
                            <td class="align-middle"><?php echo $row['ID']; ?></td>
                            <td class="align-middle"><?php echo $row['NOMBRECOMPLETO']; ?></td>
                            <td class="align-middle"><?php echo $row['USUARIOS']; ?></td>
                            <td class="align-middle"><?php echo $row['ROL']; ?></td>
                            <?php if ($row['ROL'] != 'Supervisor') { ?>
                                <!-- <td class="align-middle"><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ModificarUsuario<?php echo $row['ID']; ?>"><i class="fa-solid fa-pen-to-square"></i></button></td> -->
                                <td class="align-middle"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#EliminarUsuario<?php echo $row['ID']; ?>"><i class="fa-solid fa-trash-can"></i></button></td>
                            <?php } else { ?>
                                <td></td>
                                <td></td>
                            <?php } ?>
                        </tr>

                        <!-- Modal -->
                        <!-- <div class="modal fade" id="ModificarUsuario<?php echo $row['ID']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="code.php" method="POST">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Actualizar usuario</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="idModificar" value="<?php echo $row['ID']; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nombre completo</label>
                                                <input type="text" name="NombreCompletoMod" class="form-control" value="<?php echo $row['NOMBRECOMPLETO']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input type="text" name="CorreoMod" class="form-control" value="<?php echo $row['E_MAIL']; ?>">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Teléfono</label>
                                                        <input type="tel" name="TelefonoMod" class="form-control" value="<?php echo $row['TELEFONO']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Contraseña</label>
                                                        <input type="password" name="passwordMod" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Rol</label>
                                                <select name="rolMod" class="form-select">
                                                    <option value="">Seleccionar</option>
                                                    <option <?php echo $row['ROL']==='Administrador' ? "selected='selected'" : "" ?> value="Administrador">Administrador</option>
                                                    <option <?php echo $row['ROL']==='Cliente' ? "selected='selected'" : "" ?> value="Cliente">Cliente</option>
                                                </select>
                                            </div>
                                            <div class="form-group mt-3">
                                                <div class="form-check form-switch">
                                                    <label class="col-form-label" for="flexSwitchCheckDefault2">¿Activo?</label>
                                                    <input class="form-check-input" style="margin-top:12px;" type="checkbox" id="flexSwitchCheckDefault2" name="ActivoMod" <?php echo $row['ACTIVO'] == 1 ? "checked" : "" ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-warning" name="btn_ModificarUsuario">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->

                        <!-- Modal -->
                        <div class="modal fade" id="EliminarUsuario<?php echo $row['ID']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="code.php" method="POST">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Eliminar usuario</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="idEliminar" value="<?php echo $row['ID']; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">¿Deseas eliminar el usuario <b><?php echo $row['USUARIOS']; ?></b>?</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger" name="btn_EliminarUsuario">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </tbody>
            </table>

            <div class="container-fluid col-12">
                <ul class="pagination pg-dark justify-content-center pb-2 mb-0" style="float:none;">
                    <?php 
                    $SelectPagina = $base->prepare("SELECT * FROM usuario_pass WHERE ROL <> 'Supervisor'");

                    $SelectPagina->execute();

                    $CantidadPagina = $SelectPagina->rowCount();
                    $Paginas = ceil($CantidadPagina / $RegistrosPorPagina);
                    $Ultima = round($CantidadPagina / $RegistrosPorPagina);

                    if ($Ultima == $Pagina + 1) {
                        $Ultima = "";
                    }

                    if ($Pagina > 1) { ?>
                        <li class="page-item"><a href="Cliente.php?Pagina=1" class="page-link"><i class="fa-solid fa-angles-left"></i></a></li>
                        <li class="page-item"><a href="Cliente.php?Pagina=<?php echo ($Pagina - 1); ?>" class="page-link"><i class="fa-solid fa-angle-left"></i></a></li>
                    <?php }
                    if ($Pagina > 2) { ?>
                        <li class="page-item"><a href="Cliente.php?Pagina=<?php echo ($Pagina-2); ?>" class="page-link"><?php echo ($Pagina-2);?></a></li>
                    <?php }

                    if ($Pagina > 1) { ?>
                        <li class="page-item"><a href="Cliente.php?Pagina=<?php echo ($Pagina-1); ?>" class="page-link"><?php echo ($Pagina-1);?></a></li>
                    <?php } ?>

                    <li class="page-item active"><a href="Cliente.php?Pagina=<?php echo $Pagina; ?>" class="page-link"><?php echo $Pagina;?></a></li>

                    <?php if (($Pagina + 1) <= $Paginas && $Paginas > 1) { 
                        ?>
                        <li class="page-item"><a href="Cliente.php?Pagina=<?php echo ($Pagina+1); ?>" class="page-link"><?php echo ($Pagina+1);?></a></li>
                    <?php } 

                    if (($Pagina + 2) <= $Paginas && $Paginas > 1) { 
                        ?>
                        <li class="page-item"><a href="Cliente.php?Pagina=<?php echo ($Pagina+2); ?>" class="page-link"><?php echo ($Pagina+2);?></a></li>
                        <?php 
                    }
                    if ($Pagina < $Paginas && $Paginas > 1) { ?>
                        <li class="page-item"><a href="Cliente.php?Pagina=<?php echo ($Pagina + 1); ?>" class="page-link"><i class="fa-solid fa-angle-right"></i></a></li>
                        <li class="page-item"><a href="Cliente.php?Pagina=<?php echo $Ultima; ?>" class="page-link"><i class="fa-solid fa-angles-right"></i></a></li>
                    <?php } ?>
                </ul>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="CrearUsuario" tabindex="-1" aria-labelledby="CrearUsuarioLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="code.php" method="POST" id="formulario">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="CrearUsuarioLabel">Insertar usuario</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group" id="grupo__nombre">
                                    <label for="Nombre" class="col-form-label">Nombre completo</label>
                                    <input type="text" name="NombreCompleto" class="form-control">
                                    <p class="formulario__input-error">El nombre completo debe tener por mínimo 4 dígitos</p>
                                </div>
                                <div class="form-group" id="grupo__mail">
                                    <label for="Email" class="col-form-label">Email</label>
                                    <input type="text" name="Correo" class="form-control">
                                    <p class="formulario__input-error">El correo solo puede contener letras, números, puntos, guiones y guión bajo.</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" id="grupo__usuario">
                                            <label for="Usuario" class="col-form-label">Usuario</label>
                                            <input type="text" name="Usuario" class="form-control">
                                            <p class="formulario__input-error">El usuario tiene que ser de 4 a 20 dígitos y solo puede contener numeros, letras y guión bajo.</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="grupo__tel">
                                            <label for="Tele" class="col-form-label">Teléfono</label>
                                            <input type="tel" name="Telefono" class="form-control">
                                            <p class="formulario__input-error">El teléfono solo puede contener números y el máximo son 14 dígitos</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="grupo__pass">
                                            <label for="Contra" class="col-form-label">Contraseña</label>
                                            <input type="password" name="password" class="form-control"  id='pass'>
                                            <p class="formulario__input-error">La contraseña tiene que ser de 4 a 50 dígitos</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="grupo__confirmpass">
                                            <label for="Contra2" class="col-form-label">Confirmar contraseña</label>
                                            <input type="password" name="confirmpassword" class="form-control" id='pass2'>
                                            <p class="formulario__input-error">Ambas contraseñas deben ser iguales</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Rol</label>
                                    <select name="rol" class="form-select">
                                        <option value="">Seleccionar</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Cliente">Cliente</option>
                                    </select>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="form-check form-switch">
                                        <label class="col-form-label" for="flexSwitchCheckDefault">¿Activo?</label>
                                        <input class="form-check-input" style="margin-top:12px;" type="checkbox" id="flexSwitchCheckDefault" name="Activo">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary" name="btn_GuardarUsuario">Guardar</button>
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
    <script type="text/javascript" src="js/Formulario.js"></script>

</body>
</html>