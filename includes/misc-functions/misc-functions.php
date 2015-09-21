<?php 
/**
 * Misc Functions the MP Stacks + Passwords Add On
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks Passwords
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2015, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Start up the PHP session so we can store passwords in it.
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @see      wp_enqueue_script()
 * @see      wp_enqueue_style()
 * @return   void
 */
function mp_stacks_passwords() {
    if(!session_id()) {
        session_start();
    }
}
add_action('init', 'mp_stacks_passwords', 1);