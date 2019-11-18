<?php include('header.php'); ?>

<?php
if (isset($_REQUEST['submit'])) {
    if (empty($_REQUEST['name']) || empty($_REQUEST['passwd']) || empty($_REQUEST['email']) || empty($_REQUEST['country']) || empty($_REQUEST['gender']) || empty($_REQUEST['languages']) || empty($_FILES['profile_pic']['name'])) {
        $err =  "Fill all fields...";
    } else {
        $conn = mysqli_connect("localhost", "root", "", "stack");
        if ($conn) {
            $name         = $_REQUEST['name'];
            $passwd       = $_REQUEST['passwd'];
            $email        = $_REQUEST['email'];
            $country      = $_REQUEST['country'];
            $gender       = $_REQUEST['gender'];
            $languages    = implode(", ", $_REQUEST['languages']);
            $profile_pic  = $_FILES['profile_pic']['name'];
            $suffix = "$name" . uniqid();
            $target = "profile_pic/" . pathinfo($profile_pic, PATHINFO_FILENAME) . $suffix . "." . pathinfo($profile_pic, PATHINFO_EXTENSION);
            if (isset($_REQUEST['id'])) {
                $id = $_REQUEST['id'];
                echo $q = "UPDATE admin SET name='$name', email='$email', country='$country', gender='$gender', languages='$languages', profile_pic='$target' WHERE id=$id";
            } else {
                echo $q = "INSERT INTO admin(name, password, email, country, gender, languages, profile_pic) VALUES('$name', '$passwd', '$email', '$country', '$gender', '$languages', '$target')";
            }
            if (mysqli_query($conn, $q)) {

                move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target);

                $success =  "<div class='alert alert-success alert-dismissible' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          <strong>Success!</strong> Data Inserted Successfully....
        </div>";
            }
        }
    }
}

if (isset($_REQUEST['id'])) {

    $conn = mysqli_connect("localhost", "root", "", "stack");
    $id = $_REQUEST['id'];

    $sq = "SELECT * FROM admin WHERE id=$id";


    if ($res = mysqli_query($conn, $sq)) {

        $row = mysqli_fetch_assoc($res);

        $name         = $row['name'];
        $passwd       = $row['password'];
        $email        = $row['email'];
        $country      = $row['country'];
        $gender       = $row['gender'];
        $lang         = explode(", ", $row['languages']);
        $profile_pic  = $row['profile_pic'];
    }
}
?>

<!--close-left-menu-stats-sidebar-->

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
                        <h5>Add Admin</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <?php echo @$success; ?>
                        <?php echo @$err; ?>
                        <?php echo @$id_msg; ?>
                        <?php echo @$idmetrix; ?>

                        <form action="add_admin.php" method="POST" enctype="multipart/form-data" class="form-horizontal">

                            <div class="control-group">
                                <label class="control-label">Name :</label>
                                <div class="controls">
                                    <input type="text" name="name" value="<?php if (@$id) {
                                                                                echo $name;
                                                                            } ?>" class="span11" placeholder="First name" />
                                </div>
                            </div>

                            <?php if (!@$id) { ?>
                                <div class="control-group">
                                    <label class="control-label">Password input</label>
                                    <div class="controls">
                                        <input type="password" name="passwd" class="span11" placeholder="Enter Password" />
                                    </div>
                                </div>
                            <?php } else {  ?>
                                <div class="">
                                    <input type="hidden" name="passwd" value="<?php if (@$id) {
                                                                                        echo $passwd;
                                                                                    } ?>" class="span11" placeholder="Enter Password" />
                                </div>
                            <?php } ?>

                            <div class="control-group">
                                <label class="control-label">Email:</label>
                                <div class="controls">
                                    <input type="email" name="email" value="<?php if (@$id) {
                                                                                echo $email;
                                                                            } ?>" class="span11" placeholder="Email Address" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Country</label>
                                <div class="controls">
                                    <select name="country">
                                        <option value="">----SELECT----</option>
                                        <option value="India" <?php if (@$id) {
                                                                    if ($country == 'India') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>India</option>
                                        <option value="China" <?php if (@$id) {
                                                                    if ($country == 'China') {
                                                                        echo 'selected';
                                                                    }
                                                                } ?>>China</option>
                                        <option value="USA" <?php if (@$id) {
                                                                if ($country == 'USA') {
                                                                    echo 'selected';
                                                                }
                                                            } ?>>USA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Gender</label>
                                <div class="controls">
                                    <label>
                                        <input type="radio" name="gender" value="Male" <?php if (@$id) {
                                                                                            if ($gender == 'Male') {
                                                                                                echo 'checked';
                                                                                            }
                                                                                        } ?> />
                                        Male</label>
                                    <label>
                                        <input type="radio" name="gender" value="Female" <?php if (@$id) {
                                                                                                if ($gender == 'Female') {
                                                                                                    echo 'checked';
                                                                                                }
                                                                                            } ?> />
                                        Female</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Known Languages</label>
                                <div class="controls">
                                    <label>
                                        <input type="checkbox" name="languages[]" value="English" <?php if (@$id) {
                                                                                                        if (in_array('English', $lang)) {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> />
                                        English</label>
                                    <label>
                                        <input type="checkbox" name="languages[]" value="Hindi" <?php if (@$id) {
                                                                                                    if (in_array('Hindi', $lang)) {
                                                                                                        echo 'checked';
                                                                                                    }
                                                                                                } ?> />
                                        Hindi</label>
                                    <label>
                                        <input type="checkbox" name="languages[]" value="Gujarati" <?php if (@$id) {
                                                                                                        if (in_array('Gujarati', $lang)) {
                                                                                                            echo 'checked';
                                                                                                        }
                                                                                                    } ?> />
                                        Gujarati</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">File upload input</label>
                                <div class="controls">
                                    <input type="file" name="profile_pic" />
                                    <?php if (@$id) { ?>

                                        <img src='<?php echo $profile_pic; ?>' class="img-circle" height='90px' width='90px' alt='pic' />
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" name="submit" class="btn btn-success" value="<?php if (@$id) {
                                                                                                        echo "Update Admin";
                                                                                                    } else {
                                                                                                        echo "Add Admin";
                                                                                                    } ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php') ?>