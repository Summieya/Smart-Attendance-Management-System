<?php include 'db.php'; ?>
<!--html code -->
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
    <p class="intro">Welcome to the Smart Attendance Management for your class.Use the sidebar to navigate through the system.</p>

    <form method="GET">
      <label>Select Class:</label>
        <select name="class" required>
        <option value="">Select</option>
        <option value="1">1</option>
        <option value="2">2</option>
        </select>

    <label>Select Section:</label>
    <select name="section" required>
        <option value="">Select</option>
        <option value="A">A</option>
        <option value="B">B</option>
    </select>

    <input class= "submit-btn" type="submit" value="View Students">
</form>

<?php
if (isset($_GET['class']) && isset($_GET['section'])) {
    $class = $_GET['class'];
    $section = $_GET['section'];

    // Save attendance if form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
        $date = $_POST['date'];

        foreach ($_POST['status'] as $student_id => $status) {
            $name = $_POST['name'][$student_id];
            $roll = $_POST['roll'][$student_id];

            // Prevent duplicate entries
            $check = "SELECT * FROM attendance WHERE Student_ID='$student_id' AND Date='$date'";
            $res = $connection->query($check);

            if ($res->num_rows == 0) {
                $insert = "INSERT INTO attendance (Student_ID, Date, Name, Roll_Number, Class, Section, Status)
                           VALUES ('$student_id', '$date', '$name', '$roll', '$class', '$section', '$status')";
                $connection->query($insert);
            }
        }

        echo "<div style='color: green;'>Attendance recorded successfully!</div>";
    }

    // Fetch students
    $sql = "SELECT * FROM students WHERE student_class='$class' AND student_section='$section'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        echo '<form method="POST">';
        echo '<input type="hidden" name="class" value="' . htmlspecialchars($class) . '">';
        echo '<input type="hidden" name="section" value="' . htmlspecialchars($section) . '">';
        echo '<label>Date: <input type="date" name="date" required value="' . date('Y-m-d') . '"></label>';
        echo '<table class= "attendance-table" border="1" cellpadding="5">';
        echo '<tr><th>Sl No</th><th>Student_ID</th><th>Name</th><th>Roll No</th><th>Status</th></tr>';

        $i = 1;
        while ($row = $result->fetch_assoc()) {
                       
            $name = htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8');
            $roll = htmlspecialchars($row['Roll_Number'], ENT_QUOTES, 'UTF-8');

            echo '<tr>';
            echo '<td>' . $i++ . '</td>';
            $student_id = htmlspecialchars($row['Student_ID'], ENT_QUOTES, 'UTF-8'); 
            echo '<td>' . $student_id . '</td>';
            echo '<td>' . $name . '</td>';
            echo '<td>' . $roll . '</td>';
            echo '<td>';
            echo '<label><input type="radio" name="status[' . $student_id . ']" value="Present" required> P</label> ';
            echo '<label><input type="radio" name="status[' . $student_id . ']" value="Absent"> A</label>';
            echo '</td>';
            echo '</tr>';

            echo '<input type="hidden" name="name[' . $student_id . ']" value="' . $name . '">';
            echo '<input type="hidden" name="roll[' . $student_id . ']" value="' . $roll . '">';
        }

        echo '</table><br>';
        echo '<div style="margin: top 10px;">';
        echo '<button class="submit-btn" type="submit">Submit Attendance</button>';
         echo '</div>';
        echo '</form>';
    } else {
        echo '<div style="color:red;">No students found for Class ' . $class . ' Section ' . $section . '.</div>';
    }
}
?>
  </div>
</div>

</body>
</html>

