<?php $search_text = empty($_GET['s']) ? "Search" : get_search_query(); ?> 
    <form method="get" action="<?php echo esc_url( home_url( '' ) ); ?>"> 
		<div class="ktz-search has-feedback">
		<label class="control-label sr-only" for="inputSuccess5">Search</label>
        <input type="text" name="s" id="s" class="form-control btn-box" placeholder="Search" />
		<span class="glyphicon glyphicon-search form-control-feedback"></span>
		</div>
    </form>
