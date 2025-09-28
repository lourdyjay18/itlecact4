<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
<<<<<<< HEAD
    <style>
        .gallery img {
            width: 150px;
            height: auto;
            display: block;
            margin-bottom: 8px;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        .gallery-item {
            text-align: center;
        }
    </style>
=======
    <link rel="stylesheet" href="styles.css">
>>>>>>> bedabda7c06f34cf35e51581b20cd892573ff066
</head>
<body>
    <div class="upload-container">
    <h2>Upload a File</h2>
    <!-- enctype is important for file uploads -->
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose file (JPEG/PNG only, max 2MB):</label><br><br>
        <input type="file" name="file" id="file" required>
        <br><br>
        <button type="submit" name="submit">Upload</button><br><br>

        <a href="dashboard.php">Dashboard</a>
        
    </form>
    
<?php
// Step 2: Handle File Upload
if (isset($_POST['submit'])) {
    // Check if file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        
        // Allowed file types
        $allowed_types = ['image/jpeg', 'image/png'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];

        // Step 2a: Validate file type
        if (!in_array($file_type, $allowed_types)) {
            echo "<p style='color:red;'>Only JPEG and PNG files are allowed.</p>";
            exit;
        }

        // Step 2b: Validate file size (2MB max)
        if ($file_size > 2 * 1024 * 1024) {
            echo "<p style='color:red;'>File is too large. Maximum size is 2MB.</p>";
            exit;
        }

        // Step 3: Store in uploads/ directory with unique name
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create folder if not exists
        }

        $file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $new_name = uniqid("file_", true) . "." . $file_ext;
        $upload_path = $upload_dir . $new_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
            echo "";
            // Step 4: Display uploaded file
            echo "<h3>Uploaded File:</h3>";
            if ($file_type === "image/jpeg" || $file_type === "image/png") {
                echo "<img src='$upload_path' width='300'>";
            } else {
                echo "<a href='$upload_path'>Download File</a>";
            }
            // Add delete button for current uploaded file
            echo "<form method='post' style='margin-top:10px;'>
                <input type='hidden' name='delete_file' value='$upload_path'>
                <button type='submit' onclick=\"return confirm('Delete this file?')\">Delete</button>
            </form>";
            
        } else {
            echo "<p style='color:red;'>Failed to upload file.</p>";
        }

    } else {
        echo "<p style='color:red;'>No file uploaded or an error occurred.</p>";
    }
}

// Handle file deletion
if (isset($_POST['delete_file'])) {
    $delete_path = $_POST['delete_file'];
    if (strpos($delete_path, 'uploads/') === 0 && is_file($delete_path)) {
        unlink($delete_path);
        echo "<p style='color:green;'>File deleted successfully!</p>";
    }
}


// ✅ Show Gallery
$files = glob("uploads/*.{jpg,jpeg,png}", GLOB_BRACE);
if ($files) {
    echo "<h2>Gallery</h2>";
    echo "<div class='gallery'>";
    foreach ($files as $file) {
        echo "<div class='gallery-item'>";
        echo "<img src='$file' alt='image'>";
        echo "<form method='post' class='delete-form'>
                <input type='hidden' name='delete_file' value='$file'>
                <button type='submit' onclick=\"return confirm('Delete this file?')\">Delete</button>
              </form>";
        echo "</div>";
    }
    echo "</div>";
}
?>
    </div>
</body>
</html>
