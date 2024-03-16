<?php
include_once 'db_connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Telephone Billing System</title>
    <link rel="stylesheet" href="./misc/styles_customers.css"> <!-- Link your CSS file here -->
</head>

<body>
    <nav class="mNav">
        <div class="heading">CUSTOMERS</div>
        <div class="links">
            <a href="home.html">Home</a>
            <a href="generate_bill.php">Generate Bill</a>
            <a href="add_calls.php">Add Calls</a>
        </div>
    </nav>
    <section class="customer-container">
        <div class="container">
            <h2>Customer List</h2>
            <div class="customer-list">
                <?php
                    include_once 'db_connect.php';
                    $sql = "SELECT * FROM customers";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li>" . $row['name'] . " - " . $row['telephone_number'] . " ";
                            echo "<span class='links'><a href='customers.php?delete_customer=" . $row['id'] . "'>Delete</a>";
                            echo "  <a href='view_calls.php?customer_id=" . $row['id'] . "'>View Call Logs</a></span></li>";
                        }
                    } else {
                        echo "No customers found.";
                    }
                    ?>
            </div>
        </div>

        <div class="add-customer">
            <form action="customers.php" method="post">
                <h3>Add New Customer</h3>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="telephone_number">Telephone Number:</label>
                <input type="text" id="telephone_number" name="telephone_number" required>
                <button type="submit" name="add_customer">Add Customer</button>
            </form>
        </div>
    </section>
</body>

</html>

<?php
// Include database connection code here
include_once 'db_connect.php';

// Add new customer
if (isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $telephone_number = $_POST['telephone_number'];

    $sql = "INSERT INTO customers (name, telephone_number) VALUES ('$name', '$telephone_number')";

    if ($conn->query($sql) === TRUE) {
        // Refresh the page after adding the customer
        header("Location: customers.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete customer

// if (isset($_GET['delete_customer'])) {
//     $customer_id = $_GET['delete_customer'];

//     $sql = "DELETE FROM customers WHERE id=$customer_id";

//     if ($conn->query($sql) === TRUE) {
//         // Refresh the page after deleting the customer
//         header("Location: customers.php");
//         exit;
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }

if (isset($_GET['delete_customer'])) {
    $customer_id = $_GET['delete_customer'];

    // First, delete associated calls
    $sql_delete_calls = "DELETE FROM calls WHERE customer_id=$customer_id";

    if ($conn->query($sql_delete_calls) === TRUE) {
        // Now, delete the customer
        $sql_delete_customer = "DELETE FROM customers WHERE id=$customer_id";

        if ($conn->query($sql_delete_customer) === TRUE) {
            // Refresh the page after deleting the customer
            header("Location: customers.php");
            exit;
        } else {
            echo "Error: " . $sql_delete_customer . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_delete_calls . "<br>" . $conn->error;
    }
}

// Close database connection
//$conn->close();
?>