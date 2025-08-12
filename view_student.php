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

  <!-- Main content -->
  <div class="main-content">
    <p class="intro">Welcome to the Attendance Management System. This platform allows teachers to mark attendance, manage student data, and generate attendance reports efficiently. Use the sidebar to navigate through the system.</p>
    
    <!-- Selection form -->
    <form method="GET">
      <label>Select Class:</label>
      <select name="class" required>
        <option value="">Select</option>
        <option value="1" <?= (isset($_GET['class']) && $_GET['class']=='1') ? 'selected' : '' ?>>1</option>
        <option value="2" <?= (isset($_GET['class']) && $_GET['class']=='2') ? 'selected' : '' ?>>2</option>
      </select>

      <label>Select Section:</label>
      <select name="section" required>
        <option value="">Select</option>
        <option value="A" <?= (isset($_GET['section']) && $_GET['section']=='A') ? 'selected' : '' ?>>A</option>
        <option value="B" <?= (isset($_GET['section']) && $_GET['section']=='B') ? 'selected' : '' ?>>B</option>
      </select>

      <input class="submit-btn" type="submit" value="View Students">
    </form>

    <?php
    // Only fetch and display students if class and section are selected
    if (isset($_GET['class']) && isset($_GET['section'])) {
        $class = $_GET['class'];
        $section = $_GET['section'];
        $serial_no = 1;

        // Prepare and execute SQL statement safely
        $stmt = $connection->prepare("SELECT Student_ID, Roll_Number, Name, student_class, student_section FROM students WHERE student_class = ? AND student_section = ?");
        $stmt->bind_param("ss", $class, $section);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h2>Students in Class " . htmlspecialchars($class) . ", Section " . htmlspecialchars($section) . "</h2>";
            echo "<table class='viewing-students' border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr>
                    <th>Serial No</th>
                    <th>Student ID No</th>
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Section</th>
                  </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $serial_no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['Student_ID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Roll_Number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['student_class']) . "</td>";
                echo "<td>" . htmlspecialchars($row['student_section']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red;'>No students found for Class " . htmlspecialchars($class) . ", Section " . htmlspecialchars($section) . ".</p>";
        }

        $stmt->close();
    }
    ?>

  </div>
</div>

</body>
</html>
