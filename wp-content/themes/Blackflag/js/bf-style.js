jQuery(document).ready(function($) {

$('.slide-title h2 a, .tv-featured-title').each(function () {
    var html = $(this).html();
    var split = html.split(" ");
    if (split.length > 3) {
		split[split.length - 1] = "<span class='last-word'>" + split[split.length - 1] + "</span>";
		split[split.length - 2] = "<span class='last-word'>" + split[split.length - 2] + "</span>";
        $(this).html(split.join(" "));
    }
	else
	{}
});

$('.widget-title').each(function () {
    var html = $(this).html();
    var split = html.split(" ");
    if (split.length > 1) {
		split[split.length - 1] = "<span class='last-word'>" + split[split.length - 1] + "</span>";
        $(this).html(split.join(" "));
    }	else
	{}
});


});