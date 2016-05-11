<style type="text/css">
<!--
    table.page_header {width: 100%; border: none; background-color: #DDDDFF; border-bottom: solid 1mm #AAAADD; padding: 2mm }
    table.page_footer {width: 100%; border: none; background-color: #DDDDFF; border-top: solid 1mm #AAAADD; padding: 2mm}
    div.note {border: solid 1mm #DDDDDD;background-color: #EEEEEE; padding: 2mm; border-radius: 2mm; width: 100%; }
    ul.main { width: 95%; list-style-type: square; }
    ul.main li { padding-bottom: 2mm; }
    h1 { text-align: center; font-size: 20mm}
    h3 { text-align: center; font-size: 14mm}
	div.model{border-bottom: solid 2px #000;border-top: solid 2px #000;text-align: right; padding-bottom:5px; padding-top:5px}
-->
.header{background-color: #CCC;}
.header-th{padding-top:5px;padding-bottom:5px;}
.header-td{background-color: #ececec;}
.potencia {
    background-color: #CCC;
    width: 356px;
    padding: 0;
    height: 40px;
    font-family: Arial,Helvetica,sans-serif;
    color: #000;
}

.potencia1 {
    font-size: 14px;
    font-weight: 400;
    color: #666;
    width: 250px;
    padding-top: 6px;
    padding-left: 10px;
	float:left;
}
.potencia2 {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #000;
    padding-top: 12px;
    padding-left: 20px;
	text-align: right;
	margin-right: 10px;
}

.arial11normal {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 11px;
    font-weight: 400;
}

.img-controller{width: 720px;}

</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
	<!--
    <page_header>
        <table class="page_header">
            <tr>
                <td style="width: 50%; text-align: left">
                    Goline ...
                </td>
                <td style="width: 50%; text-align: right">
                    Infomation
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer">
            <tr>
                <td style="width: 33%; text-align: left;">
                    http://dev.gonline.com/
                </td>
                <td style="width: 34%; text-align: center">
                    page [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 33%; text-align: right">
                    &copy;Gonline 2015
                </td>
            </tr>
        </table>
    </page_footer>
	-->
    <div class="model">
		Model: <span style="font-size:20px"><b><?php echo $generators['name'];?></b></span>
	</div>
	<div style="padding-top:5px; padding-bottom:5px; border-bottom: solid 4px #000;">
	<table style="width: 100%">
		<tr style="width: 100%">
			<td style="width: 75%; text-align: left;"><span style="font-size:24px">Gonline</span> Power Systems</td>
			<td style="width: 25%; text-align: right;"><span style="margin-top:10px;">Diesel</span></td>
		</tr>
	</table>
	</div>
	<br>
	<!--
	<div class="potencia">
		<div class="potencia1">
			<span style="width:50%; text-align:left"><strong>STAND-BY POWER:</strong></span> <span style="width:50%; text-align:right"> 79 kVA </span><br>
			<span class="arial11normal">(LTP “Limited Time Power” norma ISO 8528-1)</span>
		</div>
		
	</div>	
	<div class="potencia">
		<div class="potencia1">
			<span style="width:50%; text-align:left"><strong>STAND-BY POWER:</strong></span> <span style="width:50%; text-align:right"> 79 kVA </span><br>
			<span class="arial11normal">(LTP “Limited Time Power” norma ISO 8528-1)</span>
		</div>
		
	</div>
	-->
    <p style="text-align: left; margin: 0px">Genset with manual control panel.</p>
    <div style="text-align: center">
        <img src="<?php echo base_url('themes/default/assets/img/pic_generator.png');?>" />
    </div>
	<div style="border-bottom: solid 1px #000; padding-bottom:5px;">
		<table style="width:100%">
		  <tr>
			<th width="50%">
			<div class="potencia">
				<div class="potencia1">
					<span style="width:50%; text-align:left"><strong>STAND-BY POWER:</strong></span> <span style="width:50%; text-align:right"> <?php echo round($generators['kVA_standby']) * $gen_number;?> kVA </span><br>
					<span class="arial11normal">(LTP “Limited Time Power” norma ISO 8528-1)</span>
				</div>		
			</div>
			</th>
			<th width="50%">
				<div class="potencia">
					<div class="potencia1">
						<span style="width:50%; text-align:left"><strong>PRIME POWER:</strong></span> <span style="width:50%; text-align:right">  <?php echo round($generators['kVA_prime']) * $gen_number;?> kVA</span><br>
						<span class="arial11normal">(PRP “Prime Power” norma ISO 8528-1)</span>
					</div>		
				</div>
			</th>
		  </tr>		  
		</table>
	</div>
	
	<div style="border-bottom: solid 1px #000; padding-bottom:5px; margin-top:5px">
		<table style="width:100%;">
		  <tr>			
			<th class="header" style="width:25%">ENGINE</th>
			<th class="header" style="width:25%">ALTERNATOR</th>		
			<th class="header" style="width:25%">CONTROLLER</th>
			<th class="header" style="width:25%">CANOPY</th>
			
		  </tr>
		  <tr style="border: solid 1px #999;">
			
			<td class="header-td" style="width:25%;"><?php echo $engine_manufacturer?></td>		
			<td class="header-td" style="width:25%;"><?php echo $alternator_manufacturer?></td>
			<td class="header-td" style="width:25%;"></td>
			<td class="header-td" style="width:25%;"></td>
		  </tr>
		  <tr>
			
			<td class="header-td" style="width:25%"><?php echo $eng->name;?></td>		
			<td class="header-td" style="width:25%"><?php echo $alt->name;?></td>
			<td class="header-td" style="width:25%"></td>
			<td class="header-td" style="width:25%"></td>
		  </tr>
		</table>
		<br>
		<table style="width:100%;">
		  <tr class="header">
			<th class="header-th" style="width:15%;">VOLTAGE</th>
			<th class="header-th" style="width:10%">HZ</th>
			<th class="header-th" style="width:15%">PHASE</th>		
			<th class="header-th" style="width:15%">COS Ø</th>
			<th class="header-th" style="width:25%">STAND-BY KVA/KW</th>
			<th class="header-th" style="width:20%">PRIME KVA/KW</th>
			
		  </tr>
		  <tr style="border: solid 1px #999;">
			<td class="header-td" style="width:15%;">220/380V</td>
			<td class="header-td" style="width:10%;"><?php echo $hz;?></td>
			<td class="header-td" style="width:15%;"><?php echo $phase;?></td>
			<td class="header-td" style="width:15%;">0.8</td>
			<td class="header-td" style="width:25%;"><?php echo round($generators['kVA_standby']);?> / <?php echo $engine_parameters->standby * $gen_number;?></td>
			<td class="header-td" style="width:20%;"><?php echo round($generators['kVA_prime']);?> / <?php echo $engine_parameters->prime * $gen_number;?></td>
		  </tr>
		</table>
	</div>
	<br><br>
	<div style="border-bottom: solid 1px #000; padding-bottom:5px;">
		ENGINE CHARACTERISTICS
	</div>
	<div>
		<table style="width:100%; font-size: 13px">
			<tr>
				<th class="header" style="width:50%">MAKE</th>
				<th class="header" style="width:50%">MODEl</th>
			</tr>
			<tr style="border: solid 1px #999;">
				<td class="header-td"><?php echo $engine_manufacturer?></td>
				<td class="header-td"><?php echo $eng->name;?></td>
			</tr>
		</table>
	</div>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<div style="border-bottom: solid 1px #000; padding-bottom:5px; font-size: 13px">
		GENERAL DATA
	</div>
	<div>
		<table style="width:100%; font-size: 13px">
			<!--<tr>
				<th class="header-td" style="width:50%">MAKE</th>
				<th class="header-td" style="width:50%">MODEl</th>
			</tr>-->
			<tr>
				<td class="header-td" style="width:50%">Power PRP (kWm)</td>
				<td class="header-td" style="width:50%">
					<?php if($hz==50) echo $engine_parameters->prime * $gen_number;else echo $engine_parameters->prime_2 * $gen_number?>
				</td>
			</tr>
			<tr>
				<td>Power LTP (kWm)</td>
				<td><?php if($hz==50) echo $engine_parameters->standby * $gen_number;else echo $engine_parameters->standby_2 * $gen_number?></td>
			</tr>
			<tr>
				<td class="header-td" style="width:50%">No. cylinders</td>
				<td class="header-td" style="width:50%"><?php echo $engine_parameters->cylinders_number;?></td>
			</tr>
			<tr>
				<td>Cylinder capacity (L)</td>
				<td><?php echo $engine_parameters->displacement;?></td>
			</tr>
			<tr>
				<td class="header-td">Diameter per stroke (mm)</td>
				<td class="header-td"><?php echo $engine_parameters->stroke;?></td>
			</tr>
			<tr>
				<td>Compression ratio</td>
				<td><?php echo $engine_parameters->compression_ratio;?></td>
			</tr>
			<tr>
				<td class="header-td">Injection</td>
				<td class="header-td"><?php echo $engine_parameters->type_injection;?></td>
			</tr>
			<tr>
				<td>Suction</td>
				<td></td>
			</tr>
			<tr>
				<td class="header-td">Cooling system</td>
				<td class="header-td"><?php echo $engine_parameters->type_cooled;?></td>
			</tr>
			<tr>
				<td>Fly wheel coupling</td>
				<td></td>
			</tr>
		</table>
	</div>

	<br><br>
	<div style="border-bottom: solid 1px #000; padding-bottom:5px;">
		ALTERNATOR CHARACTERISTICS
	</div>
	<div>
		<table style="width:100%; font-size: 13px">
			<tr>
				<th class="header" style="width:50%">MAKE</th>
				<th class="header" style="width:50%">MODEl</th>
			</tr>
			<tr style="border: solid 1px #999;">
				<td class="header-td"><?php echo $alternator_manufacturer?></td>
				<td class="header-td"><?php echo $alt->name;?></td>
			</tr>
		</table>
	</div>
	<br/>
	<div style="border-bottom: solid 1px #000; padding-bottom:5px; font-size: 13px">
		GENERAL DATA
	</div>

	<div>
		<table style="width:100%; font-size: 13px">
			<tr>
				<td class="header-td" style="width:50%">Power (kVA)</td>
				<td class="header-td" style="width:50%"><?php echo $engine_alternator->power * $gen_number;?></td>
			</tr>
			<tr>
				<td> Efficiency Alt. 2/4 %</td>
				<td><?php echo $engine_alternator->efficiency_3;?></td>
			</tr>
			<tr>
				<td class="header-td"> Efficiency Alt. 3/4 %</td>
				<td class="header-td"><?php echo $engine_alternator->efficiency_2;?></td>
			</tr>
			<tr>
				<td>Efficiency Alt. 4/4 %</td>
				<td><?php echo $engine_alternator->efficiency;?></td>
			</tr>
			<tr>
				<td class="header-td">No. Poles</td>
				<td class="header-td"><?php echo $engine_alternator->pole;?></td>
			</tr>
			<tr>
				<td>Voltage regulator</td>
				<td><?php if($engine_alternator->voltage_regulation!='') echo $engine_alternator->voltage_regulation;else echo 'COMPOUND TRANS';?></td>
			</tr>
			<!--
			<tr>
				<td class="header-td">No. wires</td>
				<td class="header-td"><?php echo $eng->name;?></td>
			</tr>
			-->
			<tr>
				<td class="header-td">Degree of protection</td>
				<td class="header-td"><?php if($product->protection_class!='') echo'IP'.$product->protection_class;?></td>
			</tr>
		</table>
	</div>
    <br><br>
    <div style="border-bottom: solid 1px #000; padding-bottom:5px;">
        MANUAL CONTROL PANEL
    </div>
    <div>
        <table style="width:100%; font-size: 13px">
            <tr>
                <td class="header-td" style="width:100%"><b>1.</b> STARTER SWITCH</td>
            </tr>
            <tr>
                <td><b>2.</b> EMERGENCY STOP PUSHBUTTON</td>
            </tr>
            <tr>
                <td class="header-td"><b>3.</b> MEASURING INSTRUMENTS:
                    <p style="margin: 5px 15px">▪ Analogue ammeters</p>
                    <p style="margin: 3px 15px">▪ Fuel level indicator.</p>
                    <p style="margin: 3px 15px">▪ Analogue voltmeter.</p>
                    <p style="margin: 3px 15px">▪ Digital Hz display and hour meter.</p>
                </td>
            </tr>
        </table>
    </div>
    <div><img class="img-controller" src="<?php echo base_url('themes/default/assets/img/controller-1.png')?>" /></div>
    <br><br>
	<div style="border-bottom: solid 1px #000; padding-bottom:5px;">
		Fuel Consumption
		<table style="width:100%;">
		  <tr>			
			<th class="header" style="width:33%">Percent of power</th>
			<th class="header" style="width:33%">g/kWh</th>		
			<th class="header" style="width:34%">l/hr</th>			
		  </tr>
		  <tr style="border: solid 1px #999;">
			<td>Standby power</td>
			<td><?php if($fuel['fuel_consumption']->standby_fuel_con_1 > 0) echo $fuel['fuel_consumption']->standby_fuel_con_1;?></td>
			<td><?php if($fuel['standby']['fuel_con_1']) echo round($fuel['standby']['fuel_con_1'],1) * $gen_number;?></td>
		  </tr>
		  <tr>			
			<td class="header-td">Prime power</td>		
			<td class="header-td"><?php if($fuel['fuel_consumption']->prime_fuel_con_1) echo $fuel['fuel_consumption']->prime_fuel_con_1;?></td>
			<td class="header-td"><?php if($fuel['standby']['fuel_con_1']) echo round($fuel['prime']['fuel_con_1'],1) * $gen_number;?></td>
		  </tr>
		  <tr style="border: solid 1px #999;">
			<td>75%</td>
			<td><?php if($fuel['fuel_consumption']->prime_fuel_con_2) echo $fuel['fuel_consumption']->prime_fuel_con_2;?></td>
			<td><?php if($fuel['prime']['fuel_con_2']) echo round($fuel['prime']['fuel_con_2'],1) * $gen_number;?></td>
		  </tr>
		  <tr style="border: solid 1px #999;">
			<td class="header-td">50%</td>		
			<td class="header-td"><?php if($fuel['fuel_consumption']->prime_fuel_con_3) echo $fuel['fuel_consumption']->prime_fuel_con_3;?></td>
			<td class="header-td"><?php if($fuel['prime']['fuel_con_3']) echo round($fuel['prime']['fuel_con_3'],1) * $gen_number;?></td>
		  </tr>
	</table>
	</div>
	
</page>