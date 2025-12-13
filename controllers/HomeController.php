<?php
require_once "models/Course.php";

class HomeController {

    public function index() {
        $courseModel = new Course();
        $courses = $courseModel->getAllCourses();  // lấy toàn bộ khóa học

        require "views/home/index.php";
    }
}
