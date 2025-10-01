<?php
$upload_dir = "/tmp/uploads/";

// Create uploads directory if it doesn't exist
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_FILES['file'])) {
    $target_file = $upload_dir . basename($_FILES['file']['name']);
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
        echo "File uploaded successfully! Access it at: uploads/" . $_FILES['file']['name'];
    } else {
        echo "Upload failed.";
    }
} else {
    echo "No file received.";
}
?>
