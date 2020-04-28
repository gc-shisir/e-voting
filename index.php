<?php  
    include("./inc/db.php");
    session_start();
    // session_destroy();

    $msg='';
    if(isset($_POST['submit'])){
        $email=htmlspecialchars($_POST['email']);
        $password=htmlspecialchars($_POST['password']);

        if(empty($email) || empty($password)){
            $msg='Please enter all the credentials';
        }else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $msg="Please enter a valid email";
        }else{
            $query="SELECT * FROM voter where email='$email' ";
            $result=mysqli_query($conn,$query);

            if($result){
                while($row=mysqli_fetch_assoc($result)){
                    $dbEmail=$row['email'];
                    $dbPass=$row['password1'];
                    if($email==$dbEmail && $password==$dbPass){
                        session_start();
                        $_SESSION['email']=$dbEmail;
                        $_SESSION['pass']=$dbPass;
                        header('location:voting_section.php');
                    }else{
                        $msg='Email and password didnot match';
                    }
                }
            }else{
                $msg="Email is not registered";
            }    
        }       
    }
?>



<?php
    include("./inc/header.php");

?>

<!-- Main login body part begins here-->
<div id="main-body">
    <div class="main-body-title">
        <h2 class="text-white">E-VOTING SYSTEM</h2>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <h4 class="alert-danger"><?php echo $msg;  ?></h4>
        <div class="error"></div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" >
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Log in</button>
            <div class="registration-link">
                <h5 class="text-muted text-center">Not Registered?</h5>
                <button class="btn btn-primary" id="registerLink" name="registerLink" onclick="window.location.href='./voter-register.php' ">
                    Register a new voter
                </button>
            </div>
        </form>
        
    </div>
</div>

<!-- Main login body part ends here -->


<?php
    include("./inc/footer.php");

?>

    
