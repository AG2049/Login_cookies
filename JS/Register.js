$(document).ready(function(){
    $('#NewUser').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: 'register.php',
            data: formData,
            dataType: 'json',
            contentType: false, // No establecer el tipo de contenido
            processData: false, // No procesar los datos (para que FormData funcione correctamente)
            success: function(response){
                if(response.success == 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La contraseña no cumple con los parametros minimos'
                    });
                } else if(response.success == 1){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El nombre de usuario no cumple con los parametros minimos'
                    });
                }else if(response.success == 2){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Las contraseñas no coinciden'
                    });
                }else if(response.success == 3){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Usuario creado exitosamente',
                        showConfirmButton: false,
                        timer: 900
                    });
                    setTimeout(() => {location.href = 'index.php';}, 1000)
                }else if(response.success == 4){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El usuario ya existe o no cumple con los parametros'
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