<?php 
include('authentication.php');
include('includes/header.php');
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        </button>
      </div>
      <div class="modal-body"> Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <form action="code.php" method="POST">
          <button type="submit" name="logout_btn" class="btn btn-danger">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid px-4">
                        <ol class="breadcrumb mb-4 mt-3">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item ">Account</li>
                            <li class="breadcrumb-item active">Officer Account</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                            <button class="btn btn-primary" href="officer_account_add.php"><i class="fa fa-plus"></i> Add Officer Account</button>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>Status</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                        <th>Status</th>
                                        <th>ACTION</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                            $query = "SELECT
                            ssgsystem.`user`.user_id, 
                            ssgsystem.`user`.fname, 
                            ssgsystem.`user`.mname, 
                            ssgsystem.`user`.lname, 
                            ssgsystem.`user`.email, 
                            ssgsystem.staff_position.pos_name, 
                            ssgsystem.user_status.user_status
                        FROM
                            ssgsystem.`user`
                            INNER JOIN
                            ssgsystem.staff_position
                            ON 
                                ssgsystem.`user`.pos_name = ssgsystem.staff_position.pos_id
                            INNER JOIN
                            ssgsystem.user_status
                            ON 
                                ssgsystem.`user`.user_status = ssgsystem.user_status.user_status_id
                        WHERE
                            ssgsystem.`user`.user_type = 1";
                            $query_run = mysqli_query($con, $query);
                            if(mysqli_num_rows($query_run) > 0)
                            {
                                foreach($query_run as $row)
                                {
                                    ?>
                                    <tr>
                                        <td><?= $row['user_id']; ?></td>
                                        <td><?= $row['fname']; ?> <?= $row['mname']; ?> <?= $row['lname']; ?> </td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['pos_name']; ?></td>
                                        <td><?= $row['user_status']; ?></td>
                                        <td> <a href="student_view.php?id=<?=$row['user_id'];?>" class="btn btn-info btn-sm"><i class="fa-sharp fa-solid fa-eye"></i></a>
                                    
                                    <a href="student_edit.php?id=<?=$row['user_id'];?>" class="btn btn-warning btn-sm"><i class="fa-sharp fa-solid fa-pen"></i></a>

                                    <a href="student_edit.php?id=<?=$row['user_id'];?>" class="btn btn-danger btn-sm"><i class="fa-sharp fa-solid fa-trash"></i></a>

                                    </td>
                                    </tr>
                                    <?php
                                }
                            }
                            else
                            {
                            ?>
                                <tr>
                                    <td colspan="6">No Record Found</td>
                                </tr>
                            <?php
                            }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>