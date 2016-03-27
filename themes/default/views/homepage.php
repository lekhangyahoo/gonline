<div class="alert">
	<form method="post" accept-charset="utf-8">
	<div class="col-nest">
		<div class="col" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
		Stand By &nbsp; <input type="radio" name="stand_by" checked value="1"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; Prime &nbsp; <input type="radio" name="stand_by" />
			<input name="power" value="<?php echo $power?>" placeholder="Please enter kVA"> </input>
		</div>
		<div class="col" data-cols="1/8" data-medium-cols="1/2" data-small-cols="1">
		Hz
			<select name="hz">
				<option value="50" <?php if($hz == 50) echo 'selected'?>> 50 hz </option>
				<option value="60" <?php if($hz == 60) echo 'selected'?>> 60 hz </option>
			</select>
		</div>
		<div class="col" data-cols="1/8" data-medium-cols="1/2" data-small-cols="1">
			Phase
			<select name="phase">
				<option value="3" <?php if(@$phase == 3) echo 'selected'?>> Three </option>
				<option value="1" <?php if(@$phase == 1) echo 'selected'?>> Single </option>
			</select>
		</div>
		<div class="col pull-right" style="margin-top:22px" data-cols="1/4" data-medium-cols="1/2" data-small-cols="1">
			<button type="button" class="btn">More Option</button>
		</div>
	</div>
	<div><button type="submit" class="btn">Submit</button></div>
	</form>
</div>

<?php if(!empty($generators)){?>
	<div> <h1>Results</h1></div>
	
	
	<div class="mobile-gen">
	  <table class="table" style="font-size:12px">
		<thead>
		  <tr>
			<th style="min-width:130px" class="border-right">MODEL</th>
			<th class="border-right">R.P.M</th>
			<th class="border-right">CONTIN. PRP</th>
			<th class="border-right">STAND-BY LTP</th>
			<th class="border-right">PRICE</th>
			<th>DELIVERY</th>
		  </tr>
		</thead>
		<tbody>
			<?php
				//$image_compare = array('default-compare-1.JPG','default-compare-2.JPG');
				$image_compare = array('default-compare-1.JPG','default-compare-1.JPG');
			?>
			<?php foreach($generators as $key=>$gen){ $index_ima = $key%2;//$index_ima = rand(0, 3);?>
			<?php $url = site_url('/product/generator/'.$gen['engine']->product_id.'/'.$gen['alternator']->product_id.'/0/0/'.$hz.'/'.$phase);?>
			<tr class="compare_<?php echo $key;?> <?php if($key % 2 == 1) echo 'line2';else echo 'line1'?>">
				<td class="image-gen border-right">
					<a href="<?php echo $url;?>" target="_blank">
						<img src="<?php echo base_url('themes/default/assets/img/'.$image_compare[$index_ima])?>" width="81" height="59" border="0" align="left">
						<br>
						<?php echo $gen['name'];?>
					</a>
				</td>
				<td align="center" class="border-right">
					<?php if($phase == 1 )echo $gen['engine']->rpm; else echo $gen['engine']->rpm_2;?>
				</td>
				<td class="border-right">
					<?php echo round($gen['generator_kVA']);?>
				</td>
				<td class="border-right">
					<?php echo round($gen['engine']->s_kAV);?>
				</td>
				<td class="border-right">
					<?php echo format_currency($gen['price']);?>
				</td>
				<td>
					<?php echo $gen['days'];?> days
				</td>
			</tr>
			<?php }?>
		</tbody>
	  </table>
	</div>

	<div class="cojefichas">
		<div class="cojecabeceras">
			<div class="cabecera1"><p>MODEL</p></div>
			<div class="cabecera2"><p>R.P.M</p></div>
			<div class="cabecera3">
				<div class="cabecera31"> POWER (kVA)</div>
				<div class="cabecera32">CONTIN. PRP</div>
				<div class="cabecera32">STAND-BY LTP</div>
				<!--
				<div class="cabecera33">kVA</div>
				<div class="cabecera33">kW</div>
				<div class="cabecera33">kVA</div>
				<div class="cabecera33">kW</div>
				-->
			</div>
			<div class="cabecera4"><p>ENGINE</p></div>
			<div class="cabecera41"><p>ALTERNATOR</p></div>
			<div class="cabecera5"><p>PRICE</p>
			</div>
			<div class="cabecera6">
				<p>DELIVERY<br>
				</p>
			</div>

			<div class="cabecera7">
				<p>DOWNLOADS<br>
				</p>
			</div>

			<div class="cabecera8">
				<p>ACTION<br>
				</p>
			</div>

			<br>
		</div>

		<?php foreach($generators as $key=>$gen){ $index_ima = $key%2;//$index_ima = rand(0, 3);?>
			<?php if($key%2==1){ $line2 = ' line2'; }else {$line2='';}?>
			<div class="cojeresultados compare_<?php echo $key;?>" id="compare_<?php echo $key;?>">
				<div class="resultado1">
					<?php $url = site_url('/product/generator/'.$gen['engine']->product_id.'/'.$gen['alternator']->product_id.'/0/0/'.$hz.'/'.$phase);?>
					<a href="<?php echo $url;?>" target="_blank">
						<img src="<?php echo base_url('themes/default/assets/img/'.$image_compare[$index_ima])?>" width="81" height="59" hspace="15" border="0" align="left">
						<br>
						<?php echo $gen['name'];?>
					</a>
				</div>
				<div class="resultado2 <?php echo $line2?>">
					<p class="marginTop20">
						<?php if($phase == 1 )echo $gen['engine']->rpm; else echo $gen['engine']->rpm_2;?>
					</p>
				</div>
				<div class="resultado3 <?php echo $line2?>">
					<p class="marginTop20"><?php echo round($gen['generator_p_kVA']);?></p>
				</div>
				<!--
				<div class="resultado3 <?php echo $line2?>">
					<p class="marginTop20"><?php //echo $gen['result']['engine_parameters']->prime;?></p>
				</div>
				-->
				<div class="resultado3 <?php echo $line2?>">
					<p class="marginTop20"><?php echo round($gen['generator_kVA']);?></p>
				</div>
				<!--
				<div class="resultado3 <?php echo $line2?>">
					<p class="marginTop20"><?php echo round($gen['generator_kVA']);?></p>
				</div>
				-->
				<div class="resultado4 <?php echo $line2?>">
					<p class="marginTop15">
						<?php echo $gen['engine']->name;?><br>
						<!--<?php echo $gen['engine']->name;?>-->
					</p>
				</div>
				<div class="resultado41 <?php echo $line2?>">
					<p class="marginTop15">
						<?php echo $gen['alternator']->name;?><br>
						<!--<?php echo $gen['alternator']->name;?>-->
					</p>
				</div>
				<div class="resultado5 <?php echo $line2?>"><p class="marginTop20"><?php echo format_currency($gen['price']);?></p></div>
				<div class="resultado6 <?php echo $line2?>">
					<p class="marginTop20"><?php echo $gen['days'];?></p>
				</div>
				<div class="resultado7 <?php echo $line2?>">
					<?php $url_document = str_replace('/generator/','/documents/',$url)?>
					<a target="_blank" href="<?php echo $url_document;?>">
						<p class="marginTop20"><img src="<?php echo base_url('assets/img/pdf.png');?>?>" width="121" height="25" ></p>
					</a>
				</div>
				<div class="resultado8 <?php echo $line2?>">
					<p class="marginTop20">
						<input name="Enviar" type="submit" onclick="set_url_gen('<?php echo $url?>')" data-toggle="modal" data-target="#myModal" class="boton-enviar-ficha" value="Contact">
					</p>
				</div>
			</div>
		<?php }?>

	</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">Contact us</h3>
				</div>
				<div class="modal-body">
					<p>Please enter your email or mobile</p>
					<input name="email_contact" id="email_contact" placeholder="Your email or mobile">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" onclick="form_send_email()" class="btn btn-info" data-dismiss="modal" style="background-color: #31b0d5;border-color: #269abc;">Save</button>
				</div>
			</div>
		</div>
	</div>
<script>
	var url ='';
	function set_url_gen(url_gen){
		url = url_gen;
	}
	function form_send_email(){
		var type = 0;
		var email = $("#email_contact").val();
		if( (isValidEmailAddress(email) || $.isNumeric( email ) ) && email !=''){
			if(isValidEmailAddress( email ))
				type = 1;
			if($.isNumeric( email ))
				type = 2;

			$.ajax({
				method: "POST",
				url: "<?php echo site_url('product/contact');?>/"+type,
				data: { email: email, url: url}
			}).done(function( msg ) {
				if(msg)
					alert("Thank you for your contact");
				$("#email_contact").val('');
			});

		}else {
			alert("Please enter your email or mobile");
		}

		return;
	}

	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
		return pattern.test(emailAddress);
	};
</script>
<?php /*
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
			$url = site_url('/product/generator/'.$generator['engine']->product_id.'/'.$generator['alternator']->product_id.'/0/0/'.$hz.'/'.$phase);
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
*/?>
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


