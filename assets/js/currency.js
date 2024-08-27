const currencySelect = document.getElementById('currency');
const convertedValueElement = document.getElementById('converted-value');

const fetchExchangeRate = async (baseCurrency, targetCurrency) => {
    const apiKey = 'f0c8adfc8746f7d322b22e86'; // Replace with your API key
    const response = await fetch('https://v6.exchangerate-api.com/v6/f0c8adfc8746f7d322b22e86/latest/USD');
    const data = await response.json();
    return data.conversion_rates[targetCurrency];
};

const updateCurrency = async (selectedCurrency) => {
    const baseAmount = 100; // Base amount to convert
    const baseCurrency = 'USD'; // Base currency
    const exchangeRate = await fetchExchangeRate(baseCurrency, selectedCurrency);
    const convertedAmount = (baseAmount * exchangeRate).toFixed(2);
    convertedValueElement.innerText = `Amount: ${selectedCurrency} ${convertedAmount}`;
};

currencySelect.addEventListener('change', (event) => {
    const selectedCurrency = event.target.value;
    updateCurrency(selectedCurrency);
});

// Initial load
updateCurrency(currencySelect.value);
