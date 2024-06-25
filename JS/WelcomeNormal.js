$(document).ready(function() {
    // Agregar producto al carrito
    $('.cantidad').change(function() {
        var id = $(this).data('id');
        var cantidad = $(this).val();

        if (cantidad < 0 || cantidad == "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La cantidad debe ser mayor a 0.'
            });
            return;
        }

        // Agregar producto al carrito usando AJAX
        $.post('agregar_al_carrito.php', {
            id_producto: id,
            cantidad: cantidad
        }, function(response) {
            if (response.success) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Producto agregado al carrito',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo agregar el producto al carrito.'
                });
            }
        }, 'json');
    });

    // Mostrar detalles del carrito al hacer clic en Ver Carrito
    $('#verCarrito').click(function(e) {
        e.preventDefault();
        $.get('carrito.php', function(response) {
            Swal.fire({
                title: 'Detalles del Carrito',
                html: response,
                showCloseButton: true,
                showConfirmButton: false,
                customClass:{
                    popup: 'larger-swal-popup'
                }
            });
        });
        var cantidad = document.getElementById("cantidad");
        var disponibles = document.getElementById("disponibles");
        var disponiblesNum = disponibles.textContent || disponibles.innerText;
        if(cantidad.value>disponiblesNum){
            cantidad.value = 0;
        }
    });
});


function mostrarAlertaLoginExitoso() {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Te has logeado exitosamente',
        showConfirmButton: false,
        timer: 1200
    });
}