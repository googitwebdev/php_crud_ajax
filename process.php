<?php 
include "config.php";


if (isset($_GET['get_users'])) {
    $sql = "SELECT * FROM users";
    //execute the query
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //output data of each row
        while ($row = $result->fetch_assoc()) {
    ?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
        <td><?php echo $row['email']; ?></td>
	<td><?php echo $row['age']; ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><button class="btn btn-info" onclick="edit_record(<?php echo $row['id']; ?>)" >Edit</button>&nbsp;<button class="btn btn-danger"  onclick="delete_record(<?php echo $row['id']; ?>)" >Delete</button></td>
    </tr>   
                
    <?php
        }
    }
}
    
if (isset($_POST['firstname'])) {
    $firstname    = $_POST['firstname'];
    $user_id      = $_POST['user_id'];
    $lastname     = $_POST['lastname'];
    $email        = $_POST['email'];
    $age          = $_POST['age'];
    $gender       = $_POST['gender'];
    if ($user_id == '') {
        $sql = "INSERT INTO `users`(`firstname`, `lastname`, `email`, `age`, `gender`) VALUES ('$firstname','$lastname','$email','$age','$gender')";
        $message = "Record created successfully.";
    }else{
        // write the update query
        $sql = "UPDATE `users` SET `firstname`='$firstname',`lastname`='$lastname',`email`='$email',`age`='$age',`gender`='$gender' WHERE `id`='$user_id'";
        $message = "Record upated successfully.";
    }
    // execute the query
    $result = $conn->query($sql);

    if ($result) {
        $response = array('status' => true, 'message' => $message);
    }else{
        $response = array('status' => false, 'message' => $conn->error);
    }

    echo json_encode($response);exit();
}

if (isset($_GET['delete_id'])) {
	$user_id = $_GET['delete_id'];

	// write delete query
	$sql = "DELETE FROM `users` WHERE `id`='$user_id'";

	// Execute the query

	$result = $conn->query($sql);

	if ($result) {
        $result = array('status' => true, 'message' => 'Record deleted successfully.');
	}else{
        $result = array('status' => true, 'message' => $conn->error);
	}

    echo json_encode($result);exit();
}

if (isset($_GET['edit_id'])) {
	$user_id = $_GET['edit_id'];

	// write SQL to get user data
	$sql = "SELECT * FROM `users` WHERE `id`='$user_id'";

	//Execute the sql
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$response = array('status' => true, 'data' => $row);
	}else{
		$response = array('status' => false, 'data' => $conn->error);
	}
	echo json_encode($response);exit();
} 

?>
