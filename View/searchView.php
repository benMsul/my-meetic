<?php
include('../View/headerView.php');
?>
<div class="dashboard_container">
  <div class="dashboard_menu">

    <select onchange="location = this.value;">
      <option value="#">Menu</option>
      <option value="./dashboard.php">Dashboard</option>
      <option value="./searchView.php" selected>Search</option>
      <option value="./accountView.php">My Account</option>
      <option value="./loginView.php">Logout</option>
    </select>
  </div>


  <div class="search_container">
    <h2>Search</h2>
    <form action="" method="POST">
      <label for="gender">Gender:</label>
      <select name="gender" id="gender">
        <option value="">All</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>

      <label for=" city"> City:</label>
      <input type="text" name=" city" id=" city">

      <label for=" description"> Description:</label>
      <input type="text" name=" description" id=" description">

      <label for="age_range">Age Range:</label>
      <select name="age_range" id="age_range">
        <option value="">All</option>
        <option value="18-25">18-25</option>
        <option value="25-35">25-35</option>
        <option value="35-45">35-45</option>
        <option value="45+">45+</option>
      </select>

      <input type="submit" name="search" value="Search">
    </form>
  </div>

  <?php
if (isset($_POST['search'])) {
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $description = $_POST['description'];
    $age_range = $_POST['age_range'];
  
    $sql = "SELECT * FROM users WHERE 1=1";
    if (!empty($gender)) {
      $sql .= " AND gender = '$gender'";
    }
    if (!empty($city)) {
      $sql .= " AND city = '$city'";
    }
    if (!empty($description)) {
      $sql .= " AND description = '$description'";
    }
    if (!empty($age_range)) {
      if ($age_range === '18-25') {
        $sql .= " AND age >= 18 AND age <= 25";
      } elseif ($age_range === '25-35') {
        $sql .= " AND age >= 25 AND age <= 35";
      } elseif ($age_range === '35-45') {
        $sql .= " AND age >= 35 AND age <= 45";
      } elseif ($age_range === '45+') {
        $sql .= " AND age >= 45";
      }
    }
  
    $result = mysqli_query($conn, $sql);
  
    echo "<div class='search_results'>";
    echo "<h3>Search Results</h3>";
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>User: " . htmlspecialchars($row['username']) . "</p>";
        echo "<p>Name: " . htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) . "</p>";
        echo "<p>Gender: " . htmlspecialchars($row['gender']) . "</p>";
        echo "<p>City: " . htmlspecialchars($row['city']) . "</p>";
        echo "<p>Description: " . htmlspecialchars($row['description']) . "</p>";
        echo "<hr>";
      }
    } else {
      echo "<p>No results found.</p>";
    }
    echo "</div>";
  
    mysqli_free_result($result);
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

.search_container {
  background-color: #f9f9f9;
  border-radius: 4px;
  padding: 20px;
  max-width: 600px;
  margin: 0 auto;
}

.search_container h2 {
  margin-bottom: 20px;
}

.search_container form {
  margin-top: 10px;
}

.search_container label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.search_container input[type="text"],
.search_container select {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.search_container input[type="submit"] {
  background-color: #4caf50;
  color: white;
  padding: 10px 20px;
  font-size: 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.search_container input[type="submit"]:hover {
  background-color: #45a049;
}

.search_results {
  margin-top: 20px;
}

.search_results h3 {
  margin-bottom: 10px;
}

.search_results p {
  margin: 5px 0;
}

.search_results hr {
  margin-top: 10px;
  margin-bottom: 10px;
}

  </style>
</head>
<body>

</div>

<?php
include('../View/footerView.php');
?>
