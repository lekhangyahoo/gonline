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

class AdminProducts extends Admin {

    public function __construct()
    {
        parent::__construct();

        \CI::auth()->check_access('Admin', true);

        \CI::load()->model(['Products', 'Categories']);
        \CI::load()->helper('form');
        \CI::lang()->load('products');
		
		//$engines = \CI::Products()->getProductsCondition(1,60);
		//$alternator = \CI::Products()->getProductsAlternators(2,60);
		//echo \CI::db()->last_query().'<pre>';print_r($alternator);exit;
    }

    function input_data_from_link($type = 0, $active = false){
        \CI::load()->helper('simple_html_dom');
        set_time_limit(1800);

        if($type == 0) {
            $csv_data = array_map('str_getcsv', file($_SERVER['DOCUMENT_ROOT'] . '/perkins-data.csv'));
            $product_list = array();
            foreach ($csv_data as $key => $product) {
                if ($key == 0 || $key == 1 || $product[0] == '' || $product[2] == '') continue;
                $index = $key - 2;
                $product_list[$index]['active'] = $product[1];
                $product_list[$index]['product']['name'] = $product[2];
                $product_list[$index]['product']['slug'] = strtolower(str_replace(' ', '-', $product[2]));
                $product_list[$index]['product']['note'] = $product[18];
                $product_list[$index]['product']['ref_link'] = $product[19];
                $product_list[$index]['product']['document_link'] = $product[20];
                $product_list[$index]['product']['document_link_2'] = $product[21];
                $product_list[$index]['product']['price_1'] = $product[22];

                $product_list[$index]['engine']['standby'] = $product[3];
                $product_list[$index]['engine']['prime'] = $product[4];
                $product_list[$index]['engine']['rpm'] = ($product[9] > 0) ? $product[9] : 1500;
                $product_list[$index]['engine']['standby_2'] = $product[10];
                $product_list[$index]['engine']['prime_2'] = $product[11];
                $product_list[$index]['engine']['rpm_2'] = ($product[16] > 0) ? $product[16] : 1800;

                $product_list[$index]['fuel'][50]['hz'] = 50;
                $product_list[$index]['fuel'][50]['standby_fuel_con_1'] = $product[5];
                $product_list[$index]['fuel'][50]['prime_fuel_con_1'] = $product[6];
                $product_list[$index]['fuel'][50]['prime_fuel_con_2'] = $product[7];
                $product_list[$index]['fuel'][50]['prime_fuel_con_3'] = $product[8];
                $product_list[$index]['fuel'][50]['unit'] = ($product[17] != '') ? 1 : 0;

                $product_list[$index]['fuel'][60]['hz'] = 60;
                $product_list[$index]['fuel'][60]['standby_fuel_con_1'] = $product[12];
                $product_list[$index]['fuel'][60]['prime_fuel_con_1'] = $product[13];
                $product_list[$index]['fuel'][60]['prime_fuel_con_2'] = $product[14];
                $product_list[$index]['fuel'][60]['prime_fuel_con_3'] = $product[15];
                $product_list[$index]['fuel'][60]['unit'] = ($product[17] != '') ? 1 : 0;


                //$ref_link = 0;
                $ref_link = $product[19];
                if (!isset($get_data[$ref_link])) {
                //if ($ref_link > 0) {
                    $data = array();
                    // Create DOM from URL or file
                    $html = file_get_html($ref_link);

                    $modelTitle = $html->find('div.modelTitle');
                    foreach ($modelTitle as $element) {
                        $title = trim($element->plaintext);
                        break;
                    }

                    $img = $html->find('ul#carousel-photos a img');
                    foreach ($img as $element) {
                        $link_img = $element->src;
                        break;
                    }
                    //echo $title;continue;
                    if($active == false)
                        $images = $this->save_image($title, $link_img);

                    foreach ($html->find('.specifications tbody tr') as $key2 => $element) {
                        $tmp = $element->childNodes(1);
                        $label = trim($element->childNodes(0)->plaintext);
                        //echo $label.'<br/>';
                        $value = trim($tmp->find('.unit-metric')[0]->plaintext);
                        if ($label == 'Bore') {
                            $tmp_data['bore'] = $value;
                        }
                        if ($label == 'Stroke') {
                            $tmp_data['stroke'] = $value;
                        }
                        if ($label == 'Displacement') {
                            $tmp_data['displacement'] = $value;
                        }
                        if ($label == 'Cycle') {
                            $tmp_data['cylinders'] = $value;
                        }
                        if ($label == 'Compression ratio') {
                            $tmp_data['compression_ratio'] = $value;
                        }
                        if ($label == 'Cooling system') {
                            $tmp_data['cooling_system'] = $value;
                        }
                        if ($label == 'Emissions') {
                            $tmp_data['emissions'] = $value;
                        }
                        if ($label == 'Length') {
                            $tmp_data['length'] = $value;
                        }
                        if ($label == 'Width') {
                            $tmp_data['width'] = $value;
                        }
                        if ($label == 'Height') {
                            $tmp_data['height'] = $value;
                        }
                        if ($label == 'Dry weight') {
                            $tmp_data['weight'] = $value;
                        }

                    }

                    $tmp_data['dimensions'] = str_replace('.0 mm', '', $tmp_data['length']) . 'x' . str_replace('.0 mm', '', $tmp_data['width']) . 'x' . str_replace('.0 mm', '', $tmp_data['height']);
                    $tmp_data['weight'] = str_replace(' kg', '', $tmp_data['weight']);

                    if($active == false){
                        $product_list[$index]['product']['images'] = $get_data[$ref_link]['images'] = $images ? $images : '';
                    }
                    $product_list[$index]['product']['dimensions'] = $get_data[$ref_link]['dimensions'] = $tmp_data['dimensions'] ? $tmp_data['dimensions'] : 0;
                    $product_list[$index]['product']['weight'] = $get_data[$ref_link]['weight'] = $tmp_data['weight'] ? $tmp_data['weight'] : 0;

                    $product_list[$index]['engine']['bore'] = $get_data[$ref_link]['bore'] = $tmp_data['bore'] ? $tmp_data['bore'] : 0;
                    $product_list[$index]['engine']['stroke'] = $get_data[$ref_link]['stroke'] = $tmp_data['stroke'] ? $tmp_data['stroke'] : 0;
                    $product_list[$index]['engine']['displacement'] = $get_data[$ref_link]['displacement'] = $tmp_data['displacement'] ? $tmp_data['displacement'] : 0;
                    $product_list[$index]['engine']['cylinders_number'] = $get_data[$ref_link]['cylinders_number'] = $tmp_data['cylinders'] ? $tmp_data['cylinders'] : 0;
                    $product_list[$index]['engine']['compression_ratio'] = $get_data[$ref_link]['compression_ratio'] = $tmp_data['compression_ratio'] ? $tmp_data['compression_ratio'] : 0;
                    $product_list[$index]['engine']['type_cooled'] = $get_data[$ref_link]['type_cooled'] = $tmp_data['cooling_system'] ? $tmp_data['cooling_system'] : 0;
                    $product_list[$index]['engine']['emissions'] = $get_data[$ref_link]['emissions'] = $tmp_data['emissions'] ? $tmp_data['emissions'] : 0;
                } else {
                    if($active == false){
                        $product_list[$index]['product']['images'] = $get_data[$ref_link]['images'];
                    }
                    $product_list[$index]['product']['dimensions'] = $get_data[$ref_link]['dimensions'];
                    $product_list[$index]['product']['weight'] = $get_data[$ref_link]['weight'];

                    $product_list[$index]['engine']['bore'] = $get_data[$ref_link]['bore'];
                    $product_list[$index]['engine']['stroke'] = $get_data[$ref_link]['stroke'];
                    $product_list[$index]['engine']['displacement'] = $get_data[$ref_link]['displacement'];
                    $product_list[$index]['engine']['cylinders_number'] = $get_data[$ref_link]['cylinders_number'];
                    $product_list[$index]['engine']['compression_ratio'] = $get_data[$ref_link]['compression_ratio'];
                    $product_list[$index]['engine']['type_cooled'] = $get_data[$ref_link]['type_cooled'];
                    $product_list[$index]['engine']['emissions'] = $get_data[$ref_link]['emissions'];
                }
                //break;
            }
            //pr($product_list);exit;
            foreach ($product_list as $product) {
                $product['product']['primary_category'] = 1;
                $product['product']['enabled_1'] = 1;
                $product['product']['manufacturers'] = 3;
                if($active == false) {
                    \CI::db()->insert('products', $product['product']);
                    $product_id = \CI::db()->insert_id();
                    \CI::db()->insert('category_products', array('product_id' => $product_id, 'category_id' => 1));

                    $product['engine']['product_id'] = $product_id;
                    \CI::db()->insert('engines', $product['engine']);

                    $product['fuel'][50]['product_id'] = $product_id;
                    \CI::db()->insert('fuel_consumptions', $product['fuel'][50]);

                    $product['fuel'][60]['product_id'] = $product_id;
                    \CI::db()->insert('fuel_consumptions', $product['fuel'][60]);
                }else{
                    $query = \CI::db()->where('slug', $product['product']['slug'])->get('products');
                    if($query->num_rows() > 0) {
                        $result = $query->row_array();
                        $product_id = $result['id'];

                        \CI::db()->where('id', $product_id);
                        \CI::db()->update('products', $product['product']);

                        \CI::db()->where('product_id', $product_id);
                        \CI::db()->update('engines', $product['engine']);

                        \CI::db()->where('product_id', $product_id)->where('hz', 50);
                        \CI::db()->insert('fuel_consumptions', $product['fuel'][50]);

                        \CI::db()->where('product_id', $product_id)->where('hz', 60);
                        \CI::db()->insert('fuel_consumptions', $product['fuel'][60]);

                    }else{
                        \CI::db()->insert('products', $product['product']);
                        $product_id = \CI::db()->insert_id();
                        \CI::db()->insert('category_products', array('product_id' => $product_id, 'category_id' => 1));

                        $product['engine']['product_id'] = $product_id;
                        \CI::db()->insert('engines', $product['engine']);

                        $product['fuel'][50]['product_id'] = $product_id;
                        \CI::db()->insert('fuel_consumptions', $product['fuel'][50]);

                        $product['fuel'][60]['product_id'] = $product_id;
                        \CI::db()->insert('fuel_consumptions', $product['fuel'][60]);
                    }
                }
            }
        }

        // input database control
        if($type==1){
            $csv_data = array_map('str_getcsv', file($_SERVER['DOCUMENT_ROOT'] . '/leroy-somer-data.csv'));
            $product_list = array();
            foreach ($csv_data as $key => $product) {
                if ($key == 0 || $key == 1 || $product[0] == '' || $product[2] == '') continue;
                $index = $key - 2;

                $product_list[$index]['active'] = $product[1];
                $product_list[$index]['product']['name'] = $product[2];
                $product_list[$index]['product']['slug'] = strtolower(str_replace(' ', '-', str_replace('.', '-', $product[2])));
                $product_list[$index]['product']['group'] = $product[3];
                $product_list[$index]['product']['note'] = $product[43];
                $product_list[$index]['product']['ref_link'] = $product[44];
                $product_list[$index]['product']['document_link'] = $product[45];
                $product_list[$index]['product']['price_1'] = $product[47];
                $product_list[$index]['product']['protection_class'] = $product[40];
                $product_list[$index]['product']['weight'] = $product[42];

                $product_list[$index]['alternator'][50]['hz'] = 50;
                $product_list[$index]['alternator'][50]['power'] = $product[4];
                $product_list[$index]['alternator'][50]['power_standby'] = $product[5];
                $product_list[$index]['alternator'][50]['phase'] = 3;
                $product_list[$index]['alternator'][50]['voltage'] = $product[33];
                $product_list[$index]['alternator'][50]['pole'] = $product[34];
                $product_list[$index]['alternator'][50]['speed'] = $product[35];
                $product_list[$index]['alternator'][50]['shaft_height'] = $product[36];
                $product_list[$index]['alternator'][50]['excitation'] = $product[38];
                $product_list[$index]['alternator'][50]['max_efficiency'] = $product[37];
                $product_list[$index]['alternator'][50]['regulation'] = $product[39];
                $product_list[$index]['alternator'][50]['number_of_wires'] = $product[40];
                $product_list[$index]['alternator'][50]['about_power'] = $product[32];

                $product_list[$index]['alternator'][50]['efficiency_standby'] = $product[6];
                $product_list[$index]['alternator'][50]['efficiency'] = $product[7];
                $product_list[$index]['alternator'][50]['efficiency_2'] = $product[8];
                $product_list[$index]['alternator'][50]['efficiency_3'] = $product[9];
                //$product_list[$index]['alternator'][50]['efficiency_4'] = $product[8];

                $product_list[$index]['alternator'][50]['power_single_phase'] = $product[11];
                $product_list[$index]['alternator'][50]['power_single_phase_standby'] = $product[12];
                $product_list[$index]['alternator'][50]['efficiency_single_standby'] = $product[13];
                $product_list[$index]['alternator'][50]['efficiency_single'] = $product[14];
                $product_list[$index]['alternator'][50]['efficiency_single_2'] = $product[15];
                $product_list[$index]['alternator'][50]['efficiency_single_3'] = $product[16];
                //$product_list[$index]['alternator'][50]['efficiency_single_4'] = $product[8];

                //hz 60
                $product_list[$index]['alternator'][60]['hz'] = 60;
                $product_list[$index]['alternator'][60]['power'] = $product[18];
                $product_list[$index]['alternator'][60]['power_standby'] = $product[19];
                $product_list[$index]['alternator'][60]['phase'] = 3;
                $product_list[$index]['alternator'][60]['voltage'] = $product[33];
                $product_list[$index]['alternator'][60]['pole'] = $product[34];
                $product_list[$index]['alternator'][60]['speed'] = $product[35];
                $product_list[$index]['alternator'][60]['shaft_height'] = $product[36];
                $product_list[$index]['alternator'][60]['excitation'] = $product[38];
                $product_list[$index]['alternator'][60]['max_efficiency'] = $product[37];
                $product_list[$index]['alternator'][60]['regulation'] = $product[39];
                $product_list[$index]['alternator'][60]['number_of_wires'] = $product[40];
                $product_list[$index]['alternator'][60]['about_power'] = $product[32];

                $product_list[$index]['alternator'][60]['efficiency_standby'] = $product[20];
                $product_list[$index]['alternator'][60]['efficiency'] = $product[21];
                $product_list[$index]['alternator'][60]['efficiency_2'] = $product[22];
                $product_list[$index]['alternator'][60]['efficiency_3'] = $product[23];
                //$product_list[$index]['alternator'][60]['efficiency_4'] = $product[8];

                $product_list[$index]['alternator'][60]['power_single_phase'] = $product[25];
                $product_list[$index]['alternator'][60]['power_single_phase_standby'] = $product[26];
                $product_list[$index]['alternator'][60]['efficiency_single_standby'] = $product[27];
                $product_list[$index]['alternator'][60]['efficiency_single'] = $product[28];
                $product_list[$index]['alternator'][60]['efficiency_single_2'] = $product[29];
                $product_list[$index]['alternator'][60]['efficiency_single_3'] = $product[30];
                //$product_list[$index]['alternator'][60]['efficiency_single_4'] = $product[8];
            }

            foreach ($product_list as $product) {
                $product['product']['primary_category'] = 2;
                $product['product']['enabled_1'] = 1;
                $product['product']['manufacturers'] = 7;
                if ($active == false) {
                    \CI::db()->insert('products', $product['product']);
                    $product_id = \CI::db()->insert_id();
                    \CI::db()->insert('category_products', array('product_id' => $product_id, 'category_id' => 2));

                    $product['alternator'][50]['product_id'] = $product_id;
                    \CI::db()->insert('alternators', $product['alternator'][50]);
                    $product['alternator'][60]['product_id'] = $product_id;
                    \CI::db()->insert('alternators', $product['alternator'][60]);
                }else{
                    $query = \CI::db()->where('slug', $product['product']['slug'])->get('products');
                    if($query->num_rows() > 0) {
                        $result = $query->row_array();
                        $product_id = $result['id'];

                        \CI::db()->where('id', $product_id);
                        \CI::db()->update('products', $product['product']);

                        \CI::db()->where('product_id', $product_id)->where('hz', 50);
                        \CI::db()->insert('alternators', $product['alternator'][50]);

                        \CI::db()->where('product_id', $product_id)->where('hz', 60);
                        \CI::db()->insert('alternators', $product['alternator'][60]);

                    }else{
                        \CI::db()->insert('products', $product['product']);
                        $product_id = \CI::db()->insert_id();
                        \CI::db()->insert('category_products', array('product_id' => $product_id, 'category_id' => 2));

                        $product['alternators'][50]['product_id'] = $product_id;
                        \CI::db()->insert('alternators', $product['alternator'][50]);

                        $product['alternators'][60]['product_id'] = $product_id;
                        \CI::db()->insert('alternators', $product['alternator'][60]);
                    }
                }
            }
        }
        //pr($product_list);
        exit;

        \CI::db()->insert('engines', $parameters);
        $product_id = \CI::db()->insert_id();


        $data = array();
        // Create DOM from URL or file
        $html = file_get_html('https://www.perkins.com/en_GB/products/new/perkins/electric-power-generation/diesel-generators/1000002660.html');

        $modelTitle = $html->find('div.modelTitle');
        foreach($modelTitle as $element) {
            $data['name'] = trim($element->plaintext);
            break;
        }
        $data['slug'] = strtolower(str_replace(' ', '-', $data['name']));
        $download = $html->find('div#toggle-product-downloads ul li a');
        foreach($download as $element) {
            $data['document_link'] = $element->href;
            break;
        }
        $img = $html->find('ul#carousel-photos a img');
        foreach($img as $element) {
            $link_img = $element->src;
            break;
        }

        $tmp_name = '404D-22G';
        $images = $this->save_image($tmp_name, $link_img);

        echo $images; exit;
        // Find all images
        $tmp_array = array('bore','stroke','displacement','aspiration','rotation ','cylinders','cycle','compression_ratio',
            'combustion_system','cooling_system','total_coolant_capacity','total_lubricating_capacity','length','width','height','weight','disclaimer1','disclaimer2','emissions');
        $tmp_data = array();
        foreach($html->find('.unit-metric') as $key=>$element) {
            $tmp_data[$tmp_array[$key]] = trim($element->plaintext);
            if(count($tmp_array) == ($key + 1)) break;
        }

        $data['dimensions'] = str_replace('.0 mm','',$tmp_data['length']).'x'.str_replace('.0 mm','',$tmp_data['width']).'x'.str_replace('.0 mm','',$tmp_data['height']);
        $data['weight'] = str_replace(' kg', '', $tmp_data['weight']);
        //\CI::db()->insert('products', $data);
        //$product_id = \CI::db()->insert_id();

        $parameters = array();
        //$parameters['product_id']   = $product_id;
        $parameters['bore']         = $tmp_data['bore'];
        $parameters['stroke']       = $tmp_data['stroke'];
        $parameters['displacement'] = $tmp_data['displacement'];
        $parameters['cylinders_number']     = $tmp_data['cylinders'];
        $parameters['compression_ratio']    = $tmp_data['compression_ratio'];
        $parameters['type_cooled']          = $tmp_data['cooling_system'];
        $parameters['emissions']            = $tmp_data['emissions'];

        //\CI::db()->insert('engines', $parameters);


        echo '<pre>';print_r($data);pr($parameters);

        // Find all links
        //foreach($html->find('a') as $element)
          //  echo $element->href . '<br>';

        echo 'aaaa';exit;
    }

    public function save_image($tmp_name, $link_img){
        \CI::load()->library('image_lib');
        $image = file_get_contents($link_img);
        $tmp_img = str_replace(' ','',trim(strtolower($tmp_name)));
        $path_image = $_SERVER['DOCUMENT_ROOT'].'/uploads/images/full/'.$tmp_img.'.jpg';

        file_put_contents($path_image, $image);
        $name_image = $tmp_img.'.jpg';

        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/images/full/'.$name_image;
        $config['new_image'] = 'uploads/images/medium/'.$name_image;
        $config['maintain_ratio'] = false;
        $config['width'] = 664;
        $config['height'] = 466;
        \CI::image_lib()->initialize($config);
        \CI::image_lib()->resize();
        \CI::image_lib()->clear();

        //small image
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/images/medium/'.$name_image;
        $config['new_image'] = 'uploads/images/small/'.$name_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 235;
        $config['height'] = 235;
        \CI::image_lib()->initialize($config);
        \CI::image_lib()->resize();
        \CI::image_lib()->clear();

        //cropped thumbnail
        $config['image_library'] = 'gd2';
        $config['source_image'] = 'uploads/images/small/'.$name_image;
        $config['new_image'] = 'uploads/images/thumbnails/'.$name_image;
        $config['maintain_ratio'] = false;
        $config['width'] = 144;
        $config['height'] = 105;
        \CI::image_lib()->initialize($config);
        \CI::image_lib()->resize();
        \CI::image_lib()->clear();

        return '{"'.$tmp_img.'":{"filename":"'.$tmp_img.'.jpg","alt":"engine-'.$tmp_img.'","caption":"","primary":"TRUE"}}';

    }
    public function index($rows=100, $order_by="name", $sort_order="ASC", $code=0, $page=0)
    {
        $data['groups'] = \CI::Customers()->get_groups();
        $data['page_title'] = lang('products');

        $data['code'] = $code;
        $term = false;

        //get the category list for the drop menu
        $data['categories'] = \CI::Categories()->getCategoryOptionsMenu();

        $post = \CI::input()->post(null, false);
        \CI::load()->model('Search');
        if($post)
        {
            $term = json_encode($post);
            $code = \CI::Search()->recordTerm($term);
            $data['code'] = $code;
        }
        elseif ($code)
        {
            $term = \CI::Search()->getTerm($code);
        }

        //store the search term
        $data['term'] = $term;
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;
        $data['rows'] = $rows;
        $data['page'] = $page;

        $data['products'] = \CI::Products()->products(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order, 'rows'=>$rows, 'page'=>$page));

        //total number of products
        $data['total'] = \CI::Products()->products(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order), true);


        \CI::load()->library('pagination');

        $config['base_url'] = site_url('admin/products/'.$rows.'/'.$order_by.'/'.$sort_order.'/'.$code.'/');
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $rows;
        $config['uri_segment'] = 7;
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        \CI::pagination()->initialize($config);

        $this->view('products', $data);
    }

    //basic category search
    public function product_autocomplete()
    {
        $name = trim(\CI::input()->post('name'));
        $limit = \CI::input()->post('limit');

        if(empty($name))
        {
            echo json_encode([]);
        }
        else
        {
            $results = \CI::Products()->product_autocomplete($name, $limit);

            $return = [];

            foreach($results as $r)
            {
                $return[$r->id] = $r->name;
            }
            echo json_encode($return);
        }

    }

    public function bulk_save()
    {
        $products = \CI::input()->post('product');

        if(!$products)
        {
            \CI::session()->set_flashdata('error', lang('error_bulk_no_products'));
            redirect('admin/products');
        }

        foreach($products as $id=>$product)
        {
            $product['id'] = $id;
            \CI::Products()->save($product);
        }

        \CI::session()->set_flashdata('message', lang('message_bulk_update'));
        redirect('admin/products');
    }

    public function form($id = false, $duplicate = false)
    {
        $this->product_id = $id;
        \CI::load()->library('form_validation');
        \CI::load()->model(array('ProductOptions', 'Categories', 'DigitalProducts', 'Customers'));
        \CI::lang()->load('digital_products');
        \CI::form_validation()->set_error_delimiters('<div class="error">', '</div>');

        $data['groups'] = \CI::Customers()->get_groups();
        $data['categories'] = \CI::Categories()->get_categories_tiered();
        $data['file_list'] = \CI::DigitalProducts()->getList();

        $data['page_title'] = lang('product_form');

        //default values are empty if the product is new
        $data['id'] = '';
        $data['sku'] = '';
        $data['primary_category'] = '';
        $data['name'] = '';
        $data['slug'] = '';
        $data['description'] = '';
        $data['excerpt'] = '';
        $data['weight'] = '';
        $data['track_stock'] = '';
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['shippable'] = '';
        $data['taxable'] = '';
        $data['fixed_quantity'] = '';
        $data['quantity'] = '';
        $data['enabled'] = '';
        $data['related_products'] = [];
        $data['product_categories'] = [];
        $data['images'] = [];
        $data['product_files'] = [];
        $data['productOptions'] = [];

        foreach($data['groups'] as $group)
        {
            $data['enabled_'.$group->id] = '';
            $data['price_'.$group->id] = '';
            $data['saleprice_'.$group->id] = '';
        }
        
		
		// get_manufacturers
		$data['manufacturers'] = \CI::Products()->get_manufacturers(true);
		
        //create the photos array for later use
        $data['photos'] = [];

        if ($id)
        {
            // get the existing file associations and create a format we can read from the form to set the checkboxes
            $pr_files = \CI::DigitalProducts()->getAssociationsByProduct($id);
            foreach($pr_files as $f)
            {
                $data['product_files'][]  = $f->file_id;
            }

            // get product & options data
            $data['productOptions'] = \CI::ProductOptions()->getProductOptions($id);
            $product = \CI::Products()->find($id, true);

            //if the product does not exist, redirect them to the product list with an error
            if (!$product)
            {
                \CI::session()->set_flashdata('error', lang('error_not_found'));
                redirect('admin/products');
            }

            //helps us with the slug generation
            $this->product_name = \CI::input()->post('slug', $product->slug);

            //set values to db values
            $data['id']     = $id;
            $data['sku']    = $product->sku;
            $data['primary_category'] = $product->primary_category;
            $data['name']       = $product->name;
            $data['seo_title']  = $product->seo_title;
            $data['meta']       = $product->meta;
            $data['slug']       = $product->slug;
            $data['description']= $product->description;
            $data['excerpt']    = $product->excerpt;
            
            $data['weight']     = $product->weight;
			$data['dimensions'] = $product->dimensions;
			$data['days']       = $product->days;
			$data['ogirin']     = $product->ogirin;
            $data['track_stock']= $product->track_stock;
            $data['shippable']  = $product->shippable;
            $data['quantity']   = $product->quantity;
            $data['taxable']    = $product->taxable;
            $data['fixed_quantity']     = $product->fixed_quantity;
			
			$data['manufacturer']       = $product->manufacturers;
            $data['protection_class']   = $product->protection_class;
            $data['document_link']      = $product->document_link;

            foreach($data['groups'] as $group)
            {
                $data['enabled_'.$group->id] = $product->{'enabled_'.$group->id};
                $data['price_'.$group->id] = $product->{'price_'.$group->id};
                $data['saleprice_'.$group->id] = $product->{'saleprice_'.$group->id};
            }

            //make sure we haven't submitted the form yet before we pull in the images/related products from the database
            if(!\CI::input()->post('submit'))
            {

                $data['product_categories'] = [];
                foreach($product->categories as $product_category)
                {
                    $data['product_categories'][] = $product_category->id;
                }

                $data['related_products'] = $product->related_products;
                $data['images'] = (array)json_decode($product->images);
            }
			
			// get document file
			$data['documents'] = \CI::Products()->get_documents($id);
			
			if($data['primary_category'] == 1){ // engine
				$engine = \CI::Products()->find_engine($id);
				$data['prime'] 		= isset($engine->prime) ? $engine->prime : '';
				$data['standby'] 	= isset($engine->standby) ? $engine->standby : '';				
				$data['prime_2'] 	= isset($engine->prime_2) ? $engine->prime_2 : '';
				$data['standby_2'] 	= isset($engine->standby_2) ? $engine->standby_2 : '';
                //$data['funnel_phi'] = isset($engine->funnel_phi) ? $engine->funnel_phi : '';
                $data['type_cooled']= isset($engine->type_cooled) ? $engine->type_cooled : '';
                $data['type_fuel']  = isset($engine->type_fuel) ? $engine->type_fuel : '';
                $data['dBA']        = isset($engine->dBA) ? $engine->dBA : '';
                $data['rpm']        = isset($engine->rpm) ? $engine->rpm : 1500;
                $data['rpm_2']      = isset($engine->rpm_2) ? $engine->rpm_2 : 1800;

				$fuel_consumption = \CI::Products()->find_fuel_consumption($id,50);
				$data['standby_fuel_con_1']	= isset($fuel_consumption->standby_fuel_con_1) ? $fuel_consumption->standby_fuel_con_1 : '';
				$data['standby_fuel_con_2']	= isset($fuel_consumption->standby_fuel_con_2) ? $fuel_consumption->standby_fuel_con_2 : '';
				$data['standby_fuel_con_3']	= isset($fuel_consumption->standby_fuel_con_3) ? $fuel_consumption->standby_fuel_con_3 : '';				
				$data['prime_fuel_con_1']	= isset($fuel_consumption->prime_fuel_con_1) ? $fuel_consumption->prime_fuel_con_1 : '';
				$data['prime_fuel_con_2']	= isset($fuel_consumption->prime_fuel_con_2) ? $fuel_consumption->prime_fuel_con_2 : '';
				$data['prime_fuel_con_3']	= isset($fuel_consumption->prime_fuel_con_3) ? $fuel_consumption->prime_fuel_con_3 : '';
				
				$fuel_consumption = \CI::Products()->find_fuel_consumption($id,60);
				$data['standby_fuel_con_2_1']	= isset($fuel_consumption->standby_fuel_con_2_1) ? $fuel_consumption->standby_fuel_con_2_1 : '';
				$data['standby_fuel_con_2_2']	= isset($fuel_consumption->standby_fuel_con_2_2) ? $fuel_consumption->standby_fuel_con_2_2 : '';
				$data['standby_fuel_con_2_3']	= isset($fuel_consumption->standby_fuel_con_2_3) ? $fuel_consumption->standby_fuel_con_2_3 : '';				
				$data['prime_fuel_con_2_1']	= isset($fuel_consumption->prime_fuel_con_2_1) ? $fuel_consumption->prime_fuel_con_2_1 : '';
				$data['prime_fuel_con_2_2']	= isset($fuel_consumption->prime_fuel_con_2_2) ? $fuel_consumption->prime_fuel_con_2_2 : '';
				$data['prime_fuel_con_2_3']	= isset($fuel_consumption->prime_fuel_con_2_3) ? $fuel_consumption->prime_fuel_con_2_3 : '';
			}

            if($data['primary_category'] == 2){ // canopy
                $alternator = \CI::Products()->find_alternator($id,50);
                $data['hz'] 			= isset($alternator->hz) ? $alternator->hz : 50;
                $data['power'] 			= isset($alternator->power) ? $alternator->power : '';
                $data['efficiency'] 	= isset($alternator->efficiency) ? $alternator->efficiency : '';
                $data['efficiency_2'] 	= isset($alternator->efficiency_2) ? $alternator->efficiency_2 : '';
                $data['efficiency_3'] 	= isset($alternator->efficiency_3) ? $alternator->efficiency_3 : '';
                $data['efficiency_4'] 	= isset($alternator->efficiency_4) ? $alternator->efficiency_4 : '';
                $data['power_single_phase'] = isset($alternator->power_single_phase) ? $alternator->power_single_phase : '';

                $alternator_2 = \CI::Products()->find_alternator($id,60);
                //print_r($alternator_2);exit;
                $data['hz_2'] 		= isset($alternator_2->hz) ? $alternator_2->hz : 60;
                $data['power_2'] = isset($alternator_2->power) ? $alternator_2->power : '';
                $data['efficiency_2_1'] 	= isset($alternator_2->efficiency) ? $alternator_2->efficiency : '';
                $data['efficiency_2_2'] 	= isset($alternator_2->efficiency_2) ? $alternator_2->efficiency_2 : '';
                $data['efficiency_2_3'] 	= isset($alternator_2->efficiency_3) ? $alternator_2->efficiency_3 : '';
                $data['efficiency_2_4'] 	= isset($alternator_2->efficiency_4) ? $alternator_2->efficiency_4 : '';

                $data['phase'] 		= isset($alternator->phase) ? $alternator->phase : '';
                $data['power_single_phase_2'] = isset($alternator->power_single_phase) ? $alternator->power_single_phase : '';
            }
			
			if($data['primary_category'] == 4){ // alternators
				$canopy = \CI::Products()->find_canopy($id);
                //print_r($canopy);exit;
				$data['canopy_kVA_min'] 	= isset($canopy->kVA_min) ? $canopy->kVA_min : '';
				$data['canopy_kVA_max'] 	= isset($canopy->kVA_max) ? $canopy->kVA_max : '';
				$data['canopy_standard'] 	= isset($canopy->standard) ? $canopy->standard : 0;
			}
			
        }

        //if $data['related_products'] is not an array, make it one.
        if(!is_array($data['related_products']))
        {
            $data['related_products']   = [];
        }
        if(!is_array($data['product_categories']))
        {
            $data['product_categories'] = [];
        }


        //no error checking on these
        \CI::form_validation()->set_rules('caption', 'Caption');
        \CI::form_validation()->set_rules('primary_photo', 'Primary');

        \CI::form_validation()->set_rules('sku', 'lang:sku', 'trim');
        \CI::form_validation()->set_rules('seo_title', 'lang:seo_title', 'trim');
        \CI::form_validation()->set_rules('meta', 'lang:meta_data', 'trim');
        \CI::form_validation()->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
        \CI::form_validation()->set_rules('slug', 'lang:slug', 'trim');
        \CI::form_validation()->set_rules('description', 'lang:description', 'trim');
        \CI::form_validation()->set_rules('excerpt', 'lang:excerpt', 'trim');
        \CI::form_validation()->set_rules('weight', 'lang:weight', 'trim|numeric|floatval');
        \CI::form_validation()->set_rules('track_stock', 'lang:track_stock', 'trim|numeric');
        \CI::form_validation()->set_rules('quantity', 'lang:quantity', 'trim|numeric');
        \CI::form_validation()->set_rules('shippable', 'lang:shippable', 'trim|numeric');
        \CI::form_validation()->set_rules('taxable', 'lang:taxable', 'trim|numeric');
        \CI::form_validation()->set_rules('fixed_quantity', 'lang:fixed_quantity', 'trim|numeric');

        foreach($data['groups'] as $group)
        {
            \CI::form_validation()->set_rules('enabled_'.$group->id, lang('enabled').'('.$group->name.')', 'trim|numeric');
            \CI::form_validation()->set_rules('price_'.$group->id, lang('price').'('.$group->name.')', 'trim|numeric|floatval');
            \CI::form_validation()->set_rules('saleprice_'.$group->id, lang('saleprice').'('.$group->name.')', 'trim|numeric|floatval');
        }

        /*
        if we've posted already, get the photo stuff and organize it
        if validation comes back negative, we feed this info back into the system
        if it comes back good, then we send it with the save item

        submit button has a value, so we can see when it's posted
        */

        if($duplicate)
        {
            $data['id'] = false;
        }
        if(\CI::input()->post('submit'))
        {
            //reset the product options that were submitted in the post
            $data['ProductOptions'] = \CI::input()->post('option');
            $data['related_products'] = \CI::input()->post('related_products');
            $data['product_categories'] = \CI::input()->post('categories');
            $data['images'] = \CI::input()->post('images');
            $data['product_files'] = \CI::input()->post('downloads');

        }

        if (\CI::form_validation()->run() == FALSE)
        {
            $this->view('product_form', $data);
        }
        else
        {
            \CI::load()->helper('text');

            //first check the slug field
            $slug = \CI::input()->post('slug');

            //if it's empty assign the name field
            if(empty($slug) || $slug=='')
            {
                $slug = \CI::input()->post('name');
            }

            $slug = url_title(convert_accented_characters($slug), '-', TRUE);

            //validate the slug
            $slug = ($id) ? \CI::Products()->validate_slug($slug, $product->id) : \CI::Products()->validate_slug($slug);


            $save['id'] 		= $id;
            $save['sku'] 		= \CI::input()->post('sku');
            $save['name'] 		= \CI::input()->post('name');
            $save['seo_title'] 	= \CI::input()->post('seo_title');
            $save['meta'] 		= \CI::input()->post('meta');
            $save['description'] 	= \CI::input()->post('description');
            $save['excerpt'] 		= \CI::input()->post('excerpt');
            $save['weight'] 		= \CI::input()->post('weight');
			$save['days'] 			= \CI::input()->post('days');
            $save['track_stock'] 	= \CI::input()->post('track_stock');
            $save['fixed_quantity'] = \CI::input()->post('fixed_quantity');
            $save['quantity'] 		= \CI::input()->post('quantity');
            $save['shippable'] 		= \CI::input()->post('shippable');
            $save['taxable'] 		= \CI::input()->post('taxable');
			$save['dimensions'] 	= \CI::input()->post('dimensions');
			$save['ogirin'] 		= \CI::input()->post('ogirin');
            $save['manufacturers'] 	= \CI::input()->post('manufacturers');
            $save['protection_class'] 	= \CI::input()->post('protection_class');
            $save['document_link'] 	    = \CI::input()->post('document_link');
            $post_images = \CI::input()->post('images');

            foreach($data['groups'] as $group)
            {
                $save['enabled_'.$group->id]    = \CI::input()->post('enabled_'.$group->id);
                $save['price_'.$group->id]      = \CI::input()->post('price_'.$group->id);
                $save['saleprice_'.$group->id]  = \CI::input()->post('saleprice_'.$group->id);
            }

            $save['slug'] = $slug;


            if($primary = \CI::input()->post('primary_image'))
            {
                if($post_images)
                {
                    foreach($post_images as $key => &$pi)
                    {
                        if($primary == $key)
                        {
                            $pi['primary']  = true;
                            continue;
                        }
                    }
                }

            }

            $save['images'] = json_encode($post_images);


            if(\CI::input()->post('related_products'))
            {
                $save['related_products'] = json_encode(\CI::input()->post('related_products'));
            }
            else
            {
                $save['related_products'] = '';
            }

            //save categories
            $categories = \CI::input()->post('categories');
            if(!$categories)
            {
                $categories = [];
            }

             //(\CI::input()->post('primary_category')) ? \CI::input()->post('primary_category') : 0;
            if(!\CI::input()->post('primary_category') && $categories)
            {
                $save['primary_category'] = $categories[0];
            }
            elseif(!\CI::input()->post('primary_category') && !$categories)
            {
                $save['primary_category'] = 0;
            }
            else
            {
                $save['primary_category'] = \CI::input()->post('primary_category');
            }


            // format options
            $options = [];
            if(\CI::input()->post('option'))
            {
                foreach (\CI::input()->post('option') as $option)
                {
                    $options[]  = $option;
                }

            }
				
            // save product
            $product_id = \CI::Products()->save($save, $options, $categories);

			// save file
			//should check upload file
			$config['allowed_types'] 	= '*';
            $config['upload_path'] 		= 'uploads/documents';//config_item('digital_products_path');
            $config['remove_spaces'] 	= true;

            \CI::load()->library('upload', $config);
            if(\CI::upload()->do_upload())
            {
                $upload_data 				= \CI::upload()->data();
				$document['product_id'] 	= $product_id;
				$document['file_name'] 		= $upload_data['file_name'];
				$document['display_name']	= \CI::input()->post('display_name');
				$document['size'] 			= $upload_data['file_size'];
				\CI::Products()->save_document($document);
            } /*else {
                $data['error'] 	= \CI::upload()->display_errors();
            }*/
			
			
			// save engine
			if($data['primary_category']==1){ // engine
				$save_engine['product_id'] 		= $id;
			
				$save_engine['rpm'] 			= \CI::input()->post('rpm');
				$save_engine['prime'] 			= \CI::input()->post('prime');
				$save_engine['standby'] 		= \CI::input()->post('standby');
				$save_engine['rpm_2'] 			= \CI::input()->post('rpm_2');;
				$save_engine['prime_2'] 		= \CI::input()->post('prime_2');
				$save_engine['standby_2'] 		= \CI::input()->post('standby_2');
                //$save_engine['funnel_phi']          = \CI::input()->post('funnel_phi');
                $save_engine['type_cooled']     = \CI::input()->post('type_cooled');
                $save_engine['type_fuel']       = \CI::input()->post('type_fuel');
                $save_engine['dBA']             = \CI::input()->post('dBA');
				$engine_id = \CI::Products()->save_engine($id, $engine->id, $save_engine);
				
				$save_fuel_consumption['standby_fuel_con_1']	= \CI::input()->post('standby_fuel_con_1');
				$save_fuel_consumption['standby_fuel_con_2']	= \CI::input()->post('standby_fuel_con_2');
				$save_fuel_consumption['standby_fuel_con_3']	= \CI::input()->post('standby_fuel_con_3');				
				$save_fuel_consumption['prime_fuel_con_1']		= \CI::input()->post('prime_fuel_con_1');
				$save_fuel_consumption['prime_fuel_con_2']		= \CI::input()->post('prime_fuel_con_2');
				$save_fuel_consumption['prime_fuel_con_3']		= \CI::input()->post('prime_fuel_con_3');
				$save_fuel_consumption['product_id'] 			= $id;
				$save_fuel_consumption['rpm'] 					= 1500;
				$save_fuel_consumption['hz'] 					= 50;

				$engine_id = \CI::Products()->fuel_consumption($id, $fuel_consumption->id, $save_fuel_consumption);
				//  echo lqr();
				$save_fuel_consumption_2['standby_fuel_con_1']	= \CI::input()->post('standby_fuel_con_2_1');
				$save_fuel_consumption_2['standby_fuel_con_2']	= \CI::input()->post('standby_fuel_con_2_2');
				$save_fuel_consumption_2['standby_fuel_con_3']	= \CI::input()->post('standby_fuel_con_2_3');				
				$save_fuel_consumption_2['prime_fuel_con_1']	= \CI::input()->post('prime_fuel_con_2_1');
				$save_fuel_consumption_2['prime_fuel_con_2']	= \CI::input()->post('prime_fuel_con_2_2');
				$save_fuel_consumption_2['prime_fuel_con_3']	= \CI::input()->post('prime_fuel_con_2_3');
				$save_fuel_consumption_2['product_id'] 			= $id;
				$save_fuel_consumption_2['rpm'] 				= 1800;
				$save_fuel_consumption_2['hz'] 					= 60;
				$engine_id = \CI::Products()->fuel_consumption($id, $fuel_consumption->id, $save_fuel_consumption_2);
			}
			
			// save alternators
			if($data['primary_category']==2){ // engine
				$save_alternator['product_id'] 		= $id;
							
				$save_alternator['hz'] 				= 50;
				$save_alternator['phase'] 			= \CI::input()->post('phase');
				$save_alternator['efficiency'] 		= \CI::input()->post('efficiency');
				$save_alternator['efficiency_2'] 	= \CI::input()->post('efficiency_2');
				$save_alternator['efficiency_3'] 	= \CI::input()->post('efficiency_3');
				$save_alternator['efficiency_4'] 	= \CI::input()->post('efficiency_4');
				$save_alternator['power'] 			= \CI::input()->post('power');
                $save_alternator['power_single_phase'] = \CI::input()->post('power_single_phase');
				$alternator_id = \CI::Products()->save_alternator($id, $alternator->id, $save_alternator);

				$save_alternator['hz'] 				= 60;
				$save_alternator['phase'] 			= \CI::input()->post('phase');
				$save_alternator['efficiency'] 		= \CI::input()->post('efficiency_2_1');
				$save_alternator['efficiency_2'] 	= \CI::input()->post('efficiency_2_2');
				$save_alternator['efficiency_3'] 	= \CI::input()->post('efficiency_2_3');
				$save_alternator['efficiency_4'] 	= \CI::input()->post('efficiency_2_4');
				$save_alternator['power'] 			= \CI::input()->post('power_2');
                $save_alternator['power_single_phase'] = \CI::input()->post('power_single_phase_2');
				$alternator_id = \CI::Products()->save_alternator($id, $alternator_2->id, $save_alternator);

				
			}
            if($data['primary_category']==4){ // engine
                $save_canopy['product_id']  = $id;
                $save_canopy['kVA_min']     = \CI::input()->post('kVA_min');
                $save_canopy['kVA_max']     = \CI::input()->post('kVA_max');
                $save_canopy['standard']    = \CI::input()->post('standard');
                $canopy_id = \CI::Products()->save_canopy($canopy->id, $save_canopy);
            }

            // add file associations
            // clear existsing
            \CI::DigitalProducts()->disassociate(false, $product_id);
            // save new
            $downloads = \CI::input()->post('downloads');
            if(is_array($downloads))
            {
                foreach($downloads as $d)
                {
                    \CI::DigitalProducts()->associate($d, $product_id);
                }
            }

            \CI::session()->set_flashdata('message', lang('message_saved_product'));

            //go back to the product list
            redirect('admin/products');
        }
    }

    public function giftCardForm($id = false, $duplicate = false)
    {
        $this->product_id = $id;
        \CI::load()->library('form_validation');
        \CI::load()->model(array('ProductOptions', 'Categories'));
        \CI::form_validation()->set_error_delimiters('<div class="error">', '</div>');

        $data['categories'] = \CI::Categories()->get_categories_tiered();
        $data['page_title'] = lang('giftcard_product_form');
        $data['groups'] = \CI::Customers()->get_groups();

        //default values are empty if the product is new
        $data['id'] = '';
        $data['sku'] = '';
        $data['primary_category'] = '';
        $data['name'] = '';
        $data['slug'] = '';
        $data['description'] = '';
        $data['excerpt'] = '';
        $data['track_stock'] = '';
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['is_giftcard'] = 1;
        $data['taxable'] = '';
        $data['images'] = [];
        $data['product_categories'] = [];
        $data['product_files'] = [];

        foreach($data['groups'] as $group)
        {
            $data['enabled_'.$group->id] = '';
        }

        //create the photos array for later use
        $data['photos'] = [];

        if ($id)
        {

            // get product & options data
            $data['ProductOptions'] = \CI::ProductOptions()->getProductOptions($id);
            $product = \CI::Products()->find($id, true);

            //if the product does not exist, redirect them to the product list with an error
            if (!$product)
            {
                \CI::session()->set_flashdata('error', lang('error_not_found'));
                redirect('admin/products');
            }

            //helps us with the slug generation
            $this->product_name = \CI::input()->post('slug', $product->slug);

            //set values to db values
            $data['id']                 = $id;
            $data['sku']                = $product->sku;
            $data['primary_category']   = $product->primary_category;
            $data['name']               = $product->name;
            $data['seo_title']          = $product->seo_title;
            $data['meta']               = $product->meta;
            $data['slug']               = $product->slug;
            $data['description']        = $product->description;
            $data['excerpt']            = $product->excerpt;
            $data['quantity']           = $product->quantity;
            $data['taxable']            = $product->taxable;
            $data['fixed_quantity']     = $product->fixed_quantity;
            $data['is_giftcard']        = $product->is_giftcard;
            foreach($data['groups'] as $group)
            {
                $data['enabled_'.$group->id] = $product->{'enabled_'.$group->id};
            }

            //make sure we haven't submitted the form yet before we pull in the images/related products from the database
            if(!\CI::input()->post('submit'))
            {

                $data['product_categories'] = [];
                foreach($product->categories as $product_category)
                {
                    $data['product_categories'][] = $product_category->id;
                }

                $data['related_products']   = $product->related_products;
                $data['images']             = (array)json_decode($product->images);
            }
        }

        if(!is_array($data['product_categories']))
        {
            $data['product_categories'] = [];
        }


        //no error checking on these
        \CI::form_validation()->set_rules('caption', 'Caption');
        \CI::form_validation()->set_rules('primary_photo', 'Primary');

        \CI::form_validation()->set_rules('sku', 'lang:sku', 'trim');
        \CI::form_validation()->set_rules('seo_title', 'lang:seo_title', 'trim');
        \CI::form_validation()->set_rules('meta', 'lang:meta_data', 'trim');
        \CI::form_validation()->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
        \CI::form_validation()->set_rules('slug', 'lang:slug', 'trim');
        \CI::form_validation()->set_rules('description', 'lang:description', 'trim');
        \CI::form_validation()->set_rules('excerpt', 'lang:excerpt', 'trim');
        \CI::form_validation()->set_rules('taxable', 'lang:taxable', 'trim|numeric');
        \CI::form_validation()->set_rules('fixed_quantity', 'lang:fixed_quantity', 'trim|numeric');
        
        \CI::form_validation()->set_rules('option[giftcard_values]', 'lang:giftcard_values', 'required');
        foreach($data['groups'] as $group)
        {
            \CI::form_validation()->set_rules('enabled_'.$group->id, lang('enabled').'('.$group->name.')', 'trim|numeric');
        }
        /*
        if we've posted already, get the photo stuff and organize it
        if validation comes back negative, we feed this info back into the system
        if it comes back good, then we send it with the save item

        submit button has a value, so we can see when it's posted
        */

        if($duplicate)
        {
            $data['id'] = false;
        }
        if(\CI::input()->post('submit'))
        {
            //reset the product options that were submitted in the post
            $data['ProductOptions'] = \CI::input()->post('option');
            $data['product_categories'] = \CI::input()->post('categories');
            $data['images'] = \CI::input()->post('images');

        }

        if (\CI::form_validation()->run() == FALSE)
        {
            $this->view('giftcard_product_form', $data);
        }
        else
        {
            \CI::load()->helper('text');

            //first check the slug field
            $slug = \CI::input()->post('slug');

            //if it's empty assign the name field
            if(empty($slug) || $slug=='')
            {
                $slug = \CI::input()->post('name');
            }

            $slug   = url_title(convert_accented_characters($slug), '-', TRUE);

            //validate the slug
            $slug = ($id) ? \CI::Products()->validate_slug($slug, $product->id) : \CI::Products()->validate_slug($slug);


            $save['id'] = $id;
            $save['sku'] = \CI::input()->post('sku');
            $save['name'] = \CI::input()->post('name');
            $save['seo_title'] = \CI::input()->post('seo_title');
            $save['meta'] = \CI::input()->post('meta');
            $save['description'] = \CI::input()->post('description');
            $save['excerpt'] = \CI::input()->post('excerpt');
            
            foreach($data['groups'] as $group)
            {
                $save['enabled_'.$group->id] = \CI::input()->post('enabled_'.$group->id);
                $save['price_'.$group->id] = '0.00';
                $save['saleprice_'.$group->id] = '0.00';
            }

            $save['is_giftcard'] = 1;
            $save['taxable'] = \CI::input()->post('taxable');
            $save['taxable'] = \CI::input()->post('taxable');
            $post_images = \CI::input()->post('images');

            $save['slug'] = $slug;


            if($primary = \CI::input()->post('primary_image'))
            {
                if($post_images)
                {
                    foreach($post_images as $key => &$pi)
                    {
                        if($primary == $key)
                        {
                            $pi['primary'] = true;
                            continue;
                        }
                    }
                }

            }

            $save['images'] = json_encode($post_images);


            if(\CI::input()->post('related_products'))
            {
                $save['related_products'] = json_encode(\CI::input()->post('related_products'));
            }
            else
            {
                $save['related_products'] = '';
            }

            //save categories
            $categories = \CI::input()->post('categories');
            if(!$categories)
            {
                $categories = [];
            }

             //(\CI::input()->post('primary_category')) ? \CI::input()->post('primary_category') : 0;
            if(!\CI::input()->post('primary_category') && $categories)
            {
                $save['primary_category'] = $categories[0];
            }
            elseif(!\CI::input()->post('primary_category') && !$categories)
            {
                $save['primary_category'] = 0;
            }
            else
            {
                $save['primary_category'] = \CI::input()->post('primary_category');
            }


            // format options
            $options = [];
            array_push($options, [
                                    'type' => 'textfield',
                                    'name' => 'from',
                                    'required' => 1,
                                    'values' =>
                                    [
                                        '0' =>
                                        [
                                            'name' => 'from',
                                            'value' => '',
                                            'price' => 0,
                                            'limit' => 0
                                        ]
                                    ]
                                ]);

            array_push($options, [
                                    'type' => 'textfield',
                                    'name' => 'to_email',
                                    'required' => 1,
                                    'values' =>
                                    [
                                        '0' =>
                                        [
                                            'name' => 'to_email',
                                            'value' => '',
                                            'price' => 0,
                                            'limit' => 0
                                        ]
                                    ]
                                ]);

            array_push($options, [
                                    'type' => 'textarea',
                                    'name' => 'personal_message',
                                    'required' => 1,
                                    'values' =>
                                    [
                                        '0' =>
                                        [
                                            'name' => 'personal_message',
                                            'value' => '',
                                            'price' => 0
                                        ]
                                    ]
                                ]);

            $giftcard_values = [];
            $postedValues = \CI::input()->post('option[giftcard_values]');
            if($postedValues)
            {
                foreach($postedValues as $giftcard_value)
                {
                    array_push($giftcard_values, ['name'=> 'beginning_amount', 'value' => $giftcard_value, 'weight'=>'', 'price' => $giftcard_value]);
                }
            }
            

            array_push($options, [
                                    'type' => 'droplist',
                                    'name' => 'beginning_amount',
                                    'required' => 1,
                                    'values' => $giftcard_values
                                ]);


            // save product
            $product_id = \CI::Products()->save($save, $options, $categories);


            \CI::session()->set_flashdata('message', lang('message_saved_giftcard_product'));

            //go back to the product list
            redirect('admin/products');
        }

    }


    public function product_image_form()
    {
        $data['file_name'] = false;
        $data['error']  = false;
        $this->partial('iframe/product_image_uploader', $data);
    }

    public function product_image_upload()
    {
        $data['file_name'] = false;
        $data['error']  = false;

        $config['allowed_types'] = 'gif|jpg|png';
        //$config['max_size']   = config_item('size_limit');
        $config['upload_path'] = 'uploads/images/full';
        $config['encrypt_name'] = false;
        $config['remove_spaces'] = true;

        \CI::load()->library('upload', $config);

        if ( \CI::upload()->do_upload())
        {
            $upload_data    = \CI::upload()->data();

            \CI::load()->library('image_lib');

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/full/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 600;
            $config['height'] = 500;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            //small image
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/small/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 235;
            $config['height'] = 235;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            //cropped thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/small/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/thumbnails/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 150;
            $config['height'] = 150;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            $data['file_name'] = $upload_data['file_name'];
        }

        if(\CI::upload()->display_errors() != '')
        {
            $data['error'] = \CI::upload()->display_errors();
        }
        $this->partial('iframe/product_image_uploader', $data);
    }

    public function delete($id = false)
    {
        if ($id)
        {
            $product = \CI::Products()->find($id);
            //if the product does not exist, redirect them to the customer list with an error
            if (!$product)
            {
                \CI::session()->set_flashdata('error', lang('error_not_found'));
                redirect('admin/products');
            }
            else
            {

                //if the product is legit, delete them
                \CI::Products()->delete_product($id);

                \CI::session()->set_flashdata('message', lang('message_deleted_product'));
                redirect('admin/products');
            }
        }
        else
        {
            //if they do not provide an id send them to the product list page with an error
            \CI::session()->set_flashdata('error', lang('error_not_found'));
            redirect('admin/products');
        }
    }
	
	public function delete_documents()
    {echo 'cccc';exit;
        // \CI::Products()->delete_product($id);
		echo "Deleted succsessful";
    }
}
