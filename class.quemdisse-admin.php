<?php

class QuemDisseAdmin
{
  private static $initiated = false;

  public function __construct()
  {
    if (! self::$initiated) {
      self::$initiated = true;
    }
    add_action('admin_menu', [$this, 'add_menus']);
    add_action('admin_menu', [$this, 'setings_page']);
  }

  public function add_menus() {
    $page_hook = add_menu_page(
      'Quem Disse',
      'Quem Disse',
      'manage_options',
      'quemdisse-settings-page',
      [$this, 'quemdisse_page'],
      'dashicons-filter',
      100
    );
  }

  public function setings_page() {
    add_options_page(
      'Configurações Plugin Quem Disse',
      'Quem Disse',
      'manage_options',
      'quemdisse-settings-page',
      [$this, 'page_html']
    );
  }

  public function page_html() { ?>
    <div class='wrap'>
      <h1>Configurações Quem Disse</h1>
      <form method="POST">
        <?php if (isset($_POST['quemdisse_show_excerpt'])) $this->handle_form();
        settings_fields('quemdisse_settings');
        do_settings_sections('quemdisse-settings-page');
        submit_button();
        ?>
      </form>
      <div>
        <h3>Informações:</h3>
        <p>
          Ao instalar o plugin e ativá-lo, o resumo do autor ficará oculto para os usuários por pardrão. <br>
          Selecione a opção <strong>Somente Logado</strong> para mostrar o resumo somente para usuários logados enquanto configura os estilos. <br>
          Ao selecionar <strong>Público</strong> o resumo ficará visível para todos os usuários.
        </p>
      </div>
    </div> <?php
  }

  public function quemdisse_page()
  {
    add_settings_section(
      'quemdisse_first_section', // id da sessão "aba"
      'Selecione as opções desejadas', // subtitulo da aba
      null, // função que retorna texto no topo da aba 
      'quemdisse-settings-page', // página a qual a aba irá pertencer
    );

    /* Campo de select */
    add_settings_field(
      'quemdisse_show_excerpt', // id do campo será tbm o name
      'Apresentar resumo do autor', // label do campo
      [$this, 'location_html_select'], // código html do campo
      'quemdisse-settings-page', // página a qual o campo irá pertencer
      'quemdisse_first_section' // aba na qual esse imput aparece
    );

    /* CSS Personalizado */
    add_settings_field(
      'quemdisse_custom_styles', // id do campo será tbm o name
      'Configure CSS personalizado para esse campo', // label do campo
      [$this, 'custom_styles'], // código html do campo
      'quemdisse-settings-page', // página a qual o campo irá pertencer
      'quemdisse_first_section' // aba na qual esse imput aparece
    );
  }

  public function location_html_select() { 
    ?>
    <select name="quemdisse_show_excerpt" id="quemdisse_show_excerpt">
      <option <?php selected(get_option('quemdisse_show_excerpt'), 'hidden') ?> value="hidden">Oculto</option>
      <option <?php selected(get_option('quemdisse_show_excerpt'), 'logged-only') ?> value="logged-only">Somente Logado</option>
      <option <?php selected(get_option('quemdisse_show_excerpt'), 'public') ?> value="public">Público</option>
    </select>
    <?php 
  }
  public function custom_styles() { 
    ?>
    <textarea name="quemdisse_custom_styles" id="quemdisse_custom_styles" cols="40" rows="16" placeholder="Cole aqui o CSS personalizado para o resumo do autor"></textarea>
    <?php 
  }

  public function handle_form() {

    if( current_user_can('manage_options') ) {
      if(isset($_POST['quemdisse_show_excerpt']) && ($_POST['quemdisse_show_excerpt'] == 'hidden' || $_POST['quemdisse_show_excerpt'] == 'logged-only' || $_POST['quemdisse_show_excerpt'] == 'public')) {
        update_option('quemdisse_show_excerpt', sanitize_textarea_field($_POST['quemdisse_show_excerpt']));
      }
      ?>
      <div class="updated">
        <p>Configurações salvas</p>
      </div> <?php
    } else { ?>
    <div class="error">
        <p>Houve um erro, tente novamente</p>
    </div> <?php
    }
  }

}
$quem_disse_admin = new QuemDisseAdmin();
