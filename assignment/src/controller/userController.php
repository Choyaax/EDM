<?php
class userController
{
    public function login($username, $password) {
        // Log the login attempt
        error_log("Login attempt for username: " . $username);

        // Fetch user from the database
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, return success
            return json_encode([
                'success' => true,
                'user_id' => $user['id'],
                'message' => 'Login successful'
            ]);
        } else {
            // Invalid credentials
            return json_encode(['success' => false, 'message' => 'Invalid username or password']);
        }
    }

    public function register(){ 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate input
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                // Handle error: All fields are required
                return "All fields are required";
            }

            if ($password !== $confirm_password) {
                // Handle error: Passwords don't match
                return "Passwords don't match";
            }

            // Additional validation (e.g., email format, password strength) can be added here

            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Create user model and save to database
            $user = new User();
            $user->username = $username;
            $user->email = $email;
            $user->password = $hashed_password;

            if ($user->save()) {
                // Registration successful
                // Redirect to login page or dashboard
                header('Location:/login.php');
                exit;
            } else {
                // Handle error: Unable to save user
                return "Unable to save user";
            }
        }

        // If not a POST request, display the registration form
        include 'public/view/register.php';
        return "register";
    }

    public function update(){
   //butangan 
    }

    public function delete(){
  //butangan pa  //CRUD 
    }
}
