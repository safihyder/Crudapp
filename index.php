<?php
$insert=false;
$update=false;
$delete=false;
// Connecting to the database
$servername="localhost";
$username="root";
$password="";
$database="notes";
// Create a connection
$conn=mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("Connection is unable to connect due to the following error-->".mysqli_connect_error());
}
if(isset($_GET["delete"])){
  $sno=$_GET["delete"];
  $delete=true;
  // echo $sno;
  $sql="DELETE FROM `notes` WHERE `S no.`=$sno";
  $result=mysqli_query($conn,$sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST["snoEdit"])){
    $sno=$_POST["snoEdit"];
    $title=$_POST["titleEdit"];
    $description=$_POST["descriptionEdit"];
    $sql="UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`S no.` =$sno";
    $result=mysqli_query($conn,$sql);
    if($result){
    $update=true;
    }else{
      printf("We are unable to update the record");
    }
  }else{

    $title=$_POST["title"];
    $description=$_POST["description"];
    $sql="INSERT INTO `notes` (`title`, `description`, `Tstamp`) VALUES ('$title','$description', CURRENT_TIMESTAMP);";
    $result=mysqli_query($conn,$sql);
    if($result){
      $insert=true;
      // echo "The table value was set successfully";
    }else{
      echo "The table value was unable to set due to this error".mysqli_error($conn);
    }
  }
    
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes-making notes easy</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </head>
  <body>
    <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

<!--edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModal">Update input</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/CRUDApp/index.php" method="post">
        <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="titleEdit" class="form-label">Note Title</label>
              <input type="text" name="titleEdit" class="form-control" id="titleEdit" aria-describedby="emailHelp">
            </div>
            
            <div class="mb-3">
                <label for="descriptionEdit" class="form-label">Note Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg  bg-body-tertiary navbar bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">PHP CRUD</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <a class="nav-link" href="#">Contact us</a>
              </li>
            </ul>
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
        <strong>Success</strong> Your note has been inserted successfully!
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      ?>
      <?php
      if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success</strong> Your note has been deleted successfully!
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      ?>
      <?php
      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success</strong> Your note has been updated successfully!
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      ?>
      <div class="container my-4">
        <form action="/CRUDApp/index.php" method="post">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">
            </div>
            
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="desc" name="description" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div>
      <div class="container my-4">
     
        <table class="table" id="myTable" >
  <thead>
    <tr>
      <th scope="col">S no.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
        $sql="SELECT * FROM `notes`";
        $result=mysqli_query($conn,$sql);
        $Sno=0;
        while($row = mysqli_fetch_assoc($result)){
          $Sno++;
         echo "<tr>
          <th scope='row'>".$Sno."</th>
          <td>".$row['title']."</td>
          <td>".$row['description']."</td>
          <td> <button class='btn btn-sm btn-primary edit' data-bs-toggle='modal' data-bs-target='#editModal' id=".$row['S no.'].">Edit</button>
          <button class='btn btn-sm btn-primary delete' data-bs-toggle='modal' data-bs-target='#editModal' id=d".$row['S no.'].">Delete</button></td>
        </tr>";
          }
        ?>
  </tbody>
</table>
      </div>
      <hr>
    
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js">
    </script>
    <script>
      let table = new DataTable('#myTable');
    </script>
    <script>
  edits=document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener('click',(e)=>{
      console.log("edit");
      tr=e.target.parentNode.parentNode;
      title=tr.getElementsByTagName("td")[0].innerText;
      description=tr.getElementsByTagName("td")[1].innerText;
      // console.log(title,description);
      titleEdit.value=title;
      descriptionEdit.value=description;
      snoEdit.value=e.target.id;
      console.log(e.target.id);


  }) 
  })
  deletes=document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element)=>{
    element.addEventListener('click',(e)=>{
      // console.log("delete");
      sno=e.target.id.substr(1,)
      if(confirm("Are you sure to delete this note?")){
        console.log("Yes");
        window.location=`/CRUDApp/index.php?delete=${sno}`;
      }else{
        console.log("No");
      }

  }) 
  })
</script>
  </body>
</html>