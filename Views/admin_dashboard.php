<?php
include ("Views/header.php");
?>
<div class="container-fluid">
    <!-- DataTables Example -->
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            Current Projects
        </div>
        <br>
        <!-- <button class="btn btn-dark" style="align: right;"><a href="add_projects.php">ADD PROJECT</a></button> -->

        <div class="card-body">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']); // Clear the message after displaying it
            }
            ?>
            <div class="row">
                <?php while ($row = $projects->fetch_assoc()) { ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <p class="card-text"><small class="text-muted">Start Date:
                                        <?php echo $row['start_date']; ?></small></p>
                                <p class="card-text"><small class="text-muted">End Date:
                                        <?php echo $row['end_date']; ?></small></p>
                                <p class="card-text"><small class="text-muted">Deadline:
                                        <?php echo $row['deadline']; ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<!-- JavaScript for confirmation prompts -->
<?php include ('Views/footer.php'); ?>