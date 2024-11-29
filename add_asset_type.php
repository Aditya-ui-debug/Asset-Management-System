<?php
require('top.inc.php');

// Check if the user is an admin (role 1)
if ($_SESSION['ROLE'] != 1) {
    header('location:add_employee.php?id=' . $_SESSION['USER_ID']);
    die();
}

// Handle deletion of asset types
if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    mysqli_query($con, "DELETE FROM asset_type WHERE id='$id'");
}

// Handle adding or updating asset types
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $asset_name = mysqli_real_escape_string($con, $_POST['asset_name']);
    $id = isset($_POST['id']) ? mysqli_real_escape_string($con, $_POST['id']) : '';

    if ($id == '') {
        mysqli_query($con, "INSERT INTO asset_type(asset_name) VALUES('$asset_name')");
    } else {
        mysqli_query($con, "UPDATE asset_type SET asset_name='$asset_name' WHERE id='$id'");
    }

    header('location:add_asset_type.php');
    die();
}
// Executes an SQL SELECT query to retrieve all asset types from the asset_type table, ordering them by id in descending order. 
$res = mysqli_query($con, "SELECT * FROM asset_type ORDER BY id DESC");
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
        <!-- This number specifies how many of the 12 available columns this element should occupy. So "col-xl-12" means that on extra-large screens (1200px and above), the element will take up all 12 columns, which means it will span the full width of the row. -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Asset Type Management</h4>
                        <h4 class="box_title_link"><a href="add_asset_request.php">Add Asset Type</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="5%">ID</th>
                                        <th width="70%">Asset Type</th>
                                        <th width="20%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['asset_name'] ?></td>
                                        <td>
                                            <a href="add_asset_type.php?id=<?php echo $row['id'] ?>">Edit</a> 
                                            <a href="add_asset_type.php?id=<?php echo $row['id'] ?>&type=delete">Delete</a>
                                        </td>
                                    </tr>
                                    <?php 
                                    $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <input type="text" name="asset_name" placeholder="Enter Asset Type" required />
                            <button type="submit">Add Asset Type</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.inc.php');
?>
