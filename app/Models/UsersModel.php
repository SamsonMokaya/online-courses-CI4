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
                'status' => 'active',
            ]);

            if ($insertOneResult->getInsertedCount() == 1) {
                return true;
            }

            return false;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            return ['error' => 'Error while creating a user: ' . $ex->getMessage()];
        }
    }

    function updateUserStatus($userId, $newStatus) {
        try {
            $updateResult = $this->collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($userId)],
                ['$set' => ['status' => $newStatus]]
            );

            if ($updateResult->getModifiedCount() == 1) {
                return true;
            }

            return false;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            return ['error' => 'Error while updating user status: ' . $ex->getMessage()];
        }
    }


    function getUserById($userId) {
    try {
        $user = $this->collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($userId)]);
        return $user;
    } catch (\MongoDB\Exception\RuntimeException $ex) {
        return ['error' => 'Error while fetching user by ID: ' . $ex->getMessage()];
    }
}

}
