$(document).ready(function()
{	
	$addcom1=$('.addcom1');
	$block_com1=$('.block_com1');
	$block_com2=$('.block_com2');
	$addcom2=$('.addcom2');

	$addcom1.click(function()
	{	
		var id=$(this).attr('id');
		id=id.substr(8);
		$block_com1.hide();
		$block_com2.hide();
		$('#com1_'+id).show();
		$addcom1.show();
		$(this).hide();
	});

	$addcom2.click(function()
	{	
		var id=$(this).attr('id');
		id=id.substr(8);
		$block_com2.hide();
		$block_com1.hide();
		$('#com2_'+id).show();
		$addcom2.show();
		$(this).hide();
	});

});