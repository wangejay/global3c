<?php 
/**
 * Black flag search form
**/ 
?>
<?php 	$bf_search_translate = get_option('bf_search_translate'); ?>

<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<input type="text" name="s" id="s" value="<?php echo $bf_search_translate; ?>" onfocus='if (this.value == "<?php echo $bf_search_translate; ?>") { this.value = ""; }' onblur='if (this.value == "") { this.value = "<?php echo $bf_search_translate; ?>"; }' />
	<button type="submit" class="submit-button">
	</button>
</form>