<?php
class ProductType {
    public const NO_ID_PROVIDED = -1;

    public static function createFromData($data) {
        return new self(
            $data['product_id'] ?? self::NO_ID_PROVIDED,
            $data['name'] ?? '',
            $data['description'] ?? '',
            filter_var($data['category_id'] ?? 1, FILTER_VALIDATE_INT),
            filter_var($data['is_available'] ?? false, FILTER_VALIDATE_BOOLEAN),
            $data['image'] ?? ''
        );
    }

    private int $id;
    private string $name;
    private string $description;
    private int $categoryId;
    private bool $isAvailable;
    private string $image;

    public function __construct(
        int $id, 
        string $name, 
        string $description, 
        int $categoryId,
        bool $isAvailable,
        string $image = ''
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->isAvailable = $isAvailable;
        $this->image = $image;
    }

    public function toArray(): array {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category_id'=> $this->categoryId,
            'is_available' => $this->isAvailable,
        ];
        
        // Only include image data if it exists
        if (!empty($this->image)) {
            try {
                $data['image'] = $this->getImageBase64();
                $data['image_type'] = $this->getImageType();
            } catch (Exception $e) {
                // Image data could not be processed
                error_log("Error processing image data: " . $e->getMessage());
            }
        }
        
        return $data;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getCategoryId(): int {
        return $this->categoryId;
    }

    public function isAvailable(): bool {
        return $this->isAvailable;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function getImageBase64(): string {
        if (empty($this->image)) {
            return '';
        }
        
        // Check if the image is already base64 encoded
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $this->image)) {
            return $this->image;
        }
        
        return base64_encode($this->image);
    }

    public function getImageType(): string {
        if (empty($this->image)) {
            return '';
        }
        
        try {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_buffer($finfo, $this->image, FILEINFO_MIME_TYPE);
            finfo_close($finfo);
            
            // Extract the image type from the MIME type
            $parts = explode('/', $mime);
            return $parts[1] ?? 'unknown';
        } catch (Exception $e) {
            error_log("Failed to determine image type: " . $e->getMessage());
            return 'unknown';
        }
    }
    
    public function validate(): array {
        $errors = [];
        
        if (empty($this->name)) {
            $errors[] = "Product name is required";
        }
        
        return $errors;
    }
}
?>
