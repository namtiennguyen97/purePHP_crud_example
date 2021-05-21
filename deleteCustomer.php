<?php
$conn = mysqli_connect('localhost','root','','code_thuan');

    $id = $_POST['id'];
    $deleteQuery = "DELETE FROM customers WHERE id=".$id;
    mysqli_query($conn,$deleteQuery);



