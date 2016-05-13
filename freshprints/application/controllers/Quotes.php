<?php
class Quotes extends CI_Controller {
	
	public function getQuote()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('garment', 'Apparel Type', 'required');
		$this->form_validation->set_rules('quantity', 'Quantity', 'integer|greater_than[0]|required');
		$this->form_validation->set_rules('numColorFront', 'Number of Colors on the Front', 'required');
		$this->form_validation->set_rules('numColorBack', 'Number of Colors on the Back', 'required');
		
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view("header");
			$this->load->view("form");
			$this->load->view("footer");
		}
		else 
		{	
			$this->load->model('garment_model');
			$this->load->model('color_price_model');
			
			$data = array(
                'garment' => $this->input->post('garment'),
           		'quantity' => $this->input->post('quantity'),
           		'numColorFront' => $this->input->post('numColorFront'),
				'numColorBack' => $this->input->post('numColorBack'),
          	);
			
			$price['garment'] = $this->garment_model->getGarmentPrice($data['garment'],$data['quantity'],$data['numColorFront'],$data['numColorBack']);
			$price['colorFront'] = $this->color_price_model->getPrice($data['numColorFront'],$data['quantity']);  
			$price['colorBack'] = $this->color_price_model->getPrice($data['numColorBack'],$data['quantity']);  
			$price['shipping'] = $this->garment_model->getShippingPrice($data['garment'],$data['quantity']);
			
			$price ['compensation'] = $this->garment_model->getCompensation($price['garment'], $price['colorFront'], $price['colorBack'], $price['shipping']);
			$price ['markup'] = $this->garment_model->getMarkUp($price['garment'], $price['colorFront'], $price['colorBack'], $price['shipping'], $price ['compensation']);
			$price ['total'] = $this->garment_model->getTotal ($price['garment'], $price['colorFront'], $price['colorBack'], $price['shipping'], $price ['compensation'], $price['markup']);
			$price ['perUnit'] = round($price['total']/$data['quantity'],2);
			
			$this->load->view("header");
			$this->load->view("displayQuote", $price);
			$this->load->view("footer");
		}
	}
}