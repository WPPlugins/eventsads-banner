<?php
abstract class Beb_Events_Ads_Banner_Op_Com {
    protected static $riassunto_banner_mappa = array(
        'stato_banner', 'nome_evento', 'priorita', 'titolo', 'sottotitolo', 'data_evento_giorno',
        'data_evento_mese', 'descrizione'
    );
    protected static $wp_options_prefisso = 'beb_events_ads_banner_';
    protected static $prefisso_nome = 'beb-events-ads-banner';
    protected static $prefisso_nome_banner = 'events-ads-banner';
    protected $mappa_mese_numero;
    protected $mappa_mese_abr_mese;
    protected $banner;
    protected $contenuto = NULL;
    protected $impostazioni = NULL;
    protected $problemini = NULL;
    protected $url;
    protected $plugin_per_traduzioni = false;
    protected $is_admin = false;
    protected static $chiavi_da_escludere_da_traduzione = array('stato_banner', 'nome_evento', 'open', 'immagine_show');
    protected static $elenco_pagine = array(
    		'pagina_preview' => 'beb-eab-preview',
    		'pagina_add' => 'beb-eab-add-banner',
    		'pagina_settings' => 'beb-eab-settings',
    		'pagina_problemi' => 'beb-eab-issues'
    );
    protected static $contenuto_iniziale = array(
        0 => array(
            'banner_esempio' => true,
            'stato_banner' => 'on',
            'open' => 'home',
            'nome_evento' => 'Example 01',
            'priorita' => '0',
            'data_evento_giorno' => '01',
            'data_evento_mese' => '01',
            'titolo' => 'Lorem ipsum dolor sit a',
            'sottotitolo' => ' Lorem ipsum dolor sit amet, co',
            'descrizione' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim ',
            'link_sx_titolo' => 'Info',
            'link_sx' => '#',
            'link_dx_titolo' => 'Book',
            'link_dx' => '#'
        )
    );
    protected static $impostazioni_iniziali = array(
        'background-color' => array(
            'num_colori' => '2',
            'colore_1' => 'ff0000',
            'colore_2' => '000000'
        ),
        '.beb-eab-spazio-banner' => array(
            'opacity' => '0.8'
        ),
        '#beb-eab-banner-data h1' => array(
            'color' => 'ffffff',
            'font-size' => '32px',
        	'line-height' => '32px',
        	'text-align' => 'center'
        ),
        '#beb-eab-banner-data h2' => array(
            'color' => 'ffffff',
            'font-size' => '25px',
        	'line-height' => '25px',
            'text-align' => 'center'
        ),
        '#beb-eab-banner-testo h1' => array(
            'color' => 'ffffff',
            'font-size' => '25px',
        	'line-height' => '25px',
            'text-align' => 'center'
        ),
        '#beb-eab-banner-testo h2' => array(
            'color' => 'ffffff',
            'font-size' => '18px',
        	'line-height' => '18px',
            'text-align' => 'center'
        ),
        '#beb-eab-banner-testo p' => array(
            'color' => 'ffffff',
            'font-size' => '12px',
        	'line-height' => '12px',
            'text-align' => 'justify'
        ),
        '#beb-eab-banner-cont-prenota-sx' => array(
            'text-align' => 'center'
        ),
        '#beb-eab-banner-cont-prenota-sx a' => array(
            'font-size' => '14px',
            'font-weight' => 'bold',
        ),
    	'#beb-eab-banner-cont-prenota-sx, #beb-eab-banner-cont-prenota-sx a' => array(
    		'color' => 'ffffff',
    	),
        '#beb-eab-banner-cont-prenota-dx' => array(
            'text-align' => 'center'
        ),
        '#beb-eab-banner-cont-prenota-dx a' => array(
            'font-size' => '14px',
            'font-weight' => 'bold',
        ),
    	'#beb-eab-banner-cont-prenota-dx, #beb-eab-banner-cont-prenota-dx a' => array(
    		'color' => 'ffffff',
    	)
    );
    protected $wpdb = NULL;

    public function __construct() {
        // INIZIALIZZARE TUTTO CON IL CONTROLLO SE IL BANNER E' VISIBILE
        global $wpdb;
        if (!has_action('beb_events_ads_banner_traduci_banner')) {
            if (is_admin()) {
            	$this->is_admin = true;
                $dove = 'admin_init';
            } else {
                $dove = 'init';
            }
            add_action($dove, array($this, 'beb_events_ads_banner_traduci_banner'));
        }
        $this->mappa_mese_numero = array(
            __("January", self::$prefisso_nome) => '01',
            __("February", self::$prefisso_nome) => '02',
            __("March", self::$prefisso_nome) => '03',
            __("April", self::$prefisso_nome) => '04',
            __("May", self::$prefisso_nome) => '05',
            __("June", self::$prefisso_nome) => '06',
            __("July", self::$prefisso_nome) => '07',
            __("August", self::$prefisso_nome) => '08',
            __("September", self::$prefisso_nome) => '09',
            __("October", self::$prefisso_nome) => '10',
            __("November", self::$prefisso_nome) => '11',
            __("December", self::$prefisso_nome) => '12'
        );
        $this->mappa_mese_abr_mese = array(
            __("Jan", self::$prefisso_nome) => '01',
            __("Feb", self::$prefisso_nome) => '02',
            __("Mar", self::$prefisso_nome) => '03',
            __("Apr", self::$prefisso_nome) => '04',
            __("May", self::$prefisso_nome) => '05',
            __("Jun", self::$prefisso_nome) => '06',
            __("Jul", self::$prefisso_nome) => '07',
            __("Aug", self::$prefisso_nome) => '08',
            __("Sep", self::$prefisso_nome) => '09',
            __("Oct", self::$prefisso_nome) => '10',
            __("Nov", self::$prefisso_nome) => '11',
            __("Dec", self::$prefisso_nome) => '12'
        );
        $this->url = plugin_dir_url( __FILE__ );
        self::beb_events_ads_banner_carica_dati();
    }

    final public function beb_events_ads_banner_carica_dati () {
        if (is_admin()) {
            add_action('admin_menu', array($this, 'beb_events_ads_banner_carica_header'));
        } else {
            add_action('wp_head', array($this, 'beb_events_ads_banner_carica_header'));
        }
        if (isset($GLOBALS[self::$wp_options_prefisso.'contenuto']) and !empty($GLOBALS[self::$wp_options_prefisso.'contenuto'])) {
            $this->contenuto = $GLOBALS[self::$wp_options_prefisso.'contenuto'];
        } else {
            $this->contenuto = get_option(self::$wp_options_prefisso.'contenuto');
            if ($this->contenuto !== false and is_array($this->contenuto)) {
                $GLOBALS[self::$wp_options_prefisso.'contenuto'] = $this->contenuto;
            } else {
                if (is_admin()) {
                    $this->contenuto = self::$contenuto_iniziale;
                }
            }
        }
        if (isset($GLOBALS[self::$wp_options_prefisso.'impostazioni']) and !empty($GLOBALS[self::$wp_options_prefisso.'impostazioni'])) {
            $this->impostazioni = $GLOBALS[self::$wp_options_prefisso.'impostazioni'];
        } else {
            $this->impostazioni = get_option(self::$wp_options_prefisso.'impostazioni');
            if ($this->impostazioni !== false and is_array($this->impostazioni)) {
                $GLOBALS[self::$wp_options_prefisso.'impostazioni'] = $this->impostazioni;
            } else {
                if (is_admin()) {
                    $this->impostazioni = self::$impostazioni_iniziali;
                }
            }
        }
        if (isset($GLOBALS[self::$wp_options_prefisso.'problemini']) and !empty($GLOBALS[self::$wp_options_prefisso.'problemini'])) {
        	$this->problemini = $GLOBALS[self::$wp_options_prefisso.'problemini'];
        } else {
        	$this->problemini = get_option(self::$wp_options_prefisso.'problemini');
        	if ($this->problemini !== false and is_array($this->problemini)) {
        		$GLOBALS[self::$wp_options_prefisso.'problemini'] = $this->problemini;
        	}
        }
    }
    final public function beb_events_ads_banner_carica_header () {
        self::carica_header();
    }
    private function carica_header () {
        wp_register_style (self::$prefisso_nome.'-view.css', $this->url.'css/'.self::$prefisso_nome.'-view.css', array(), BEBCVBANNER_VERSION_CSS_VIEW);
        wp_enqueue_style (self::$prefisso_nome.'-view.css', false, array(), BEBCVBANNER_VERSION_CSS_VIEW);
    }

    final public function beb_events_ads_banner_traduci_banner () {
        self::beb_events_ads_banner_traduci_banner_operativo();
    }
    private function beb_events_ads_banner_traduci_banner_operativo () {
        load_plugin_textdomain(self::$prefisso_nome, false, dirname( plugin_basename( __FILE__ ) ).'/languages' );
    }
    final protected function beb_cv_banner ($contenuto = NULL, $visualizza = NULL) {
        if (!isset($contenuto)) {
            $contenuto = $this->contenuto;
        }
        $n_contenuti = count($contenuto);
        self::controlla_se_esiste_plugin_x_traduzioni();
        $mostra = false;
        if (is_user_logged_in()) {
        	if (isset($_GET['page']) and array_search($_GET['page'], self::$elenco_pagine) !== false) {
        		$mostra = true;
        	}elseif (is_admin_bar_showing() and (isset($this->problemini['compatibility_all_in_one_events_calendar']) and
        			$this->problemini['compatibility_all_in_one_events_calendar'] === 'no')) {
        		//Problema di compatibilita'� con "All in one event calendar"...vedi pagina "beb-eab-issues"
        		$mostra = true;
        	}
        }
        for ($i = 0; $i < $n_contenuti; $i++) {
            if (isset($contenuto[$i]['stato_banner']) and 'on' === $contenuto[$i]['stato_banner']) {
                $mostra = true;
            }
            if (true === $mostra) {
            	if (false !== $this->plugin_per_traduzioni) {
					foreach ($contenuto[$i] as $chiave_array => $contenuto_sing) {
						if (!is_numeric($contenuto_sing) and false === array_search($chiave_array, self::$chiavi_da_escludere_da_traduzione)) {
							if ('wpml' === $this->plugin_per_traduzioni) {
								$contenuto[$i][$chiave_array] = icl_translate(self::$prefisso_nome, 'EAB - '.$chiave_array, $contenuto_sing);
							} elseif ('polylang' === $this->plugin_per_traduzioni) {
								// Da aggiungere
							}
						}
	                }
            	}
                $larghezza_cont_banner = 465;
                $larghezza_banner = 380;
                $larghezza_data = 64;
                $margine_immagine = 20;
                if (isset($contenuto[$i]['data_evento_giorno'])) {
                    if ($contenuto[$i]['data_evento_giorno'] < 10 and strlen($contenuto[$i]['data_evento_giorno']) == 1) {
                        $contenuto[$i]['data_evento_giorno'] = '0'.$contenuto[$i]['data_evento_giorno'];
                    }
                    if ($contenuto[$i]['data_evento_mese'] < 10 and strlen($contenuto[$i]['data_evento_mese']) == 1) {
                        $contenuto[$i]['data_evento_mese'] = '0'.$contenuto[$i]['data_evento_mese'];
                    }
                    $larghezza_banner += $larghezza_data;
                }
                if (isset($contenuto[$i]['immagine'])) {
                    $dimensioni_imm = @getimagesize($contenuto[$i]['immagine']);
                    if ($dimensioni_imm[1] > 120) {
                        $larghezza_imm = (120 * $dimensioni_imm[0])/$dimensioni_imm[1];
                    } else {
                        $larghezza_imm = $dimensioni_imm[0];
                    }
                    $larghezza_imm = ceil($larghezza_imm); // margine immagine
                    $larghezza_banner += $larghezza_imm + $margine_immagine;
                    $larghezza_cont_banner += $larghezza_imm + 23;
                }
                $altezza_titolo = '25px';
                if (!isset($contenuto[$i]['sottotitolo']) and !isset($contenuto[$i]['descrizione'])) {
                    $margin_titolo = '46px 0 0';
                    $altezza_sottotitolo = 'auto';
                    $margin_sottotitolo = '0';
                    $altezza_descrizione = '13px';
                } elseif (isset($contenuto[$i]['sottotitolo']) and !isset($contenuto[$i]['descrizione'])) {
                    $margin_titolo = '33px 0 0 0';
                    $altezza_sottotitolo = '10px';
                    $margin_sottotitolo = '15px 0 0 0';
                } elseif (isset($contenuto[$i]['descrizione']) and !isset($contenuto[$i]['sottotitolo'])) {
                    $altezza_titolo = '30px';
                    $margin_titolo = 0;
                    $altezza_descrizione = '15px';
                } else {
                    $margin_titolo = 0;
                    $altezza_sottotitolo = '18px';
                    $margin_sottotitolo = 0;
                    $altezza_descrizione = '12px';
                }
                $apertura_banner_titolo = 'beb-eab-banner-aperto';
                $apertura_banner_posizione = 0;
                $imm_bottone_banner = 'img/freccia_dx.png';

                $chiudi_banner = false;
                if (isset($contenuto[$i]['open']) and !$this->is_admin) {
                    $url_protocollo_http = explode('/', $_SERVER["SERVER_PROTOCOL"]);
                    $url_protocollo_http = $url_protocollo_http[0];
                    $url_da_WP = get_site_url().'/';
                    $url_ricostruito = strtolower($url_protocollo_http).'://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];

                    if ('never' === $contenuto[$i]['open']) {
                        $chiudi_banner = true;
                    }
                    if ('home' === $contenuto[$i]['open'] and (is_home() or is_page('home'))) {
                        $chiudi_banner = true;
                    }
                    if ('home' === $contenuto[$i]['open'] and $url_da_WP !== $url_ricostruito) {
                        $chiudi_banner = true;
                    }
                    if(true === $chiudi_banner) {
                        $apertura_banner_titolo = 'beb-eab-banner-chiuso';
                        $apertura_banner_posizione -= $larghezza_banner;
                        $imm_bottone_banner = 'img/freccia_sx.png';
                        if (isset($contenuto[$i]['data_evento_giorno'])) {
                            //$apertura_banner_posizione -= 17;
                            $apertura_banner_posizione += $larghezza_data;
                        }
                        if (isset($contenuto[$i]['immagine'])) {
                            if ('show' === $contenuto[$i]['immagine_show']) {
                                $apertura_banner_posizione += $larghezza_imm + $margine_immagine;
                            }
                        }
                    }
                } ?>
                <style type="text/css">
                    <?php if(!$this->is_admin):?>
                        #beb-eab-contenitore-banner {
                            bottom: 60px;
                            height: 150px;
                            position: fixed;
                        	z-index: 99999;
                        }
                        #beb-eab-contenitore-banner .beb-eab-spazio-banner {
                            height: 150px;
                        }
                    <?php else:?>
                    	#beb-eab-contenitore-banner .beb-eab-spazio-banner {
                            height: 120px;
                        }
					<?php endif; ?>
                    <?php if (isset($larghezza_imm)): ?>
                        #beb-eab-banner-immagine img {
                        	width: <?php echo $larghezza_imm; ?>px;
                        }
                    <?php endif; ?>
                    .beb-eab-spazio-banner {
                    	<?php if ($this->impostazioni['background-color']['num_colori'] == 2): ?>
                    	    background: -webkit-linear-gradient(left, #<?php echo $this->impostazioni['background-color']['colore_1']; ?>, #<?php echo $this->impostazioni['background-color']['colore_2']; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);
                            background: -o-linear-gradient(right, #<?php echo $this->impostazioni['background-color']['colore_1']; ?>, #<?php echo $this->impostazioni['background-color']['colore_2']; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);
                            background: -moz-linear-gradient(right, #<?php echo $this->impostazioni['background-color']['colore_1']; ?>, #<?php echo $this->impostazioni['background-color']['colore_2']; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);
                            background: linear-gradient(to right, #<?php echo $this->impostazioni['background-color']['colore_1']; ?>, #<?php echo $this->impostazioni['background-color']['colore_2']; ?>) repeat scroll 0 0 rgba(0, 0, 0, 0);
                    	<?php else: ?>
                            background-color: #<?php echo $this->impostazioni['background-color']['colore_1']; ?>;
                        <?php endif; ?>
                        width: <?php echo $larghezza_banner; ?>px;
                    }
        	        .beb-eab-spazio-banner2 {
                        border-bottom: 75px solid transparent;
                        border-right: 60px solid #<?php echo $this->impostazioni['background-color']['colore_1']; ?>;
                        border-top: 75px solid transparent;
                    }
                    <?php foreach ($this->impostazioni as $id_class => $opzioni_arr) {
                        if ($id_class != 'beb_eab_display' and 'beb_eab_banner_imp_tempo' and 'background-color') {
                            echo "$id_class {";
                            if (is_array($opzioni_arr)) {
                                foreach ($opzioni_arr as $tipo => $valore) {
                                    if ($tipo === 'color') {
                                        echo "$tipo: #$valore;";
                                    } elseif ($tipo === 'font-size') {
                                        echo "$tipo: $valore;";
                                        echo "line-height: $valore;";
                                        echo "line-height: $valore;";
                                    } else {
                                        echo "$tipo: $valore;";
                                    }
                                }
                            }
                            echo "}\n";
                        }
                    } ?>
                    #beb-eab-banner-testo h1 {
                        margin: <?php echo $margin_titolo; ?>;
                    }
                    #beb-eab-banner-testo h2 {
                    	margin: <?php echo $margin_sottotitolo; ?>;
                    }
                    #beb-eab-banner-testo p {
                        height: calc(100% - <?php echo $this->impostazioni['#beb-eab-banner-testo h1']['font-size']; ?> -
                        <?php echo $this->impostazioni['#beb-eab-banner-testo h2']['font-size']; ?> - 6px);
                    	line-height: <?php echo $altezza_descrizione; ?>;
                    }
                </style>
                <div id="beb-eab-contenitore-banner" style="right: <?php echo $apertura_banner_posizione; ?>px;" title="<?php echo $apertura_banner_titolo; ?>"
                    <?php if ($this->is_admin and isset($larghezza_cont_banner)) { echo 'alt="'.$larghezza_cont_banner.'"'; } ?>>
                        <?php if (!$this->is_admin and (isset($contenuto[$i]['link_totale']) and 'si' === $contenuto[$i]['link_totale'])): ?>
                            <a href="<?php echo @$contenuto[$i]['link_sx']; ?>">
                        <?php endif;?>
                    		 <div class="beb-eab-spazio-banner">
                    		    <?php if (isset($contenuto[$i]['data_evento_giorno']) or $visualizza): ?>
                    				<div id="beb-eab-banner-data" alt="beb-eab-banner-data" <?php if (!isset($contenuto[$i]['data_evento_giorno'])) {
                                            echo 'style="display: none;"';}?>>
                    					<h1><?php echo @$contenuto[$i]['data_evento_giorno']; ?></h1>
                    					<h2><?php echo @array_search($contenuto[$i]['data_evento_mese'], $this->mappa_mese_abr_mese); ?></h2>
                    				</div>
                    			<?php endif; ?>
                    			<?php if (isset($contenuto[$i]['immagine']) or $visualizza): ?>
                    		        <div id="beb-eab-banner-immagine" <?php if (!isset($contenuto[$i]['immagine'])) {
                                            echo 'style="display: none;"';} if (isset($contenuto[$i]['immagine_show']) and
                                            'hide' === $contenuto[$i]['immagine_show']) { echo ' alt="nascondi" '; } ?>>
                    		            <img src="<?php echo @$contenuto[$i]['immagine']; ?>">
                    		        </div>
                    	        <?php endif; ?>
                    			<div id="beb-eab-banner-cont-testo">
                    				<div id="beb-eab-banner-testo">
                    					<h1><?php echo $contenuto[$i]['titolo']; ?></h1>
                    					<?php if (isset($contenuto[$i]['sottotitolo']) or $visualizza): ?>
                    					    <h2><?php echo @$contenuto[$i]['sottotitolo']; ?></h2>
                    					<?php endif; ?>
                    					<?php if (isset($contenuto[$i]['descrizione']) or $visualizza): ?>
                    					   <p><?php echo @$contenuto[$i]['descrizione']; ?></p>
                    					<?php endif; ?>
                    				</div>
                    				<?php if ((isset($contenuto[$i]['link_sx_titolo']) and isset($contenuto[$i]['link_dx_titolo'])) or
                    				    (isset($contenuto[$i]['link_sx_titolo']) or isset($contenuto[$i]['link_dx_titolo'])) or $visualizza): ?>
                        				<div id="beb-eab-banner-cont-prenota">
                        				    <?php if (isset($contenuto[$i]['link_sx_titolo']) or $visualizza): ?>
                        				        <div id="beb-eab-banner-cont-prenota-sx">
                        				            <a href="<?php echo ($this->is_admin ? 'http://#' : @$contenuto[$i]['link_sx']); ?> ">
                                                        <?php echo @$contenuto[$i]['link_sx_titolo']; ?>
                                                    </a>
                        				        </div>
                                            <?php endif; ?>
                                            <?php if (isset($contenuto[$i]['link_dx_titolo']) or $visualizza): ?>
                            					<div id="beb-eab-banner-cont-prenota-dx">
                            					    <a href="<?php echo ($this->is_admin ? 'http://#' : @$contenuto[$i]['link_dx']); ?>">
                            					       <?php echo @$contenuto[$i]['link_dx_titolo']; ?>
                            					    </a>
                            					</div>
                        					<?php endif; ?>
                        				</div>
                    				<?php endif; ?>
                    			</div>
                    		 </div>
                        <?php if (!$this->is_admin and (isset($contenuto[$i]['link_totale']) and 'si' === $contenuto[$i]['link_totale'])): ?>
                            </a>
                        <?php endif;?>
            		 <div class="beb-eab-spazio-banner2"></div>
            		 <div class="beb-eab-banner-freccia">
            	 		<img id="beb-eab-banner-bottone" src="<?php echo $this->url.$imm_bottone_banner; ?>" />
            		 </div>
                </div>
    <?php
            }
        }
	}

	private function controlla_se_esiste_plugin_x_traduzioni () {
		if(!is_admin()) {
			// FUNZIONI PRESE DA "wp-admin/includes/plugin.php" - VERSIONE WP 4.4.2
            if (function_exists('is_plugin_active') === false) {
                function is_plugin_active( $plugin ) {
                    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || is_plugin_active_for_network( $plugin );
                }
            }
			if (function_exists('is_plugin_active_for_network') === false) {
                function is_plugin_active_for_network( $plugin ) {
                    if ( !is_multisite() )
                        return false;

                    $plugins = get_site_option( 'active_sitewide_plugins');
                    if ( isset($plugins[$plugin]) )
                        return true;

                    return false;
                }
            }
		}


		if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
			$this->plugin_per_traduzioni = 'wpml';
		} elseif (is_plugin_active('polylang/polylang.php')) {
			$this->plugin_per_traduzioni = 'polylang';
		}
	}
}
?>