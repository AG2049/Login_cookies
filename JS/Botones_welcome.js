// Función para eliminar producto
function eliminarProducto(id) {
    $.ajax({
        url: '../PHP/SQL/DeleteProduct.php',
        type: 'POST',
        data: { id_producto: id },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.status === 'success') {
                Swal.fire(
                    'Eliminado!',
                    'Tu registro ha sido eliminado.',
                    'success'
                );
                $('#miTabla').DataTable().row($('#fila-' + id)).remove().draw();
            } else {
                Swal.fire(
                    'Error!',
                    result.message,
                    'error'
                );
            }
        },
        error: function(xhr, status, error) {
            Swal.fire(
                'Error!',
                'No se pudo eliminar el registro.',
                'error'
            );
        }
    });
}

// Función para inicializar DataTables
function inicializaDataTables() {
    $('#miTabla').DataTable();
}

$(document).ready(function() {
    inicializaDataTables();

    // Manejar clic en botón "Ver"
    $('.btn-ver').click(function() {
        var id = $(this).closest('tr').find('td:eq(0)').text();
        var nombre = $(this).closest('tr').find('td:eq(1)').text();
        var descripcion = $(this).closest('tr').find('td:eq(2)').text();
        var precio = $(this).closest('tr').find('td:eq(3)').text();
        var imagen = $(this).closest('tr').find('img').attr('src');
        var disponibilidad = $(this).closest('tr').find('td:eq(5)').text();

        // Redireccionar a edicion.php con parámetros
        var form = $('<form action="Tabla/registro.php" method="POST">' +
            '<input type="hidden" name="id" value="' + id + '" />' +
            '<input type="hidden" name="nombre" value="' + nombre + '" />' +
            '<input type="hidden" name="descripcion" value="' + descripcion + '" />' +
            '<input type="hidden" name="precio" value="' + precio + '" />' +
            '<input type="hidden" name="imagen" value="' + imagen + '" />' +
            '<input type="hidden" name="disponibilidad" value="' + disponibilidad + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });

    // Manejar clic en botón "Editar"
    $('.btn-editar').click(function() {
        var id = $(this).closest('tr').find('td:eq(0)').text();
        var nombre = $(this).closest('tr').find('td:eq(1)').text();
        var descripcion = $(this).closest('tr').find('td:eq(2)').text();
        var precio = $(this).closest('tr').find('td:eq(3)').text();
        var imagen = $(this).closest('tr').find('img').attr('src');
        var disponibilidad = $(this).closest('tr').find('td:eq(5)').text();

        // Redireccionar a edicion.php con parámetros
        var form = $('<form action="Tabla/edicion.php" method="POST">' +
            '<input type="hidden" name="id" value="' + id + '" />' +
            '<input type="hidden" name="nombre" value="' + nombre + '" />' +
            '<input type="hidden" name="descripcion" value="' + descripcion + '" />' +
            '<input type="hidden" name="precio" value="' + precio + '" />' +
            '<input type="hidden" name="imagen" value="' + imagen + '" />' +
            '<input type="hidden" name="disponibilidad" value="' + disponibilidad + '" />' +
            '</form>');
        $('body').append(form);
        form.submit();
    });

    // Manejar clic en botón "Eliminar"
    $('.btn-eliminar').click(function() {
        var fila = $(this).closest('tr');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = fila.find('td:eq(0)').text(); // Obtener el ID del producto de la primera columna
                eliminarProducto(id);
            }
        });
    });

    // Manejar clic en botón "Guardar"
    $('#btnGuardar').click(function() {
        var data = {
            // Asumimos que tienes algunos datos que enviar, ajusta según tus necesidades
            nombre: $('#nombre').val(),
            descripcion: $('#descripcion').val(),
            precio: $('#precio').val(),
            imagen: $('#imagen').val(),
            disponibilidad: $('#disponibilidad').val()
        };

        $.ajax({
            url: 'PHP/guardar.php',
            type: 'POST',
            data: data,
            success: function(response) {
                Swal.fire(
                    'Guardado!',
                    'Tu registro ha sido guardado.',
                    'success'
                );
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'No se pudo guardar el registro.',
                    'error'
                );
            }
        });
    });

    // Manejar clic en botón "Continuar"
    $('#btnContinuar').click(function() {
        var data = {
            // Asumimos que tienes algunos datos que enviar, ajusta según tus necesidades
            nombre: $('#nombre').val(),
            descripcion: $('#descripcion').val(),
            precio: $('#precio').val(),
            imagen: $('#imagen').val(),
            disponibilidad: $('#disponibilidad').val()
        };

        $.ajax({
            url: 'PHP/continuar.php',
            type: 'POST',
            data: data,
            success: function(response) {
                Swal.fire(
                    'Continuado!',
                    'El proceso ha continuado.',
                    'success'
                );
            },
            error: function(xhr, status, error) {
                Swal.fire(
                    'Error!',
                    'No se pudo continuar el proceso.',
                    'error'
                );
            }
        });
    });

    // Manejar clic en botón "Agregar"
    $('.btn-agregar').click(function() {
        // Limpiar la URL antes de redirigir
        var url = '../PHP/Tabla/alta.php';
        window.location.href = url;
    });
});