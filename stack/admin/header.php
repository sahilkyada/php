<?php 

  ob_start();

  session_start(); 

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

<!DOCTYPE html>
<html lang="en">
<head>
<title>Matrix Admin</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Matrix Admin</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome User</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
   
    
    <li class=""><a title="" href="logout.php"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->

<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li class="active"><a href="dashboard.php"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Admin</span></a>
      <ul>
        <?php if($row['role']=='admin'){ ?><li><a href="add_admin.php">Add Admin</a></li><?php } ?>
        <li><a href="view_admin.php">View Admin</a></li>
      </ul>
    </li>

    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>File Handling</span></a>
      <ul>
        <?php if($row['role']=='admin'){ ?><li><a href="add_file.php">Add File</a></li><?php } ?>
        <li><a href="view_file.php">View File</a></li>
      </ul>
    </li>
   
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Directory Handling</span></a>
      <ul>
        <?php if($row['role']=='admin'){ ?><li><a href="add_directory.php">Add Directory</a></li><?php } ?>
        <li><a href="view_directory.php">View Directory</a></li>
      </ul>
    </li>
   
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Features</span></a>
      <ul>
        <?php if($row['role']=='admin'){ ?><li><a href="add_feature.php">Add Feature</a></li><?php } ?>
        <li><a href="view_features.php">View Features</a></li>
      </ul>
    </li>
   
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Searvices</span></a>
      <ul>
        <?php if($row['role']=='admin'){ ?><li><a href="add_service.php">Add Service</a></li><?php } ?>
        <li><a href="view_services.php">View Services</a></li>
      </ul>
    </li>
   
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Team</span></a>
      <ul>
        <?php if($row['role']=='admin'){ ?><li><a href="add_team.php">Add Team Member</a></li><?php } ?>
        <li><a href="view_team.php">View Team</a></li>
      </ul>
    </li>
   
    <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Pricing</span></a>
      <ul>
        <?php if($row['role']=='admin'){ ?><li><a href="add_pricing.php">Add New Plan</a></li><?php } ?>
        <li><a href="view_pricing.php">View Plan</a></li>
      </ul>
    </li>
   
  </ul>
</div>
<!--sidebar-menu-->