<?php
    include("./inc/header.php");
    include("./inc/db.php");
    session_start();

    if(isset($_POST['submit'])){
        header('location:logout.php');
    }else if($_SESSION['email']!=''){
        $sessionEmail=$_SESSION['email'];
        // echo $sessionEmail;
    }else{
        header('location:index.php');
    }

    
    
    $query="SELECT * FROM voter WHERE email='$sessionEmail' ";
    $result=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($result);

    $name=$row['full_name'];
    $municipality=$row['municipality'];
    $state=$row['state'];
    $ward=$row['ward'];
    $citizenship_id=$row['citizenship_id'];
    
    
?>

<section id="header-section">
    <div class="container-fluid">
        
    </div>
</section>

<section class="header">
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <img src="<?php echo $profile;  ?> " class="img img-fluid profile" alt="Profile Picture">
            </div>
            <div class="col-md-6 col-sm-12">
                <ul class="list-group">
                    <li class="list-group-item">Name:<?php echo $name; ?></li>
                    <li class="list-group-item">State:<?php echo $state; ?></li>
                    <li class="list-group-item">Municipality:<?php echo $municipality; ?></li>
                    <li class="list-group-item">Ward:<?php echo $ward; ?></li>
                    <li class="list-group-item">Citizenship ID:<?php echo $citizenship_id; ?></li>
                </ul>
                <form method="post">
                    <button type="submit" class="btn btn-primary w-100 my-3" name="submit">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</section>







<?php
    include("./inc/footer.php");
?>
