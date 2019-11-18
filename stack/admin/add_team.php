<?php include('header.php');

if (isset($_REQUEST['submit'])) {
  if (empty($_REQUEST['name']) ||  empty($_REQUEST['role']) || empty($_FILES['pic']))  {
    $empty = "<div class='alert alert-warning alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Warning!</strong> PLEASE ENTER ALL FIELDS COMPLETELY. 
  </div>";
  } else {

    $conn = mysqli_connect("localhost", "root", "", "stack");
    if ($conn) {
      $name = $_REQUEST['name'];
      $role = $_REQUEST['role'];
      $pic = $_FILES['pic']['name'];
      $file_tmp = $_FILES['pic']['tmp_name'];
      $filepath = pathinfo($pic, PATHINFO_FILENAME);
      $fileext = pathinfo($pic, PATHINFO_EXTENSION);
      $suffix = uniqid($name,);
      $target = "team/" . "$suffix" . "$filepath" . "." . "$fileext";
      
      if(isset($_REQUEST['update_id'])){
        $id = $_REQUEST['update_id'];
        $success_id = "<div class='alert alert-warning alert-dismissible' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          <strong>ID=$id!</strong> ID mali gai.... 
          </div>";
        $q = "UPDATE team SET name='$name', role='$role', pic='$target' WHERE id=$id";
      }
      else{
        $q = "INSERT INTO team(name, role, pic) VALUES('$name','$role','$target')";
      }

      if (mysqli_query($conn, $q)) {
        $sucsess = "Your Data Inserted";
        move_uploaded_file($file_tmp, $target);
      }
    }
  }
}
?>

<?php
if (isset($_REQUEST['update_id'])) {
  $id = $_REQUEST['update_id'];
  $conn = mysqli_connect("localhost", "root", "", "stack");
  $sq = "SELECT * FROM team WHERE id=$id";
  $res = mysqli_query($conn, $sq);

  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $name = $row['name'];
    $role = $row['role'];
    $pic = $row['pic'];
  }
}
?>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Team</a> <a href="#" class="current">Add Team Member</a> </div>
    <h1>Add Team Member</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Add Team Member</h5>

          </div>
          <?php echo @$empty; ?>
          <?php echo @$sucsess; ?>
          <?php echo @$sucsess_id; ?>

          <div class="widget-content nopadding">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
              <div class="control-group">
                <label class="control-label">Team Member Name: </label>
                <div class="controls">
                  <input type="text" name="name" value="<?php if(isset($id)){ echo $name; } ?>" class="span11" placeholder="Enter Team Member Name" />
                </div>
              </div>

             <div class="control-group">
                <label class="control-label">Role: </label>
                <div class="controls">
                  <input type="text" name="role" value="<?php if(isset($id)){ echo $role; } ?>" class="span11" placeholder="Enter Role" />
                </div>
              </div>

              <div class="control-group">
                    <label class="control-label">Profile Pic: </label>
                    <div class="controls">
                      <input type="file" name="pic" />
                      <?php if(isset($id)) { ?>
                        <img class='img-circle' src="<?php echo $pic; ?>" height="100px" width="100px" />
                      <?php } ?>
                    </div>
                  </div>           

                <div class="form-actions">
                <input type="submit" name="submit" class="btn btn-success" value="<?php if(isset($id)){ echo "Update Team Member Name"; } else{ echo "Add Team Member"; } ?>">
                </div>
              </div>

            </form>

          </div>
        </div>

      </div>

    </div>

  </div>
</div>
</div>

<?php include('footer.php'); ?>