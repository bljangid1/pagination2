<?php
    include_once 'config.php';

    // if(isset($_REQUEST["POST"])){

    // }

    // if(isset($_POST["submit"])){

    // }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Fullname  = mysqli_real_escape_string($conn, $_POST["fullname"]);
        $Gender    = mysqli_real_escape_string($conn, $_POST['gender']);
        $Interests = isset($_POST['interests'])
            ? mysqli_real_escape_string($conn, implode(",", $_POST["interests"])) : "";
        $Country = mysqli_real_escape_string($conn, $_POST['country']);

        // File Upload (Image)
        // $imagePath = "";
        // if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        //     $targetDir = "Profiles/";
        //     $targetFile = $targetDir . basename($_FILES["profile"]["name"]);
        //     if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
        //         $imagePath = $targetFile;
        //     }
        // }

        // File Upload (Image)
        $imagePath = "";
        if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
            $targetDir    = "Profiles/";
            $targetFile   = $targetDir . basename($_FILES["profile"]["name"]);
            $fileType     = mime_content_type($_FILES['profile']['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    echo "File upload failed!";
                }
            } else {
                echo "Invalid file type. Only JPG, PNG, and GIF are allowed.";
            }
        }

        $Insert = mysqli_query($conn, "INSERT INTO `form_data`(`fullname`, `gender`, `interests`, `profile`, `country`, `modified_date_time`) VALUES ('$Fullname','$Gender','$Interests','$imagePath','$Country', NOW())");

        if ($Insert) {
            header("Location: display.php");
            exit;
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish Bootstrap Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styling */
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
        }

        .form-container h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 500;
            color: #555;
        }

        .form-check-label {
            font-weight: 500;
        }

        .form-select {
            background-color: #f8f9fa;
            border: 1px solid #ccc;
        }

        .form-control {
            border-radius: 5px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            border-radius: 5px;
            padding: 12px 30px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-check-inline {
            margin-right: 15px;
        }

        .file-input {
            font-size: 16px;
            padding: 8px;
        }

        /* Responsive tweaks */
        @media (max-width: 767px) {
            .form-container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container form-container">
    <h2>Register for Our Service</h2>
    <form method="POST" enctype="multipart/form-data">
        <!-- Open Text Field -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name">
        </div>

        <!-- Radio Buttons -->
        <fieldset class="mb-3">
            <legend class="col-form-label">Gender</legend>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label" for="female">Female</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                <label class="form-check-label" for="other">Other</label>
            </div>
        </fieldset>

        <!-- Checkboxes -->
        <div class="mb-3">
            <label class="form-label">Interests</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="interests[]" id="sports" value="sports">
                <label class="form-check-label" for="sports">Sports</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="music" name="interests[]" value="music">
                <label class="form-check-label" for="music">Music</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="travel" name="interests[]" value="travel">
                <label class="form-check-label" for="travel">Travel</label>
            </div>
        </div>

        <!-- File Upload -->
        <div class="mb-3">
            <label for="image" class="form-label">Upload Profile Image</label>
            <input class="form-control file-input" type="file" name="profile" id="profile" accept="image/*">
        </div>

        <!-- Dropdown -->
        <div class="mb-3">
            <label for="country" class="form-label">Select Country</label>
            <select class="form-select" id="country" name="country">
                <option selected>Select your country</option>
                <option value="US">United States</option>
                <option value="CA">Canada</option>
                <option value="GB">United Kingdom</option>
                <option value="AU">Australia</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-custom">Submit</button>
    </form>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
