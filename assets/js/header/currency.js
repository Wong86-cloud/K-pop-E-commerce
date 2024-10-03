// Your API key from Open Exchange Rates or other currency API
const apiKey = ''; // Replace with your actual API key
const baseCurrency = 'USD'; // The base currency for the prices

// Function to fetch exchange rates from the API
async function fetchExchangeRates() {
    const url = `https://openexchangerates.org/api/latest.json?app_id=${apiKey}&base=${baseCurrency}`;
    
    try {
        const response = await fetch(url);
        const data = await response.json();
        return data.rates; // Return the exchange rates
    } catch (error) {
        console.error('Error fetching exchange rates:', error);
        return null;
    }
}

async function updatePriceDisplay() {
    const selectedCurrency = document.getElementById('currency').value;

    // Fetch the latest exchange rates
    const exchangeRates = await fetchExchangeRates();

    if (exchangeRates && exchangeRates[selectedCurrency]) {
        const conversionRate = exchangeRates[selectedCurrency];

        // Update product prices
        const productPriceElements = document.querySelectorAll('.product-price');
        productPriceElements.forEach((priceElement) => {
            const originalPrice = parseFloat(priceElement.getAttribute('data-price'));
            const convertedPrice = (originalPrice * conversionRate).toFixed(2);
            priceElement.innerText = `${selectedCurrency} ${convertedPrice}`;
        });

        // Update row total prices
        const rowTotalPriceElements = document.querySelectorAll('.total-price');
        rowTotalPriceElements.forEach((priceElement) => {
            const originalPrice = parseFloat(priceElement.getAttribute('data-price'));
            const convertedPrice = (originalPrice * conversionRate).toFixed(2);
            priceElement.innerText = `${selectedCurrency} ${convertedPrice}`;
        });

        // Update footer prices
        const subtotalElement = document.querySelector('.subtotal-price');
        const taxElement = document.querySelector('.tax-price');
        const totalFooterElement = document.querySelector('.total-price');

        if (subtotalElement) {
            const subtotal = parseFloat(subtotalElement.getAttribute('data-price'));
            const convertedSubtotal = (subtotal * conversionRate).toFixed(2);
            subtotalElement.innerText = `${selectedCurrency} ${convertedSubtotal}`;
        }

        if (taxElement) {
            const tax = parseFloat(taxElement.getAttribute('data-price'));
            const convertedTax = (tax * conversionRate).toFixed(2);
            taxElement.innerText = `${selectedCurrency} ${convertedTax}`;
        }

        if (totalFooterElement) {
            const totalFooter = parseFloat(totalFooterElement.getAttribute('data-price'));
            const convertedTotalFooter = (totalFooter * conversionRate).toFixed(2);
            totalFooterElement.innerText = `${selectedCurrency} ${convertedTotalFooter}`;
        }
    } else {
        console.error(`No conversion rate found for ${selectedCurrency}`);
    }
}

// Event listener for currency change
document.getElementById('currency').addEventListener('change', updatePriceDisplay);

// Initialize the display with the default selected currency
updatePriceDisplay();

