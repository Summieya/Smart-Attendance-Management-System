<?php include 'db.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Print Individual Attendance</title>
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
    <div class="main-content">
    <h2>Print Individual Student Attendance Sheet</h2>
    <form method="GET">
  <label>Student ID:</label>
  <input type="number" name="student_id" required>
  <label>From:</label>
  <input type="date" name="from_date" required>
  <label>To:</label>
  <input type="date" name="to_date" required>
  <input class="submit-btn" type="submit" value="View Attendance">
</form>

<?php
if (isset($_GET['student_id']) && isset($_GET['from_date']) && isset($_GET['to_date'])) {
  $sid = $_GET['student_id'];
  $from = $_GET['from_date'];
  $to = $_GET['to_date'];

  $query = "SELECT * FROM attendance 
            WHERE Student_ID='$sid' 
            AND Date BETWEEN '$from' AND '$to'
            ORDER BY Date ASC";

  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
    echo '<div id="printable-area">';
    echo "<h3>Attendance Report for " . htmlspecialchars($student['Name']) . " (Roll: " . htmlspecialchars($student['Roll_Number']) . ")</h3>";
    echo "<p>Date Range: " . htmlspecialchars($from) . " to " . htmlspecialchars($to) . "</p>";


    mysqli_data_seek($result, 0); // reset pointer

    echo "<table class='attendance-table'>";
    echo "<tr><th>Date</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
      echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
      echo "</tr>";

    }
    echo '</div>';
    echo "</table>";
    echo '<div style="margin-top:15px;">';
    echo "<button class='print-btn' onclick='window.print()'>Print Sheet</button>";
    echo '</div>';
  } else {
    echo "<p style='color:red;'>No attendance found for the selected range.</p>";
  }
}
?>
    
  </div>
  </div>
</body>
</html>
