<?php namespace GoCart\Controller;
/**
 * AdminProducts Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    AdminProducts
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class AdminMaterials extends Admin {

	var $_db_table = array( 'coefficients'  => 'coefficients',
                            'constants'     => 'constants',
                            'febrifuge'     => 'materials_price_febrifuge',
                            'basic'         => 'materials_price',
                            'funnel'        => 'materials_price_funnel',
                            'cable'         => 'materials_price_elactric_cable'
                        );
    public function __construct()
    {
        parent::__construct();

        \CI::auth()->check_access('Admin', true);

        \CI::load()->model(['Products', 'Categories']);
        \CI::load()->helper('form');
        \CI::lang()->load('products');
    }

    public function index($direction = false)
    {
        \CI::db()->order_by('group','ESC')->order_by('id','ESC');
		$quey = \CI::db()->get($this->_db_table[$direction]);
		$data['results'] = $quey->result();
        $this->view($direction, $data);
    }
    
    public function form($direction = false, $id = false)
    {
		$data = array();
		if($direction=='coefficients'){
			$data = array(
				'code' 			=> \CI::input()->post('code'),
				'value' 		=> \CI::input()->post('value'),
				'description' 	=> \CI::input()->post('description'),
				'group' 		=> \CI::input()->post('group'),
				);
		}
        if($direction=='constants'){
            $data = array(
                'code' 			=> \CI::input()->post('code'),
                'value' 		=> \CI::input()->post('value'),
                'description' 	=> \CI::input()->post('description'),
                'group' 		=> \CI::input()->post('group'),
            );
        }
        if($direction=='febrifuge'){
            $data = array(
                'kVA' 		=> \CI::input()->post('kVA'),
                'width' 	=> \CI::input()->post('width'),
                'height' 	=> \CI::input()->post('height'),
                'value_vtp' => \CI::input()->post('value_vtp'),
                'note' 		=> \CI::input()->post('note'),
            );
        }
        if($direction=='basic'){
            $data = array(
                'code' 		        => \CI::input()->post('code'),
                'description' 	    => \CI::input()->post('description'),
                'value' 	        => \CI::input()->post('value'),
                'condition'         => \CI::input()->post('condition'),
                'condition_value' 	=> \CI::input()->post('condition_value'),
                'unit' 		        => \CI::input()->post('unit'),
                'group' 		    => \CI::input()->post('group')
            );
        }
        if($direction=='funnel'){
            $data = array(
                'phi' 		    => \CI::input()->post('phi'),
                'value_mabi' 	=> \CI::input()->post('value_mabi'),
                'value_coha' 	=> \CI::input()->post('value_coha'),
                'value_vtp'     => \CI::input()->post('value_vtp'),
                'value_noch'    => \CI::input()->post('value_noch'),
                'value_onnh'    => \CI::input()->post('value_onnh'),
                'description' 	=> \CI::input()->post('description'),
                'group' 		=> \CI::input()->post('group'),
                'note' 		    => \CI::input()->post('note'),
            );
        }
        if($direction=='cable'){
            $data = array(
                'kVA' 		    => \CI::input()->post('kVA'),
                'ampe' 	        => \CI::input()->post('ampe'),
                'section' 	    => \CI::input()->post('section'),
                'trademark'     => \CI::input()->post('trademark'),
                'symbol'        => \CI::input()->post('symbol'),
                'unit'          => \CI::input()->post('unit'),
                'value' 		=> \CI::input()->post('value'),
                'description' 	=> \CI::input()->post('description'),
                'note' 		    => \CI::input()->post('note'),
            );
        }

		if(!empty($_POST)){
			if($id){
				\CI::db()->where('id', $id)->update($this->_db_table[$direction], $data);
				return;
			}
			else {
				\CI::db()->insert($this->_db_table[$direction], $data);
				redirect('admin/materials/'.$direction);
			}
		}		
		
    }

    public function delete($direction = false, $id = false)
    {		
        if ($id)
        {
            \CI::db()->delete($this->_db_table[$direction], array('id' => $id));
        }
        else
        {
            //if they do not provide an id send them to the product list page with an error
            \CI::session()->set_flashdata('error', lang('error_not_found'));
        }
		redirect('admin/materials/'.$direction);
    }
}
