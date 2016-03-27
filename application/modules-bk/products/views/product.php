<div class="page-header">
    <h1><?php echo $product->name;?></h1>
    <div><?php echo $get_parameters_of_product['manufacturer']->name?> <?php echo $get_parameters_of_product['category']->name?></div>
</div>

<div class="col-nest">
    <div class="col" data-cols="2/5" data-medium-cols="2/5">
        <div class="productImg">
            <!--<img src="http://dev.gonline.com/themes/default/assets/img/pic_generator.png" alt="No Image Available">-->
            <?php
            if($product->primary_category==1)
                $photo = theme_img('pic_generator.png', lang('no_image_available'));
            if($product->primary_category==2)
                $photo = theme_img('pic_alternator.png', lang('no_image_available'));

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
            echo $photo;
            ?>
        </div>

        <?php if($documents){?>
        <div>
            <div class="page-header"><b>Technical Document Downloads</b></div>
            <?php foreach($documents as $document){?>
                <div class="download-document last">
                    <img src="<?php echo base_url('assets/img')?>/label-pdf.gif" width="20" height="9" alt="PDF" border="0">
                    <a target="_blank" href="<?php echo base_url('uploads/documents/'.$document->file_name)?>"><?php echo $document->display_name;?></a> <?php echo $document->size;?> Kb
                </div>
            <?php }?>
        </div>
        <?php }?>

    </div>


    <div class="col pull-right" style="padding: 0px 25px;" data-cols="3/5" data-medium-cols="3/5">
        <div id="productAlerts"></div>
        <div class="productPrice">
            <?php if($product->saleprice > 0):?>
                <small class="sale"><?php echo lang('on_sale');?></small>
                <?php echo format_currency($product->saleprice);?>
            <?php else:?>
                <?php echo format_currency($product->price);?>
            <?php endif;?>
        </div>
        <div class="productDetails">

            <div class="productDescription">
                <div id="textos">
                    <p><strong><span class="verde" style="text-transform: uppercase;"><?php echo $get_parameters_of_product['category']->name?></span></strong><br>
                        Make: <strong><?php echo $get_parameters_of_product['manufacturer']->name?></strong><br>
                        Model: <strong><?php echo $product->name?></strong>
                    </p>
                </div>

                <?php if($product->primary_category == 1){ $category_parameters = $get_parameters_of_product['category_parameters'];?>
                    <?php if($category_parameters->rpm !=''){?>
                        <h3>RPM: <?php echo $category_parameters->rpm?></h3>
                        <div class="potencia"><div class="potencia1"><strong>STAND-BY POWER:</strong><br>
                                <span class="arial11normal">(LTP "Limited Time Power" norma ISO 8528-1)</span></div>
                            <div class="potencia2"><?php echo $category_parameters->standby?> kWm</div>
                        </div>
                        <div style="clear: both;"></div>
                        <div style="clear: both; height:5px;"></div>
                        <div class="potencia">
                            <div class="potencia1">
                                <strong>PRIME POWER:</strong><br>
                                <span class="arial11normal">(PRP "Prime Power" norma ISO 8528-1)</span>
                            </div>
                            <div class="potencia2"><?php echo $category_parameters->prime?> kWm</div>
                        </div>
                    <?php }?>

                    <?php if($category_parameters->rpm_2 !=''){?>
                        <h3>RPM: <?php echo $category_parameters->rpm_2?></h3>
                        <div class="potencia"><div class="potencia1"><strong>STAND-BY POWER:</strong><br>
                                <span class="arial11normal">(LTP "Limited Time Power" norma ISO 8528-1)</span></div>
                            <div class="potencia2"><?php echo $category_parameters->standby_2?> kWm</div>
                        </div>
                        <div style="clear: both;"></div>
                        <div style="clear: both; height:5px;"></div>
                        <div class="potencia">
                            <div class="potencia1">
                                <strong>PRIME POWER:</strong><br>
                                <span class="arial11normal">(PRP "Prime Power" norma ISO 8528-1)</span>
                            </div>
                            <div class="potencia2"><?php echo $category_parameters->prime_2?> kWm</div>
                        </div>
                    <?php }?>
                <?php }?>

                <?php if($product->primary_category == 2){ $category_parameters = $get_parameters_of_product['category_parameters'];?>

                    <div class="potencia" style="height:30px">
                        <div class="potencia1"><strong><?php echo $category_parameters->hz?> Hz, CONTINUOUS POWER:</strong></div>
                        <div class="potencia2" style="padding-top: 3px;"><?php echo $category_parameters->power?> kAV</div>
                    </div>
                    <div style="clear: both; height:5px;"></div>

                    <?php $category_parameters = $get_parameters_of_product['category_parameters_hz_60'];?>

                    <div class="potencia" style="height:30px">
                        <div class="potencia1"><strong><?php echo $category_parameters->hz?> Hz, CONTINUOUS POWER:</strong></div>
                        <div class="potencia2" style="padding-top: 3px;"><?php echo $category_parameters->power?> kAV</div>
                    </div>
                    <div style="clear: both;"></div>
                <?php }?>

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

            <!--
            <div class="potencia4" style="height:40px;margin-top:15px;">
                <p class="arial14">Compare &nbsp; <input type="checkbox" id="check_compare" value="1"></p>
            </div>
            -->

            <!--
            <form action="http://dev.gonline.com/cart/add-to-cart" id="add-to-cart" method="post" accept-charset="utf-8">
            <input type="hidden" name="cartkey" value="" />
            <input type="hidden" name="id" value="1"/>

            <div class="text-left">
                <button class="blue" type="button" value="submit" onclick="addToCart($(this));"><i class="icon-cart"></i> Add to Cart</button>
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