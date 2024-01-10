function alert_eliminar(codigos){
  Swal.fire({
    title: 'Estas seguro quieres eliminar este direccion?',
    text: "¡No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, bórralo!'
  }).then((result) => {
    if (result.isConfirmed) {
      mandar_eliminar(codigos) 
    }
  })
}

function mandar_eliminar(codigo){
  parametro = {ids: codigo};

  $.ajax({
    data: parametro,
    url: "Direcciones/EliminarDireccion.php",
    type: "POST",
    beforeSend: function () {},
    success: function () {
      Swal.fire(
        'Eliminado!',
        'El direccion esta eliminado',
        'success'
        ).then((result) =>{
          window.location.href = "Usuarios.php"
        });
      },

      error: function () {
       Swal.fire(
        'Error!',
        'Error de eliminar direccion',
        'error'
        ).then((result) =>{
          window.location.href = "Usuarios.php"
        });
      },
    });
}