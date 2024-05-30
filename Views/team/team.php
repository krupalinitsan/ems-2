<?php
include ("Views/header.php");
?>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            Teams
        </div>
        <br>
        <div class="text-right px-4">
            <a href="add_team" class="btn btn-dark">ADD TEAM</a>
        </div>
        <!-- <button class="btn btn-dark"><a href="add_team.php">ADD TEAM</a></button> -->
        <div class="card-body">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']); // Clear the message after displaying it
            }
            ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>team name</th>
                            <th>status</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>

                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                        echo "<span class='badge badge-success'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>";
                                    } else {
                                        echo "<span class='badge badge-secondary'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Inactive</a></span>";
                                    }
                                    ?>
                                </td>

                                <td>
                                    <a href='manage_team?id=<?php echo $row['id']; ?>' class='btn btn-info btn-sm'>Edit</a>
                                    <a href='?type=delete&id=<?php echo $row['id']; ?>' class='btn btn-danger btn-sm'
                                        onclick='return confirmDelete()'>Delete</a>
                                </td>

                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this team? This action cannot be undone.');
    }
</script>

<?php include ('Views/footer.php'); ?>