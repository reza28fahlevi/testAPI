<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">

    <title>Employee Data</title>
  </head>
  <body>
    <h1 id="headers">Employee Data</h1>
    <button type="button" id="add" class="btn btn-sm btn-success float-right">Add +</button>
    <table id="employeeTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Departement</th>
                <th>Function</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalEmployee" tabindex="-1" role="dialog" aria-labelledby="modalEmployee" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="ModalTitle">Employee Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" name="form1" id="form1">
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="">
                <div class="form-group">
                    <label for="employee_name">Employee Name</label>
                    <input type="text" class="form-control" id="employee_name" name="employee_name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="employee_departement">Employee Departement</label>
                    <input type="text" class="form-control" id="employee_departement" name="employee_departement" placeholder="Departement">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
  </body>
</html>
<script>
    var dataTables = $('#employeeTable').DataTable( {
            ajax: {
                url: '<?php echo base_url('api/employees') ?>',
                type: 'GET',
                dataSrc: 'employees'
            },
            "columns": [
                { 
                    "target" : [0],
                    "data" : 'employee_name'
                },
                { 
                    "target" : [1],
                    "data" : 'employee_departement'
                },
                { 
                    "target" : [2],
                    "data" : 'id',
                    render: function (data) {
                        return "<button type='button' class='btn btn-sm btn-secondary mx-1' onClick='edit(this)' data-id='"+ data +"'>Edit</button><button type='button' class='btn btn-sm btn-danger mx-1' onClick='deleteEmployee(this)' data-id='"+ data +"'>Delete</button>";
                    }
                },
            ]
        });
    $(document).ready(function(){
        
        $("#add").click(function(){
            $('#form1')[0].reset();
            $('#modalEmployee').modal('show');
        })
        $('#form1').on('submit', function() {
            var employee_name = $('#employee_name').val();
            var employee_departement = $('#employee_departement').val();
            var id = $('#id').val();
            if(id!=""){
                var url = "<?php echo base_url('api/employees/');?>" + id
            }else{
                var url = "<?php echo base_url('api/employees/');?>"
            }
            $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        employee_name: employee_name,
                        employee_departement: employee_departement
                    },
                    success: function(response) {
                        var response = JSON.parse(response);
                        if(!response.error)
                        {
                            Swal.fire({
                                title: 'Success',
                                text: response.messages.success,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            })
                        }
                        else
                        {
                            alert('Server error');
                            return false;
                        }
                    }
                });
        });
        $("#headers").click(function(){
            Swal.fire({
                title: 'Error!',
                text: 'Do you want to continue',
                icon: 'error',
                confirmButtonText: 'Cool'
            })
        })
     
    })
    
    function edit(val){
            var id = $(val).attr("data-id");
            
            $('#form1')[0].reset();        
            $.ajax({
                type: "GET",
                url: '<?php echo base_url('api/employees/')?>' + id,
                data: {"data":"employee"},
                success: function(data){
                    console.log(data);
                    $('#id').val(data.id);
                    $('#employee_name').val(data.employee_name);
                    $('#employee_departement').val(data.employee_departement);
                }
            });
            $('#modalEmployee').modal('show');
        }

        function deleteEmployee(val){
            var id = $(val).attr("data-id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?php echo base_url('api/employees/')?>" + id,
                            type: 'DELETE',
                            success: function(result) {
                                if(result.messages.success){
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                    dataTables.ajax.reload();
                                }
                            }
                        });
                    }
                })
            
        }
</script>