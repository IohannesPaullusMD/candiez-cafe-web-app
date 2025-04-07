<?php

require_once __DIR__ . '/DatabaseConnection.php';

class SiteDetails {

    public static function getImageBase64(string $image): string {
        if (empty($image)) {
            return '';
        }
        
        // Check if the image is already base64 encoded
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $image)) {
            return $image;
        }
        
        return base64_encode($image);
    }

    public static function getImageType(string $image): string {
        if (empty($image)) {
            return '';
        }
        
        try {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_buffer($finfo, $image, FILEINFO_MIME_TYPE);
            finfo_close($finfo);
            
            // Extract the image type from the MIME type
            $parts = explode('/', $mime);
            return $parts[1] ?? 'unknown';
        } catch (Exception $e) {
            error_log("Failed to determine image type: " . $e->getMessage());
            return 'unknown';
        }
    }

    private mysqli $dbConn;

    public function __construct() {
        $this->dbConn = DatabaseConnection::createConnection();
    }

    public function __destruct() {
        if ($this->dbConn) {
            mysqli_close($this->dbConn);
        }
    }

    public function getHomePageDetails(): array {
        $sql = "SELECT * FROM home_page WHERE id = 1";
        $stmt = mysqli_prepare($this->dbConn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $text = $row['text'] ?? '';
            $image = $row['image'] ?? '';

            return [
                'text' => $text,
                'image' => self::getImageBase64($image),
                'image_type' => self::getImageType($image)
            ];
        }

        return [];
    }

    public function getAboutPageDetails(): array {
        $sql = "SELECT * FROM about_page WHERE id = 1";
        $stmt = mysqli_prepare($this->dbConn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $text = $row['text'] ?? '';

            return [
                'text' => $text
            ];
        }

        return [];
    }

    public function getContactPageDetails(): array {
        $sql = "SELECT * FROM contact_page";
        $stmt = mysqli_prepare($this->dbConn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $contacts = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $contacts[] = [
                    'contact' => $row['contact'] ?? '',
                    'contact_details' => $row['contact_details'] ?? ''
                ];
            }
        }

        return $contacts;
    }
}

?>
