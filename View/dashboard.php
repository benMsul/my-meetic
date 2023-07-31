<?php
session_start();
include('../View/headerView.php');
include('../Model/config.php');

if (!isset($_SESSION['username'])) {
  echo "You need to be logged in to access this page.";
  exit;
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
} else {
  echo "An error occurred while retrieving your account information.";
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Account View</title>
  <style>
    .dashboard_container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      padding: 20px;
    }

    .dashboard_menu {
      margin-bottom: 20px;
    }

    .dashboard_menu select {
      padding: 10px;
      font-size: 16px;
      border: none;
      background: #f2f2f2;
      border-radius: 4px;
      cursor: pointer;
    }

    .account_container {
      background-color: #f9f9f9;
      border-radius: 4px;
      padding: 20px;
      max-width: 600px;
      margin: 0 auto;
    }

    .account_container h2 {
      margin-bottom: 20px;
    }

    .error-message,
    .success-message {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 4px;
    }

    .error-message {
      background-color: #ffdddd;
      color: #ff0000;
    }

    .success-message {
      background-color: #ddffdd;
      color: #00aa00;
    }

    .account_container h3 {
      margin-bottom: 10px;
    }

    .account_container ul {
      margin: 0;
      padding: 0;
      list-style-type: none;
    }

    .account_container li {
      margin-bottom: 5px;
    }

    .account_container form {
      margin-top: 10px;
    }

    .account_container label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .account_container input[type="password"],
    .account_container input[type="email"] {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .account_container input[type="submit"] {
      background-color: #4caf50;
      color: white;
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .account_container input[type="submit"]:hover {
      background-color: #45a049;
    }

    .account_container p {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="dashboard_container">
  <div class="dashboard_menu">
    <select onchange="location = this.value;">
      <option value="#">Menu</option>
      <option value="#">Dashboard</option>
      <option value="./searchView.php">Search</option>
      <option value="./accountView.php">My Account</option>
      <option value="./loginView.php">Logout</option>
    </select>
  </div>

  <div class="account_container">
    <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
    <p>Here is your dashboard.</p>
  </div>
</div>

<?php
include('../View/footerView.php');
?>
