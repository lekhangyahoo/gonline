<?php namespace GoCart\Controller;
/**
 * Product Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Product
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Product extends Front {
    public function index($slug) {
        $product = \CI::Products()->slug($slug);
		//echo '<pre>'; print_r($product);exit;
        if(!$product)
        {
            throw_404();
        }
        else
        {
            $product->images = json_decode($product->images, true);
            if($product->images)
            {
                $product->images = array_values($product->images);
            }
            else
            {
                $product->images = [];
            }

            //set product options
            $data['options'] = \CI::ProductOptions()->getProductOptions($product->id);

            $data['posted_options'] = \CI::session()->flashdata('option_values');

            //get related items
            $data['related'] = $product->related_products;

            //create view variable
            $data['page_title'] = $product->name;
            $data['meta'] = $product->meta;
            $data['seo_title'] = (!empty($product->seo_title))?$product->seo_title:$product->name;
            $data['product'] = $product;

            //load the view
            $this->view('product', $data);
        }
    }
	
	public function generator ($eng,$alt){
		$cos_phi = 0.8;
		
		$engine 	= \CI::Products()->getProduct($eng);
		$engine->manufacturer = \CI::Products()->getManufacturers($engine->manufacturers);
		$alternator = \CI::Products()->getProduct($alt);
		$alternator->manufacturer = \CI::Products()->getManufacturers($alternator->manufacturers);
		
		$engine_parameters 	= \CI::Products()->getParameters($engine->id,'engines');
		$engine_alternator 	= \CI::Products()->getParameters($alternator->id,'alternators');
		//echo '<pre>';print_r($alternator);exit;
		
		$data['page_title'] = $engine->name;
        $data['meta'] 		= $engine->meta;
        $data['seo_title'] 	= (!empty($engine->seo_title))?$engine->seo_title:$engine->name;
        $data['product'] 	= $engine;
		$data['engine_parameters'] 	= $engine_parameters;
		$data['alt'] 				= $alternator;
		$data['engine_alternator'] 	= $engine_alternator;
		
		
		$generators = array();
		$generators['kVA'] = $generators['kVA_standby'] = ($engine_parameters->standby/$cos_phi) * ($engine_alternator->efficiency*0.01);
		$generators['kVA_prime'] = ($engine_parameters->prime/$cos_phi) * ($engine_alternator->efficiency*0.01);
		$generators['price'] = $engine->price_1 + $alternator->price_1;
					
		if($engine_alternator->power < $generators['kVA'])
			$generators['kVA'] = $engine_alternator->power;
					
		if($engine->days > $alternator->days)
			$generators['days'] = $engine->days;
		else $generators['days'] = $alternator->days;	
		
		$generators['name'] = 'G50-'.round($generators['kVA']).$engine->manufacturer->code.$alternator->manufacturer->code.'BA';
		//echo '<pre>';print_r($generators);exit;
		$data['generators'] 	= $generators;
					
			
		$this->view('generator', $data);
	}

}

