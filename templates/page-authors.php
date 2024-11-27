<?php
$users = wp_list_pluck(get_users(), 'user_login');

global $wpdb;

$author_data = $wpdb->get_results( 
  "SELECT wp_postmeta.meta_key, wp_postmeta.meta_value, wp_posts.post_title
    FROM wp_postmeta
    INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID
    WHERE post_id IN (
    SELECT post_id 
    FROM wp_postmeta 
    WHERE meta_key = '_author_username'
    AND meta_value IN ('" . implode("','", array_map( 'esc_sql', $users )) . "')
  )
  AND meta_key IN ('_author_bio', '_custom_media', '_author_username')
  ORDER BY wp_posts.post_title", ARRAY_A);

$authors = [];
foreach ($author_data as $author) {
  $nome = $author["post_title"];

  if (!isset($authors[$nome])) {
      $authors[$nome] = [
          "nome" => $nome,
          "bio"  => "",
          "img"  => ""
      ];
  }

  if ($author["meta_key"] === "_author_bio") {
      $authors[$nome]["bio"] = $author["meta_value"];
  } elseif ($author["meta_key"] === "_custom_media") {
      $authors[$nome]["img"] = $author["meta_value"];
  } elseif ($author["meta_key"] === "_author_username") {
    $authors[$nome]["user"] = $author["meta_value"];
}
}

$authors = array_values($authors);

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
        <h1 class="entry-title">Lista de autores</h1>
      </header>

      <div class="entry-content">
        <div class="row">
          <?php foreach($authors as $author):?>
            
            <div class="col-sm-6 mb-3">
              <div class="card border-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col-3">
                      <img src="<?php echo $author['img']; ?>" alt="<?php echo $author['nome']; ?>" class="img-fluid rounded-circle">
                    </div>
                    <div class="col-9 d-flex align-items-center">
                      <div>
                      <h5 class="card-title mb-0"><?php echo $author['nome']; ?></h5>
                      <p>
                      <a href="/authors/<?php echo $author['user']; ?>">Ver posts de <?php echo $author['nome']; ?></a>
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