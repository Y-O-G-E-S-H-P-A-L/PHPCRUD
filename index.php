<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap 5.1 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <!-- Fontawesome 6 -->
  <script src="https://kit.fontawesome.com/4ef9bffeeb.js" crossorigin="anonymous"></script>
  <!-- Jquery 3.6 -->
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <!-- Datatables plugin CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <!-- Datatables plugin JS -->
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


  <title>PHP CRUD</title>
</head>

<body>
  <?php
  $con = mysqli_connect('localhost', 'root', '', 'mydatabase');
  if (!$con) {
    echo "Connection Failed..!" . mysqli_connect_error();
  }
  $insert = false;
  $update = false;
  $delete = false;

  if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $sql = "DELETE FROM `notes` WHERE sno = $sno";
    $result = mysqli_query($con, $sql);
    if ($result) {
      $delete = true;
    }
  }
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['editSno'])) {
      $sno = $_POST['editSno'];
      $editTitle = $_POST['editTitle'];
      $editDescription = $_POST['editDescription'];
      if ($editTitle && $editDescription) {
        $sql = "UPDATE `notes` SET `title` = '$editTitle' , `description` = '$editDescription' WHERE `notes`.`sno` = $sno";
        $result = mysqli_query($con, $sql);
        if ($result) {
          $update = true;
        }
      }
    } else {
      $title = $_POST['title'];
      $description = $_POST['description'];
      if ($description && $title) {
        $sql = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title','$description')";
        $result = mysqli_query($con, $sql);
        if ($result) {
          $insert = true;
        }
      }
    }
  }
  ?>
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/PHPCRUD/index.php" method="POST" class="border p-3 rounded">
            <input type="hidden" name="editSno" id="editSno">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="editTitle" name="editTitle" />
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Note Description</label>
              <textarea class="form-control" id="editDescription" name="editDescription" rows="3"></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-secondary align-item-center col-md-6">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fa-brands fa-php fs-1"></i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">PHP CRUD</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
          <button class="btn btn-outline-light" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php
  if ($insert == true) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <i class='fa-solid fa-circle-check textlight rounded'></i>
                  <strong>Success !</strong> Your note has been inserted successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
  }
  if ($update == true) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <i class='fa-solid fa-circle-check textlight rounded'></i>
                  <strong>Success !</strong> Your note has been updated successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
  }
  if ($delete == true) {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <i class='fa-solid fa-circle-check textlight rounded'></i>
                  <strong>Success !</strong> Your note has been deleted successfully.
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
  }
  ?>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-6 offset-3">
        <form action="/PHPCRUD/index.php" method="POST" class="border p-3 rounded">
          <h4 class="p-3 text-light text-center rounded bg-secondary">Keep Notes</h4>
          <div class="mb-3">
            <label for="title" class="form-label">Note Title</label>
            <input type="text" class="form-control" id="title" name="title" />
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Note Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-secondary align-item-center col-md-6">Add Note</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-12 ">
        <table class="table table-hover border-bottom-0 p-5 " id="myTable">
          <thead>
            <tr>
              <th scope="col">Sr No.</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($con, $sql);
            $sno = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              $sno++;
              echo "
          <tr>
            <th scope='row'>" . $sno . "</th>
            <input type='hidden' id='sno' value='" . $row['sno'] . "'/>
            <td>" . $row['title'] . "</td>
            <td>" . $row['description'] . "</td>
            <td> 
              <button class='edit btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' id=" . $row['sno'] . ">Edit</button>
              <button class='delete btn btn-primary btn-sm ms-3'>Delete</button>
            </td>
          </tr>
          ";
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <hr>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('#myTable').DataTable();
    });

    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        editSno.value = e.target.id;
        editTitle.value = title;
        editDescription.value = description;
        $(editModal).modal('toggle');
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;
        sno = tr.getElementsByTagName("input")[0].value;
        console.log(sno);
        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/PHPCRUD/index.php?delete=${sno}`;
        } else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>