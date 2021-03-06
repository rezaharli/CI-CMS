<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Public_Controller {

	function __construct()
	{
		parent::__construct();
	}

	//Load Login Form
	function index($url = 'ZGFzaGJvYXJk')
	{
        $this->template
        	->set_theme('admin')
        	->title('Login')

        	->set('url', $url)

        	->set_layout('login.html')

        	->set_partial('form','partials/login_form.html')
        	->set_partial('header','partials/login_header.html');
		ci()->data['results'] = 'test';
        $this->build();
	}

	//Login Proses
	function do_login()
	{
		//validate form input
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
	    $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

		if ($this->form_validation->run() == true)
		{ 
			//check to see if the user is logging in
			//check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{ 
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('message_title', 'welcome to melody manager');
				$this->session->set_flashdata('message_body', $this->ion_auth->messages());
				redirect(base64_decode($this->input->post('url')), 'refresh');
			}
			else
			{ 
				//if the login was un-successful
				//redirect them back to the login page
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('message_body', $this->ion_auth->errors());
				redirect('users/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{  
			//the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->index();
		}
	}
}
