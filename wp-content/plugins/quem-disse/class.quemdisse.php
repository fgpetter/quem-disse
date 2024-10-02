<?php

class QuemDisse {

  private static $initiated = false;

  public function __construct()
  {
    if ( ! self::$initiated ) {
      self::$initiated = true;

      add_action( 'init', [$this, 'register_sources'] );
      add_action( 'init', [$this, 'register_authors'] );
      add_action( 'admin_init', [$this, 'authors_add_metabox_image'] );
      add_action( 'admin_init', [$this, 'authors_add_metabox_username'] );
      add_action( 'save_post_authors', [$this, 'authors_save_metabox_image'] );
      add_action( 'save_post_authors', [$this, 'authors_save_metabox_username'] );
    }
  }

  /**
   * Executa processo de ativação do plugin
   * @static
   */
  public static function plugin_activation() {
    if ( version_compare( $GLOBALS['wp_version'], QUEMDISSE__MINIMUM_WP_VERSION, '<' ) ) {
      load_plugin_textdomain( 'quemdisse' );
      $message = sprintf(
        esc_html__( 'O plugin "QuemDisse" requer o WordPress versão %s ou superior. Sua versão atual é %s.', 'quemdisse' ),
        QUEMDISSE__MINIMUM_WP_VERSION,
        $GLOBALS['wp_version']
      );

      flush_rewrite_rules(false);

    }
  }

  /**
   * Executa processo de desativação do plugin
   * @static
   */
  public static function plugin_deactivation() {
    flush_rewrite_rules(false);
  }

  /**
  * Cria tela de cadastro de fontes
  */
  public function register_authors() {

    $labels = [
      'name'                  => _x('Autores', 'Post type general name', 'quemdisse'),
      'singular_name'         => _x('Autor', 'Post type singular name', 'quemdisse'),
      'menu_name'             => _x('Autores', 'Admin Menu text', 'quemdisse'),
      'name_admin_bar'        => _x('Autor', 'Add New on Toolbar', 'quemdisse'),
      'add_new'               => __('Adicionar Novo', 'quemdisse'),
      'add_new_item'          => __('Adicionar Novo Autor', 'quemdisse'),
      'new_item'              => __('Novo Autor', 'quemdisse'),
      'edit_item'             => __('Editar Autor', 'quemdisse'),
      'view_item'             => __('Ver Autor', 'quemdisse'),
      'all_items'             => __('Todas os autores', 'quemdisse'),
      'search_items'          => __('Buscar utores', 'quemdisse'),
      'parent_item_colon'     => __('Autor Filha:', 'quemdisse'),
      'not_found'             => __('Nenhuma Autor encontrada.', 'quemdisse'),
      'not_found_in_trash'    => __('Nenhuma Autor encontrada na lixeira.', 'quemdisse'),
      'featured_image'        => _x('Imagem Destacada', 'Overrides the “Featured Image” phrase', 'quemdisse'),
      'set_featured_image'    => _x('Definir imagem destacada', 'Overrides the “Set featured image” phrase', 'quemdisse'),
      'remove_featured_image' => _x('Remover imagem destacada', 'Overrides the “Remove featured image” phrase', 'quemdisse'),
      'use_featured_image'    => _x('Usar como imagem destacada', 'Overrides the “Use as featured image” phrase', 'quemdisse'),
      'archives'              => _x('Arquivos de Autores', 'The post type archive label', 'quemdisse'),
      'insert_into_item'      => _x('Inserir em Autor', 'Overrides the “Insert into post” phrase', 'quemdisse'),
      'uploaded_to_this_item' => _x('Enviado para esta Autor', 'Overrides the “Uploaded to this post” phrase', 'quemdisse'),
      'filter_items_list'     => _x('Filtrar lista de Autores', 'Screen reader text for the filter links', 'quemdisse'),
      'items_list_navigation' => _x('Navegação da lista de Autores', 'Screen reader text for the pagination', 'quemdisse'),
      'items_list'            => _x('Lista de Autores', 'Screen reader text for the items list', 'quemdisse'),
    ];

    $props = [
      'labels' => $labels,
      'description' => __('Lista de autores apresnetadas no site.', 'quemdisse'),
      'public' => true,
      'publicly_queryable' => true,
      'query_var' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'show_in_rest' => true,
      'rewrite' => ['slug' => 'authors'],
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => null,
      'supports' => ['title', 'editor','excerpt'],
      'menu_icon'  => 'dashicons-id',
    ];

    register_post_type('authors', $props );

  }

  /**
  * Cria tela de cadastro de autores
  */
  public function register_sources() {

    $labels = [
      'name'                  => _x('Fontes', 'Post type general name', 'quemdisse'),
      'singular_name'         => _x('Fonte', 'Post type singular name', 'quemdisse'),
      'menu_name'             => _x('Fontes', 'Admin Menu text', 'quemdisse'),
      'name_admin_bar'        => _x('Fonte', 'Add New on Toolbar', 'quemdisse'),
      'add_new'               => __('Adicionar Nova', 'quemdisse'),
      'add_new_item'          => __('Adicionar Nova Fonte', 'quemdisse'),
      'new_item'              => __('Nova Fonte', 'quemdisse'),
      'edit_item'             => __('Editar Fonte', 'quemdisse'),
      'view_item'             => __('Ver Fonte', 'quemdisse'),
      'all_items'             => __('Todas as Fontes', 'quemdisse'),
      'search_items'          => __('Buscar Fontes', 'quemdisse'),
      'parent_item_colon'     => __('Fonte Filha:', 'quemdisse'),
      'not_found'             => __('Nenhuma Fonte encontrada.', 'quemdisse'),
      'not_found_in_trash'    => __('Nenhuma Fonte encontrada na lixeira.', 'quemdisse'),
      'featured_image'        => _x('Imagem Destacada', 'Overrides the “Featured Image” phrase', 'quemdisse'),
      'set_featured_image'    => _x('Definir imagem destacada', 'Overrides the “Set featured image” phrase', 'quemdisse'),
      'remove_featured_image' => _x('Remover imagem destacada', 'Overrides the “Remove featured image” phrase', 'quemdisse'),
      'use_featured_image'    => _x('Usar como imagem destacada', 'Overrides the “Use as featured image” phrase', 'quemdisse'),
      'archives'              => _x('Arquivos de Fontes', 'The post type archive label', 'quemdisse'),
      'insert_into_item'      => _x('Inserir na Fonte', 'Overrides the “Insert into post” phrase', 'quemdisse'),
      'uploaded_to_this_item' => _x('Enviado para esta Fonte', 'Overrides the “Uploaded to this post” phrase', 'quemdisse'),
      'filter_items_list'     => _x('Filtrar lista de Fontes', 'Screen reader text for the filter links', 'quemdisse'),
      'items_list_navigation' => _x('Navegação da lista de Fontes', 'Screen reader text for the pagination', 'quemdisse'),
      'items_list'            => _x('Lista de Fontes', 'Screen reader text for the items list', 'quemdisse'),
    ];

    $props = [
      'labels' => $labels,
      'description' => __('Lista de fontes apresnetadas no site.', 'quemdisse'),
      'public' => true,
      'publicly_queryable' => true,
      'query_var' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'show_in_rest' => true,
      'rewrite' => ['slug' => 'fontes'],
      'capability_type' => 'post',
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' => null,
      'supports' => ['title', 'editor', 'thumbnail'],
      'menu_icon'  => 'dashicons-format-quote',
    ];

    register_post_type('fontes', $props );

  }

  /**
   * Adiciona caixa de upload de imagem para autores.
   *
   * @return void
   */
  public function authors_add_metabox_image() {
    add_meta_box(
      'author_image',
      __('Adicione uma foto para o autor', 'quemdisse'),
      [$this, 'author_metabox_image'],
      'authors',
      'normal', // normal, side, advanced
      'default' // low, high, default
    );
  }

  /**
   * Renderiza a caixa de upload de imagem para autores.
   *
   * @param WP_Post $post O autor que est  sendo editado.
   */
  public function author_metabox_image ($post) {
    $media_url = get_post_meta( $post->ID, '_custom_media', true );
    ?>
    <div class="custom-media-uploader">
      <img id="custom-media-preview" src="<?php echo esc_url( $media_url ); ?>" style="max-width:100%; height:auto;" />
      <input type="hidden" name="custom_media" id="custom_media" value="<?php echo esc_url( $media_url ); ?>" />

      <input type="button" class="components-button is-secondary" style="width: 100%; margin-bottom: 16px"
        id="custom-media-upload-button" value="<?php esc_attr_e( 'Enviar imagem', 'quemdisse' ); ?>" />
        <input type="button" class="components-button is-destructive" style="width: 100%"
        id="custom-media-remove-button" value="<?php esc_attr_e( 'Remover imagem', 'quemdisse' ); ?>" />

    </div>
    <script>
    jQuery(document).ready(function($){
      var custom_uploader;

      // Botão de upload
      $('#custom-media-upload-button').click(function(e) {
        e.preventDefault();

        // If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
          custom_uploader.open();
          return;
        }

        // Carrega imagem de previsualização
        custom_uploader = wp.media.frames.file_frame = wp.media({
          title: '<?php _e( "Escolher imagem", "quemdisse" ); ?>',
          button: {
            text: '<?php _e( "Usar essa imagem", "quemdisse" ); ?>'
          },
          multiple: false
        });

        custom_uploader.on('select', function() {
          var attachment = custom_uploader.state().get('selection').first().toJSON();
          $('#custom_media').val(attachment.url);
          $('#custom-media-preview').attr('src', attachment.url);
        });

        custom_uploader.open();
      });

      // Botão de remoção
      $('#custom-media-remove-button').click(function(e){
        e.preventDefault();
        $('#custom_media').val('');
        $('#custom-media-preview').attr('src', '');
      });
    });
    </script>
    <?php
    // Adiciona nonce de segurança
    wp_nonce_field( 'custom_media_nonce_action', 'custom_media_nonce' );
  }

  public function authors_save_metabox_image( $post_id ) {

    // executa somente se houver um post de imagem, senão ignora, para evitar multiplas execuções
    if ( isset( $_POST['custom_media'] ) ) {

      if ( ! isset( $_POST['custom_media_nonce'] ) || ! wp_verify_nonce( $_POST['custom_media_nonce'], 'custom_media_nonce_action' ) ) {
        wp_die( __( 'Impossível salvar', 'quemdisse') );
      }

      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
      }

      if ( ! current_user_can( 'edit_post', $post_id ) ) {
        wp_die( __( 'Impossível salvar', 'quemdisse') );
      }

      update_post_meta( $post_id, '_custom_media', esc_url_raw( $_POST['custom_media'] ) );
    }
  }

  /**
   * Adiciona caixa de input de nome de usuário para autores.
   *
   */
  public function authors_add_metabox_username() {
    add_meta_box(
      'author_username',
      __('Adicione um nome de usuário para o autor', 'quemdisse'),
      [$this, 'author_metabox_username'],
      'authors',
      'side', // normal, side, advanced
      'high', // low, high, default
    );
  }

  /**
   * Mostra um input de texto para que o usuário digite o nome de usuário
   * que deseja atrelar a página do autor.
   *
   * @param WP_Post $post O autor que est  sendo editado.
   */
  public function author_metabox_username($post) {
    ?>
    <input type="text" name="author_username" id="author_username" class="components-text-control__input" 
      value="<?php echo get_post_meta( $post->ID, '_author_username', true ); ?>"
    >
    <small> Digite o nome de usuário para atrelar a página ao autor.</small>
    <?php
  }

  /**
   * Salva o nome de usuário do autor em uma meta box.
   *
   * Verifica se o nome de usuário existe e se o usuário tem permissão para
   * editar a página do autor. Se sim, salva o nome de usuário na meta box.
   *
   * @param int $post_id ID da página do autor.
   */
  public function authors_save_metabox_username( $post_id ) {

    if ( isset( $_POST['author_username'] ) ) {
      $author_username = sanitize_text_field( $_POST['author_username'] );
      $user = get_user_by( 'login', $author_username );

      if( $user ) {
        update_post_meta( $post_id, '_author_username', $_POST['author_username'] );
      } else { 
        wp_die( __( 'Impossível salvar', 'quemdisse') );
      }
    }
  }


}
$quem_disse = new QuemDisse();