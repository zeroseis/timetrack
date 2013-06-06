<?php

class Project_model extends Model
{
	var $table = 'projects';
	
	function Project_model()
	{
		parent::Model();
	}

	function find_all($limit = 0, $offset = 0, $order_by = 'client_name, name')
	{
		if ($limit > 0) $this->db->limit($limit, $offset);
		$this->db->order_by($order_by);
		
		$this->db->select("{$this->table}.*, clients.name AS client_name");
		$this->db->join('clients', "{$this->table}.client_id = clients.id");
		
		$query = $this->db->get($this->table);
		return $query->result();
	}
	
	function find_all_inactive($limit = 0, $offset = 0)
	{
		$this->db->where('active', 0);
		return $this->find_all($limit, $offset);
	}
	
	function find_all_active($limit = 0, $offset = 0)
	{
		$this->db->where('active', 1);
		return $this->find_all($limit, $offset);
	}
	
	// turn project inactive
	function inactivate($id)
	{
		$this->db->where('id', $id);
		$this->db->update($this->table, array('active' => 0));
		if ($this->db->affected_rows()) return TRUE;
		return FALSE;
	}
}

// End of file.