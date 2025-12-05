<?php

    include_once 'config.php';

    $limit = 2;

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $offset = ceil($page - 1) * $limit;

    $Select = mysqli_query($conn, "SELECT * FROM `form_data` ORDER BY id DESC LIMIT $offset, $limit");

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
    </style>

</head>

<body>

    <div class="container text-center center mt-5" >
        <div class="row text-center" style="justify-content: center;">
            <table class="table table-bordered table-hover align-middle">
                <thead style="background-color:#000; color:#fff">

                    <tr>
                        <td>Sr No</td>
                        <td>Full Name</td>
                        <td>Gender</td>
                        <td>Interest</td>
                        <td>Profile</td>
                        <td>Country</td>
                        <td>Created</td>
                        <td>Modified</td>
                        <td>Action</td>

                    </tr>
                </thead class="bordered">

                <tbody>
                    <?php
                        $sr = $offset + 1;
                    while ($row = mysqli_fetch_assoc($Select)) {?>
                        
                    <tr>
                        <td><?php echo $sr++ ?></td>
                        <td><?php echo $row['fullname'] ?></td>
                        <td><?php echo $row['gender'] ?></td>
                        <td><?php echo $row['interests'] ?></td>
                        <td><img src="<?php echo $row['profile'] ?>" style="width: 70px; height:70px; object-fit:cover; border:1px solid black; border-radius:50px; "  alt=""></td>
                        <td><?php echo $row['country']; ?></td>
                        <td><?php echo $row['created_date_time']; ?></td>
                        <td><?php echo $row['modified_date_time']; ?></td>

                        <td><a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a> &nbsp;&nbsp;
                        <a href="delete.php?id=<?php echo $row['id'] ?>" onclick="return confirm('Are You Sure Want To Delete This Data?')"><button class="btn btn-danger">Delete</button></a>
                    </td>
                              </tr>

                    <?php
                    }?>
                </tbody>

            </table>

        </div>
        <div class="row">

        <?php

            $selQuery = "SELECT * FROM `form_data`";
            $result   = mysqli_query($conn, $selQuery);

            if (mysqli_num_rows($result) > 0) {

                $total_records = mysqli_num_rows($result);
                $total_pages   = ceil($total_records / $limit);

            ?>

        <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item                         <?php echo($page <= 1) ? 'disabled' : ''; ?> ">
      <a class="page-link" href="display.php?page=<?php echo($page - 1) ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>

    <?php

        for ($i = 1; $i <= $total_pages; $i++) {?>

    <li class="page-item"><a class="page-link                                              <?php echo($i == $page) ? 'active' : '' ?>" href="display.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
    <?php }?>

     <li class="page-item                          <?php echo($page >= $total_pages) ? 'disabled' : ''; ?> ">
      <a class="page-link" href="display.php?page=<?php echo $page + 1 ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<?php
    }
?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>