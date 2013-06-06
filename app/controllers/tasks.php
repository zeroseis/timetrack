<?php

class Tasks extends Controller {

	var $rules = array(
		array('field' => 'date', 'label' => 'Date', 'rules' => 'required'),
		array('field' => 'start', 'label' => 'Start', 'rules' => 'trim|required|callback_valid_time'),
		array('field' => 'end', 'label' => 'End', 'rules' => 'trim|callback_valid_time'),
		array('field' => 'description', 'label' => 'Description', 'rules' => ''),
		array('field' => 'project_id', 'label' => 'Project', 'rules' => 'required|is_natural_no_zero'),
		array('field' => 'user_id', 'label' => 'User', 'rules' => 'required|is_natural_no_zero')
	);

	function Tasks()
	{
		parent::Controller();
		
		// verify if user is logged in
		if ( ! $this->session->userdata('email'))
		{
			redirect('users/login');
		}
	}
	
	function index($client = 0, $proj = 0, $user = 0, $from = 0, $to = 9999999999)
	{	
		$this->db->start_cache();
		if (strripos($this->session->userdata('email'), '@latitude14.com.br') === false) {
			$user = $this->session->userdata('id');
		}
		if ($client > 0) $this->db->where('clients.id', $client);
		if ($proj > 0) $this->db->where('project_id', $proj);
		if ($user > 0) $this->db->where('user_id', $user);
		$this->db->where('start >', $from);
		$this->db->where('start <', $to);
		$this->db->join('projects', 'projects.id = tasks.project_id', 'left');
		$this->db->join('clients', 'clients.id = projects.client_id', 'left');
		$this->db->join('users', 'users.id = tasks.user_id', 'left');
		$this->db->stop_cache();
		
		// carregar lista de tarefas
		// se não foi feita filtragem nenhuma, exibir somente as recentes
		if ($client == 0 and $proj == 0 and $user == 0 and $from == 0 and $to == 9999999999)
		{
			$this->db->limit(10);
		}
		$this->db->select('tasks.*, projects.name AS project_name, users.name AS user_name, clients.name AS client_name, clients.id AS client_id');
		$this->db->order_by('start', 'DESC');
		$get = $this->db->get('tasks');
		$tasks = $get->result();
		
		// calcular tempo total
		$this->db->where('end IS NOT NULL');
		$this->db->select('SUM(end - start) AS total');
		$total = $this->db->get('tasks')->row()->total;
		
		$this->db->flush_cache();
		
		// load projects list for filter dropdown
		$this->load->model('project_model');
		$projects[''] = '--';
		foreach ($this->project_model->find_all_active() as $p)
		{
			$projects["{$p->client_id}-{$p->id}"] = "{$p->client_name} – $p->name";
		}
		
		// load users list for filter dropdown
		$this->load->model('user_model');
		$users[''] = '--';
		foreach ($this->user_model->find_all() as $u)
		{
			$users[$u->id] = $u->name;
		}		
		
		$d['proj'] = "$client-$proj";
		$d['from'] = ($from) ? date('d/m/Y', $from) : '';
		$d['to']   = ($to != 9999999999) ? date('d/m/Y', $to) : '';
		$d['user'] = $user;
		
		$d['tasks']    = $tasks;
		$d['total']    = $total;
		$d['projects'] = $projects;
		$d['users']    = $users;
		$d['view']     = 'tasks/index';
		
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->view('_template', $d);
	}
	
	function create()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules);
		
		if ($this->form_validation->run())
		{
			list($day, $month, $year) = explode('/', $this->input->post('date'));
			
			list($start_hour, $start_min) = explode(':', $this->input->post('start'));
			$start = mktime($start_hour, $start_min, 0, $month, $day, $year);
			
			$end = NULL;
			if ($this->input->post('end'))
			{
				list($end_hour, $end_min) = explode(':', $this->input->post('end'));
				$end = mktime($end_hour, $end_min, 0, $month, $day, $year);
				
				// if end date < start date, it's on the next day, so 
				// add 24 hours to it
				if ($end < $start)
				{
					$end += 86400; // a day in seconds
				}
			}
			
			$t['start'] = $start;
			$t['end']   = $end;
			$t['description'] = $this->input->post('description');
			$t['project_id']  = $this->input->post('project_id');
			$t['user_id']     = $this->input->post('user_id');
			
			$this->db->insert('tasks', $t);
			
			redirect("tasks");
		}
		
		$task['date']  = date('d/m/Y');
		$start_time = mktime(date('H'), (round(date('i') / 5) * 5), 0, date('m'), date('d'), date('Y'));
		$task['start'] = date('H:i', $start_time);
		$task['end']   = '';
		$task['description'] = '';
		$task['project_id'] = '';
		$task['user_id'] = $this->session->userdata('id');
		
		
		// load list for project dropdown
		$this->load->model('project_model');
		$projects[''] = '--';
		foreach ($this->project_model->find_all_active() as $p)
		{
			$projects[$p->id] = "{$p->client_name} – $p->name";
		}
		
		// load list for user dropdown
		if (strripos($this->session->userdata('email'), '@latitude14.com.br') === false) {
			$this->db->order_by('name');
			$get = $this->db->get('users');
			foreach ($get->result() as $user)
			{
				if ($user->id == $this->session->userdata('id')) $users[$user->id] = $user->name;
			}
		} else {
			$users[''] = '--';
			$this->db->order_by('name');
			$get = $this->db->get('users');
			foreach ($get->result() as $user)
			{
				$users[$user->id] = $user->name;
			}
		}
		
		$d['projects'] = $projects;
		$d['users'] = $users;
		$d['task'] = $task;
		$d['view'] = 'tasks/create';
		$this->load->view('_template_mini', $d);
	}
	
	function edit($id)
	{
		$get = $this->db->get_where('tasks', array('id' => $id));
		$task = $get->row_array();
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->rules);
		
		if ($this->form_validation->run())
		{
			list($day, $month, $year) = explode('/', $this->input->post('date'));
			
			list($start_hour, $start_min) = explode(':', $this->input->post('start'));
			$start = mktime($start_hour, $start_min, 0, $month, $day, $year);
			
			$end = NULL;
			if ($this->input->post('end'))
			{
				list($end_hour, $end_min) = explode(':', $this->input->post('end'));
				$end = mktime($end_hour, $end_min, 0, $month, $day, $year);
				
				// if end date < start date, it's on the next day, so 
				// add 24 hours to it
				if ($end < $start)
				{
					$end += 86400; // a day in seconds
				}
			}
			
			$t['start'] = $start;
			$t['end']   = $end;
			$t['description'] = $this->input->post('description');
			$t['project_id']  = $this->input->post('project_id');
			$t['user_id']     = $this->input->post('user_id');
			
			$this->db->update('tasks', $t, array('id' => $id));
			
			redirect("tasks");
		}
		
		$task['date']  = date('d/m/Y', $task['start']);
		$task['start'] = date('H:i', $task['start']);
		$task['end']   = ($task['end']) ? date('H:i', $task['end']) : '';
		
		// load list for project dropdown
		$this->load->model('project_model');
		$projects[''] = '--';
		foreach ($this->project_model->find_all_active() as $p)
		{
			$projects[$p->id] = "{$p->client_name} – $p->name";
		}
		
		// load user list
		if (strripos($this->session->userdata('email'), '@latitude14.com.br') === false) {
			$this->db->order_by('name');
			$get = $this->db->get('users');
			foreach ($get->result() as $user)
			{
				if ($user->id == $this->session->userdata('id')) $users[$user->id] = $user->name;
			}
		} else {
			$users[''] = '--';
			$this->db->order_by('name');
			$get = $this->db->get('users');
			foreach ($get->result() as $user)
			{
				$users[$user->id] = $user->name;
			}
		}
		
		$d['projects'] = $projects;
		$d['users'] = $users;
		$d['task'] = $task;
		$d['view'] = 'tasks/edit';
		$this->load->view('_template_mini', $d);
	}
	
	
	
	function duplicate($id = 0)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('tasks');
		
		if ($query->num_rows() < 1) show_404($this->uri->uri_string());
		
		$task = $query->row_array();
		$task['date']  = date('d/m/Y', $task['start']);
		$task['start'] = date('H:i', $task['start']);
		$task['end']   = ($task['end']) ? date('H:i', $task['end']) : '';
		
		
		// load list for project dropdown
		$this->load->model('project_model');
		$projects[''] = '--';
		foreach ($this->project_model->find_all_active() as $p)
		{
			$projects[$p->id] = "{$p->client_name} – $p->name";
		}
		
		// load user list
		if (strripos($this->session->userdata('email'), '@latitude14.com.br') === false) {
			$this->db->order_by('name');
			$get = $this->db->get('users');
			foreach ($get->result() as $user)
			{
				if ($user->id == $this->session->userdata('id')) $users[$user->id] = $user->name;
			}
		} else {
			$users[''] = '--';
			$this->db->order_by('name');
			$get = $this->db->get('users');
			foreach ($get->result() as $user)
			{
				$users[$user->id] = $user->name;
			}
		}
		
		$this->load->helper('form');
		
		$d['projects'] = $projects;
		$d['users'] = $users;
		$d['task'] = $task;
		$d['view'] = 'tasks/create';
		$this->load->view('_template_mini', $d);
	}
	
	
	
	function filter()
	{
		if ($this->input->post('proj'))
		{
			list($client, $proj) = explode("-", $this->input->post('proj'));
		}
		else
		{
			$client = 0;
			$proj = 0;
		}
		
		$user = ($this->input->post('user')) ? $this->input->post('user') : 0;
		
		
		if ($this->input->post('from') and $this->input->post('to'))
		{
			list($from_day, $from_month, $from_year) = explode("/", $this->input->post('from'));
			$from = mktime(0, 0, 0, $from_month, $from_day, $from_year);
			list($to_day, $to_month, $to_year) = explode("/", $this->input->post('to'));
			$to = mktime(0, 0, 0, $to_month, $to_day, $to_year);
		}
		else
		{
			$from = 0;
			$to = 9999999999;
		}
		
		redirect("tasks/index/$client/$proj/$user/$from/$to");
	}
	
	
	
	function delete($id)
	{
		$this->db->delete('tasks', array('id' => $id));
		redirect('tasks');
	}
	
	
	/*-- callback validation functions --*/
	
	function valid_time($t)
	{
		if (empty($t) or preg_match("/^([0-1]?[0-9]|2[0-3]):[0-5]?[0-9]$/", $t)) return true;
		$this->form_validation->set_message('valid_time', 'The %s field must be a valid time (hh:mm).');
		return false;
	}
}

/* End of file */