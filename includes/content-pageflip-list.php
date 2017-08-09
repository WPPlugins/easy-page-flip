<?php

	add_shortcode( 'chr-pageflip-list', 'create_epf_shortcode' );

	function create_epf_shortcode( $atts ) {
	    ob_start();
	 
	    // define attributes and their defaults
	    extract( shortcode_atts( array (
	        'orderby' => 'date',
	        'order' => 'DESC',
	        'posts' => 6,
	        'thumb' => 'thumbnail',
	    ), $atts ) );

	    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	    // define query parameters based on attributes
	    $options = array(
	        'post_type' => 'pageflip',
	        'order' => $order,
	        'orderby' => $orderby,
	        'posts_per_page' => $posts,
	        'paged' => $paged,
	    );
		
		$loop_pageflip = new WP_Query( $options ); ?>
	    
	    <ul class="ul-list-easy-pageflip">
		<?php
	    // run the loop based on the query
	    if($loop_pageflip->have_posts()) {
	    	while ( $loop_pageflip->have_posts() ) : $loop_pageflip->the_post(); ?>
			<li class="li-easy-pageflip">
				<h4><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h4>
		 		<?php echo '<a href="'.get_permalink().'" title="'.the_title('', '', false).'" >'; if ( has_post_thumbnail()) { the_post_thumbnail($thumb); }else{ echo '<img src="'. plugins_url('./../assets/images/not-image.jpg' , __FILE__ ) .'" class="attachment-thumbnail wp-post-image" style="width: 150px; height: 150px;" alt="'.the_title('', '', false).'" title="'.the_title('', '', false).'" />'; } echo '</a>'; ?>
			</li>
			<?php endwhile; ?>
		</ul>
		
	<?php 	

		if(function_exists('wp_pagenavi')) :			
			wp_pagenavi( array( 'query' => $loop_pageflip ));
		else :
		
			if($loop_pageflip->max_num_pages>1){
		?>
			<div class="chr-default-pagination">
			    <?php if ($paged > 1) { ?>
			    	<a href="<?php echo '?paged=' . ($paged -1); //prev link ?>">&laquo;</a>
			    <?php } for($i=1;$i<=$loop_pageflip->max_num_pages;$i++){ ?>
			    	<a href="<?php echo '?paged=' . $i; ?>" <?php echo ($paged==$i)? 'class="selected"':'';?>><?php echo $i;?></a>
			    <?php } if($paged < $loop_pageflip->max_num_pages){ ?>
			    	<a href="<?php echo '?paged=' . ($paged + 1); //next link ?>">&raquo;</a>
			    <?php } ?>
			</div>
			
		<?php
			}

		endif;

	        $myvariable = ob_get_clean();

			return $myvariable;

	    }else{
		    echo '<h6>' . __( 'Not found...', 'easy-page-flip' ) . '</h6>';
	    }
	
	}