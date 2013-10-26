<form class="form-inline" role="form" action="<?php bloginfo( 'siteurl'); ?>/?s=" method="get">
  	<div class="form-group">
		<label class="sr-only" for="search">Email address</label>
    	<input type="text" class="form-control" placeholder="Search" name="s" id="search" value="<?php the_search_query(); ?>">
	</div>
    <button type="submit" class="btn btn-default pull-right">Search</button>
</form>