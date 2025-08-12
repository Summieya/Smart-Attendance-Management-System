<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Print Class Attendance</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Attendance Panel</title>
  <link rel="stylesheet" href="style.css"> 
</head>
<body>
<div class="container">
  <!-- sidebar -->
  <div class="sidebar">
    <div class="header-box">
      <img src="school_logo.png" alt="school_logo.png" style="width: 40px;">
      <h1 style="font-size: 18px;">Starlight Public School</h1>
    </div>
    <ul>
      <li><a href="add_student.php">Add Students</a></li>
      <li><a href="view_student.php">View Students</a></li>
      <li><a href="mark_attendance.php">Mark Attendance</a></li>
      <li><a href="printsheet.php">Print Sheet</a></li>
    </ul>
    <div style="position: absolute; bottom: 20px; width: 50%; text-align: center;">
        <a href="logout.php" style="display: inline-block; padding: 8px 16px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px;">Sign Out</a>
    </div>
  </div>

  <!-- main content -->
  <div class="main-content">
  <h2>Print Class Attendance Sheet</h2>
    <form method="GET">
      <label>Date:</label>
      <input type="date" name="date" required>
      <label>Class:</label>
      <input type="text" name="class" required>
      <label>Section:</label>
      <input type="text" name="section" required>
      <input class="submit-btn" type="submit" value="View Attendance">
    </form>

<?php
if (isset($_GET['date']) && isset($_GET['class']) && isset($_GET['section'])) {
  $date = $_GET['date'];
  $class = $_GET['class'];
  $section = $_GET['section'];

  $query = "SELECT * FROM attendance WHERE Date='$date' AND Class='$class' AND Section='$section'";
  $result = mysqli_query($connection, $query);

 if (mysqli_num_rows($result) > 0) {
    echo '<div id="printable-area">';
    echo "<h3>Attendance for Class $class - Section $section on $date</h3>";
    echo "<table class='attendance-table' border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr><th>Sl No</th><th>Student ID</th><th>Name</th><th>Roll No</th><th>Status</th></tr>";
    
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . $i++ . "</td>";
      echo "<td>" . htmlspecialchars($row['Student_ID']) . "</td>";
      echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
      echo "<td>" . htmlspecialchars($row['Roll_Number']) . "</td>";
      echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
      echo "</tr>";
    }
    echo "</table>";  
    echo '</div>';
    echo '<div style="margin-top:15px;">';
    echo "<button class='print-btn' onclick='window.print()'>Print Sheet</button>";
    echo '</div>';
}

  } else {
    echo "<p style='color:red;'>No attendance found for this date and class.</p>";
  }

?>

    </div>
</div>
</body>
</html>
