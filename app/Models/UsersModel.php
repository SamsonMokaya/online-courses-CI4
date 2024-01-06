<?php

namespace App\Models;

use App\Libraries\DatabaseConnector;


class UsersModel {
    private $collection;

    function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->users;
    }

    function getUserByEmailAndPassword($email, $password) {
        try {
            $user = $this->collection->findOne(['email' => $email, 'password' => $password]);

            return $user;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            return ['error' => 'Error while fetching user with email and password: ' . $ex->getMessage()];
        }
    }

    function isEmailUnique($email) {
        try {
            $existingUser = $this->collection->findOne(['email' => $email]);

            return empty($existingUser); // If empty, email is unique
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            return ['error' => 'Error while checking email uniqueness: ' . $ex->getMessage()];
        }
    }

    function insertUser($name, $email, $password) {
        if (!$this->isEmailUnique($email)) {
            return ['error' => 'Email is not unique, a user with this email already exists.'];
        }

        try {
            $insertOneResult = $this->collection->insertOne([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            if ($insertOneResult->getInsertedCount() == 1) {
                return true;
            }

            return false;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            return ['error' => 'Error while creating a user: ' . $ex->getMessage()];
        }
    }
}
