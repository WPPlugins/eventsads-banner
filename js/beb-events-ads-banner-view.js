jQuery(document).ready(function($){
	var fmtPosizioneAttualeBannerR = $('#beb-eab-contenitore-banner').css('right');
	var beb_eab_url_tmp = $("#beb-eab-banner-bottone").attr("src");
	beb_eab_url_tmp = beb_eab_url_tmp.split('/');
	delete beb_eab_url_tmp [0];
	delete beb_eab_url_tmp [beb_eab_url_tmp.length-1];
	var beb_eab_url = beb_eab_url_tmp.join('/');
	beb_eab_url = 'http:' + beb_eab_url;
	
	if ('0px' === fmtPosizioneAttualeBannerR) {
		// Larghezza Testo
		fmtPosizioneAttualeBannerR = parseInt($('#beb-eab-banner-cont-testo').width()) + (parseInt($('#beb-eab-banner-cont-testo').css('padding-left')) * 2);
		// Larghezza Data
		//fmtPosizioneAttualeBannerR += parseInt($('#beb-eab-banner-data').width()) + 1;
		// Larghezza Immagine
		if ('nascondi' === $('#beb-eab-banner-immagine').attr('alt')){
			fmtPosizioneAttualeBannerR += parseInt($('#beb-eab-banner-immagine img').width()) + (parseInt($('#beb-eab-banner-immagine').css('margin-left')) * 2);
		}
		fmtPosizioneAttualeBannerR = (fmtPosizioneAttualeBannerR * -1) + 'px';
	}
	
	$('#beb-eab-banner-bottone').on('click', function (){
		if ($('#beb-eab-contenitore-banner').attr('title') === 'beb-eab-banner-aperto') {
			// Banner aperto --> lo chiudo
			$('#beb-eab-contenitore-banner').animate({
				'right': fmtPosizioneAttualeBannerR
				}, 500 );
			$('#beb-eab-banner-bottone').attr('src', beb_eab_url + 'freccia_sx.png');
			$('#beb-eab-contenitore-banner').attr('title', 'beb-eab-banner-chiuso');
		} else if ($('#beb-eab-contenitore-banner').attr('title') === 'beb-eab-banner-chiuso') {
			// Banner chiuso --> lo apro
			$('#beb-eab-contenitore-banner').animate({
				'right': 0
				}, 500 );
			$('#beb-eab-banner-bottone').attr('src', beb_eab_url + 'freccia_dx.png');
			$('#beb-eab-contenitore-banner').attr('title', 'beb-eab-banner-aperto');
		}
	});
});