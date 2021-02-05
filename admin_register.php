<?php 

    include('inc/db.php');
    if(isset($_POST['submit'])){
        $fullName=$_POST['name'];
        $email=$_POST['email'];
        $position=$_POST['position'];
        $password=$_POST['password1'];
        $confirmPassword=$_POST['password2'];

        $profile=$_FILES['profile_img'];
        $id=$_FILES['professional_id'];

        $extList=array('jpg','png','jpeg');

        // var_dump($profile);
        $profileFileName=$profile['name'];
        $profileTempName=$profile['tmp_name'];
        $fileProfileCheck=explode('.',$profileFileName);
        $profileFileExt=strtolower(end($fileProfileCheck));

        if(in_array($profileFileExt,$extList));
        {
            $profileFileDest='uploads/admin/'.$profileFileName;
            move_uploaded_file($profileTempName,$profileFileDest);
        }
        
        $idFileName=$id['name'];
        $idTempName=$id['tmp_name'];
        $idFileCheck=explode('.',$idFileName);
        $idFileExt=strtolower(end($idFileCheck));

        if(in_array($idFileExt,$extList));
        {
            $idFileDest='uploads/admin/'.$idFileName;
            move_uploaded_file($idTempName,$idFileDest);
        }

        if(strlen($password)<6 || strlen($confirmPassword)<6){
            $msg="password too short"; 
        }else if($password!=$confirmPassword){
            $msg="password didnot match";
        }else{
            // Checking if email is already registered
            $sql="SELECT * FROM admins WHERE email='$email' ";            
            $rslt=mysqli_query($conn,$sql);
            echo "result in progress";
            if($rslt){
                $rowCount=mysqli_num_rows($rslt);
                echo $rowCount;
                echo "result in progress";
                if($rowCount>0){
                    $msg="Email already registered";
                }else{
                    $query="INSERT INTO admins(name,email,position,profile,professional_id,password)
                                VALUES('$fullName','$email','$position','$profileFileDest','$idFileDest','$password') ";
                
                    $result=mysqli_query($conn,$query);
        
                    if($result){
                        header("location:index.php" );
                    }else{
                        $msg="obtained an error";
                    }
                }
    
            }
            else{
                $msg="failed";
            }

            
        }      

    }

?>




<?php include("./inc/header.php");  ?>


<div id="showcase-body" class="w-100 d-flex justify-content-center ">
    <div class="showcase-body-title">
        <h2 class="text-white text-center mt-4 pt-2">ADMIN REGISTRATION</h2>
    </div>
    
    <form class="register-voter mx-auto" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">

    <?php if(!empty($msg)) : ?>
        <div class="alert-danger mb-3"><?php echo $msg; ?></div>
    <?php endif;  ?>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?php echo isset($_POST['email']) ? $email : ""; ?>" >
        </div>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required value="<?php echo isset($_POST['name']) ? $fullName : ""; ?>" >
        </div>
        <div class="form-group">
            <label for="name">Position at election commission</label>
            <input type="text" name="position" id="name" class="form-control" required value="<?php echo isset($_POST['position']) ? $position : ""; ?>" >
        </div>
        <div class="form-group"> 
            <label for="password">Password</label>
            <input type="password" name="password1" id="password1" class="form-control"  required  >
        </div>
        <div class="form-group">
            <label for="password">Confirm Password</label>
            <input type="password" name="password2" id="password2" class="form-control"  required  >
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Upload a photo [passport sized] </label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="profile_img" required value="<?php echo isset($_POST['citizenship_copy']) ? $citizenship_copy : ""; ?> " >
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Upload a copy of your professional id </label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="professional_id" required value="<?php echo isset($_POST['citizenship_copy']) ? $citizenship_copy : ""; ?> " >
        </div>

        <button type="submit" class="btn btn-primary w-100 registerVoter" name="submit" >Register</button>

        <div class="registration-link">
            <h5 class="text-muted text-center my-3 ">Already Registered?</h5>
            <button class="btn btn-primary w-100" id="registerLink" name="loginLink" onclick="window.location.href='./admin_login.php' ">
                Login
            </button>
        </div>

        
    </form>    
</div>

<?php include("./inc/footer.php");  ?>