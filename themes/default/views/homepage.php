<div class="alert">
	<form method="post" accept-charset="utf-8">
	<div class="col-nest">
		<div class="col" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
		Please enter kVA:<input name="power" value="<?php echo $power?>"> </input>
		</div>
		<div class="col" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
		Hz
			<select name="hz">
				<option value="50" <?php if($hz == 50) echo 'selected'?>> 50hz </option>
				<option value="60" <?php if($hz == 60) echo 'selected'?>> 60hz </option>
			</select>
		</div>
		<div class="col pull-right" style="margin-top:22px" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
			<button type="button" class="btn btn-primary">More Option</button>
		</div>
	</div>
	<div><button type="submit" class="btn btn-primary">Submit</button></div>
	</form>
</div>

<?php if(!empty($generators)){?>
	<div> <h1>Results</h1></div>
	
	<div class="productsFilter">
        <div class="pull-right">
            <select id="sort">
                <option data-option="power" <?php echo($sort=='name' && $dir == 'DESC')?' selected="selected"':'';?>  value="asc">Sort by power Low to Hight</option>
                <option data-option="power" <?php echo($sort=='name' && $dir == 'ASC')?' selected="selected"':'';?> value="desc">Sort by power Hight to Low</option>
                <option data-option="price" <?php echo($sort=='price' && $dir == 'ASC')?' selected="selected"':'';?>  value="asc"><?php echo lang('sort_by_price_asc');?></option>
                <option data-option="price" <?php echo($sort=='price' && $dir == 'DESC')?' selected="selected"':'';?>  value="desc"><?php echo lang('sort_by_price_desc');?></option>
				<option data-option="day" <?php echo($sort=='name' && $dir == 'DESC')?' selected="selected"':'';?>  value="asc">Sort by day</option>
            </select>
        </div>
        <div class="pull-right">
            <label class="control-label" for="input-limit"><?php echo lang('sort'); ?></label>
        </div>
    </div> 
	
	<div class="col-nest categoryItems element" id="generators">
    <?php foreach($generators as $generator):?>
        <div class="col listing-item" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1" data-power="<?php echo round ($generator['generator_kVA']);?>" data-price="<?php echo format_currency($generator['price']);?>" data-day="<?php echo $generator['days'];?>">
            <?php
            $photo  = theme_img('no_picture.png');
			$url = site_url('/product/generator/'.$generator['engine']->product_id.'/'.$generator['alternator']->product_id);
            ?>
			
            <div class="categoryItem" >
			
                <div class="previewImg">
					<a href="<?php echo $url;?>" target="_blank"><img src="<?php echo $photo;?>"></a>
				</div>

                <div class="categoryItemDetails">
                    <div>
						<h1><?php echo $generator['name'];?>AB</h1>
					</div>
					<div>
						Standby Power: <b><?php echo round ($generator['generator_kVA']);?></b> kVA
					</div>
					<div>
						Price: <?php echo format_currency($generator['price']);?>
					</div>
					<!--<div>
						Days: <?php echo $generator['days'];?>
					</div>-->
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

<script>
	$( "#sort" ).change(function() {
		var value =  $(this).val() ;
		var option = $(this).children('option:selected').data('option');
		var divList = $(".listing-item");
		if(value=='asc') {
			divList.sort(function (a, b) {
				return $(a).data(option) - $(b).data(option)
			});
		}else{
			divList.sort(function (a, b) {
				return $(b).data(option) - $(a).data(option)
			});
		}
		$("#generators").html(divList);
	});
</script>

<?php }else {if(@$power>0){?>
	<div>Not found, Please contact us! </div>
<?php }}?>


