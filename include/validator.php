<?php
class Validator {
    private $data;
    private $errors = [];
    private $rules = [];
    private $messages = [];

    public function __construct($data) {
        $this->data = $data;
    }

    public function validate($rules) {
        $this->rules = $rules;
        
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule => $value) {
                $this->validateRule($field, $rule, $value);
            }
        }

        return empty($this->errors);
    }

    private function validateRule($field, $rule, $value) {
        $input = $this->data[$field] ?? null;

        switch ($rule) {
            case 'required':
                if (empty($input) && $input !== '0') {
                    $this->addError($field, 'This field is required');
                }
                break;

            case 'email':
                if (!empty($input) && !filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, 'Please enter a valid email address');
                }
                break;

            case 'min':
                if (!empty($input) && strlen($input) < $value) {
                    $this->addError($field, "This field must be at least {$value} characters long");
                }
                break;

            case 'max':
                if (!empty($input) && strlen($input) > $value) {
                    $this->addError($field, "This field must not exceed {$value} characters");
                }
                break;

            case 'numeric':
                if (!empty($input) && !is_numeric($input)) {
                    $this->addError($field, 'This field must be a number');
                }
                break;

            case 'integer':
                if (!empty($input) && !filter_var($input, FILTER_VALIDATE_INT)) {
                    $this->addError($field, 'This field must be an integer');
                }
                break;

            case 'float':
                if (!empty($input) && !filter_var($input, FILTER_VALIDATE_FLOAT)) {
                    $this->addError($field, 'This field must be a decimal number');
                }
                break;

            case 'url':
                if (!empty($input) && !filter_var($input, FILTER_VALIDATE_URL)) {
                    $this->addError($field, 'Please enter a valid URL');
                }
                break;

            case 'date':
                if (!empty($input) && !strtotime($input)) {
                    $this->addError($field, 'Please enter a valid date');
                }
                break;

            case 'regex':
                if (!empty($input) && !preg_match($value, $input)) {
                    $this->addError($field, 'This field format is invalid');
                }
                break;

            case 'in':
                if (!empty($input) && !in_array($input, $value)) {
                    $this->addError($field, 'This field value is not allowed');
                }
                break;

            case 'not_in':
                if (!empty($input) && in_array($input, $value)) {
                    $this->addError($field, 'This field value is not allowed');
                }
                break;

            case 'same':
                if (!empty($input) && $input !== ($this->data[$value] ?? null)) {
                    $this->addError($field, 'This field must match the ' . $value . ' field');
                }
                break;

            case 'different':
                if (!empty($input) && $input === ($this->data[$value] ?? null)) {
                    $this->addError($field, 'This field must be different from the ' . $value . ' field');
                }
                break;

            case 'unique':
                if (!empty($input)) {
                    $db = Database::getInstance();
                    $result = $db->fetch(
                        "SELECT COUNT(*) as count FROM {$value[0]} WHERE {$value[1]} = ?",
                        [$input],
                        's'
                    );
                    if ($result['count'] > 0) {
                        $this->addError($field, 'This value is already taken');
                    }
                }
                break;

            case 'exists':
                if (!empty($input)) {
                    $db = Database::getInstance();
                    $result = $db->fetch(
                        "SELECT COUNT(*) as count FROM {$value[0]} WHERE {$value[1]} = ?",
                        [$input],
                        's'
                    );
                    if ($result['count'] === 0) {
                        $this->addError($field, 'This value does not exist');
                    }
                }
                break;

            case 'file':
                if (!empty($input) && !isset($_FILES[$field])) {
                    $this->addError($field, 'Please upload a file');
                }
                break;

            case 'image':
                if (!empty($input) && isset($_FILES[$field])) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!in_array($_FILES[$field]['type'], $allowedTypes)) {
                        $this->addError($field, 'Please upload a valid image file');
                    }
                }
                break;

            case 'mimes':
                if (!empty($input) && isset($_FILES[$field])) {
                    if (!in_array($_FILES[$field]['type'], $value)) {
                        $this->addError($field, 'This file type is not allowed');
                    }
                }
                break;

            case 'max_size':
                if (!empty($input) && isset($_FILES[$field])) {
                    if ($_FILES[$field]['size'] > $value) {
                        $this->addError($field, 'File size must not exceed ' . $this->formatBytes($value));
                    }
                }
                break;
        }
    }

    private function addError($field, $message) {
        $this->errors[$field][] = $message;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getFirstError() {
        foreach ($this->errors as $field => $errors) {
            return $errors[0];
        }
        return null;
    }

    public function hasError($field) {
        return isset($this->errors[$field]);
    }

    public function getError($field) {
        return $this->errors[$field][0] ?? null;
    }

    public function sanitize($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitize'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    private function formatBytes($bytes) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}

// Example usage:
/*
$validator = new Validator($_POST);

$rules = [
    'name' => [
        'required' => true,
        'min' => 3,
        'max' => 50
    ],
    'email' => [
        'required' => true,
        'email' => true,
        'unique' => ['users', 'email']
    ],
    'password' => [
        'required' => true,
        'min' => 8,
        'regex' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
    ],
    'confirm_password' => [
        'required' => true,
        'same' => 'password'
    ],
    'age' => [
        'required' => true,
        'integer' => true,
        'min' => 18
    ],
    'avatar' => [
        'file' => true,
        'image' => true,
        'max_size' => 5242880 // 5MB
    ]
];

if ($validator->validate($rules)) {
    // Validation passed
    $data = $validator->sanitize($_POST);
    // Process the data
} else {
    // Validation failed
    $errors = $validator->getErrors();
    // Display errors to user
}
*/
?> 