<div class="page-header">
    <h1>Contacts</h1>
</div>


<table class="table table-striped">
    <thead>
        <tr>
			<th>Email</th>
			<th>Mobile</th>			
			<th>Product</th>			
			<th>Date</th>
			<th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php
		$status = array(
                  '0'   => 'No',
                  '1'   => 'Yes',
                  '2'   => 'Error',
                );	
		
        //$page_links = CI::pagination()->create_links();

        if(@$page_links != ''):?>
        <tr><td colspan="5" style="text-align:center"><?php //echo $page_links;?></td></tr>
        <?php endif;?>
        <?php echo (count($contacts) < 1)?'<tr><td style="text-align:center;" colspan="5">There are currently no contact.</td></tr>':''?>
<?php foreach ($contacts as $contact):?>
        <tr>
            <?php /*<td style="width:16px;"><?php echo  $contact->id; ?></td>*/?>
            <td><a href="mailto:<?php echo  $contact->email;?>"><?php echo  $contact->email; ?></a></td>
			<td><?php echo  $contact->mobile; ?></td>
            <td class="gc_cell_left"><a href="<?php echo  site_url($contact->url); ?>" target="_blank"> View </a></td>
            <td class="gc_cell_left"><?php echo date('d-m-Y H:i', $contact->date); ?></td>
            <td>
                <?php echo form_dropdown('status', $status, $contact->check, 'onChange="change_status(this, '.$contact->id.');"');?>
            </td>
            
        </tr>
<?php endforeach;
        if(@$page_links != ''):?>
        <tr><td colspan="5" style="text-align:center"><?php //echo $page_links;?></td></tr>
        <?php endif;?>
    </tbody>
</table>

<script type="text/javascript">
    function change_status(sel, id) {
       var value = sel.value;	   
	   $.ajax({
				method: "POST",
				url: "<?php echo site_url('/admin/customers/contact');?>",
				data: { status: value, id: id}
			}).done(function( msg ) {
					if(msg)
						alert("The status changed.");
				});
    }
	
</script>
