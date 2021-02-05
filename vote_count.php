<?php
include("./inc/db.php");
$msg='';
if($_GET['id']){
  $candidate_id=$_GET['id'];
}
if(isset($_GET['voter_id'])){
  $voter_id=$_GET['voter_id'];
}
echo $candidate_id."  ".$voter_id;
$sql='SELECT * FROM vote WHERE voter_id='.$voter_id;
$result=mysqli_query($conn,$sql);
if($result){
  $count=mysqli_num_rows($result);
  if($count>0){
    header('location:voting_section.php');
  }else{
    $query="INSERT INTO vote(voter_id,candidate_id) VALUES('$voter_id','$candidate_id')";
    mysqli_query($conn,$query);
    $msg="you have successfully casted your vote";
    header('location:voting_section.php?msg='.$msg);
  }
} 

?>