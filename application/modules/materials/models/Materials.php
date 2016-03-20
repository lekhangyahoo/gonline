<?php
/**
 * Products Class
 *
 * @package     GoCart
 * @subpackage  Models
 * @category    Products
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

Class Materials extends CI_Model
{
    public function __construct()
    {

    }

    public function getMaterials()
    {
        $basic = $this->db->get('materials_price')->result();
        foreach($basic as $item){
            $data['basic'][$item->code] = $item;
        }
        $coefficients   = $this->db->get('coefficients')->result();
        foreach($coefficients as $item){
            $data['coefficients'][$item->code] = $item;
        }

        $constants      = $this->db->get('constants')->result();
        foreach($constants as $item){
            $data['constants'][$item->code] = $item;
        }

        $funnel         = $this->db->get('materials_price_funnel')->result();
        foreach($funnel as $item){
            if($item->group == 0)
                $data['funnel'][$item->phi] = $item;
            if($item->group == 1)
                $data['funnel'][$item->group][$item->phi.'_'.$item->group] = $item;
        }

        $data['febrifuge']  = $this->db->get('materials_price_febrifuge')->result();

        $cable              = $this->db->get('materials_price_elactric_cable')->result();
        foreach($cable as $item){
            $data['cable'][$item->ampe] = $item;
        }
        return $data;
    }
	
}
