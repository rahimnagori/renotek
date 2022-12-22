<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Common_Model');
  }

  public function index()
  {
    $pageData['socialAccounts'] = $this->Common_Model->getPageData();

    $join[0][] = 'categories';
    $join[0][] = 'products.category_id = categories.id';
    $join[0][] = 'left';
    $select = 'products.*, categories.category_name';
    $pageData['products'] = $this->Common_Model->join_records('products', $join, false, $select);
    $pageData['homeProducts'] = $this->Common_Model->join_records('products', $join, array('is_home_page' => 1), $select);
    $pageData['sellProducts'] = $this->Common_Model->join_records('products', $join, array('is_best_sell' => 1), $select);
    $pageData['categories'] = $this->Common_Model->fetch_records('categories');
    $pageData['aboutUsContent'] = $this->Common_Model->fetch_records('pages_content', false, false, true);

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/index', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function shop()
  {
    $pageData['socialAccounts'] = $this->Common_Model->getPageData();

    $join[0][] = 'categories';
    $join[0][] = 'products.category_id = categories.id';
    $join[0][] = 'left';
    $join[1][] = 'product_images';
    $join[1][] = 'products.id = product_images.product_id';
    $join[1][] = 'left';
    $select = 'products.id, products.product_title, products.product_price, categories.category_name, product_images.product_image';

    $pageData['products'] = $this->Common_Model->join_records('products', $join, false, $select);
    $pageData['categories'] = $this->Common_Model->fetch_records('categories');

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/shop', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function about()
  {
    $pageData['socialAccounts'] = $this->Common_Model->getPageData();
    $pageData['aboutUsContent'] = $this->Common_Model->fetch_records('pages_content', false, false, true);

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/about', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function contact()
  {
    $pageData['socialAccounts'] = $this->Common_Model->getPageData();

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/contact', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function product_details($id)
  {
    $pageData['socialAccounts'] = $this->Common_Model->getPageData();
    $pageData['productDetails'] = $this->Common_Model->fetch_records('products', array('id' => $id), false, true);
    if (empty($pageData['productDetails'])) redirect('Shop');

    $pageData['productImages'] = $this->Common_Model->fetch_records('product_images', array('product_id' => $id));

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/details', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function send_contact_request()
  {
    $response['status'] = 0;
    $response['responseMessage'] = '';
    $this->form_validation->set_rules('user_name', 'user_name', 'required|trim');
    $this->form_validation->set_rules('email', 'email', 'required|valid_email|trim');
    $this->form_validation->set_rules('phone', 'phone', 'required|trim');
    $this->form_validation->set_rules('message', 'message', 'required|trim');
    if ($this->form_validation->run()) {
      $insert = array(
        'user_name' => $this->input->post('user_name'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'message' => $this->input->post('message'),
        'created' => date("Y-m-d H:i:s")
      );

      if ($this->Common_Model->insert('contact_requests', $insert)) {
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Request received successfully.');
      }
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error(validation_errors());
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }
}
