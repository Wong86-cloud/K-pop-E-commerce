<?php
session_start();
include_once('../db_connection/config.php');

// Define all possible options for each question
$possibleAnswers = [
    'q1' => [1, 2, 3, 4, 5],
    'q2' => [1, 2, 3, 4, 5],
    'q3' => ['Albums', 'Photocards', 'Photobooks', 'Merchandise'],
    'q4' => ['Very easy', 'Easy', 'Neutral', 'Difficult', 'Very difficult'],
    'q5' => ['Credit/Debit Card', 'PayPal'],
    'q6' => ['Yes, major issues', 'Yes, minor issues', 'No, everything was smooth', 'Didn’t reach checkout'],
    'q7' => ['Product reviews', 'Wishlist', 'Discussion forums', 'Group Creation feature'],
    'q8' => [1, 2, 3, 4, 5],
];

// Prepare and execute query to fetch feedback data
$query = "SELECT u.unique_id, f.question_1 AS q1, f.question_2 AS q2, f.question_3 AS q3, 
       f.question_4 AS q4, f.question_5 AS q5, f.question_6 AS q6, 
       f.question_7 AS q7, f.question_8 AS q8 
FROM feedback AS f
JOIN users AS u ON f.unique_id = u.unique_id";

$result = $conn->query($query);

if (!$result) {
    error_log("Database query failed: " . $conn->error); 
    echo json_encode(["error" => "Database query failed"]);
    exit;
}

$feedbackData = [
    'q1' => [],
    'q2' => [],
    'q3' => [],
    'q4' => [],
    'q5' => [],
    'q6' => [],
    'q7' => [],
    'q8' => [],
];

$totalResponses = $result->num_rows;

if ($totalResponses > 0) {
    while ($row = $result->fetch_assoc()) {
        foreach ($row as $key => $value) {
            if (isset($feedbackData[$key])) {
                if ($key == 'q3' || $key == 'q7') { 
                    $answers = explode(',', $value);
                    foreach ($answers as $answer) {
                        $answer = trim($answer);
                        if (!empty($answer)) {
                            $feedbackData[$key][$answer] = ($feedbackData[$key][$answer] ?? 0) + 1;
                        }
                    }
                } else {
                    $feedbackData[$key][$value] = ($feedbackData[$key][$value] ?? 0) + 1;
                }
            }
        }
    }

    // Add missing options to the feedback data
    foreach ($possibleAnswers as $key => $options) {
        foreach ($options as $option) {
            if (!isset($feedbackData[$key][$option])) {
                $feedbackData[$key][$option] = 0; // Mark options that haven't been chosen
            }
        }
    }

    // Calculate percentages for each question
    foreach ($feedbackData as $key => &$question) {
        foreach ($question as $answer => &$count) {
            $count = ($count / $totalResponses) * 100; // Convert to percentage
        }
    }
} else {
    error_log("No feedback responses found.");
}

// Send JSON header
header('Content-Type: application/json');

// Check if there's a JSON encoding error
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("JSON encoding error: " . json_last_error_msg());
}

// Return data as JSON
echo json_encode($feedbackData);
$conn->close();
?>
