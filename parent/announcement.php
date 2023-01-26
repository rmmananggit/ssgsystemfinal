<?php 
include('authentication.php');
include('includes/header.php');
?>


<div class="container-fluid">
<div class="col-lg-12 mb-3 mt-3">
 
<h2 class="text-center">ANNOUNCEMENT</h2>
<?php
$query = "SELECT
announcement.*
FROM
announcement
ORDER BY
announcement.announcement_date DESC";
$query_run = mysqli_query($con, $query);
$check_announcement = mysqli_num_rows($query_run) > 0;

if($check_announcement)
{
    while($row = mysqli_fetch_array($query_run))
    {
        ?>
<div class="card mt-3">
  <div class="card-header">Title: <?php echo $row['announcement_title']; ?>
  </div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $row['announcement_body']; ?></h5>
    <p class="card-text">By: <?php echo $row['announcement_publish'];?> <br> <?php echo $row['announcement_date']; ?>
</p>
  </div>
</div>
        <?php
    }
}
else
{
    echo "No Announcement";
}


?>
</div>
</div>

<?php include('includes/footer.php');?>






