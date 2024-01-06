<?php

namespace App\Models;

use App\Libraries\DatabaseConnector;
use MongoDB\BSON\ObjectID;

class SubscriptionModel {
    private $collection;

    public function __construct() {
        $connection = new DatabaseConnector();
        $database = $connection->getDatabase();
        $this->collection = $database->subscriptions;
    }

    public function createSubscription($userId, $package, $phone, $amount) {
        try {
            $startDate = new \DateTime();
            $endDate = (clone $startDate)->modify('+1 year');

            $subscription = [
                'user_id' => new ObjectID($userId),
                'package' => $package,
                'phone' => $phone,
                'start_date' => $startDate->format('Y-m-d H:i:s'),
                'end_date' => $endDate->format('Y-m-d H:i:s'),
                'amount' => $amount,
            ];

            $this->collection->insertOne($subscription);

            return $subscription;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            return ['error' => 'Error while creating subscription: ' . $ex->getMessage()];
        }
    }

    /**
     * Get the subscription details for a user.
     *
     * @param string $userId
     * @return array|null
     */
    public function getSubscription($userId) {
        try {
            $subscription = $this->collection->findOne(['user_id' => new ObjectID($userId)]);

            if ($subscription === null) {
                // No subscription found for the user
               return ['error' => 'No subscription found for the user'];
            }

            return $subscription;
        } catch (\MongoDB\Exception\RuntimeException $ex) {
            return ['error' => 'Error while fetching subscription: ' . $ex->getMessage()];
        }
    }
}
