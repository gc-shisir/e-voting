<?php
    include("./inc/header.php");
    include("./inc/db.php");
    session_start();

    $msg='';

    // Check for session
    if(isset($_POST['submit'])){
        header('location:logout.php');
    }else if($_SESSION['email']!=''){
        $sessionEmail=$_SESSION['email'];
        // echo $sessionEmail;
    }else{
        header('location:index.php');
    }
    
    // Grab user/voter details
    $query="SELECT * FROM voter WHERE email='$sessionEmail' ";
    $result=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($result);

    $name=$row['full_name'];
    $voter_id=(int)$row['id'];
    $municipality=$row['municipality'];
    $state=$row['state'];
    $ward=$row['ward'];
    $citizenship_id=$row['citizenship_id'];
    $profile=$row['profile'];
    // var_dump($voter_id);
    $displayName=$name;

    // Check voted or not
    $sql='SELECT * FROM vote WHERE voter_id='.$voter_id;
    $result=mysqli_query($conn,$sql);
    if($result){
        $count=mysqli_num_rows($result);
        if($count>0){
            $msg="you have already voted";
        }else{
            $msg='';
        }
    }
    
    // grab returned voted message
    if(isset($_GET['msg'])){
        $msg=$_GET['msg'];
    }
    
?>

<?php  include('./inc/header.php'); ?>
<?php  include('./inc/navbar.php'); ?>

<section id="admin-header-section" >
    <div class="container d-flex py-4  align-items-center">
        <div class="profile-img">
            <img src="<?php echo $profile;?>" class='img-fluid' alt="Profile Picture">
        </div>
        <div class="description">
            <h3>Name:<?php if(isset($name)) echo $name;  ?></h3>
            <h3>Citizenship ID number:<?php echo $citizenship_id;  ?></h3>     
        </div>
    </div>
</section>

<section id="showcase-section" class="bg-primary">
    <div class="container py-4">

    <?php if($msg=='') :?>
        <!-- display list of candidates -->
        <div class="row">
            <?php
                $sql='SELECT * FROM candidate';
                $candidateResult=mysqli_query($conn,$sql);
                // $row=mysqli_fetch_assoc($candidateResult);
                // var_dump($row);
                if($candidateResult): ?>
                    <?php while($row=mysqli_fetch_assoc($candidateResult)) : ?>
                        
                        <div class="col-md-2 col-sm-6 text-center mt-4">
                            <div class="card">
                                <img src="<?php echo $row['profile_img']; ?>" class="card-img-top img-fluid" alt="<?php echo $row['full_name']; ?>">
                                <div class="card-body">
                                  <h5 class="card-title"> <?php echo $row['full_name']; ?> </h5>
                                  <a href="vote_count.php?id=<?php echo (int)$row['id']; ?> & voter_id=<?php echo $voter_id; ?>" class="btn btn-primary w-100">Vote</a>
                                </div>
                            </div>
                        </div>
        
                    <?php endwhile; ?>
                <?php endif; ?>
               
            
        </div>
        
                    <?php else: ?>
                        <h2 class="text-center"><?php echo $msg; ?></h2>
                    <?php endif;?>

        
    </div>
</section>

<?php  include('./inc/footer.php'); ?> 
