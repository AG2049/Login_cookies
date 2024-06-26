$(document).ready(function(){
    $('#formEdicion').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: 'guardar_edicion.php',
            data: formData,
            dataType: 'json',
            contentType: false, // No establecer el tipo de contenido
            processData: false, // No procesar los datos (para que FormData funcione correctamente)
            success: function(response){
                if(response.success == 1){
                    location.href = '../Tabla/alta.php';
                } else if(response.success == 2){
                    location.href = '../welcome.php';
                } else if(response.success == 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Es necesario agregar una imagen'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
                alert("Hubo un error al procesar la solicitud. Por favor, intenta de nuevo.");
            }
        });
    });
});
