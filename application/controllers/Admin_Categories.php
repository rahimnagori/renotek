<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Categories extends CI_Controller
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

    $pageData['categories'] = $this->Common_Model->fetch_records('categories');
    $pageData['parentCategories'] = $this->Common_Model->fetch_records('categories', array('parent_id' => 0));

    $this->load->view('admin/categories_management', $pageData);
  }

  public function add_category()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 8)) {
      $insert['category_name'] = $this->input->post('category_name');
      $insert['parent_id'] = $this->input->post('parent_id');
      if ($this->Common_Model->insert('categories', $insert)) {
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Category added successfully.');
        $this->session->set_flashdata('responseMessage', $response['responseMessage']);
      }
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized to perform this action.');
    }
    echo json_encode($response);
  }

  public function delete_category()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $where['id'] = $this->input->post('delete_category_id');
      if ($this->Common_Model->delete('categories', $where)) {
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Category deleted successfully.');
      }
      $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
    echo json_encode($response);
  }

  public function get_category($id)
  {
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $pageData['categoryDetails'] = $this->Common_Model->fetch_records('categories', array('id' => $id), false, true);
      $parentCategories = $this->Common_Model->fetch_records('categories', array('parent_id' => 0));
      foreach( $parentCategories as $parentCategory){
        $pageData['parentCategories'][$parentCategory['id']] = $parentCategory;
      }
      $this->load->view('admin/include/category_details', $pageData);
    } else {
      $response['status'] = 2;
      echo $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
  }

  public function get_new_categories($id)
  {
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $pageData['categories'] = $this->Common_Model->fetch_records('categories', array('id !=' => $id), false, true);
      $this->load->view('admin/include/category_delete_confirmation', $pageData);
    } else {
      $response['status'] = 2;
      echo $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
  }

  public function update_category()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $update['category_name'] = $this->input->post('category_name');
      $where['id'] = $this->input->post('category_id');
      if ($this->Common_Model->update('categories', $where, $update)) {
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Category updated successfully.');
      }
      $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
    echo json_encode($response);
  }
}
