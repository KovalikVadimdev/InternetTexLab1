<?php

$host = "127.0.0.1";
$dbname = "lb_pdo_lessons";
$username = "root";
$password = "password";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "<table style='text-align: center; border: 1px solid black; border-collapse: collapse; margin: auto'>";
    echo "<tr>";
    echo "<th>Name group</th>";
    echo "<th>Day of the week</th>";
    echo "<th>Number of classes</th>";
    echo "<th>Audience</th>";
    echo "<th>Discipline</th>";
    echo "<th>Type of class</th>";
    echo "<th>Name of the teacher</th>";
    echo "</tr>";
    if (isset($_GET['submit_btn'])) {
        $sql = "SELECT DISTINCT group_student.title, lesson.week_day, lesson.lesson_number, lesson.auditorium, lesson.disciple, lesson.type, teacher.name
            FROM group_student 
            INNER JOIN lesson_groups ON group_student.ID_Groups = lesson_groups.FID_Groups 
            INNER JOIN lesson ON lesson_groups.FID_Lesson2 = lesson.ID_Lesson 
            INNER JOIN lesson_teacher ON lesson.ID_Lesson = lesson_teacher.FID_Lesson1 
            INNER JOIN teacher ON lesson_teacher.FID_Teacher = teacher.ID_Teacher 
            WHERE lesson.auditorium = :name_auditorium";

        $prepare = $pdo->prepare($sql);
        $name_auditorium = $_GET["name_auditorium"];
        $prepare->bindParam(':name_auditorium', $name_auditorium);
        $executed = $prepare->execute();
        $elementDB = $prepare->fetchAll(PDO::FETCH_ASSOC);

        foreach ($elementDB as $element) {
            echo "<tr>";
            echo "<td>" . $element['title'] . "</td>";
            echo "<td>" . $element["week_day"] . "</td>";
            echo "<td>" . $element["lesson_number"] . "</td>";
            echo "<td>" . $element["auditorium"] . "</td>";
            echo "<td>" . $element["disciple"] . "</td>";
            echo "<td>" . $element["type"] . "</td>";
            echo "<td>" . $element["name"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}