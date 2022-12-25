<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Settings extends CI_Controller
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
        $pageData['socialAccounts'] = $this->Common_Model->fetch_records('social_accounts');
        $pageData['pagesContent'] = $this->Common_Model->fetch_records('pages_content', false, false, true);

        $this->load->view('admin/admin_settings', $pageData);
    }

    public function update_social()
    {
        $response['status'] = 0;
        $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
        $updateSocial = [];
        $socialAccounts = $this->Common_Model->fetch_records('social_accounts');
        foreach ($socialAccounts as $socialAccount) {
            $checkIsActive = $this->input->post($socialAccount['icon'] . '_active');
            $updateSocial['is_active'] = ($checkIsActive && $checkIsActive == 'on') ? 1 : 0;
            $updateSocial['url'] = $this->input->post($socialAccount['icon'] . '_url');
            $where['icon'] = $socialAccount['icon'];
            $this->Common_Model->update('social_accounts', $where, $updateSocial);
        }
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Social accounts updated successfully.');
        echo json_encode($response);
    }

    public function update_about()
    {
        $response['status'] = 0;
        $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
        $update['about_us_short'] = $this->input->post('about_us_short');
        $update['about_us_long'] = $this->input->post('about_us_long');
        $this->Common_Model->update('pages_content', array('id' => 1), $update);

        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('About content updated successfully.');
        echo json_encode($response);
    }
}
