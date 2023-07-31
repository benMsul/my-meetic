<?php 
include('../View/headerView.php');
include('../Model/config.php');
?>

   

    <div class="form_container">
        <div class="overlay">

        </div>
        <div class="titleDiv">
            <h1 class="title">Login</h1>
            <span class="subtitle">Welcome back !</span>
        </div>
        
        <?php 
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
  
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
  
    if ($result && mysqli_num_rows($result) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['loginMessage'] = '<span class="success">Login Successful ' . $username . '</span>';
      header('location: dashboard.php');
      exit();
    } else {
      $_SESSION['noLogin'] = '<span class="fail">' . $username . ' is not registered or the Username/Password is not valid</span>';
      header('location: loginView.php');
      exit();
    }
  }
        ?>

        <form action="" method="POST">
            <div class="rows grid">


                <div class="row">
                    <label for ="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Enter UserName" required>
                </div>


                <div class="row">
                    <label for ="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter Password" required>
                </div>

                
                <div class="row">
                    <input type="submit" id="submitBtn" name="submit" value="Login" required>

                    <span class="registerLink">Don't have an account ? <a href="../View/registerView.php">Register</a></span>
                </div>
            </div>

            
        </form>
    </div>


<?php 
include('../View/footerView.php');
?>