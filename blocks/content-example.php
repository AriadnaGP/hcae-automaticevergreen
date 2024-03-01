<?php
/**
 * Here you have an example of block type, you can remplace the example name with if you need it
 * Don't forget to create this block and in ACF Wordpress
 *
 * @package HeyCreator Theme
 */

$class_name = 'example-block';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['anchor'] ) ) {
	$id_block = $block['anchor'];
}

/** Create align class ("alignwide") from block setting ("wide")*/

$align_class = $block['align'] ? 'align' . $block['align'] : '';
$slider_height = get_field( 'slider_height' );

?>
<section id="<?php echo esc_html( $id_block ); ?>" class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_html( $align_class ); ?>" >
  
  <div class="example-content-wrap">
	  <InnerBlocks.Content />
  </div>

</section>
