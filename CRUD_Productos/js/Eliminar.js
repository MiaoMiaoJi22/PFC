function alert_eliminar(codigo){
  Swal.fire({
    title: 'Estas seguro quieres eliminar el producto?',
    text: "¡No podrás revertir esto!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: '¡Sí, bórralo!'
  }).then((result) => {
    if (result.isConfirmed) {
      mandar_eliminar(codigo) 
    }
  })
}

function mandar_eliminar(codigo){
  parametro = {id: codigo};

  $.ajax({
    data: parametro,
    url: "CRUD_Productos/EliminarProducto.php",
    type: "POST",
    beforeSend: function () {},
    success: function () {
      Swal.fire(
        'Eliminado!',
        'El producto esta eliminado',
        'success'
        ).then((result) =>{
          window.location.href = "Producto.php"
        });
      },

      error: function () {
       Swal.fire(
        'Error!',
        'Error de eliminar producto',
        'error'
        ).then((result) =>{
          window.location.href = "Producto.php"
        });
      },
    });
}