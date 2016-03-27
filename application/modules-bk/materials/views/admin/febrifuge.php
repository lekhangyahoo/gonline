<?php pageHeader('Febrifuge'); // thoat nhiet?>

<script type="text/javascript">
    var BASE_URL = '<?php echo base_url();?>';
    function areyousure()
    {
        return confirm('Are you sure you want to delete this item?');
    }
    function update(id)
    {
        var url 		= BASE_URL + 'admin/materials/form/febrifuge/' + id;
        var kVA 		= $("#kVA_"+id).val();
        var width 		= $("#width_"+id).val();
        var height      = $("#height_"+id).val();
        var value_vtp 	= $("#value_vtp_"+id).val();
        var note 		= $("#note_"+id).val();
        $.post(
            url,
            { kVA: kVA, width: width, height: height, value_vtp: value_vtp, note: note}
        );
        alert('Item updated.');
    }
</script>
<table class="table table-striped">
    <thead>
    <tr>
        <th>kVA</th>
        <th>Width</th>
        <th>Height</th>
        <th>Value accessories</th>
        <th>Note</th>
        <th style="width:10%">
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php echo form_open('admin/materials/form/febrifuge/', array('id'=>'save_form'));?>
        <td><input type="text" name="kVA" value="" class="form-control tableInput"></td>
        <td><input type="text" name="width" value="" class="form-control tableInput"></td>
        <td><input type="text" name="height" value="" class="form-control tableInput"></td>
        <td><input type="text" name="value_vtp" value="10000" class="form-control tableInput"></td>
        <td><input type="text" name="note" value="" class="form-control tableInput" style="max-width:100%"></td>
        <td class="text-right">
            <button type="submit" class="btn btn-default"><i class="icon-plus"></i></button>
        </td>
        </form>
    </tr>
    <?php foreach ($results as $result):?>
        <tr>
            <td><input id="kVA_<?php echo $result->id;?>" type="text" name="kVA" value="<?php echo $result->kVA?>" class="form-control tableInput"></td>
            <td><input id="width_<?php echo $result->id;?>" type="text" name="width" value="<?php echo $result->width?>" class="form-control tableInput"></td>
            <td><input id="height_<?php echo $result->id;?>" type="text" name="height" value="<?php echo $result->height?>" class="form-control tableInput" style="max-width:100%"></td>
            <td><input id="value_vtp_<?php echo $result->id;?>" type="text" name="value_vtp" value="<?php echo $result->value_vtp?>" class="form-control tableInput"></td>
            <td><input id="note_<?php echo $result->id;?>" type="text" name="note" value="<?php echo $result->note?>" class="form-control tableInput" style="max-width:100%"></td>
            <td class="text-right">
                <div class="btn-group">
                    <a class="btn btn-default" onclick="update(<?php echo $result->id?>);" >
                        <i class="icon-save"></i>
                    </a>
                    <a class="btn btn-danger" href="<?php echo site_url('admin/materials/delete/febrifuge/'.$result->id);?>" onclick="return areyousure();" alt="<?php echo lang('delete');?>">
                        <i class="icon-times "></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>