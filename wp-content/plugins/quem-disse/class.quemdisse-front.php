<?php

class QuemDisseFront
{
  private static $initiated = false;

  public function __construct()
  {
    if (! self::$initiated) {
      self::$initiated = true;
    }
    add_filter('the_content', [$this, 'show_author_excerpt']);
    add_action( 'wp_footer', function() {
      global $template;
      echo '<div style="display:none;">Template being used: ' . $template . '</div>';
  } );
  }

  public function show_author_excerpt($content) {
    if(is_single() && is_singular('post') && is_main_query() && get_option('quemdisse_show_excerpt')) {
      //var_dump(get_the_author_meta('user_login'));
      $author_card = "
      <div class='author-container' >
        <div class='author-name-image'>
          <div class='author-image'>
          <img src='http://localhost/wp-content/uploads/2024/09/download.jpeg' />
          </div>
          <h3 class='author-name' >Nome do Autor</h3>
        </div>
        <p class='author-description' >Suspendisse lorem ligula, faucibus nec pharetra eget, interdum vitae erat. 
          Mauris eu sapien interdum nunc condimentum suscipit a eu diam. 
          Etiam vitae quam imperdiet, ultrices sapien non, accumsan dui. In dictum neque 
          id imperdiet varius. Nunc semper nisl nec rutrum sagittis.</p>
        <p class='author-page'> <a href='#'>Clique Aqui para ver o autor</a> </p>
      </div>
      ";
      return $this->author_card_styles().$content."<br><br>".$author_card;
    }

    return $content;
  }

  public function author_card_styles(){
    ?>
    <style>
      .author-container {
        padding: 15px 0 15px 15px;
        border-left: 2px solid #6e6eb6;
      }
      .author-name-image {
        display: flex;
      }
      .author-image {
        width: 120px;
        height: 120px;
        overflow: hidden;
        border-radius: 100%;
        margin-right: 20px;
      }
      .author-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
    </style>
    <?php
  }

}
$quem_disse_front = new QuemDisseFront();
