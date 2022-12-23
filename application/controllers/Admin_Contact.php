<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Contact extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_Model');
    if (!$this->check_login()) {
      redirect('Admin');
    }
  }

  public function check_login()
  {
    return ($this->session->userdata('is_admin_logged_in')) ? true : false;
  }

  public function index()
  {
    $pageData = $this->Common_Model->getAdmin($this->session->userdata('id'));

    $pageData['contactRequests'] = $this->Common_Model->fetch_records('contact_requests');
    $this->load->view('admin/contacts_management', $pageData);
  }

  public function get_product($id)
  {
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $pageData['productDetails'] = $this->Common_Model->fetch_records('products', array('id' => $id), false, true);
      $pageData['categories'] = $this->Common_Model->fetch_records('categories');
      $this->load->view('admin/include/product_details', $pageData);
    } else {
      $response['status'] = 2;
      echo $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
  }
}
