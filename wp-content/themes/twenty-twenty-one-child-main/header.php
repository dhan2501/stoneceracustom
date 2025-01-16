<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <title>Bootstrap demo</title> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> 
    <?php wp_head(); ?>   
</head>
  
  <body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= site_url(); ?>">
        <?php $custom_logo_id = get_theme_mod( 'custom_logo' );
        $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        echo '<img class="header_logo" src="'.$image[0].'">';
        ?>
        <img src="<?php header_image(); ?>" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      
      <?php
        function buildTree( array &$elements, $parentId = 0 )
        {
            $branch = array();
            foreach ( $elements as &$element )
            {
                if ( $element->menu_item_parent == $parentId )
                {
                    $children = buildTree( $elements, $element->ID );
                    if ( $children )
                        $element->wpse_children = $children;

                    $branch[$element->ID] = $element;
                    unset( $element );
                }
            }
            return $branch;
        }
        function wpse_nav_menu_2_tree( $menu_id )
        {
            $items = wp_get_nav_menu_items( $menu_id );
            return  $items ? buildTree( $items, 0 ) : null;
        }

        $tree = wpse_nav_menu_2_tree( 'top-menu' );  // <-- Modify this to your needs!


        ?>
          

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
           <?php
            foreach ($tree as $list) {
              if(empty($list->wpse_children)){
            ?>
            <li class="nav-item"><a  class="nav-link active" href="<?= $list->url;?>"><?= $list->title?></a></li>
             <?php 
           }
           else{
            ?>
            <li  class="nav-item dropdown" >
               <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $list->title;?></a> 
            <ul class="dropdown-menu">
              <?php
               foreach ($list->wpse_children as $subList) {
                ?>
                <li><a class="dropdown-item" href="<?= $subList->url;?>"><?= $subList->title;?></a></li>
                <?php
               }
              ?>
            </ul>
            </li>
            <?php
           }
            }

           ?>

        
      </ul>
      <!-- <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> -->
      <?//= do_shortcode('[woocommerce_ajax_search_form]'); ?>
      <?//= do_shortcode('[asearch  image="false" source="product, post, page"]'); ?>
      <?= do_shortcode('[asearch  image="true" source="product,product_cat"]'); ?>
      <!-- <div class="wcas-search-container">
    <input type="text" id="wcas-search-input" placeholder="Search for products..." />
    <div id="wcas-search-results"></div>
</div> -->
      <ul>
      <li class="nav-item">
          <?php echo do_shortcode('[tophead-wishlist]'); ?>
        </li>
        <li class="nav-item">
            <?php echo do_shortcode('[bucket]'); ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
