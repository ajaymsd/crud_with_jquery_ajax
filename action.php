<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax_crud');

$action = $_POST['action'];

if ($action == 'Insert') {
    echo $action;
    $name = mysqli_real_escape_string($con, $_POST['uname']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $contact = mysqli_real_escape_string($con, $_POST['unumber']);

    $sql = "INSERT INTO userinfo (name, gender, contact) VALUES ('$name', '$gender', '$contact')";

    if ($con->query($sql)) {
        $id = $con->insert_id;
        echo "
        <tr uid='$id'>
          <td>$name</td>
          <td>$gender</td>
          <td>$contact</td>
          <td><a href='#' class='btn btn-primary edit'>Edit</a></td>
          <td><a href='#' class='btn btn-danger delete'>Delete</a></td>
        </tr>";
    } else {
        return false;
    }
} else if ($action == 'Update') {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $name = mysqli_real_escape_string($con, $_POST['uname']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $contact = mysqli_real_escape_string($con, $_POST['unumber']);

    $sql = "UPDATE userinfo SET name='$name', gender='$gender', contact='$contact' WHERE id='$id'";

    if ($con->query($sql)) {
        echo "
          <td>$name</td>
          <td>$gender</td>
          <td>$contact</td>
          <td><a href='#' class='btn btn-primary edit'>Edit</a></td>
          <td><a href='#' class='btn btn-danger delete'>Delete</a></td>
          ";
    } else {
        return false;
    }

    
}

else if($action=="Delete"){
      $id=$_POST['id'];
      $sql="delete from userinfo where id='$id' ";
      if ($con->query($sql)) {
         echo true;
      }else{
        echo false;
      }

}
?>
