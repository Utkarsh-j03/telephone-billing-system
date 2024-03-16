<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Call Logs - Telephone Billing System</title>
    <link rel="stylesheet" href="./misc/styles_log.css"> <!-- Link your CSS file here -->
</head>

<body>

    <nav>
        <div class="heading">View Call Logs</div>
        <div class="links">
            <a href="home.html">Home</a>
            <a href="customers.php">Customers</a>
            <a href="generate_bill.php">Generate Bill</a>
            <a href="add_calls.php">Add Calls</a>
        </div>
    </nav>
    <section class="call-logs-container">
        <div class="container">
            <h2>Call Logs</h2>
            <ul>
                <?php
                include_once 'db_connect.php';

                if (isset($_GET['customer_id'])) {
                    $customer_id = $_GET['customer_id'];
                    $sql = "SELECT * FROM calls WHERE customer_id=$customer_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li>" . $row['call_date'] . " - " . $row['minutes'] . " minutes</li>";
                        }
                    } else {
                        echo "<li>No call logs found for this customer.</li>";
                    }
                } else {
                    echo "<li>Invalid customer ID.</li>";
                }
                ?>
            </ul>
        </div>
    </section>
</body>

</html>