<?php
// Ensure that there is no whitespace or output before session_start()
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Check if item_id is submitted via POST
if (isset($_POST['item_id'])) {
    // Sanitize the item_id to prevent SQL injection (assuming item_id is an integer)
    $item_id = intval($_POST['item_id']);

    // Establish a database connection (assuming you've already included database credentials)
    require_once "config2.php";

    // Retrieve user_id from session
    $user_id = $_SESSION['user_id'];

    // Prepare and execute SQL query to remove item from cart
    $sql = "DELETE FROM cart_items WHERE id = $item_id AND user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Item successfully removed from cart
        header("Location: cart.php"); // Redirect back to cart page
        exit();
    } else {
        // Error occurred while removing item
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle invalid requests
    echo "Invalid request";
}
?>
