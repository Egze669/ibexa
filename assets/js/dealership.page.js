(function (global, doc) {
    let sortDirection = {
        brand: true,   // true means ascending, false means descending
        model: true,
        year: true,
        price: true
    };

    doc.querySelectorAll('.sortButton').forEach(button => {
        button.addEventListener('click', function() {
            const carRows = Array.from(doc.querySelectorAll('.car-row'));
            const sortBy = this.getAttribute('data-sort-by');
            const isAscending = sortDirection[sortBy];
            carRows.sort((a, b) => {
                let atrA = a.querySelector('.'+sortBy).textContent.toLowerCase();
                let atrB = b.querySelector('.'+sortBy).textContent.toLowerCase();
                if(sortBy === 'price'){
                    atrA = Number(atrA);
                    atrB = Number(atrB);
                }
                if (atrA < atrB) return  isAscending ? -1 : 1;
                if (atrA > atrB) return  isAscending ? 1 : -1;
                else return 0;
            });
            carRows.forEach(item => {
                item.parentNode.appendChild(item); // Append each sorted row back to the parent
            });
            sortDirection[sortBy] = !sortDirection[sortBy];
        });
    });


    doc.addEventListener('DOMContentLoaded', function () {

        const searchInput = doc.getElementById('search');

        searchInput.addEventListener('input', function () {
            filterCars();
        });

        function filterCars() {
            const carRows = doc.querySelectorAll('.car-row');

            const searchTerm = searchInput.value.toLowerCase();

            carRows.forEach(row => {
                try {
                    const brand = row.querySelector('.car_brand').textContent.toLowerCase();
                    const model = row.querySelector('.model').textContent.toLowerCase();
                    const year = row.querySelector('.year').textContent.toLowerCase();
                    const price = row.querySelector('.price').textContent.toLowerCase();
                    const matchesSearchTerm = brand.includes(searchTerm) ||
                        model.includes(searchTerm) ||
                        year.includes(searchTerm) ||
                        price.includes(searchTerm)

                    if (matchesSearchTerm) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                } catch ($error) {
                    row.style.display = 'none';
                }
            });
        }
    });
})(window, document);
