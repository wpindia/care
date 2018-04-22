$(document).ready(function () {
	$totalDivs = $('.container section div.row > div').length;

	$height = ($totalDivs - 1 ) * 275;

	$('#left-col').css('min-height', $height);
});