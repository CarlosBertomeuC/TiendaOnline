$(document).ready(function() {
    var nombres = [];

    // Obtener los nombres de los productos desde el servidor
    $.ajax({
        url: '../config/obtener_nombres_productos.php',
        method: 'GET',
        success: function(data) {
            nombres = JSON.parse(data);
            $('#nombre-input').autocomplete({
                source: nombres
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener los nombres de los productos:", error);
        }
    });

    $('#aplicar-filtros').on('click', function() {
        var valores = slider.noUiSlider.get();
        var precioMin = valores[0];
        var precioMax = valores[1];
        var categoria = $('#categoria-select').val();
        var nombre = $('#nombre-input').val();
        var url = `productos.php?precio_min=${precioMin}&precio_max=${precioMax}`;
        if (categoria) {
            url += `&categoria=${categoria}`;
        }
        if (nombre) {
            url += `&nombre=${nombre}`;
        }
        window.location.href = url;
    });
});