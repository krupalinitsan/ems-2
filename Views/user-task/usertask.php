<!-- app/Views/tasks.php -->
<?php include ('Views/header.php'); ?>

<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-newspaper"></i>
            My tasks
        </div>
        <br>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Task ID</th>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?php echo $task['id']; ?></td>
                                <td><?php echo $task['name']; ?></td>
                                <td><?php echo $task['description']; ?></td>
                                <td><?php echo $task['deadline']; ?></td>
                                <td><?php echo $task['start_date']; ?></td>
                                <td><?php echo $task['end_date']; ?></td>
                                <td>
                                    <?php if ($task['status'] == 1): ?>
                                        <span class='badge badge-complete'>
                                            <a href='?type=status&operation=deactive&id=<?php echo $task['id']; ?>'>Active</a>
                                        </span>&nbsp;
                                    <?php else: ?>
                                        <span class='badge badge-pending'>
                                            <a href='?type=status&operation=active&id=<?php echo $task['id']; ?>'>Deactive</a>
                                        </span>&nbsp;
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include ('Views/footer.php'); ?>