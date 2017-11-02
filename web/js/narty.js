// by Narty

$(function() {
    $(".f-s-80").addClass("load");
});

$("#f-like").click(function() {
	if($('#like').attr('class') != "fa color-blue fa-thumbs-up") {
		$('#like').addClass('fa-thumbs-up');
		$('#like').removeClass('fa-thumbs-o-up');
	} else {
		$('#like').removeClass('fa-thumbs-up');
		$('#like').addClass('fa-thumbs-o-up');
	}
});

$("#f-dislike").click(function() {
	if($('#dislike').attr('class') != "fa color-red fa-thumbs-down") {
		$('#dislike').addClass('fa-thumbs-down');
		$('#dislike').removeClass('fa-thumbs-o-down');
	} else {
		$('#dislike').removeClass('fa-thumbs-down');
		$('#dislike').addClass('fa-thumbs-o-down');
	}
});