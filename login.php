<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$host = 'localhost';
$dbname = '4ps_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username_input = trim($_POST['username']);
        $password_input = $_POST['password'];

        // Add some debugging
        error_log("Login attempt for username: " . $username_input);

        $stmt = $pdo->prepare("
            SELECT id, name, email, username, password, status, mobile, address, family_size, id_number, role 
            FROM user 
            WHERE username = ?
        ");
        $stmt->execute([$username_input]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // More debugging
            error_log("User found: " . print_r($user, true));

            if ($user['status'] === 'inactive') {
                $_SESSION['error'] = "Your account is inactive. Please contact support.";
                
                // Add debugging
                error_log("Inactive account error set");
                
                header("Location: index.php");
                exit();
            }

            if (password_verify($password_input, $user['password'])) {
                // Successful login logic remains the same
                $_SESSION['user_id'] = $user['id'];
                // ... other session variables ...

                switch ($_SESSION['role']) {
                    case 'super admin':
                        header("Location: superadmin.php");
                        break;
                    case 'admin':
                        header("Location: secadmin.php");
                        break;
                    case 'user':
                        header("Location: userpagehome.php");
                        break;
                    default:
                        $_SESSION['error'] = "Invalid role. Please contact the administrator.";
                        header("Location: index.php");
                }
                exit();
            } else {
                $_SESSION['error'] = "Incorrect password. Please try again.";
                
                // Add debugging
                error_log("Incorrect password error set");
                
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Username not found. Please try again.";
            
            // Add debugging
            error_log("Username not found error set");
            
            header("Location: index.php");
            exit();
        }
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred. Please try again later.";
    header("Location: index.php");
    exit();
}