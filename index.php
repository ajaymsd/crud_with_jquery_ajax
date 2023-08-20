<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>

<div class="modal" tabindex="-1" id="modal-form">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       <form class="form" id="user-form">
        <input type="hidden" name="action" id='action' value="Insert" />
        <input type="hidden" name="id" id='uid' value=0 />
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="uname" id="uname"class="form-control" required />
        </div>
        <div class="form-group mt-2">
        <label>Gender</label>
            <select name="gender" id="ugender"  required class="form-control">
               <option>Select</option>
               <option value="Male">Male</option>
               <option value="Female">Female</option>
               <option value="Others">Others</option>
            </select>
        </div>
        <div class="form-group mt-2">
            <label>Contact</label>
            <input type="number" name="unumber" id="unumber" class="form-control" required />
        </div>
        <input type="submit" class="btn btn-success mt-4"/>
       </form>

      </div>
    </div>
  </div>
</div>


    <div class="container mt-3">
       <p class="text-end"> <a href="#" class="btn btn-success" id="add-record">Add Record</a></p>
       <table class="table table-bordered container mt-5">
         <thead>
            <th>Name</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Action-Edit</th>
            <th>Action-Delete</th>
         </thead>
         <tbody id="tbody">

         <?php 
          $con=mysqli_connect('localhost','root','',"ajax_crud");
          $sql ="select * from userinfo";
          $res=$con->query($sql);
          while($row=$res->fetch_assoc()){
          ?>
          <tr uid="<?php echo $row['id'] ;?>">
            <td><?php echo $row['name'] ;?></td>
            <td><?php echo $row['gender'] ;?></td>
            <td><?php echo $row['contact'] ;?></td>
            <td> <a href="#" class="btn btn-primary edit" id="edit-record">Edit</a></td>
            <td><a href="#" class="btn btn-danger mx-2 delete" id="delete-record">Delete</a> </td>
          </tr>
          <?php }?>

         </tbody>
       </table>
    </div>
   
   
    <script>
        $(document).ready(function(){
          var current_row = null;
          $('#add-record').click(function(){
           $('#modal-form').modal('show');
          });

          $('#user-form').submit(function(event){
          event.preventDefault();
           $.ajax({
              url:'action.php',
              method:'POST',
              data:$('#user-form').serialize(),
              beforeSend:function(){
                $('#user-form').find('input[type="submit"]').val('Loading...');
              },
              success:function(response){
               if($("#uid").val()==0){
                $('#tbody').append(response);
               }else{
                $(current_row).html(response);
               }
                
                $('#user-form').find('input[type="submit"]').val('Submit');
               clear_input();
               $('#modal-form').modal('hide');
               },
              error:function(){
                alert("Error In sending Data");
              }
           });
          });

          $("body").on("click",'.edit',function(event){
            event.preventDefault();
            $('#modal-form').modal('show');
            current_row =$(this).closest('tr');
            var id=$(this).closest("tr").attr("uid");
            var name=$(this).closest("tr").find("td:eq(0)").text();
            var gender=$(this).closest("tr").find("td:eq(1)").text();
            var contact=$(this).closest("tr").find("td:eq(2)").text();
           
            $("#action").val("Update");
            $("#uid").val(id);
            $("#uname").val(name);
            $("#ugender").val(gender);
            $("#unumber").val(contact);
          });

          $("body").on("click",'.delete',function(event){
            event.preventDefault();
            var id=$(this).closest('tr').attr('uid');
            var cls=$(this);
            if(confirm("Are You Sure Want to delete this record No : "+id + "?")){
              $.ajax({
                url:'action.php',
                type:'post',
                data:{
                  id:id,
                  action:'Delete'
                },
                success:function(res){
                if(res){
                  $(cls).closest("tr").remove();
                }else{
                  alert("Failed TryAgain");
                  $(cls).text("Try Again");
                }
              }
              });
            }
          });

          function clear_input(){
            $("#user-form").find('.form-control').val("");
            $('#action').val('Insert');
            $('#uid').val('0');
          }
        });
    </script>
</body>
</html>