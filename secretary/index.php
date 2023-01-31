<?php 
include('authentication.php');
include('includes/header.php');
?>

<!-- MODAL -->
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
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Student Account

                                    <?php
                                            $total_student = "SELECT * FROM `student`";
                                            $total_student_query_run = mysqli_query($con, $total_student);

                                            if($student_count = mysqli_num_rows($total_student_query_run))
                                            {
                                                echo '<h4>'.$student_count.'</h4>';
                                            }
                                            else{
                                                echo '<h4>0</h4>';
                                            }

                                            ?>

                                    
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="student_account.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Staff Account <br> 


                                    <?php
                                            $staff = "SELECT
                                            `user`.*
                                        FROM
                                            `user`
                                        WHERE
                                            `user`.pos_name != 4";
                                            $staff_query_run = mysqli_query($con, $staff);

                                            if($staff_count = mysqli_num_rows($staff_query_run))
                                            {
                                                echo '<h4>'.$staff_count.'</h4>';
                                            }
                                            else{
                                                echo '<h4>0</h4>';
                                            }

                                            ?>



                                  </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="officer_account.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Total Fines Transaction

                                    
                                    <?php
                                            $total_fines = "SELECT * FROM `fines_transaction`";
                                            $total_fines_query_run = mysqli_query($con, $total_fines);

                                            if($fines_count = mysqli_num_rows($total_fines_query_run))
                                            {
                                                echo '<h4>'.$fines_count.'</h4>';
                                            }
                                            else{
                                                echo '<h4>0</h4>';
                                            }

                                            ?>



                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="transaction_view.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Total Archived Account


                                    <?php
                                            $arch_student = "SELECT
                                            *, 
                                            student.*
                                        FROM
                                            student
                                        WHERE
                                            student.user_status = 2";
                                            $arch_student_query_run = mysqli_query($con, $arch_student);

                                            if($arch_cont = mysqli_num_rows($arch_student_query_run))
                                            {
                                                echo '<h4>'.$arch_cont.'</h4>';
                                            }
                                            else{
                                                echo '<h4>0</h4>';
                                            }

                                            ?>




                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>






<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>