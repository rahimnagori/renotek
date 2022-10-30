<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Products extends CI_Controller
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

    $join[0][] = 'categories';
    $join[0][] = 'products.category_id = categories.id';
    $join[0][] = 'left';
    $select = 'products.*, categories.category_name';
    $pageData['products'] = $this->Common_Model->join_records('products', $join, false, $select);
    $pageData['categories'] = $this->Common_Model->fetch_records('categories');
    if(count($pageData['categories']) == 0){
      $this->session->set_flashdata('responseMessage', $this->Common_Model->error('Please add a category first'));
      redirect('Admin-Categories');
    }

    $this->load->view('admin/products_management', $pageData);
  }

  public function add_product()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 8)) {
      $insert = $this->create_product();
      if ($this->Common_Model->insert('products', $insert)) {
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Product added successfully.');
        $this->session->set_flashdata('responseMessage', $response['responseMessage']);
      }
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized to perform this action.');
    }
    echo json_encode($response);
  }

  public function delete_product()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $where['id'] = $this->input->post('delete_product_id');
      if ($this->Common_Model->delete('products', $where)) {
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Product deleted successfully.');
      }
      $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
    echo json_encode($response);
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

  public function update_product()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $update = $this->create_product('update');
      $where['id'] = $this->input->post('product_id');
      if ($this->Common_Model->update('products', $where, $update)) {
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Product updated successfully.');
      }
      $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
    echo json_encode($response);
  }

  private function create_product($update = false){
    $data = [
      'category_id' => $this->input->post('category_id'),
      'product_title' => $this->input->post('product_title'),
      'product_description' => $this->input->post('product_description'),
      'product_price' => $this->input->post('product_price'),
      'is_best_sell' => $this->input->post('is_best_sell'),
      'is_home_page' => $this->input->post('is_home_page'),
    ];
    if (!$update) {
      $data['created'] = date("Y-m-d H:i:s");
    }
    return $data;
  }

  public function image($id)
  {
    $pageData = $this->Common_Model->getAdmin($this->session->userdata('id'));

    $pageData['productDetails'] = $this->Common_Model->fetch_records('products', array('id' => $id), false, true);
    if(empty($pageData['productDetails'])){
      $this->session->set_flashdata('responseMessage', $this->Common_Model->error('Product not found'));
      redirect('Admin-Products');
    }
    $pageData['productImages'] = $this->Common_Model->fetch_records('product_images', array('product_id' => $id));

    $this->load->view('admin/product_images_management', $pageData);
  }

  public function add_image()
  {
    $response['status'] = 0;
    $insert['product_id'] = $this->input->post('product_id');
    if ($_FILES['product_image']['error'] == 0) {
      $config['upload_path'] = "assets/site/img/products/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('product_image')) {
        $productImage = $this->upload->data("file_name");

        $insert['product_image'] = "assets/site/img/products/" . $productImage;
        
        if ($this->Common_Model->insert('product_images', $insert)) {
          $response['status'] = 1;
          $response['responseMessage'] = 'Product Image Added Successfully.';
        }
      } else {
        $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
      }
    }
    echo json_encode($response);
  }

  public function delete_image()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $where['id'] = $this->input->post('delete_image_id');
      $product_id = $this->input->post('product_id');
      // $productDetails = $this->Common_Model->fetch_records('products', array('id' => $product_id), false, true);
      $imageDetails = $this->Common_Model->fetch_records('product_images', $where, false, true);
      if ($this->Common_Model->delete('product_images', $where)) {
        if(file_exists($imageDetails['product_image'])) unlink($imageDetails['product_image']);
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Product deleted successfully.');
      }
      $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
    echo json_encode($response);
  }

  public function get_image($id)
  {
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $pageData['imageDetails'] = $this->Common_Model->fetch_records('product_images', array('id' => $id), false, true);
      $this->load->view('admin/include/image_details', $pageData);
    } else {
      $response['status'] = 2;
      echo $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
  }

  public function update_image()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
    if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
      $imageId = $this->input->post('image_id');
      if ($_FILES['product_image']['error'] == 0) {
        $imageDetails = $this->Common_Model->fetch_records('product_images', array('id' => $imageId), false, true);
        $config['upload_path'] = "assets/site/img/products/";
        $config['allowed_types'] = 'jpeg|gif|jpg|png';
        $config['encrypt_name'] = true;
        $this->load->library("upload", $config);
        if ($this->upload->do_upload('product_image')) {
          $productImage = $this->upload->data("file_name");
  
          $update['product_image'] = "assets/site/img/products/" . $productImage;
          $where['id'] = $imageId;
          if ($this->Common_Model->update('product_images', $where, $update)) {
            if(file_exists($imageDetails['product_image'])) unlink($imageDetails['product_image']);
            $response['status'] = 1;
            $response['responseMessage'] = 'Product Image Updated Successfully.';
          }
        } else {
          $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
        }
      }
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }
}
