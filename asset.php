<?php
require('top.inc.php');

// Handle deletion and status update of asset requests
if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    mysqli_query($con, "DELETE FROM asset_requests WHERE id='$id'");
}

// update the reqest_status table after get data from GET
if (isset($_GET['type']) && $_GET['type'] == 'update' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $request_status = mysqli_real_escape_string($con, $_GET['status']);
    mysqli_query($con, "UPDATE asset_requests SET request_status='$request_status' WHERE id='$id'");
}

// Fetch requests based on user role
if ($_SESSION['ROLE'] == 1) {
    $sql = "SELECT asset_requests.*, employee.name, employee.id as eid FROM asset_requests, employee WHERE asset_requests.employee_id=employee.id ORDER BY asset_requests.id DESC";
} else {
    $eid = $_SESSION['USER_ID'];
    $sql = "SELECT asset_requests.*, employee.name, employee.id as eid FROM asset_requests, employee WHERE asset_requests.employee_id='$eid' AND asset_requests.employee_id=employee.id ORDER BY asset_requests.id DESC";
}
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Asset Requests</h4>
                        <?php if ($_SESSION['ROLE'] != 1) { ?>
                        <h4 class="box_title_link"><a href="add_asset_request.php">Add Asset Request</a></h4>
                        <?php } ?>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="5%">ID</th>
                                        <th width="15%">Employee Name</th>
                                        <th width="15%">Asset Type</th>
                                        <th width="14%">Request Date</th>
                                        <th width="25%">Description</th>
                                        <th width="18%">Request Status</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['name'].' ('.$row['eid'].')' ?></td>
                                        <td><?php echo $row['asset_type'] ?></td>
                                        <td><?php echo $row['request_date'] ?></td>
                                        <td><?php echo $row['description'] ?></td>
                                        <td>
                                            <?php
                                            if ($row['request_status'] == 1) {
                                                echo "Pending";
                                            } elseif ($row['request_status'] == 2) {
                                                echo "Approved";
                                            } elseif ($row['request_status'] == 3) {
                                                echo "Rejected";
                                            }
                                            ?>
                                            <?php if ($_SESSION['ROLE'] == 1) { ?>
                                            <select class="form-control" onchange="update_request_status('<?php echo $row['id'] ?>', this.options[this.selectedIndex].value)">
                                                <option value="">Update Status</option>
                                                <option value="2">Approved</option>
                                                <option value="3">Rejected</option>
                                            </select>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($row['request_status'] == 1) { ?>
                                            <a href="asset.php?id=<?php echo $row['id'] ?>&type=delete">Delete</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php 
                                    $i++;
                                    // $i variable is incremented for each row to maintain the serial number
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function update_request_status(id, select_value) {
    window.location.href = 'asset.php?id=' + id + '&type=update&status=' + select_value;
}
</script>
<?php
require('footer.inc.php');
?>
<!-- The code handles the display, deletion, and status update of asset requests.
Admins can delete pending requests and update the status of requests.
Non-admin users can view their own requests and add new ones.
The status of requests is displayed and can be updated using a dropdown menu by admins. -->