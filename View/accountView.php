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

if (isset($_POST['updateAccount'])) {
  $newPassword = $_POST['newPassword'];
  $confirmNewPassword = $_POST['confirmNewPassword'];
  $newEmail = $_POST['newEmail'];

  if (!empty($newPassword) && $newPassword != $confirmNewPassword) {
    $_SESSION['updateAccountError'] = "The new passwords don't match. Please try again.";
    header("Location: accountView.php");
    exit;
  }

  $updateSql = "UPDATE users SET password = ?, email = ? WHERE username = ?";
  $stmt = mysqli_prepare($conn, $updateSql);
  mysqli_stmt_bind_param($stmt, "sss", $newPassword, $newEmail, $username);
  $updateResult = mysqli_stmt_execute($stmt);

  if ($updateResult) {
    $_SESSION['updateAccountSuccess'] = "Your account information has been updated successfully.";
    header("Location: accountView.php");
    exit;
  } else {
    $_SESSION['updateAccountError'] = "An error occurred while updating your account information. Please try again.";
    header("Location: accountView.php");
    exit;
  }
}

if (isset($_POST['deleteAccount'])) {
  $deleteSql = "DELETE FROM users WHERE username = ?";
  $stmt = mysqli_prepare($conn, $deleteSql);
  mysqli_stmt_bind_param($stmt, "s", $username);
  $deleteResult = mysqli_stmt_execute($stmt);

  if ($deleteResult) {
    session_destroy();
    $_SESSION['deleteAccountSuccess'] = "Your account has been deleted successfully.";
    header("Location: loginView.php");
    exit;
  } else {
    $_SESSION['deleteAccountError'] = "An error occurred while deleting your account. Please try again.";
    header("Location: accountView.php");
    exit;
  }
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
      <option value="./dashboard.php">Dashboard</option>
      <option value="./searchView.php">Search</option>
      <option value="./accountView.php" selected>My Account</option>
      <option value="./loginView.php">Logout</option>
    </select>
  </div>

  <div class="account_container">
    <h2>My Account</h2>

    <?php if (isset($_SESSION['updateAccountError'])): ?>
      <p class="error-message"><?php echo $_SESSION['updateAccountError']; ?></p>
      <?php unset($_SESSION['updateAccountError']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['updateAccountSuccess'])): ?>
      <p class="success-message"><?php echo $_SESSION['updateAccountSuccess']; ?></p>
      <?php unset($_SESSION['updateAccountSuccess']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['deleteAccountError'])): ?>
      <p class="error-message"><?php echo $_SESSION['deleteAccountError']; ?></p>
      <?php unset($_SESSION['deleteAccountError']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['deleteAccountSuccess'])): ?>
      <p class="success-message"><?php echo $_SESSION['deleteAccountSuccess']; ?></p>
      <?php unset($_SESSION['deleteAccountSuccess']); ?>
    <?php endif; ?>

    <h3>Account Information</h3>
    <ul>
      <li><strong>Name:</strong> <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></li>
      <li><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['birthdate']); ?></li>
      <li><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></li>
      <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
      <li><strong>Interests:</strong> <?php echo htmlspecialchars($user['description']); ?></li>
    </ul>

    <h3>Account Manager</h3>
    <form action="" method="POST">
      <label for="newPassword">New Password:</label>
      <input type="password" name="newPassword" id="newPassword">

      <label for="confirmNewPassword">Confirm New Password:</label>
      <input type="password" name="confirmNewPassword" id="confirmNewPassword">

      <label for="newEmail">New Email:</label>
      <input type="email" name="newEmail" id="newEmail">

      <input type="submit" name="updateAccount" value="Update Account">
    </form>

    <h3>Delete Account</h3>
    <p>Click the button below to permanently delete your account.</p>
    <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
      <input type="submit" name="deleteAccount" value="Delete Account">
    </form>
  </div>
</div>

<?php
include('../View/footerView.php');
?>
