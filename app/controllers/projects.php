<?php

class Projects extends Controller {
	
	var $rules = array(
		array('field' => 'name', 'label' => 'Name', 'rules' => 'required'),
		array('field' => 'client_id', 'label' => 'Cliente', 'rules' => 'required|is_natural_no_zero')
	);
	
	function Projects()
	{
		parent::Controller();
		
		// verify if user is logged in
		if ( ! $this->session->userdata('email'))
		{
			redirect('users/login');
		}
		
		$this->load->model('project_model');
	}
	
	function index()
	{
		$projects = $this->project_model->find_all_active();
		
		$d['projects'] = $projects;
		$d['view'] = 'projects/index';
		
		$this->load->view('_template', $d);
	}
	
	function inactive()
	{
		$projects = $this->project_model->find_all_inactive();
		
		$d['projects'] = $projects;
		$d['view'] = 'projects/inactive';
		
		$this->load->view('_template', $d);
	}
	
	function create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules);
		
		if ($this->form_validation->run())
		{
			$p['name'] = $this->input->post('name');
			$p['client_id'] = $this->input->post('client_id');
			$p['billable'] = $this->input->post('billable');
			$p['active'] = $this->input->post('active');
			$this->db->insert('projects', $p);
			redirect('projects');
		}
		
		// create empty project
		$project['name']      = '';
		$project['client_id'] = '';
		$project['billable']  = 1;
		$project['active']    = 1;
		
		// load clients list for dropdown
		$clients[] = '--';
		$this->db->order_by('name');
		$get = $this->db->get('clients');
		foreach ($get->result() as $c)
		{
			$clients[$c->id] = $c->name;
		}
		
		$d['project'] = $project;
		$d['clients'] = $clients;
		$d['view'] = 'projects/create';
		$this->load->view('_template_mini', $d);
	}
	
	function edit($id)
	{
		$get = $this->db->get_where('projects', array('id' => $id));
		$project = $get->row_array();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules);
		
		if ($this->form_validation->run())
		{
			$p['name'] = $this->input->post('name');
			$p['client_id'] = $this->input->post('client_id');
			$p['billable'] = $this->input->post('billable');
			$p['active'] = $this->input->post('active');
			$this->db->limit(1);
			$this->db->update('projects', $p, array('id' => $id));
			redirect('projects');
		}
		
		// load clients list for dropdown
		$clients[] = '--';
		$this->db->order_by('name');
		$get = $this->db->get('clients');
		foreach ($get->result() as $c)
		{
			$clients[$c->id] = $c->name;
		}
		
		$d['project'] = $project;
		$d['clients'] = $clients;
		$d['view'] = 'projects/edit';
		$this->load->view('_template_mini', $d);
	}
	
	function delete($id)
	{
		$this->db->delete('tasks', array('project_id' => $id));
		$this->db->delete('projects', array('id' => $id));
		redirect('projects');
	}
	
	function inactivate($id = 0)
	{
		$this->project_model->inactivate($id);
		redirect('projects');
	}
}


// end of file