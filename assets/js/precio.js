document.addEventListener('DOMContentLoaded', function() {
    var slider = document.getElementById('rango-precio');

    noUiSlider.create(slider, {
        start: [parseInt(slider.dataset.min), parseInt(slider.dataset.max)],
        connect: true,
        range: {
            'min': 0,
            'max': 1000
        },
        step: 10,
        tooltips: [true, true],
        format: {
            to: function (value) {
                return Math.round(value);
            },
            from: function (value) {
                return Number(value);
            }
        }
    });

    slider.noUiSlider.on('update', function (values, handle) {
        document.getElementById('rango-precio-valor').innerText = values.join(' - ') + '€';
    });

    document.getElementById('aplicar-filtros').addEventListener('click', function() {
        var valores = slider.noUiSlider.get();
        var precioMin = valores[0];
        var precioMax = valores[1];
        var categoria = document.getElementById('categoria-select').value;
        var url = `productos.php?precio_min=${precioMin}&precio_max=${precioMax}`;
        if (categoria) {
            url += `&categoria=${categoria}`;
        }
        window.location.href = url;
    });
});