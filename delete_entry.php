<?php
include('db_connect.php');  

if (isset($_POST['ref_no'])) {
    $ref_no = $_POST['ref_no'];

     
    $delete_query = "DELETE FROM payroll WHERE ref_no = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param('s', $ref_no);  
    $stmt->execute();
    $stmt->close();

    
    if ($conn->affected_rows > 0) {
        echo "Entry with Ref_No $ref_no deleted successfully.";
    } else {
        echo "Error deleting entry with Ref_No $ref_no.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
