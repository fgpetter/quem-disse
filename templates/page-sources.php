<?php
global $wpdb;

// Query to get all fonte posts
$source_data = $wpdb->get_results(
  "SELECT ID, post_title, post_content, guid 
   FROM wp_posts 
   WHERE post_type = 'fontes' 
   AND post_status = 'publish'
   ORDER BY post_title", ARRAY_A);

$sources = [];
foreach ($source_data as $source) {
    $sources[] = [
        'id' => $source['ID'],
        'title' => $source['post_title'],
        'content' => $source['post_content'],
        'link' => $source['guid']
    ];
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo plugins_url( 'quem-disse/assets/css/quem-disse.css', QUEMDISSE__PLUGIN_DIR ) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php get_header(); ?>
  </head>
  <body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div id="site-content" role="main" style="max-width: 1000px; margin: 0 auto;">
      <header class="entry-header mb-5">
        <h1 class="entry-title">Lista de Fontes</h1>
      </header>

      <div class="entry-content">
        <div class="row">
          <?php foreach($sources as $source): ?>
            <div class="col-sm-6 mb-3">
              <div class="card border-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col-3">
                      <img src="<?php echo get_the_post_thumbnail_url($source['id']); ?>" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-9 d-flex align-items-center">
                      <div>
                      <h5 class="card-title mb-0"><?php echo esc_html($source['title']); ?></h5>
                      <br class="card-text"><?php echo wp_trim_words($source['content'], 20); ?> </br>
                      <a href="<?php echo esc_url($source['link']); ?>">Ver posts de <?php echo esc_html($source['title']); ?></a>
                      </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php get_footer(); ?>
  </body>
</html> 