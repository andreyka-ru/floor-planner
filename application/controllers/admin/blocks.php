<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blocks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('blocks_model');
        $this->load->model('objects_model');
        $this->load->model('floors_model');
        $this->load->helper('language');
    }

    public function index() {
        if(!$this->ion_auth->logged_in()) {
            redirect('admin', 'refresh');
        }
        $data['main_menu'] = 'blocks';
        $data['menu'] = array();
        $data['usermenu'] = array();

        $data['message'] =  $this->session->flashdata('message')? $this->session->flashdata('message'):'';
        $data['objects_list'] = $this->objects_model->getObjects();
        if (!empty($_POST['object_id']))
            $data['object_id'] = $_POST['object_id'];
        else
            $data['object_id'] = $data['objects_list'][0]['id'];

        $data['blocks_list'] = $this->blocks_model->getBlocks($data['object_id']);
        //print_r($data['blocks_list']);
        foreach ($data['blocks_list'] as $i => $block)
        {
            $data['blocks_list'][$i]['floors'] = $this->floors_model->getFloors($block['id']);
        }
        $this->load->view('admin/header', $data);
        $this->load->view('admin/blocks/index', $data);
        $this->load->view('admin/footer', $data);
    }

    public function addBlock()
    {
        $this->form_validation->set_rules('numb_block', '', 'required');
        if ($this->form_validation->run() == true)
        {
            $data = array(
                'numb_block' => $this->input->post('numb_block'),
                'object_id' => $this->input->post('object_id')

            );
            $output["id"] = $this->blocks_model->addBlock($data);
            $output["numb_block"] = $this->input->post('numb_block');
            $output["success"] = "ok";
        }
        else
        {
            $output["error"] = "error";
        }
        echo json_encode($output);
    }

    public function delBlock()
    {

        if (!empty($_POST['block_id']) and $this->blocks_model->delete($_POST['block_id']))
        {


            $output["success"] = "ok";
        }
        else
        {
            $output["error"] = "error";
        }

        echo json_encode($output);
    }
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */