<?php
require_once __DIR__ .'/DatabaseConnection.php';

class AdminUser {
    
    public static function login(AdminUser $adminUser): bool {
        $dbConn = DatabaseConnection::createConnection();
        $stmt = $dbConn->prepare("SELECT * FROM admin_users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $adminUser->username, $adminUser->password);
        $stmt->execute();
        $result = $stmt->get_result();
        mysqli_close($dbConn);

        if ($result->num_rows === 1) {
            $_SESSION['admin_user'] = $adminUser->username;
            return true;
        }

        return false;
    }

    public static function logout(): void {
        session_destroy();
    }

    private string $username;
    private string $password;

    public function __construct(string $username, string $password) {
        $this->username = $username;
        $this->password = $password;
    }
}

?>
