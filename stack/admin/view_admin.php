<?php include('header.php');  ?>

<?php
  ob_start();
  session_start(); 

  $conn = mysqli_connect("localhost", "root", "", "stack");

  if(isset($_REQUEST['search'])){
    $val = $_REQUEST['search'];

    $q = "SELECT * FROM admin where name LIKE '%$val%' OR email LIKE '%$val%'";
  }
  else{
    $q = "SELECT * FROM admin";
  }

  

  if(isset($_REQUEST['delete'])){

    if($_REQUEST['id']){

      $id = $_REQUEST['id'];

      $dq = "DELETE FROM admin WHERE id=$id";

      if(mysqli_query($conn, $dq)){
        header('location: view_admin.php');
        $del_msg = "<div class='alert alert-warning alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>Warning!</strong> Better check yourself, you're not looking too good.
      </div>";
      }
    }
  }

  if(!isset($_SESSION['id'])){
    header('location: index.php');
}else{
    $sid = isset($_SESSION['id']);

    $sq = "SELECT * FROM admin WHERE id=$sid";

    $conn = mysqli_connect("localhost", "root", "", "stack");

    if ($conn) {

      $res = mysqli_query($conn, $sq);
      $row = mysqli_fetch_assoc($res);

    } 

}

?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Admin</a> </div>
    <h1>View Admin</h1>

  </div>
  <div class="container-fluid">
    <hr>

    <?php 
    
        echo @$del_msg;
    
    ?>

    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon">
            
            <input type="checkbox" id="title-checkbox" name="title-checkbox" />
            </span>
            <h5>All Admins</h5>
            <form class="form-horizontal" method='GET'>
              <input type="search" name="search" placeholder="Search Admins">
              <input type="submit" class="btn btn-primary" name="submit" value="Search">
            </form>

          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th><i class="icon-resize-vertical"></i></th>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Country</th>
                  <th>Gender</th>
                  <th>Languages</th>
                  <th>Profile Pic</th>
                  <?php if($row['role']=='admin'){ ?><th colspan=2>Modify</th><?php } ?>
                </tr>
              </thead>
              <tbody>

             
              <?php 
              
             
              if($res = mysqli_query($conn, $q)){

                if(mysqli_num_rows($res) > 0){
           
                while($fres = mysqli_fetch_assoc($res)){

                  $id = $fres['id'];
            ?>
                  <tr>
                  <td><input type='checkbox' /></td>
                  <td><div class='text-center'><?php echo $fres['id']; ?></div></td>                  
                  <td><div class='text-center'><?php echo $fres['name']; ?></div></td>                  
                  <td><div class='text-center'><?php echo $fres['email']; ?></div></td>                  
                  <td><div class='text-center'><?php echo $fres['country']; ?></div></td>                  
                  <td><div class='text-center'><?php echo $fres['gender']; ?></div></td>                  
                  <td><div class='text-center'><?php echo $fres['languages']; ?></div></td>                  
                  <td><div class='text-center'><img class='img-circle' src='<?php echo $fres['profile_pic']; ?>' height='100px' width='100px' /></div></td>            
                 
                  <?php if($row['role']=='admin'){ ?>
                  <td>
                    <center>
                    <form method='POST' action='add_admin.php?update_id=<?php echo $id; ?>'>
                      <input type='submit' class='btn btn-primary' name='update' value='Update' />
                    </form>
                    </center>
                  </td>                
                  <td>
                    <center>
                    <form method='POST' action='view_admin.php?id=<?php echo $id; ?>'>
                      <input type='submit' class='btn btn-danger' name='delete' value='Delete' />
                    </form>
                    </center>
                  </td>      
                  <?php } ?>  

                </tr>
                
            <?php
                }
              }
            
              }
              else{
                echo "No records found...";
              }
              
              ?>     
                
              </tbody>
            </table>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

<?php

  

?>

<?php include('footer.php'); ?>
