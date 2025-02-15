<?php
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IT Manager Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">IT Manager Dashboard</h2>
        <a href="pages/add_asset.php" class="btn btn-primary mb-3">Add New Asset</a>
        
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
            <tbody>
                <?php
                $sql = "SELECT * FROM assets";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
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
</body>
</html>
