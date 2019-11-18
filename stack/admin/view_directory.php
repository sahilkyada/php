<?php include('header.php');  ?>

<?php
  ob_start();


  
 # header('location: view_admin.php');
?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Directory Handling</a> </div>
    <h1>View Directory</h1>

  </div>
  <div class="container-fluid">
    <hr>

    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon">
            
            <input type="checkbox" id="title-checkbox" name="title-checkbox" />
            </span>
            <h5>All Directories</h5>
            <form class="form-horizontal" method='GET'>
              <input type="search" name="search" placeholder="Search Directory">
              
              <input type="submit" class="btn btn-primary" name="submit" value="Search">
            </form>

          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th><i class="icon-resize-vertical"></i></th>
                  <th>No</th>
                  <th>Name</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>

              <?php 
                  if(isset($_REQUEST['submit'])){

                    $path = $_REQUEST['search'];
                    $res = scandir($path);

                  }

                  $flag = 0;

                  if(@$res[0] == '.' || @$res[1] == '..'){
                    $res = array_slice($res, 2, count($res), true);
                    $flag = 1;
                  }

                  if(@$path){
                  foreach($res as $k=>$v){                   
                  
                  ?><tr>
                  <td><input type='checkbox' /></td>
                  <td><div class='text-center'><?php if($flag){ echo $k-2; } else{ echo $k; } ?></div></td>                  
                  <td><div class='text-center'><?php echo $v; ?></div></td>                                
                  <td>
                    <center>
                      <input type='submit' class='btn btn-danger' name='delete' value='Delete' />
                    </form>
                    </center>
                  </td>              
                </tr>
                
                  <?php } } ?>                 
                
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
