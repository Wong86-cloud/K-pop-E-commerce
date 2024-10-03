document.getElementById('phone-number').addEventListener('input', function() {
    const countryCode = document.getElementById('country-code').value;
    const phoneNumber = this.value;
    
    const fullPhoneNumber = countryCode + phoneNumber;
    console.log("Full Phone Number: " + fullPhoneNumber); // Example: +11234567890
});

document.addEventListener('DOMContentLoaded', function () {
    const productPrice = 150.00;
    const shippingMethodForm = document.getElementById('shipping-method-form');
    const shippingFeeElement = document.getElementById('shipping-fee');
    const totalPriceElement = document.getElementById('total-price');
    const paymentForm = document.getElementById('payment-method-form');
    const paymentError = document.querySelector('.payment-error');
    const paymentSuccess = document.querySelector('.payment-success');
    const viewOrderButton = document.getElementById('view-order-button');

    // Function to update total price based on shipping method
    function updateTotalPrice() {
        const selectedShippingMethod = document.querySelector('input[name="shipping-method"]:checked');
        const shippingFee = parseFloat(selectedShippingMethod.value);
        const totalPrice = productPrice + shippingFee;

        // Update the displayed shipping fee and total price
        shippingFeeElement.textContent = `$${shippingFee.toFixed(2)}`;
        totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
    }

    // Attach event listener to the shipping method form
    shippingMethodForm.addEventListener('change', updateTotalPrice);

    // Initialize the total price on page load
    updateTotalPrice();

    // Event listener for payment submission
    document.querySelector('.pay-now-btn').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default form submission

        // Get the customer info fields
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const address = document.getElementById('address').value;
        const postcode = document.getElementById('postcode').value;
        const city = document.getElementById('city').value;

        // Check if all fields are filled
        if (!name || !email || !address || !postcode || !city) {
            paymentError.style.display = 'block'; // Show error message
            paymentSuccess.style.display = 'none'; // Hide success message
        } else {
            paymentError.style.display = 'none'; // Hide error message
            paymentSuccess.style.display = 'block'; // Show success message
        }
    });

    // Event listener for view order button
    viewOrderButton.addEventListener('click', function () {
        window.location.href = 'delivery.php'; // Redirect to delivery page
    });
});
