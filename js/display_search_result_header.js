$(document).ready(function(e) {
	$("#search").keyup(function()
	{
		$("#display_search").show();
		var x = $(this).val();
		$.ajax(
		{
			type: 'GET',
			url: 'php/livesearch.php',
			data: 'q='+x, 
			success: function(data)
			{
				$("#display_search").html(data);
			}
			,
		});
	});
});
