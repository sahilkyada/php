<?php include('header.php');

if (isset($_REQUEST['submit'])) {
  if (empty($_REQUEST['name']) ||  empty($_REQUEST['passwd']) || empty($_REQUEST['email']) || empty($_REQUEST['country']) || empty($_REQUEST['gender']) || empty($_REQUEST['languages']) || empty($_FILES['profile_pic'])) {
    $empty = "<div class='alert alert-warning alert-dismissible' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
    <strong>Warning!</strong> PLEASE ENTER ALL FIELDS COMPLETELY. 
  </div>";
  } else {

    $conn = mysqli_connect("localhost", "root", "", "stack");
    if ($conn) {
      $name = $_REQUEST['name'];
      $passwd = $_REQUEST['passwd'];
      $email = $_REQUEST['email'];
      $country = $_REQUEST['country'];
      $gender = $_REQUEST['gender'];
      $languages = implode(",", $_REQUEST['languages']);
      $profile_pic = $_FILES['profile_pic']['name'];
      $file_tmp = $_FILES['profile_pic']['tmp_name'];
      $filepath = pathinfo($profile_pic, PATHINFO_FILENAME);
      $fileext = pathinfo($profile_pic, PATHINFO_EXTENSION);
      $suffix = uniqid($name,);
      $target = "profile_pic/" . "$suffix" . "$filepath" . "." . "$fileext";

      if(isset($_REQUEST['update_id'])){
        $id = $_REQUEST['update_id'];
        $success_id = "<div class='alert alert-warning alert-dismissible' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          <strong>ID=$id!</strong> ID mali gai.... 
          </div>";
        $q = "UPDATE admin SET name='$name', email='$email', country='$country', gender='$gender', languages='$languages', profile_pic='$target' WHERE id=$id";
      }
      else{
        $q = "INSERT INTO admin(name, password, email, country, gender, languages, profile_pic, role) VALUES('$name','$passwd','$email','$country','$gender','$languages','$target', 'user')";
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
  $sq = "SELECT * FROM admin WHERE id=$id";
  $res = mysqli_query($conn, $sq);

  if ($res) {
    $row = mysqli_fetch_assoc($res);
    $name = $row['name'];
    $email = $row['email'];
    $gender = $row['gender'];
    $country = $row['country'];
    $lang = explode(',', $row['languages']);
    $profile_pic = $row['profile_pic'];
  }
}
?>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="tip-bottom">Admin</a> <a href="#" class="current">Add Admin</a> </div>
    <h1>Add Admin</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span6">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Add admin</h5>

          </div>
          <?php echo @$empty; ?>
          <?php echo @$sucsess; ?>
          <?php echo @$sucsess_id; ?>

          <div class="widget-content nopadding">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data">
              <div class="control-group">
                <label class="control-label"> Name :</label>
                <div class="controls">
                  <input type="text" name="name" value="<?php if(isset($id)){ echo $name; } ?>" class="span11" placeholder="Name" />
                </div>
              </div>

              <?php if(isset($id)){  ?>
                  <input type="hidden" name="passwd" value="<?php if(isset($id)){ echo $passwd; } ?>" class="span11" placeholder="Enter Password" />
              <?php } else { ?>
                <div class="control-group">
                <label class="control-label">Password input</label>
                <div class="controls">
                  <input type="password" name="passwd" class="span11" placeholder="Enter Password" />
                </div>
              </div>
              <?php } ?>

              <div class="control-group">
                <label class="control-label">Email</label>
                <div class="controls">
                  <input type="email" name="email" value="<?php if(isset($id)){ echo $email; } ?>" class="span11" placeholder="Email" />
                </div>
              </div>

              <div class="widget-content nopadding">
                  <div class="control-group">
                    <label class="control-label">Country</label>
                    <div class="controls">
                      <select name="country">
                        <option value="">--select--</option>
                        <option value="INDIA" <?php if(isset($id)){ if($country=='INDIA'){ echo 'selected'; } }  ?> >INDIA</option>
                        <option value="USA" <?php if(isset($id)){ if($country=='USA'){ echo 'selected'; } } ?> >USA</option>
                        <option value="UAE" <?php if(isset($id)){ if($country=='UAE'){ echo 'selected'; } } ?> >UAE</option>
                        <option value="UK" <?php if(isset($id)){ if($country=='UK'){ echo 'selected'; } } ?> >UK</option>

                      </select>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label">Gender</label>
                    <div class="controls">
                      <label>
                        <input type="radio" name="gender" value="male" <?php if(isset($id)){ if($gender=='male'){ echo 'checked'; }} ?> />
                        Male</label>
                      <label>
                        <input type="radio" name="gender" value="female" <?php if(isset($id)){ if($gender=='female'){ echo 'checked'; }} ?> />
                        Female</label>

                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Known Languages</label>
                    <div class="controls">
                      <label>
                        <input type="checkbox" name="languages[]" value="english" <?php if(isset($id)){ if(in_array('english', $lang)){ echo 'checked'; }} ?> />
                        English</label>
                      <label>
                        <input type="checkbox" name="languages[]" value="hindi" <?php if(isset($id)){ if(in_array('hindi', $lang)){ echo 'checked'; }} ?> />
                        Hindi</label>
                      <label>
                        <input type="checkbox" name="languages[]" value="gujarati" <?php if(isset($id)){ if(in_array('gujarati', $lang)){ echo 'checked'; }} ?> />
                        Gujrati</label>
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label">File upload input</label>
                    <div class="controls">
                      <input type="file" name="profile_pic" />
                      <?php if(isset($id)) { ?>
                        <img class='img-circle' src="<?php echo $profile_pic; ?>" height="100px" width="100px" />
                      <?php } ?>
                    </div>
                  </div>

                  <div class="form-actions">
                    <input type="submit" name="submit" class="btn btn-success" value="<?php if(isset($id)){ echo "Update Admin"; } else{ echo "Add Admin"; } ?>">
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