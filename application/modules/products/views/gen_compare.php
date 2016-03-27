<div class="izquierda2"><span class="verde18">COMPARE GENERATORS</span></div>
<div class="mobile-gen">
  <table class="table" style="font-size:12px">
    <thead>
      <tr>
        <th style="min-width:130px" class="border-right">MODEL</th>
        <th class="border-right">R.P.M</th>
        <th class="border-right">CONTIN. PRP</th>
		<th class="border-right">STAND-BY LTP</th>
		<th class="border-right">PRICE</th>
		<th>ACTION</th>
      </tr>
    </thead>
    <tbody>
		<?php $image_compare = array('default-compare-1.JPG','default-compare-2.JPG','default-compare-3.JPG','default-compare-4.JPG');?>
		<?php foreach($compare as $key=>$gen){ $index_ima = $key%4;//$index_ima = rand(0, 3);?>
		<tr class="compare_<?php echo $key;?> <?php if($key % 2 == 1) echo 'line2';else echo 'line1'?>">
			<td class="image-gen border-right">
				<a href="<?php echo site_url($gen['uri_string_compare']);?>" target="_self">
                    <img src="<?php echo base_url('themes/default/assets/img/'.$image_compare[$index_ima])?>" width="81" height="59" border="0" align="left">
                    <br>
                    <?php echo $gen['result']['generators']['name'];?>
                </a>
			</td>
			<td align="center" class="border-right">
				<?php echo $gen['result']['engine_parameters']->rpm;?>
			</td>
			<td class="border-right">
				<?php echo round($gen['result']['generators']['kVA_prime']);?>
			</td>
			<td class="border-right">
				<?php echo round($gen['result']['generators']['kVA_standby']);?>
			</td>
			<td class="border-right">
				<?php echo format_currency($gen['result']['generators']['price']);?>
			</td>
			<td>
				<input name="Enviar" type="submit" onclick="remove_compare('<?php echo $key;?>','<?php echo $gen['uri_string_compare'];?>')" class="boton-enviar-ficha" value="Remove">
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
            <div class="cabecera31"> POWER (kVA) </div>
            <div class="cabecera32">CONTIN. PRP</div>
            <div class="cabecera32">STAND-BY LTP</div>
            <!--<div class="cabecera33">kVA</div>
            <div class="cabecera33">kW</div>
            <div class="cabecera33">kVA</div>
            <div class="cabecera33">kW</div>-->
        </div>
        <div class="cabecera4"><p>ENGINE</p></div>
        <div class="cabecera41"><p>ALTERNATOR</p></div>
        <div class="cabecera5"><p>PRICE</p>
        </div>
        <div class="cabecera6">
            <p>DELIVERY<br>
            </p></div>

        <div class="cabecera7">
            <p>DOWNLOADS<br>
            </p></div>
        <div class="cabecera8">
            <p>ACTION<br>
            </p></div>
        <br>
    </div>

    <?php $image_compare = array('default-compare-1.JPG','default-compare-2.JPG','default-compare-3.JPG','default-compare-4.JPG');?>
    <?php foreach($compare as $key=>$gen){ $index_ima = $key%4;//$index_ima = rand(0, 3);?>
        <?php if($key%2==1){ $line2 = ' line2'; }else {$line2='';}?>
        <div class="cojeresultados compare_<?php echo $key;?>" id="compare_<?php echo $key;?>">
            <div class="resultado1">
                <a href="<?php echo site_url($gen['uri_string_compare']);?>" target="_self">
                    <img src="<?php echo base_url('themes/default/assets/img/'.$image_compare[$index_ima])?>" width="81" height="59" hspace="15" border="0" align="left">
                    <br>
                    <?php echo $gen['result']['generators']['name'];?>
                </a>
            </div>
            <div class="resultado2 <?php echo $line2?>">
                <p class="marginTop20">
                    <?php echo $gen['result']['engine_parameters']->rpm;?>
                </p>
            </div>
            <div class="resultado3 <?php echo $line2?>">
                <p class="marginTop20"><?php echo round($gen['result']['generators']['kVA_prime']);?></p>
            </div>

            <!--
            <div class="resultado3 <?php echo $line2?>">
                <p class="marginTop20"><?php echo $gen['result']['engine_parameters']->prime;?></p>
            </div>
            -->
            <div class="resultado3 <?php echo $line2?>">
                <p class="marginTop20"><?php echo round($gen['result']['generators']['kVA_standby']);?></p>
            </div>
            <!--
            <div class="resultado3 <?php echo $line2?>">
                <p class="marginTop20"><?php echo $gen['result']['engine_parameters']->standby;?></p>
            </div>
            -->

            <div class="resultado4 <?php echo $line2?>">
                <p class="marginTop15">
                    <?php echo $gen['result']['engine_manufacturer'];?><br>
                    <?php echo $gen['result']['eng']->name;?>
                </p>
            </div>
            <div class="resultado41 <?php echo $line2?>">
                <p class="marginTop15">
                    <?php echo $gen['result']['alternator_manufacturer']?><br>
                    <?php echo $gen['result']['alt']->name;?>
                </p>
            </div>
            <div class="resultado5 <?php echo $line2?>"><p class="marginTop20"><?php echo format_currency($gen['result']['generators']['price']);?></p></div>
            <div class="resultado6 <?php echo $line2?>">
                <p class="marginTop20"><?php echo $gen['result']['generators']['days'];?> days</p>
            </div>
            <div class="resultado7 <?php echo $line2?>">
                <?php $url_document = str_replace('/generator/','/documents/',$gen['uri_string_compare'])?>
                <a target="_blank" href="<?php echo base_url($url_document)?>">
                    <p class="marginTop20"><img src="<?php echo base_url('assets/img/pdf.png');?>" width="121" height="25" ></p>
                </a>
            </div>
            <div class="resultado8 <?php echo $line2?>">
                <p class="marginTop20">
                    <input name="Enviar" type="submit" onclick="remove_compare('<?php echo $key;?>','<?php echo $gen['uri_string_compare'];?>')" class="boton-enviar-ficha" value="Remove">&nbsp;
                    <input name="Enviar" type="submit" onclick="form_send_email()" class="boton-enviar-ficha" value="Contact">
                </p>
            </div>
        </div>
    <?php }?>

</div>
<script>
    function remove_compare(id, url) {
        var compare_ = ".compare_"+id;
        $(compare_).hide();
        $.ajax({
            method: "POST",
            url: "<?php echo site_url('product/remove_compare/1');?>",
            data: {url: url}
        }).done(function (msg) {
            //alert("Data Saved: " + msg);
        });
    }
</script>