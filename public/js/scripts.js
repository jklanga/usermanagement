file_browser_callback : 'elFinderBrowser'
$(document).ready(function () {
	$(function() {
		$('.datepicker').datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			 changeYear: true
		});
	
	});

	$('.jquery-table').DataTable();
	
	$('#search_list').click(function(){
		$('#search_form').submit();
	})
	
	$('.search_group').click(function(){
		$('#group_id').val($(this).attr('id'));
		$('#search_form').submit();
	})
	
	$('#clear_search').click(function(){
		$(":input, #search_form").not(":button, :submit, :reset, :hidden").each( function() {
		    $(this).val("");
		});
		$('#search_form').submit();
	})
	
	$('#update_details').click(function(){
		$('#update_form').submit();
	})
	
	$('.list_items').click(function(){
		window.location = "../"+$(this).attr('id');
	})
	
	$('.list_users,.list_groups').click(function(){
		window.location = "/"+$(this).attr('id');
	})
	
	$('.nav li.dropdown, li a').mouseover(function(){
		$('.nav li.dropdown').each(function(){
			$(this).removeClass('open');
		})
	  	$(this).addClass('open');
	});
	
});

