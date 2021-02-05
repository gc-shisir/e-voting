<?php
    include("./inc/db.php");
    $msg='';

    if(isset($_POST['submit'])){
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $fullName=mysqli_real_escape_string($conn,$_POST['name']);
        $state=mysqli_real_escape_string($conn,$_POST['state']);
        $municipality=mysqli_real_escape_string($conn,$_POST['municipality']);
        $ward=mysqli_real_escape_string($conn,$_POST['ward']);
        $citizenship_id=mysqli_real_escape_string($conn,$_POST['citizenship_id']);
        $password=mysqli_real_escape_string($conn,$_POST['password1']);
        $confirmPassword=mysqli_real_escape_string($conn,$_POST['password2']);

        $profile_img=($_FILES['profile_img']);
        $citizenship_copy=($_FILES['citizenship_copy']);
        // var_dump($citizenship_copy);

        // uploading profile image
        $profileName=$profile_img['name'];
        $profileTempName=$profile_img['tmp_name'];

        $profileExt=explode('.',$profileName);
        $proExtCheck=strtolower(end($profileExt));

        $proExtList=array('jpg','jpeg','png');

        if(in_array($proExtCheck,$proExtList)){
            $profileDestFile='uploads/voters/'.$profileName;
            // print_r($destFile);
            move_uploaded_file($profileTempName,$profileDestFile);
        }

        // uploading citizenship copy
        $fileName=$citizenship_copy['name'];
        $fileTempName=$citizenship_copy['tmp_name'];

        $fileExt=explode('.',$fileName);
        $extCheck=strtolower(end($fileExt));

        $extList=array('jpg','jpeg','png');

        if(in_array($extCheck,$extList)){
            $destFile='uploads/voters/'.$fileName;
            // print_r($destFile);
            move_uploaded_file($fileTempName,$destFile);
        }
       
        if(strlen($password)<6 || strlen($confirmPassword)<6){
            $msg="password too short"; 
        }else if($password!=$confirmPassword){
            $msg="password didnot match";
        }else{
            // Checking if email is already registered
            $sql="SELECT * FROM voter WHERE email='$email' ";            
            $rslt=mysqli_query($conn,$sql);
            if($rslt){
                $rowCount=mysqli_num_rows($rslt);
                echo $rowCount;
                if($rowCount>0){
                    $msg="Email already registered";
                }else{
                    $query="INSERT INTO voter(email,full_name,state,municipality,ward,citizenship_id,citizenship_copy,password1,password2)
                                VALUES('$email','$fullName','$state','$municipality','$ward','$citizenship_id','$destFile','$password','$confirmPassword') ";
                
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



<?php include("./inc/header.php"); ?>

<div id="showcase-body" class="w-100 d-flex justify-content-center ">
    <div class="showcase-body-title">
        <h2 class="text-white text-center mt-4 pt-2">VOTER REGISTRATION</h2>
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
            <label for="state">State</label>
            <input type="text" name="state" id="state" class="form-control"required value="<?php echo isset($_POST['state']) ? $state : ""; ?>" >
        </div>
        <div class="form-group">
            <label for="municipality">Municipality</label>
            <input type="text" name="municipality" id="municipality" class="form-control" required value="<?php echo isset($_POST['municipality']) ? $municipality : ""; ?>" >
        </div>
        <div class="form-group">
            <label for="ward">Ward Number</label>
            <input type="number" name="ward" id="ward" class="form-control" required value="<?php echo isset($_POST['ward']) ? $ward : ""; ?> " >
        </div>
        <div class="form-group">
            <label for="citizenship">Citizenship ID number</label>
            <input type="text" name="citizenship_id" id="citizenship_id" class="form-control" required value="<?php echo isset($_POST['citizenship_id']) ? $citizenship_id : ""; ?> " >
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Upload a Passport sized photo </label>
            <input type="file" class="form-control-file" id="exampleFormControlFile" name="profile_img" required value="<?php echo isset($_POST['profile_img']) ? $citizenship_copy : ""; ?> " >
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Upload a copy of Citizenship certificate </label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="citizenship_copy" required value="<?php echo isset($_POST['citizenship_copy']) ? $citizenship_copy : ""; ?> " >
        </div>
        <div class="form-group"> 
            <label for="password">Password</label>
            <input type="password" name="password1" id="password1" class="form-control"  required  >
        </div>
        <div class="form-group">
            <label for="password">Confirm Password</label>
            <input type="password" name="password2" id="password2" class="form-control"  required  >
        </div>
        <button type="submit" class="btn btn-primary w-100 registerVoter" name="submit" >Register</button>
        
    </form>    
</div>

<?php
    include("./inc/footer.php");

?>

