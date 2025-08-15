<?php
require_once 'db_con.php';

if (isset($_GET['approve'])) {
    $user_id = $_GET['approve'];
    $query = "UPDATE `users` SET `status` = 'approved' WHERE `id` = $user_id";
    mysqli_query($db_con, $query);
    header('Location: index.php?page=role-requests');
}

if (isset($_GET['decline'])) {
    $user_id = $_GET['decline'];
    $query = "UPDATE `users` SET `status` = 'declined' WHERE `id` = $user_id";
    mysqli_query($db_con, $query);
    header('Location: index.php?page=role-requests');
}

?>
<h1 class="text-primary"><i class="fas fa-user-check"></i> Role Requests</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Role Requests</li>
    </ol>
</nav>

<table class="table table-striped table-hover table-bordered" id="data">
    <thead class="thead-dark">
    <tr>
        <th>Full Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>Requested Role</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM `users` WHERE `status` = 'pending'";
    $result = mysqli_query($db_con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row['full_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>
                <a href="index.php?page=role-requests&approve=<?php echo $row['id']; ?>" class="btn btn-success">Approve</a>
                <a href="index.php?page=role-requests&decline=<?php echo $row['id']; ?>" class="btn btn-danger">Decline</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
