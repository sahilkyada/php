<?php include('header.php'); ?>

<?php 
  if(isset($_REQUEST['submit'])){
    if(empty($_REQUEST['name']) || empty($_REQUEST['passwd']) || empty($_REQUEST['email']) || empty($_REQUEST['country']) || empty($_REQUEST['gender']) || empty($_REQUEST['languages']) || empty($_FILES['file']['name'])){
      $msg = "<span class='container jumbotron text-warning'>Enter all values...</span>";
    }
    else{
      $conn = mysqli_connect("localhost", "root", "", "stack");
      if(!$conn){
        echo "not connected to db...";
      } 
      else{
        $name = $_REQUEST['name'];
        $passwd = md5($_REQUEST['passwd']);
        $email = $_REQUEST['email'];
        $country = $_REQUEST['country'];
        $gender = $_REQUEST['gender'];
        $languages = implode(",", $_REQUEST['languages']);
        $profile_pic = $_FILES['file']['name'];
        $profile_pic_path = $_FILES['file']['tmp_name'];
        $target = "profile_pic/" . pathinfo( $_FILES['file']['name'], PATHINFO_FILENAME);
        $suffix = uniqid();
        $target = $target . $suffix . "." . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if(isset($_REQUEST['id']))
        {
          $id = $_REQUEST['id'];
          
          echo $q = "UPDATE admin SET name='$name', email='$email', country='$country', gender='$gender', languages='$languages', profile_pic='$target' WHERE id=$id" ;
        }
        else
        {
          echo $q = "INSERT INTO admin(name, password, email, country, gender, languages, profile_pic) VALUES('$name', '$passwd', '$email', '$country', '$gender', '$languages', '$target')";
        }
        if(mysqli_query($conn, $q)){
          move_uploaded_file($profile_pic_path, $target);
          $msg = "<span class='container jumbotron text-success'>SUCCESS</span>";
        }
      }
    }
  }
  if(isset($_REQUEST['id'])){
    $conn = mysqli_connect("localhost", "root", "", "stack");
    $id = $_REQUEST['id'];
    $sq = "SELECT * FROM admin WHERE id=$id";
    if($res = mysqli_query($conn, $sq)){
        $row = mysqli_fetch_assoc($res);
        // $id         = $row['id'];
        $passwd     = $row['password'];
        $name       = $row['name'];
        $email      = $row['email'];
        $co         = $row['country'];
        $gender     = $row['gender'];
        $lang       = explode(',',$row['languages']);
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
          <h5>Admin</h5>
          <?php echo @$msg; ?>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Full Name</label>
              <div class="controls">
                <input type="text" name="name" value="<?php if( isset($id)) {  echo $name;}; ?>" class="span11" placeholder="Full name" />
              </div>
            </div>
            <?php if(!isset($_REQUEST['id'])) { ?>
              <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                  <input type="password" name="passwd" value="<?php if(isset($id)) {  echo $passwd; } ?>" class="span11" placeholder="Enter Password"  />
                </div>
              </div>
            <?php } else { ?>
              <div class="control-group">
                  <input type="hidden" name="passwd" value="<?php if(isset($id)) {  echo $passwd; } ?>" class="span11" placeholder="Enter Password"  />
              </div>
            <?php } ?>
            <div class="control-group">
              <label class="control-label">Email</label>
              <div class="controls">
                <input type="email" name="email" value="<?php if( isset($id)) {  echo $email; } ?>" class="span11" placeholder="Enter Email" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Country</label>
              <div class="controls">


              <?php $country = array("INDIA","USA","CHINA","RUSSIA","GERMANY"); ?>
                <select name="country" >
                  <option value="">---SELECT---</option>
                  <?php for($i=0;$i<sizeof($country);$i++) { ?>
                  <option value="<?php echo $country[$i]; ?>" <?php if( isset($id)) { if($co == $country[$i]) { echo "selected"; }}; ?>> <?php echo $country[$i]; ?></option>
                  <?php } ?>
<!--                   
                  <option value="USA"  <?php if( isset($id)) { if($country =='USA') { echo "selected"; }}; ?>>USA</option>
                  <option value="CHINA" <?php if( isset($id)) { if($country =='CHINA') { echo "selected"; }}; ?>>CHINA</option>
                  <option value="RUSSIA" <?php if( isset($id)) { if($country =='RUSSIA') { echo "selected"; }}; ?>>RUSSIA</option> -->
                </select>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Gender</label>
              <div class="controls">
                <label>
                  <input type="radio" name="gender" value="Male" <?php if(isset($id)) { if($gender=='Male') { echo "checked"; } }?> />
                  Male</label>
                <label>
                  <input type="radio" name="gender" value="Female" <?php if(isset($id)) { if($gender=='Female') { echo "checked"; } }?>  />
                  Female</label>
                <label>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Known Languages</label>
              <div class="controls">
                <label>
                  <input type="checkbox" name="languages[]" value="English" <?php if(isset($id)) { if(in_array('English',$lang)) {  echo "checked"; } }?> />
                  English</label>
                <label>
                  <input type="checkbox" name="languages[]" value="HINDI" <?php if(isset($id)) { if(in_array('HINDI',$lang)) {  echo "checked"; } }?>  />
                  Hindi</label>
                <label>
                  <input type="checkbox" name="languages[]" value="Gujarati"  <?php if(isset($id)) { if(in_array('Gujarati',$lang)) {  echo "checked"; } }?>  />
                  Gujarati</label>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">Profile Image</label>
              <div class="controls">
                <input type="file" name="file" />
                <?php if(isset($id)) { ?>
                  <img src="<?php echo $profile_pic; ?>" height="100px" width="100px" />
                <?php } ?>
              </div>
            </div>
            <div class="form-actions">
              <input type="submit" name="submit" class="btn btn-success" value="Add Admin" />
            </div>
          </form>
        </div>
      </div>
      
    </div>
    
  </div>
  
</div></div>

<?php include('footer.php'); ?>