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

  /**
   * Filtra o conteudo do do post para incluir um card do autor do post.
   *
   * @param string $content
   * @return string
   */
  public function show_author_excerpt($content) {

    if(is_single() && is_singular('post') && (get_post_type() != 'authors') && is_main_query() && get_option('quemdisse_show_excerpt')) {
      
      // localiza o autor
      $author_username = get_the_author_meta('ID');
      global $wpdb;
      
      // localiza o nome do autor na página de autor
      $post_author = $wpdb->get_results(
        "SELECT wp_posts.post_title, wp_posts.post_name
          FROM wp_posts
          WHERE wp_posts.ID = (
            SELECT post_id 
            FROM wp_postmeta 
            WHERE meta_key = '_author_username'
            AND meta_value = '{$author_username}'
          )", ARRAY_A);
  
      if( !empty( $post_author ) ) {

        $author_name = $post_author[0]['post_title'];
        $author_slug = $post_author[0]['post_name'];
  
        // pega os dados do autor
        $author_data = $wpdb->get_results( 
          "SELECT wp_postmeta.meta_key, wp_postmeta.meta_value
          FROM wp_postmeta
          WHERE post_id = (
            SELECT post_id 
            FROM wp_postmeta 
            WHERE meta_key = '_author_username'
            AND meta_value = '{$author_username}'
          )
          AND meta_key IN ('_author_bio', '_custom_media', '_author_username')", ARRAY_A);
        
        // organiza os dados do autor para exibição
        $author = [];
        foreach ($author_data as $item) {
          $author[$item['meta_key']] = $item['meta_value'];
        }
  
        $author_card = "
        <div class='author-container' >
          <div class='author-name-image'>
            <div class='author-image'>
            <img src='{$author['_custom_media']}' alt='{$author_name}' />
            </div>
            <h3 class='author-name' >{$author_name}</h3>
          </div>
          <p class='author-description' >{$author['_author_bio']}</p>
          <p class='author-page'> <a href='/authors/{$author_slug}'>Clique Aqui para ver o autor</a> </p>
        </div>
        ";
        return $this->author_card_styles().$content."<br><br>".$author_card;
      }

    }

    return $content;
  }

  /**
   * Gera o CSS para o card do autor.
   * 
   * @return string
   */
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
