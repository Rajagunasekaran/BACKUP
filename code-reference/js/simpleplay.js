var YTdeferred = jQuery.Deferred();

window.onYouTubeIframeAPIReady = function() {
	YTdeferred.resolve(window.YT);
};

(function($) {

	$.ajaxSetup({
		cache: true
	});

	$.getScript("https://www.youtube.com/iframe_api")
		.done(function(script, textStatus) {});

	$.fn.simplePlayer = function() {

		var video = $(this),
			videoId = $(this).attr('data-video');

		var play = $('<div />', {
			'id': 'play_' + videoId,
			'class': 'play-btn',
			'data-video': videoId
		}).hide();

		var defaults = {
			autoplay: 1,
			autohide: 1,
			border: 0,
			wmode: 'opaque',
			enablejsapi: 1,
			modestbranding: 1,
			version: 3,
			hl: 'en_US',
			rel: 0,
			showinfo: 0,
			hd: 1,
			iv_load_policy: 3 // add origin
		};

		// onYouTubeIframeAPIReady

		YTdeferred.done(function(YT) {
			play.appendTo(video).fadeIn();
		});

		function onPlayerStateChange(event) {
			if (event.data == YT.PlayerState.ENDED) {
				play.fadeIn();
				video.children('iframe').hide();
				if (video.children('img').length) {
					video.children('img').fadeIn();
				} else if (video.children('.img')) {
					video.children('.img').fadeIn();
				}
			}
		}

		function onPlayerReady(event) {
			var replay = document.getElementsByClassName('play-btn');
			$.each(function(i, playBtn) {
				playBtn.addEventListener('click', function() {
					var playId = $(this).attr('data-video');
					if ($('#player_' + playId).length) {
						$('#player_' + playId).fadeIn();
					}
					player.playVideo();
				});
			})
		}

		play.bind('click', function() {
			var playId = $(this).attr('data-video');

			if ($('iframe[id*=player_]').length) {
				$.each($('.frame-video'), function(i, vID) {
					$(vID).children('iframe').remove();
					if ($(vID).children('img').length) {
						$(vID).children('img').fadeIn();
					} else if ($(vID).children('.img')) {
						$(vID).children('.img').fadeIn();
					}
					$(vID).children('.play-btn').fadeIn();
				});
			}

			if (!$('#player_' + playId).length) {

				$('<iframe />', {
						id: 'player_' + playId,
						src: 'https://www.youtube.com/embed/' + video.data('video') + '?' + $.param(defaults)
					})
					.attr({
						width: video.width(),
						height: video.height(),
						seamless: 'seamless'
					})
					.css('border', 'none')
					.appendTo(video).fadeIn();

				if (video.children('img').length) {
					video.children('img').fadeOut();
				} else if (video.children('.img')) {
					video.children('.img').fadeOut();
				}
				$(this).fadeOut();

				player = new YT.Player('player_' + playId, {
					events: {
						'onStateChange': onPlayerStateChange,
						'onReady': onPlayerReady
					}
				});
			}

			$(this).fadeOut();
		});

		return this;
	};
}(jQuery));