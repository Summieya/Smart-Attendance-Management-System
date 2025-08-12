<?php
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $student_class       = trim($_POST['student_class']);
    $student_section     = trim($_POST['student_section']);
    $student_id     = trim($_POST['student_id']);
    $roll_number = trim($_POST['roll_number']);

    if (!empty($name) && !empty($student_class) && !empty($student_section) && !empty($roll_number) && !empty($student_id)) {
        $stmt = $connection->prepare("INSERT INTO students (Name, Student_ID, student_class, student_section, Roll_Number) VALUES (?, ?, ?, ?,?)");
        $stmt->bind_param("sssss", $name, $student_id, $student_class, $student_section, $roll_number);

        if ($stmt->execute()) {
            echo "<script>alert('Student added successfully');</script>";
        } else {
            echo "<script>alert('Error adding student');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('All fields are required');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        
    </style>
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

  <!-- main content -->
  <div class="main-content">
    <p class="intro">Fill out the form below to register a new student into the system. Please provide accurate personal and academic details including the student’s name, class, section, and roll number</p>
    <div class="form-container">
      <div class="form-box">
          <h2>Add Student</h2>
              <form method="POST">
              <input type="text" name="student_id" placeholder="Student ID" required>
              <input type="text" name="name" placeholder="Student Name" required>
              <input type="text" name="student_class" placeholder="Class" required>
              <input type="text" name="student_section" placeholder="Section" required>
              <input type="number" name="roll_number" placeholder="Roll Number" required>
              <button type="submit">Add Student</button>
            </form>
      </div>
    </div>
  </div>
</div>   
</body>
</html>