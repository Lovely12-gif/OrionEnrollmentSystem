<?php
include '../Config/connecttodb.php';

if(isset($_POST['saveSubject'])){
    $Subjectcode = $_POST['Subjectcode'];
    $Subjectdesc = $_POST['Subjectdesc'];
 
    // Use prepared statements
    $sql = "INSERT INTO subject ( Subjectcode,Subjectdesc) 
            VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param( "ss", $Subjectcode,$Subjectdesc);

    if ($stmt->execute()) {
        header("Location: Subjectindex.php?message=created");
    } else {
        echo "Error: " . $stmt->error;
    }
}
if(isset($_POST['editSubject'])){
    $Subjectcode = $_POST['Subjectcode'];
    $Subjectdesc = $_POST['Subjectdesc'];
 
    // Use prepared statements
    $sql = "UPDATE subject SET Subjectcode = ?, Subjectdesc = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$Subjectcode, $Subjectdesc);
    

    if ($stmt->execute()) {
        header("Location: Subjectindex.php?message=created");
    } else {
        echo "Error: " . $stmt->error;
    }

}

if (isset($_GET['Subject_ID'])) {
    $id = intval($_GET['Subject_ID']); // Convert to integer to prevent SQL injection

    // Prepare the SQL statement
    $stmt = mysqli_prepare($conn, "DELETE FROM subject WHERE Subject_ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if ($stmt->execute()) {
        header("Location: Subjectindex.php?message=deleted");
    } else {
        echo "Error: " . $stmt->error;
    }

}
?>