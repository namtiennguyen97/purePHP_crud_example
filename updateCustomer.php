<?php
$conn = mysqli_connect('localhost','root','','code_thuan');
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$query = "UPDATE customers SET name='".$name."', phone='".$phone."', email='".$email."' WHERE id=".$id;
mysqli_query($conn,$query);

$newData = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone
];

echo json_encode($newData);
