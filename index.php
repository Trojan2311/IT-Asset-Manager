<?php
include 'includes/db.php';
?>

<?php
session_start(); // Start the session at the very top

// Ensure user is logged in before accessing session variables
if (!isset($_SESSION['username'])) {
    header("Location: pages/login.php");
    exit;
}

// Get user details
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "user";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between">
            <h2>IT Manager Dashboard</h2>
            <div>
                <p>Welcome, <strong><?php echo htmlspecialchars($username); ?></strong>
                    (<?php echo htmlspecialchars($role); ?>)</p>
                <a href="pages/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <hr>




        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>IT Manager Dashboard</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        </head>

        <body>
            <div class="container mt-4">
                <h2 class="text-center">IT Manager Dashboard</h2>
                <a href="pages/add_asset.php" class="btn btn-primary mb-3">Add New Asset</a>

                <!-- 🔍 Search & Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" id="search" class="form-control"
                            placeholder="Search by Serial No, Model, or Asset Tag">
                    </div>
                    <div class="col-md-3">
                        <select id="filter_status" class="form-control">
                            <option value="">Filter by Status</option>
                            <option value="New">New</option>
                            <option value="Used">Used</option>
                            <option value="EOL">EOL</option>
                            <option value="Resale">Resale</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filter_warehouse" class="form-control">
                            <option value="">Filter by Warehouse</option>
                            <option value="Huntingwood">Huntingwood</option>
                            <option value="GLOBAL">GLOBAL</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success" id="search_button">Search</button>
                    </div>
                </div>
                <div class="mb-3">
                    <td>
                        <?php if ($_SESSION['role'] == 'admin') { ?>
                            <a href='pages/edit_asset.php?id=<?php echo $row['id']; ?>'
                                class='btn btn-warning btn-sm'>Edit</a>
                            <a href='pages/delete_asset.php?id=<?php echo $row['id']; ?>'
                                class='btn btn-danger btn-sm'>Delete</a>
                        <?php } ?>
                    </td>

                    <a href="pages/export_excel.php" class="btn btn-success">Export to Excel</a>
                    <a href="pages/export_pdf.php" class="btn btn-danger">Export to PDF</a>
                    <br> <br>
                    <a href="pages/dashboard.php" class="btn btn-info mb-3">View Dashboard</a>
                    <br>
                </div>
                <br>
                <a href="pages/bulk_upload.php" class="btn btn-warning mb-3">Bulk Upload (CSV)</a>
                <br>
                <!-- 🔹 Asset Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Type</th>
                            <th>Make</th>
                            <th>Model</th>
                            <th>Serial No</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Received Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="asset_table">
                        <?php
                        $sql = "SELECT * FROM assets ORDER BY id ASC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['item_type']}</td>
                            <td>{$row['make']}</td>
                            <td>{$row['model']}</td>
                            <td>{$row['serial_no']}</td>
                            <td>{$row['location']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['received_date']}</td>
                            <td>
                                <a href='pages/edit_asset.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='pages/delete_asset.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>No assets found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <script>
                $(document).ready(function () {
                    $("#search_button").click(function () {
                        var search = $("#search").val();
                        var status = $("#filter_status").val();
                        var warehouse = $("#filter_warehouse").val();

                        $.ajax({
                            url: "pages/search_assets.php",
                            method: "POST",
                            data: { search: search, status: status, warehouse: warehouse },
                            success: function (data) {
                                $("#asset_table").html(data);
                            }
                        });
                    });
                });
            </script>
        </body>

        </html>