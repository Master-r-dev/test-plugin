<?php

if(!function_exists('single_page_query_vars')) :
    function single_page_query_vars( $qvars ) {
        $qvars[] = 'al_stocks';
        return $qvars;
    }
endif;
add_filter( 'query_vars', 'single_page_query_vars' );
?>