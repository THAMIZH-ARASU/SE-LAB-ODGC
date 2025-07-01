<?php
session_start();
// Ensure only students can access this page
if ($_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db.php'; // Include PDO database connection
require 'vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Email Configuration
$EMAIL_ADDRESS = "yourgmail@gmail.com"; // Your Gmail address
$EMAIL_PASSWORD = "your gmail app password"; // Your app-specific password

// Fetch student details from the database
$registration_number = $_SESSION['registration_number'];
$sql = "SELECT * FROM users WHERE registration_number = :registration_number";
$stmt = $conn->prepare($sql);
$stmt->execute(['registration_number' => $registration_number]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Initialize error messages array
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $enrollment = $_POST['enrollment'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $year_of_study = $_POST['year_of_study'];
    $programme = $_POST['programme'];
    $branch = $_POST['branch'];
    $class = $_POST['class'];
    $leave_type = $_POST['leave_type'];
    $from_date = $_POST[$leave_type . '_from_date'];
    $to_date = $_POST[$leave_type . '_to_date'];
    $reason = $_POST[$leave_type . '_reason'];
    $days_availed = $_POST[$leave_type . '_days_availed'];

    // File validation - check file size (5MB limit) and format
    $file_fields = ['parent_sign', 'student_sign', 'advisor_letter', 'hod_letter'];
    $max_size = 5 * 1024 * 1024; // 5MB in bytes
    $valid_upload = true;

    foreach ($file_fields as $field) {
        // Check if file was uploaded
        if (!isset($_FILES[$field]['name']) || empty($_FILES[$field]['name'])) {
            $errors[$field] = "Please upload a file for " . str_replace('_', ' ', $field);
            $valid_upload = false;
            continue;
        }

        // Check file size
        if ($_FILES[$field]['size'] > $max_size) {
            $errors[$field] = "File size exceeds 5MB limit for " . str_replace('_', ' ', $field);
            $valid_upload = false;
            continue;
        }

        // Check file format
        $allowed_extensions = [];
        if ($field === 'advisor_letter' || $field === 'hod_letter') {
            $allowed_extensions = ['pdf'];
        } else {
            $allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];
        }

        $file_ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            $errors[$field] = "Invalid file format. Allowed formats: " . implode(', ', $allowed_extensions);
            $valid_upload = false;
        }
    }

    // If all files are valid, proceed with form submission
    if ($valid_upload) {
        // Handle file uploads
        $upload_dir = "uploads/"; // Base directory for uploads

        // Create a folder for the applicant using their name and enrollment number
        $applicant_folder = $upload_dir . $name . '_' . $enrollment . '/';
        if (!is_dir($applicant_folder)) {
            mkdir($applicant_folder, 0777, true); // Create the folder if it doesn't exist
        }

        // Move uploaded files to the applicant's folder
        $parent_sign = $applicant_folder . basename($_FILES['parent_sign']['name']);
        $student_sign = $applicant_folder . basename($_FILES['student_sign']['name']);
        $advisor_letter = $applicant_folder . basename($_FILES['advisor_letter']['name']);
        $hod_letter = $applicant_folder . basename($_FILES['hod_letter']['name']);

        move_uploaded_file($_FILES['parent_sign']['tmp_name'], $parent_sign);
        move_uploaded_file($_FILES['student_sign']['tmp_name'], $student_sign);
        move_uploaded_file($_FILES['advisor_letter']['tmp_name'], $advisor_letter);
        move_uploaded_file($_FILES['hod_letter']['tmp_name'], $hod_letter);

        // Insert data into the database
        $sql = "INSERT INTO leave_applications (
            name, enrollment, email, department, year_of_study, programme, branch, class,
            leave_type, from_date, to_date, reason, days_availed,
            parent_sign, student_sign, advisor_letter, hod_letter, status
        ) VALUES (
            :name, :enrollment, :email, :department, :year_of_study, :programme, :branch, :class,
            :leave_type, :from_date, :to_date, :reason, :days_availed,
            :parent_sign, :student_sign, :advisor_letter, :hod_letter, 'Pending'
        )";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'enrollment' => $enrollment,
            'email' => $email,
            'department' => $department,
            'year_of_study' => $year_of_study,
            'programme' => $programme,
            'branch' => $branch,
            'class' => $class,
            'leave_type' => $leave_type,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'reason' => $reason,
            'days_availed' => $days_availed,
            'parent_sign' => $parent_sign,
            'student_sign' => $student_sign,
            'advisor_letter' => $advisor_letter,
            'hod_letter' => $hod_letter
        ]);

        // Fetch Dean's email
        $sql = "SELECT email FROM users WHERE role = 'dean'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $dean_email = $stmt->fetchColumn();

        // Send email notifications
        if ($dean_email) {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $EMAIL_ADDRESS;
                $mail->Password = $EMAIL_PASSWORD;
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom($EMAIL_ADDRESS, 'Online OD System');
                $mail->addAddress($dean_email); // Only send to Dean

                $mail->isHTML(true);
                $mail->Subject = 'New OD Application Submitted';
                $mail->Body = "A new OD application has been submitted by <b>$name</b>.<br><br>"
                             . "Details:<br>"
                             . "Enrollment Number: $enrollment<br>"
                             . "Department: $department<br>"
                             . "Leave Type: $leave_type<br>"
                             . "From Date: $from_date<br>"
                             . "To Date: $to_date<br>"
                             . "Reason: $reason<br><br>"
                             . "Please review the application in the system.";

                $mail->send();
            } catch (Exception $e) {
                // Log the error or display a message
                error_log("Email could not be sent to Dean. Error: {$mail->ErrorInfo}");
            }
        } else {
            error_log("Dean's email not found in the database");
        }

        // Send confirmation email to student
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $EMAIL_ADDRESS;
            $mail->Password = $EMAIL_PASSWORD;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom($EMAIL_ADDRESS, 'Online OD System');
            $mail->addAddress($email); // Student's email
            $mail->isHTML(true);
            $mail->Subject = 'OD Application Submitted Successfully';
            $mail->Body = "Dear $name,<br><br>"
                         . "Your OD application has been submitted successfully.<br>"
                         . "Details:<br>"
                         . "From Date: $from_date<br>"
                         . "To Date: $to_date<br>"
                         . "Reason: $reason<br><br>"
                         . "Thank you,<br>"
                         . "Online OD System";

            $mail->send();
        } catch (Exception $e) {
            error_log("Failed to send email to student: {$mail->ErrorInfo}");
        }

        // Redirect to a success page or display a success message
        header("Location: student_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>PTU - Leave Application Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #ffffff;
    }
    .container {
      width: 85%;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    /* Updated header styling for larger logo */
    .header {
      background-color: #c40d0d;
      color: #ffffff;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;

      /* Use flex layout to position logo and text side by side */
      display: flex;
      align-items: center;
      justify-content: center; /* centers horizontally in the container */
    }
    /* Make the logo bigger here by adjusting width or height */
    .header .logo {
      width: 170px;  /* Increase or decrease to make the logo bigger or smaller */
      height: auto;
      margin-right: 20px;
    }
    /* Keep the text in a separate container so it remains centered */
    .header-text {
      text-align: center;
	  font-size: 25px;
    }

    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      color: #660000;
      font-weight: bold;
    }
    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="number"],
    select,
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #660000;
      border-radius: 4px;
      box-sizing: border-box;
    }
    textarea {
      height: 100px;
      resize: vertical;
    }
    .radio-group {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    .radio-group label {
      color: #000;
      font-weight: normal;
    }
    .section {
      border: 1px solid #c40d0d;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    .section-title {
      background-color: #c40d0d;
      color: #ffffff;
      padding: 8px;
      margin: -15px -15px 15px -15px;
      border-radius: 5px 5px 0 0;
    }
    .upload-section {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-top: 20px;
    }
    .upload-box {
      border: 1px solid #660000;
      padding: 15px;
      border-radius: 5px;
    }
    .upload-box p {
      margin: 5px 0;
      color: #660000;
    }
    .file-requirements {
      font-size: 0.85em;
      color: #666;
      margin-top: 5px;
    }
    .error-message {
      color: #c40d0d;
      font-size: 0.85em;
      margin-top: 5px;
      font-weight: bold;
    }
    button {
      background-color: #c40d0d;
      color: #ffffff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      margin-top: 20px;
    }
    button:hover {
      background-color: #660000;
    }
    .note {
      font-size: 0.9em;
      color: #c40d0d;
      margin-top: 10px;
    }
    .notebold {
      font-weight: bold;
      font-size: 0.9em;
      color: #c40d0d;
      margin-top: 10px;
    }
    .leave-type-selector {
      margin-bottom: 20px;
      padding: 20px;
      background-color: #f8f8f8;
      border-radius: 5px;
      text-align: center;
    }
    .leave-type-selector select {
      width: 60%;
      padding: 10px;
      font-size: 16px;
      border: 2px solid #c40d0d;
      border-radius: 5px;
      cursor: pointer;
      background-color: #ffffff;
    }
    .leave-type-selector label {
      display: block;
      margin-bottom: 10px;
      font-size: 16px;
      color: #660000;
      font-weight: bold;
    }
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <!-- Larger logo -->
      <img
        src="assets/ptu-logo.png"
        alt="PTU Logo"
        class="logo"
      />
      <!-- Header text in a separate container -->
      <div class="header-text">
        <h2>Puducherry Technological University</h2>
        <h3>Leave Application - Students</h3>
      </div>
    </div>

    <form action="od_form.php" method="POST" enctype="multipart/form-data">
      <!-- Leave Type Selector -->
      <div class="leave-type-selector">
        <label for="leave_type">Select Type of Leave</label>
        <select id="leave_type" name="leave_type" required onchange="showLeaveForm()">
          <option value="">Select Leave Type</option>
          <option value="personal">Leave on Personal/Medical Grounds</option>
          <option value="duty">Leave on Duty</option>
        </select>
      </div>

      <!-- Basic Information -->
      <div class="form-group">
        <label for="name">Name of the Student</label>
        <input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" required />
      </div>

      <div class="form-group">
        <label for="enrollment">Enrollment Number</label>
        <input type="text" id="enrollment" name="enrollment" value="<?php echo $student['registration_number']; ?>" required onchange="setYearOfStudy()" />
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="<?php echo $student['email']; ?>" required />
      </div>

      <div class="form-group">
       <label for="year_of_study">Year of Study</label>
       <select id="year_of_study" name="year_of_study" required>
        <option value="">Select Year</option>
        <option value="1st Year">1st Year</option>
        <option value="2nd Year">2nd Year</option>
        <option value="3rd Year">3rd Year</option>
        <option value="4th Year">4th Year</option>
      </select>
      </div>
      <div class="form-group">
        <label for="department">Department</label>
        <select id="department" name="department" required>
          <option value="">Select Department</option>
          <option value="CSE" <?php echo ($student['department'] === 'CSE') ? 'selected' : ''; ?>>Computer Science Engineering</option>
          <option value="ECE" <?php echo ($student['department'] === 'ECE') ? 'selected' : ''; ?>>Electronics and Communication Engineering</option>
          <option value="EEE" <?php echo ($student['department'] === 'EEE') ? 'selected' : ''; ?>>Electrical and Electronics Engineering</option>
          <option value="MECH" <?php echo ($student['department'] === 'MECH') ? 'selected' : ''; ?>>Mechanical Engineering</option>
          <option value="CIVIL" <?php echo ($student['department'] === 'CIVIL') ? 'selected' : ''; ?>>Civil Engineering</option>
          <option value="IT" <?php echo ($student['department'] === 'IT') ? 'selected' : ''; ?>>Information Technology</option>
          <option value="CHEM" <?php echo ($student['department'] === 'CHEM') ? 'selected' : ''; ?>>Chemical Engineering</option>
        </select>
      </div>

      <div class="form-group">
        <label>Programme</label>
        <div class="radio-group">
          <label><input type="radio" name="programme" value="B.Tech" required /> B.Tech</label>
          <label><input type="radio" name="programme" value="M.Tech" /> M.Tech</label>
          <label><input type="radio" name="programme" value="M.C.A" /> M.C.A</label>
          <label><input type="radio" name="programme" value="M.Sc" /> M.Sc</label>
          <label><input type="radio" name="programme" value="M.Phil" /> M.Phil</label>
          <label><input type="radio" name="programme" value="MBA" /> MBA</label>
        </div>
      </div>

      <div class="form-group">
        <label for="branch">Branch/Specialization</label>
        <input type="text" id="branch" name="branch" required />
      </div>

      <div class="form-group">
        <label for="class">Class/Section</label>
        <input type="text" id="class" name="class" required />
      </div>

      <!-- Leave on Personal/Medical Grounds Section -->
      <div id="personal_leave_section" class="section hidden">
        <div class="section-title">Leave on Personal/Medical Grounds</div>
        <div class="form-group">
          <label for="personal_from_date">From Date</label>
          <input type="date" id="personal_from_date" name="personal_from_date" />
        </div>

        <div class="form-group">
          <label for="personal_to_date">To Date</label>
          <input type="date" id="personal_to_date" name="personal_to_date" />
        </div>

        <div class="form-group">
          <label for="personal_reason">Reason for Leave</label>
          <textarea id="personal_reason" name="personal_reason" rows="4"></textarea>
        </div>

        <div class="form-group">
          <label for="personal_days_availed">Number of days of leave already availed</label>
          <input type="number" id="personal_days_availed" name="personal_days_availed" min="0" />
        </div>
      </div>

      <!-- Leave on Duty Section -->
      <div id="duty_leave_section" class="section hidden">
        <div class="section-title">Leave on Duty</div>
        <div class="form-group">
          <label for="duty_from_date">From Date</label>
          <input type="date" id="duty_from_date" name="duty_from_date" />
        </div>

        <div class="form-group">
          <label for="duty_to_date">To Date</label>
          <input type="date" id="duty_to_date" name="duty_to_date" />
        </div>

        <div class="form-group">
          <label for="duty_reason">Reason for Leave</label>
          <textarea id="duty_reason" name="duty_reason" rows="4"></textarea>
        </div>

        <div class="form-group">
          <label for="duty_days_availed">Number of days of on duty leave already availed</label>
          <input type="number" id="duty_days_availed" name="duty_days_availed" min="0" max="7" />
        </div>
      </div>

      <!-- Document Upload Section -->
      <div class="section">
        <div class="section-title">Required Documents</div>
        <div class="upload-section">
          <div class="upload-box">
            <label for="parent_sign">Parent/Guardian Signature</label>
            <input
              type="file"
              id="parent_sign"
              name="parent_sign"
              accept=".pdf,.jpg,.jpeg,.png"
              required
            />
            <div class="file-requirements">Accepted formats: PDF, JPG, JPEG, PNG (Max: 5MB)</div>
            <?php if (isset($errors['parent_sign'])): ?>
              <div class="error-message"><?php echo $errors['parent_sign']; ?></div>
            <?php endif; ?>
            <p>Upload scanned copy of parent's signature with date</p>
          </div>

          <div class="upload-box">
            <label for="student_sign">Student Signature</label>
            <input
              type="file"
              id="student_sign"
              name="student_sign"
              accept=".pdf,.jpg,.jpeg,.png"
              required
            />
            <div class="file-requirements">Accepted formats: PDF, JPG, JPEG, PNG (Max: 5MB)</div>
            <?php if (isset($errors['student_sign'])): ?>
              <div class="error-message"><?php echo $errors['student_sign']; ?></div>
            <?php endif; ?>
            <p>Upload scanned copy of your signature with date</p>
          </div>

          <div class="upload-box">
            <label for="advisor_letter">Class Advisor Approval Letter</label>
            <input
              type="file"
              id="advisor_letter"
              name="advisor_letter"
              accept=".pdf"
              required
            />
            <div class="file-requirements">Accepted format: PDF only (Max: 5MB)</div>
            <?php if (isset($errors['advisor_letter'])): ?>
              <div class="error-message"><?php echo $errors['advisor_letter']; ?></div>
            <?php endif; ?>
            <p>Upload signed approval letter from Class Advisor</p>
          </div>

          <div class="upload-box">
            <label for="hod_letter">HOD Approval Letter</label>
            <input
              type="file"
              id="hod_letter"
              name="hod_letter"
              accept=".pdf"
              required
            />
            <div class="file-requirements">Accepted format: PDF only (Max: 5MB)</div>
            <?php if (isset($errors['hod_letter'])): ?>
              <div class="error-message"><?php echo $errors['hod_letter']; ?></div>
            <?php endif; ?>
            <p>Upload signed approval letter from HOD</p>
          </div>
        </div>
      </div>

      <p class="note">
        * The student shall enclose necessary Medical Certificate for leave availed on
        medical grounds
      </p>
      <p class="note">
        * Prior permission of HoD is required for availing ONDUTY Leave. A maximum of 7 days of
        OD per semester is permissible.
      </p>
      <p class="notebold">NOTE: Permission letter to be enclosed with this form</p>

      <button type="submit">Submit Application</button>
    </form>
  </div>

  <script>
    function showLeaveForm() {
      const leaveType = document.getElementById("leave_type").value;
      const personalSection = document.getElementById("personal_leave_section");
      const dutySection = document.getElementById("duty_leave_section");

      // Hide both sections first
      personalSection.classList.add("hidden");
      dutySection.classList.add("hidden");

      // Show the selected section
      if (leaveType === "personal") {
        personalSection.classList.remove("hidden");
      } else if (leaveType === "duty") {
        dutySection.classList.remove("hidden");
      }

      // Reset form fields when switching between leave types
      if (leaveType === "personal") {
        resetFormFields("duty");
      } else if (leaveType === "duty") {
        resetFormFields("personal");
      }
    }

    function resetFormFields(type) {
      document.getElementById(`${type}_from_date`).value = "";
      document.getElementById(`${type}_to_date`).value = "";
      document.getElementById(`${type}_reason`).value = "";
      document.getElementById(`${type}_days_availed`).value = "";
    }

    // Add client-side file validation
    document.querySelectorAll('input[type="file"]').forEach(function(fileInput) {
      fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileSize = file.size;
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        
        // Get file extension
        const fileName = file.name;
        const fileExt = fileName.split('.').pop().toLowerCase();
        
        let acceptedFormats = [];
        if (e.target.id === 'advisor_letter' || e.target.id === 'hod_letter') {
          acceptedFormats = ['pdf'];
        } else {
          acceptedFormats = ['pdf', 'jpg', 'jpeg', 'png'];
        }

        // Check file size
        if (fileSize > maxSize) {
          alert('File size exceeds 5MB limit for ' + e.target.id.replace('_', ' '));
          e.target.value = ''; // Clear the file input
          return;
        }

        // Check file format
        if (!acceptedFormats.includes(fileExt)) {
          alert('Invalid file format. Allowed formats: ' + acceptedFormats.join(', '));
          e.target.value = ''; // Clear the file input
        }
      });
    });

    function setYearOfStudy() {
        const enrollment = document.getElementById('enrollment').value;
        const yearSelect = document.getElementById('year_of_study');
        
        if (enrollment.length >= 2) {
            const yearPrefix = enrollment.substring(0, 2);
            const currentYear = new Date().getFullYear().toString().substring(2);
            console.log(currentYear, yearPrefix);
            
            // Calculate year of study based on enrollment year
            let yearOfStudy;
            if (yearPrefix === currentYear) {
                yearOfStudy = "1st Year";
            } else if (yearPrefix === (parseInt(currentYear) - 2).toString()) {
                yearOfStudy = "2nd Year";
            } else if (yearPrefix === (parseInt(currentYear) - 3).toString()) {
                yearOfStudy = "3rd Year";
            } else if (yearPrefix === (parseInt(currentYear) - 4).toString()) {
                yearOfStudy = "4th Year";
            }
            
            // Set the selected option
            if (yearOfStudy) {
                for (let i = 0; i < yearSelect.options.length; i++) {
                    if (yearSelect.options[i].value === yearOfStudy) {
                        yearSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        }
    }

    // Call setYearOfStudy when the page loads if enrollment number is already filled
    document.addEventListener('DOMContentLoaded', function() {
        const enrollment = document.getElementById('enrollment').value;
        if (enrollment) {
            setYearOfStudy();
        }
    });
  </script>
</body>
</html>