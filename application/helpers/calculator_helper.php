<?php
function get_info_fuel_consumption($engine_id, $alternator_id, $hz)
{
    $CI = &get_instance();
    $CI->load->model('Products');
	$cos_phi = 0.8;
	$constant = 0.84; 	// lit/kg
	$engine 			= $CI->Products->find_engine($engine_id);	
	$alternator 		= $CI->Products->find_alternator($alternator_id, $hz);
	$fuel_consumption 	= $CI->Products->find_fuel_consumption($engine_id, $hz);
	if(empty($fuel_consumption)) {
		$fuel_consumption = new stdclass;
		$fuel_consumption->standby_fuel_con_1 = 0;
		$fuel_consumption->standby_fuel_con_2 = 0;
		$fuel_consumption->standby_fuel_con_3 = 0;
		$fuel_consumption->prime_fuel_con_1 = 0;
		$fuel_consumption->prime_fuel_con_2 = 0;
		$fuel_consumption->prime_fuel_con_3 = 0;
	}
	$kVA_standby 	= ($engine->standby/$cos_phi) * ($alternator->efficiency*0.01);
	$kVA_prime		= ($engine->prime/$cos_phi) * ($alternator->efficiency*0.01);
		
	//echo $CI->db->last_query();print_r($fuel_consumption);exit;
	$pf = $engine->power_factor;
	/*
	$generators['standby']['kVA_1'] = ($engine->standby/$pf) * ($alternator->efficiency*0.01);
	$generators['standby']['kVA_2'] = ($engine->standby/$pf) * ($alternator->efficiency_2*0.01);
	$generators['standby']['kVA_3'] = ($engine->standby/$pf) * ($alternator->efficiency_3*0.01);
	$generators['prime']['kVA_1']   = ($engine->prime/$pf) * ($alternator->efficiency*0.01);		// 4/4
	$generators['prime']['kVA_2']   = ($engine->prime/$pf) * ($alternator->efficiency_2*0.01);		// 3/4
	$generators['prime']['kVA_3']   = ($engine->prime/$pf) * ($alternator->efficiency_3*0.01);		// 2/4
	*/

	$generators['standby']['kVA_1'] = $kVA_standby;
	$generators['standby']['kVA_2'] = ($kVA_standby/4)*3;
	$generators['standby']['kVA_3'] = $kVA_standby/2;
	$generators['prime']['kVA_1']   = $kVA_prime;		// 4/4
	$generators['prime']['kVA_2']   = ($kVA_prime/4)*3;	// 3/4
	$generators['prime']['kVA_3']   = $kVA_prime/2;		// 2/4
	
	$generators['standby']['kWm_1'] = $generators['standby']['kVA_1'] * $cos_phi;	// load 110%
	$generators['standby']['kWm_2'] = $generators['standby']['kVA_2'] * $cos_phi;
	$generators['standby']['kWm_3'] = $generators['standby']['kVA_3'] * $cos_phi;
	$generators['prime']['kWm_1']   = $generators['prime']['kVA_1'] * $cos_phi;		// 4/4
	$generators['prime']['kWm_2']   = $generators['prime']['kVA_1'] * $cos_phi;		// 3/4
	$generators['prime']['kWm_3']   = $generators['prime']['kVA_1'] * $cos_phi;		// 2/4
	
	// kW * g/kWh = g/h; (g/h) / 1000 = kg/h; (kg/h) / constant = l/h
	$generators['fuel']['standby']['fuel_con_1'] = ($generators['standby']['kWm_1'] * $fuel_consumption->standby_fuel_con_1)/1000/$constant;
	$generators['fuel']['standby']['fuel_con_2'] = ($generators['standby']['kWm_2'] * $fuel_consumption->standby_fuel_con_2)/1000/$constant;
	$generators['fuel']['standby']['fuel_con_3'] = ($generators['standby']['kWm_3'] * $fuel_consumption->standby_fuel_con_3)/1000/$constant;
	$generators['fuel']['prime']['fuel_con_1']   = ($generators['prime']['kWm_1'] * $fuel_consumption->prime_fuel_con_1)/1000/$constant;	// 4/4
	$generators['fuel']['prime']['fuel_con_2']   = ($generators['prime']['kWm_2'] * $fuel_consumption->prime_fuel_con_2)/1000/$constant;	// 3/4
	$generators['fuel']['prime']['fuel_con_3']   = ($generators['prime']['kWm_3'] * $fuel_consumption->prime_fuel_con_3)/1000/$constant;	// 2/4
	
	$generators['fuel']['fuel_consumption'] 	 = $fuel_consumption;
	return $generators['fuel'];
	
	/*if($alternator->power < $generators[$tmp]['kVA'])
		$generators[$tmp]['generator_kVA'] = $alternator->power;
	else $generators[$tmp]['generator_kVA'] = $generators[$tmp]['kVA'];*/
}

function get_exchangeRates(){
	echo dirname(__FILE__);exit;
	$xmlData = NULL;
    $source = file_get_contents('http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx');
    $xml_parser = xml_parser_create();
    xml_parse_into_struct($xml_parser, $source , $xmlData);
    xml_parser_free($xml_parser);
    
	$CI = &get_instance();
	$data = array();
	//echo '<pre>';print_r($xmlData);echo $CI->db->escape(date('Y-m-d H:i:s'));exit;
    foreach($xmlData as $v){
		if(isset($v['attributes'])){
			$data[] = array(
				'code' 			=> $v['attributes']['CURRENCYCODE'],
				'name' 			=> $v['attributes']['CURRENCYNAME'],
				'buy' 			=> $v['attributes']['BUY'],
				'transfer' 		=> $v['attributes']['TRANSFER'],
				'sell' 			=> $v['attributes']['SELL'],
				'date_modified' => date('Y-m-d H:i:s')
			);
		}
	}
	//$CI->db->insert_batch('currencies', $data); 
	$CI->db->update_batch('currencies', $data, 'code'); 
}