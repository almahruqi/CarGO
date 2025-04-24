<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $mailer;
    private $fromEmail;
    private $fromName;
    private $replyTo;
    private $templatePath;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->fromEmail = 'noreply@cargo.com';
        $this->fromName = 'CarGo';
        $this->replyTo = 'support@cargo.com';
        $this->templatePath = __DIR__ . '/../templates/email/';

        // Configure mailer
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'your-email@gmail.com';
        $this->mailer->Password = 'your-app-password';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;
        $this->mailer->CharSet = 'UTF-8';
    }

    public function send($to, $subject, $template, $data = [], $attachments = []) {
        try {
            // Set sender
            $this->mailer->setFrom($this->fromEmail, $this->fromName);
            $this->mailer->addReplyTo($this->replyTo);

            // Set recipient
            if (is_array($to)) {
                foreach ($to as $email => $name) {
                    $this->mailer->addAddress($email, $name);
                }
            } else {
                $this->mailer->addAddress($to);
            }

            // Set subject
            $this->mailer->Subject = $subject;

            // Load and process template
            $body = $this->loadTemplate($template, $data);
            $this->mailer->isHTML(true);
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);

            // Add attachments
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    if (is_array($attachment)) {
                        $this->mailer->addAttachment(
                            $attachment['path'],
                            $attachment['name'] ?? basename($attachment['path'])
                        );
                    } else {
                        $this->mailer->addAttachment($attachment);
                    }
                }
            }

            // Send email
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            return false;
        }
    }

    private function loadTemplate($template, $data) {
        $templateFile = $this->templatePath . $template . '.php';
        
        if (!file_exists($templateFile)) {
            throw new Exception("Email template not found: $template");
        }

        // Extract data to variables
        extract($data);

        // Start output buffering
        ob_start();

        // Include template file
        include $templateFile;

        // Get buffered content
        $content = ob_get_clean();

        return $content;
    }

    public function sendWelcomeEmail($user) {
        $data = [
            'name' => $user['name'],
            'email' => $user['email'],
            'login_url' => 'https://cargo.com/login'
        ];

        return $this->send(
            $user['email'],
            'Welcome to CarGo',
            'welcome',
            $data
        );
    }

    public function sendPasswordResetEmail($user, $token) {
        $data = [
            'name' => $user['name'],
            'reset_url' => 'https://cargo.com/reset-password?token=' . $token,
            'expiry' => '1 hour'
        ];

        return $this->send(
            $user['email'],
            'Password Reset Request',
            'password_reset',
            $data
        );
    }

    public function sendVerificationEmail($user, $token) {
        $data = [
            'name' => $user['name'],
            'verification_url' => 'https://cargo.com/verify-email?token=' . $token,
            'expiry' => '24 hours'
        ];

        return $this->send(
            $user['email'],
            'Verify Your Email Address',
            'email_verification',
            $data
        );
    }

    public function sendNotificationEmail($user, $subject, $message) {
        $data = [
            'name' => $user['name'],
            'message' => $message
        ];

        return $this->send(
            $user['email'],
            $subject,
            'notification',
            $data
        );
    }

    public function sendContactFormEmail($name, $email, $message) {
        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message
        ];

        return $this->send(
            $this->replyTo,
            'New Contact Form Submission',
            'contact_form',
            $data
        );
    }

    public function sendOrderConfirmationEmail($user, $order) {
        $data = [
            'name' => $user['name'],
            'order' => $order,
            'order_url' => 'https://cargo.com/orders/' . $order['id']
        ];

        return $this->send(
            $user['email'],
            'Order Confirmation - #' . $order['id'],
            'order_confirmation',
            $data
        );
    }
}

// Example usage:
/*
$mailer = new Mailer();

// Send welcome email
$mailer->sendWelcomeEmail([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Send password reset email
$mailer->sendPasswordResetEmail([
    'name' => 'John Doe',
    'email' => 'john@example.com'
], 'reset-token-123');

// Send verification email
$mailer->sendVerificationEmail([
    'name' => 'John Doe',
    'email' => 'john@example.com'
], 'verification-token-123');

// Send notification email
$mailer->sendNotificationEmail([
    'name' => 'John Doe',
    'email' => 'john@example.com'
], 'New Message', 'You have received a new message.');

// Send contact form email
$mailer->sendContactFormEmail(
    'John Doe',
    'john@example.com',
    'Hello, I have a question about your service.'
);

// Send order confirmation email
$mailer->sendOrderConfirmationEmail([
    'name' => 'John Doe',
    'email' => 'john@example.com'
], [
    'id' => '123',
    'items' => [...],
    'total' => 100.00
]);
*/
?> 