<?php
require('top.inc.php');

if ($_SESSION['ROLE'] != 1) {
    header('location:index.php');
    die();
}

$res = mysqli_query($con, "SELECT * FROM assets ORDER BY id DESC");
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Manage Assets</h4>
                        <h4 class="box_title_link"><a href="add_asset.php">Add Asset</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="70%">Asset Name</th>
                                        <th width="25%">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['asset_name'] ?></td>
                                        <td><?php echo $row['asset_description'] ?></td>
                                    </tr>
                                    <?php } ?>
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
