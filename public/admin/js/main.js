(function($){
    var constants = {
       'cellSizeMinus': '148',//200
       'cellSizeRecomended': '292',//200
       'cellSizePlus': '148',//200
       'minus': '145',//188
       'recomended': '290',//387
       'plus': '582' //588
    }; 
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
            return '<a id="pointer_'+size+'" href="#" class="f-pointer '+className+'" style="z-index:'+size+'" title="'+size+'"><span class="sizeTitle">'+size+'</span></a>';
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
            var offset = form.find('div.res-formula-holder').offset();
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
                    .css('top',parseInt(offset.top-255));
            } else {
                form
                    .find('.size_wrapper')
                    .prepend($.rangeFormula.createPointer(size,className))
                    .find('a#pointer_'+size)
                    .addClass(className)
                    .css('left',leftPropPix)
                    .css('top',parseInt(offset.top-255));
                    
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