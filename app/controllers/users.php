<?php

class Users extends Controller {
	
	function Users()
	{
		parent::Controller();
		$this->load->library('form_validation');
		$this->load->model('user_model');
	}
	
	function edit()
	{
		$user = $this->user_model->find($this->session->userdata('id'));
		
		$fields = array(
			array('field' => 'name', 'label' => 'Name', 'rules' => 'required'),
			// array('field' => 'email', 'label' => 'Email', 'rules' => 'required|valid_email'),
			array('field' => 'password', 'label' => 'Password', 'rules' => ''),
			array('field' => 'confirm', 'label' => 'Password again', 'rules' => 'matches[password]'));
		$this->form_validation->set_rules($fields);
		
		if ($this->form_validation->run())
		{
			$d['name'] = $this->input->post('name');
			$d['email'] = $this->input->post('email');
			if ($this->input->post('password'))
			{
				$d['password'] = $this->input->post('password');
			}
			
			$this->user_model->update($user->id, $d);
			$this->session->set_flashdata('ok', 'Your info have been updated succesfully.');
			redirect('');
		}
		
		$d['user'] = $user;
		$d['view'] = 'users/edit';
		$this->load->view('_template_mini', $d);
	}
	
	function login()
	{
		$fields = array(
			array(
				'field' => 'email',
				'label' => 'E-mail',
				'rules' => 'required|valid_email|trim'),
			array(
				'field' => 'pass',
				'label' => 'Password',
				'rules' => 'required|callback_validate_pass|trim'));
		$this->form_validation->set_rules($fields);
		
		if ($this->form_validation->run())
		{
			$this->db->where('email', $this->input->post('email'));
			$user = $this->db->get('users', 1)->row();
			
			$this->session->set_userdata('email', $user->email);
			$this->session->set_userdata('id', $user->id);
			redirect('');
		}
		
		$d['view'] = 'users/login';
		$this->load->view('_template_mini', $d);
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('users/login');
	}
	
	/* -- callback -- */
	
	function validate_pass($pass)
	{
		$this->db->where('email', $this->input->post('email'));
		$query = $this->db->get('users', 1);
		if ($query->num_rows())
		{
			$user = $query->row();
			if ($user->key == md5($pass))
			{
				return true;
			}
		}
		$this->form_validation->set_message('validate_pass', 'Incorrect e-mail or password.');
		return false;
	}
}

// end of file