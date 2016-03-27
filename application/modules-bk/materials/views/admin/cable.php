<?php pageHeader('Cable'); // ong khoi?>

<script type="text/javascript">
    var BASE_URL = '<?php echo base_url();?>';
    function areyousure()
    {
        return confirm('Are you sure you want to delete this item?');
    }
    function update(id)
    {
        var url 		= BASE_URL + 'admin/materials/form/cable/' + id;
        var kVA 		= $("#kVA_"+id).val();
        var ampe 	    = $("#ampe_"+id).val();
        var section     = $("#section_"+id).val();
        var trademark 	= $("#trademark_"+id).val();
        var symbol 	    = $("#symbol_"+id).val();
        var unit 	    = $("#unit_"+id).val();
        var value 		= $("#value_"+id).val();
        var description = $("#description_"+id).val();
        var note 		= $("#note_"+id).val();
        $.post(
            url,
            { kVA: kVA, ampe: ampe, section: section, trademark: trademark, symbol: symbol, unit: unit, value: value, description: description, note: note}
        );
        alert('Item updated.');
    }
</script>
<table class="table table-striped">
    <thead>
    <tr>
        <th>kVA</th>
        <th>Ampe</th>
        <th>Section</th>
        <th>trademark</th>
        <th>Symbol</th>
        <th>Unit</th>
        <th>Value</th>
        <th>Description</th>
        <th>Note</th>
        <th style="width:10%">
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php echo form_open('admin/materials/form/cable/', array('id'=>'save_form'));?>
        <td><input type="text" name="kVA" value="" class="form-control tableInput"></td>
        <td><input type="text" name="ampe" value="" class="form-control tableInput"></td>
        <td><input type="text" name="section" value="" class="form-control tableInput"></td>
        <td><input type="text" name="trademark" value="" class="form-control tableInput"></td>
        <td><input type="text" name="symbol" value="" class="form-control tableInput"></td>
        <td><input type="text" name="unit" value="" class="form-control tableInput"></td>
        <td><input type="text" name="value" value="" class="form-control tableInput"></td>
        <td><input type="text" name="description" value="" class="form-control tableInput"  style="max-width:100%"></td>
        <td><input type="text" name="note" value="" class="form-control tableInput"></td>
        <td class="text-right">
            <button type="submit" class="btn btn-default"><i class="icon-plus"></i></button>
        </td>
        </form>
    </tr>
    <?php foreach ($results as $result):?>
        <tr>
            <td><input id="kVA_<?php echo $result->id;?>" type="text" name="kVA" value="<?php echo $result->kVA?>" class="form-control tableInput"></td>
            <td><input id="ampe_<?php echo $result->id;?>" type="text" name="ampe" value="<?php echo $result->ampe?>" class="form-control tableInput"></td>
            <td><input id="section_<?php echo $result->id;?>" type="text" name="section" value="<?php echo $result->section?>" class="form-control tableInput"></td>
            <td><input id="trademark_<?php echo $result->id;?>" type="text" name="trademark" value="<?php echo $result->trademark?>" class="form-control tableInput"></td>
            <td><input id="symbol_<?php echo $result->id;?>" type="text" name="symbol" value="<?php echo $result->symbol?>" class="form-control tableInput"></td>
            <td><input id="unit_<?php echo $result->id;?>" type="text" name="unit" value="<?php echo $result->unit?>" class="form-control tableInput"></td>
            <td><input id="value_<?php echo $result->id;?>" type="text" name="value" value="<?php echo $result->value?>" class="form-control tableInput"></td>
            <td><input id="description_<?php echo $result->id;?>" type="text" name="description" value="<?php echo $result->description?>" class="form-control tableInput"  style="max-width:100%"></td>
            <td><input id="note_<?php echo $result->id;?>" type="text" name="note" value="<?php echo $result->note?>" class="form-control tableInput"></td>
            <td class="text-right">
                <div class="btn-group">
                    <a class="btn btn-default" onclick="update(<?php echo $result->id?>);" >
                        <i class="icon-save"></i>
                    </a>
                    <a class="btn btn-danger" href="<?php echo site_url('admin/materials/delete/cable/'.$result->id);?>" onclick="return areyousure();" alt="<?php echo lang('delete');?>">
                        <i class="icon-times "></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>