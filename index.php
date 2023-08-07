<?php
    //connect to database
    
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$insert = false;
$update = false;
$delete = false;
// create a connection object
$conn = mysqli_connect($servername, $username, $password,$database);

//die if connection was not successful
if(!$conn){
    die("we failed to connect: ".mysqli_connect_error());

}
// echo $_GET['update'];
//echo $_POST['snoEdit'];
//exit();

//echo var_dump(isset( $_POST['title']));
//echo  var_dump(isset($_POST['description']));

//echo $_SERVER['REQUEST_METHOD'];
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  //echo $sno;
  $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(isset($_POST['snoEdit'])){
    $sno = $_POST["snoEdit"];

    //echo "yes";
    //Update the record
    $title = $_POST["titleEdit"];
    $addnote = $_POST["addnoteEdit"];

    //query to be executed
    $sql = "UPDATE `notes` SET `title` = '$title' , `addnote` = '$addnote' WHERE `notes`.`sno` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
      $update= true;
      //echo "Note has been successfully updated";
    }
    else{
      echo "note has not been uodates due to error";
    }
}
  else{
    $title = $_POST['title'];
    //if(var_dump(isset($_POST['description'])) == false){
    /////$description = $_POST['description'];
    //}
    $addnote = $_POST['addnote'];

    //query to be executed
    $sql = "INSERT INTO `notes` (`title`, `addnote`) VALUES ('$title' , '$addnote')"; 
    $result = mysqli_query($conn, $sql);
    
    if($result){
      //echo "The record has been Inserted successfully";
        $insert = true;
    }
    else{
      echo "The record has not been inserted succesfully because of this error --->";
      mysqli_error($conn);
    }
  }
}
//exit();
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">


  <title>Mienotes - Easy notes taking</title>

</head>

<body>
  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="/vaish/curd/index.php" method="post">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">

            </div>
            <div class="mb-3">
              <label for="addnote" class="form-label">Note Description</label>
              <textarea class="form-control" id="addnoteEdit" name="addnoteEdit" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">update note</button>

          </div>
          <div class="modal-footer d-block mr-auto" >
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </form>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"> <img src="/vaish/curd/logo.png" height="28px" alt=""> Mienotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact us

            </a>
          </li>

          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
      </div>
    </div>
  </nav>

  <?php
  if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inserted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    <span aria-hidden='true'>&times;</span>
  </div>";
  }

  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been Updated successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    <span aria-hidden='true'>&times;</span>
  </div>";
  }

  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been Deleted successfully.
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    <span aria-hidden='true'>&times;</span>
  </div>";
  }
  ?>

  <div class="container my-2">
    <h2>Add a note to Mienote</h2>
    <form action="/vaish/curd/index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">

      </div>
      <div class="mb-3">
        <label for="addnote" class="form-label">Note Description</label>
        <textarea class="form-control" id="addnote" name="addnote" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Add note</button>
    </form>
  </div>
  <div class="container my-4">


    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">Sr no</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
      $sql = "SELECT * FROM `notes`";
      $result = mysqli_query($conn,$sql);
      $sno = 0;
      while($row = mysqli_fetch_assoc($result)){
        $sno = $sno + 1;
        echo " <tr>
        <th scope='row'>". $sno ."</th>
        <td>".$row['title']."</td>
        <td>".$row['addnote']."</td>
        <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button> </td>
      </tr>";
        
      }
    ?>


      </tbody>
    </table>
  </div>
  <hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script>let table = new DataTable('#myTable');</script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        //console.log("edit", );
        console.log("edit", e.target.parentNode.parentNode);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        addnote = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, addnote);
        snoEdit.value = e.target.id;
        console.log(e.target.id);
        addnoteEdit.value = addnote;
        titleEdit.value = title;
        $('#editModal').modal('toggle')
      })
    })

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        //console.log("edit", );
        console.log("edit", e.target.parentNode.parentNode);
        sno = e.target.id.substr(1,);

        if (confirm("Are you sure you want to delete this note?")) {
          console.log("yes");
          window.location = `/vaish/curd/index.php?delete=${sno}`;

          //TODO create a form using JS and submit using post
        }
        else {
          console.log("no");
        }
      })
    })
  </script>
</body>

</html>