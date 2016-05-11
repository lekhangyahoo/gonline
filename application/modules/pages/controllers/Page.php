<?php namespace GoCart\Controller;
/**
 * Page Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Page
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Page extends Front{

    public function homepage()
    {
		//echo FCPATH.'themes/'.config_item('theme').'/views/homepage.php';exit;
        //do we have a homepage view?
		\CI::load()->model(['Products', 'Categories']);
        \CI::load()->helper('form');
        \CI::lang()->load('products');
		/*
		\CI::load()->helper('calculator');
		\CI::load()->helper('html_to_pdf');
		get_exchangeRates();exit;
		convert2pdf('','');exit;
		*/
        if(file_exists(FCPATH.'themes/'.config_item('theme').'/views/homepage.php'))
        {
			$data['power']      = @$_POST['power'];
            $data['hz']         = @$_POST['hz'];
            $data['phase']      = @$_POST['phase'];
			$engines            = array();
			$alternators        = array();
			$generators         = array();
			$data['engines']    = $engines;
			$data['alternators']= $alternators;
            $data['stand_by']   = isset($_POST['stand_by'])?$_POST['stand_by']:1;
			
			if($data['power'] > 0){
                $data['hz']         = @$_POST['hz'];
                $data['phase']      = @$_POST['phase'];
                /*
				$categories['sort'] = $data['sort'] = '';
				$categories['dir'] 	= $data['dir']  = '';
				$categories['slug'] = $data['slug'] = '';
				$categories['page'] = $data['page'] = '';
				$categories['per_page'] = $data['per_page'] = '';
				$categories     = \CI::Categories()->get($data['slug'], $data['sort'], $data['dir'], $data['page'], $data['per_page'], $data['stand_by']);

				$engines        = \CI::Products()->getProductsCondition($data['power'], $data['hz'], true, $data['stand_by']);
                //echo \CI::db()->last_query().'<pre>';print_r($engines);exit;
                $engines_min    = \CI::Products()->getProductsCondition($data['power'], $data['hz'], false, $data['stand_by']);
                $engines = array_merge($engines_min, $engines);
                //echo \CI::db()->last_query().'<pre>';print_r($engines);exit;
				$alternators    = \CI::Products()->getProductsAlternators($data['power'], $data['hz'], $data['phase']);
				//echo \CI::db()->last_query().'<pre>';print_r($alternators);exit;
                $canopies    = \CI::Products()->getProductsCanopies();
                //echo \CI::db()->last_query().'<pre>';print_r($canopies);exit;
                $controllers    = \CI::Products()->getProductsControllers();
                //echo \CI::db()->last_query().'<pre>';print_r($controllers);exit;

				$data['engines']    = $engines;
				$data['alternators']= $alternators;
                $data['canopies']   = $canopies;
                $data['controllers']= $controllers;

				$generators         = $this->results($data['hz'], $engines, $alternators, $data['power'], $data['phase'], $canopies, $controllers, $data['stand_by']);
                */
                $generators = $this->generate_generators($data);
                if($data['power'] > 1000){
                    $general_generators = $this->general_generators($data);
                }
                //echo '<pre>';print_r($general_generators);exit;
                if(isset($general_generators))
                    $generators = array_merge($generators, $general_generators);
                $generators         = $this->array_orderby(@$generators, 'kVA', SORT_ASC, 'price', SORT_ASC);
			}

			$data['generators'] = @$generators;

			//echo '<pre>';
			//pr($generators);exit;
            $this->view('homepage',$data);
            return;
        }
        else
        {
            //if we don't have a homepage view, check for a registered homepage
            if(config_item('homepage'))
            {
                if(isset($this->pages['all'][config_item('homepage')]))
                {
                    //we have a registered homepage and it's active
                    $this->index($this->pages['all'][config_item('homepage')]->slug, false);
                    return;
                }
            }
        }

        // wow, we do not have a registered homepage and we do not have a homepage.php
        // let's give them something default to look at.
        $this->view('homepage_fallback');
    }

    public function generate_generators($data){
        $generators = array();
        $engines        = \CI::Products()->getProductsCondition($data['power'], $data['hz'], true, $data['stand_by']);
        //echo \CI::db()->last_query().'<pre>';print_r($engines);exit;
        $engines_min    = \CI::Products()->getProductsCondition($data['power'], $data['hz'], false, $data['stand_by']);
        $engines = array_merge($engines_min, $engines);
        //echo \CI::db()->last_query().'<pre>';print_r($engines);exit;
        $alternators    = \CI::Products()->getProductsAlternators($data['power'], $data['hz'], $data['phase']);
        //echo \CI::db()->last_query().'<pre>';print_r($alternators);exit;
        $canopies    = \CI::Products()->getProductsCanopies();
        //echo \CI::db()->last_query().'<pre>';print_r($canopies);exit;
        $controllers    = \CI::Products()->getProductsControllers();
        //echo \CI::db()->last_query().'<pre>';print_r($controllers);exit;

        $data['engines']    = $engines;
        $data['alternators']= $alternators;
        $data['canopies']   = $canopies;
        $data['controllers']= $controllers;

        $generators         = $this->results($data['hz'], $engines, $alternators, $data['power'], $data['phase'], $canopies, $controllers, $data['stand_by']);

        return $generators;
    }


    public function general_generators($data){
        // will customize this function with other generators
        $tmp_data = $data;
        $number = 2;
        $power = $data['power'];
        if($power < 1500){
            $tmp_data['power'] = round($power / 2);
            $generators = $this->generate_generators($tmp_data);
        }else if($power < 2500){
            $number = 3;
            $tmp_data['power'] = round($power / $number);
            $generators = $this->generate_generators($tmp_data);
        }else if($power < 4000){
            $number = 4;
            $tmp_data['power'] = round($power / $number);
            $generators = $this->generate_generators($tmp_data);
        }else if($power < 6000){
            $number = 5;
            $tmp_data['power'] = round($power / $number);
            $generators = $this->generate_generators($tmp_data);
        }else if($power < 8000){
            $number = 6;
            $tmp_data['power'] = round($power / $number);
            $generators = $this->generate_generators($tmp_data);
        }else if($power < 14000){
            $number = 8;
            $tmp_data['power'] = round($power / $number);
            $generators = $this->generate_generators($tmp_data);
        }else{
            $number = 10;
            $tmp_data['power'] = round($power / $number);
            $generators = $this->generate_generators($tmp_data);
        }

        $tmp_results = array();
        foreach($generators as $item){
            $item['kVA']        = round($item['kVA']) * $number;
            $item['p_kVA']      = round($item['p_kVA']) * $number;
            $item['number_gen'] = $number;
            $item['name']       = $number.'x'.$item['name'];
            $tmp_results[]      = $item;
            //pr($item);
        }
        return $tmp_results;
    }

	public function  array_orderby(){
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
				}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	
	public function results($hz, $engines, $alternators, $power, $phase = 3, $canopies, $controllers, $stand_by = true){
		$generators = array();
		$tmp = 0;
        $coefficient_min = 0.9 * $power;
        $coefficient_max = 1.4 * $power;
        // use for prime power
        $coefficient_min_2 = 0.8 * $power;
        //echo $coefficient_min_2 = 1.0 * $power;
        //pr($engines);
        $coefficient_max_2 = 1.3 * $power;

        //echo '<pre>';print_r($alternators);exit;
		foreach($engines as $key=>$engine){
			foreach($alternators as $alternator){
                $flag_get = false;
                if($alternator->efficiency_standby < $alternator->efficiency)
                    $alternator->efficiency_standby = $alternator->efficiency;
                if($phase == 1){
                    $alternator->power = ($alternator->power_single_phase>0)?$alternator->power_single_phase:$alternator->power;
                    $alternator->efficiency = ($alternator->efficiency_single>0)?$alternator->efficiency_single:$alternator->efficiency;
                    $alternator->efficiency_standby = ($alternator->efficiency_single_standby>0)?$alternator->efficiency_single_standby:$alternator->efficiency;
                }
                if($hz == 50) {
                    if($stand_by == true) {
                        if ($coefficient_min <= $engine->s_kAV && $coefficient_max >= $engine->s_kAV) {
                            if ($alternator->power >= $engine->s_kAV * $alternator->efficiency_standby * 0.01) {
                                $generators[$tmp]['kVA'] = $engine->s_kAV * $alternator->efficiency_standby * 0.01;
                                $generators[$tmp]['p_kVA'] = $engine->p_kAV * $alternator->efficiency * 0.01;
                                $flag_get = true;
                            }
                        }
                    }
                    else{
                        if ($coefficient_min_2 <= $engine->p_kAV && $coefficient_max_2 >= $engine->p_kAV) {

                            if ($alternator->power >= $engine->s_kAV * $alternator->efficiency_standby * 0.01) {
                                $generators[$tmp]['kVA'] = $engine->s_kAV * $alternator->efficiency * 0.01;
                                $generators[$tmp]['p_kVA'] = $engine->p_kAV * $alternator->efficiency_standby * 0.01;
                                $flag_get = true;
                            }
                        }
                    }
                }else{
                    if($stand_by == true) {
                        if ($coefficient_min <= $engine->s_kAV_2 && $coefficient_max >= $engine->s_kAV_2) {
                            if ($alternator->power >= $engine->s_kAV_2 * $alternator->efficiency_standby * 0.01) {
                                $generators[$tmp]['kVA'] = $engine->s_kAV_2 * $alternator->efficiency * 0.01;
                                $generators[$tmp]['p_kVA'] = $engine->p_kAV_2 * $alternator->efficiency_standby * 0.01;
                                $flag_get = true;
                            }
                        }
                    }else{
                        if ($coefficient_min_2 <= $engine->p_kAV_2 && $coefficient_max_2 >= $engine->p_kAV_2) {
                            if ($alternator->power >= $engine->s_kAV_2 * $alternator->efficiency_standby * 0.01) {
                                $generators[$tmp]['kVA'] = $engine->s_kAV_2 * $alternator->efficiency * 0.01;
                                $generators[$tmp]['p_kVA'] = $engine->p_kAV_2 * $alternator->efficiency_standby * 0.01;
                                $flag_get = true;
                            }
                        }
                    }
                }
                if($flag_get == true){
                    $generators[$tmp]['engine'] = $engine;
                    $generators[$tmp]['alternator'] = $alternator;
                    $canopy = $this->select_canopy($canopies, $generators[$tmp]['kVA']);
                    $controller = $this->select_controller($controllers, $generators[$tmp]['kVA']);
                    $generators[$tmp]['canopy'] = $canopy;
                    $generators[$tmp]['controller'] = $controller;
                    //pr($controller);
                    $generators[$tmp]['price'] = $engine->price_1 + $alternator->price_1 + $canopy['price_1'] + $controller['price_1'];

                    /*if ($alternator->power < $generators[$tmp]['kVA']) {
                        $generators[$tmp]['generator_kVA'] = $alternator->power;
                    }*/
                    //else{
                    $generators[$tmp]['generator_kVA'] = $generators[$tmp]['kVA'];
                    $generators[$tmp]['generator_p_kVA'] = $generators[$tmp]['p_kVA'];
                    //}

                    if ($engine->days > $alternator->days)
                        $generators[$tmp]['days'] = $engine->days;
                    else $generators[$tmp]['days'] = $alternator->days;

                    $generators[$tmp]['name'] = 'G' . (int)$hz / 10 . '-' . round($generators[$tmp]['generator_kVA']) . $generators[$tmp]['engine']->code . $generators[$tmp]['alternator']->code . $canopy['code'] . $controller['code'];
                    $tmp ++;

                }
			}
		}
        //pr($generators);
        return $this->filter($generators, $power, $stand_by);
		//return $generators;
	}
    function select_canopy($canopies, $kVA){
        $canopy['price_1']  = 0;
        $canopy['code']     = 'N';
        $canopy['item']     = null;
        /* Will check condition of kAV later*/
        foreach($canopies as $item){
            $canopy['price_1'] = $item->price_1;
            $canopy['code'] = $item->code;
            $canopy['item'] = $item;
            //echo '<pre>';print_r($canopy);exit;
            return $canopy;
        }
        return $canopy;
    }

    function select_controller($controllers, $kVA){
        $controller['price_1']  = 0;
        $controller['code']     = 'N';
        $controller['item']     = null;
        /* Will check condition of kAV later*/
        foreach($controllers as $item){
            $controller['price_1']   = $item->price_1;
            $controller['code']      = $item->code;
            $controller['item']      = $item;
            //return $controller;
        }
        return $controller;
    }

    public function filter($generators, $power, $stand_by){

        $min = $power * 0.8;
        $max = $power * 1.4;
        $tmp = array();

        // group kVA
        foreach($generators as $generator){
            //echo $generator['generator_kVA'] .':'.$generator['generator_p_kVA'].'<br>';
            if($stand_by) {
                if ($min <= $generator['kVA'] && $generator['kVA'] <= $max) {
                    $index = round($generator['kVA']);
                    $tmp[$index][] = $generator;
                }
            }else{
                if ($min <= $generator['p_kVA'] && $generator['p_kVA'] <= $max) {
                    $index = round($generator['p_kVA']);
                    $tmp[$index][] = $generator;
                }
            }
        }

        //return $tmp;

        // get only one row
        $list = array();
        foreach($tmp as $key=>$generator_list){
            $tmp_2 = $this->array_orderby(@$generator_list, 'price', SORT_DESC, 'days', SORT_DESC);
            $list[] = $generator_1 = $tmp_2[0];

            if(!empty($generator_list)){
                $tmp_2 = $this->array_orderby(@$tmp_2, 'days', SORT_DESC, 'price', SORT_DESC);
                $generator_2 = array_pop($tmp_2);
                if($generator_2['days'] < $generator_1['days'])
                    $list[] = $tmp_2[0];
            }
            //echo count($generator_list);exit;
        }
        if($stand_by)
            $list  = $this->array_orderby(@$list, 'kVA', SORT_ASC, 'price', SORT_ASC);
        else $list  = $this->array_orderby(@$list, 'p_kVA', SORT_ASC, 'price', SORT_ASC);
        $tmp_count = 0;
        $gen_left = array();
        $gen_right = array();
        for($i= count($list) - 1; $i>=0; $i--){
            if($stand_by) {
                if ($list[$i]['kVA'] >= $power){
                    $gen_right[] = $list[$i];
                    continue;
                }else{
                    $tmp_count++;
                    if($tmp_count > 3) unset($list[$i]);
                    else $gen_left[] = $list[$i];
                }
            }else{
                if ($list[$i]['p_kVA'] >= $power){
                    $gen_right[] = $list[$i];
                    continue;
                }else{
                    $tmp_count++;
                    if($tmp_count > 3) unset($list[$i]);
                    else $gen_left[] = $list[$i];
                }
            }
        }
        $gen_results = $gen_left;

        if($stand_by)
            $gen_right = $this->array_orderby(@$gen_right, 'price', SORT_ASC, 'kVA', SORT_ASC);
        else
            $gen_right = $this->array_orderby(@$gen_right, 'price', SORT_ASC, 'p_kVA', SORT_ASC);

        foreach($gen_right as $key=>$item ){
            if($key==5) break;
            $gen_results[] = $item;
        }

        if($stand_by)
             $gen_results  = $this->array_orderby(@$gen_results, 'kVA', SORT_ASC, 'price', SORT_ASC);
        else $gen_results  = $this->array_orderby(@$gen_results, 'p_kVA', SORT_ASC, 'price', SORT_ASC);
        $tmp_gen_results = $gen_results;

        // remove case ><
        foreach($tmp_gen_results as $key=>$item){
            foreach($tmp_gen_results as $item2){
                if($item['kVA'] < $item2['kVA'] && $item['price'] > $item2['price'] && $item['days']>=$item2['days']){
                    unset($gen_results[$key]);
                }
            }
        }

        //echo count($list).'<br>';exit;
        //$list = array_values($list);
        //echo $min.'<br>';
        //echo $max.'<br>';exit;
        return $gen_results;
    }
    public function show404()
    {
        $this->view('404');
    }

    public function index($slug=false, $show_title=true)
    {

        $page = false;

        //this means there's a slug, lets see what's going on.
        foreach($this->pages['all'] as $p)
        {
            if($p->slug == $slug)
            {
                $page = $p;
                continue;
            }
        }

        if(!$page)
        {
            throw_404();
        }
        else
        {
            //create view variable
            $data['page_title'] = false;
            if($show_title)
            {
                $data['page_title'] = $page->title;
            }
            $data['meta'] = $page->meta;
            $data['seo_title'] = (!empty($page->seo_title))?$page->seo_title:$page->title;
            $data['page'] = $page;

            //load the view
            $this->view('page', $data);
        }
    }

    public function api($slug)
    {
        \CI::load()->language('page');

        $page = $this->Page_model->slug($slug);

        if(!$page)
        {
            $json = json_encode(['error'=>lang('error_page_not_found')]);
        }
        else
        {
            $json = json_encode($page);
        }

        $this->view('json', ['json'=>json_encode($json)]);
    }
}

/* End of file Page.php */
/* Location: ./GoCart/controllers/Page.php */