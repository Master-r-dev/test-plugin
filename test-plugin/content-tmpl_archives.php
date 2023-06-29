<?php
/**
 * Template part for displaying page content in tmpl_archives.php

 */

 ?>
 
 <article >
   <div class="entry-content"> 
     <div style="clear: both; margin-bottom: 30px;"></div>
     <?php
        $last__posts = intval(get_post_meta($post->ID, 'archived-posts-no', true)); 
        if($last__posts > 100 || $last__posts < 2) $last__posts = 5;
        $args = array(
            'post_type' => 'al_stocks',
            'post_status' => 'publish',
            'posts_per_page' => '5',
            'paged' => 1,
        );
        $my_query = new WP_Query($args);
        if($my_query->have_posts()) {
        echo '<h1 class="widget-title">Last '.$last__posts.' Stocks <span class="dashicons dashicons-format-aside"></span></h1>&nbsp;';
        echo '<div class="archives-latest-section"><ol>';
        $counter = 1;
        while($my_query->have_posts() && $counter <= $last__posts) {
            $my_query->the_post();  
            ?>
            <li><a href="<?php the_permalink() ?>"
              rel="bookmark"               
              title="Permanent Link to <?php the_title_attribute(); ?>">
              <?php the_title(); ?> | <?php if (get_post_meta(get_the_ID(), 'price', true)=='' )  echo 'price: none'; else echo 'price: '.get_post_meta(get_the_ID(), 'price', true) ;?></a>              
            </li>
            <?php
            $counter++;
        }
        echo '</ol></div>';
        wp_reset_postdata(); 
        } else {
            echo '<div> No stocks =( </div>';
        }
        ?> 
  
   </div> 
  
 </article> 
