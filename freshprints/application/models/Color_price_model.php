<?php
class Color_price_model extends CI_Model
{
	private $_quantity;
	private $_price_1;
	private $_price_2;
	private $_price_3;
	private $_price_4;
	private $_price_5;
	private $_price_6;
	
	public function getPrice ($numColors, $quantity)
	{
		if ($numColors == 0)
			return 0;
		
		$query = $this->db->query('SELECT quantity, one, two, three, four, five, six FROM pricing_list ORDER BY quantity');
		
		foreach ($query->result_array() as $row)
		{
			if ($row['quantity'] >= $quantity) {
				break;
			}
		}
		
		if ($numColors == 1)
			return $row['one']*$quantity;
		else if ($numColors == 2)
			return $row['two']*$quantity;
		else if ($numColors == 3)
			return $row['three']*$quantity;
		else if ($numColors == 4)
			return $row['four']*$quantity;
		else if ($numColors == 5)
			return $row['five']*$quantity;
		else
			return $row['six']*$quantity;
		
	}
}