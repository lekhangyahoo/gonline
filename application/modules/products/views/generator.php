<style>
.download-document {
    padding: 10px 0;
    border-bottom: 1px solid #C5C5C5;
	width: 75%;
}
.last{border:none}
</style>
<div class="page-header">
    <h2>GENERATOR Model <?php echo $generators['name'];?></h2>
	<div><?php echo round($generators['kVA_standby']);?> kVA, <?php echo $engine_manufacturer?> Engine, <?php echo $hz;?> Hz - <?php if($phase==1) echo 'Single-phase';else echo 'Three-phase'?> - <?php echo $alternator_manufacturer?> Alternator </div>
	
</div>

<div class="col-nest">
    <div class="col" data-cols="2/5" data-medium-cols="2/5">
        <div class="productImg"><?php
        $photo = theme_img('pic_generator.png', lang('no_image_available'));

        if(!empty($product->images[0]))
        {
            foreach($product->images as $photo)
            {
                if(isset($photo['primary']))
                {
                    $primary = $photo;
                }
            }
            if(!isset($primary))
            {
                $tmp = $product->images; //duplicate the array so we don't lose it.
                $primary = array_shift($tmp);
            }

            $photo = '<img src="'.base_url('uploads/images/full/'.$primary['filename']).'" alt="'.$product->seo_title.'" data-caption="'.htmlentities(nl2br($primary['caption'])).'"/>';
        }
        echo $photo
        ?></div>
        <?php if(!empty($primary['caption'])):?>
        <div class="productCaption">
            <?php echo $primary['caption'];?>
        </div>
        <?php endif;?>

        <?php if(count($product->images) > 1):?>
            <div class="col-nest productImages">

                <?php foreach($product->images as $image):?>
                    <div class="col productThumbnail" data-cols="1/3" data-medium-cols="1/3" data-small-cols="1/3" style="margin:15px 0px;">
                        <img src="<?php echo base_url('uploads/images/full/'.$image['filename']);?>" data-caption="<?php echo htmlentities(nl2br($image['caption']));?>"/>
                    </div>
                <?php endforeach;?>

            </div>
        <?php endif;?>
		
		<div>
			<div class="page-header"><b>Technical Document Downloads</b></div>			
			<div class="download-document last">
				<img src="<?php echo base_url('assets/img')?>/label-pdf.gif" width="20" height="9" alt="PDF" border="0">
				<?php $url_document = str_replace('/generator/','/documents/',uri_string())?>
				<a target="_blank" href="<?php echo base_url($url_document)?>">Spec. Sheet - <?php echo $generators['name'];?>.pdf</a>
			</div>
		</div>
		
    </div>


    <div class="col pull-right" style="padding: 0px 25px;" data-cols="3/5" data-medium-cols="3/5">
        <div id="productAlerts"></div>
            <div class="productPrice">           
                <?php echo format_currency($generators['price']);?>
            </div>
        <div class="productDetails"> 

            <div class="productDescription">
                <?php echo (new content_filter($product->description))->display();?>
				<div id="textos">
					<p class="negro14">GENERAL FEATURES:</p>
					<p class="arial13"><strong>Power Generator with manual control panel.</strong></p>
					<p><strong><span class="verde">ENGINE</span></strong><br>
					  Make: <strong><?php echo $engine_manufacturer?></strong><br>
					  Model: <strong><?php echo $eng->name;?></strong></p>
					<p><strong><span class="verde">ALTERNATOR</span></strong><br>
					  Model: <strong><?php echo $alternator_manufacturer?></strong>
					  <br>
					  Model: <strong><?php echo $alt->name;?></strong>
					</p>
					<p><strong><span class="verde">CONTROLLER</span></strong><br>
					  Model: <strong>Decision - Maker</strong></p>					
				</div>				
				
				<div class="potencia"><div class="potencia1"><strong>STAND-BY POWER:</strong><br>
					<span class="arial11normal">(LTP “Limited Time Power” norma ISO 8528-1)</span></div>
					<div class="potencia2"><?php echo round($generators['kVA_standby']);?> kVA</div>
				</div>
				<div style="clear: both;"></div>
				<div style="clear: both; height:5px;"></div>
				
				<div class="potencia">
					<div class="potencia1">
						<strong>PRIME POWER:</strong><br>
						<span class="arial11normal">(PRP “Prime Power” norma ISO 8528-1)</span>
					</div>
					<div class="potencia2"><?php echo round($generators['kVA_prime']);?> kVA</div>
				</div>
				
				<!--
				<div><span style="font-size:18px">Generator: </span><?php echo $generators['name'];?></div>
				<div>Standby: <?php echo round($generators['kVA_standby']);?> kVA. Prime: <?php echo round($generators['kVA_prime']);?> kVA</div>
				
				<br/>
				
				<div><span style="font-size:18px">Engine: </span><a href="<?php echo site_url('product/'.$product->slug);?>" target="_blank"><?php echo $product->name?></a></div>
				<div>Standby: <?php echo $engine_parameters->standby;?> kWm. Prime: <?php echo $engine_parameters->prime;?> kWm</div>
				
				<br/>
				
				<div><span style="font-size:18px">Alternator: </span><a href="<?php echo site_url('product/'.$alt->slug);?>" target="_blank"><?php echo $alt->name?></a></div>
				<div>Power: <?php echo $engine_alternator->power;?> kVA. Efficiency: <?php echo $engine_alternator->efficiency;?> %</div>
				
				<br/>
				
				<div><span style="font-size:18px">Controller : </span><a href="#" target="_blank">Decision -Maker</a></div>
				<div>- Digital display and keypad provide easy local data access</div>
				<div>- Measurements a re selectable in metric o r English units</div>
				-->
            </div>
			
			<div class="potencia4">
				
					<div class="columnasfooter">
					<div class="columna-enviar-ficha">
						<input autocomplete="true" name="email_contact" type="text" class="formu-enviar-ficha" id="email_contact" value="" placeholder="E-mail or phone number">
						<input name="Enviar" type="submit" onclick="form_send_email(0)" class="boton-enviar-ficha" value="Contact me">
					</div>
					</div>
				
			</div>
							
			<div class="potencia4" style="height:auto;margin-top:15px;">
				<p class="arial14">
					Need more information?, <a class="verde more-information" href="javascript:void(0)" ><strong>CONTACT</strong></a>
				</p>
				<div class="content-information" style="display:none">
					<input autocomplete="true" name="name" type="text" class="formu-enviar-ficha" id="name" value="" placeholder="Company's name">
					<input autocomplete="true" name="email" type="text" class="formu-enviar-ficha" id="email" value="" placeholder="E-mail">
					<input autocomplete="true" name="mobile" type="text" class="formu-enviar-ficha" id="mobile" value="" placeholder="Phone number">
					<input autocomplete="true" name="address" type="text" class="formu-enviar-ficha" id="address" value="" placeholder="Your address">
					<input autocomplete="true" name="subject" type="text" class="formu-enviar-ficha" id="subject" value="" placeholder="Subject">
					<textarea rows="4" cols="50" name="content" class="" id="content" placeholder="Message"></textarea>
					<input name="Enviar" type="submit" onclick="form_send_email(1)" class="boton-enviar-ficha" value="Send">
					<br>
				</div>	
				
			</div>
			
			<div class="potencia4 compare"  style="height:40px;margin-top:15px;">
				<p class="arial14">
                    Compare &nbsp; <input type="checkbox" id="check_compare" value="1">

                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a id="show-compare" <?php if(!\CI::session()->userdata('compare')) echo 'style="display: none" ';?>class="boton-enviar-ficha" href="<?php echo site_url('product/compare/1'); ?>" target="_blank">Show compare</a>

                </p>
			</div>
			
			<!--
			<?php echo form_open('cart/add-to-cart', 'id="add-to-cart"');?>
            <input type="hidden" name="cartkey" value="<?php echo CI::session()->flashdata('cartkey');?>" />
            <input type="hidden" name="id" value="<?php echo $product->id?>"/>

            <div class="text-left">
            <?php if(!config_item('inventory_enabled') || config_item('allow_os_purchase') || !(bool)$product->track_stock || $product->quantity > 0) : ?>

                <?php if(!$product->fixed_quantity) : ?>

                        <strong>Quantity&nbsp;</strong>
                        <input type="text" name="quantity" value="1" style="width:50px; display:inline"/>&nbsp;
                        <button class="blue" type="button" value="submit" onclick="addToCart($(this));"><i class="icon-cart"></i> <?php echo lang('form_add_to_cart');?></button>
                <?php else: ?>
                        <button class="blue" type="button" value="submit" onclick="addToCart($(this));"><i class="icon-cart"></i> <?php echo lang('form_add_to_cart');?></button>
                <?php endif;?>

            <?php endif;?>
                </div>
            </form>
			-->

        </div>		

    </div>
</div>


<script>
	$( ".more-information" ).click(function() {
		$( ".content-information" ).toggle(400);
	});

	function form_send_email(flag){
		var type = 0;
		if(flag==0){
			var email = $("#email_contact").val();			
			if( (isValidEmailAddress(email) || $.isNumeric( email ) ) && email !=''){
				if(isValidEmailAddress( email ))
					type = 1;
				if($.isNumeric( email ))
					type = 2;
				
				var url = '<?php echo uri_string();?>';
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
		}else{
			var email 	= $("#email").val();
			var mobile 	= $("#mobile").val();
			var name 	= $("#name").val();
			var address = $("#address").val();
			var subject = $("#subject").val();
			var content = $("#content").val();
			var type = 0;
			if( (isValidEmailAddress(email) || $.isNumeric( mobile ) ) && (email !='' || mobile !='' ) ){
				var url = '<?php echo uri_string();?>';
				$.ajax({
					method: "POST",
					url: "<?php echo site_url('product/contact');?>/"+type,
					data: { email: email, mobile: mobile, url: url, name: name, address: address, subject: subject, content: content}
				}).done(function( msg ) {
						if(msg)
							alert("Thank you for your contact");
						$( ".content-information" ).toggle(400);
						$("#email").val('');$("#mobile").val('');
						$("#name").val('');$("#address").val('');
						$("#subject").val('');$("#content").val('');
					});
					  
			}else {
				alert("Please enter your email or mobile");
			}
		}
		return;
	}
	
	function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/);
        return pattern.test(emailAddress);
    };
	
	$('#check_compare').click(function() {
        var url = '<?php echo uri_string();?>';
        if ($(this).is(':checked')) {
            $.ajax({
                method: "POST",
                url: "<?php echo site_url('product/add_compare/1');?>",
                data: {url: url}
            }).done(function( msg ) {
                    //alert( "Data Saved: " + msg );
                if(msg==true)
                    $("#show-compare").show();
                else $("#show-compare").hide();
              });
        }
		else {
            $.ajax({
                method: "POST",
                url: "<?php echo site_url('product/remove_compare/1');?>",
                data: { url: url}
            }).done(function( msg ) {
                //alert( "Data Saved: " + msg );
                if(msg==true) {
                    $("#show-compare").show();
                } else {
                    $("#show-compare").hide();
                }
            });
		}
    });

    function addToCart(btn)
    {
        $('.productDetails').spin();
        btn.attr('disabled', true);
        var cart = $('#add-to-cart');
        $.post(cart.attr('action'), cart.serialize(), function(data){
            if(data.message != undefined)
            {
                $('#productAlerts').html('<div class="alert green">'+data.message+' <a href="<?php echo site_url('checkout');?>"> <?php echo lang('view_cart');?></a> <i class="close"></i></div>');
                updateItemCount(data.itemCount);
                cart[0].reset();
            }
            else if(data.error != undefined)
            {
                $('#productAlerts').html('<div class="alert red">'+data.error+' <i class="close"></i></div>');
            }

            $('.productDetails').spin(false);
            btn.attr('disabled', false);
        }, 'json');
    }

    var banners = false;
    $(document).ready(function(){
        banners = $('#banners').html();
    })

    $('.productImages img').click(function(){
        if(banners)
        {
            $.gumboTray(banners);
            $('.banners').gumboBanner($('.productImages img').index(this));
        }
    });

    $('.tabs').gumboTabs();
</script>

<?php if(count($product->images) > 1):?>
<script id="banners" type="text/template">
    <div class="banners">
        <?php
        foreach($product->images as $image):?>
                <div class="banner" style="text-align:center;">
                    <img src="<?php echo base_url('uploads/images/full/'.$image['filename']);?>" style="max-height:600px; margin:auto;"/>
                    <?php if(!empty($image['caption'])):?>
                        <div class="caption">
                            <?php echo $image['caption'];?>
                        </div>
                    <?php endif; ?>
                </div>
        <?php endforeach;?>
        <a class="controls" data-direction="back"><i class="icon-chevron-left"></i></a>
        <a class="controls" data-direction="forward"><i class="icon-chevron-right"></i></a>
        <div class="banner-timer"></div>
    </div>
</script>
<?php endif;?>


<?php if(!empty($product->related_products)):?>
    <div class="page-header" style="margin-top:30px;">
        <h3><?php echo lang('related_products_title');?></h3>
    </div>
    <?php
    $relatedProducts = [];
    foreach($product->related_products as $related)
    {
        $related->images    = json_decode($related->images, true);
        $relatedProducts[] = $related;
    }
    \GoCart\Libraries\View::getInstance()->show('categories/products', ['products'=>$relatedProducts]); ?>

<?php endif;?>