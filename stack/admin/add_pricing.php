<?php include('header.php');

if (isset($_REQUEST['submit'])) {
  if (empty($_REQUEST['plan']) ||  empty($_REQUEST['description']) || empty($_REQUEST['price']))  {
    $empty = "<div class='alert alert-warning alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Warning!</strong> PLEASE ENTER ALL FIELDS COMPLETELY. 
  </div>";
  } else {

    $conn = mysqli_connect("localhost", "root", "", "stack");
    if ($conn) {
      $plan = $_REQUEST['plan'];
      $price = $_REQUEST['price'];
      $description = $_REQUEST['description'];
      
      if(isset($_REQUEST['update_id'])){
        $id = $_REQUEST['update_id'];
        $success_id = "<div class='alert alert-warning alert-dismissible' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          <strong>ID=$id!</strong> ID mali gai.... 
          </div>";
        $q = "UPDATE pricing SET plan='$plan', description='$description', price='$price' WHERE id=$id";
      }
      else{
        $q = "INSERT INTO pricing(plan, price, description) VALUES('$plan','$price','$description')";
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
  $sq = "SELECT * FROM pricing WHERE id=$id";
  $res = mysqli_query($conn, $sq);

  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $plan = $row['plan'];
    $price = $row['price'];
    $description = $row['description'];
  }
}
?>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Pricing</a> <a href="#" class="current">Add Pricing Plan</a> </div>
    <h1>Add Pricing Plan</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Add Pricing Plan</h5>

          </div>
          <?php echo @$empty; ?>
          <?php echo @$sucsess; ?>
          <?php echo @$sucsess_id; ?>

          <div class="widget-content nopadding">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
              <div class="control-group">
                <label class="control-label">Plan: </label>
                <div class="controls">
                  <input type="text" name="plan" value="<?php if(isset($id)){ echo $plan; } ?>" class="span11" placeholder="Plan" />
                </div>
              </div>

              
              <div class="control-group">
                  <label class="control-label">Price: </label>
                  <div class="controls">
                      <input type="text" name="price" value="<?php if(isset($id)){ echo $price; } ?>" class="span11" placeholder="Price" />
                    </div>
                </div>            
                
                <div class="control-group">
                    <label class="control-label">Description: </label>
                    <div class="controls">
                    <input type="text" name="description" value="<?php if(isset($id)){ echo $description; } ?>" class="span11" placeholder="Description" />
                    </div>
                </div>

                <div class="form-actions">
                <input type="submit" name="submit" class="btn btn-success" value="<?php if(isset($id)){ echo "Update Plan"; } else{ echo "Add Plan"; } ?>">
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