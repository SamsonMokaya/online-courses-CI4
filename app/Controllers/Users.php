<?php

namespace App\Controllers;

use App\Models\UsersModel;

use App\Models\CoursesModel;

use App\Models\SubscriptionModel;

use MongoDB\BSON\ObjectId;

use LeviZwannah\MpesaSdk\Mpesa; 
class Users extends BaseController
{
    
    public function index()
    {
        // Fetch all courses
        $coursesModel = model(CoursesModel::class);
        $courses = $coursesModel->getAllCourses();

        // Check if the 'user_id' session variable exists to determine if the user is logged in
        $loggedIn = session()->has('user_id');

        // Get the user's activation status
        $isActive = $this->getUserActivationStatus(); // You need to implement this method

        // Pass the courses, logged in status, and activation status to the landingPage view
        echo view('templates/header', ['loggedIn' => $loggedIn, 'isActive' => $isActive]);
        echo view('landingPage', ['courses' => $courses, 'loggedIn' => $loggedIn, 'isActive' => $isActive]);
        echo view('templates/footer');

    }

    public function signUp()
    {
        echo view('SignUpPage');
    }

    public function signIn()
    {
        echo view('SignInPage');
    }

    public function sendResetToken()
    {
        echo view('ResetTokenPage');
    }

    public function resetPassword()
    {
        echo view('PasswordResetPage');
    }

    

    public function logout()
    {
        // Destroy the session to log the user out
        session()->destroy();

        // Redirect to the landing page
        return redirect()->to('/');
    }

    public function signInUser()
    {
        $model = model(UsersModel::class);

        if ($this->request->getMethod() === 'post' && $this->validate([
                'email' => 'required|min_length[1]|max_length[255]',
                'password' => 'required|min_length[1]|max_length[255]',
            ])) {
            $user = $model->getUserByEmailAndPassword(
                $this->request->getPost('email'),
                $this->request->getPost('password')
            );

            if ($user) {
                // User found, store user details in session
                session()->set('user_id', $user['_id']);  // Set 'user_id' instead of 'isLoggedIn'
                session()->set('user', $user);
                session()->set('isLoggedIn', true);

                return redirect()->to('/');
            } else {
                // Handle the case where getUserByEmailAndPassword returns an error or credentials are invalid
                return redirect()->to('/signin')->withInput()->with('error', 'Invalid email or password');
            }
        } else {
            // Validation failed, redirect them back to the sign-in page
            return redirect()->to('/signin')->withInput()->with('errors', $this->validator->getErrors());
        }
    }



    public function registerUser()
    {
        $model = model(UsersModel::class);

        if ($this->request->getMethod() === 'post' && $this->validate([
                'name' => 'required|min_length[1]|max_length[255]',
                'email' => 'required|min_length[1]|max_length[255]',
                'password' => 'required|min_length[1]|max_length[255]',
            ])) {
            $result = $model->insertUser(
                $this->request->getPost('name'),
                $this->request->getPost('email'),
                $this->request->getPost('password'),
            );

            if ($result === true) {
                // Redirect to the sign-in page after successful registration
                return redirect()->to('/signin');
            } else {
                // Handle the case where insertUser returns an error
                return redirect()->to('/register')->withInput()->with('error', $result['error']);
            }
        } else {
            // Validation failed, redirect them back to the register user page
            return redirect()->to('/register')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    // Add this function to your Users controller
    public function updateUserStatus()
    {
        $userId = session()->get('user_id');
        

        if (!$userId) {
            // User is not logged in, handle as needed
            return redirect()->to('/')->with('error', "User not logged in.");
        }

        $usersModel = new UsersModel();

        // Update the user status
        $result = $usersModel->updateUserStatus($userId, $this->request->getPost('status'),);

        if ($result === true) {
            $newStatus = $this->request->getPost('status');

            // Redirect to the appropriate page or handle as needed
            if ($newStatus == 'active') {
                return redirect()->to('/')->with('success', "Account activated successfully.");
            } elseif ($newStatus == 'inactive') {
                return redirect()->to('/')->with('success', "Account deactivated successfully.");
            }
        } else {
            // Handle the case where updateUserStatus returns an error
            return redirect()->to('/')->with('error', "Error updating user status.");
        }
    }


  
    private function getUserActivationStatus()
    {
        $userId = session()->get('user_id');
        $userModel = model(UsersModel::class);
        $user = $userModel->getUserById($userId);

        return ($user && isset($user['status'])) ? ($user['status'] === 'active') : false;
    }


// public function processPayment()
// {
//     try {
//         echo "Reached the beginning of processPayment function<br>";

//         $package = $this->request->getPost('package');
//         $phone = $this->request->getPost('phone');
//         $userId = session()->get('user_id');

//         echo "Package: $package, Phone: $phone, UserId: $userId<br>";

//         // Fetch user subscription
//         $subscriptionModel = new SubscriptionModel();
//         $subscription = $subscriptionModel->getSubscription($userId);

//         echo "Fetched user subscription<br>";

//         // Check if the user already has an active subscription
//         if ($subscription !== null) {
//             echo "User already has an active subscription. Redirecting...<br>";
//         }

//         // Use .env or any other configuration method to get consumer key and secret
//         $consumerKey = getenv('CONSUMER_KEY');
//         $consumerSecret = getenv('CONSUMER_SECRET');
//         $businessShortCode = getenv('SHORT_CODE');
//         $initiatorName = getenv('INITIATOR_NAME');
//         $securityCredential = getenv('SECURITY_CREDENTIAL');
        

//         echo "Initialized Mpesa SDK with Consumer Key: $consumerKey, Consumer Secret: $consumerSecret<br>";

//         // Initialize the Mpesa SDK
//         $mpesa = new Mpesa();
//         $mpesa->configure([
//             'key' => $consumerKey,
//             'secret' => $consumerSecret,
//             'code' => $businessShortCode,
//             'initiator' => $initiatorName,
//             'credential' => $securityCredential,
//         ]);

//         echo "Mpesa SDK initialized<br>";

//         // Process payment with Mpesa SDK
//         $payment = $mpesa->b2c()
//             ->amount($package)
//             ->phone($phone)
//             ->resultUrl(base_url('/payment/result')) // Adjust the result URL as needed
//             ->timeoutUrl(base_url('/payment/timeout')) // Adjust the timeout URL as needed
//             ->pay();

//         echo "Payment processed with Mpesa SDK<br>";

//         // Check if the payment was accepted
//         if (!$payment->accepted()) {
//             // Payment failed
//             $error = $payment->error();
//             echo "Payment failed: $error->code - $error->message<br>";
//         }

//         // Payment successful
//         echo "Payment successful<br>";

//         // Save the subscription details to your MongoDB subscriptions collection
//         $subscriptionModel->createSubscription($userId, $package);

//         echo "Subscription details saved to MongoDB<br>";

//         return redirect()->to('/')->with('success', "Payment successful. Subscription activated.");
//     } catch (Exception $e) {
//         echo "Exception caught: " . $e->getMessage() . "<br>";
//         return redirect()->to('/')->with('error', $e->getMessage());
//     }
// }



}
