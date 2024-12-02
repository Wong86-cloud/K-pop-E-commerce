document.addEventListener('DOMContentLoaded', () => {
    const currencySelect = document.getElementById('currency');
    const convertedValueElement = document.getElementById('converted-value');

    // Fetch exchange rate data
    const fetchExchangeRate = async (baseCurrency, targetCurrency) => {
        const apiKey = '82e5380e6fe63e2030a861f6'; // Replace with your actual API key
        const response = await fetch(`https://v6.exchangerate-api.com/v6/${apiKey}/latest/${baseCurrency}`);
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        const data = await response.json();
        return data.conversion_rates[targetCurrency];
    };

    // Update product prices based on the selected currency
    const updateCurrency = async (selectedCurrency) => {
        const baseCurrency = 'USD'; // Base currency
        const exchangeRate = await fetchExchangeRate(baseCurrency, selectedCurrency);

        // Update product prices
        const productPriceElements = document.querySelectorAll('[data-price]');
        productPriceElements.forEach((priceElement) => {
            const originalPrice = Number(priceElement.getAttribute('data-price'));
            const convertedPrice = (originalPrice * exchangeRate).toFixed(2);
            priceElement.innerText = `${selectedCurrency} ${convertedPrice}`;
        });

        // Update subtotal, tax, and total prices
        const subtotalElement = document.querySelector('.subtotal-price');
        const taxElement = document.querySelector('.tax-price');

        if (subtotalElement) {
            const subtotal = Number(subtotalElement.getAttribute('data-price'));
            subtotalElement.innerText = `${selectedCurrency} ${(subtotal * exchangeRate).toFixed(2)}`;
        }

        if (taxElement) {
            const tax = Number(taxElement.getAttribute('data-price'));
            taxElement.innerText = `${selectedCurrency} ${(tax * exchangeRate).toFixed(2)}`;
        }
    };

    // Event listener for currency change
    currencySelect.addEventListener('change', (event) => {
        const selectedCurrency = event.target.value;
        updateCurrency(selectedCurrency);
    });

    // Initial load
    updateCurrency(currencySelect.value);
});
