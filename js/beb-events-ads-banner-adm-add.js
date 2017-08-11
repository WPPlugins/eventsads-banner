jQuery(document).ready(function($){
	// ------------------------------------------ VARIABILI E FUNZIONI ----------------------------------------- 
	var largSpazioBannerOriginale = parseInt($('.beb-eab-spazio-banner').width());
	var fmtEabDataLarg = parseInt(0);
	var fmtEabImmLarg = parseInt(0);
	var fmtEabImmMarg = parseInt($('#beb-eab-banner-immagine').css('margin-left')*2);
	var largContTestoOriginale = parseInt($('#beb-eab-banner-cont-testo').width()) + (parseInt($('#beb-eab-banner-cont-testo').css('padding-left')) * 2);
	
	function fmtFaiSparireImmagine () {
		$('.beb-eab-spazio-banner').animate({'width': largSpazioBannerOriginale + 'px'}, 1000);
		$('#beb-eab-banner-immagine').hide(500);
		
	}
	 // Controlla se � stata inserita anche la data o l'immagine, da usare quando viene inserita una delle due cose
	 // e si vuole virificare se c'� anche l'altra.
	var dimensioneInizialeBanner = largContTestoOriginale;
	if ('none' !== $('#beb-eab-banner-data').css('display') && '' !== $('#beb-eab-banner-data > h1').text()) {
		dimensioneInizialeBanner += (parseInt($('#beb-eab-banner-data').width()) + 1);
	}
	if ('none' !== $('#beb-eab-banner-immagine').css('display') && '' !== $('#beb-eab-banner-immagine > img').attr('src') ) {
		dimensioneInizialeBanner += (parseInt($('#beb-eab-banner-immagine').width()) + fmtEabImmMarg);
	}
	$('.beb-eab-spazio-banner').width(dimensioneInizialeBanner);
	// ----------------------------------- PULSANTE ON/OFF STATO BANNER ---------------------------------------- 
	var fmt_eab_url_tmp = $("#beb-eab-banner-bottone").attr("src");
	fmt_eab_url_tmp = fmt_eab_url_tmp.split('/');
	var fmt_eab_dominio = fmt_eab_url_tmp [0] + '//' + fmt_eab_url_tmp [2] + '/';
	if (fmt_eab_url_tmp [2] == 'localhost') {
		fmt_eab_dominio = fmt_eab_dominio + fmt_eab_url_tmp [3] + '/';
	}
	delete fmt_eab_url_tmp [0];
	delete fmt_eab_url_tmp [fmt_eab_url_tmp.length-1];
	var fmt_eab_url = fmt_eab_url_tmp.join('/');
	
	fmt_eab_url = 'http:' + fmt_eab_url;
	
	$('.eab-interruttore-banner').mouseover(function() {
		$(this).css('background-image', 'url("' + fmt_eab_url + 'on_off.png")');
	}).mouseout(function() {
		$(this).css('background-image', 'url(' + fmt_eab_url + $(this).children('input[name="fmt_eab_banner_new[stato_banner]"]').val() + '.png)');
	});
	$('.eab-interruttore-banner').click(function(){
		if ($(this).children('input[name="fmt_eab_banner_new[stato_banner]"]').val() === 'on') {
			$(this).children('input[name="fmt_eab_banner_new[stato_banner]"]').val('off');
			$(this).css('background-image', 'url("' + fmt_eab_url + 'off.png")');
		} else if ($(this).children('input[name="fmt_eab_banner_new[stato_banner]"]').val() === 'off') {
			$(this).children('input[name="fmt_eab_banner_new[stato_banner]"]').val('on');
			$(this).css('background-image', 'url("' + fmt_eab_url + 'on.png")');
		}
	});
	// ------------------------- DATA --------------------- //
	var fmt_eab_larg_data = parseInt($('#beb-eab-banner-data').width()) + 1;		// 1 � il bordo destro
	var fmtNomeMese;
	
	$('.beb-eab-contenitore-admin form select').each(function(element) {
		 // Impostazioni iniziali
		if ($('#beb-eab-giorno option:selected').val() == '' && $('#beb-eab-mese option:selected').val() == '') {
			$('#beb-eab-banner-data').css('display', 'none');
			fmtEabDataLarg = parseInt(0);
		} else {
			$('#beb-eab-banner-data').css('display', 'inline');
			fmtNomeMese = $('select#' + $('#beb-eab-mese').attr('id') + ' option[value="' + $('#beb-eab-mese').val() + '"]').text();
			$('#beb-eab-banner-data h1').text($('#beb-eab-giorno').val());
			$('#beb-eab-banner-data h2').text(fmtNomeMese.substring(0, 3));
			fmtEabDataLarg = fmt_eab_larg_data;
		}
		// Animazione inserimento
		$(this).change(function() {
			fmtNomeMese = $('#beb-eab-mese').children('option:selected').text();
			$('#beb-eab-banner-data h1').text($('#beb-eab-giorno').val());
			$('#beb-eab-banner-data h2').text(fmtNomeMese.substring(0, 3));
			
			if ($('#beb-eab-banner-data').css('display') == 'none') {
				$('.beb-eab-spazio-banner').animate({'width': (largContTestoOriginale + fmt_eab_larg_data + fmtEabImmLarg) + 'px'}, 500, function(){
					$('#beb-eab-banner-data').show(400);
				});
				fmtEabDataLarg = fmt_eab_larg_data;
			}
			if ($('#beb-eab-giorno option:selected').val() == '' && $('#beb-eab-mese option:selected').val() == '') {
				if ($('#beb-eab-banner-data').css('display') == 'inline' || $('#beb-eab-banner-data').css('display') == 'block') {
					$('#beb-eab-banner-data').hide(400, function(){
						$('.beb-eab-spazio-banner').animate({'width': (largContTestoOriginale + fmtEabImmLarg) + 'px'}, 500);
					});
					fmtEabDataLarg = parseInt(0);
				}
			}
		});
	});
	// ----------TESTI: TITOLO, SOTTOTITOLO, DESCRIZIONE, LINK SX E LINK DX ----------------------
	var fmt_eab_mappa_form_prev_testi = {
			'beb-eab-titolo': {
				'gancio': '#beb-eab-banner-testo h1',
				'numCaratteri': parseInt($('#beb-eab-titolo').next().children('.beb-eab-add-banner-numeri').text())
			},
			'beb-eab-sottotitolo': {
				'gancio': '#beb-eab-banner-testo h2',
				'numCaratteri': parseInt($('#beb-eab-sottotitolo').next().children('.beb-eab-add-banner-numeri').text())
			},
			'beb-eab-descrizione': {
				'gancio': '#beb-eab-banner-testo p',
				'numCaratteri': parseInt($('#beb-eab-descrizione').next().children('.beb-eab-add-banner-numeri').text())
			},
			'beb-eab-link-sx-titolo': {
				'gancio': '#beb-eab-banner-cont-prenota-sx',
				'numCaratteri': parseInt($('#beb-eab-link-sx-titolo').next().children('.beb-eab-add-banner-numeri').text())
			},
			'beb-eab-link-dx-titolo': {
				'gancio': '#beb-eab-banner-cont-prenota-dx',
				'numCaratteri': parseInt($('#beb-eab-link-dx-titolo').next().children('.beb-eab-add-banner-numeri').text())
			},
			'numTestiScritti': ''
	};
	var fmtEabLungTesto;
	var fmt_eab_id_input;
	var fmtEabMmappaCheckMargin = {
		'input-0': 'beb-eab-titolo',
		'input-1': 'beb-eab-sottotitolo',
		'input-2': 'beb-eab-descrizione',
		'numTestiScritti': 0,
		'titolo': true,
		'sottotitolo': true,
		'descrizione': true
	};
	var fmt_eab_testo;
	var fmtEabMargine;
	
	$('.beb-eab-contenitore-admin form .fmt-banner-testi').each(function(element) {
		fmt_eab_id_input = $(this).attr('id');
		if ($(this).val() !== '' || 'undefined') {
			$(fmt_eab_mappa_form_prev_testi[fmt_eab_id_input]['gancio']).text($(this).val());
		}
		$(this).keyup(function() {
			fmtEabLungTesto = fmt_eab_mappa_form_prev_testi[$(this).attr('id')]['numCaratteri'] - parseInt($(this).val().length);
			fmt_eab_testo = $(this).val();
			if ((fmtEabLungTesto) <= 5) {
				$(this).next().children('.beb-eab-add-banner-numeri').css('color', '#ff0000');
			} else {
				$(this).next().children('.beb-eab-add-banner-numeri').css('color', '#0000ff');
			}
			if ($(this).attr('id') === 'beb-eab-link-sx-titolo' || 'beb-eab-link-dx-titolo') {
				if (fmt_eab_testo === '') {
					$(this).parent().parent().next('.fmt-eab-riga.nascondi-riga').hide(500);
				} else {
					$(this).parent().parent().next('.fmt-eab-riga.nascondi-riga').show(500);
				}
			}
			$(this).next().children('.beb-eab-add-banner-numeri').text(fmtEabLungTesto);
			$(fmt_eab_mappa_form_prev_testi[$(this).attr('id')]['gancio']).text(fmt_eab_testo);
			// Se impostato il sottotitolo, sistemo meglio il testo
			if ('' !== $('#beb-eab-titolo').val() && true === fmtEabMmappaCheckMargin['titolo']) {
				fmtEabMmappaCheckMargin['numTestiScritti']++;
				fmtEabMmappaCheckMargin['titolo'] = false;
			} else if ('' === $('#beb-eab-titolo').val() && false === fmtEabMmappaCheckMargin['titolo']) {
				if (fmtEabMmappaCheckMargin['numTestiScritti'] > 0){
					fmtEabMmappaCheckMargin['numTestiScritti']--;
					fmtEabMmappaCheckMargin['titolo'] = true;
				}
			}
			if ('' !== $('#beb-eab-sottotitolo').val() && true === fmtEabMmappaCheckMargin['sottotitolo']) {
				fmtEabMmappaCheckMargin['numTestiScritti']++;
				fmtEabMmappaCheckMargin['sottotitolo'] = false;
			} else if ('' === $('#beb-eab-sottotitolo').val() && false === fmtEabMmappaCheckMargin['sottotitolo']) {
				if (fmtEabMmappaCheckMargin['numTestiScritti'] > 0){
					fmtEabMmappaCheckMargin['numTestiScritti']--;
					fmtEabMmappaCheckMargin['sottotitolo'] = true;
				}
			}
			if ('' !== $('#beb-eab-descrizione').val() && true === fmtEabMmappaCheckMargin['descrizione']) {
				fmtEabMmappaCheckMargin['numTestiScritti']++;
				fmtEabMmappaCheckMargin['descrizione'] = false;
			} else if ('' === $('#beb-eab-descrizione').val() && false === fmtEabMmappaCheckMargin['descrizione']) {
				if (fmtEabMmappaCheckMargin['numTestiScritti'] > 0){
					fmtEabMmappaCheckMargin['numTestiScritti']--;
					fmtEabMmappaCheckMargin['descrizione'] = true;
				}
			}
			switch (fmtEabMmappaCheckMargin['numTestiScritti']) {
			case 0:
				fmtEabMargine = 0;
				break;
			case 1:
				fmtEabMargine = 46;
				break;
			case 2:
				fmtEabMargine = 35;
				break;
			case 3:
				fmtEabMargine = 0;
				break;

			default:
				break;
			}
			$('#beb-eab-banner-testo h1').animate({'margin': fmtEabMargine + 'px 0 0'}, 500);
		});
	});
	
	// ------------------------------------------ SELEZIONE/ESCLUSIONE DEI LINK -------------------------------------------
	$('#beb-eab-link-totale').click(function (){
		if (0 === $( '#beb-eab-link-totale:checked' ).length) {
			// Nascondo il Link Sx
			$(this).parent().parent().next().next().hide(500, function () {
				// Mostro il Titolo Sx
				$(this).prev().show(500);
				// Mostro il Titolo Dx
				$(this).next().show(500);
			});
		} else {
			// Nascondo la riga del Titolo Sx nella pagina delle impostazioni
			$(this).parent().parent().next().hide(500, function () {
				// Faccio apparire la sezione del link sx nella pagina delle impostazioni
				$(this).next().show(500);
				// Cancello contenuto del Titolo sx nella pagina delle impostazioni
				$(this).children('.fmt-eab-riga-c').children('input').val('');
				// Cancello contenuto del Titolo Dx nella pagina delle impostazioni
				$(this).next().next().children('.fmt-eab-riga-c').children('input').val('');
				// Cancello contenuto del Link dx nella pagina delle impostazioni
				$(this).next().next().next().children('.fmt-eab-riga-c').children('input').val('');
			});
			// Nascondo la riga del Titolo Dx nella pagina delle impostazioni
			$(this).parent().parent().next().next().next().hide(500);
			// Nascondo la riga del Link Dx nella pagina delle impostazioni
			$(this).parent().parent().next().next().next().next().hide(500);
			// Cancello dal banner il contenuto di tutta la riga dei link
			$('#beb-eab-banner-cont-prenota-sx, #beb-eab-banner-cont-prenota-dx').text('');
		}
	});
	// ------------------------------------------------ IMMAGINE --------------------------------------------------
	$("#beb-eab-banner-immagine").next().next('.beb-eab-add-banner-media').show();
	 // Apre automaticamente la finestra con la galleria delle immagini
	if ('' !== $('#beb-eab-immagine').val()) {
		$( ".contenitore-input.beb-eab-add-options-el" ).css('float', 'left');
		$( ".contenitore-input.beb-eab-add-texts-el, .contenitore-input.beb-eab-add-options-el" ).css({
			'top': '0',
			'left': '0px',
			'margin': '250px 0 0 1%'});
		$( ".contenitore-input.beb-eab-add-links-el" ).css({'top': '-240px', 'left': '0px'});	
		$( ".contenitore-input.beb-eab-add-media-el" ).css({'top': '0', 'margin': '1% 0'});
	} else {
		$('#beb-eab-immagine').one('focus', function(){
			var fmt_width = (screen.width*70)/100;
			var left_window = (screen.width*15)/100;
			var fmt_height = (screen.availHeight*60)/100;
			var top_window = (screen.availHeight*20)/100;
			window.open(fmt_eab_dominio + 'wp-admin/upload.php', '_blank', 'width=' + fmt_width + ', height=' + fmt_height +
					', left=' + left_window + ', top=' + top_window + 'toolbar=no, scrollbars=yes, resizable=yes');
		});
	}
	// Inserisce l'immagine nel banner
	var fmt_contatore_eventi = false;
	var fmtEabImmagine = new Image();
	
	$('#beb-eab-immagine').keyup(function() {
		var fmt_eab_imm_larg;
		var fmt_eab_imm_altezza;
		fmtEabImmagine.src = $(this).val();
		fmt_eab_imm_larg = Math.round(parseInt(fmtEabImmagine.width));
		fmt_eab_imm_altezza = Math.round(parseInt(fmtEabImmagine.height));
		
		if ('' === $(this).val()) {
			$(this).next().next('.beb-eab-add-banner-media').hide(500);
			$(this).next().next('.beb-eab-add-banner-media').next().hide(500);
			if (true === fmt_contatore_eventi) {
				$('#beb-eab-banner-immagine').hide(500, function() {
					$('.beb-eab-spazio-banner').animate({'width': (largSpazioBannerOriginale + fmtEabDataLarg) + 'px'}, 1000);
				});
				fmt_contatore_eventi = false;
				fmtEabImmLarg = parseInt(0);
			}
		} else {
			var fmtLinkErrato = false;

			if (false === fmt_contatore_eventi) {
				$(this).next().next('.beb-eab-add-banner-media').show(500);
				$(this).next().next('.beb-eab-add-banner-media').next().show(500);
				$("#beb-eab-banner-immagine img").error(function (){
					alert ('Il link inserito non e\' corretto');
					fmtLinkErrato = true;
				}).attr('src', fmtEabImmagine.src);
				if (false === fmtLinkErrato) {
					if (fmt_eab_imm_altezza > 120) {
						fmt_eab_imm_larg = Math.round(((120*fmt_eab_imm_larg)/fmt_eab_imm_altezza) + fmtEabImmMarg);
					} else {
						fmt_eab_imm_larg = fmt_eab_imm_larg + 40;
					}
					$('.beb-eab-spazio-banner').animate({'width': (largSpazioBannerOriginale + fmtEabDataLarg + fmt_eab_imm_larg) + 'px'}, 1000, function() {
						$('#beb-eab-banner-immagine').show(500);					
					});
					fmt_contatore_eventi = true;
					fmtEabImmLarg = fmt_eab_imm_larg;
				}
			}
		}
	});
});