<div class="alert">
	<form method="post" accept-charset="utf-8">
	<div class="col-nest">
		<div class="col" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
		Please enter kVA:<input name="power" value="<?php echo $power?>"> </input>
		</div>
		<div class="col" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
		Hz
			<select id="sort">
                <option value="50"> 50hz </option>
                <option value="60"> 60hz </option>
            </select>
		</div>
		<div class="col pull-right" style="margin-top:22px" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
			<button type="button" class="btn btn-primary">More Option</button>
		</div>
	</div>
	<div><button type="submit" class="btn btn-primary">Submit</button></div>
	</form>
	<?php //if(!empty($engines) || !empty($alternators)) {echo '<pre>'; print_r($engines); print_r($alternators);echo '</pre>';}?>
</div>

<!--
<?php if(!empty($generators)){?>
<div> <h1>Results</h1></div>
<?php $count = 1; foreach($generators as $generator){?>
<div>
	<div><?php echo "#".$count?></div>
	<div>Engine -- Name: <?php echo $generator['engine']->name?>, Prime:<?php echo $generator['engine']->prime?> kWm, Standby:<?php echo $generator['engine']->standby?> kWm, Days:<?php echo $generator['engine']->days?></div>
	
	<div>kVA: <?php echo round ($generator['kVA'])?></div>
	
	<div>Alternator 50hz -- Name: <?php echo $generator['alternator']->name?>, kVA: <?php echo $generator['alternator']->power;?>, Days:<?php echo $generator['alternator']->days?></div>
	
	<div>Generator kVA: <?php echo round ($generator['generator_kVA'])?></div>
	
	<div>Max: <?php if($generator['engine']->days > $generator['alternator']->days) echo $generator['engine']->days;else echo $generator['alternator']->days?> days</div>
	<div>Total price: <?php echo $generator['price']?></div>
</div>
<hr/>	
<?php $count++;}?>
<?php }else {if(@$power>0){?>
<div>Not found, Please contact us! </div>
<?php }}?>
-->
<?php if(!empty($generators)){?>
	<div> <h1>Results</h1></div>
	
	<div class="productsFilter">
        <div class="pull-right">
            <select id="sort">
                <option <?php echo($sort=='name' && $dir == 'DESC')?' selected="selected"':'';?>  value="<?php echo site_url('category/'.$slug.'/name/DESC/'.$page);?>">Sort by power Low to Hight</option>
                <option <?php echo($sort=='name' && $dir == 'ASC')?' selected="selected"':'';?> value="<?php echo site_url('category/'.$slug.'/name/ASC/'.$page);?>">Sort by power Hight to Low</option>
                <option <?php echo($sort=='price' && $dir == 'ASC')?' selected="selected"':'';?>  value="<?php echo site_url('category/'.$slug.'/price/ASC/'.$page);?>"><?php echo lang('sort_by_price_asc');?></option>
                <option <?php echo($sort=='price' && $dir == 'DESC')?' selected="selected"':'';?>  value="<?php echo site_url('category/'.$slug.'/price/DESC/'.$page);?>"><?php echo lang('sort_by_price_desc');?></option>
            </select>
        </div>
        <div class="pull-right">
            <label class="control-label" for="input-limit"><?php echo lang('sort'); ?></label>
        </div>
    </div> 
	
	<div class="col-nest categoryItems element">
    <?php foreach($generators as $generator):?>
        <div class="col" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
            <?php
            $photo  = theme_img('no_picture.png');
            ?>
			
            <div target="_blank" onclick="window.location = '<?php echo site_url('/product/generator/'.$generator['engine']->product_id.'/'.$generator['alternator']->product_id)?>'" class="categoryItem" >
			
                <div class="previewImg"><img src="<?php echo $photo;?>"></div>

                <div class="categoryItemDetails">
                    <div><h1><?php //echo $product->name;?>G50-<?php echo round ($generator['generator_kVA']).$generator['engine']->code.$generator['alternator']->code;?>AB</h1></div>					
					<div>
						Standby Power: <?php echo round ($generator['generator_kVA']);?> kVA
					</div>
					<div>
						Price: <?php echo format_currency($generator['price']);?>
					</div>
					<div>
						Days: <?php echo $generator['days'];?>
					</div>
					<!--
					<div>
						Engine Power: <?php echo $generator['engine']->standby?> kWm, <?php echo round($generator['engine']->standby/0.8)?> kVA
					</div>
					<div>
						Alternator Power: <?php echo $generator['alternator']->power;?> kVA, <?php echo $generator['alternator']->efficiency;?> %
					</div>
					-->
                </div>                

            </div>
        </div>
    <?php endforeach;?>
    </div>
<?php }else {if(@$power>0){?>
	<div>Not found, Please contact us! </div>
<?php }}?>