
<?php 
include '../Config/connecttodb.php'; 

if(isset($_POST['saveStudent'])){
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
    $Type = 'Student';

    // Use prepared statements
    $sql = "INSERT INTO user (Username, Password, Fname, Lname, Minitial, Gender, Age, Contact, Email, Department, Type) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssissss", $Username, $Password, $Fname, $Lname, $Minitial, $Gender, $Age, $Contact, $Email, $Department, $Type);

    if ($stmt->execute()) {
        header("Location: CRUDStudentindex.php?message=created");
    } else {
        echo "Error: " . $stmt->error;
    }
}
if(isset($_POST['editStudent'])){
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

    if (!empty($_POST['password'])) {
        $Password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE user SET Username=?, Fname=?, Lname=?, Minitial=?, Gender=?, Age=?, Contact=?, Email=?, Department=?, Password=? WHERE User_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisisssi", $Username, $Fname, $Lname, $Minitial, $Gender, $Age, $Contact, $Email, $Department, $Password, $UserID);
    } else {
        $sql = "UPDATE user SET Username=?, Fname=?, Lname=?, Minitial=?, Gender=?, Age=?, Contact=?, Email=?, Department=? WHERE User_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssisissi", $Username, $Fname, $Lname, $Minitial, $Gender, $Age, $Contact, $Email, $Department, $UserID);
    }

    if ($stmt->execute()) {
        header("Location: CRUDStudentindex.php?message=updated");
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
        header("Location: CRUDStudentindex.php?message=deleted");
    } else {
        echo "Error: " . $stmt->error;
    }

}
?>