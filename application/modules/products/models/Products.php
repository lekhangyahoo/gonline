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

Class Products extends CI_Model
{
    public function __construct()
    {
        $this->customer = \CI::Login()->customer();
    }

    public function getProduct($id, $get_manufacturers = false)
    {
        //do this again right here since it can be used for combining the cart. We want to make sure it's fresh.
        $this->customer = \GC::getCustomer();

        //find the product
        $product = CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price')->where('id', $id)->where('enabled_'.$this->customer->group_id, '1')->get('products')->row();
        $product = $this->processImageDecoding($product);
        return $product;
    }
	
	public function getParameters($id, $table = 'engines')
    {
        if($table=='alternators') CI::db()->where('hz', 50);
        $engines = CI::db()->select('*')->where('product_id', $id)->get($table)->row();
        return $engines;
    }
	
	public function getManufacturers($id)
    {
        return CI::db()->where('id', $id)->get('manufacturers')->row();
    }
	
    public function product_autocomplete($name, $limit)
    {
        return  CI::db()->like('name', $name)->get('products', $limit)->result();
    }

    public function touchInventory($id, $quantity)
    {
        $product = $this->getProduct($id);
        if(!$product)
        {
            return false;
        }

        CI::db()->where('id', $id)->update('products', ['quantity' => ($product->quantity - $quantity)]);
    }

    public function products($data=[], $return_count=false)
    {
        if(empty($data))
        {
            //if nothing is provided return the whole shabang
            CI::db()->order_by('name', 'ASC');
            $result = CI::db()->get('products');

            return $result->result();
        }
        else
        {
            //grab the limit
            if(!empty($data['rows']))
            {
                CI::db()->limit($data['rows']);
            }

            //grab the page
            if(!empty($data['page']))
            {
                CI::db()->offset($data['page']);
            }

            //do we order by something other than category_id?
            if(!empty($data['order_by']))
            {
                //if we have an order_by then we must have a direction otherwise KABOOM
                CI::db()->order_by($data['order_by'], $data['sort_order']);
            }

            //do we have a search submitted?
            if(!empty($data['term']))
            {
                $search = json_decode($data['term']);
                //if we are searching dig through some basic fields
                if(!empty($search->term))
                {
                    CI::db()->like('name', $search->term);
                    CI::db()->or_like('description', $search->term);
                    CI::db()->or_like('excerpt', $search->term);
                    CI::db()->or_like('sku', $search->term);
                }

                if(!empty($search->category_id))
                {
                    //lets do some joins to get the proper category products
                    CI::db()->join('category_products', 'category_products.product_id=products.id', 'right');
                    CI::db()->where('category_products.category_id', $search->category_id);
                    //CI::db()->order_by('sequence', 'ASC');
                }
            }

            if($return_count)
            {
                return CI::db()->count_all_results('products');
            }
            else
            {
                return CI::db()->get('products')->result();
            }

        }
    }

    public function getProducts($category_id = false, $limit = false, $offset = false, $by=false, $sort=false)
    {
        //if we are provided a category_id, then get products according to category
        if ($category_id)
        {
            CI::db()->select('category_products.*, products.*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price, LEAST(IFNULL(NULLIF(saleprice_'.$this->customer->group_id.', 0), price_'.$this->customer->group_id.'), price_'.$this->customer->group_id.') as sort_price', false)->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$category_id, 'enabled_'.$this->customer->group_id=>1));

            CI::db()->order_by($by, $sort);

            $result = CI::db()->limit($limit)->offset($offset)->get()->result();

            $products = [];

            foreach($result as $product)
            {
                $products[] = $this->processImageDecoding($product);
            }
            return $products;
        }
        else
        {
            //sort by alphabetically by default
            return CI::db()->order_by('name', 'ASC')->get('products')->result();
        }
    }
	
	public function getProductsCondition($power = 0, $rpm = 1500, $get_max = true, $limit = false, $offset = false, $by=false, $sort=false)
    {
		// prime, standby is kWm , => kVA = kWm/cos
		
		/*CI::db()->select('products.*, engines.*, (engines.prime/engines.power_factor) as p_kAV, (engines.standby/engines.power_factor) as s_kAV , (engines.standby/engines.power_factor*1.5) as max_s_kAV, (engines.standby/engines.power_factor*0.8) as min_s_kAV');
		CI::db()->where('engines.rpm', 1500);
		//CI::db()->where('max_s_kAV >= '.$power);
		CI::db()->where('engines.standby/engines.power_factor*'.$par_max.' >= '.$power);
		CI::db()->where('engines.standby/engines.power_factor*'.$par_min.' <= '.$power);
		CI::db()->join('engines', 'engines.product_id=products.id');
        return CI::db()->order_by('name', 'ASC')->get('products')->result();*/
		
		/*$sql = 'SELECT products.*, `engines`.*, (engines.prime/engines.power_factor) AS p_kAV, (engines.standby/engines.power_factor) AS s_kAV, (engines.standby/engines.power_factor*'.$par_max.') AS max_s_kAV, (engines.standby/engines.power_factor*'.$par_min.') AS min_s_kAV '
		.'FROM products JOIN `engines` ON engines.product_id=products.id '
		.'WHERE engines.rpm = 1500 AND engines.standby/engines.power_factor >= '.$par_min*$power.' AND engines.standby/engines.power_factor <= '.$par_max*$power.'  ORDER BY `name` ASC';*/
		if($rpm == 1500){
			if($get_max){	// get max
				$sql = 'SELECT products.*, manufacturers.code, `engines`.*, (engines.prime/engines.power_factor) AS p_kAV, (engines.standby/engines.power_factor) AS s_kAV '
				.'FROM products JOIN `engines` ON engines.product_id=products.id '
				.'JOIN `manufacturers` ON manufacturers.id=products.manufacturers '
				.'WHERE engines.standby/engines.power_factor >= '.$power.' ORDER BY `name` ASC limit 50';
			}
			else {			// get min
				$sql = 'SELECT products.*, `engines`.*, (engines.prime/engines.power_factor) AS p_kAV, (engines.standby/engines.power_factor) AS s_kAV '
				.'FROM products JOIN `engines` ON engines.product_id=products.id '
				.'WHERE engines.standby/engines.power_factor < '.$power.' ORDER BY `name` ASC limit 50';
			}
		}else{
			if($get_max){	// get max
				$sql = 'SELECT products.*, manufacturers.code, `engines`.*, (engines.prime_2/engines.power_factor) AS p_kAV, (engines.standby_2/engines.power_factor) AS s_kAV '
				.'FROM products JOIN `engines` ON engines.product_id=products.id '
				.'JOIN `manufacturers` ON manufacturers.id=products.manufacturers '
				.'WHERE engines.standby_2/engines.power_factor >= '.$power.' ORDER BY `name` ASC limit 50';
			}
			else {			// get min
				$sql = 'SELECT products.*, manufacturers.code, `engines`.*, (engines.prime_2/engines.power_factor) AS p_kAV, (engines.standby_2/engines.power_factor) AS s_kAV '
				.'FROM products JOIN `engines` ON engines.product_id=products.id '
				.'JOIN `manufacturers` ON manufacturers.id=products.manufacturers '
				.'WHERE engines.standby_2/engines.power_factor < '.$power.' ORDER BY `name` ASC limit 50';
			}
		}
		
		return CI::db()->query($sql)->result();
        
    }
	
	public function getProductsAlternators($power = 0, $hz = 50, $limit = false, $offset = false, $by=false, $sort=false)
    {        
		CI::db()->select('products.*, manufacturers.code, alternators.product_id, alternators.hz, alternators.power, alternators.phase, alternators.efficiency, alternators.efficiency_2, alternators.efficiency_3, alternators.efficiency_4');
		CI::db()->where('alternators.hz', $hz);
		CI::db()->where('alternators.efficiency > ', 0);
		CI::db()->where('alternators.power > '.($power*0.85));
		CI::db()->join('alternators', 'alternators.product_id=products.id');
		CI::db()->join('manufacturers', 'manufacturers.id=products.manufacturers');
        return CI::db()->order_by('name', 'ASC')->get('products')->result();
    }

    public function count_all_products()
    {
        return CI::db()->count_all_results('products');
    }

    public function count_products($id)
    {
        return CI::db()->select('product_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$id, 'enabled_'.$this->customer->group_id=>1))->count_all_results();
    }

    public function slug($slug, $related=true)
    {
      $result = CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price')->get_where('products', array('slug'=>$slug, 'enabled_'.$this->customer->group_id=>1))->row();

      if(!$result)
        {
            return false;
        }

        $related = json_decode($result->related_products);

        if(!empty($related))
        {
            //build the where
            $where = [];
            foreach($related as $r)
            {
                $where[] = '`id` = '.$r;
            }
            CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price');
            CI::db()->where('('.implode(' OR ', $where).')', null);
            CI::db()->where('enabled_'.$this->customer->group_id, 1);

            $result->related_products   = CI::db()->get('products')->result();
        }
        else
        {
            $result->related_products   = [];
        }
        $result->categories = $this->getProductCategories($result->id);

        return $result;
    }

    public function find($id, $related=true)
    {
        $result = CI::db()->get_where('products', array('id'=>$id))->row();
        if(!$result)
        {
            return false;
        }

        if($related)
        {
            $relatedItems = json_decode($result->related_products);
            if(!empty($relatedItems))
            {
                //build the where
                $where = [];
                foreach($relatedItems as $r)
                {
                    $where[] = '`id` = '.$r;
                }

                CI::db()->where('('.implode(' OR ', $where).')', null);
                CI::db()->where('enabled_'.$this->customer->group_id, 1);

                $result->related_products   = CI::db()->get('products')->result();
            }
            else
            {
                $result->related_products   = [];
            }
        }

        $result->categories = $this->getProductCategories($result->id);

        return $result;
    }
	
	public function find_engine($product_id)
    {
        $result = CI::db()->get_where('engines', array('product_id'=>$product_id))->row();
        if(!$result)
        {
            return false;
        }
        return $result;
    }
	
	public function find_alternator($product_id, $hz)
    {
        $result = CI::db()->get_where('alternators', array('product_id'=>$product_id, 'hz'=>$hz))->row();
        if(!$result)
        {
            return false;
        }
        return $result;
    }
	

    public function getProductCategories($id)
    {
        return CI::db()->where('product_id', $id)->join('categories', 'category_id = categories.id')->get('category_products')->result();
    }

    public function save($product, $options=false, $categories=false)
    {
        if ($product['id'])
        {
            CI::db()->where('id', $product['id']);
            CI::db()->update('products', $product);

            $id = $product['id'];
        }
        else
        {
            CI::db()->insert('products', $product);
            $id = CI::db()->insert_id();
        }

        //loop through the product options and add them to the db
        if($options !== false)
        {

            // wipe the slate
            CI::ProductOptions()->clearOptions($id);

            // save edited values
            $count = 1;
            foreach ($options as $option)
            {
                $values = $option['values'];
                unset($option['values']);
                $option['product_id'] = $id;
                $option['sequence'] = $count;

                CI::ProductOptions()->saveOption($option, $values);
                $count++;
            }
        }

        if($categories !== false)
        {
            if($product['id'])
            {
                //get all the categories that the product is in
                $cats   = $this->getProductCategories($id);

                //generate cat_id array
                $ids    = [];
                foreach($cats as $c)
                {
                    $ids[]  = $c->id;
                }

                //eliminate categories that products are no longer in
                foreach($ids as $c)
                {
                    if(!in_array($c, $categories))
                    {
                        CI::db()->delete('category_products', array('product_id'=>$id,'category_id'=>$c));
                    }
                }

                //add products to new categories
                foreach($categories as $c)
                {
                    if(!in_array($c, $ids))
                    {
                        CI::db()->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
                    }
                }
            }
            else
            {
                //new product add them all
                foreach($categories as $c)
                {
                    CI::db()->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
                }
            }
        }

        //return the product id
        return $id;
    }
	
	public function save_document($document)
    {
        CI::db()->insert('products_documents', $document);
        $id = CI::db()->insert_id();        
	}
	
	public function save_engine($product_id ='', $engine_id ='', $engine = array() )
    {
        if ($engine_id > 0)
        {
            CI::db()->where('id', $engine_id);
            CI::db()->update('engines', $engine);
        }
        else
        {
            CI::db()->insert('engines', $engine);
            $id = CI::db()->insert_id();
        }
        
        //return the engine id
        return true;
    }
	
	public function save_alternator($product_id ='', $engine_id ='', $engine = array())
    {
        if ($engine_id > 0)
        {
            CI::db()->where('id', $engine_id);
			CI::db()->where('hz', $engine['hz']);
            CI::db()->update('alternators', $engine);
        }
        else
        {
            CI::db()->insert('alternators', $engine);
            $id = CI::db()->insert_id();
        }
        
        //return the engine id
        return true;
    }

    public function delete_product($id)
    {
        // delete product
        CI::db()->where('id', $id);
        CI::db()->delete('products');

        //delete references in the product to category table
        CI::db()->where('product_id', $id);
        CI::db()->delete('category_products');

        // delete coupon reference
        CI::db()->where('product_id', $id);
        CI::db()->delete('coupons_products');
    }

    public function search_products($term, $limit=false, $offset=false, $by=false, $sort=false)
    {
        $results = [];

        CI::db()->select('*, LEAST(IFNULL(NULLIF(saleprice_'.$this->customer->group_id.', 0), price_'.$this->customer->group_id.'), price_'.$this->customer->group_id.') as sort_price', false);
        //this one counts the total number for our pagination
        CI::db()->where('enabled_'.$this->customer->group_id, 1);
        CI::db()->where('(name LIKE "%'.CI::db()->escape_like_str($term).'%" OR description LIKE "%'.CI::db()->escape_like_str($term).'%" OR excerpt LIKE "%'.CI::db()->escape_like_str($term).'%" OR sku LIKE "%'.CI::db()->escape_like_str($term).'%")');
        $results['count'] = CI::db()->count_all_results('products');


        CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price, LEAST(IFNULL(NULLIF(saleprice_'.$this->customer->group_id.', 0), price_'.$this->customer->group_id.'), price_'.$this->customer->group_id.') as sort_price', false);
        //this one gets just the ones we need.
        CI::db()->where('enabled_'.$this->customer->group_id, 1);
        CI::db()->where('(name LIKE "%'.CI::db()->escape_like_str($term).'%" OR description LIKE "%'.CI::db()->escape_like_str($term).'%" OR excerpt LIKE "%'.CI::db()->escape_like_str($term).'%" OR sku LIKE "%'.CI::db()->escape_like_str($term).'%")');

        if($by && $sort)
        {
            CI::db()->order_by($by, $sort);
        }
        $products = CI::db()->get('products', $limit, $offset)->result();
        $results['products'] = [];
        foreach($products as $product)
        {
            $results['products'][] = $this->processImageDecoding($product);
        }

        return $results;
    }

    public function processImageDecoding($product)
    {
        if($product)
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
            return $product;
        }
        else
        {
            return $product;
        }
        
    }

    public function validate_slug($slug, $id=false, $counter=false)
    {
        CI::db()->select('slug');
        CI::db()->from('products');
        CI::db()->where('slug', $slug.$counter);
        if ($id)
        {
            CI::db()->where('id !=', $id);
        }
        $count = CI::db()->count_all_results();

        if ($count > 0)
        {
            if(!$counter)
            {
                $counter = 1;
            }
            else
            {
                $counter++;
            }
            return $this->validate_slug($slug, $id, $counter);
        }
        else
        {
             return $slug.$counter;
        }
    }
	
	public function get_manufacturers($option = true){		
		if($option){
			$results = CI::db()->get('manufacturers')->result();
			$tmp[] 	= array();
			$tmp[0] = 'Select manufacturer';
			foreach($results as $result){
				$tmp[$result->id] = $result->name;
			}
			return $tmp;			
		}
		else {
			return CI::db()->get('manufacturers')->result_array();
		}
	}

}
