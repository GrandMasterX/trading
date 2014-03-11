$(document).ready(function() {
    $('#e-tooltip').tooltip();
    $('#getSizeModal').on('hidden', function () {
      console.log('modal closed');
      if($("#p_intro").length > 0) {
          //1 - stop
          init('p_intro',1);
      }
            
    })    
    
    logSteps(window.introVideo,'Стартовая страница регистрации с видео intro');
});

    function init(id,action) {
           console.log('id: ' + id);
        // Listen for the ready event for any vimeo video players on the page
            var p_id='#'+id;
            var vimeoPlayers = $('#'+id),
                player;
                for (var i = 0, length = vimeoPlayers.length; i < length; i++) {
                        player = vimeoPlayers[i];
                        //if (player != undefined) {
                            $f(player).addEvent('ready', ready);
                        //}
                }

                /**
                 * Utility function for adding an event. Handles the inconsistencies
                 * between the W3C method for adding events (addEventListener) and
                 * IE's (attachEvent).
                 */
                function addEvent(element, eventName, callback) {
                    if (element.addEventListener) {
                        element.addEventListener(eventName, callback, false);
                    }
                    else {
                        element.attachEvent(eventName, callback, false);
                    }
                }
                
                    function ready(player_id) {
                        console.log('Player with player_id is ready now: ' + player_id);
                        // Keep a reference to Froogaloop for this player
                        var froogaloop = $f(player_id);
                        console.log('inside function ready: ' + froogaloop);
                        
                        froogaloop.addEvent('play', onPlay);
                        froogaloop.addEvent('pause', onPause);
                        froogaloop.addEvent('finish', onFinish);
                        
                        if(action==1) {
                            froogaloop.api('play');    
                        }                         
                            
                        $(".start-btn-holder").fadeOut();   
                    }
                    
                    function onPlay(player_id) {
                        $(".start-btn-holder").fadeOut();   
                        logSteps(id, 'Запуск видео');
                        console.log('start');
                    }
                    
                    function onPause(player_id) {
                        $(".start-btn-holder").fadeIn('slow');
                        logSteps(id, 'Остановка видео');
                        console.log('paused');
                    }

                    function onFinish(player_id) {
                        $(".start-btn-holder").fadeIn('slow');
                        logSteps(id, 'Завершение видео');
                        console.log('finished');
                    }

//        var iframe = $('#'+id)[0];
//        console.log(iframe);
//        if (iframe != undefined) {
//            var player = $f(iframe),
//            status = $('.status');

            // When the player is ready, add listeners for pause, finish, and playProgress
//            player.addEvent('ready', function() {
//                status.text('ready');
//                
//                player.addEvent('play', onPlay);
//                player.addEvent('pause', onPause);
//                player.addEvent('finish', onFinish);
                //player.addEvent('playProgress', onPlayProgress);
                //player.addEvent('loadProgress', onLoadProgress);
//            });   
//           
            // Call the API when a button is pressed
            //$('button').bind('click', function() {
                //player.api($(this).text().toLowerCase());
            //});

//            function onPlay(id) {
//                status.text('start');
//                $(".start-btn-holder").fadeOut();   
//                logSteps(id, 'Запуск видео');
//                console.log('start');
//            }

//            function onPause(id) {
//                status.text('paused');
//                $(".start-btn-holder").fadeIn('slow');
//                logSteps(id, 'Остановка видео');
//                console.log('paused');
//            }

//            function onFinish(id) {
//                status.text('finished');
//                $(".start-btn-holder").fadeIn('slow');
//                logSteps(id, 'Завершение видео');
//                console.log('finished');
//            }

//            function onPlayProgress(data, id) {
//                status.text(data.seconds + 's played');
//            }
//            
//            function onLoadProgress(data, id) {
//                console.log(data.percent);
//            }
//        }
    }
 
    $('.next-btn').live('click', function() {
        if ($(this).hasClass('first')) {
            loadVideo($(this));
            $(this).closest('li').hide()
                   .next().show()
                   .find('.controls').addClass('current');              
        } else {
            $("form#registration").submit();
        }
    });    
    
    function loadVideo(elem) {

        //stop all videos
        $("iframe").each(function() {
            this.contentWindow.postMessage('{ "method": "pause" }', "http://player.vimeo.com");
        });
        
        var vidId = elem.closest('li').next().find('.vid-id').attr('id');
        var container = elem.closest('li').next().find('.player-container').attr('id');
        
        $('#'+container).html('<iframe id="'+vidId+'" src="http://player.vimeo.com/video/'+vidId+'?api=1&player_id='+vidId+
            '&autoplay=1" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
            
        init(vidId);
        if(vidId!=undefined) {
            logSteps(vidId,'Просмотр видео');
        }
    }
    
    //log every step 
    function logSteps(video_id, message) {
        jQuery.ajax({
            'url':'logSteps',
            'dataType':'json',
            'type':'GET',
            'cache':false,
            'data':{
                video_id:video_id,
                video_title:$("#ht_"+video_id).html(),
                session_id:$('input#session_id').val(),
                message:(typeof(message)==='undefined') ? 'null' : message
            },
            'success':function(data){
//                if(data.status=='success'){
//                } else {
//               }                    
            }
        });        
    }    


//YOUTUBE VIDEO

//The greeting video is loaded on page load
//Load player api asynchronously.
//var tag = document.createElement('script');
//tag.src = "http://www.youtube.com/player_api";
//var firstScriptTag = document.getElementsByTagName('script')[0];
//firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
//var player;

//function onYouTubePlayerAPIReady() {
//    player = new YT.Player('player', {
//      height: '300',
//      width: '900',
//      videoId: '2woH10c8l_0',//2woH10c8l_0 rus
//      videoId: window.introVideo,//2woH10c8l_0 rus
//      playerVars:{'autoplay':0, 'rel':0, 'showinfo':0, 'egm':0, 'showsearch':0, 'hd': 1, 'suggestedQuality':'hd720', 'wmode':'opaque'},
//      events: {
//        'onReady': onPlayerReady,
//        'onStateChange': onPlayerStateChange
//      }
//    });
//}

//function onPlayerReady(event) {
//    $("div#loader").removeClass("loading");
//    console.log('set HD');
//    player.setPlaybackQuality('hd720');
//    event.target.playVideo();
//}
//function onPlayerStateChange(event,element) {

//    if (event.data == 1) {
//        $(".start-btn-holder").fadeOut();
//    }
//    if (event.data == 2) {
//        $(".start-btn-holder").fadeIn('slow');
//    }    

//    When the video has ended
//    if (event.data == YT.PlayerState.ENDED) {
//        console.log('video ended!');
//        $(".start-btn-holder").fadeIn('slow');
//        player.seekTo(1, true);
//        console.log('seek to');
//        player.pauseVideo();
//        console.log('pause video');
//    }
//}

//function loadVideo(elem) {
//            var vidId = elem.closest('li').next().find('.vid-id').attr('id');
//            var container = elem.closest('li').next().find('.player-container').attr('id');
//            
//            $('#'+container).html('<iframe id="player_'+vidId+
//                '" class="embed" width="900" height="300" src="http://www.youtube.com/embed/'+
//                vidId+'?enablejsapi=1&autoplay=0&autohide=1&showinfo=0&rel=0&wmode=opaque" '+
//                'frameborder="0" allowfullscreen></iframe>');

//            player = new YT.Player('player_'+vidId, {
//                playerVars:{'showinfo':0, 'egm':0, 'showsearch':0, 'hd': 1, 'suggestedQuality': 'hd720'},
//                events: {
//                    'onReady': onPlayerReady,
//                    'onStateChange': onPlayerStateChange
//                }
//            });    
//}

//YOUTUBE VIDEO END

// Determine whether a variable is empty
function empty (mixed_var) {
  // Checks if the argument variable is empty
  // undefined, null, false, number 0, empty string,
  // string "0", objects without properties and empty arrays
  // are considered empty
  //
  // http://kevin.vanzonneveld.net
  // +   original by: Philippe Baumann
  // +      input by: Onno Marsman
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      input by: LH
  // +   improved by: Onno Marsman
  // +   improved by: Francesco
  // +   improved by: Marc Jansen
  // +      input by: Stoyan Kyosev (http://www.svest.org/)
  // +   improved by: Rafal Kukawski
  // *     example 1: empty(null);
  // *     returns 1: true
  // *     example 2: empty(undefined);
  // *     returns 2: true
  // *     example 3: empty([]);
  // *     returns 3: true
  // *     example 4: empty({});
  // *     returns 4: true
  // *     example 5: empty({'aFunc' : function () { alert('humpty'); } });
  // *     returns 5: false
  var undef, key, i, len;
  var emptyValues = [undef, null, false, 0, "", "0"];

  for (i = 0, len = emptyValues.length; i < len; i++) {
    if (mixed_var === emptyValues[i]) {
      return true;
    }
  }

  if (typeof mixed_var === "object") {
    for (key in mixed_var) {
      // TODO: should we check for own properties only?
      //if (mixed_var.hasOwnProperty(key)) {
      return false;
      //}
    }
    return true;
  }

  return false;
}
