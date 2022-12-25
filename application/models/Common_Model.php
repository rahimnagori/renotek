<?php
class Common_Model extends CI_Model
{
  function join_records($table, $joins, $where = false, $select = '*', $ob = false, $obc = 'DESC', $groupBy = false)
  {
    /* https://github.com/rahimnagori/cheat-sheet/blob/master/ci_dynamic_join.php */
    $this->db->select($select);
    $this->db->from($table);
    foreach ($joins as $join) {
      $this->db->join($join[0], $join[1], $join[2]);
    }
    if ($where) $this->db->where($where);
    if ($groupBy) $this->db->group_by($groupBy);
    if ($ob) $this->db->order_by($ob, $obc);
    $query = $this->db->get();
    return $query->result_array();
  }

  function fetch_records($table, $where = false, $select = false, $singleRecords = false, $orderBy = false, $orderDirection = 'DESC', $groupBy = false, $where_in_key = false, $where_in_value = false, $limit = false, $start = 0)
  {
    if ($where) $this->db->where($where);
    if ($where_in_key) $this->db->where_in($where_in_key, $where_in_value);
    if ($select) $this->db->select($select);
    if ($groupBy) $this->db->group_by($groupBy);
    if ($orderBy) $this->db->order_by($orderBy, $orderDirection);
    if ($limit) $this->db->limit($limit, $start);
    $query = $this->db->get($table);
    return ($singleRecords) ? $query->row_array() : $query->result_array();
  }

  public function get_products($startingIndex = 0, $totalRecords = false, $category = false, $orderBy = false, $orderDirection = false)
  {
    $this->db->from('products');
    $this->db->select('products.id, products.product_title, products.product_price, categories.category_name, product_images.product_image');

    $this->db->join('categories', 'products.category_id = categories.id', 'left');
    $this->db->join('product_images', 'products.id = product_images.product_id', 'left');

    // if ($where) $this->db->where($where);
    $this->db->group_by('products.id'); /* This is required to select single product image */
    $totalProducts = $this->db->get();
    $pageData['totalProducts'] = count($totalProducts->result_array());

    $this->db->from('products');
    $this->db->select('products.id, products.product_title, products.product_price, categories.category_name, product_images.product_image');

    $this->db->join('categories', 'products.category_id = categories.id', 'left');
    $this->db->join('product_images', 'products.id = product_images.product_id', 'left');

    // if ($where) $this->db->where($where);
    $this->db->group_by('products.id'); /* This is required to select single product image */
    // $this->db->limit($totalRecords, $startingIndex);
    if ($orderBy) $this->db->order_by($orderBy, $orderDirection);
    $products = $this->db->get();
    $pageData['products'] = $products->result_array();
    return $pageData;
  }

  public function get_user($where)
  {
    $this->db->or_where('username', $where);
    $this->db->or_where('email', $where);
    $query = $this->db->get('users');
    return $query->row_array();
  }

  public function get_admin($where)
  {
    // $this->db->where('username', $where);
    $this->db->where('email', $where);
    $query = $this->db->get('admins');
    return $query->row_array();
  }

  public function update($table, $where, $updateData)
  {
    $this->db->where($where);
    return $this->db->update($table, $updateData) ? true : false;
  }

  public function insert($table, $data)
  {
    return ($this->db->insert($table, $data)) ? $this->db->insert_id() : false;
  }

  public function delete($table, $where)
  {
    $this->db->where($where);
    $delete = $this->db->delete($table);
    return $delete ? true : false;
  }

  public function success($message)
  {
    return '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $message . '</div>';
  }

  public function error($message)
  {
    return '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $message . '</div>';
  }

  public function history($message)
  {
    $insert['user_id'] = ($this->session->userdata('id')) ? $this->session->userdata('id') : 0;
    $insert['action'] = $message;
    $this->insert('histories', $insert);
  }

  public function send_mail($to, $subject, $body, $bcc = false, $attachments = [])
  {
    $settings = $this->fetch_records('settings', array('id' => 1), 'smtp_user', true);
    $this->load->library('parser');
    $response['status'] = 0;
    $PROJECT = $this->config->item('PROJECT');
    $config = array();
    $config['mailtype'] = "html";
    $config['charset'] = "utf-8";
    $config['newline'] = "\r\n";
    $config['wordwrap'] = TRUE;
    $config['validate'] = FALSE;

    $this->load->library('email', $config);
    $this->email->initialize($config);

    $this->email->set_header("MIME-Version", "1.0");
    $this->email->set_header("Reply-To", $settings['smtp_user']);
    $this->email->set_header("X-Mailer", "PHP/" . phpversion());

    $this->email->from($settings['smtp_user'], 'Admin');
    $this->email->to($to);
    $this->email->set_crlf("\r\n");
    $this->email->subject($subject);

    if ($bcc) {
      $this->email->bcc($bcc);
    }

    $pageData['body'] = $body;
    $pageData['PROJECT'] = $PROJECT;
    $msg = $this->load->view('site/include/email_template', $pageData, true);
    // $this->load->view('site/include/email_template', $pageData); /* Debug */

    if (!empty($attachments)) {
      /* It accepts absolute path ex: site_url('/assets.../filename') */
      foreach ($attachments as $attachment) {
        if (is_array($attachment)) {
          $this->email->attach($attachment['path'], 'attachment', $attachment['filename']);
        } else {
          $this->email->attach($attachment);
        }
      }
    }
    $this->email->message($msg);
    try {
      $this->email->send();
      $response['status'] = 1;
    } catch (Exception $e) {
      $response['responseMessage'] = $e->getMessage();
      $response['status'] = 2;
    }
    return $response;
  }

  public function send_mail_with_smtp($to, $subject, $body, $bcc = null, $attachment = false)
  {
    $this->load->library('email');
    $config = $this->get_smtp_configuration();
    $this->email->initialize($config);
    $this->email->from($config['smtp_user'], 'Admin');
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($body);
    try {
      $this->email->send();
      echo $this->email->print_debugger();
      echo "<br/>Mail Sent";
    } catch (Exception $e) {
      echo "<p>" . $e->getMessage() . "</p>";
    }
  }

  private function get_smtp_configuration()
  {
    $config = $this->fetch_records('settings', array('id' => 1), 'smtp_user, smtp_pass', true);
    $config['smtp_host'] = 'smtp.gmail.com';
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    // $config['smtp_port'] = '465';
    $config['smtp_port'] = 465;
    $config['smtp_timeout'] = '7';
    // $config['smtp_user'] = '';
    // $config['smtp_pass'] = '';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'text'; //html
    $config['validation'] = TRUE;
    return $config;
  }

  public function update_user_login($table, $user_id, $action_type = 0)
  {
    if ($action_type) {
      $update['last_login'] = date('Y-m-d H:i:s');
    }
    $update['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $update['is_online'] = $action_type;
    $this->update($table, array('id' => $user_id), $update);
    $insert['user_id'] = $user_id;
    $insert['ip_address'] = $update['ip_address'];
    $insert['is_organization'] = ($table == 'organizations') ? 1 : 0;
    $insert['action_type'] = $action_type;
    $insert['created'] = $update['last_login'];

    $this->insert('user_ips', $insert);
  }

  public function get_userdata()
  {
    $pageData = [];
    $where['id'] = $this->session->userdata('id');
    if ($where['id']) {
      $pageData['userDetails'] = $this->fetch_records('users', $where, false, true);
    }

    return $pageData;
  }

  public function get_payment_types()
  {
    $formattedPaymentTypes = [];
    $paymentTypes = $this->fetch_records('payment_types');
    foreach ($paymentTypes as $paymentType) {
      $formattedPaymentTypes[$paymentType['id']] = ucfirst($paymentType['payment_type']);
    }
    return $formattedPaymentTypes;
  }

  public function get_job_types()
  {
    $formattedJobType = [];
    $jobTypes = $this->fetch_records('job_types');
    foreach ($jobTypes as $jobType) {
      $formattedJobType[$jobType['id']] = ucfirst($jobType['name']);
    }
    return $formattedJobType;
  }

  public function get_email_content($email_type)
  {
    $where['email_type'] = $email_type;
    $email = $this->fetch_records('emails', $where, 'id, content', true);
    return $email['content'];
  }

  public function get_job_reference($data)
  {
    $jobTypes = $this->get_job_types();
    $employmentTypes = ($data['employment_type'] == 1) ? 'P' : 'T';
    $paymentTypes = $this->get_payment_types();
    $totalJobs = count($this->fetch_records('jobs')) + 1;

    return $this->format_ref_string($jobTypes[$data['job_type']]) . $employmentTypes . $this->format_ref_string($paymentTypes[$data['payment_type']]) . $totalJobs . rand(100, 999);
  }

  public function format_ref_string($string)
  {
    return substr($string, 0, 1);
  }

  public function generate_password($passwordLength)
  {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i <= $passwordLength; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
    }
    return implode($pass);
  }

  public function generate_username($userdata)
  {
    $totalUsers = count($this->fetch_records('users')) + 1;
    return $userdata['first_name'] . $totalUsers . $this->generate_password(4);
  }

  public function is_admin_authorized($adminId, $permissionId = false)
  {
    $adminData = $this->fetch_records('admins', array('id' => $adminId), false, true);
    $where['admin_id'] = $adminId;
    $adminPermissions = $this->fetch_records('admin_permissions', $where, false, true);
    if (empty($adminPermissions)) {
      $permissions = $this->fetch_records('permissions');
      $adminDefaultPermission = [];
      foreach ($permissions as $permission) {
        // $adminDefaultPermission[$permission['id']] = ($adminData['admin_type'] == 1) ? 1 : 0;
        /* By default allowing all Admin */
        $adminDefaultPermission[$permission['id']] = 1;
      }
      $insertAdminPermission['admin_id'] = $adminId;
      $insertAdminPermission['permissions'] = json_encode($adminDefaultPermission);
      $this->insert('admin_permissions', $insertAdminPermission);
      $adminPermissions = $insertAdminPermission;
    }
    $allPermissions = json_decode($adminPermissions['permissions']);
    $bulkPermissions = [];
    foreach ($allPermissions as $key => $allPermission) {
      $bulkPermissions[$key] = $adminData['admin_type'] == 1 ? 1 : $allPermission; /* Super Admin have all the priviledge by default. */
    }
    if ($permissionId) {
      return isset($bulkPermissions[$permissionId]) ? $bulkPermissions[$permissionId] : 0;
      // return $adminData['admin_type'] == 1 ? 1 : isset($bulkPermissions[$permissionId]) ? $bulkPermissions[$permissionId] : 0;
    } else {
      return $bulkPermissions;
    }
  }

  public function getAdmin($adminId)
  {
    $where['id'] = $adminId;
    $pageData['adminData'] = $this->fetch_records('admins', $where, false, true);
    // $pageData['defaultPermissions'] = $this->fetch_records('permissions');
    // if (!empty($pageData['adminData'])) {
    //   $pageData['permissions'] = $this->is_admin_authorized($adminId);
    // }
    return $pageData;
  }

  public function send_user_form_to_admin($userId, $update = false)
  {
    $pageData = [];
    $pageData['userdata'] = $this->fetch_records('users', array('id' => $userId), false, true);
    $subject = ($update) ? 'Registration form updated by user.' : 'Registration form for new user.';
    $pageData['emailContent'] = $this->Common_Model->get_email_content(7);
    $body = $this->load->view('site/include/registration_form', $pageData, true);

    $attachments = [];
    if ($pageData['userdata']['resume'] != '' || $pageData['userdata']['resume'] != null) {
      $resumeFile = [
        'path' => site_url($pageData['userdata']['resume']),
        'filename' => 'resume'
      ];
      $attachments[] = $resumeFile;
    }
    $userDocs = $this->fetch_records('user_docs', array('user_id' => $userId));
    foreach ($userDocs as $key => $userDoc) {
      $docFile = [
        'path' => site_url($userDoc['document']),
        'filename' => $userDoc['doc_name'] . " ($key)"
      ];
      $attachments[] = $docFile;
    }

    $settings = $this->fetch_records('settings', array('id' => 1), 'admin_email', true);
    if ($this->config->item('ENVIRONMENT') == 'production') {
      $this->send_mail($settings['admin_email'], $subject, $body, false, $attachments);
    }
    /* $this->load->view('site/include/registration_form', $pageData); */
  }

  public function send_contact_form_to_admin($id)
  {
    $pageData = [];
    $pageData['userdata'] = $this->fetch_records('contact_requests', array('id' => $id), false, true);
    $subject = 'Received a new contact request.';
    $pageData['emailContent'] = $this->Common_Model->get_email_content(8);
    $body = $this->load->view('site/include/contact_form', $pageData, true);
    $attachments = [];
    if ($pageData['userdata']['resume'] != '' || $pageData['userdata']['resume'] != null) {
      $attachments[] = site_url($pageData['userdata']['resume']);
    }
    $settings = $this->fetch_records('settings', array('id' => 1), 'contact_email', true);
    if ($this->config->item('ENVIRONMENT') == 'production') {
      $this->send_mail($settings['contact_email'], $subject, $body, false, $attachments);
    }
    /* $this->load->view('site/include/registration_form', $pageData); */
  }

  public function send_request_professional_form_to_admin($id)
  {
    $pageData = [];
    $pageData['userdata'] = $this->fetch_records('professional_requests', array('id' => $id), false, true);
    $subject = 'A new professional request is received.';
    $pageData['emailContent'] = $this->Common_Model->get_email_content(9);
    $body = $this->load->view('site/include/request_professional_form', $pageData, true);

    $attachments = [];
    if ($pageData['userdata']['resume'] != '' || $pageData['userdata']['resume'] != null) {
      $attachments[] = site_url($pageData['userdata']['resume']);
    }

    $settings = $this->fetch_records('settings', array('id' => 1), 'admin_email', true);
    if ($this->config->item('ENVIRONMENT') == 'production') {
      $this->send_mail($settings['admin_email'], $subject, $body, false, $attachments);
    }
    /* $this->load->view('site/include/registration_form', $pageData); */
  }

  public function send_request_professional_confirmation_to_user($id)
  {
    $pageData = [];
    $pageData['userdata'] = $this->fetch_records('professional_requests', array('id' => $id), false, true);
    $subject = 'Thank you for your professional request.';
    $body = "<p>Hello " . $pageData['userdata']['name'] . ",</p>";
    $body .= $this->Common_Model->get_email_content(12);

    $attachments = [];
    if ($pageData['userdata']['resume'] != '' || $pageData['userdata']['resume'] != null) {
      $attachments[] = site_url($pageData['userdata']['resume']);
    }

    if ($this->config->item('ENVIRONMENT') == 'production') {
      $this->send_mail($pageData['userdata']['email'], $subject, $body, false, $attachments);
    }
    /* $this->load->view('site/include/registration_form', $pageData); */
  }

  private function fetch_admin_to_email()
  {
    $adminToEmail = [];
    $admins = $this->fetch_records('admins');
    foreach ($admins as $admin) {
      $permissions = $this->is_admin_authorized($admin['id']);
      if ($permissions[13]) {
        $adminToEmail[] = $admin['email'];
      }
    }
    return $adminToEmail;
  }

  public function send_deletion_confirmation_to_user($userDetails)
  {
    $subject = "Attention! Your account has been deleted by Admin.";
    $body = "<p>" . $userDetails['first_name'] . ' ' . $userDetails['last_name'] . ',';
    $body .= $this->Common_Model->get_email_content(11);
    $this->send_mail($userDetails['email'], $subject, $body);
  }

  public function getPageData()
  {
    $socialAccounts = $this->fetch_records('social_accounts', array('is_active' => 1));
    $cart = $this->session->userdata('cart');
    return array( 'socialAccounts' => $socialAccounts, 'cart' => (!$cart || empty($cart)) ? 0 : count($cart) );
  }
}
