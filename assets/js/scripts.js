document.addEventListener("DOMContentLoaded", function() {
    const categoryLinks = document.querySelectorAll('.categorias-lista a');

    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const categoriaId = this.getAttribute('href').split('=')[1];
            
            fetch(`filtro_productos.php?categoria=${categoriaId}`)
                .then(response => response.text())
                .then(data => {
                    document.querySelector('.productos').innerHTML = data;
                });
        });
    });
});
