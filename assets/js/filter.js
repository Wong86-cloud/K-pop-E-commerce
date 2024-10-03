document.addEventListener('DOMContentLoaded', function() {
    const filterProductCheckboxes = document.querySelectorAll('input[type="checkbox"][name="filter"]');
    const filterPriceRadios = document.querySelectorAll('input[type="radio"][name="price_order"]');
    const productItems = document.querySelectorAll('.shop-items li');
    const searchBox = document.getElementById('search_box'); // The search input box
    const searchButton = document.getElementById('search_button'); // The search button

    function filterProducts() {
        let selectedCategories = [];
        let selectedPriceFilter = 'Default';
        const searchQuery = searchBox.value.toLowerCase().trim(); // Get the search input and convert it to lowercase

        console.log("Search query: ", searchQuery); // Debugging search query
        
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

        // Filter products based on category and search query
        productItems.forEach(item => {
            const category = item.getAttribute('data-category');
            const price = parseFloat(item.querySelector('.product-price').getAttribute('data-price'));
            const productName = item.querySelector('strong').textContent.toLowerCase(); // Product name to match

            const matchesCategory = selectedCategories.includes('all') || selectedCategories.includes(category);
            const matchesSearch = productName.includes(searchQuery);

            console.log("Product name: ", productName, "Matches search: ", matchesSearch); // Debugging product name match

            // Show or hide items based on category and search query
            if (matchesCategory && matchesSearch) {
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

        // Get the shop items container
        const shopItemsContainer = document.querySelector('.shop-items');
        console.log(shopItemsContainer); // Log for debugging

        // Ensure the container exists before modifying
        if (shopItemsContainer) {
            shopItemsContainer.innerHTML = ''; // Clear current items
            sortedItems.forEach(item => shopItemsContainer.appendChild(item)); // Append sorted items
        } else {
            console.error('The shop items container could not be found.');
        }
    }

    // Add event listeners to checkboxes, radio buttons, and search box
    filterProductCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterProducts);
    });
    filterPriceRadios.forEach(radio => {
        radio.addEventListener('change', filterProducts);
    });
    
    // Listen for search input changes or button click to trigger filtering
    searchBox.addEventListener('input', function() {
        console.log("Search input changed: ", searchBox.value);
        filterProducts();
    });
    searchButton.addEventListener('click', function() {
        console.log("Search button clicked");
        filterProducts();
    });    

    // Initial filter
    filterProducts();
});
