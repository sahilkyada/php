<?php ob_start(); include('header.php');

if (isset($_REQUEST['submit'])) {
  if (empty($_FILES['file']['name'])) {
    $empty = "<div class='alert alert-warning alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Warning!</strong> PLEASE SELECT ANY FILE FIRST. 
  </div>";
  } else {

    $conn = mysqli_connect("localhost", "root", "", "stack");
    if ($conn) {
      $file = $_FILES['file']['name'];
      $file_tmp = $_FILES['file']['tmp_name'];
      $filepath = pathinfo($file, PATHINFO_FILENAME);
      $fileext = pathinfo($file, PATHINFO_EXTENSION);
      $suffix = uniqid($name,);
      $target = "file/" . "$suffix" . "$filepath" . "." . "$fileext";
 
      $q = "INSERT INTO file_handling(name) VALUES('$target')";
      
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
  $sq = "SELECT * FROM file_handling WHERE id=$id";
  $res = mysqli_query($conn, $sq);

  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $file = $row['name'];
  }

  if(file_exists($file)){

    $content = file_get_contents($file);

  }

  if(isset($_REQUEST['up_submit'])){

    $ta_content = $_REQUEST['ta_content'];

    if(file_put_contents($file, $ta_content)){
      header("location: view_file.php");
    }else{
      header("location: view_file.php");
    }

  }
}
?>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">File Handling</a> <a href="#" class="current">Add File</a> </div>
    <h1>Add File</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Add File</h5>

          </div>
          <?php echo @$empty; ?>
          <?php echo @$sucsess; ?>
          <?php echo @$sucsess_id; ?>

          <div class="widget-content nopadding">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
            
            
            
            <div class="control-group">

            <?php if(isset($id)){ ?>

              <label class="control-label"> Content :</label>
              <textarea class="form-control" rows="3" name="ta_content"><?php echo $content; ?></textarea>

              <div class="form-actions">
                    <input type="submit" name="up_submit" class="btn btn-success" value="Update File">
                  </div>

            <?php }else{ ?>

                <label class="control-label"> File :</label>
                <div class="controls">
                  <input type="file" name="file" />
                </div>

                <div class="form-actions">
                    <input type="submit" name="submit" class="btn btn-success" value="Add File">
                  </div>

            <?php } ?>
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