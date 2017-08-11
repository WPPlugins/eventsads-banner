jQuery(document).ready(function($){
	var mappa_associativa_imp_banner_size = {
			'beb-eab-banner-data-giorno-size': '#beb-eab-banner-data h1',
			'beb-eab-banner-data-mese-size': '#beb-eab-banner-data h2',
			'beb-eab-banner-titolo-size': '#beb-eab-banner-testo h1',
			'beb-eab-banner-sottotitolo-size': '#beb-eab-banner-testo h2',
			'beb-eab-banner-description-size': '#beb-eab-banner-testo p',
			'beb-eab-banner-left-link-size': '#beb-eab-banner-cont-prenota-sx a',
			'beb-eab-banner-right-link-size': '#beb-eab-banner-cont-prenota-dx a'
	};
	var fmtRiferimentoAlt;
	var fmtColoreScelto;
	
	$('.beb-eab-contenitore-admin.beb-eab-imp-colori input').each(function(){
		$(this).next().css('background-color', '#' + $(this).val());
	});
	
	$('.beb-eab-contenitore-admin.beb-eab-imp-colori input[type="text"]').keyup(function(){
		fmtRiferimentoAlt = $(this).attr('alt');
		fmtColoreScelto = $(this).val();
		// ------------------------------------------- COLORE DIV -------------------------------------------------
		$(this).next().css('background-color', '#' + fmtColoreScelto);
		if ('beb-eab-banner-opacita' === fmtRiferimentoAlt) {
			// ------------------------------------------- OPACITA BANNER ---------------------------------------------
			$('.beb-eab-spazio-banner, .beb-eab-spazio-banner2, .beb-eab-banner-freccia').css('opacity', fmtColoreScelto);
		} else if (fmtRiferimentoAlt === 'beb-eab-spazio-banner 1' || 'beb-eab-spazio-banner 2') {
			// ------------------------------------------- SCELTA 1 O 2 COLORI ------------------------------------------------- 
			if ('1' == $('.beb-eab-contenitore-admin.beb-eab-imp-colori input[type="radio"]:checked').val()) {
				//$('.fmt-eab-riga.colore2').hide(500);
				$('.beb-eab-spazio-banner').css({'background': 'none', 'background-color': '#' + fmtColoreScelto});
				$('.beb-eab-spazio-banner2').css('border-right-color', '#' + fmtColoreScelto);
			} else if ('2' == $('.beb-eab-contenitore-admin.beb-eab-imp-colori input[type="radio"]:checked').val()) {
				var beb_eab_colore1 = '#' + $('input[name="beb_eab_banner_settings[background-color][colore_1]"]').val();
				var beb_eab_colore2 = '#' + $('input[name="beb_eab_banner_settings[background-color][colore_2]"]').val();
				//$('.fmt-eab-riga.colore2').show(500);
				$('.beb-eab-spazio-banner').css({
				    'background': 'rgba(0, 0, 0, 0) -webkit-linear-gradient(right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0', 
	                'background': 'rgba(0, 0, 0, 0) -o-linear-gradient(right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0',
	                'background': 'rgba(0, 0, 0, 0) -moz-linear-gradient(right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0',
	                'background': 'rgba(0, 0, 0, 0) linear-gradient(to right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0'
				});
				$('.beb-eab-spazio-banner2').css('border-right-color', '#' + beb_eab_colore1);
			}
		} else {
			// ------------------------------------------- COLORE TESTO BANNER ----------------------------------------
			$('#' + fmtRiferimentoAlt).css('color', '#' + fmtColoreScelto);
		}
	});
	// ------------------------------------------- SCELTA 1 O 2 COLORI -------------------------------------------------
	var beb_eab_colore1 = $('input[name="beb_eab_banner_settings[background-color][colore_1]"]').val();
	var beb_eab_colore2 = $('input[name="beb_eab_banner_settings[background-color][colore_2]"]').val();
	$('.beb-eab-contenitore-admin.beb-eab-imp-colori input[type="radio"]').click(function() {
		if ($(this).val() == '1') {
			$('.fmt-eab-riga.colore2').hide(500);
			$('.beb-eab-spazio-banner').css({'background': 'none', 'background-color': '#' + beb_eab_colore1});
			$('.beb-eab-spazio-banner2').css('border-right-color', '#' + beb_eab_colore1);
		} else if ($(this).val() == '2') {
			$('.fmt-eab-riga.colore2').show(500);
			$('.beb-eab-spazio-banner').css({
			    'background': 'rgba(0, 0, 0, 0) -webkit-linear-gradient(right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0', 
                'background': 'rgba(0, 0, 0, 0) -o-linear-gradient(right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0',
                'background': 'rgba(0, 0, 0, 0) -moz-linear-gradient(right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0',
                'background': 'rgba(0, 0, 0, 0) linear-gradient(to right, #' + beb_eab_colore1 + ', #' + beb_eab_colore2 + ') repeat scroll 0 0'
			});
			$('.beb-eab-spazio-banner2').css('border-right-color', '#' + beb_eab_colore1);
		}
	});
	// ------------------------------------------- DIMENSIONE FONT -------------------------------------------------
	$('.beb-eab-contenitore-admin.beb-eab-imp-formattazione input[type="text"]').keyup(function(){
		$(mappa_associativa_imp_banner_size[$(this).attr('alt')]).css('font-size', $(this).val());
	});
	// ------------------------------------------- Formatting Text and Paragraph -------------------------------------------------
	var mappa_associativa_imp_banner_align = {
			'beb-eab-banner-data-giorno-align': '#beb-eab-banner-data h1',
			'beb-eab-banner-data-mese-align': '#beb-eab-banner-data h2',
			'beb-eab-banner-titolo-align': '#beb-eab-banner-testo h1',
			'beb-eab-banner-sottotitolo-align': '#beb-eab-banner-testo h2',
			'beb-eab-banner-description-align': '#beb-eab-banner-testo p',
			'beb-eab-banner-left-link-align': '#beb-eab-banner-cont-prenota #beb-eab-banner-cont-prenota-sx',
			'beb-eab-banner-right-link-align': '#beb-eab-banner-cont-prenota #beb-eab-banner-cont-prenota-dx'
	};
	$('.beb-eab-contenitore-admin.beb-eab-imp-formattazione input[type="radio"]').click(function() {
		$(mappa_associativa_imp_banner_align[$(this).attr('alt')]).css('text-align', $(this).val());
	});
});