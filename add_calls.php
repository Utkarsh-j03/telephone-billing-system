<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Calls - Telephone Billing System</title>
    <link rel="stylesheet" href="./misc/styles_calls.css"> <!-- Link your CSS file here -->
</head>

<body>
    <nav>
        <div class="heading">Add Calls</div>
        <div class="links">
            <a href="home.html">Home</a>
            <a href="customers.php">Customers</a>
            <a href="generate_bill.php">Generate Bill</a>
        </div>
    </nav>
    <section class="add-calls-container">
        <form action="add_calls.php" method="post">
            <h3>Add Calls</h3>
            <label for="customer_name">Customer Name:</label>
            <select id="customer_name" name="customer_name" required>
                <!-- Populate select options with customer names fetched from the database -->
                <?php
                include_once 'db_connect.php';
                $sql = "SELECT * FROM customers";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                    }
                }
                ?>
            </select>
            <div class="line">
                <div class="line1">
                    <label for="minutes">Minutes:</label>
                    <input type="number" id="minutes" name="minutes" required>
                </div>
                <div class="line2">
                    <label for="call_date">Date of Call:</label>
                    <input type="date" id="call_date" name="call_date" required>
                </div>
            </div>
            <button type="submit" name="add_call">Add Call</button>
        </form>
    </section>
</body>

</html>

<?php
// Include database connection code here
include_once 'db_connect.php';

// Function to add call
function addCall($conn, $customer_name, $minutes, $call_date) {
    // Get customer ID based on customer name
    $sql = "SELECT id FROM customers WHERE name='$customer_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $customer_id = $row['id'];

        // Insert call details into calls table
        $sql = "INSERT INTO calls (customer_id, minutes, call_date) VALUES ('$customer_id', '$minutes', '$call_date')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Call added successfully for $customer_name on $call_date.</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<p>No customer found with the provided name.</p>";
    }
}

// Handle form submission for adding call
if (isset($_POST['add_call'])) {
    $customer_name = $_POST['customer_name'];
    $minutes = $_POST['minutes'];
    $call_date = $_POST['call_date'];

    addCall($conn, $customer_name, $minutes, $call_date);
}

// Close database connection
$conn->close();
?>