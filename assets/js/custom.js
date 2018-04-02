$(document).ready(function(){
	$(".modalListingList").on('click', function(){
		var business_owner = $(this).attr('business_owner');
		var business_name = $(this).attr('business_name');
		var business_email = $(this).attr('business_email');
		var business_phone = $(this).attr('business_phone');
		var business_f_year = $(this).attr('business_f_year');
		var business_type = $(this).attr('business_type');
		var business_motto = $(this).attr('business_motto');
		var business_description = $(this).attr('business_description');

		var content  = "<tr><th>Business Owner</th><td>" + business_owner + "</td></tr><tr><th>Business Name</th><td>" + business_name + "</td></tr><tr><th>Business Email</th><td>" + business_email + "</td></tr><tr><th>Business Phone</th><td>" + business_phone + "</td></tr><tr><th>Foundation Year</th><td>" + business_f_year + "</td></tr><tr><th>Business Type</th><td>" + business_type + "</td></tr><tr><th>Business Motto</th><td>" + business_motto + "</td></tr><tr><th>Business Description</th><td>" + business_description + "</td></tr>";

		$("#detailsListing").html(content);
	});
});