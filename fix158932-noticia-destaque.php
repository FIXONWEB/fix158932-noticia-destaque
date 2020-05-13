<?php
/**
 * Plugin Name:     FIXONWEB - Notícia Destaque
 * Plugin URI:      https://github.com/fixonweb/fix158932-noticia-destaque
 * Description:     Shortcode que mostra uma noticia recente de uma certa categoria
 * Author:          FIXONWEB
 * Author URI:      https://github.com/fixonweb
 * Text Domain:     fix158932
 * Domain Path:     /languages
 * Version:         1.0.1
 *
 * @package         Fix158932
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require 'plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker('https://github.com/FIXONWEB/fix158932-noticia-destaque', __FILE__, 'fix158932-noticia-destaque/fix158932-noticia-destaque');

add_shortcode("fix158932_noticia_destaque", "fix158932_noticia_destaque");
function fix158932_noticia_destaque($atts, $content = null){

	$post_type = 'post';
	$args = array(
		'numberposts' => 1,
		'post_type'   => $post_type,
		// 'category'    => 'destaque',
    	'tax_query' => array(
        	array(
            	'taxonomy' => 'category',
            	'field'    => 'slug',
            	'terms'    => 'destaque'
        	)
    	)
		// 'tax_query' => array(
  //       	array(
  //           	'taxonomy' => 'clientes',
  //           	'field'    => 'slug',
  //           	'terms'    => $cliente
  //       	)
  //   	)
	);

	$posts = get_posts( $args );

	ob_start();
	?>
		<style type="text/css">
			.border_red {
				border: 0px solid red;	
			}
			.fix158932 {
				background-size: cover;
			}

			.fix158932 .fix-image {
				border: 0px solid red;
				min-height: 100px;	
			}
			.fix158932 .fix-texto {
				background: rgba(0, 0, 0, 0.7);
				padding: 5px;
				color: white;
			}
			.fix158932 .fix-texto .fix-data {
				line-height: 1;
				font-size: 80%;
			}
			.fix158932 .fix-texto .fix-title {
				line-height: 1;
				font-weight: bold;
			}
			.fix158932 .fix-texto .fix-content {
				line-height: 1;
				font-weight: gray;
				padding-top: 4px;
				font-weight: 500;
			}

		</style>

		<?php foreach ($posts as $post) { ?>

			<?php 
			$post_date = date('d/m', strtotime($post->post_date));
			$post_title = $post->post_title;
			$content = $post->post_content;
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = wp_trim_words( $content, 5 );
			$img_url = get_the_post_thumbnail_url($post->ID,'medium'); 
			?>

			<div class="fix158932 border_red" style="background: url('<?php echo $img_url ?>') ;background-repeat: no-repeat;background-size: cover;">
				<a href="<?php echo $post->guid ?>">
					<div class="fix-image border_red"  >
						
					</div>
					<div class="fix-texto border_red">
						<div class="fix-data"><?=$post_date ?></div>
						<div class="fix-title"><?=$post_title ?></div>
						<div class="fix-content"><?=$content ?></div>
					</div>
				</a>
			</div>
		<?php } ?>
	<?php
	return ob_get_clean();
}
