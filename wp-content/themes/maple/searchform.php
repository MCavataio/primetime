<form  method="get" id="searchform" action="<?php echo esc_url(home_url('/')) ?>">
    <div class="tn-search">
        <span class="search-input"><input type="text" id="s" placeholder="<?php  esc_html_e('Search and hit enter&hellip;', 'tn') ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php  esc_html_e('Search for:', 'tn') ?>"/></span>
        <span class="search-submit"><input type="submit" value="" /><i class="fa fa-search"></i></span>
    </div>
</form><!--#search form -->
