<?php   										// Opening PHP tag
	// Include the database connection script
	require 'includes/database-connection.php';

	function search_course_by_name(PDO $pdo, string $courseName){
		$sql = "SELECT * 
			FROM courses_taken 
			WHERE courseName LIKE :courseName ;";
		
		$courses = pdo($pdo, $sql, ['courseName' => "%$courseName%"])->fetchAll();		
		return $courses;
	}
	function search_course_by_code(PDO $pdo, string $code){
		$sql = "SELECT *
			FROM courses_taken
			WHERE courseID LIKE :courseID;";
		
		$courses = pdo($pdo, $sql, ['courseID' => "%$code%"])->fetchAll();		
		return $courses;
	}
	function search_course_by_school(PDO $pdo, string $school){
		$sql = "SELECT *
			FROM courses_taken
			WHERE school LIKE :school";
		
		$courses = pdo($pdo, $sql, ['school' => "%$school%"])->fetchAll();		
		return $courses;
	}
	
	// Check if the request method is POST (i.e, form submitted)
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$searchBy = $_POST['searchBy'] ?? "courseID";
		$courseID = $_POST['courseID'] ?? "";
		
		// Check which radio button is selected
		if ($searchBy == "courseID") {
			// Code for searching by course ID
			$courses = search_course_by_code($pdo, $course);
		} elseif ($searchBy == "name") {
			// Code for searching by course name
			$courses = search_course_by_name($pdo, $course);
		} elseif ($searchBy == "school") {
			// Code for searching by school course was taken at
			$courses = search_course_by_school($pdo, $course);
		}
	}
	else{
		$course = "";
		$searchBy = "courseID";
	}
 ?> 

<!DOCTYPE html>
<html>
<head>
    <title>Nikki's Programming Portfolio</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header>
    <div class="logo">Nicole Bubencik</div>
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="resume.html">Resume</a></li>
            <li><a href="projects.html">Projects</a></li>
        </ul>
    </nav>
</header>
<main>
    <div style="width:40%; margin:auto; text-align:center; margin-bottom:10px;">
        <div>
            <h1>Courses</h1>
            <form action="courses.php" method="POST">
                <label for="searchBy">Search By:</label>
                <div class="form-group" style="display:flex;">
                    <input type="radio" id="courseID" name="searchBy" value="courseID" <?php if ($searchBy == "courseID") echo "checked"; ?>>
                    <label for="courseID">Course ID</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="courseName" name="searchBy" value="courseName" <?php if ($searchBy == "courseName") echo "checked"; ?>>
                    <label for="courseName">Course Name</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="school" name="searchBy" value="school" <?php if ($searchBy == "school") echo "checked"; ?>>
                    <label for="school">School</label>
                </div>
                <div class="form-group" style="width:100%;">
                    <input type="text" id="courseID" name="courseID" value="<?php echo htmlspecialchars($course); ?>">
                </div>
                <button type="submit">Search Course</button>
            </form>
        </div>

        <div class="container">
            <div class="item">
                <?php if (isset($courses) && !empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <h2><?php echo htmlspecialchars($course['courseName']); ?></h2>
                        <h4><?php echo htmlspecialchars($course['school']); ?></h4>
		    	<h4><?php echo htmlspecialchars($course['courseID']); ?></h4>
                        <p><?php echo htmlspecialchars($course['description']); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No courses found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<footer>
    <div class="footer-content">
        <div class="footer-icons">
            <a href="mailto: nikkibubencik@gmail.com" style="text-decoration: none;">
                <img src="icons/email.png" alt="email" class="icon">
            </a>
            <a href="tel:774-613-1059" style="text-decoration: none;">
                <img src="icons/phone.png" alt="phone number: 774 613 1059" class="icon">
            </a>
            <a href="https://www.linkedin.com/in/nicole-bubencik" style="text-decoration: none;">
                <img src="icons/linkedin.png" alt="linkedin" class="icon">
            </a>
            <a href="https://github.com/nikkiBubencik/nikkiBubencik.github.io/tree/dashboard" style="text-decoration: none;">
                <img src="icons/github.png" alt="github" class="icon">
            </a>
        </div>
        <div class="footer-download">
            <a href="Nicole_Bubencik_Resume.png" class="resume_td" download>Download Resume</a>
        </div>
    </div>
</footer>
</body>
</html>
