<?php include ('Views/header.php'); ?>

<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            Tasks
        </div>
        <br>
        <div class="text-right px-4">
            <a href="add_task" class="btn btn-dark">ADD TASK</a>
        </div>
        <div class="card-body">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                unset($_SESSION['message']);
            }
            ?>
            <!-- Search form -->
            <form method="GET" action="task" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" style="margin: 3px;" type="search" placeholder="Search"
                    aria-label="Search" name="search"
                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>description</th>
                            <th>employee</th>
                            <th>project</th>
                            <th>deadline</th>
                            <th>start date</th>
                            <th>end date</th>
                            <th>status</th>
                            <th colspan="2">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = 5;
                        $search = '';
                        if (isset($_GET['search'])) {
                            $search = $_GET['search'];
                        }

                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;
                        $users = $tasks->search($search, $offset, $limit);
                        while ($row = $result->fetch_assoc()) { ?>

                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td>
                                    <?php
                                    $employee = $tasks->getEmployeeNameById($row['employee_id']);
                                    echo is_null($employee) ? "-" : $employee['firstname'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $project = $tasks->getProjectNameById($row['project_id']);
                                    echo is_null($project) ? "-" : $project['name'];
                                    ?>
                                </td>
                                <td><?php echo $row['deadline']; ?></td>
                                <td><?php echo $row['start_date']; ?></td>
                                <td><?php echo $row['end_date']; ?></td>
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
                                    <a href='manage_task?id=<?php echo $row['id']; ?>' class='btn btn-info btn-sm'>Edit</a>
                                    <a href='?type=delete&id=<?php echo $row['id']; ?>' class='btn btn-danger btn-sm'
                                        onclick='return confirmDelete()'>Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
                $data = $tasks->pagination($search);
                // $data = $employeeModel->pagination($search);
                $total_record = $data->num_rows;

                $total_page = ceil($total_record / $limit);

                echo '<ul class="pagination justify-content-center">';
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-linkhref="task?page=' . ($page - 1) . '&search=' . $search . '">Prev</a></li>';
                }
                for ($i = 1; $i <= $total_page; $i++) {
                    echo '<li class="page-item"><a class="page-link" href="task?page=' . $i . '&search=' . $search . '">' . $i . '</a></li>';
                }
                if ($total_page > $page) {
                    echo '<li class="page-item"><a class="page-link" href="task?page=' . ($page + 1) . '&search=' . $search . '">Next</a></li>';
                }
                echo '</ul>';

                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this task? This action cannot be undone.');
    }
</script>

<?php include ('Views/footer.php'); ?>