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
        <h1 class="entry-title"><?php the_title(); ?></h1>
      </header>

      <div class="entry-content">
        
        <div class="row">
          <div class="col-3">
            <?php $media_url = get_post_meta( $post->ID, '_custom_media', true ); 
              if( ! empty( $media_url ) ) : ?>
              
              <figure class="wp-block-image">
                <img src="<?php echo esc_url( $media_url ); ?>" alt="<?php the_title(); ?>" class="img-fluid rounded-circle"/>
              </figure>
    
            <?php endif ?>
          </div>
          <div class="col-9">
            <img src="<?php echo plugins_url( 'quem-disse/assets/img/logo_quem_disse.png', QUEMDISSE__PLUGIN_DIR ) ?>" 
              alt="Logo Quem Disse" class="logo-quem-disse mb-3"/>
            <div class="row gap-0">

            <!-- SELOS -->

              <?php 
              $selo_tempo = get_post_meta( $post->ID, '_author_selo_tempo', true );
              $selo_formacao = get_post_meta( $post->ID, '_author_selo_formacao', true );
              $selo_artigos = get_post_meta( $post->ID, '_author_selo_artigos', true );

              if( ! empty( $selo_tempo ) ) : ?>
                <div class="col-auto px-1">
                  <img src="<?php echo plugins_url( 'quem-disse/assets/img/'.$selo_tempo.'.png', QUEMDISSE__PLUGIN_DIR ) ?>" 
                    alt="<?php echo get_post_meta( $post->ID, '_author_selo_tempo', true ) ?>" class="selo-tempo me-2"/>
                </div>
              <?php endif ?>
              
              <?php if( ! empty( $selo_formacao ) ) : ?>
                <div class="col-auto px-1">
                  <img src="<?php echo plugins_url( 'quem-disse/assets/img/'.$selo_formacao.'.png', QUEMDISSE__PLUGIN_DIR ) ?>" 
                    alt="<?php echo get_post_meta( $post->ID, '_author_selo_tempo', true ) ?>" class="selo-tempo me-2"/>
                </div>
              <?php endif ?>

              <?php if( ! empty( $selo_artigos ) ) : ?>
                <div class="col-auto px-1">
                  <img src="<?php echo plugins_url( 'quem-disse/assets/img/'.$selo_artigos.'.png', QUEMDISSE__PLUGIN_DIR ) ?>" 
                    alt="<?php echo get_post_meta( $post->ID, '_author_selo_tempo', true ) ?>" class="selo-tempo me-2"/>
                </div>
              <?php endif ?>
            </div>
          </div>
        </div>

        <!-- RESUMO -->

        <div class="card p-3 border-0 card-credentials mb-2">
          <?php $job = get_post_meta( $post->ID, '_author_job', true ); 
                $formacao = get_post_meta( $post->ID, '_author_formacao', true );
                $drt = get_post_meta( $post->ID, '_author_drt', true );
            if( ! empty( $job ) ) : ?>
              <p class="author-job">
                <strong>Cargo:</strong> 
                <?php 
                  echo $job;
                  if( ! empty( $drt ) ){ echo ' | '.$drt;};
                ?>
              </p>
            <?php endif ?>
            <?php if( ! empty( $formacao ) ) : ?>
              <p style="margin-top: -15px;">
                <?php echo $formacao; ?>
              </p>
            <?php endif ?>

            <?php $tempo = get_post_meta( $post->ID, '_author_selo_tempo', true ); 
            if( ! empty( $tempo ) ) : ?>
              <p class="author-selo-tempo">
                <?php 
                switch ($tempo) {
                  case '5_anos':
                    $tempo = 'Mais de 5 anos';
                    break;
                  case '10_anos':
                    $tempo = 'Mais de 10 anos';
                    break;
                  case '20_anos':
                    $tempo = 'Mais de 20 anos';
                    break;
                  case '30_anos':
                    $tempo = 'Mais de 30 anos';
                    break;
                  case '40_anos':
                    $tempo = 'Mais de 40 anos';
                    break;
                  case '50_anos':
                    $tempo = 'Mais de 50 anos';
                    break;
                  }
                ?>
                <strong>Tempo de vínculo com a empresa:</strong> <?php echo $tempo; ?>
              </p>
            <?php endif ?>

            <?php $editorial = get_post_meta( $post->ID, '_author_bio', true ); 
            if( ! empty( $editorial ) ) : ?>
              <p class="author-bio"><?php echo $editorial; ?></p>
            <?php endif ?>

            <?php $editorial = get_post_meta( $post->ID, '_author_editorial', true ); 
            if( ! empty( $editorial ) ) : ?>
              <p class="author-editorial mb-0">
                <strong>Editoriais:</strong> <?php echo $editorial; ?>
              </p>
            <?php endif ?>
            <div>
              <p style="font-size: 0.7rem; margin-top: 15px; margin-bottom: 0">Atualizado em: <?php echo get_the_modified_date('d/m/Y'); ?></p style="font-size: 0.8rem;">
            </div>
        </div>

        <!-- REDES SOCIAIS -->

        <div class="author-social-media mb-4 ms-3">
            <?php $linkedin = get_post_meta( $post->ID, '_author_linkedin', true ); 
              if( ! empty( $linkedin ) ) : ?>
                <a href="<?php echo $linkedin; ?>" class="author-linkedin text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#0A66C2" class="bi bi-linkedin" viewBox="0 0 16 16">
                  <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                </svg>
                </a>
            <?php endif ?>

            <?php $instagram = get_post_meta( $post->ID, '_author_instagram', true ); 
            if( ! empty( $instagram ) ) : ?>
              <a href="<?php echo $instagram; ?>" class="author-instagram text-decoration-none">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16" style="color:#c32070;">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
              </svg>
              </a>
            <?php endif ?>

            <?php $email = get_post_meta( $post->ID, '_author_email', true ); 
            if( ! empty( $email ) ) : ?>
              <a href="mailto:<?php echo $email; ?>" class="author-email text-decoration-none ms-3"> Entre em contato: 
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
              </svg>
              </a>
            <?php endif ?>
        </div>

        <!-- CONTEÚDO DO POST -->

        <div class="wp-block-paragraph">
          <?php the_content(); ?>
        </div>

        <!-- POSTS DO AUTOR -->

        <div class="auhtor-posts" style="margin-top: 70px;">
          <?php 
            $author = get_post_meta( $post->ID, '_author_username', true );

            if( ! empty( $author ) ) : 
              $user_data = get_user_by('login', $author); ?>

              <h4 class="author-posts-header">Publicações do autor</h4>

              <div class="row">
              <?php
                $args = [
                  'post_type' => 'post',
                  'author' => $user_data->ID,
                  'posts_per_page' => 10
                ];
                $the_query = new WP_Query( $args );
                if( $the_query->have_posts() ) : while( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="col-4" style='<?php if( empty(the_post_thumbnail() ) ) { echo "display: none"; } ?>' >
                  <div class="card border-0" style="max-width: 100%;">
                    <div style="height: 200px; max-width: 100%; 
                                background: url('<?php echo get_the_post_thumbnail_url($post->ID,"medium") ?>') 
                                no-repeat center center; background-size: cover">
                    </div>
                    <div class="card-body ps-0">
                      <h5 class="card-title">
                        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                          <?php the_title(); ?>
                        </a>
                      </h5>
                    </div>
                  </div>
                </div>
                <?php endwhile; endif; wp_reset_postdata(); ?>
            <?php endif ?>
        </div>
      </div>
    </div>

    <?php get_footer(); ?>

  </body>
</html>