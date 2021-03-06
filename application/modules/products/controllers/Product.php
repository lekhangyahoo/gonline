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

			// get documents
			$data['documents'] = \CI::Products()->get_documents($product->id);
			//echo \CI::db()->last_query(); print_r($data['documents']);exit;
			//echo $product->manufacturers;exit;
			// get parameter of product
			$data['get_parameters_of_product'] = \CI::Products()->get_parameters_of_product($product->id, $product->primary_category, $product->manufacturers);
			//echo '<pre>'; print_r($data['documents']);exit;

            //set product options
            $data['options'] 		= \CI::ProductOptions()->getProductOptions($product->id);

            $data['posted_options'] = \CI::session()->flashdata('option_values');

            //get related items
            $data['related'] 		= $product->related_products;

            //create view variable
            $data['page_title'] = $product->name;
            $data['meta'] 		= $product->meta;
            $data['seo_title'] 	= (!empty($product->seo_title))?$product->seo_title:$product->name;
            $data['product'] 	= $product;

            //load the view
            $this->view('product', $data);
        }
    }
	
	public function generator ($eng, $alt, $can, $con, $hz = 50, $phase = 3,$gen_number = 1, $order_id = null){
		/* \CI::load()->library('Setup');
		\CI::Setup()->set(120);
		echo (\CI::Setup()->bon_dung(5000, 2, 3));
		exit;*/
		\CI::lang()->load('products');
		if($order_id > 0){
			$data['order'] = \CI::Orders()->getOrder($order_id, true);
		}
		//echo \CI::db()->last_query();exit;
		if($eng=='' || $alt =='') redirect(site_url());
		$power_factor = 0.8;
        $can 	= \CI::uri()->segment(5); // only test on demo, we will get option for canopy
        $con 	= \CI::uri()->segment(6);
        $hz 	= \CI::uri()->segment(7);
		$phase 	= \CI::uri()->segment(8);
		$gen_number 	= \CI::uri()->segment(9);
		$order_id 	= \CI::uri()->segment(10);
        if(!empty($this->gen_compare)){
            $con    	= $this->gen_compare['con'];
            $can    	= $this->gen_compare['can'];
            $hz     	= $this->gen_compare['hz'];
			$phase  	= $this->gen_compare['phase'];
			$gen_number = $this->gen_compare['gen_number'];
            $other  	= $this->gen_compare['other'];
        }

		if(!isset($gen_number) or $gen_number == 0) $gen_number = 1;

		$engine 	= \CI::Products()->getProduct($eng);
		$alternator = \CI::Products()->getProduct($alt);
        $canopy 	= \CI::Products()->getProduct($can);
        $controller = \CI::Products()->getProduct($con);
        if(empty($engine) || empty($alternator)) redirect(site_url());
		$engine->manufacturer 		= \CI::Products()->getManufacturers($engine->manufacturers);
		$alternator->manufacturer 	= \CI::Products()->getManufacturers($alternator->manufacturers);
        if(isset($canopy->manufacturers)) {
            $canopy->manufacturer 	    = \CI::Products()->getManufacturers($canopy->manufacturers);
            $canopy_manufacturer_code = $canopy->manufacturer->code;
            $price_can = $canopy->price_1;
        }else{
            $canopy_manufacturer_code = 'N';
            $price_can = 0;
        }

        if(isset($controller->manufacturers)) {
            $controller->manufacturer = \CI::Products()->getManufacturers($controller->manufacturers);
            $controller_manufacturer_code = $controller->manufacturer->code;
            $price_con = $controller->price_1;
        }else{
            $controller_manufacturer_code = 'N';
            $price_con = 0;
        }

		$engine_parameters 	= \CI::Products()->getParameters($engine->id,'engines');
		$engine_alternator 	= \CI::Products()->getParameters($alternator->id,'alternators', $hz);
		$parameter_con	 	= \CI::Products()->getParameters($controller->id,'controllers');
        //echo '<pre>';print_r($alternator);exit;

		$get_provinces = \CI::Locations()->get_zones(230);
		foreach($get_provinces as $value){
			$provinces[$value->id] = $value->name;
		}
		$data['provinces'] = $provinces;

		$data['page_title'] = $engine->name;
        $data['meta'] 		= $engine->meta;
        $data['seo_title'] 	= (!empty($engine->seo_title))?$engine->seo_title:$engine->name;
        $data['product'] 	= $engine;
		$data['engine_parameters'] 	= $engine_parameters;
		$data['alt'] 				= $alternator;
		$data['eng'] 				= $engine;
		$data['engine_alternator'] 	= $engine_alternator;
        $data['hz']                 = $hz;
		$data['phase']              = $phase;
		$data['gen_number']         = $gen_number;
        $data['can']                = $can;
        $data['con']                = $con;
		$data['parameter_con']      = $parameter_con;

		$generators 				= array();

		if($engine_alternator->efficiency_standby < $engine_alternator->efficiency)
			$engine_alternator->efficiency_standby = $engine_alternator->efficiency;

		if($hz == 50){
			$generators['kVA'] = $generators['kVA_standby'] = ($engine_parameters->standby / $power_factor) * ($engine_alternator->efficiency * 0.01);
			$generators['kVA_prime'] = ($engine_parameters->prime / $power_factor) * ($engine_alternator->efficiency * 0.01);
		}else {
			$generators['kVA'] = $generators['kVA_standby'] = ($engine_parameters->standby_2 / $power_factor) * ($engine_alternator->efficiency * 0.01);
			$generators['kVA_prime'] = ($engine_parameters->prime_2 / $power_factor) * ($engine_alternator->efficiency * 0.01);
		}

        $generators['price']    = $engine->price_1 + $alternator->price_1 + $price_can + $price_con;

		if($engine_alternator->power < $generators['kVA'])
			$generators['kVA'] = $engine_alternator->power;

		if($engine->days > $alternator->days)
			$generators['days'] = $engine->days;
		else $generators['days']= $alternator->days;

		$generators['name'] = 'G'.(int)($hz/10).'-'.round($generators['kVA']).$engine->manufacturer->code.$alternator->manufacturer->code.$canopy_manufacturer_code.$controller_manufacturer_code;
		//echo '<pre>';print_r($generators);exit;
		$data['generators'] 	= $generators;

		$data['engine_manufacturer'] 		= $engine->manufacturer->name;
		$data['alternator_manufacturer'] 	= $alternator->manufacturer->name;

		//$data['segment_array'] = \CI::uri()->segment_array();

        if(!empty($this->gen_compare)){
            return $data;
        }
        $canopies 	= \CI::Products()->getCanopy();
        $canopy_option[0] = 'No canopy';
        foreach($canopies as $item){
            $canopy_option[$item->product_id] = $item->name;
        }
        //print_r($canopies);exit;
        $data['canopy_option'] 	= $canopy_option;

        $controllers 	= \CI::Products()->getController();
        foreach($controllers as $item){
            $controller_option[$item->product_id] = $item->name;
        }
        //print_r($controller_option);exit;
        $data['controller_option'] 	= $controller_option;

        $this->view('generator', $data);
	}

	function calculator_price_again($eng, $alt, $can, $con, $hz = 50, $phase = 3, $gen_number = 1){
		\CI::lang()->load('products');
		$hz 	= $_POST['hz'];
		$kVA 	= $_POST['kVA'];
		$engine 		= \CI::Products()->getProduct($eng);
		$alternator 	= \CI::Products()->getProduct($alt);
		$canopy			= \CI::Products()->getProduct($can);
		$controller 	= \CI::Products()->getProduct($con);
		$parameter_con 	= \CI::Products()->getParameters($con,'controllers');
		//echo $con ;print_r($controller);exit;

		$engine->manufacturer 		= \CI::Products()->getManufacturers($engine->manufacturers);
		$alternator->manufacturer 	= \CI::Products()->getManufacturers($alternator->manufacturers);
		if(isset($canopy->manufacturers)) {
			$canopy->manufacturer 	    = \CI::Products()->getManufacturers($canopy->manufacturers);
			$canopy_manufacturer_code = $canopy->manufacturer->code;
			$price_can = $canopy->price_1;
		}else{
			$canopy_manufacturer_code = 'N';
			$price_can = 0;
		}

		if(isset($controller->manufacturers)) {
			$controller->manufacturer = \CI::Products()->getManufacturers($controller->manufacturers);
			$controller_manufacturer_code = $controller->manufacturer->code;
			$price_con = $controller->price_1;
		}else{
			$controller_manufacturer_code = 'N';
			$price_con = 0;
		}

		$generators['price']= $engine->price_1 + $alternator->price_1 + $price_can + $price_con;
		$data['currency'] 	= format_currency($generators['price']);
		$data['price'] 		= $generators['price'];
		$data['ats']		= $parameter_con->ats;
		//if($parameter_con->ats == 1)
		if(isset($_POST['ats']))
				$data['gen_control_panel'] = lang('gen_with_ats_control');
		else 	$data['gen_control_panel'] = lang('gen_with_manual_control');
		$data['name'] = 'G'.(int)($hz/10).'-'.$kVA.$engine->manufacturer->code.$alternator->manufacturer->code.$canopy_manufacturer_code.$controller_manufacturer_code;
		echo json_encode($data);
	}

	function documents($eng, $alt, $can, $con,$hz = 50, $phase = 3, $gen_number = 1){
		if($eng=='' || $alt =='') redirect(site_url());
		$power_factor = 0.8;
		
		$engine 	= \CI::Products()->getProduct($eng);
		$alternator = \CI::Products()->getProduct($alt);
		$controller = \CI::Products()->getProduct($con);

		if(empty($engine) || empty($alternator)) redirect(site_url());
		$engine->manufacturer 		= \CI::Products()->getManufacturers($engine->manufacturers);
		$alternator->manufacturer 	= \CI::Products()->getManufacturers($alternator->manufacturers);
		
		$engine_parameters 	= \CI::Products()->getParameters($engine->id,'engines');
		$engine_alternator 	= \CI::Products()->getParameters($alternator->id,'alternators', $hz);
		$parameter_con	 	= \CI::Products()->getParameters($controller->id,'controllers');
		
		$data['page_title'] = $engine->name;
        $data['meta'] 		= $engine->meta;
        $data['seo_title'] 	= (!empty($engine->seo_title))?$engine->seo_title:$engine->name;
        $data['product'] 	= $engine;
		$data['engine_parameters'] 	= $engine_parameters;
		$data['alt'] 				= $alternator;
		$data['eng'] 				= $engine;
		$data['engine_alternator'] 	= $engine_alternator;

        $data['hz']     		= $hz;
        $data['phase']  		= $phase;
		$data['gen_number']  	= $gen_number;
		
		$generators = array();
		$generators['kVA'] 			= $generators['kVA_standby'] = ($engine_parameters->standby/$power_factor) * ($engine_alternator->efficiency*0.01);
		$generators['kVA_prime'] 	= ($engine_parameters->prime/$power_factor) * ($engine_alternator->efficiency*0.01);
		$generators['price'] 		= $engine->price_1 + $alternator->price_1;
					
		if($engine_alternator->power < $generators['kVA'])
			$generators['kVA'] = $engine_alternator->power;
					
		if($engine->days > $alternator->days)
			$generators['days'] 	= $engine->days;
		else $generators['days'] 	= $alternator->days;	
		
		$generators['name'] 		= 'G'.($hz/10).'-'.round($generators['kVA']).$engine->manufacturer->code.$alternator->manufacturer->code.'BA';
		if($gen_number == 3)
			$generators['name']		= $gen_number.'x'.$generators['name'];
		//echo '<pre>';print_r($generators);exit;
		$data['generators'] 		= $generators;
		
		$data['engine_manufacturer'] 		= $engine->manufacturer->name;
		$data['alternator_manufacturer'] 	= $alternator->manufacturer->name;
		\CI::load()->helper('calculator');
		\CI::load()->helper('html_to_pdf');
		$data['fuel'] 	= get_info_fuel_consumption($engine->id, $alternator->id, $hz, $phase);
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
		$data['phase']  = @$uri_string[7];
        $data['other']  = 'return';
        $this->gen_compare = $data;
        $generator = $this->generator($data['eng'], $data['alt'],'', '', $data['hz'], $data['phase']);
        return $generator;
    }
	function contact($type = 1){
		if($_POST['email'] == '') return false;
		
		if($type == 1){
			$data = array('email' => $_POST['email'], 'url' => $_POST['url'], 'date' => time());			
		}
		if($type == 2){
			$data = array('mobile' => $_POST['email'], 'url' => $_POST['url'], 'date' => time());			
		}
		
		if($type == 0){
			$data = array(
				'email' 		=> $_POST['email'],
				'url' 			=> $_POST['url'],
				'mobile' 		=> $_POST['mobile'],
				'company_name' 	=> $_POST['name'],
				'address' 		=> $_POST['address'],
				'subject' 		=> $_POST['subject'],
				'content' 		=> $_POST['content'],
				'date' 			=> time(),
			);
		}
		\CI::db()->insert('contact', $data);
        echo true;
	}
	
	function calculate_setup($type = 1){
		//echo '<pre>';print_r($_POST);exit;
		$kVA 		= $_POST['kVA'];
		$phase 		= $_POST['phase'];
		$gen_number = $_POST['gen_number'];
		\CI::load()->library('Setup');
		\CI::Setup()->set($kVA, $phase, $gen_number);

		if( isset($_POST['bon_dau']) ) {
			\CI::Setup()->bon_dung($_POST['dung_tich_bon_dau'], $_POST['duong_kinh_bon_dau'], $_POST['do_day_bon_dau']);
			\CI::Setup()->ong_dan_dau('ODD21', 'VDD21', $_POST['do_dai_ong_dau'], 1);
			\CI::Setup()->tu_bom($_POST['so_luong_tu_bom']);
		}
		
		//public function ong_khoi($phi, $length, $rockwool = true, $quantity_ong_nhung = 1){

		if( isset($_POST['rockwool']) )  $rockwool = true;
		else $rockwool = false;

		if($kVA <= 15){
			$phi = 49;
			$funnel_quantity = 1;
		}else{
			if($kVA >= 750) \CI::db()->where('group', 2);
			$query = \CI::db()->where('kVA <= ', $kVA)->order_by('kVA','DESC')->limit(1)->get('parameters_kva');
			if ($query->num_rows() > 0){
			   $get_phi = $query->row();
			   if($_POST['do_dai_ong_khoi'] > 20){
				   if($kVA >= 750) \CI::db()->where('group', 2);
				   $query = \CI::db()->where('funnel_phi > ', $get_phi->funnel_phi)->order_by('funnel_phi','ASC')->limit(1)->get('parameters_kva');
				   if ($query->num_rows() > 0){
					   $get_phi = $query->row();
					   $phi = $get_phi->funnel_phi;
				   }else{
					   if($kVA >= 750) \CI::db()->where('group', 2);
					   $query = \CI::db()->order_by('funnel_phi','DESC')->limit(1)->get('parameters_kva');
					   $get_phi = $query->row();
					   $phi = $get_phi->funnel_phi;
				   }
			   }else{
				   $phi = $get_phi->funnel_phi;
			   }
			}else{
				if($kVA >= 750) \CI::db()->where('group', 2);
				$query = \CI::db()->order_by('phi','DESC')->limit(1)->get('parameters_kva');
				$get_phi = $query->row();
				$phi = $get_phi->funnel_phi;
			}
			$funnel_quantity = $get_phi->funnel_quantity;
		}

		if( isset($_POST['vat_tu']) ) {
			\CI::Setup()->ong_khoi($phi, $_POST['do_dai_ong_khoi'], $_POST['do_day_ong_khoi'], $rockwool, 1, $funnel_quantity);
			\CI::Setup()->cap_dong_luc($_POST['do_dai_day_cap']);
			\CI::Setup()->cap_te($_POST['do_dai_day_cap']);
			\CI::Setup()->cap_dieu_khien($_POST['do_dai_day_cap']);// can xac dinh lai do dai
			\CI::Setup()->bao_ve_cap($_POST['do_dai_day_cap']);
			\CI::Setup()->vat_tu_phu(1);
		}

		if( isset($_POST['kiem_dinh']) ){
			\CI::Setup()->kiem_dinh($_POST['kd_chat_luong'], $_POST['kd_tt3'], $_POST['thu_tai_gia']);
		}

		if( isset($_POST['nhan_cong']) ) {
			\CI::Setup()->nhan_cong($_POST['nc_thao_ra_vo'], $_POST['nc_day_vao_vi_tri_dg'], $_POST['nc_day_vao_vi_tri_pt'], $_POST['nc_lap_may'], $_POST['nc_lap_dat_ats'], $_POST['nc_lap_tu_hoa'], $_POST['nc_hd_sudung_nt']);
		}

		if( isset($_POST['van_chuyen']) ) {
			\CI::Setup()->khoang_cach($_POST['province'], $_POST['district'], $_POST['ward'], $_POST['address']);
			\CI::Setup()->vc_thu_cong($_POST['transport_hands']);
		}
		if( isset($_POST['ats']) ) {
			\CI::Setup()->tu_ats();
		}

		if( isset($_POST['thoat_nhiet']) ) {
			\CI::Setup()->thoat_nhiet();
		}


		echo \CI::Setup()->get_all_value();
		exit; 
	}

	function print_order(){
		$order_id 	= \CI::uri()->segment(3);
		$action 	= \CI::uri()->segment(4);
		$data['order'] = \CI::Orders()->getOrder($order_id);
		//echo '<pre>';print_r($data);exit;
		if(empty($action)){
			$html 			= \CI::load()->view('print_order_details', $data, true);
			\CI::load()->helper('html_to_pdf');
			convert2pdf($html,$order_id.'.pdf');
			exit;
			echo 'aaa';exit;
		}else{

		}

	}
}

