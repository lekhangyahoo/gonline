<?php pageHeader('Constants'); ?>

<script type="text/javascript">
var BASE_URL = '<?php echo base_url();?>';
function areyousure()
{
    return confirm('Are you sure you want to delete this item?');
}
function update(id)
{    
	var url 		= BASE_URL + 'admin/materials/form/constants/' + id;
	var code 		= $("#code_"+id).val();
	var value 		= $("#value_"+id).val();
	var description = $("#description_"+id).val();
	var group 		= $("#group_"+id).val();
	$.post( 
		url,
        { code: code, value: value, description: description, group: group}
    );
	alert('Item updated.');
}
</script>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Code</th>
            <th>Value</th>
            <th>Description</th>
            <th>Type</th>
            <th style="width:10%">
            </th>
        </tr>
        </thead>
        <tbody>
			<tr>
			<?php echo form_open('admin/materials/form/constants/', array('id'=>'save_form'));?>
                <td><input type="text" name="code" value="" class="form-control tableInput"></td>
                <td><input type="text" name="value" value="" class="form-control tableInput"></td>
                <td><input type="text" name="description" value="" class="form-control tableInput" style="max-width:100%"></td>
				<td><input type="text" name="group" value="" class="form-control tableInput"></td>
                <td class="text-right">
					<button type="submit" class="btn btn-default"><i class="icon-plus"></i></button>
                </td>
			</form>
			</tr>
		<?php foreach ($results as $result):?>
			<tr>
				<td><input id="code_<?php echo $result->id;?>" type="text" name="code" value="<?php echo $result->code?>" class="form-control tableInput"></td>
                <td><input id="value_<?php echo $result->id;?>" type="text" name="value" value="<?php echo $result->value?>" class="form-control tableInput"></td>
                <td><input id="description_<?php echo $result->id;?>" type="text" name="description" value="<?php echo $result->description?>" class="form-control tableInput" style="max-width:100%"></td>
				<td><input id="group_<?php echo $result->id;?>" type="text" name="group" value="<?php echo $result->group?>" class="form-control tableInput"></td>
                <td class="text-right">
                    <div class="btn-group">
                        <a class="btn btn-default" onclick="update(<?php echo $result->id?>);" >
							<i class="icon-save"></i>
						</a>
                        <a class="btn btn-danger" href="<?php echo site_url('admin/materials/delete/constants/'.$result->id);?>" onclick="return areyousure();" alt="<?php echo lang('delete');?>">
							<i class="icon-times "></i>
						</a>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>			
        </tbody>
    </table>
