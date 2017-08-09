<?php

add_shortcode( 'chr_pageflip_single', 'chr_pageflip_single' );
add_filter('the_content','chr_pageflip_single');

function chr_pageflip_single($content) {

global $post_type;

    if ('pageflip' == $post_type) { 

		$meta_element_speed 	= get_post_meta( get_the_ID(), 'custom_element_grid_meta_speed', true );
		$meta_element_starting 	= get_post_meta( get_the_ID(), 'custom_element_grid_starting', true );
		$meta_element_direction = get_post_meta( get_the_ID(), 'custom_element_grid_meta_direction', true );
		$meta_element_numbers	= get_post_meta( get_the_ID(), 'custom_element_grid_meta_numbers', true);
		$meta_element_closed 	= get_post_meta( get_the_ID(), 'custom_element_grid_meta_closed', true);
?>

	<script type="text/javascript">
	//<![CDATA[
		jQuery(document).ready(function($) {
			$('.gallery').find('br').remove();
			$('.galleryid-<?php echo get_the_ID();?>').booklet({
				speed: <?php if( ! empty( $meta_element_speed ) ) { echo $meta_element_speed; } else { echo "1000"; } ; ?>,
				startingPage: <?php if( ! empty( $meta_element_starting ) ) { echo $meta_element_starting; } else { echo "1"; } ;?>,
				direction:  '<?php if( ! empty( $meta_element_direction ) ) { echo $meta_element_direction; } else { echo "LTR"; } ; ?>',
				pageNumbers: <?php if( ! empty( $meta_element_numbers ) ) { echo $meta_element_numbers; } else { echo "true"; } ; ?>,
				closed: <?php if( ! empty( $meta_element_closed ) ) { echo $meta_element_closed; } else { echo "false"; } ; ?>,
		        autoCenter: true,
				pagePadding: 0
		    });
	    });
	//]]>
	</script>
	<?php

		//Verifica as IDs das imagens da Galeria
		$chr_get_ids = get_the_content();

		preg_match('/\[gallery.*ids=.(.*).\]/', $chr_get_ids, $chr_ids);
		$array_id = explode(",", $chr_ids[1]); $array = $array_id;
		$print_ids = implode(",", $array);
		
		//Verifica se existe Link na Imagem
		$chr_get_target = get_the_content();
		
		preg_match('/\[gallery.*link=.(.*).*ids=.(.*).\]/', $chr_get_target, $chr_target);
		$array_target = explode(",", $chr_target[1]);
		$targetarray = $array_target;
		$print_target = implode(",", $targetarray);
		
		//Funcao de criacao do novo shortcode da galeria
		$geragaleria = '[gallery link="'.$print_target.'" ids="' . $print_ids . '" size="chr-imagem-revista" columns="0" itemtag="div" icontag="figure" captiontag="p"]';
		
		return do_shortcode($geragaleria);

	} else {

	    return $content;

	}
	
}