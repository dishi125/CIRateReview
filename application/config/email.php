<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    //'smtp_host' => 'smtp.office365.com',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
   // 'smtp_user' => 'rateandreview.psm@outlook.com',
    'smtp_user' => 'InngeniusWeb@gmail.com',
    //'smtp_pass' => 'RatePsm$$',
    'smtp_pass' => 'arzvmgglakrhqoht',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'utf-8',
    'wordwrap' => TRUE,
    'crlf' => "\r\n",
	'newline' => "\r\n"
);
