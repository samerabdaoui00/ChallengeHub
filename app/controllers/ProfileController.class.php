<?php
require_once(__DIR__ . "/../models/User.class.php");
require_once(__DIR__ . "/../models/Challenge.class.php");
require_once(__DIR__ . "/../models/Participation.class.php");

// This controller manages the profile page
// From here a user can update their info, delete their account or log out
class ProfileController
{
    // Redirect to login if not connected
    private function checkLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }
    }

    // Main profile page — handles 3 different POST actions based on which button was clicked
    public function index(): void
    {
        $this->checkLogin();

        // build the User object from session data
        // we pass the user_id as the password argument (it's numeric so it won't be hashed)
        $user    = new User($_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_id']);
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['update'])) {
                // try to update name, email, and optionally password
                if ($user->update($_POST)) {
                    $message = "Profile updated successfully ✅";
                    // sync session values with the new ones
                    $_SESSION['user_name']  = $_POST['name'];
                    $_SESSION['user_email'] = $_POST['email'];
                } else {
                    $message = "Update failed — check your current password ❌";
                }

            } elseif (isset($_POST['delete'])) {
                // delete the account and log out (logout is called inside delete())
                $user->delete();
                exit();

            } elseif (isset($_POST['logout'])) {
                $user->logout();
                exit();
            }
        }

        // load the user's challenges and participations to display on the profile
        $myChallenges     = Challenge::getByUser($_SESSION['user_id']);
        $myParticipations = Participation::getByUser($_SESSION['user_id']);

        require_once(__DIR__ . "/../views/user/profile.php");
    }
}
?>
