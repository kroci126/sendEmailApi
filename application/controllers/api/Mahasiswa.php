<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller{
    function __construct($config = 'rest'){
        parent:: __construct($config);
        $this->load->model('Mahasiswamodel','model');
    }

    public function index_get(){
        $data = $this->model->getMahasiswa();
        $this->set_response([
                'message'=> 'Success',
                'code' => 200,
                'status' => TRUE,
                'data'   => $data ,
               
                ], REST_Controller::HTTP_OK);
    }

    public function sendmail_post(){
        $from_email = $this->post('email');
        $this->load->library('email');
        $this->email->from('info@gavinthan.com', 'info@gavinthan.com');
        $this->email->to($from_email);
        $this->email->subject('Informasi Penting!');
        $this->email->message("
            <body style='outline-style: solid; outline-color:#1a82e2;border-radius: 15px; margin: 10px;'>
            <center>
                <h1 style='color: #FF5555;'>Welcome New User!</h1>
                <img src='http://clipart-library.com/img1/1408494.png' height='150;'>
                <p>Thank you for registering to our website.</p>
                <p style='font-size:10px'>Tap the button below to confirm your email address. If you didn't create an account, please safely delete this email.</p>
                <tr>
            <td align='left' bgcolor='#ffffff'>
              <table border='0' cellpadding='10' cellspacing='0' width='100%'>
                <tr>
                  <td align='center' bgcolor='#ffffff' style='padding: 12px;'>
                    <table border='0' cellpadding='10' cellspacing='0'>
                      <tr>
                        <td align='center' bgcolor='#1a82e2' style='border-radius: 6px;'>
                          <a href='http://gavinthan.com/api/Project_Test/test.html' style='display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;'>Confirm Email</a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
            </center>
          </body>
        ");

        if($this->email->send()){
            $this->set_response(
                [
                    'status'=> TRUE,
                    'code' => 200,
                    'message' => 'Email konfirmasi telah berhasil dikirim, silahkan periksa inbox email Anda!'
                ], REST_Controller::HTTP_OK
                );
        }else{
            $this->set_response(
                [
                    'status'=> FALSE,
                    'code' => 404,
                    'message' => 'Gagal mengirimkan email informasi!'
                ], REST_Controller::HTTP_NOT_FOUND
                );
        }
    }

}