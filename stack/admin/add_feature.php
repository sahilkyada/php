<?php include('header.php');

if (isset($_REQUEST['submit'])) {
  if (empty($_REQUEST['title']) ||  empty($_REQUEST['description']) || empty($_REQUEST['icon']))  {
    $empty = "<div class='alert alert-warning alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Warning!</strong> PLEASE ENTER ALL FIELDS COMPLETELY. 
  </div>";
  } else {

    $conn = mysqli_connect("localhost", "root", "", "stack");
    if ($conn) {
      $title = $_REQUEST['title'];
      $description = $_REQUEST['description'];
      $icon = $_REQUEST['icon'];
      
      if(isset($_REQUEST['update_id'])){
        $id = $_REQUEST['update_id'];
        $success_id = "<div class='alert alert-warning alert-dismissible' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          <strong>ID=$id!</strong> ID mali gai.... 
          </div>";
        $q = "UPDATE features SET title='$title', description='$description', icon='$icon' WHERE id=$id";
      }
      else{
        $q = "INSERT INTO features(title, description, icon) VALUES('$title','$description','$icon')";
      }

      if (mysqli_query($conn, $q)) {
        $sucsess = "Your Data Inserted";
      }
    }
  }
}
?>

<?php
if (isset($_REQUEST['update_id'])) {
  $id = $_REQUEST['update_id'];
  $conn = mysqli_connect("localhost", "root", "", "stack");
  $sq = "SELECT * FROM features WHERE id=$id";
  $res = mysqli_query($conn, $sq);

  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $title = $row['title'];
    $description = $row['description'];
    $icon = $row['icon'];
  }
}
?>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Feature</a> <a href="#" class="current">Add Feature</a> </div>
    <h1>Add Feature</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Add Feature</h5>

          </div>
          <?php echo @$empty; ?>
          <?php echo @$sucsess; ?>
          <?php echo @$sucsess_id; ?>

          <div class="widget-content nopadding">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
              <div class="control-group">
                <label class="control-label">Title: </label>
                <div class="controls">
                  <input type="text" name="title" value="<?php if(isset($id)){ echo $title; } ?>" class="span11" placeholder="Title" />
                </div>
              </div>

             <div class="control-group">
                <label class="control-label">Description: </label>
                <div class="controls">
                  <input type="text" name="description" value="<?php if(isset($id)){ echo $description; } ?>" class="span11" placeholder="Description" />
                </div>
              </div>

             <div class="control-group">
                <label class="control-label">Icon: </label>
                <div class="controls">
                  <input type="text" name="icon" value="<?php if(isset($id)){ echo $icon; } ?>" class="span11" placeholder="Icon Class" />
                </div>
              </div>            

                <div class="form-actions">
                <input type="submit" name="submit" class="btn btn-success" value="<?php if(isset($id)){ echo "Update Feature"; } else{ echo "Add Feature"; } ?>">
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