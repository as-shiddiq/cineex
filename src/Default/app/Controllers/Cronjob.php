<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Cronjob extends BaseController
{
    public function outbox()
    {
        $OutboxModel = new \App\Models\OutboxModel();
        $configEmail = configEmail();
        $configWeb = configWeb();
        $getOutboxModel = $OutboxModel->limit(5)->where('sent_at',NULL)->findAll();
        $mail = new PHPMailer(true);
        foreach ($getOutboxModel as $row) {
            if($row->outbox_tipe=='email')
            {
                try {
                    //Server settings                   
                    // $mail->SMTPDebug = 1;                      // Enable verbose debug output
                    $mail->isSMTP();                                           
                    $mail->Mailer = "smtp";
                    $mail->Host       = $configEmail->config_email_host;             
                    $mail->SMTPSecure = $configEmail->config_email_smptsecure; 
                    $mail->SMTPAuth   = $configEmail->config_email_smtpauth;   
                    $mail->Username   = $configEmail->config_email_username; 
                    $mail->Password   = $configEmail->config_email_password;         
                    $mail->Port       = $configEmail->config_email_port;                        

                    $mail->setFrom($configEmail->config_email_username, $configWeb->config_web_nama);
                    $mail->ClearAddresses();
                    $mail->addAddress($row->outbox_tujuan);     // Add a recipient
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = $row->outbox_nama;
                    $title = $row->outbox_nama;
                    $message = html_entity_decode($row->outbox_pesan);
                    ob_start();
                    include FCPATH.'templates/email/'.$configEmail->config_email_template.'.php';
                    $pesan = ob_get_contents();
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';                     
                    $mail->Body    = $pesan;
                    // $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

                    $mail->send();
                    $OutboxModel->set(['sent_at'=>timestamp()])
                                    ->where('id',$row->id)
                                    ->update();
                    \log_message('debug',$row->id.' - '.$row->outbox_nama);
                    // echo json_encode(['info'=>'success','message'=>'Sukses! email berhasil dikirim.']);
                } catch (Exception $e) {
                    \log_message('debug',$e->getMessage());
                }

            }
        }

    }
}

