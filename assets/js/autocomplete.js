const searchInput = document.querySelector('.menu-item input');

const resultsContainer = document.createElement('div');
resultsContainer.classList.add('search-results-container');
searchInput.parentNode.appendChild(resultsContainer);


let productos = [];

async function loadproductos() {
    try {
        const response = await fetch('../config/buscar_nombre.php');
        const data = await response.json();
        if (Array.isArray(data)) {
            productos = data.map(producto => producto.nombre);
        } else {
            console.error('Error loading productos:', data.error);
        }
    } catch (error) {
        console.error('Error fetching productos:', error);
    }
}

loadproductos();

document.addEventListener('click', (event) => {
    if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
        resultsContainer.innerHTML = '';
    }
});

searchInput.addEventListener('input', function () {
    const searchValue = searchInput.value.toLowerCase();
    const filteredproductos = productos.filter(productos => productos.toLowerCase().includes(searchValue));

    resultsContainer.innerHTML = '';

    filteredproductos.forEach(productos => {
        const resultDiv = document.createElement('div');
        resultDiv.textContent = productos;
        resultDiv.classList.add('search-result');
        resultsContainer.appendChild(resultDiv);

        resultDiv.addEventListener('click', () => {
            searchInput.value = productos;
            resultsContainer.innerHTML = '';
            document.getElementById('nombre-input').innerHTML = productos;
        });
    });
    if (filteredproductos.length === 0 && searchValue !== '') {
        const noResultsDiv = document.createElement('div');
        noResultsDiv.textContent = 'No se encontraron resultados';
        noResultsDiv.classList.add('search-result');
        resultsContainer.appendChild(noResultsDiv);
    }
});