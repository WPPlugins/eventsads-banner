<?php
/**
 * @package BeBEventsAdsBanner
 */
/*
Plugin Name: Events Ads Banner
Plugin URI: https://wordpress.org/plugins/eventsads-banner/
Description: A simple banner to show advertising, comunications, events and more. Very simple to use and to customize ! Try it !!!
Version: 1.4.8
Author: Fabio Maria Torrini
Author URI: http://dalet-group.com/events-ads-banner/
Network: http://dalet-group.com/events-ads-banner/
Contact: Forum
Contact URI: http://dalet-group.com/en/forums/forum/events-ads-banner/

Text Domain: beb-events-ads-banner
Domain Path: /languages/

Copyright 2014  BeB Digital Architecture - Fabio Maria Torrini  (info@dalet-group.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'La funzione richiesta NON esiste !';
	exit;
}
define( 'BEBCVBANNER_VERSION', '1.4.8' );

define( 'BEBCVBANNER_VERSION_CSS_ADM', '1.2.1' );
define( 'BEBCVBANNER_VERSION_CSS_ADM_ADD', '1.2.0' );
define( 'BEBCVBANNER_VERSION_CSS_ADM_PREV', '1.2.0' );
define( 'BEBCVBANNER_VERSION_CSS_ADM_SET', '1.2.0' );
define( 'BEBCVBANNER_VERSION_CSS_VIEW', '1.2.1' );

define( 'BEBCVBANNER_VERSION_JS_ADM', '1.0.0' );
define( 'BEBCVBANNER_VERSION_JS_ADM_ADD', '1.2.1' );
define( 'BEBCVBANNER_VERSION_JS_ADM_PREV', '1.2.0' );
define( 'BEBCVBANNER_VERSION_JS_ADM_SET', '1.2.0' );
define( 'BEBCVBANNER_VERSION_JS_VIEW', '1.2.0' );

define( 'BEBCVBANNER__MINIMUM_WP_VERSION', '3.1' );
define( 'BEBCVBANNER__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BEBCVBANNER__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BEBCVBANNER_DELETE_LIMIT', 100000 );
define ('BEBCVBANNER_ANCORA_TRAD', 'Beb_Events_Ads_Banner_View');

// carico i files di lingua - traduzioni
if (is_admin()) {
	if (!class_exists('Beb_Events_Ads_Banner_Adm')) {
        if (!@include_once(BEBCVBANNER__PLUGIN_DIR.'class-beb-events-ads-banner-adm.php')) {
            exit ('<p><strong>ERRORE</strong> - cod. 0101 - Ci scusiamo tanto,e\' stato riscontrato un problema nel caricamento di alcuni file.
            Prego contattare lo sviluppatore</p>');
        }
        register_activation_hook (__FILE__, array('Beb_Events_Ads_Banner_Adm', 'beb_eab_adm_attivazione_plugin'));
        register_deactivation_hook(__FILE__, array('Beb_Events_Ads_Banner_Adm', 'beb_eab_adm_disattivazione_plugin'));
	    $aggiorna_stato = NULL;
	    if (isset($_POST['beb_events_ads_banner_contenuto']['banner_id_array'])) {
	        $aggiorna_stato = $_POST['beb_events_ads_banner_contenuto'];
	    }
        $beb_eab_pannello_amministrazione = new Beb_Events_Ads_Banner_Adm($aggiorna_stato);
    }
	//include_once 'my_setting_page.php';
} elseif ('wp-login.php' !== $GLOBALS['pagenow'] and !wp_is_mobile()) {
    if (!class_exists('Beb_Events_Ads_Banner_View')) {
        if (!@include_once(BEBCVBANNER__PLUGIN_DIR.'class-beb-events-ads-banner-view.php')) {
            exit ('<p><strong>ERRORE</strong> - cod. 0102 - Ci scusiamo tanto,e\' stato riscontrato un problema nel caricamento di alcuni file.
                Prego contattare lo sviluppatore</p>');
        }
        $beb_eab_banner = new Beb_Events_Ads_Banner_View();
    }
}
?>