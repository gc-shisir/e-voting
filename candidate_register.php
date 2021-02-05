<?php 
  session_start();
  $displayName=$_GET['name'];
?>

<?php 

    include('inc/db.php');
    if(isset($_POST['submit'])){
        $fullName=$_POST['name'];
        $position=$_POST['position'];
        $municipality=$_POST['municipality'];
        $state=$_POST['state'];
        $profile=$_FILES['profile_img'];
        $citizenship_id=$_POST['citizenship_id'];
        $citizenship_copy=$_FILES['citizenship_copy'];

        $extList=array('jpg','png','jpeg');

        // var_dump($profile);
        $profileFileName=$profile['name'];
        $profileTempName=$profile['tmp_name'];
        $fileProfileCheck=explode('.',$profileFileName);
        $profileFileExt=strtolower(end($fileProfileCheck));

        if(in_array($profileFileExt,$extList));
        {
            $profileFileDest='uploads/candidates/'.$profileFileName;
            move_uploaded_file($profileTempName,$profileFileDest);
        }
        
        $idFileName=$citizenship_copy['name'];
        $idTempName=$citizenship_copy['tmp_name'];
        $idFileCheck=explode('.',$idFileName);
        $idFileExt=strtolower(end($idFileCheck));

        if(in_array($idFileExt,$extList));
        {
            $idFileDest='uploads/candidates/'.$idFileName;
            move_uploaded_file($idTempName,$idFileDest);
        }

      // Checking if email is already registered
      $sql="SELECT * FROM candidate WHERE citizenship_id='$citizenship_id' ";            
      $rslt=mysqli_query($conn,$sql);
      echo "result in progress";
      if($rslt){
          $rowCount=mysqli_num_rows($rslt);
          if($rowCount>0){
              $msg="Email already registered";
          }else{
              $query="INSERT INTO candidate(full_name,position,state,municipality,citizenship_id,citizenship_copy,profile_img)
                          VALUES('$fullName','$position','$municipality','$state', '$citizenship_id','$idFileDest','$profileFileDest') ";
          
              $result=mysqli_query($conn,$query);
  
              if($result){
                  header("location:admin_dashboard.php" );
              }else{
                  $msg="obtained an error";
              }
          }

      }
      else{
          $msg="failed";
      }
    }

?>


<?php include('./inc/header.php') ?>
<?php include('./inc/navbar.php') ?>

<form class="register-voter mx-auto form w-50 my-5" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
  <?php if(!empty($msg)) : ?>
      <div class="alert-danger mb-3"><?php echo $msg; ?></div>
  <?php endif;  ?>
  <div class="form-group">
      <label for="name">Full Name</label>
      <input type="text" name="name" id="name" class="form-control" required value="<?php echo isset($_POST['name']) ? $fullName : ""; ?>" >
  </div>
  <div class="form-group">
      <label for="name">Position</label>
      <input type="text" name="position" id="position" class="form-control" required value="<?php echo isset($_POST['position']) ? $fullName : ""; ?>" >
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
      <input type="file" class="form-control-file" id="exampleFormControlFile1" name="profile_img" required value="<?php echo isset($_POST['citizenship_copy']) ? $citizenship_copy : ""; ?> " >
  </div> 
  <div class="form-group">
      <label for="exampleFormControlFile1">Upload a copy of citizenship ID </label>
      <input type="file" class="form-control-file" id="exampleFormControlFile1" name="citizenship_copy" required value="<?php echo isset($_POST['citizenship_copy']) ? $citizenship_copy : ""; ?> " >
  </div> 
  <button type="submit" class="btn btn-primary" name="submit">Register</button>  
</form>    

<?php include('./inc/footer.php') ?>