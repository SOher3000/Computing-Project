<?php
include_once 'db/db.php';
include_once 'header.html';
include_once 'reducedMenu.php';

class LoginHandler
{
    private $db;
    private $error;

    public function __construct($db)
    {
        $this->db = $db;
        $this->error = '';
    }

    public function handleLogin()
    {
        if (isset($_POST['submitted'])) {
            $username = $this->sanitizeInput($_POST['Username']);
            $password = $this->sanitizeInput($_POST['password']);

            if (!empty($username) && !empty($password)) {
                if ($this->authenticateUser($username, $password)) {
                    $this->startUserSession($username);
                    header('Location: index.php');
                    exit();
                } else {
                    $this->error = 'Query failed - Please try again';
                }
            } else {
                $this->error = 'Please fill both';
            }
        }
    }

    private function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }

    private function authenticateUser($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE name = :username AND password = MD5(:password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        return $stmt->rowCount() === 1;
    }

    private function startUserSession($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE name = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userData = $stmt->fetch();

        session_start();
        $_SESSION['userid'] = $userData["userid"];
        $_SESSION['user'] = $username;
    }

    public function displayError()
    {
        if (!empty($this->error)) {
            echo "<div class='error'>{$this->error}</div>";
        }
    }
}

try {
    $db = new PDO('mysql:host=localhost;dbname=your_database_name', 'your_username', 'your_password');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $loginHandler = new LoginHandler($db);
    $loginHandler->handleLogin();
    $loginHandler->displayError();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>
<div id='content'>
    <h3>Login</h3>
    <form action='' method='POST'>
        Username&nbsp;<input type='text' name='Username'/><br/>
        Password&nbsp;<input type='password' name='password'/><br/>
        <input type='hidden' name='submitted' value='true'/>
        <input type='submit' value='Login'/>
    </form>
</div>
