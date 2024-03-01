<?php
/**
 * Here you have an example of block type, you can remplace the example name with if you need it
 * Don't forget to create this block and in ACF Wordpress
 *
 * @package HeyCreator Theme
 */

$class_name = 'decorative-block';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['anchor'] ) ) {
	$id_block = $block['anchor'];
}
	$img_decoration = get_field( 'image_decoration' );
	$down_decoration = get_field( 'bottom_decoration' );
	$left_decoration = get_field( 'left_decoration' );
	$right_decoration = get_field( 'right_decoration' );

	$position_up = get_field( 'top_position' );
	$position_down = get_field( 'bottom_position' );
	$position_left = get_field( 'left_position' );
	$position_right = get_field( 'right_position' );

	$height = get_field( 'height' );
	$width = get_field( 'width' );

	$svg_code = get_field( 'svg_code', $post_id );

/** Create align class ("alignwide") from block setting ("wide")*/

$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>
<section id="<?php echo esc_html( $id_block ); ?>" class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_html( $align_class ); ?>" >

  <?php if ( ( $img_decoration ) || ( $svg_code ) ) { ?>
	<div class="decoration" style="
		<?php
		if ( $width ) {
			?>
		 width: <?php echo esc_attr( $width ); ?>px; <?php } ?>
		<?php
		if ( $height ) {
			?>
		 height: <?php echo esc_attr( $height ); ?>px; <?php } ?>
		<?php
		if ( $position_left ) {
			?>
	left: <?php echo esc_attr( $position_left ); ?>; <?php } ?>
		<?php
		if ( $position_up ) {
			?>
	top: <?php echo esc_attr( $position_up ); ?>; <?php } ?>
		<?php
		if ( $position_right ) {
			?>
	right: <?php echo esc_attr( $position_right ); ?>; <?php } ?>
		<?php
		if ( $position_down ) {
			?>
	bottom: <?php echo esc_attr( $position_down ); ?>; <?php } ?>">
		<?php
		if ( $img_decoration ) {
			?>
 <img src="<?php echo esc_url( $img_decoration ); ?>"><?php } ?>
		<?php
		if ( $svg_code ) {
			echo $svg_code;}
		?>
		</div>
  <?php } ?>
	
  <div class="decorative-content-wrap">
	  <InnerBlocks />
  </div>

</section>
