
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
<?php
$conn = mysqli_connect('localhost','root','','code_thuan');

?>

<?php
$query = 'SELECT * FROM customers';
$customerData = mysqli_query($conn,$query);
?>

<p align="center" style="font-weight: bold; font-size: 120%">Customer Manager</p>
<button class="btn btn-success" id="showCreateModal">Create <i class="fa fa-plus"></i></button>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Delete</th>
        <th>Update</th>
    </tr>
    </thead>
    <tbody id="appendData">
        <?php foreach ($customerData as $value): ?>
    <tr class="customer<?php echo $value['id']?>">
        <td><?php echo $value['name'] ?></td>
        <td><?php echo $value['phone'] ?></td>
        <td><?php echo $value['email'] ?></td>
        <td><a class="btn btn-danger deleteCustomer" onclick="deleteCustomer(<?php echo $value['id'] ?>)" id="<?php echo $value['id'] ?>"><i class="fa fa-trash"></i></a></td>
        <td><a class="btn btn-info updateCustomer"  id="<?php echo $value['id'] ?>"><i class="fa fa-user"></i></a></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>


<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="createForm">
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>ID:</td>
                            <td><input type="number" class="form-control" name="id" placeholder="Enter customer id/ unique...."></td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td><input type="text" class="form-control" name="name" placeholder="Enter customer name..."></td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td><input type="number" class="form-control" name="phone" placeholder="Enter customer phone..."></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" class="form-control" name="email" placeholder="Enter customer email..."></td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="submit" id="createData" class="btn btn-success">Create <i class="fa fa-plus"></i></button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateForm" method="post" >
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <td>ID:</td>
                            <td><input readonly id="idInput" class="form-control" name="id"></td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td><input type="text" id="nameInput" class="form-control" name="name" placeholder="Edit customer name..."></td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td><input type="number" id="phoneInput" class="form-control" name="phone" placeholder="Edit customer Phone..."></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" id="emailInput" class="form-control" name="email" placeholder="Edit customer Email..."></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="confirmUpdate" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="toastrSetup.js"></script>
<script>
    $('#showCreateModal').click(function () {
        $('#createModal').modal('show');
    });

    $('#createData').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: 'createCustomer.php',
                method: 'post',
                data: $('#createForm').serialize(),
                success: function (data) {
                   let newData = JSON.parse(data);
                    console.log(newData);
                   $('#appendData').append("<tr class='customer"+newData.id+"'>" +
                       "<td>"+newData.name+"</td>" +
                       "<td>"+newData.phone+"</td>" +
                       "<td>"+newData.email+"</td>" +
                       "<td><a class='btn btn-danger deleteCustomer' onclick='deleteCustomer("+newData.id+")' id='"+newData.id+"' ><i class='fa fa-trash'></i></a></td>"+
                       "<td><a class='btn btn-info updateCustomer' id='"+newData.id+"'><i class='fa fa-user'></i></a></td>"+
                       "</tr>");
                   $('#createModal').modal('hide');
                   toastr.success(newData.name + ' has been create!');
                },
                error: function (response) {
                    console.log(response);
                }

            });
    });
</script>
<script>
//delete customer
    function deleteCustomer(id){
        $.ajax({
            url: "deleteCustomer.php",
            method: 'post',
            cache: false,
            data:{id: id},
            success: function () {
                toastr.warning('Your data has been deleted!');
                $('.customer'+id).remove();
            }
        });
    };



</script>
<script>
    // func get data user before it updated!
    let id;
   $('#appendData').on('click','.updateCustomer', function () {
        id = $(this).attr('id');
       $('#updateModal').modal('show');
       $.ajax({
           url: 'getCustomer.php',
           method: 'post',
           data: {id: id},
           success: function (data) {
               let currentData = JSON.parse(data);
               console.log(currentData);
               $('#idInput').val(currentData.id);
               $('#nameInput').val(currentData.name);
               $('#emailInput').val(currentData.email);
               $('#phoneInput').val(currentData.phone);
           }
       });
   });



    //update form
    $('#confirmUpdate').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'updateCustomer.php',
            method: 'post',
            data: $('#updateForm').serialize(),
            success: function (data) {
                let newData = JSON.parse(data);
                console.log(newData);
                $('.customer'+id).replaceWith("<tr class='customer"+newData.id+"'>" +
                    "<td>"+newData.name+"</td>" +
                    "<td>"+newData.phone+"</td>" +
                    "<td>"+newData.email+"</td>" +
                    "<td><a class='btn btn-danger deleteCustomer' onclick='deleteCustomer("+newData.id+")' id='"+newData.id+"' ><i class='fa fa-trash'></i></a></td>"+
                    "<td><a class='btn btn-info updateCustomer' id='"+newData.id+"'><i class='fa fa-user'></i></a></td>"+
                    "</tr>");
                toastr.success('Your data has been changed!');
            }
        });
    });


</script>
</body>
</html>




