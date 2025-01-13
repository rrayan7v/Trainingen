<?php
/**
 * Plugin Name: Quote of the Day
 * Plugin URI: https://yourwebsite.com
 * Description: Een eenvoudige WordPress-plugin die een willekeurige quote toont via een shortcode.
 * Version: 1.0.0
 * Author: [Jouw Naam]
 * Author URI: https://yourwebsite.com
 */

// Voorkom directe toegang.
if (!defined('ABSPATH')) {
    exit;
}

// Quotes array (alternatief: JSON-bestand laden).
function get_quotes() {
    return [
        "The only limit to our realization of tomorrow is our doubts of today.",
        "Do what you can, with what you have, where you are.",
        "Success is not the key to happiness. Happiness is the key to success.",
        "In the middle of every difficulty lies opportunity.",
        "What lies behind us and what lies before us are tiny matters compared to what lies within us.",
        "Life is 10% what happens to us and 90% how we react to it.",
        "Don’t watch the clock; do what it does. Keep going.",
        "The future depends on what you do today.",
        "The best way to predict the future is to create it.",
        "Believe you can and you’re halfway there."
    ];
}

// Willekeurige quote ophalen.
function get_random_quote() {
    $quotes = get_quotes();
    return $quotes[array_rand($quotes)];
}

// Shortcode implementatie.
function quote_of_the_day_shortcode() {
    $quote = get_random_quote();
    return "<div class='quote-of-the-day'>" . esc_html($quote) . "</div>";
}
add_shortcode('quote_of_the_day', 'quote_of_the_day_shortcode');

// Stijlen toevoegen.
function quote_of_the_day_styles() {
    echo "<style>
        .quote-of-the-day {
            font-size: 1.5em;
            color: #333;
            padding: 10px;
            margin: 20px 0;
            border-left: 4px solid #0073aa;
            background: #f9f9f9;
        }
    </style>";
}
add_action('wp_head', 'quote_of_the_day_styles');
