<?php 
    include("./inc/db.php");
    session_start();

    // Admin profile
    if(isset($_POST['logout'])){
        header('location:logout.php');
    }

    if(!empty($_SESSION['adminEmail'])){
        echo $_SESSION['adminEmail'];
        $sql='SELECT FROM admins WHERE email='.$_SESSION['adminEmail'];
        $result=mysqli_query($conn,$sql);
        if($result){
            echo "hello";
            $row=mysqli_fetch_assoc($result);
            var_dump($row);
            $displayName=$row['name'];
            $displayPosition=$row['position'];
            echo $displayName;
        }
    }


    // Form submit
    if(isset($_POST['submit'])){
        $name=htmlspecialchars($_POST['name']);
        $state=htmlspecialchars($_POST['state']);
        $municipality=htmlspecialchars($_POST['municipality']);
        $citizenship_id_number=htmlspecialchars($_POST['citizenship_id_number']);

        $profilePicture=$_FILES['profile_picture'];
        $citizenship_copy=$_FILES['citizenship_id'];



    }
?>

<?php  include('./inc/header.php'); ?>

<section id="admin-header-section" style="background:#333;height:150px;" >
    <div class="container-fluid d-flex justify-content-around h-100">
        <div class="profile-img col-md-3 col-sm-12">
            <img src="<?php echo $profilePicture;  ?>" alt="Profile Picture">
        </div>
        <div class="profile-info col-md-3 col-sm-12  ">
            <ul class="list-group">
                <li class="list-group-item"> Name:<?php if(isset($displayName)) echo $displayName;  ?></li>
                <li class="list-group-item"> Position:<?php echo $displayPosition;  ?></li>
                <li class="list-group-item"> Professional id:<br><img src="<?php echo $citizenship_copy;  ?>" alt="professional id"></li>
            </ul>        
        </div>
        <div class="navigator d-flex h-100 align-items-center flex-column">
            <a href="logout.php" class="btn btn-primary my-1 justify-content-center align-items-center w-100" name="logout">Logout</a>    
            <button type="button" class="btn btn-primary my-1" data-toggle="modal" data-target="#candidate-register">Register Admin</button>
        </div>
    </div>
</section>



<!-- Modal part begins here -->

<div class="modal fade" id="candidate-register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title mx-auto " id="exampleModalLabel">CANDIDATE REGISTRATION</h3>
        </div>
        <div class="modal-body">
            <form class="register-voter mx-auto" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

                <?php if(!empty($msg)) : ?>
                    <div class="alert-danger mb-3"><?php echo $msg; ?></div>
                <?php endif;  ?>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" required value="<?php echo isset($_POST['name']) ? $fullName : ""; ?>" >
                </div>
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" class="form-control"required value="<?php echo isset($_POST['state']) ? $state : ""; ?>" >
                </div>
                <div class="form-group">
                    <label for="municipality">Municipality</label>
                    <input type="text" name="municipality" id="municipality" class="form-control" required value="<?php echo isset($_POST['municipality']) ? $municipality : ""; ?>" >
                </div>
                <div class="form-group">
                    <label for="citizenship">Citizenship ID number</label>
                    <input type="text" name="citizenship_id" id="citizenship_id_number" class="form-control" required value="<?php echo isset($_POST['citizenship_id']) ? $citizenship_id : ""; ?> " >
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Upload a passport sized photo </label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="profile_picture" required value="<?php echo isset($_POST['citizenship_copy']) ? $citizenship_copy : ""; ?> " >
                </div> 
                <div class="form-group">
                    <label for="exampleFormControlFile1">Upload a copy of citizenship ID </label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="citizenship_id" required value="<?php echo isset($_POST['citizenship_copy']) ? $citizenship_copy : ""; ?> " >
                </div> 

                <button type="submit" class="btn btn-primary" name="submit">Register</button>  
            </form>    
        </div>
    </div>
  </div>
</div>

<!-- Modal part ends here -->




<?php  include('./inc/footer.php'); ?> 
