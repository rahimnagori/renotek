<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Slider extends CI_Controller
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
        $pageData['sliders'] = $this->Common_Model->fetch_records('slider_management');

        $this->load->view('admin/slider_management', $pageData);
    }

    public function add_slider()
    {
        $response['status'] = 0;
        $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
        if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 8)) {
            $insert = $this->create_slider();
            if ($_FILES['slider_image']['error'] == 0) {
                $config['upload_path'] = "assets/site/img/slider/";
                $config['allowed_types'] = 'jpeg|gif|jpg|png';
                $config['encrypt_name'] = true;
                $this->load->library("upload", $config);
                if ($this->upload->do_upload('slider_image')) {
                    $productImage = $this->upload->data("file_name");
                    $insert['slider_image'] = "assets/site/img/slider/" . $productImage;

                    if ($this->Common_Model->insert('slider_management', $insert)) {
                        $response['status'] = 1;
                        $response['responseMessage'] = $this->Common_Model->success('Slider added successfully.');
                        $this->session->set_flashdata('responseMessage', $response['responseMessage']);
                    }
                } else {
                    $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
                }
            }
        } else {
            $response['status'] = 2;
            $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized to perform this action.');
        }
        echo json_encode($response);
    }

    public function delete_slider()
    {
        $response['status'] = 0;
        $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
        if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
            $where['id'] = $this->input->post('delete_slider_id');
            if ($this->Common_Model->delete('slider_management', $where)) {
                $response['status'] = 1;
                $response['responseMessage'] = $this->Common_Model->success('Slider deleted successfully.');
            }
            $this->session->set_flashdata('responseMessage', $response['responseMessage']);
        } else {
            $response['status'] = 2;
            $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
        }
        echo json_encode($response);
    }

    public function get_slider($id)
    {
        if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
            $pageData['sliderDetails'] = $this->Common_Model->fetch_records('slider_management', array('id' => $id), false, true);
            $this->load->view('admin/include/slider_details', $pageData);
        } else {
            $response['status'] = 2;
            echo $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
        }
    }

    public function update_slider()
    {
        $response['status'] = 0;
        $response['responseMessage'] = $this->Common_Model->error('Something went wrong.');
        if (true || $this->Common_Model->is_admin_authorized($this->session->userdata('id'), 9)) {
            $update = $this->create_slider('update');
            $where['id'] = $this->input->post('slider_id');
            if ($_FILES['update_slider_image']['error'] == 0) {
                $config['upload_path'] = "assets/site/img/slider/";
                $config['allowed_types'] = 'jpeg|gif|jpg|png';
                $config['encrypt_name'] = true;
                $this->load->library("upload", $config);
                if ($this->upload->do_upload('update_slider_image')) {
                    $sliderImage = $this->upload->data("file_name");
                    $update['slider_image'] = "assets/site/img/slider/" . $sliderImage;
                    $oldFile = $this->input->post('old_slider_image');
                    // if(file_exists($oldFile)) unlink($oldFile);
                } else {
                    $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
                }
            }
            if ($this->Common_Model->update('slider_management', $where, $update)) {
                $response['status'] = 1;
                $response['responseMessage'] = $this->Common_Model->success('Slider updated successfully.');
            }
            $this->session->set_flashdata('responseMessage', $response['responseMessage']);
        } else {
            $response['status'] = 2;
            $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized. Please contact Admin');
        }
        echo json_encode($response);
    }

    private function create_slider($update = false)
    {
        $data = [
            'heading' => $this->input->post('heading'),
            'sub_heading' => $this->input->post('sub_heading'),
            'url' => $this->input->post('url'),
        ];
        // if (!$update) {
        //   $data['created'] = date("Y-m-d H:i:s");
        // }
        return $data;
    }

    public function image($id)
    {
        $pageData = $this->Common_Model->getAdmin($this->session->userdata('id'));

        $pageData['sliderDetails'] = $this->Common_Model->fetch_records('slider_management', array('id' => $id), false, true);
        if (empty($pageData['sliderDetails'])) {
            $this->session->set_flashdata('responseMessage', $this->Common_Model->error('Product not found'));
            redirect('Admin-Products');
        }
        $pageData['productImages'] = $this->Common_Model->fetch_records('product_images', array('slider_id' => $id));

        $this->load->view('admin/product_images_management', $pageData);
    }

    public function add_image()
    {
        $response['status'] = 0;
        $insert['slider_id'] = $this->input->post('slider_id');
        if ($_FILES['product_image']['error'] == 0) {
            $config['upload_path'] = "assets/site/img/slider/";
            $config['allowed_types'] = 'jpeg|gif|jpg|png';
            $config['encrypt_name'] = true;
            $this->load->library("upload", $config);
            if ($this->upload->do_upload('product_image')) {
                $productImage = $this->upload->data("file_name");

                $insert['product_image'] = "assets/site/img/slider/" . $productImage;

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
            $slider_id = $this->input->post('slider_id');
            // $sliderDetails = $this->Common_Model->fetch_records('slider_management', array('id' => $slider_id), false, true);
            $imageDetails = $this->Common_Model->fetch_records('product_images', $where, false, true);
            if ($this->Common_Model->delete('product_images', $where)) {
                if (file_exists($imageDetails['product_image'])) unlink($imageDetails['product_image']);
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
                $config['upload_path'] = "assets/site/img/slider/";
                $config['allowed_types'] = 'jpeg|gif|jpg|png';
                $config['encrypt_name'] = true;
                $this->load->library("upload", $config);
                if ($this->upload->do_upload('product_image')) {
                    $productImage = $this->upload->data("file_name");

                    $update['product_image'] = "assets/site/img/slider/" . $productImage;
                    $where['id'] = $imageId;
                    if ($this->Common_Model->update('product_images', $where, $update)) {
                        if (file_exists($imageDetails['product_image'])) unlink($imageDetails['product_image']);
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
