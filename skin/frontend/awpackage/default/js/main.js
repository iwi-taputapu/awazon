jQuery(window).load(function() {
	jQuery('.sub_active').parent().parent().addClass('parent');
	jQuery('.subsub_active').parent().parent().addClass('sub_parent');
	jQuery('.subsub_active').parent().parent().parent().parent().addClass('subsub_parent');
	// var height = parent.height();
	var filterHeight = jQuery('.m-filter-css-checkboxes li').height() * 3;
	jQuery('.m-filter-css-checkboxes').height(filterHeight);
})