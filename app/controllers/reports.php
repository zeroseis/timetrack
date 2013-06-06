<?php

class Reports extends Controller {
	
	function Reports()
	{
		parent::Controller();
	}
	
	function client($client_key = '')
	{
		// verify if the client_key is valid
		$this->db->where('key', $client_key);
		$query = $this->db->get('clients', 1);
		if ( ! $query->num_rows() || empty($client_key)) show_404($this->uri->uri_string());
		
		// load client data
		$client = $query->row();
		
		// load list of projects with time worked and last activity date
		$this->db->select('projects.*, SUM(tasks.end - tasks.start) AS time, MAX(tasks.end) AS last_activity');
		$this->db->join('tasks', 'tasks.project_id = projects.id');
		$this->db->where('client_id', $client->id);
		$this->db->where('billable', 1);
		$this->db->where('tasks.end IS NOT NULL');
		$this->db->group_by('projects.id');
		$this->db->order_by('last_activity', 'DESC');
		$query = $this->db->get('projects');
		$projects = $query->result();
		
		// load total time worked for the client
		$this->db->select('SUM(tasks.end - tasks.start) AS total');
		$this->db->join('projects', 'projects.id = tasks.project_id');
		$this->db->join('clients', 'clients.id = projects.client_id');
		$this->db->where('clients.id', $client->id);
		$this->db->where('billable', 1);
		$this->db->where('tasks.end IS NOT NULL');
		$this->db->group_by('clients.id');
		$total = $this->db->get('tasks')->row()->total;
		
		$d['client']   = $client;
		$d['projects'] = $projects;
		$d['total']    = $total;
		
		$d['view'] = 'reports/client';
		$this->load->view('_template_report', $d);
	}
	
	function project($client_key = '', $id = 0)
	{
		// verify if client_key and project id are valid
		$this->db->select('projects.*, clients.name AS client_name, clients.key AS client_key');
		$this->db->join('clients', 'clients.id = projects.client_id');
		$this->db->where('clients.key', $client_key);
		$this->db->where('projects.id', $id);
		$query = $this->db->get('projects', 1);
		if ( ! $query->num_rows()) show_404($this->uri->uri_string());
		
		// load project data
		$project = $query->row();
		
		// load tasks done for the project
		$this->db->select('tasks.*, users.name AS user_name');
		$this->db->join('users', 'users.id = tasks.user_id');
		$this->db->where('project_id', $id);
		$this->db->where('tasks.end IS NOT NULL');
		$this->db->order_by('start');
		$query = $this->db->get('tasks');
		$tasks = $query->result();
		
		// load total time worked for the project
		$this->db->select('SUM(end - start) AS total');
		$this->db->where('project_id', $id);
		$this->db->where('tasks.end IS NOT NULL');
		$this->db->group_by('project_id');
		$total = $this->db->get('tasks')->row()->total;
		
		// load users info and create a tag for each one
		$this->db->order_by('name');
		$query = $this->db->get('users');
		$users = $query->result();
		
		$d['project'] = $project;
		$d['tasks']   = $tasks;
		$d['total']   = $total;
		$d['users']   = $users;
		
		$this->load->helper('date');
		$d['view'] = 'reports/project';
		$this->load->view('_template_report', $d);
	}
}

// end of file