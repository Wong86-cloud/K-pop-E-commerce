<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/bar.css">
    <link rel="stylesheet" href="assets/css/feedback.css">
</head>
<body>

    <?php include_once('navigation/header.php'); ?>
    <?php include_once('navigation/sidebar.php'); ?>
    
    <section class="feedback-container">   
        <div id="search_bar">
            <div>
                <span class="title" data-translate="Customer Feedback Form">Customer Feedback Form</span>
                <h2><img src="assets/images/navbar/feedback.png" alt="Feedback"></h2>
            </div>
        </div>

        <div class="question-container">
            <form action="db_connection/submit_feedback.php" method="POST" onsubmit="return validateForm();">
                <!-- Question 1 -->
                <div class="question-input">
                    <label class="question-title" data-translate="1. How satisfied are you with the overall shopping experience on KIVORIA?">1. How satisfied are you with the overall shopping experience on KIVORIA?</label><br>
                    <input type="radio" name="q1" value="1" required> 1
                    <input type="radio" name="q1" value="2"> 2
                    <input type="radio" name="q1" value="3"> 3
                    <input type="radio" name="q1" value="4"> 4
                    <input type="radio" name="q1" value="5"> 5
                </div>

                <!-- Question 2 -->
                <div class="question-input">
                    <label class="question-title" data-translate="2. How would you rate the variety of K-pop merchandise available?">2. How would you rate the variety of K-pop merchandise available?</label><br>
                    <input type="radio" name="q2" value="1" required> 1
                    <input type="radio" name="q2" value="2"> 2
                    <input type="radio" name="q2" value="3"> 3
                    <input type="radio" name="q2" value="4"> 4
                    <input type="radio" name="q2" value="5"> 5
                </div>

                <!-- Question 3 -->
                <div class="question-input">
                    <label class="question-title" data-translate="3. Which categories of K-pop products do you frequently purchase?">3. Which categories of K-pop products do you frequently purchase?</label><br>
                    <input type="checkbox" name="q3[]" value="Albums"> Albums<br>
                    <input type="checkbox" name="q3[]" value="Photocards"> Photocards<br>
                    <input type="checkbox" name="q3[]" value="Photobooks"> Photobooks<br>
                    <input type="checkbox" name="q3[]" value="Merchandise"> Merchandise<br>
                </div>

                <!-- Question 4 -->
                <div class="question-input">
                    <label class="question-title" data-translate="4. How easy is it to navigate and find products on our website?">4. How easy is it to navigate and find products on our website?</label><br>
                    <select name="q4" required>
                        <option value="">Select an option</option>
                        <option value="Very easy">Very easy</option>
                        <option value="Easy">Easy</option>
                        <option value="Neutral">Neutral</option>
                        <option value="Difficult">Difficult</option>
                        <option value="Very difficult">Very difficult</option>
                    </select>
                </div>

                <!-- Question 5 -->
                <div class="question-input">
                    <label class="question-title"data-translate="5. What payment method did you use for your most recent purchase?">5. What payment method did you use for your most recent purchase?</label><br>
                    <select name="q5" required>
                        <option value="">Select an option</option>
                        <option value="Credit/Debit Card">Credit/Debit Card</option>
                        <option value="PayPal">PayPal</option>
                    </select>
                </div>

                <!-- Question 6 -->
                <div class="question-input">
                    <label class="question-title" data-translate="6. Did you face any issues during the checkout process?">6. Did you face any issues during the checkout process?</label><br>
                    <input type="radio" name="q6" value="Yes, major issues" required> Yes, major issues<br>
                    <input type="radio" name="q6" value="Yes, minor issues"> Yes, minor issues<br>
                    <input type="radio" name="q6" value="No, everything was smooth"> No, everything was smooth<br>
                    <input type="radio" name="q6" value="Didn’t reach checkout"> Didn’t reach checkout
                </div>

                <!-- Question 7 -->
                <div class="question-input">
                    <label class="question-title" data-translate="7. Which feature do you find most useful on KIVORIA?">7. Which feature do you find most useful on KIVORIA?</label><br>
                    <input type="checkbox" name="q7[]" value="Product reviews"> Product reviews<br>
                    <input type="checkbox" name="q7[]" value="Wishlist"> Wishlist<br>
                    <input type="checkbox" name="q7[]" value="Discussion forums"> Discussion forums<br>
                    <input type="checkbox" name="q7[]" value="Group creation feature"> Group creation feature<br>
                </div>

                <!-- Question 8 -->
                <div class="question-input">
                    <label class="question-title"data-translate="8. How likely are you to recommend KIVORIA to other K-pop fans?">8. How likely are you to recommend KIVORIA to other K-pop fans?</label><br>
                    <input type="radio" name="q8" value="1" required> 1
                    <input type="radio" name="q8" value="2"> 2
                    <input type="radio" name="q8" value="3"> 3
                    <input type="radio" name="q8" value="4"> 4
                    <input type="radio" name="q8" value="5"> 5
                </div>

                <!-- Submit Button -->
                <input type="submit" value="Submit Feedback" class="btn btn-primary">
            </form>
        </div>
    </section>
    
<script>
function validateForm() {
    // Check if at least one checkbox for q3 is selected
    const checkboxes = document.querySelectorAll('input[name="q3[]"]');
    let isChecked = false;
    checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
            isChecked = true;
        }
    });

    if (!isChecked) {
        alert("Please select at least one category of K-pop products you frequently purchase.");
        return false; // Prevent form submission
    }

    // Check if at least one checkbox for q7 is selected
    const checkboxesQ7 = document.querySelectorAll('input[name="q7[]"]');
    let isCheckedQ7 = false;
    checkboxesQ7.forEach((checkbox) => {
        if (checkbox.checked) {
            isCheckedQ7 = true;
        }
    });

    if (!isCheckedQ7) {
        alert("Please select at least one useful feature on KIVORIA.");
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}
</script>

    <script src="assets/js/header/currency.js"></script>
    <script src="assets/js/header/language.js"></script>
    <script src="assets/js/header/feedback.js"></script>
</body>
</html>
