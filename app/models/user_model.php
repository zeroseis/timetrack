<?php

class User_model extends Model
{
	var $table = 'users';
	
	function User_model()
	{
		parent::Model();
	}
	
	function find_all($limit = 0, $offset = 0, $order_by = 'name')
	{
		if ($limit > 0) $this->db->limit($limit, $offset);
		$this->db->order_by($order_by);		
		$query = $this->db->get($this->table);
		return $query->result();
	}

	function find($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->table, 1);
		return $query->row();
	}
	
	function update($id, $data)
	{
		if (isset($data['password']))
		{
			$data['key'] = md5($data['password']);
			unset($data['password']);
		}
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
}

// End of file.