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

  public function products()
  {
    $startingIndex = (isset($_GET['startingIndex']) && !empty($_GET['startingIndex'])) ? $_GET['startingIndex'] : 0;
    $totalRecords = (isset($_GET['totalRecords']) && !empty($_GET['totalRecords'])) ? $_GET['totalRecords'] : false;
    $category = (isset($_GET['category']) && !empty($_GET['category'])) ? $_GET['category'] : false;

    $select = 'products.id, products.product_title, products.product_price, categories.category_name, product_images.product_image';
    $pageData = $this->Common_Model->get_products($startingIndex, $totalRecords, $category, false, false, $select);
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

  public function add_product_to_cart($productId)
  {
    $response['status'] = 0;
    $response['message'] = $this->Common_Model->error('Something went wrong');
    $getCart = $this->session->userdata('cart');

    if (!$getCart) {
      $getCart[] = $productId;
      $response['status'] = 1;
      $response['message'] = 'Added';
      $response['responseMessage'] = $this->Common_Model->success($response['message']);
    } else {
      if (!in_array($productId, $getCart)) {
        $getCart[] = $productId;
        $response['status'] = 1;
        $response['message'] = 'Added';
        $response['responseMessage'] = $this->Common_Model->success($response['message']);
      } else {
        $response['status'] = 2;
        $response['message'] = 'Product already in the cart.';
        $response['responseMessage'] = $this->Common_Model->error($response['message']);
      }
    }
    $this->session->set_userdata('cart', $getCart);
    $response['cart'] = count($getCart);
    echo json_encode($response);
  }

  public function remove_from_cart($productId)
  {
    $response['status'] = 0;
    $response['message'] = $this->Common_Model->error('Something went wrong');
    $getCart = $this->session->userdata('cart');

    if (in_array($productId, $getCart)) {
      if (($key = array_search($productId, $getCart)) !== false) {
        unset($getCart[$key]);
      }
      $response['status'] = 1;
      $response['message'] = 'Add to Cart';
      $response['responseMessage'] = $this->Common_Model->success($response['message']);
    } else {
      $response['status'] = 2;
      $response['message'] = 'Not in cart';
      $response['responseMessage'] = $this->Common_Model->error($response['message']);
    }
    $this->session->set_userdata('cart', $getCart);
    $response['cart'] = count($getCart);
    echo json_encode($response);
  }

  public function cart()
  {
    $getCart = $this->session->userdata('cart');
    if ($this->is_cart_no_empty($getCart)) {
      $pageData = $this->Common_Model->getPageData();
      $select = 'products.id, products.product_title, products.product_price, product_images.product_image';
      $products = $this->Common_Model->get_products(false, false, false, false, false, $select, 'products.id', $getCart);
      $pageData['cartProducts'] = $products['products'];

      $this->load->view('site/include/header', $pageData);
      $this->load->view('site/view_cart', $pageData);
      $this->load->view('site/include/footer', $pageData);
    }else{
      $this->session->set_flashdata('responseMessage', 'Please add a product first in the cart.');\
      redirect('Shop');
    }
  }

  private function is_cart_no_empty($getCart)
  {
    if (empty($getCart) || !$getCart) {
      $message = $this->Common_Model->error("Please add a product in the cart first.");
      $this->session->set_flashdata('responseMessage', $message);
      return false;
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
    if ($this->is_cart_no_empty($getCart)) {
      $this->form_validation->set_rules('user_name', 'user_name', 'required|trim');
      $this->form_validation->set_rules('email', 'email', 'required|valid_email|trim');
      $this->form_validation->set_rules('phone', 'phone', 'required|trim');
      $this->form_validation->set_rules('message', 'message', 'required|trim');
      if ($this->form_validation->run()) {
        $token = ($this->config->item('ENVIRONMENT') == 'production') ? rand(1000, 99999) : '1234';
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
          $body = "<p>Hello " . $insert['user_name'] . ",</p>";
          $body .= "<p>Here is your code:</p>";
          $body .= "<p><strong>$token</strong></p>";
          $body .= "<p>Enter this code into the application to proceed further.</p>";
          $subject = "Code to proceed further";
          if ($this->config->item('ENVIRONMENT') == 'production') {
            $this->Common_Model->send_mail($insert['email'], $subject, $body);
          }

          $this->session->set_userdata('quotation_id', $quotationId);
          $response['status'] = 1;
          $response['responseMessage'] = $this->Common_Model->success("We've sent you a code on " . $insert['email'] . ", check your email and enter it here to complete the quotation sending process.");
        }
      } else {
        $response['status'] = 2;
        $response['responseMessage'] = $this->Common_Model->error(validation_errors());
      }
    }else{
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error('Please add a product first from the <a href="' .site_url('Shop') .'">Shop</a> page.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function send_quotation()
  {
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Something went wrong');

    $this->form_validation->set_rules('token', 'token', 'required|trim');
    if ($this->form_validation->run()) {
      $where['token'] = $this->input->post('token');
      $where['id'] = $this->session->userdata('quotation_id');
      $checkQuotationExist = $this->Common_Model->fetch_records('quotations', $where, false, true);
      if ($checkQuotationExist && !empty($checkQuotationExist)) {
        // $pageData['cartProducts'] = $this->Common_Model->fetch_records('products', false, '*', false, false, false, false, 'id', json_decode($checkQuotationExist['products']));
        $prods = json_decode($checkQuotationExist['products']);
        $products = [];
        foreach ($prods as $prod) {
          $products[] = $prod;
        }
        $select = 'products.id, products.product_title, products.product_price, product_images.product_image, categories.category_name';
        $products = $this->Common_Model->get_products(false, false, false, false, false, $select, 'products.id', $products);
        $pageData['quotationDetails'] = $checkQuotationExist;
        $pageData['cartProducts'] = $products['products'];
        $pageData['isAdmin'] = true;
        $adminQuotationBody = $this->load->view('site/include/quotation', $pageData, true);
        $pageData['isAdmin'] = false;
        $userQuotationBody = $this->load->view('site/include/quotation', $pageData, true);
        if ($this->config->item('ENVIRONMENT') == 'production') {
          $this->send_quotation_to_admin($adminQuotationBody);
          $this->send_confirmation_to_customer($pageData['quotationDetails']['email'], $userQuotationBody);
        }
        $this->session->sess_destroy();
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Quotation enquiry sent successfully. Please check your email, you will also receive an confirmation email soon.');
      } else {
        $response['status'] = 2;
        $response['responseMessage'] = $this->Common_Model->error('Nothing to send. Cart is already empty. Please <a href="' . site_url('Shop') . '">add a product</a> into the cart to proceed further.');
      }
    } else {
      $response['status'] = 2;
      $response['responseMessage'] = $this->Common_Model->error(validation_errors());
    }
    echo json_encode($response);
  }

  private function send_quotation_to_admin($quotationBody)
  {
    $subject = 'New quotation received.';
    $this->Common_Model->send_mail($this->config->item('EMAIL'), $subject, $quotationBody);
  }

  private function send_confirmation_to_customer($customerEmail, $quotationBody)
  {
    $subject = 'We have received your quotation.';
    $this->Common_Model->send_mail($customerEmail, $subject, $quotationBody);
  }

  public function test()
  {
    redirect('');
    $pageData = [
      'quotationDetails' => [
        'user_name' => 'Noel Arnold Ronald Dillon',
        'phone' => '9425987350',
        'email' => 'turgut@mailinator.com',
        'message' => "I'm really impressed by the services of Renotek and would love to buy some products for my newly established firm."
      ],
      'cartProducts' => [
        [
          'id' => 1,
          'product_price' => '0.00',
          'product_title' => 'First product',
          'product_image' => '',
          'category_name' => 'Test Category'
        ],
        [
          'id' => 2,
          'product_price' => '0.00',
          'product_title' => 'Second product',
          'product_image' => '',
          'category_name' => 'Test Category'
        ]
        ],
      'isAdmin' => true
    ];
    $msgBody = $this->load->view('site/include/quotation', $pageData, true);
    $pageData['body'] = $msgBody;
    $this->load->view('site/include/email_template', $pageData);
  }

  public function get_catalogue()
  {
    $pageData = $this->Common_Model->getPageData();
    $pageData['settings'] = $this->Common_Model->fetch_records('settings', false, false, true);
    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/catalogue', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }
}
