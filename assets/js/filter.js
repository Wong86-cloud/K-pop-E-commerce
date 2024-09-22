document.addEventListener('DOMContentLoaded', function() {
    const filterProductCheckboxes = document.querySelectorAll('input[type="checkbox"][name="filter"]');
    const filterPriceRadios = document.querySelectorAll('input[type="radio"][name="filter"]');
    const productItems = document.querySelectorAll('.shop-items li');
    
    // Function to filter the products
    function filterProducts() {
        let selectedCategories = [];
        let selectedPriceFilter = 'Default';

        // Get selected categories
        filterProductCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCategories.push(checkbox.value);
            }
        });

        // Get selected price filter
        filterPriceRadios.forEach(radio => {
            if (radio.checked) {
                selectedPriceFilter = radio.value;
            }
        });

        // Filter products based on category
        productItems.forEach(item => {
            const category = item.getAttribute('data-category');
            const price = parseFloat(item.querySelector('.product-price').getAttribute('data-price'));

            // Show or hide items based on category
            if (selectedCategories.includes('all') || selectedCategories.includes(category)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });

        // Sort products based on price filter
        let sortedItems = Array.from(productItems).filter(item => item.style.display !== 'none');
        if (selectedPriceFilter === 'LowToHigh') {
            sortedItems.sort((a, b) => parseFloat(a.querySelector('.product-price').getAttribute('data-price')) - parseFloat(b.querySelector('.product-price').getAttribute('data-price')));
        } else if (selectedPriceFilter === 'HighToLow') {
            sortedItems.sort((a, b) => parseFloat(b.querySelector('.product-price').getAttribute('data-price')) - parseFloat(a.querySelector('.product-price').getAttribute('data-price')));
        }

        // Re-append sorted items to the container
        const shopItemsContainer = document.querySelector('.shop-items ul');
        shopItemsContainer.innerHTML = '';
        sortedItems.forEach(item => shopItemsContainer.appendChild(item));
    }

    // Add event listeners to checkboxes and radio buttons
    filterProductCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });
    filterPriceRadios.forEach(radio => {
        radio.addEventListener('change', filterProducts);
    });
    
    // Initial filter
    filterProducts();
});

