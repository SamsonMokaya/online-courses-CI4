<?php

namespace App\Models;

use App\Libraries\DatabaseConnector;

class CoursesModel {
    private $collection;

    function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->courses;
    }

    function getAllCourses() {
        try {
            // Fetch all courses
            $courses = $this->collection->find();

            // Convert the MongoDB cursor to an array for easier usage
            $coursesArray = iterator_to_array($courses);

            return $coursesArray;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            // Handle exceptions - you might want to log the error or handle it differently
            throw new \RuntimeException('Error while fetching courses: ' . $ex->getMessage());
        }
    }
}
