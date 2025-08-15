<?php
require_once 'admin/db_con.php';
session_start();

if (!isset($_SESSION['user_login'])) {
    header('Location: admin/login.php');
}

$username = $_SESSION['user_login'];
$query = "SELECT * FROM `users` WHERE `username` = '$username'";
$result = mysqli_query($db_con, $query);
$user = mysqli_fetch_assoc($result);

if ($user['role'] !== 'default') {
    header('Location: admin/index.php');
}

if (isset($_POST['request_role'])) {
    $role = $_POST['role'];

    $query = "UPDATE `users` SET `role` = '$role', `status` = 'pending' WHERE `username` = '$username'";
    $result = mysqli_query($db_con, $query);

    if ($result) {
        $_SESSION['message'] = "Your role request has been submitted. Please wait for admin approval.";
        header('Location: admin/login.php');
    } else {
        $error = "Failed to submit role request. Please try again.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Request Role</title>
</head>
<body>
<div class="container">
    <br>
    <h1 class="text-center">Request a Role</h1>
    <br>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <form method="POST" action="request-role.php">
                <div class="form-group">
                    <label for="role">Select Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Select a role</option>
                        <option value="player">Player</option>
                        <option value="coach">Coach</option>
                    </select>
                </div>
                <button type="submit" name="request_role" class="btn btn-primary">Submit Request</button>
                <a href="admin/logout.php" class="btn btn-secondary">Logout</a>
            </form>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="js/jquery-3.5.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
