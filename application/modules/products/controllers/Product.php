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
    public $eng = '';
    public $alt = '';
    public $con = '';
    public $can = '';
    public $hz = '';
    public $return = false;
    public $other = '';
    public $gen_compare = array();

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
	
	public function generator ($eng, $alt){
		if($eng=='' || $alt =='') redirect(site_url());
		$cos_phi = 0.8;

        $con = \CI::uri()->segment(5);
        $can = \CI::uri()->segment(6);
        $hz = \CI::uri()->segment(7);
        $other = \CI::uri()->segment(8);

        if(!empty($this->gen_compare)){
            $con    = $this->gen_compare['con'];
            $can    = $this->gen_compare['can'];
            $hz     = $this->gen_compare['hz'];
            $other  = $this->gen_compare['other'];
        }

		$engine 	= \CI::Products()->getProduct($eng);
		$alternator = \CI::Products()->getProduct($alt);
		if(empty($engine) || empty($alternator)) redirect(site_url());
		$engine->manufacturer 		= \CI::Products()->getManufacturers($engine->manufacturers);
		$alternator->manufacturer 	= \CI::Products()->getManufacturers($alternator->manufacturers);

		$engine_parameters 	= \CI::Products()->getParameters($engine->id,'engines');
		$engine_alternator 	= \CI::Products()->getParameters($alternator->id,'alternators');
		//echo '<pre>';print_r($alternator);exit;

		$data['page_title'] = $engine->name;
        $data['meta'] 		= $engine->meta;
        $data['seo_title'] 	= (!empty($engine->seo_title))?$engine->seo_title:$engine->name;
        $data['product'] 	= $engine;
		$data['engine_parameters'] 	= $engine_parameters;
		$data['alt'] 				= $alternator;
		$data['eng'] 				= $engine;
		$data['engine_alternator'] 	= $engine_alternator;
        $data['hz']                 = $hz;


		$generators = array();
		$generators['kVA'] = $generators['kVA_standby'] = ($engine_parameters->standby/$cos_phi) * ($engine_alternator->efficiency*0.01);
		$generators['kVA_prime'] = ($engine_parameters->prime/$cos_phi) * ($engine_alternator->efficiency*0.01);
		$generators['price'] = $engine->price_1 + $alternator->price_1;

		if($engine_alternator->power < $generators['kVA'])
			$generators['kVA'] = $engine_alternator->power;

		if($engine->days > $alternator->days)
			$generators['days'] = $engine->days;
		else $generators['days'] = $alternator->days;

		$generators['name'] = 'G'.$hz.'-'.round($generators['kVA']).$engine->manufacturer->code.$alternator->manufacturer->code.'BA';
		//echo '<pre>';print_r($generators);exit;
		$data['generators'] 	= $generators;

		$data['engine_manufacturer'] 		= $engine->manufacturer->name;
		$data['alternator_manufacturer'] 	= $alternator->manufacturer->name;

		//$data['segment_array'] = \CI::uri()->segment_array();

        if(!empty($this->gen_compare)){
            return $data;
        }
		$this->view('generator', $data);
	}

	function documents($eng,$alt, $hz = 50){
		if($eng=='' || $alt =='') redirect(site_url());
		$cos_phi = 0.8;
		
		$engine 	= \CI::Products()->getProduct($eng);
		$alternator = \CI::Products()->getProduct($alt);
		if(empty($engine) || empty($alternator)) redirect(site_url());
		$engine->manufacturer 		= \CI::Products()->getManufacturers($engine->manufacturers);
		$alternator->manufacturer 	= \CI::Products()->getManufacturers($alternator->manufacturers);
		
		$engine_parameters 	= \CI::Products()->getParameters($engine->id,'engines');
		$engine_alternator 	= \CI::Products()->getParameters($alternator->id,'alternators');
		
		$data['page_title'] = $engine->name;
        $data['meta'] 		= $engine->meta;
        $data['seo_title'] 	= (!empty($engine->seo_title))?$engine->seo_title:$engine->name;
        $data['product'] 	= $engine;
		$data['engine_parameters'] 	= $engine_parameters;
		$data['alt'] 				= $alternator;
		$data['eng'] 				= $engine;
		$data['engine_alternator'] 	= $engine_alternator;
		
		
		$generators = array();
		$generators['kVA'] 			= $generators['kVA_standby'] = ($engine_parameters->standby/$cos_phi) * ($engine_alternator->efficiency*0.01);
		$generators['kVA_prime'] 	= ($engine_parameters->prime/$cos_phi) * ($engine_alternator->efficiency*0.01);
		$generators['price'] 		= $engine->price_1 + $alternator->price_1;
					
		if($engine_alternator->power < $generators['kVA'])
			$generators['kVA'] = $engine_alternator->power;
					
		if($engine->days > $alternator->days)
			$generators['days'] 	= $engine->days;
		else $generators['days'] 	= $alternator->days;	
		
		$generators['name'] 		= 'G50-'.round($generators['kVA']).$engine->manufacturer->code.$alternator->manufacturer->code.'BA';
		//echo '<pre>';print_r($generators);exit;
		$data['generators'] 		= $generators;
		
		$data['engine_manufacturer'] 		= $engine->manufacturer->name;
		$data['alternator_manufacturer'] 	= $alternator->manufacturer->name;
		\CI::load()->helper('calculator');
		\CI::load()->helper('html_to_pdf');
		$data['fuel'] 	= get_info_fuel_consumption($engine->id, $alternator->id, $hz);
        //echo '<pre>';print_r($data);exit;
		$html 			= \CI::load()->view('documents', $data, true);
		convert2pdf($html,$data['generators']['name'].'.pdf');
		exit;
	}
	
	function compare(){
		$compare 	= \CI::session()->userdata('compare');
        if(empty($compare)) redirect();
        $data = array();
        foreach($compare as $key=>$uri_string) {
            $data['compare'][$key]['result'] = $this->get_generator_from_compare($uri_string);
            $data['compare'][$key]['uri_string_compare'] = $uri_string;
        }
        $this->view('gen_compare', $data);
        //echo '<pre>';print_r( $data );exit;
	}
	
	function add_compare($type){

        $url = $url_current[] = $_POST['url'];
		$compare 	= \CI::session()->userdata('compare');
		$compare[] 	= $url;

        $compare    = array_unique($compare);
        \CI::session()->set_userdata('compare', $compare);

        $compare 	= \CI::session()->userdata('compare');
        //print_r( $compare );
        if(count($compare)>0) echo true;
        exit;

	}
	
	function remove_compare($type){
        $url[] = $_POST['url'];
		$compare = \CI::session()->userdata('compare');
		$compare 	 = array_diff($compare, $url);
		\CI::session()->set_userdata('compare', $compare);
        //print_r( $compare );
        if(count($compare)>0) echo true;
        exit;
	}

    function get_generator_from_compare($uri_string){
        $uri_string     = explode('/',$uri_string);
        $data['eng']    = $uri_string[2];
        $data['alt']    = $uri_string[3];
        $data['con']    = @$uri_string[4];
        $data['can']    = @$uri_string[5];
        $data['hz']     = @$uri_string[6];
        $data['other']  = 'return';
        $this->gen_compare = $data;
        $generator = $this->generator($data['eng'], $data['alt']);
        return $generator;
    }

}

