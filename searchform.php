<?php
  $s = get_query_var('s', false);
?>
<div class="search-form-container">
  <form role="search" method="get" id="searchform" class="searchform" action="<?php echo site_url(); ?>">
  	<div class="search-inner row">
      <i class="fa fa-search"></i>
		  <input class="search-input field-left" type="text" value="<?php echo $s; ?>" placeholder="Enter a keyword..." name="s" id="s" />
		  <input class="search-input field-right btn" type="submit" id="searchsubmit" value="Search" />
  	</div>
  </form>
</div>
