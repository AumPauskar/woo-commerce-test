<?php
/*
Plugin Name: Random Joke Fetcher part 2
Description: Fetches a random joke from an external API and displays it in the admin dashboard.
Version: 1.0
Author: Aum
*/

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu
function rjf_add_admin_menu() {
    add_menu_page('Random Joke', 'Random Joke', 'manage_options', 'random-joke', 'rjf_render_admin_page', 'dashicons-smiley');
}
add_action('admin_menu', 'rjf_add_admin_menu');

// Fetch joke from API
function rjf_fetch_joke() {
    $response = wp_remote_get('https://official-joke-api.appspot.com/random_joke');
    if (is_wp_error($response)) {
        return 'Failed to fetch joke.';
    }
    $body = wp_remote_retrieve_body($response);
    $joke = json_decode($body, true);
    if (!$joke) {
        return 'Invalid joke response.';
    }
    return '<strong>' . esc_html($joke['setup']) . '</strong><br>' . esc_html($joke['punchline']);
}

// Render admin page
function rjf_render_admin_page() {
    ?>
    <div class="wrap">
        <h1>Random Joke</h1>
        <div id="joke-container">
            <?php echo rjf_fetch_joke(); ?>
        </div>
        <br>
        <button id="refresh-joke" class="button button-primary">Refresh</button>
    </div>
    <script>
    document.getElementById('refresh-joke').addEventListener('click', function() {
        fetch('<?php echo admin_url('admin-ajax.php?action=rjf_get_joke'); ?>')
            .then(response => response.text())
            .then(joke => {
                document.getElementById('joke-container').innerHTML = joke;
            });
    });
    </script>
    <?php
}

// AJAX handler
function rjf_ajax_get_joke() {
    echo rjf_fetch_joke();
    wp_die();
}
add_action('wp_ajax_rjf_get_joke', 'rjf_ajax_get_joke');
