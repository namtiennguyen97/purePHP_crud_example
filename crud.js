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
