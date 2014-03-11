$(document).ready(function() {
    $('#e-tooltip').tooltip();
    $('#getSizeModal').on('hidden', function () {
      console.log('modal closed');
        //$('.next-btn.first').trigger('click');
    })    
    
    logSteps(window.introVideo,'Стартовая страница регистрации с видео intro');
});

    function init(id) {
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

//$(function() {

//});

// 2. This code loads the IFrame Player API code asynchronously.
//var tag = document.createElement('script');

//tag.src = "https://www.youtube.com/iframe_api";
//var firstScriptTag = document.getElementsByTagName('script')[0];
//firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
//var player;
//function onYouTubeIframeAPIReady() {
//player = new YT.Player('player', {
//  height: '###',
//  width: '###',
//  videoId: 'suePi5ENhA0',
//  events: {
//    'onReady': $("div#loader").removeClass("loading"),
//    'onStateChange': onPlayerStateChange,
//    'onPlayerReady': onPlayerReady
//  }
//});
//}

// 4. The API will call this function when the video player is ready.
//function onPlayerReady(event) {
//    event.target.playVideo();
//}
//   
// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
//var done = false;
//function onPlayerStateChange(event) {
//if (event.data == 1) {
//    console.log('play');    
//}
//if (event.data == 2) {
//    console.log('stopped!');    
//}
//    if (event.data == YT.PlayerState.PLAYING && !done) {
//      setTimeout(stopVideo, 6000);
//      done = true;
//    }
//}
//function stopVideo() {
//    player.stopVideo();
//}



//POINTERS
(function($){
    var constants = {
       'cellSizeMinus': '148',//200
       'cellSizeRecomended': '292',//200
       'cellSizePlus': '148',//200
       'minus': '524',//188
       'recomended': '670',//387
       'plus': '963' //588
    }; 
    
    window.recomendedSizeArray=new Array();
    
    $.rangeFormula = {
        populateRangeTd: function() {
            
            $('.rangeTitle').each(function(){
                var rangeTitle = $(this).val(); 
                var form = $(this).closest('form');
                rangeTitle = $.rangeFormula.getRangeTitle(rangeTitle);

                var minusM=window.fdata['{'+rangeTitle+'_min}'];
                var minus=window.fdata['{'+rangeTitle+'_minr}'];
                var plus=window.fdata['{'+rangeTitle+'_maxr}'];
                var plusM=window.fdata['{'+rangeTitle+'_max}'];
                
                //form.find('.minus-m .minus .plus-m .plus').empty();
                form.find('.minus-m').html(minusM);
                form.find('.minus').html(minus);    
                form.find('.plus').html(plus);    
                form.find('.plus-m').html(plusM);
                
                $.rangeFormula.processPointers(form,minusM,minus,plus,plusM);
            });
        },
        
        processPointers: function(form,minusM,minus,plus,plusM) {
            $.rangeFormula.removeAllPointers(form);
            var value = form.find('#Formula_fvalue').val()
            $.each(window.sizeListArray, function(indexS, size) {
                var ind='{'+size+'_'+value.substring(1);
                var valueByIndex=window.fdata[ind];
                                                                                       
                if($.rangeFormula.between('minus',valueByIndex,minusM,minus)) {
                    console.log('2-valueByIndex: ' + valueByIndex + ' minusM: ' + minusM + ' minus: ' + minus);
                    var leftPropPix=$.rangeFormula.calculatePointerPosition(form,minusM,minus,ind,'minus'); // was 'minus'+size but I removed +size and only class name is passed
                    $.rangeFormula.positionPointer(form,size,'minus',leftPropPix);// was 'minus'+size but I removed +size and only class name is passed
                
                } else if($.rangeFormula.between('plus',valueByIndex,minus,plus)) {
                    console.log('3-valueByIndex: ' + valueByIndex + ' minus: ' + minus + ' plus: ' + plus);
                    var leftPropPix=$.rangeFormula.calculatePointerPosition(form,minus,plus,ind,'recomended');
                    $.rangeFormula.positionPointer(form,size,'recomended',leftPropPix);

                } else if($.rangeFormula.between('plus',valueByIndex,plus,plusM)) {
                    console.log('4-valueByIndex: ' + valueByIndex + ' plus: ' + plus + ' plusM: ' + plusM);
                    var leftPropPix=$.rangeFormula.calculatePointerPosition(form,plus,plusM,ind,'plus');
                    $.rangeFormula.positionPointer(form,size,'plus',leftPropPix);
                    
                } else if($.rangeFormula.between('plusM',valueByIndex,plusM)) {
                    console.log('5-valueByIndex: ' + valueByIndex + ' plusM: ' + plusM);
                    $.rangeFormula.positionPointer(form, size,'plus-m');

                } else if($.rangeFormula.between('minusM',valueByIndex,minusM)) {
                    console.log('1-valueByIndex: ' + valueByIndex + ' minusM: ' + minusM);
                    $.rangeFormula.positionPointer(form, size,'minus-m');
                }
            });            
        },
        
        between: function(className, x, min, max) {
          if(max===undefined){
            if(className=='plusM'){
                if(x>0){
                    console.log('className: ' + className  + 'x>0');
                    return parseInt(x) > parseInt(min);
                } else {
                    console.log('className: ' + className  + 'x<0');
                    return false;
                }
            } else {
                if(x<0){
                    console.log('className: ' + className + 'x<0');
                    return parseInt(x) < parseInt(min);
                } else {
                    console.log('className: ' + className + 'x>0');
                    return false;
                }                
            }
          }            
            console.log('parseInt(x) >= parseInt(min) && parseInt(x) <= parseInt(max)');
            return parseInt(x) >= parseInt(min) && parseInt(x) <= parseInt(max);
        },
        
        createPointer: function(size,className) {
            return '<a id="pointer_'+size+'" href="#" class="f-pointer '+className+'" style="z-index:'+size+'" title="'+size+'"><span class="sizeTitle '+size+'">'+size+'</span></a>';
        },
       
        createPointerThatFit: function(size) {
            return '<a id="" href="#" class="recomended-size" style="z-index:'+size+'" title="'+size+'"><span class="sizeTitle '+size+'">'+size+'</span></a>';
        },        
        
        getRangeTitle: function(val) {
             switch (val) {
               case '1':
                  var rangeTitle='СТ'
                  break
               case '2':
                  var rangeTitle='СГ'
                  break
               case '3':
                  var rangeTitle='СБ'
                  break
               case '4':
                  var rangeTitle='ОП'
                  break                  
               case '5':
                  var rangeTitle='ШГ'
                  break                  
               case '6':
                  var rangeTitle='РП'
                  break                  
               default:
                  var rangeTitle='null'
                  break
             }            
            return rangeTitle;
        },
        
        getCssLeftPropertyByClassName: function(className) {
            className=className.replace(/\d+/g, '');
            switch (className) {
               case 'minus':
                  var propertyValue=constants.minus
                  break
               case 'recomended':
                  var propertyValue=constants.recomended
                  break
               case 'plus':
                  var propertyValue=constants.plus
                  break
               default:
                  var propertyValue='null'
                  break
             }            
            return parseInt(propertyValue);
        },        
        
        getCellSize: function(className) {
            switch (className) {
               case 'minus':
                  var cellSize=constants.cellSizeMinus
                  break
               case 'recomended':
                  var cellSize=constants.cellSizeRecomended
                  break
               case 'plus':
                  var cellSize=constants.cellSizePlus
                  break
               default:
                  var cellSize='null'
                  break
             }            
            return parseInt(cellSize);            
        },
        
        calculatePointerPosition: function(form,min,max,ind,className) {
            var cellSize = $.rangeFormula.getCellSize(className);
            if(min<0) {
                var difference=parseInt(Math.abs(min));
                var rangeSum=difference+parseInt(max);
                var zero=$.rangeFormula.getCssLeftPropertyByClassName(className)+((parseInt(cellSize)/rangeSum)*parseInt(difference));
                if(window.fdata[ind]<0) { 
                    var css=Math.round(zero-((parseInt(cellSize)/rangeSum)*parseInt(Math.abs(window.fdata[ind]))));
                } else {
                    var css=Math.round(zero+((parseInt(cellSize)/rangeSum)*parseInt(Math.abs(window.fdata[ind]))));
                }
                var correction=css-$.rangeFormula.correctPointerPositonByWidth(form);
                console.log('SIZE: '+ ind + ' min: ' + min + ' max: ' +max +' difference: ' + difference + ' rangeSum: ' + rangeSum + ' className: ' + className + ' zero: ' + zero + ' css: ' + css + ' correction by: '+$.rangeFormula.correctPointerPositonByWidth(form) + ' final css: ' + correction);
                return css;
            } else if(min>0) {
                var rangeSum=parseInt(max)-parseInt(min);
                var zero=$.rangeFormula.getCssLeftPropertyByClassName(className);
                var css=Math.round(zero+((parseInt(cellSize)/rangeSum)*(parseInt(Math.abs(window.fdata[ind]))-min)));
                var correction=css-$.rangeFormula.correctPointerPositonByWidth(form);
                console.log('SIZE: '+ ind + ' min: ' + min + ' max: ' +max +' difference: ' + difference + ' rangeSum: ' + rangeSum + ' className: ' + className + ' zero: ' + zero + ' css: ' + css + ' correction by: '+$.rangeFormula.correctPointerPositonByWidth(form) + ' final css: ' + correction);
                return css;
            } else {
                var rangeSum=parseInt(max)-parseInt(min);
                var zero=$.rangeFormula.getCssLeftPropertyByClassName(className);
                var css=Math.round(zero+((parseInt(cellSize)/rangeSum)*parseInt(Math.abs(window.fdata[ind]))));
                var correction=css-$.rangeFormula.correctPointerPositonByWidth(form);
                console.log('SIZE: '+ ind + ' min: ' + min + ' max: ' +max +' difference: ' + difference + ' rangeSum: ' + rangeSum + ' className: ' + className + ' zero: ' + zero + ' css: ' + css + ' correction by: '+$.rangeFormula.correctPointerPositonByWidth(form) + ' final css: ' + correction);
                return css;
            }
            
        },
        
        getPointersCount: function(form) {
            return form.find('.size_wrapper a.f-pointer').length;     
        },
        
        getPointerWidth: function(form) {
            return form.find('.size_wrapper a.f-pointer').width();     
        },
        
        correctPointerPositonByWidth: function(form) {
            return ($.rangeFormula.getPointersCount(form) > 0) ? (parseInt($.rangeFormula.getPointerWidth(form))*parseInt($.rangeFormula.getPointersCount(form)))+16 : 16; 
        },
        
        repositionPointerByWidth: function(form) {
            var pointerW=cf=$.rangeFormula.getPointerWidth(form);
            form.find('.size_wrapper a.f-pointer:not(.minus-m)').each(function() {
                var curCss=$(this).css('left');
                $(this).css('left', parseInt(curCss)-parseInt(cf));
                cf=cf+pointerW; 
            });
             
            return ($.rangeFormula.getPointersCount(form) > 0) ? (parseInt($.rangeFormula.getPointerWidth(form))*parseInt($.rangeFormula.getPointersCount(form)))+16 : 16; 
        },                          
        
        positionPointer: function(form,size,className,leftPropPix) {
            var offset = form.find('div.size_wrapper').offset();

            if(className=='recomended'){
                window.recomendedSizeArray[size]=size;
            }    

            if(leftPropPix===undefined){
                form
                    .find('.size_wrapper')
                    .prepend($.rangeFormula.createPointer(size,className))
                    .find('a#pointer_'+size)
                    .addClass(function(index, currentClass){
                        if($(this).closest('form').find('a.minus-m').length>0) {
                            return className+' second';
                        }
                        return className; 
                    })
                    .css('top',parseInt(offset.top+43));
            } else {
                form
                    .find('.size_wrapper')
                    .prepend($.rangeFormula.createPointer(size,className))
                    .find('a#pointer_'+size)
                    .addClass(className)
                    .css('left',leftPropPix)
                    .css('top',parseInt(offset.top+43));
                    
                    //$.rangeFormula.getPointerPosition(form,size);
            }
        },
        
        getPointerPosition: function(form,size) {
            var pointer=form.find('a#pointer_'+size)
            var offset=pointer.offset();
        },
        
        removeAllPointers: function(form) {
            form.find('.size_wrapper .f-pointer').remove();
        },
        
        getResFormulasCount: function() {
            return $('.res-formula-range').length;
        },
        
        getRecomendedPointersBySizeCount: function(size) {
            return $('a#pointer_'+size+'.recomended').length;
        },
        
        showPointersThatFit: function() {
            for(var index in window.recomendedSizeArray) {
                if ($.rangeFormula.getRecomendedPointersBySizeCount(index) == $.rangeFormula.getResFormulasCount()) {
                    $('a#pointer_'+index+'.recomended').fadeIn('slow');
                    $('.fitting-size-holder').append($.rangeFormula.createPointerThatFit(index));
                }    
            }
        },
    }


    //Todo: create namespace for methods
//    $.fn.populateRangeValues = function(options) {
//        var html = 'Empty value!';
//        html = options.dataArray['{'+options.data+'_min}'];
//        html = html + options.dataArray['{'+options.data+'_minr}'];    
//        html = html + options.dataArray['{'+options.data+'_maxr}'];    
//        html = html + options.dataArray['{'+options.data+'_max}'];    

//        return this.html(html);
//    }
})(jQuery)

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
