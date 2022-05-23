 
 <?php
              $insert = false;
              $update = false;
              $delete = false;
              // Connect to the Database 
              $servername = "localhost";
              $username = "root";
              $password = "root";
              $database = "notes";
              
              // Create a connection
              $conn = mysqli_connect($servername, $username, $password, $database);
              
              // Die if connection was not successful
              if (!$conn){
                  die("Sorry we failed to connect: ". mysqli_connect_error());
              }
              
              if(isset($_GET['delete'])){
                $sno = $_GET['delete'];
                $delete = true;
                $sql = "DELETE FROM `notese` WHERE `sno` = $sno";
                $result = mysqli_query($conn, $sql);
              }
              if ($_SERVER['REQUEST_METHOD'] == 'POST'){
              if (isset( $_POST['snoEdit'])){
                // Update the record
                  $sno = $_POST["snoEdit"];
                  $title = $_POST["titleEdit"];
                  $description = $_POST["descriptionEdit"];
              
                // Sql query to be executed
                $sql = "UPDATE `notese` SET `title` = '$title' , `description` = '$description' WHERE `notese`.`sno` = $sno";
                $result = mysqli_query($conn, $sql);
                if($result){
                  $update = true;
              }
              else{
                  echo "We could not update the record successfully";
              }
              }
              else{
                  $title = $_POST["title"];
                  $description = $_POST["description"];
              
                // Sql query to be executed
                $sql = "INSERT INTO `notese` (`title`, `description`) VALUES ('$title', '$description')";
                $result = mysqli_query($conn, $sql);
              
                 
                if($result){ 
                    $insert = true;
                }
                else{
                    echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
                } 
              }
              }


        ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>


    <script>
      $(document).ready( function () {
    $('#myTable').DataTable();
} )
    </script>

    <title>MyNotes-Best notes taking website</title>
  
  </head>
  <body>
 

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crud/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">MyNotes</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link " aria-current="page" href="# ">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
              </li>
             </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

      <?php
        if($insert){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your note has been sumbited successfuly.
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        }
      ?>
      <?php
        if($update){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your note has been update successfuly.
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        }
      ?>
      <?php
        if($delete){
          echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Your note has been delete successfuly.
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        }
      ?>
      
  

      <div class="container my-3">
          <h2>Add a Note</h2>
        <form action="/crud/index.php" method="POST">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              
            </div>
            <div class=" mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
             
            <button type="submit" class="btn btn-primary  ">Add Note</button>
          </form>
      </div>
      <div class="container my-4" >
       
        <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S No.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php 
       $sql = "SELECT * FROM `notese`";
       $result = mysqli_query($conn,$sql);
       $sno = 0;
        while($row = mysqli_fetch_assoc($result)){
          $sno = $sno + 1;
          echo "  <tr>
          <th scope='row'>" . $sno . "</th>
          <td>". $row['title'] ."</td>
          <td>". $row['description'] ."</td>
          <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
        </tr>";
           
          
        }
    ?>
</tbody>
</table>
      </div>
      <hr>

       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener("click",(e) =>{
          console.log("edits",);
          tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description); 
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
        })
      })


      deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this note!")) {
          console.log("yes");
          window.location = `/crud/index.php?delete=${sno}`;
          // TODO: Create a form and use post request to submit a form
        }
        else {
          console.log("no");
        }
      })
    })
    </script> 
  </body>
</html>