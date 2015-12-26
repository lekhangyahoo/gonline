<style>
.download-document {
    padding: 10px 0;
    border-bottom: 1px solid #C5C5C5;
	width: 75%;
}
.last{border:none}
</style>
<div class="page-header">
    <h1><?php echo $generators['name'];?></h1>
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
				<a href="<?php echo base_url('uploads/documents')?>/3_PS-DB58-B.pdf">Spec. Sheet - <?php echo $generators['name'];?>.pdf</a>
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
				<!--<div>Provides advanced control, system monitoring, and system diagnostics
with remote monitoring capabilities.</div>-->
				<div>- Digital display and keypad provide easy local data access</div>
				<div>- Measurements a re selectable in metric o r English units</div>
            </div>
			
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

        </div>		

    </div>
</div>


<script>

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