jQuery(function($){

	//make it work only if screen resolution is correct
	if(parseInt($(window).width()) >= 1240 || parseInt($(window).height()) >= 640){		

		$('#sidebar #sidebar-content audio').mediaelementplayer({
			
			startVolume: 0.20,		
			loop: false,
			features: ['playpause','volume','progress'],
			audioHeight: 80,
			audioWidth: 200,
			success: function (mediaElement, domObject) {
					mediaElement.addEventListener('ended', function (e) {
						//at the end of current track load and play the next
						var audio_src = $('.mejs-list li.current').next().attr('data-src');
						//if last item reached, go first again
						if(!audio_src){
							var audio_src = $('.mejs-list li:first').attr('data-src');
							$('.mejs-list li:first').addClass('current').siblings().removeClass('current');
						}else{			
							$('.mejs-list li.current').next().addClass('current').siblings().removeClass('current');
						}
						
						$('audio#mejs:first').each(function(){
							this.player.pause();
							this.player.setSrc(audio_src);
							this.player.play();
						});
						
						
						
		
						
					}, false);
					
				},
			keyActions: []
		});
		
		$('.audio-next').click(function() {         
				var audio_src = $('.mejs-list li.current').next().attr('data-src');
				//if last item reached, go first again
				if(!audio_src){
					var audio_src = $('.mejs-list li:first').attr('data-src');
					$('.mejs-list li:first').addClass('current').siblings().removeClass('current');
				}else{			
					$('.mejs-list li.current').next().addClass('current').siblings().removeClass('current');
				}
				
				$('audio#mejs:first').each(function(){
					this.player.pause();
					this.player.setSrc(audio_src);
					this.player.play();
				});
		});
		
		$('.audio-prev').click(function() {         
				var audio_src = $('.mejs-list li.current').prev().attr('data-src');
				//if first item reached, go first again
				if(!audio_src){
					var audio_src = $('.mejs-list li:last').attr('data-src');
					$('.mejs-list li:last').addClass('current').siblings().removeClass('current');
				}else{			
					$('.mejs-list li.current').prev().addClass('current').siblings().removeClass('current');
				}
				
				$('audio#mejs:first').each(function(){
					this.player.pause();
					this.player.setSrc(audio_src);
					this.player.play();
				});
		});
		
		$('.mejs-offscreen').text('');
		
	
	}
});