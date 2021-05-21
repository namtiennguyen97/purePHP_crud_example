<?php
$conn = mysqli_connect('localhost','root','','code_thuan');
$search = $_POST['search'];
if ($_POST['search']){
    $query = "SELECT * FROM customers WHERE name LIKE '%".$search."%'";
    mysqli_query($conn,$query);
    $result = mysqli_query($conn,$query);
    $html = '';
    if (is_array($result) || is_object($result)){
        foreach ($result as $key => $value){
            $html .= "<tr class='customer".$value['id']."'>
        <td>".$value['name']."</td>
         <td>".$value['phone']."</td>
          <td>".$value['email']."</td>
          <td><a class='btn btn-danger deleteCustomer' id='".$value['id']."'><i class='fa fa-trash'></i></a></td>
          <td><a class='btn btn-info updateCustomer' id='".$value['id']."'><i class='fa fa-info'></i></a></td>
</tr>";
        }
    }

    $dataArr = [
      'data' => $html
    ];

    echo json_encode($dataArr);
} else{
    $query = "SELECT * FROM customers ";
    mysqli_query($conn,$query);
    $result = mysqli_query($conn,$query);
    $html = '';
    if (is_array($result) || is_object($result)){
        foreach ($result as $key => $value){
            $html .= "<tr class='customer".$value['id']."'>
        <td>".$value['name']."</td>
         <td>".$value['phone']."</td>
          <td>".$value['email']."</td>
          <td><a class='btn btn-danger deleteCustomer' id='".$value['id']."'><i class='fa fa-trash'></i></a></td>
          <td><a class='btn btn-info updateCustomer' id='".$value['id']."'><i class='fa fa-info'></i></a></td>
</tr>";
        }
    }

    $dataArr = [
        'data' => $html
    ];

    echo json_encode($dataArr);
}

