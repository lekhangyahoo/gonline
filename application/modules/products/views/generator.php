<style type="text/css">
.download-document {
    padding: 10px 0;
    border-bottom: 1px solid #C5C5C5;
	width: 75%;
}
.last{border:none}
.clear-left{clear:left}
.col-set-up-left{float:left; min-width:200px}
.col-set-up-right{float:left;}
.set-up-input{height: 30px;width: 120px !important;border-radius: 5px !important;display: initial !important; padding: 0.25em 1em 0.25em !important;}
.about-help{cursor: pointer; border-bottom: 1px dotted #BB0F1D;text-decoration: none;}
.about-help:hover{text-decoration: none !important;}
</style>

<script>
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover({
			html:true,
			trigger: 'hover',
			placement : 'top'
		});
	});
</script>
<div class="page-header">
    <h2>GENERATOR Model <?php echo $generators['name'];?></h2>
	<div><?php echo round($generators['kVA_standby']);?> kVA, <?php echo $engine_manufacturer?> Engine, <?php echo $hz;?> Hz - <?php if($phase==1) echo 'Single-phase';else echo 'Three-phase'?> - <?php echo $alternator_manufacturer?> Alternator </div>
	
</div>

<div class="col-nest">
    <div class="col" data-cols="2/5" data-medium-cols="2/5">
        <div class="productImg"><?php
        $photo = theme_img('pic_generator.png', 'image-generator');

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
					  Make: <strong><?php echo $alternator_manufacturer?></strong>
					  <br>
					  Model: <strong><?php echo $alt->name;?></strong>
					</p>
					<p><strong><span class="verde">CONTROLLER</span></strong><br>
					  Model: <strong>Decision - Maker</strong></p>
					<p><strong><span class="verde">CANOPY</span></strong> &nbsp;&nbsp;
						<select class="set-up-input change-canopy" name="change-canopy">
							<option value="1"> Standard </option>
							<option value="2"> No canopy </option>
						</select>
					</p>

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
                    <a style="margin-left:40px" id="show-compare" <?php if(!\CI::session()->userdata('compare')) echo 'style="display: none" ';?>class="boton-enviar-ficha" href="<?php echo site_url('product/compare/1'); ?>" target="_blank">Show compare</a>

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

			<hr/>
			
			<form id="calculate_setup" >
			<div>
				<div class="page-header">
					<p><b>DU TOAN CHI PHI LAP DAT VA VAN CHUYEN</b></p>
				</div>
				<div class="part-set-up bon-dau">
					<div class="col-set-up-left"> <strong><span class="verde">BON DAU: </span></strong></div>
					<div class="col-set-up-right"> <input class="set-up-check" type="checkbox" id="bon-dau" data-theid="bon-dau" name="bon_dau"></div>
					
					<div class="bon-dau-content clear-left" style="display:none">
						<div class="clear-left">
							<div class="col-set-up-left">Dung tich binh</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="dung-tich-bon-dau" name="dung_tich_bon_dau" value="5000" > (l) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Duong kinh</div>
							<div class="col-set-up-right"> <input class="set-up-input" type="text" id="duong-kinh-bon-dau" name="duong_kinh_bon_dau" value="2" > (m) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Do day cua thep</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="do-day-bon-dau" name="do_day_bon_dau" value="3"> (mm)</div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Ong dau (chieu di chieu ve)</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="do-dai-ong-dau" name="do_dai_ong_dau" value="50"> (m)</div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Tu bom</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="so-luong-tu-bom" name="so_luong_tu_bom" value="1"> (cai)</div>
						</div>
					</div>
					
				</div>
				
				<div class="clear-left" style="border-top:1px solid #ccc; padding-top: 20px;">
					<div class="col-set-up-left"> <strong><span class="verde">VAT TU: </span></strong></div>
					<div class="col-set-up-right"> <input class="set-up-check" type="checkbox" id="vat-tu" data-theid="vat-tu" name="vat_tu"></div>
					
					<div class="vat-tu-content clear-left" style="display:none">
						<div class="clear-left">
							<div class="col-set-up-left">Do dai ong khoi</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="do-dai-ong-khoi" name="do_dai_ong_khoi" value="15" > (m) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Chat lieu ong khoi</div>
							<div class="col-set-up-right">
								<div class="col-set-up-right">
									<select class="set-up-input" name="chat_lieu_ong_khoi">
										<option value="1"> Thep </option>
										<option value="2"> Inox </option>
									</select>
								</div>
							</div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Do day ong khoi</div>
							<div class="col-set-up-right">
								<select class="set-up-input" name="do_day_ong_khoi">
									<option value="2"> 2 mm </option>
									<option value="3"> 3 mm </option>
								</select>
							</div>
						</div>
						
						<div class="clear-left">
							<div class="col-set-up-left">Sua dung Rockwool</div>
							<div class="col-set-up-right"><input type="checkbox" id="rockwool" data-theid="rockwool" value="1" name="rockwool" checked></div>
						</div>
						
						<div class="clear-left">
							<div class="col-set-up-left">Khoang cach tu may den nguon </div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="do-dai-day-cap" name="do_dai_day_cap"value="15" > (m) </div>
						</div>
						
					</div>
					
				</div>
				
				<div class="clear-left" style="border-top:1px solid #ccc; padding-top: 20px;">
					<div class="col-set-up-left"> <strong><span class="verde">VAN CHUYEN: </span></strong></div>
					<div class="col-set-up-right"> <input class="set-up-check" type="checkbox" id="van-chuyen" data-theid="van-chuyen" name="van_chuyen"></div>
					<div class="van-chuyen-content clear-left" style="display:none">
						<div class="clear-left">
							<div class="">Please enter address your company</div>
						</div>

						<div class="clear-left">
							<div class="col-set-up-left">Tinh</div>
							<div class="col-set-up-right">
								<select class="set-up-input" name="province">
									<option value="2"> HCM City </option>
									<option value="3"> Ha Noi </option>
								</select>
							</div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Huyen</div>
							<div class="col-set-up-right">
								<select class="set-up-input" name="district">
									<option value="2"> Quan 1 </option>
									<option value="3"> Quan 2 </option>
								</select>
							</div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Dia chi nha</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="bon_dau" value="" style="border-radius: 5px; height: 30px;width: 100% !important"></div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Van chuyen lien tinh</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="bon_dau" value="5000" > (l) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Van chuyen tai cau</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" id="bon_dau" value="5000" > (l) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Van chuyen thu cong <a class="about-help" data-toggle="popover" title="About an chuyen thu cong" data-content="Len doi.<br> Xuong ruong."> (?) </a></div>
							<div class="col-set-up-right"> <input class="set-up-input" type="text" id="bon_dau" value="2" ></div>
						</div>

					</div>
				</div>
				
				<div class="clear-left" style="border-top:1px solid #ccc;padding-top: 20px;">
					<div class="col-set-up-left"> <strong><span class="verde">NHAN CONG:</span></strong></div>
					<div class="col-set-up-right"> <input class="set-up-check" type="checkbox" name="nhan_cong" id="nhan-cong" data-theid="nhan-cong"></div>
					
					<div class="nhan-cong-content clear-left" style="display:none">
						<div class="clear-left">
							<div class="col-set-up-left">Thao ra vo cach am</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="nc_thao_ra_vo" value="0" > (lan) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Day vao vi tri don gian <a class="about-help" data-toggle="popover" title="About day vao vi tri don gian" data-content="Vi tri don gian."> (?) </a></div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="nc_day_vao_vi_tri_dg" value="0" > (lan) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Day vao vi tri phuc tap <a class="about-help" data-toggle="popover" title="About day vao vi tri phuc tap" data-content="Len doi.<br> Xuong ruong."> (?) </a></div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="nc_day_vao_vi_tri_pt" value="0" > (lan) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Lap dat may phat dien</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="nc_lap_may" value="1" > (may) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Lap dat tu ats</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="nc_lap_dat_ats" value="1"> (may)</div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Lap tu hoa</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="nc_lap_tu_hoa"value="1"> (may)</div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">HD su dung va nghiem thu</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="nc_hd_sudung_nt" value="1"> (lan)</div>
						</div>
					</div>
				</div>
				
				<div class="clear-left" style="border-top:1px solid #ccc;padding-top: 20px;">
					<div class="col-set-up-left"> <strong><span class="verde">KIEM DINH: </span></strong></div>
					<div class="col-set-up-right"> <input class="set-up-check" type="checkbox" name="kiem_dinh" id="kiem-dinh" data-theid="kiem-dinh"></div>
					
					<div class="kiem-dinh-content clear-left" style="display:none">
						<div class="clear-left">
							<div class="col-set-up-left">KĐ CL Vinacontrol</div>
							<div class="col-set-up-right"><input class="set-up-input" name="kd_chat_luong" type="text" id="kd-chat-luong" value="1" > (SL máy) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">KĐ Công suất TT 3</div>
							<div class="col-set-up-right"><input class="set-up-input" type="text" name="kd_tt3" id="kd-tt3" value="1" > (SL giấy) </div>
						</div>
						<div class="clear-left">
							<div class="col-set-up-left">Thu tai gia</div>
							<div class="col-set-up-right"> <input class="set-up-input" type="text" name="thu_tai_gia" id="thu-tai-gia" value="1"> (SL máy)</div>
						</div>
					</div>
				</div>
								
				<div  class="clear-left" style="border-top:1px solid #ccc;padding-top: 20px;">
					<p> <strong><span class="verde">TONG GIA CHI PHI LAP DAT VAN CHUYEN (truoc thue): </span></strong> <b><span class="total-price"></span></b> </p>
                    <p> <a style="display:none" class="btn show-price-detail" data-toggle="modal" data-target="#price-detail" >View price detail<a> </p>
				</div>
			
			
			</div>
			<input type="hidden" name="kVA" value="<?php echo round($generators['kVA_standby']);?>">
			<input type="hidden" name="generator_number" value="1">
			<input type="hidden" name="phase" value="<?php echo $phase;?>">
			<input type="hidden" name="generator" value="<?php echo uri_string();?>">
			
			</form>			

		</div>
	
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="price-detail" role="dialog">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Price detail</h3>
            </div>
            <div class="modal-body arial13">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>VAT TU</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>
                            Ống thoát khói va cong lắp
                        </td>
                        <td class="text-right price ong-thoat-khoi-cong-lap"></td>
                    </tr>
                    <tr>
                        <td>
                            Ống nhún với đoạn ống đi xuyên tường và nón che mưa
                        </td>
                        <td class="text-right price ong-nhun-non-che"></td>
                    </tr>
                    <tr>
                        <td>
                            Hộp thoát nhiệt, lam gió va cong lắp
                        </td>
                        <td class="text-right price hop-thoat-nhiet-lam-gio"></td>
                    </tr>
                    <tr>
                        <td>
                            Cáp động lực va cong lắp
                        </td>
                        <td class="text-right price cap-dong-luc-cong-lap"></td>
                    </tr>
                    <tr>
                        <td>
                            Cáp te
                        </td>
                        <td class="text-right price cap-te"></td>
                    </tr>
                    <tr>
                        <td>
                            Cáp điều khiển
                        </td>
                        <td class="text-right price cap-dieu-khien"></td>
                    </tr>
                    <tr>
                        <td>
                            Bảo vệ cáp
                        </td>
                        <td class="text-right price cap-bao-ve"></td>
                    </tr>
                    <tr>
                        <td>
                            Nhiên liệu chạy nghiệm thu
                        </td>
                        <td class="text-right price nhien-lieu-nt"></td>
                    </tr>
                    <tr>
                        <td>
                            Vật tư phụ
                        </td>
                        <td class="text-right price vat-tu-phu"></td>
                    </tr>
                    </tbody>
                </table>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>NHAN CONG</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>
                            Tháo rã vỏ cách âm
                        </td>
                        <td class="text-right price thao-ra-vo"></td>
                    </tr>
                    <tr>
                        <td>
                            Đẩy vào vị trí don gian
                        </td>
                        <td class="text-right price day-vao-vi-tri-dg"></td>
                    </tr>
                    <tr>
                        <td>
                            Đẩy vào vị trí phuc tap
                        </td>
                        <td class="text-right price day-vao-vi-tri-pt"></td>
                    </tr>
                    <tr>
                        <td>
                            Nhan cong lap may phat dien
                        </td>
                        <td class="text-right price nc-lap-may"></td>
                    </tr>
                    <tr>
                        <td>
                            Nhan cong lap tu ATS
                        </td>
                        <td class="text-right price nc-lap-tu-ats"></td>
                    </tr>
                    <tr>
                        <td>
                            Nhan cong lap tu hoa
                        </td>
                        <td class="text-right price nc-lap-tu-hoa"></td>
                    </tr>
                    <tr>
                        <td>
                            Hướng dẫn sử dụng và nghiệm thu
                        </td>
                        <td class="text-right price nc-hd-nt"></td>
                    </tr>

                    </tbody>
                </table>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>KIEM DINH</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>
                            Giám định chất lượng, XX Vinacontrol
                        </td>
                        <td class="text-right price kd-cl"></td>
                    </tr>
                    <tr>
                        <td>
                            Giám định công suất Trung Tâm 3
                        </td>
                        <td class="text-right price kd-tt3"></td>
                    </tr>
                    <tr>
                        <td>
                            Thử tải giả
                        </td>
                        <td class="text-right price thu-tai-gia"></td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<script>
	function calculate_setup(){
		var form_data = $("#calculate_setup").serialize();
		$.ajax({
			method: "POST",
			url: "<?php echo site_url('product/calculate_setup/1');?>",
			data: form_data
		}).done(function( data ) {
			if(data) {
				var value = $.parseJSON(data);
				$(".total-price").html(value.total_price);
                if(value.total_money > 0){
                    $(".show-price-detail").show();
                    show_content_price_detail(value);
                }else{
                    $(".show-price-detail").hide();
                }
			}
		});
	}

    function show_content_price_detail(value){
        $(".ong-thoat-khoi-cong-lap").html(value.gia_ong_khoi_price);
        $(".ong-nhun-non-che").html(value.gia_ong_nhung_non_che_price);
        $(".hop-thoat-nhiet-lam-gio").html(value.gia_ong_khoi_price);
        $(".cap-dong-luc-cong-lap").html(value.gia_cap_dong_luc_price);
        $(".cap-te").html(value.gia_cap_te_price);
        $(".cap-dieu-khien").html(value.gia_cap_dieu_khien_price);
        $(".cap-bao-ve").html(value.gia_bao_ve_cap_price);
        $(".nhien-lieu-nt").html(value.gia_nhien_lieu_chay_nt_price);
        $(".vat-tu-phu").html(value.gia_vat_tu_phu_price);

        $(".thao-ra-vo").html(value.gia_thao_ra_vo_price);
        $(".day-vao-vi-tri-dg").html(value.gia_day_vao_vi_tri_dg_price);
        $(".day-vao-vi-tri-pt").html(value.gia_day_vao_vi_tri_pt_price);
        $(".nc-lap-may").html(value.gia_lap_may_price);
        $(".nc-lap-tu-ats").html(value.gia_lap_dat_ats_price);
        $(".nc-lap-tu-hoa").html(value.gia_lap_tu_hoa_price);
        $(".nc-hd-nt").html(value.gia_hd_sd_nt_price);

        $(".kd-cl").html(value.gia_kd_cl_price);
        $(".kd-tt3").html(value.gia_kd_tt3_price);
        $(".thu-tai-gia").html(value.gia_thu_tai_gia_price);
    }
    $("#calculate_setup input, #calculate_setup select").change(function(){
        calculate_setup();
    });


	$('.change-canopy').change(function() {
		var url_img = "<?php echo site_url().'themes/default/assets/img/';?>";
		if ($(this).val() == 1) {
			url_img = url_img + 'pic_generator.png';
		}
		if ($(this).val() == 2) {
			url_img = url_img + 'pic_generator_no_canopy.jpg';
		}
		url_img = '<img src="'+url_img+'" alt="image-generator">';
		$(".productImg").html(url_img);
		//alert($(this).val());
	});

	$( ".set-up-check" ).click(function(){
		//$( "."+$(this).data('theid')+"-content" ).toggle(400);
		$( "."+$(this).data('theid')+"-content" ).animate({height: 'toggle'});

	});

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