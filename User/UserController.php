<?php
include '../Config/connecttodb.php';

if(isset($_POST['saveUser'])){
    $Username = $_POST['username'];
    $Password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing
    $Fname = $_POST['fname'];
    $Lname = $_POST['lname'];
    $Minitial = $_POST['minitial'];
    $Gender = $_POST['gender'];
    $Age = $_POST['age'];
    $Contact = $_POST['contact'];
    $Email = $_POST['email'];
    $Department = $_POST['department'];
    $Type =  $_POST['type'];
    // Use prepared statements
    $sql = "INSERT INTO user (Username, Password, Fname, Lname, Minitial, Gender, Age, Contact, Email, Department, Type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssissss", $Username, $Password, $Fname, $Lname, $Minitial, $Gender, $Age, $Contact, $Email, $Department, $Type);

    if ($stmt->execute()) {
        header("Location: Userindex.php?message=created");
    } else {
        echo "Error: " . $stmt->error;
    }
}
if(isset($_POST['editUser'])){
    $UserID = $_POST['user_id'];
    $Username = $_POST['username'];
    $Fname = $_POST['fname'];
    $Lname = $_POST['lname'];
    $Minitial = $_POST['minitial'];
    $Gender = $_POST['gender'];
    $Age = $_POST['age'];
    $Contact = $_POST['contact'];
    $Email = $_POST['email'];
    $Department = $_POST['department'];
    $Type = $_POST['Type'];

    if (!empty($_POST['password'])) {
        $Password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE user SET Username=?, Fname=?, Lname=?, Minitial=?, Gender=?, Age=?, Contact=?, Email=?, Department=?, Password=?, Type=? WHERE User_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiissssi", $Username, $Fname, $Lname, $Minitial, $Gender, $Age, $Contact, $Email, $Department, $Password, $Type, $UserID);
    } else {
        $sql = "UPDATE user SET Username=?, Fname=?, Lname=?, Minitial=?, Gender=?, Age=?, Contact=?, Email=?, Department=?, Type=? WHERE User_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiisssi", $Username, $Fname, $Lname, $Minitial, $Gender, $Age, $Contact, $Email, $Department, $Type, $UserID);
    }
    

    if ($stmt->execute()) {
        header("Location: Userindex.php?message=updated");
    } else {
        echo "Error: " . $stmt->error;
    }
}

if (isset($_GET['user_id'])) {
    $id = intval($_GET['user_id']); // Convert to integer to prevent SQL injection

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "DELETE FROM user WHERE User_ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if ($stmt->execute()) {
        header("Location: Userindex.php?message=deleted");
    } else {
        echo "Error: " . $stmt->error;
    }

}
?>