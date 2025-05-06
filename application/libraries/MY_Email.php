<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/PHPMailer/class.phpmailer.php';
require_once APPPATH . 'libraries/PHPMailer/class.smtp.php';

class MY_Email extends PHPMailer {
    public function __construct() {
        parent::__construct();
        // Enable detailed debugging
        $this->SMTPDebug = 2; // 0 = off, 1 = client messages, 2 = client and server messages
        $this->Debugoutput = function($str, $level) {
            log_message('debug', 'PHPMailer: ' . $str);
        };

        // SMTP Configuration
        $this->isSMTP();
        $this->Host = 'smtp.gmail.com';
        $this->SMTPAuth = true;
        $this->Username = 'puskesmasdigital10@gmail.com'; // Replace with your Gmail address
        $this->Password = 'sqso yxeu eseb kcxx'; // Replace with Gmail App Password
        $this->SMTPSecure = 'tls';
        $this->Port = 587;
        $this->setFrom('puskesmasdigital10@gmail.com', 'Puskesmas Digital');
        $this->isHTML(true);
    }
}