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
    $pageData = $this->Common_Model->getPageData();

    $join[0][] = 'categories';
    $join[0][] = 'products.category_id = categories.id';
    $join[0][] = 'left';
    $select = 'products.*, categories.category_name';
    $pageData['products'] = $this->Common_Model->join_records('products', $join, false, $select);
    $pageData['homeProducts'] = $this->Common_Model->join_records('products', $join, array('is_home_page' => 1), $select);
    $pageData['sellProducts'] = $this->Common_Model->join_records('products', $join, array('is_best_sell' => 1), $select);
    $pageData['categories'] = $this->Common_Model->fetch_records('categories');
    $pageData['aboutUsContent'] = $this->Common_Model->fetch_records('pages_content', false, false, true);
    $pageData['sliderElements'] = $this->Common_Model->fetch_records('slider_management');

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/index', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function shop()
  {
    $pageData = $this->Common_Model->getPageData();
    $pageData['categories'] = $this->Common_Model->fetch_records('categories');

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/shop', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function products(){
    $startingIndex = (isset($_GET['startingIndex']) && !empty($_GET['startingIndex'])) ? $_GET['startingIndex'] : 0;
    $totalRecords = (isset($_GET['totalRecords']) && !empty($_GET['totalRecords'])) ? $_GET['totalRecords'] : false;
    $category = (isset($_GET['category']) && !empty($_GET['category'])) ? $_GET['category'] : false;
    $pageData = $this->Common_Model->get_products($startingIndex, $totalRecords, $category);
    $pageData['categories'] = $this->Common_Model->fetch_records('categories');
    $cart = $this->session->userdata('cart');
    $pageData['cart'] = (!$cart || empty($cart)) ? [] : $cart;
    // $pageData['totalPages'] = ceil($pageData['totalProducts'] / $totalRecords);
    // $pageData['currentPage'] = 1;
    // $pageData['nextPage'] = $pageData['totalPages'] - $pageData['currentPage'];
    // $pageData['prevPage'] = 0;
    // $pageData['startingIndex'] = $startingIndex + $totalRecords;
    $this->load->view('site/products', $pageData);
  }

  public function add_product_to_cart($productId){
    $response['status'] = 0;
    $response['message'] = $this->Common_Model->error('Something went wrong');
    $getCart = $this->session->userdata('cart');

    if(!$getCart){
      $getCart[] = $productId;
      $response['status'] = 1;
      $response['message'] = 'Added';
      $response['responseMessage'] = $this->Common_Model->success($response['message']);
    }else{
      if(!in_array($productId, $getCart)){
        $getCart[] = $productId;
        $response['status'] = 1;
        $response['message'] = 'Added';
        $response['responseMessage'] = $this->Common_Model->success($response['message']);
      }else{
        $response['status'] = 2;
        $response['message'] = 'Product already in the cart.';
        $response['responseMessage'] = $this->Common_Model->error($response['message']);
      }
    }
    $this->session->set_userdata('cart', $getCart);
    $response['cart'] = count($getCart);
    echo json_encode($response);
  }

  public function remove_from_cart($productId){
    $response['status'] = 0;
    $response['message'] = $this->Common_Model->error('Something went wrong');
    $getCart = $this->session->userdata('cart');

    if(in_array($productId, $getCart)){
      if (($key = array_search($productId, $getCart)) !== false) {
        unset($getCart[$key]);
      }
      $response['status'] = 1;
      $response['message'] = 'Add to Cart';
      $response['responseMessage'] = $this->Common_Model->success($response['message']);
    }else{
      $response['status'] = 2;
      $response['message'] = 'Not in cart';
      $response['responseMessage'] = $this->Common_Model->error($response['message']);
    }
    $this->session->set_userdata('cart', $getCart);
    $response['cart'] = count($getCart);
    echo json_encode($response);
  }

  public function cart(){
    $getCart = $this->session->userdata('cart');
    if($this->is_cart_no_empty($getCart)){
      $pageData = $this->Common_Model->getPageData();
      $pageData['cartProducts'] = $this->Common_Model->fetch_records('products', false, '*', false, false, false, false, 'id', $getCart);
  
      $this->load->view('site/include/header', $pageData);
      $this->load->view('site/view_cart', $pageData);
      $this->load->view('site/include/footer', $pageData);
    }
  }

  private function is_cart_no_empty($getCart){
    if(empty($getCart) || !$getCart){
      $message = $this->Common_Model->error("Please add a product in the cart first.");
      $this->session->set_flashdata('responseMessage', $message);
      redirect('Shop');
    }
    return true;
  }

  public function about()
  {
    $pageData = $this->Common_Model->getPageData();
    $pageData['aboutUsContent'] = $this->Common_Model->fetch_records('pages_content', false, false, true);

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/about', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function contact()
  {
    $pageData = $this->Common_Model->getPageData();

    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/contact', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function product_details($id)
  {
    $pageData = $this->Common_Model->getPageData();
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

  public function quote()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong');
    
    $getCart = $this->session->userdata('cart');
    if($this->is_cart_no_empty($getCart)){
      $this->form_validation->set_rules('user_name', 'user_name', 'required|trim');
      $this->form_validation->set_rules('email', 'email', 'required|valid_email|trim');
      $this->form_validation->set_rules('phone', 'phone', 'required|trim');
      $this->form_validation->set_rules('message', 'message', 'required|trim');
      if ($this->form_validation->run()) {
        $token = 1234;
        $insert = array(
          'user_name' => $this->input->post('user_name'),
          'email' => $this->input->post('email'),
          'phone' => $this->input->post('phone'),
          'message' => $this->input->post('message'),
          'products' => json_encode($getCart),
          'token' => $token,
          'created' => date("Y-m-d H:i:s")
        );
  
        $quotationId = $this->Common_Model->insert('quotations', $insert);
        if ($quotationId) {
          $this->session->set_userdata('quotation_id', $quotationId);
          $response['status'] = 1;
          $response['responseMessage'] = $this->Common_Model->success("We've sent you a code, check your email and enter it here to complete the quotation sending process.");
        }
      } else {
        $response['status'] = 2;
        $response['responseMessage'] = $this->Common_Model->error(validation_errors());
      }
      $this->session->set_flashdata('responseMessage', $response['responseMessage']);
      echo json_encode($response);

    }
  }

  public function send_quotation(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong');

    $this->form_validation->set_rules('token', 'token', 'required|trim');
    if ($this->form_validation->run()) {
      $where['token'] = $this->input->post('token');
      $where['id'] = $this->session->userdata('quotation_id');
      $checkQuotationExist = $this->Common_Model->fetch_records('quotations', $where, false, true);
      if( $checkQuotationExist && !empty($checkQuotationExist)){
        $pageData['cartProducts'] = $this->Common_Model->fetch_records('products', false, '*', false, false, false, false, 'id', json_decode($checkQuotationExist['products']));
        $pageData['quotationDetails'] = $checkQuotationExist;
      }
    }else{
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error(validation_errors());
    }

    echo json_encode($response);

  }
}
