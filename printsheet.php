<?php
include 'db.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Students</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
<div class="container">
  <!-- Sidebar -->
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
    <p class="intro">Get individual attendance record as well as monthly class attendance report.</p>

    <button class="print-btn" onclick= "window.location.href='print_class_sheet.php';">Print Class Sheet </button>
    <button class="print-btn" onclick= "window.location.href='print_individual_sheet.php';">Print Individual Sheet </button>


    </div>
  </div>

</body>
</html>