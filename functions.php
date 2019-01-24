<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */
/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */

define('PORTFOLIO_CSS_VERSION', '0.0.1');
define('PORTFOLIO_JS_VERSION', '0.0.1');

function oceanwp_child_enqueue_parent_style() {
    // Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
    $theme   = wp_get_theme( 'OceanWP' );
    $version = $theme->get( 'Version' );
    // Load the stylesheet
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );

    // register webpack stylesheet and js with theme
    wp_enqueue_style( 'site_main_css', get_stylesheet_directory_uri() . '/css/build/main.min.css', [] , PORTFOLIO_CSS_VERSION , 'all');
    wp_enqueue_script( 'site_main_js', get_stylesheet_directory_uri() . '/js/build/app.js' , null , null , true );

}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );

/*
* Ajout du custom type 'réalisations' au portfolio
*/

function portfolio_custom_post_type() {

	// On rentre les différentes dénominations de notre custom post type qui seront affichées dans l'administration
	$labels = array(
		// Le nom au pluriel
		'name'                => _x( 'Réalisations', 'Post Type General Name'),
		// Le nom au singulier
		'singular_name'       => _x( 'Réalisation', 'Post Type Singular Name'),
		// Le libellé affiché dans le menu
		'menu_name'           => __( 'Réalisations'),
		// Les différents libellés de l'administration
		'all_items'           => __( 'Toutes les réalisations'),
		'view_item'           => __( 'Voir les réalisations'),
		'add_new_item'        => __( 'Ajouter une nouvelle réalisation'),
		'add_new'             => __( 'Ajouter'),
		'edit_item'           => __( 'Editer la réalisation'),
		'update_item'         => __( 'Modifier la réalisation'),
		'search_items'        => __( 'Rechercher une réalisation'),
		'not_found'           => __( 'Non trouvée'),
		'not_found_in_trash'  => __( 'Non trouvée dans la corbeille'),
	);
	
	// Autres options sur le custom types
	
	$args = array(
		'label'               => __( 'Réalisations'),
		'description'         => __( 'Tous sur les réalisations'),
		'labels'              => $labels,
		// On définit les options disponibles dans l'éditeur de notre custom post type ( un titre, un auteur...)
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields' ),
		/* 
		* Différentes options supplémentaires
		*/	
		'hierarchical'        => false,
		'public'              => true,
		'has_archive'         => true,
		'rewrite'			  => array( 'slug' => 'realisations'),

	);
	
	register_post_type( 'realisations', $args );

}

add_action( 'init', 'portfolio_custom_post_type', 0 );



/*
* Ajout des taxonomies (années, langages, framework)
*/

function portfolio_add_taxonomies() {
	
	// Taxonomie Année
	$labels_annee = array(
		'name'              			=> _x( 'Années', 'taxonomy general name'),
		'singular_name'     			=> _x( 'Année', 'taxonomy singular name'),
		'search_items'      			=> __( 'Chercher une année'),
		'all_items'        				=> __( 'Toutes les années'),
		'edit_item'         			=> __( 'Editer l année'),
		'update_item'       			=> __( 'Mettre à jour l année'),
		'add_new_item'     				=> __( 'Ajouter une nouvelle année'),
		'new_item_name'     			=> __( 'Valeur de la nouvelle année'),
		'separate_items_with_commas'	=> __( 'Séparer les années avec une virgule'),
		'menu_name'         => __( 'Année'),
	);

	$args_annee = array(
		'hierarchical'      => false,
		'labels'            => $labels_annee,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'annees' ),
	);

	register_taxonomy( 'annees', 'realisations', $args_annee );

	// Taxonomie langages
	$labels_langages = array(
		'name'                       => _x( 'Langages', 'taxonomy general name'),
		'singular_name'              => _x( 'Langage', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher un langage'),
		'popular_items'              => __( 'Langages populaires'),
		'all_items'                  => __( 'Tous les langages'),
		'edit_item'                  => __( 'Editer un Langages'),
		'update_item'                => __( 'Mettre à jour un langage'),
		'add_new_item'               => __( 'Ajouter un nouveau langage'),
		'new_item_name'              => __( 'Nom du nouveau langage'),
		'separate_items_with_commas' => __( 'Séparer les langages avec une virgule'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un langage'),
		'choose_from_most_used'      => __( 'Choisir parmi les langages plus utilisés'),
		'not_found'                  => __( 'Pas de langages trouvés'),
		'menu_name'                  => __( 'Langages'),
	);

	$args_langages = array(
		'hierarchical'          => false,
		'labels'                => $labels_langages,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'langages' ),
	);

	register_taxonomy( 'langages', 'realisations', $args_langages );
	
	// Framework utilisé pour le projet

	$labels_framework = array(
		'name'                       => _x( 'Frameworks', 'taxonomy general name'),
		'singular_name'              => _x( 'Framework', 'taxonomy singular name'),
		'search_items'               => __( 'Rechercher un framework'),
		'popular_items'              => __( 'Framework populaires'),
		'all_items'                  => __( 'Toutes les frameworks'),
		'edit_item'                  => __( 'Editer une framework'),
		'update_item'                => __( 'Mettre à jour un framework'),
		'add_new_item'               => __( 'Ajouter un nouveau framework'),
		'new_item_name'              => __( 'Nom du nouveau framework'),
		'add_or_remove_items'        => __( 'Ajouter ou supprimer un framework'),
		'choose_from_most_used'      => __( 'Choisir parmi les frameworks les plus utilisées'),
		'not_found'                  => __( 'Pas de frameworks trouvées'),
		'menu_name'                  => __( 'Frameworks'),
	);

	$args_framework = array(
		'hierarchical'          => true,
		'labels'                => $labels_framework,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'framework' ),
	);

	register_taxonomy( 'framework', 'realisations', $args_framework );
}

add_action( 'init', 'portfolio_add_taxonomies', 0 );



