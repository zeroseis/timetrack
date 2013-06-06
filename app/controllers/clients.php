<?php

class Clients extends Controller {
	
	var $rules = array(
		array('field' => 'name', 'label' => 'Name', 'rules' => 'required')
	);
	
	function Clients()
	{
		parent::Controller();
		
		// verify if user is logged in
		if ( ! $this->session->userdata('email'))
		{
			redirect('users/login');
		}
	}
	
	function index()
	{
		$this->db->order_by('name');
		$get = $this->db->get('clients');
		$clients= $get->result();
		
		$d['clients'] = $clients;
		$d['view'] = 'clients/index';
		$this->load->view('_template', $d);
	}
	
	function edit($id)
	{
		$get = $this->db->get_where('clients', array('id' => $id));
		$client = $get->row_array();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules);
		
		if ($this->form_validation->run())
		{
			$c['name'] = $this->input->post('name');
			$this->db->update('clients', $c, array('id' => $id));
			redirect('clients');
		}
		
		$d['client'] = $client;
		$d['view'] = 'clients/edit';
		$this->load->view('_template_mini', $d);
	}
	
	function create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules);
		
		if ($this->form_validation->run())
		{
			$c['name'] = $this->input->post('name');
			$c['key'] = uniqid();
			$this->db->insert('clients', $c);
			redirect('clients');
		}
		
		$client['name'] = '';
		
		$d['client'] = $client;
		$d['view'] = 'clients/create';
		$this->load->view('_template_mini', $d);
	}
	
	function delete($id)
	{
		// excluir os projetos e respectivas tarefas relacionadas ao cliente
		$query = $this->db->get_where('projects', array('client_id' => $id));
		$projects = $query->result();
		foreach ($projects as $p)
		{
			$this->db->delete('tasks', array('project_id' => $p->id));
		}
		$this->db->delete('projects', array('client_id'=> $id));
		
		// excluir o cliente
		$this->db->delete('clients', array('id' => $id));
		
		redirect('clients');
	}
}

// end of file