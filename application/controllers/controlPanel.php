<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class ControlPanel extends CI_Controller {
 
function __construct()
{
   parent::__construct();
}
 
function index()
{
   if($this->session->userdata('logged_in'))
   {
   	 //sve je uredu i autoriziran si, ulazi
     $session_data = $this->session->userdata('logged_in');
     $data['session'] = array('username'=>$session_data['username']);
     $this->load->view('private/controlPanel', $data);
   }
   else
   {
     //u slučaju neautoriziranog upada, izvoli van!
     redirect('login', 'refresh');
   }
}
 
function logout()
{
 	//logout, doviđenja
    $this->session->unset_userdata('logged_in');
    session_destroy();
    redirect('controlPanel', 'refresh');
}
 
}