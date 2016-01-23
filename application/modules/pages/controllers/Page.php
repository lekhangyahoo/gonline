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
			$data['power']= @$_POST['power'];
            $data['hz']= @$_POST['hz'];
			$engines = array();
			$alternators = array();
			$generators = array();
			$data['engines'] = $engines;
			$data['alternators'] = $alternators;
			
			if($data['power'] > 0){
                $data['hz']= @$_POST['hz'];
				$categories['sort'] = $data['sort'] = '';
				$categories['dir'] 	= $data['dir'] = '';
				$categories['slug'] = $data['slug'] = '';
				$categories['page'] = $data['page'] = '';
				$categories['$per_page'] = $data['per_page'] = '';
				$categories = \CI::Categories()->get($data['slug'], $data['sort'], $data['dir'], $data['page'], $data['per_page']);
				
				
				$engines = \CI::Products()->getProductsCondition($data['power'], $data['hz']);
				
				$alternators = \CI::Products()->getProductsAlternators($data['power'], $data['hz']);
				
				//echo \CI::db()->last_query().'<pre>';print_r($alternators);exit;
				
				$data['engines'] = $engines;
				$data['alternators'] = $alternators;				
				$generators = $this->results($data['hz'], $data['engines'],$data['alternators'], $data['power']);
			}
			$generators = $this->array_orderby(@$generators, 'kVA', SORT_ASC, 'price', SORT_ASC);
			
			$data['generators'] = @$generators;
			//echo '<pre>';print_r($generators);exit;
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
	
	public function results($hz, $engines, $alternators, $power){
		$generators = array();
		$tmp = 0;
		foreach($engines as $engine){
			foreach($alternators as $alternator){
				if($alternator->power >= $engine->p_kAV){
					$generators[$tmp]['engine'] = $engine;
					$generators[$tmp]['alternator'] = $alternator;
					$generators[$tmp]['kVA'] = $engine->s_kAV * $alternator->efficiency*0.01;
					$generators[$tmp]['price'] = $engine->price_1 + $alternator->price_1;
					
					if($alternator->power < $generators[$tmp]['kVA'])
						$generators[$tmp]['generator_kVA'] = $alternator->power;
					else $generators[$tmp]['generator_kVA'] = $generators[$tmp]['kVA'];
					
					if($engine->days > $alternator->days)
						$generators[$tmp]['days'] = $engine->days;
					else $generators[$tmp]['days'] = $alternator->days;

                    $generators[$tmp]['name'] = 'G'.$hz.'-'.round ($generators[$tmp]['generator_kVA']).$generators[$tmp]['engine']->code.$generators[$tmp]['alternator']->code;
				}
				$tmp ++;
			}
		}
		
		return $generators;	
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