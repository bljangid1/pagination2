<?php
    include_once 'config.php';

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        $query = mysqli_query($conn, "SELECT * FROM `form_data` WHERE id=$id");

        if (mysqli_num_rows($query) > 0) {
            $row            = mysqli_fetch_assoc($query);
            $interestsArray = explode(',', $row['interests']); // convert stored interests to array
        } else {
            header('Location: display.php');
            exit;
        }
    } else {
        header('Location: display.php');
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $fullname  = $_POST['fullname'];
        $gender    = $_POST['gender'];
        $interests = isset($_POST['interests']) ? implode(',', $_POST['interests']) : '';
        $country   = $_POST['country'];

        // Handle profile image upload
        if (! empty($_FILES['profile']['name'])) {
            $profile = "Profiles/" . time() . "_" . $_FILES['profile']['name'];
            move_uploaded_file($_FILES['profile']['tmp_name'], $profile);
            $queryUpdate = "UPDATE `form_data` SET fullname='$fullname', gender='$gender', interests='$interests', profile='$profile', country='$country', modified_date_time=NOW() WHERE id=$id";
        } else {
            $queryUpdate = "UPDATE `form_data` SET fullname='$fullname', gender='$gender', interests='$interests', country='$country', modified_date_time=NOW() WHERE id=$id";
        }

        if (mysqli_query($conn, $queryUpdate)) {
            header('Location: display.php');
            exit;
        } else {
            echo "Update failed: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f4f7fc; font-family: Arial, sans-serif; }
.form-container { background-color: #fff; padding: 30px; border-radius: 8px; margin-top: 50px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
.btn-custom { background-color: #007bff; color: #fff; border-radius: 5px; padding: 12px 30px; font-weight: 600; }
.btn-custom:hover { background-color: #0056b3; }
.form-control, .form-select { border-radius: 5px; background-color: #f8f9fa; border: 1px solid #ccc; }
.form-control:focus { box-shadow: none; border-color: #007bff; }
</style>
</head>
<body>

<div class="container form-container">
    <h2 class="text-center mb-4">Edit User</h2>
    <form method="POST" enctype="multipart/form-data">
        <!-- Full Name -->
        <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($row['fullname']);?>" required>
        </div>

        <!-- Gender -->
        <fieldset class="mb-3">
            <legend class="col-form-label">Gender</legend>
            <?php
                $genders = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other'];
                foreach ($genders as $key => $label) {
                    $checked = ($row['gender'] == $key) ? 'checked' : '';
                    echo "<div class='form-check'>
                        <input class='form-check-input' type='radio' name='gender' id='$key' value='$key' $checked>
                        <label class='form-check-label' for='$key'>$label</label>
                      </div>";
                }
            ?>
        </fieldset>

        <!-- Interests -->
        <div class="mb-3">
            <label class="form-label">Interests</label><br>
            <?php
                $allInterests = ['sports' => 'Sports', 'music' => 'Music', 'travel' => 'Travel'];
                foreach ($allInterests as $key => $label) {
                    $checked = in_array($key, $interestsArray) ? 'checked' : '';
                    echo "<div class='form-check form-check-inline'>
                        <input class='form-check-input' type='checkbox' name='interests[]' id='$key' value='$key' $checked>
                        <label class='form-check-label' for='$key'>$label</label>
                      </div>";
                }
            ?>
        </div>

        <!-- Profile Image -->
        <div class="mb-3">
            <label for="profile" class="form-label">Upload Profile Image</label>
            <input class="form-control file-input" type="file" name="profile" id="profile" accept="image/*">
            <?php if (! empty($row['profile'])): ?>
                <div class="mt-2"><img src="<?php echo $row['profile'];?>" width="100" alt="Profile"></div>
            <?php endif; ?>
        </div>

        <!-- Country -->
        <div class="mb-3">
            <label for="country" class="form-label">Select Country</label>
            <select class="form-select" id="country" name="country" required>
                <option value="">Select your country</option>
                <?php
                    $countries = ['US' => 'United States', 'CA' => 'Canada', 'GB' => 'United Kingdom', 'AU' => 'Australia'];
                    foreach ($countries as $code => $name) {
                        $selected = ($row['country'] == $code) ? 'selected' : '';
                        echo "<option value='$code' $selected>$name</option>";
                    }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-custom">Update</button>
        <a href="display.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
