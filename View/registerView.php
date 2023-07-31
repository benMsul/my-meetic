<?php 
include('../View/headerView.php');
include('../Model/config.php');

if(isset($_POST['register'])) {

  $gender = $_POST['gender'];
  $username = $_POST['username'];
  $lastname = $_POST['lastname'];
  $firstname = $_POST['firstname'];
  $birthdate = $_POST['birthdate'];
  $city = $_POST['city'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $description = $_POST['description'];

  if ($password != $confirmPassword) {
    $_SESSION['unSuccessful'] = "The passwords don't match. Please try again.";
    header("Location: registerView.php");
    exit;
  }

 $sql = "INSERT INTO users SET  username = '$username',  lastname = '$lastname',  firstname = '$firstname',  birthdate = '$birthdate',  city = '$city',  email = '$email',  password = '$password',  description = '$description',  gender = '$gender'";

$res = mysqli_query($conn, $sql);

if($res == TRUE) {
    $_SESSION['accountCreated'] = "Your account has been created successfully.";

    header("Location: loginView.php");
    exit;
}
}

?>

<div class="register_container">
  <div class="overlay">
  </div>
  <div class="titleDiv">
    <h1 class="title">Register</h1>
    <span class="subtitle">Thanks for choosing us !</span>
  </div>

  <?php if(isset($_SESSION['accountCreated'])) {
    echo $_SESSION['accountCreated'];
    unset($_SESSION['accountCreated']);
  }
  ?>

  <?php if(isset($_SESSION['unSuccessful'])) {
    echo $_SESSION['unSuccessful'];
    unset($_SESSION['unSuccessful']);
  }
  ?>

  <form action="" method="POST" enctype="multipart/form-data">
    <div class="rows grid">

        <div class="row">
            <select name="gender" id="gender" required>
                <option value=""> </option>
                <option value="Woman"> Woman</option>
                <option value="Man"> Man</option>
                <option value="Transgender"> Transgender</option>
                <option value="Non_binary_non_conforming"> Non-binary/non-conforming</option>
                <option value="Prefer_not_to_respond"> Prefer not to respond</option>
            </select>
        </div>


        <div class="row">
            <label for ="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Enter UserName" required>
        </div>


        <div class="row">
            <label for ="lastname">Lastname</label>
            <input type="text" name="lastname" id="lastname" placeholder="Enter lastname" required>
        </div>


        <div class="row">
            <label for ="firstname">Firstname</label>
            <input type="text" name="firstname" id="firstname" placeholder="Enter Firstname" required>
        </div>


        <div class="row">
            <label for ="birthdate">Birthdate</label>
            <input type="date" name="birthdate" id="birthdate" placeholder="" required>
        </div>


        <div class="row">
            <label for ="city">City</label>
            <input type="text" name="city" id="city" placeholder="Enter City" required>
        </div>


        <div class="row">
            <label for ="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter Email" required>
        </div>


        <div class="row">
            <label for ="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter Password" required>
        </div>


        <div class="row">
            <label for ="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
        </div>


        <div class="row">
            <label for ="description">Description</label>
            <input type="text" name="description" id="description" placeholder="Talk about yourself" required>
        </div>
       

                
        <div class="row">
            <input type="submit" id="submitBtn" name="register" value="Register" required>

            <span class="registerLink">Have an account already ? <a href="../View/loginView.php">Login</a></span>
        </div>
    </div>

            
</form>
</div>

<?php 
include('../View/footerView.php');
?>