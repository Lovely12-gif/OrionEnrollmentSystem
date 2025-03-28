<?php
include '../Config/connecttodb.php';

if(isset($_POST['saveSubject'])){
    $Subjectname = $_POST['Subjectname'];
    $Subjectcode = $_POST['Subjectcode'];
    $Subjectdesc = $_POST['Subjectdesc'];
 
    // Use prepared statements
    $sql = "INSERT INTO subject ( Subjectname, Subjectcode,Subjectdesc) 
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param( "ss", $Subjectname, $Subjectcode,);

    if ($stmt->execute()) {
        header("Location: Courseindex.php?message=created");
    } else {
        echo "Error: " . $stmt->error;
    }
}
if(isset($_POST['editCourse'])){
    $Coursecode = $_POST['Coursecode'];
    $coursedesc = $_POST['coursedesc'];

    $sql = "INSERT INTO course ( Coursecode, coursedesc) 
    VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss",$Coursecode, $coursedesc);

if ($stmt->execute()) {
header("Location: Courseindex.php?message=created");
} else {
echo "Error: " . $stmt->error;
}

}

if (isset($_GET['Course_id'])) {
    $id = intval($_GET['Course_id']); // Convert to integer to prevent SQL injection

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "DELETE FROM course WHERE Course_ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if ($stmt->execute()) {
        header("Location: Courseindex.php?message=deleted");
    } else {
        echo "Error: " . $stmt->error;
    }

}
?>