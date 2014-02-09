<form name=form1 role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div><label class="screen-reader-text" for="s"></label>
        <input type="text" value="Search" onclick="document.form1.s.value ='';" name="s" id="searchtextarea" />
        <input type="submit" id="searchsubmit" value="Go" />
    </div>
</form>