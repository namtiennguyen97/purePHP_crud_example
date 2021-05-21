<?php

$conn = mysqli_connect('localhost','root','','code_thuan');


    $a1 = $_POST['id'];
    $a2 = $_POST['name'];
    $a3 = $_POST['phone'];
    $a4 = $_POST['email'];
    $sql = "insert into customers value('$a1','$a2','$a3','$a4')";
    mysqli_query($conn, $sql);
    $dataArr = [
        'name' => $a2,
        'id' => $a1,
        'phone' => $a3,
        'email' => $a4
    ];

    echo json_encode($dataArr);



