<?php
class Garment_model extends CI_Model
{
	private $_id;
	private $_garment;
	private $_price_white;
	private $_price_color;
	private $_shipping;
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function getID()
	{
		return $this->_id;
	}
	
	public function getGarmentPrice($garment, $quantity, $numColorFront, $numColorBack) 
	{
		$query = $this->db->query("SELECT garment, price_white, price_color FROM apparel_data WHERE garment = '$garment'");
		foreach ($query->result_array() as $row)
		{
			if ($numColorFront == 0 && $numColorBack == 0)
				return $row['price_white']*$quantity;
			else
				return $row['price_color']*$quantity;
		}
	}
	
	public function getShippingPrice($garment, $quantity)
	{
		$query = $this->db->query("SELECT garment, shipping FROM apparel_data WHERE garment = '$garment'");
		foreach ($query->result_array() as $row)
		{
			if ($row['shipping']== 1)
			{
				if ($quantity <48) 
					return $quantity;		
				else 
					return $quantity*0.75;
			}
			else 
			{
				if ($quantity <48)
					return $quantity*0.5;
				else
					return $quantity*0.25;
			}
		}
	}
	
	public function getCompensation($priceGarment, $priceColorFront, $priceColorBack, $shipping)
	{
		return round(0.07*($priceGarment+$priceColorFront+$priceColorBack+$shipping) ,2);
	}
	
	public function getMarkUp($priceGarment, $priceColorFront, $priceColorBack, $shipping, $compensation)
	{
		$subTotal = $priceGarment+$priceColorFront+ $priceColorBack+$shipping + $compensation;
		if ($subTotal > 800) {
			return round(0.45*($subTotal) ,2);
		} else {
			return round(0.55*($subTotal) ,2);
		}
	}
	
	public function getTotal ($priceGarment, $priceColorFront, $priceColorBack, $shipping, $compensation, $markup) {
		return $priceGarment+$priceColorFront+ $priceColorBack+$shipping + $compensation + $markup;
	}
}