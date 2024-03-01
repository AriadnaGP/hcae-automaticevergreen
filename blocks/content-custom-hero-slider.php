<?php 
$className = 'slider-block';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

?>

<section id="<?php echo $id;?>" class="<?php echo esc_attr($className); ?> <?php echo $align_class; ?>" >

  
<?php if( have_rows('sliders') ) {?>
  <div class="slider-wrap slider-for"><?php
      while( have_rows('sliders') ) {
        the_row(); 

        $background_image = get_sub_field('background_image');
        $background_color = get_sub_field('background_color');
        $overlay_bkg = get_sub_field('overlay_background');
        $title_color = get_sub_field('title_color');
        $description_color = get_sub_field('description_color');

        $colorArray = sscanf($overlay_bkg, "#%02x%02x%02x");
        if ($colorArray !== false) {
            $colorArray = [
                'red' => $colorArray[0],
                'green' => $colorArray[1],
                'blue' => $colorArray[2]
            ];
        }

        if ($background_image) {
          $bkg = 'style="background-repeat: no-repeat; background-size: cover; background-position: top center;"';
        } 
        else {
          $bkg = 'style="background-color:'.$background_color.';"';
        }?>


        <div class="slider-content lazy-load-bg" data-background-image="<?php echo esc_url($background_image); ?>" <?php echo $bkg;?>>
          <?php if ($overlay_bkg) {?>
            <span class="overlay-background" style="background:linear-gradient(<?php if (wp_is_mobile()) {?>0deg,<?php } else {?> 270deg,<?php } ?> <?php echo $overlay_bkg;?> 33.14%, rgba(<?php echo $colorArray['red'];?>, <?php echo $colorArray['green'];?>, <?php echo $colorArray['blue'];?>, 0.00) 100%);"></span>
          <?php } ?>
          <div class="content-wrap"><div class="slider-text">
            <h1 class="title-slider" <?php if($title_color){?>style="color: <?php echo $title_color;?>" <?php } ?>><?php echo get_sub_field('title_slider');?></h1>
            <p <?php if($description_color){?>style="color: <?php echo $description_color;?>" <?php } ?>><?php echo get_sub_field('description_slider');?></p>
            <?php 
            $link = get_sub_field('button');
            if( $link ){ 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="button wp-block-button__link" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php } ?>
          </div></div>

        </div>
      <?php } ?>
    </div>
    <?php } ?>

    <?php if( have_rows('sliders') ) {?>
    <div class="slider-nav"><?php 
      while( have_rows('sliders') ) {
        the_row(); 
        $icon= get_sub_field('icon_nav_slide');
        $image_url = wp_get_attachment_image_url($icon, 'original');
        $overlay_bkg_nav = get_sub_field('overlay_background');
        $colorArray_nav = sscanf($overlay_bkg_nav, "#%02x%02x%02x");
        if ($colorArray_nav !== false) {
            $colorArray_nav = [
                'red' => $colorArray_nav[0],
                'green' => $colorArray_nav[1],
                'blue' => $colorArray_nav[2]
            ];
        }
        if ($icon) {
        $bkg_btn = 'style="background-repeat: no-repeat; background-size: cover; background-position: top;"';
      } else {
        $bkg_btn = 'style="background-color:'.$background_color.';"';
      }?>

      <div class="slider-content">
        <div class="button-text lazy-load-bg" data-background-image="<?php echo esc_url($image_url); ?>" <?php echo $bkg_btn;?>>
          <span class="overlay-background_button" style="background: linear-gradient(
    0deg,
    rgba(<?php echo $colorArray_nav['red'];?>, <?php echo $colorArray_nav['green'];?>, <?php echo $colorArray_nav['blue'];?>, 0.8) 13.13%,
    rgba(<?php echo $colorArray_nav['red'];?>, <?php echo $colorArray_nav['green'];?>, <?php echo $colorArray_nav['blue'];?>, 0) 100%
  );"></span>
          <h6><?php echo get_sub_field('title_slider');?></h6>
        </div>
      </div>
      <?php } ?>
    </div>
    <?php } ?>

  
</section>
<style>
  @media only screen and (max-width: 669px) {
    .slider-block .slider-content .video-wrapper .embed-container::after{
      content:'';
      top: 0;
      left: -1px;
      width: 100%;
      bottom: auto;
      right: -1px;
      height: 73vh;
      position: absolute;
      background: rgb(0, 0, 0);
      background: linear-gradient(180deg, rgba(<?php echo $colorArray['red'];?>, <?php echo $colorArray['green'];?>, <?php echo $colorArray['blue'];?>, 0.25253851540616246) 0%, <?php echo $overlay_bkg;?> 100%);
    }

  }

</style>