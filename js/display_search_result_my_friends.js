$(document).ready(function(e) {
	$("#search_my_friends").keyup(function()
	{
		$("#display_list_of_friends").show();
		var x = $(this).val();
		$.ajax(
		{
			type: 'GET',
			url: 'php/livesearch.php',
			data: 'list='+x, 
			success: function(data)
			{
				$("#display_list_of_friends").html(data);
			}
			,
		});
	});
});
