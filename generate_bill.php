<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Bill - Telephone Billing System</title>
    <link rel="stylesheet" href="./misc/styles_bill.css"> <!-- Link your CSS file here -->
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <nav>
        <div class="heading">Generate Bill</div>
        <div class="links">
            <a href="home.html">Home</a>
            <a href="customers.php">Customers</a>
            <a href="add_calls.php">Add Calls</a>
        </div>
    </nav>
    <section class="generate-bill-container">
        <form action="generate_bill.php" method="post">
            <h3>Generate Bill</h3>
            <div class="field">
                <div>
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                </div>
                <div>
                    <label for="telephone_number">Telephone Number:</label>
                    <input type="text" id="telephone_number" name="telephone_number" required>
                </div>
                <!-- Additional input fields for bill generation -->
                <button type="submit" name="generate_bill">Generate Bill</button>
            </div>
        </form>
        <div class="bill-result">

            <?php
        include_once 'db_connect.php';

        if (isset($_POST['generate_bill']) && isset($_POST['customer_name']) && isset($_POST['telephone_number'])) {
            $customer_name = $_POST['customer_name'];
            $telephone_number = $_POST['telephone_number'];

            // Fetch customer details
            $sql_customer = "SELECT * FROM customers WHERE name='$customer_name' AND telephone_number='$telephone_number'";
            $result_customer = $conn->query($sql_customer);

            if ($result_customer->num_rows > 0) {
                $row_customer = $result_customer->fetch_assoc();
                $customer_id = $row_customer['id'];
                $customer_name = $row_customer['name'];
                $telephone_number = $row_customer['telephone_number'];

                // Fetch call logs for the customer
                $sql_calls = "SELECT * FROM calls WHERE customer_id='$customer_id'";
                $result_calls = $conn->query($sql_calls);

                // Calculate total cost of calls
                $total_cost = 0;
                while ($row_calls = $result_calls->fetch_assoc()) {
                    $total_cost += $row_calls['minutes'] * 1.5; // 1.5rs per minute
                }

                // Calculate total amount payable
                $maintenance_charge = 40;
                $total_amount = $total_cost + $maintenance_charge;
                $gst_charge = $total_amount * 0.12; // 12% GST
                $net_amount = $total_amount + $gst_charge;

                // Display bill in tabulated format
                echo "<div class='invoice'><h3>Bill for Customer: $customer_name</h3>";
                echo "<p>Telephone Number: $telephone_number</p>";
                echo "<p>Date and Time of Bill Generation: " . date('Y-m-d H:i:s') . "</p>";
                echo "<table>";
                echo "<tr><th>Call Date</th><th>Minutes</th><th>Cost (Rs.)</th></tr>";
                $result_calls->data_seek(0); // Reset pointer to beginning of result set
                while ($row_calls = $result_calls->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_calls['call_date'] . "</td>";
                    echo "<td>" . $row_calls['minutes'] . "</td>";
                    echo "<td>" . ($row_calls['minutes'] * 1.5) . "</td>"; // Cost calculation
                    echo "</tr>";
                }
                echo "</table>";
                echo "<p>Total Cost of Calls: Rs. $total_cost</p>";
                echo "<p>Maintenance Charge: Rs. $maintenance_charge</p>";
                echo "<p>GST (12%): Rs. $gst_charge</p>";
                echo "<h4>Total Amount Payable: Rs. $net_amount</h4>";
            } else {
                echo "<p>No customer found with the provided details.</p>";
            }
            echo "<a href='generate_bill.php'>Back to Generate Bill</a></div>";
        }
        ?>

    </section>

</body>

</html>