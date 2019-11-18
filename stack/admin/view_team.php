<?php include('header.php');  ?>

<?php
  ob_start();
  $conn = mysqli_connect("localhost", "root", "", "stack");

  if(isset($_REQUEST['search'])){
    $val = $_REQUEST['search'];

    $q = "SELECT * FROM team where title LIKE '%$val%' OR name LIKE '%$val%' OR role LIKE '%$val%'";
  }
  else{
    $q = "SELECT * FROM team";
  }

  

  if(isset($_REQUEST['delete'])){

    if($_REQUEST['id']){

      $id = $_REQUEST['id'];

      $dq = "DELETE FROM team WHERE id=$id";

      if(mysqli_query($conn, $dq)){
        header('location: view_team.php');
        $del_msg = "<div class='alert alert-warning alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong>Warning!</strong> Better check yourself, you're not looking too good.
      </div>";
      }
    }
  }

?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Team</a> </div>
    <h1>View Team</h1>

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
            <h5>All Team</h5>
            <form class="form-horizontal" method='GET'>
              <input type="search" name="search" placeholder="Search team">
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
                  <th>Role</th>
                  <th>Pic-Path</th>
                  <th>Pic</th>
                  <th colspan=2>Modify</th>
                </tr>
              </thead>
              <tbody>

              <?php 
              
             
              if($res = mysqli_query($conn, $q)){

                if(mysqli_num_rows($res) > 0){
           
                while($fres = mysqli_fetch_assoc($res)){

                  $id = $fres['id'];
            
                  echo "<tr>
                  <td><input type='checkbox' /></td>
                  <td><div class='text-center'>${fres['id']}</div></td>                  
                  <td><div class='text-center'>${fres['name']}</div></td>                  
                  <td><div class='text-center'>${fres['role']}</div></td>                  
                  <td><div class='text-center'>${fres['pic']}</div></td>  
                  <td><div class='text-center'><img class='img-circle' src='${fres['pic']}' height='100px' width='100px' /></div></td>
                  <td>
                    <center>
                    <form method='POST' action='add_team.php?update_id=$id'>
                      <input type='submit' class='btn btn-primary' name='update' value='Update' />
                    </form>
                    </center>
                  </td>                
                  <td>
                    <center>
                    <form method='POST' action='view_team.php?id=$id'>
                      <input type='submit' class='btn btn-danger' name='delete' value='Delete' />
                    </form>
                    </center>
                  </td>              
                </tr>";
            
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
