<?php 
    include("./inc/db.php");
    session_start();

    // Admin profile
    if(isset($_POST['logout'])){
        header('location:logout.php');
    }

    if(isset($_SESSION['adminEmail'])){
        $adminEmail=$_SESSION['adminEmail'];
        // echo $adminEmail;
    }else{
        header('location:logout.php');
    }

    $sql="SELECT * FROM admins WHERE email='$adminEmail' ";
    $queryResult=mysqli_query($conn,$sql);
    if($queryResult){
        $row=mysqli_fetch_assoc($queryResult);
        // var_dump($row);
        $displayName=$row['name'];
        $displayPosition=$row['position'];
        $profile_img=$row['profile'];
    }
    else{
        echo 'no result';
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
<?php  include('./inc/navbar.php'); ?>

<section id="admin-header-section" >
    <div class="container d-flex py-4 justify-content-center align-items-center">
        <div class="profile-img">
            <img src="<?php echo $profile_img;  ?>" class='img-fluid' alt="Profile Picture">
        </div>
        <div class="description">
            <h3>Name:<?php if(isset($displayName)) echo $displayName;  ?></h3>
            <h3>Position:<?php echo $displayPosition;  ?></h3>     
        </div>
        <div class="add-link ml-auto">
            <a href="candidate_register.php?name=<?php echo $displayName ?>" class="btn btn-primary">Add a Candidate</a>
        </div>
    </div>
</section>

<section id="showcase-section">
    <div class="container">
        <div class="row">
            <?php 
                $sql='SELECT * FROM candidate ';
                $result=mysqli_query($conn,$sql);
                if($result) : ?>
                    <?php while($row=mysqli_fetch_assoc($result)) : ?>
                        <div class="card">
                            <img src="<?php echo $row['profile_img']; ?>" alt="<?php echo $row['profile_img']; ?>" class="card-img-top">
                            <div class="card-body">
                                <div class="card-title"><?php echo $row['full_name']; ?></div>
                                <h3>Vote count: <span><?php 
                                    $query='SELECT * FROM vote WHERE candidate_id='.$row['id'];
                                    $queryResult=mysqli_query($conn,$query);
                                    if($queryResult){
                                        $voteCount=mysqli_num_rows($queryResult);
                                        echo $voteCount;
                                    }
                                ?></span></h3>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php endif; ?>
            <div class="col-md-3 col-sm-6 text-center">
                
            </div>
        </div>
    </div>
</section>

<?php  include('./inc/footer.php'); ?> 
