<?php
$conn = mysqli_connect('localhost','root','','code_thuan');
$id = $_POST['id'];
$query = "SELECT * FROM customers WHERE id=".$id;

mysqli_query($conn,$query);
$result =  mysqli_query($conn,$query);
foreach ($result as $value){
    echo json_encode($value);
}


