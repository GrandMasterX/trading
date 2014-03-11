(function(){
    pointers = {
        init: function() {
            alert($('.size_wrapper_2').attr('id'));
            $('.size_wrapper_2')
                .addClass('test')
                .append(this.createPointer(32,'recomended')); 
        },

        createPointer: function(size,className) {
            return '<a id="pointer_'+size+'" href="#" class="f-pointer '+className+'" style="z-index:'+size+'" title="'+size+'"><span class="sizeTitle '+size+'">'+size+'</span></a>';
        }
    };
    
    pointers.init();
    
})();
