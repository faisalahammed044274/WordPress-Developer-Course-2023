<?PHP

function u_enqueue(){
    wp_register_style(
        'u_font_rubik_and_pacifico', 
        'https://fonts.googleapis.com/css2?family=Pacifico&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap',
        [],
        null
    );
    wp_register_style(
        'u_bootstrap_icons', get_theme_file_uri('assets/bootstrap-icons/bootstrap-icons.css')
    );
    wp_register_style(
        'u_theme_css', get_theme_file_uri('assets/public/index.css'),
        
    );
    wp_enqueue_style('u_font_rubik_and_pacifico');
    wp_enqueue_style('u_bootstrap_icons');
    wp_enqueue_style('u_theme_css');


}