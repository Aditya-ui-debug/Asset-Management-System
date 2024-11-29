<?php
require('top.inc.php');

// $_server is a superglobal variable which contains information about header  ,path,and script location
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_SESSION['USER_ID'];
    // mysqli_real_escape_string help us prevent from sql injection attack . Takes two parameter connection variable and method by which data is sent. it insert '\' escape charater if it encounter any space thus makes the sql query wrong 
    $asset_type = mysqli_real_escape_string($con, $_POST['asset_type']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $request_date = date('Y-m-d');

    mysqli_query($con, "INSERT INTO asset_requests (employee_id, asset_type, request_date, description) VALUES ('$employee_id', '$asset_type', '$request_date', '$description')");

    header('location:asset.php');
    die();
}
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Add Asset Request</h4>
                    </div>
                    <div class="card-body--">
                        <form method="post" action="">
                            <label for="asset_type">Asset Type:</label>
                            <select name="asset_type" required>
                                <option value="">Select Asset Type</option>
                                <?php
                                $res = mysqli_query($con, "SELECT * FROM asset_type");
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='{$row['asset_name']}'>{$row['asset_name']}</option>";
                                }
                                ?>
                            </select>
                            <label for="description">Quantity:</label>
                            <textarea name="description" required></textarea>
                            <button type="submit">Request Asset</button>
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


<!-- The code handles the submission of an asset request form.
It checks if the form was submitted using POST, sanitizes the input, and then inserts the data into the asset_requests table in the database.
After inserting the data, the user is redirected to asset.php.
The form displays a dropdown of available asset types from the database and a textarea for the description. -->