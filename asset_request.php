<?php
require('top.inc.php');

// Handle delete request
if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    mysqli_query($con, "DELETE FROM asset_requests WHERE id='$id'");
}

// Fetch asset requests
$res = mysqli_query($con, "SELECT asset_requests.*, assets.asset_name, employee.name AS employee_name FROM asset_requests JOIN assets ON asset_requests.asset_id = assets.id JOIN employee ON asset_requests.employee_id = employee.id ORDER BY asset_requests.id DESC");
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Asset Requests</h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="5%">ID</th>
                                        <th width="30%">Asset Name</th>
                                        <th width="20%">Requested By</th>
                                        <th width="20%">Request Date</th>
                                        <th width="20%">Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['asset_name']; ?></td>
                                            <td><?php echo $row['employee_name']; ?></td>
                                            <td><?php echo $row['request_date']; ?></td>
                                            <td>
                                                <?php 
                                                if ($row['status'] == 1) {
                                                    echo "Requested";
                                                } elseif ($row['status'] == 2) {
                                                    echo "Approved";
                                                } elseif ($row['status'] == 3) {
                                                    echo "Rejected";
                                                } 
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($row['status'] == 1) { ?>
                                                    <a href="assets_request.php?id=<?php echo $row['id']; ?>&type=delete">Delete</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php 
                                    $i++;
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
<?php
require('footer.inc.php');
?>
<!-- The code handles the display and management of asset requests, allowing for deletion of requests with a status of "Requested."
The table shows a list of asset requests, including details like the asset name, who requested it, when it was requested, its current status, and an option to delete it if it's still pending. -->