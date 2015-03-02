<?php 
/**
 * Black flag sidebar
**/ 
?> 
<div id="secondary" class="widget-area">
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar')): endif; ?>
</div><!--secondary-->