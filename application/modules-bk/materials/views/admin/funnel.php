<?php pageHeader('Funnel'); // ong khoi?>

<script type="text/javascript">
    var BASE_URL = '<?php echo base_url();?>';
    function areyousure()
    {
        return confirm('Are you sure you want to delete this item?');
    }
    function update(id)
    {
        var url 		= BASE_URL + 'admin/materials/form/funnel/' + id;
        var phi 		= $("#phi_"+id).val();
        var value_mabi 	= $("#value_mabi_"+id).val();
        var value_coha  = $("#value_coha_"+id).val();
        var value_vtp 	= $("#value_vtp_"+id).val();
        var value_noch 	= $("#value_noch_"+id).val();
        var value_onnh 	= $("#value_onnh_"+id).val();
        var description = $("#description_"+id).val();
        var group 		= $("#group_"+id).val();
        var note 		= $("#note_"+id).val();
        $.post(
            url,
            { phi: phi, value_mabi: value_mabi, value_coha: value_coha, value_vtp: value_vtp, value_noch: value_noch, value_onnh: value_onnh, description: description, note: note, group: group}
        );
        alert('Item updated.');
    }
</script>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Phi</th>
        <th>Mặt bích</th>
        <th>Co hàn</th>
        <th>Vật liệu phụ</th>
        <th>Nón che</th>
        <th>Ống nhún</th>
        <th>Description</th>
        <th>Group</th>
        <th>Note</th>
        <th style="width:10%">
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php echo form_open('admin/materials/form/funnel/', array('id'=>'save_form'));?>
        <td><input type="text" name="phi" value="" class="form-control tableInput"></td>
        <td><input type="text" name="value_mabi" value="" class="form-control tableInput"></td>
        <td><input type="text" name="value_coha" value="" class="form-control tableInput"></td>
        <td><input type="text" name="value_vtp" value="" class="form-control tableInput"></td>
        <td><input type="text" name="value_noch" value="" class="form-control tableInput"></td>
        <td><input type="text" name="value_onnh" value="" class="form-control tableInput"></td>
        <td><input type="text" name="description" value="" class="form-control tableInput"  style="max-width:100%"></td>
        <td><input type="text" name="group" value="" class="form-control tableInput"></td>
        <td><input type="text" name="note" value="" class="form-control tableInput"></td>
        <td class="text-right">
            <button type="submit" class="btn btn-default"><i class="icon-plus"></i></button>
        </td>
        </form>
    </tr>
    <?php foreach ($results as $result):?>
        <tr>
            <td><input id="phi_<?php echo $result->id;?>" type="text" name="phi" value="<?php echo $result->phi?>" class="form-control tableInput"></td>
            <td><input id="value_mabi_<?php echo $result->id;?>" type="text" name="value_mabi" value="<?php echo $result->value_mabi?>" class="form-control tableInput"></td>
            <td><input id="value_coha_<?php echo $result->id;?>" type="text" name="value_coha" value="<?php echo $result->value_coha?>" class="form-control tableInput"></td>
            <td><input id="value_vtp_<?php echo $result->id;?>" type="text" name="value_vtp" value="<?php echo $result->value_vtp?>" class="form-control tableInput"></td>
            <td><input id="value_noch_<?php echo $result->id;?>" type="text" name="value_noch" value="<?php echo $result->value_noch?>" class="form-control tableInput"></td>
            <td><input id="value_onnh_<?php echo $result->id;?>" type="text" name="value_onnh" value="<?php echo $result->value_onnh?>" class="form-control tableInput"></td>
            <td><input id="description_<?php echo $result->id;?>" type="text" name="description" value="<?php echo $result->description?>" class="form-control tableInput"  style="max-width:100%"></td>
            <td><input id="group_<?php echo $result->id;?>" type="text" name="group" value="<?php echo $result->group?>" class="form-control tableInput"></td>
            <td><input id="note_<?php echo $result->id;?>" type="text" name="note" value="<?php echo $result->note?>" class="form-control tableInput"></td>
            <td class="text-right">
                <div class="btn-group">
                    <a class="btn btn-default" onclick="update(<?php echo $result->id?>);" >
                        <i class="icon-save"></i>
                    </a>
                    <a class="btn btn-danger" href="<?php echo site_url('admin/materials/delete/funnel/'.$result->id);?>" onclick="return areyousure();" alt="<?php echo lang('delete');?>">
                        <i class="icon-times "></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>