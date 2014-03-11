 $(document).ready(function() {
  $(function() {
    $( ".column" ).sortable({
      connectWith: ".column",
      handle: '.portlet-header',
    });
 
    $( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
        .end()
      .find( ".portlet-content" );
 
    $( ".portlet-header .ui-icon" ).click(function() {
      $( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
      $( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
    });
 
    $( ".column" ).disableSelection();
  });
});

  function activateSortable() {
    $( ".column-f" ).sortable({
      connectWith: ".column-f",
      handle: '.portlet-header',
      stop: function(event, ui) {
        var data=new Array();
        $(".column-f div.portlet-f").each(function(i, el){
            data[i] = $(el).find('form').attr('id').substring(13);
        });
        updateWeight(data);
      }
    });
 
    $( ".portlet-f" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
        .end()
      .find( ".portlet-content" );
 
    $( ".portlet-header .ui-icon" ).click(function() {
      $( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
      $( this ).parents( ".portlet-f:first" ).find( ".portlet-content" ).toggle();
    });
 
    $( ".column-f" ).disableSelection();
  
  //parent
    $( ".column-p" ).sortable({
      connectWith: ".column-p",
      handle: '.portlet-header',
      stop: function(event, ui) {
        var data=new Array();
        $(".column-p div.portlet-f").each(function(i, el){
            data[i] = $(el).find('form').attr('id').substring(13);
        });
        updateWeight(data);
      }
    });
 
    $( ".portlet-f" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
      .find( ".portlet-header" )
        .addClass( "ui-widget-header ui-corner-all" )
        .prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
        .end()
      .find( ".portlet-content" );
 
    $( ".portlet-header .ui-icon" ).click(function() {
      $( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
      $( this ).parents( ".portlet-f:first" ).find( ".portlet-content" ).toggle();
    });
 
    $( ".column-p" ).disableSelection();  
 
  }
  
  
  function updateWeight(data) {
      csrf=$('input[name="YII_CSRF_TOKEN"]').val()
      jQuery.ajax({
        'url':'updateWeight',
        'dataType':'json',
        'type':'POST',
        'cache':false,
        'data':{
            idArray:data, 
            YII_CSRF_TOKEN:csrf,
        },
        'success':function(data){
            if(data.status=='success'){
            } else {
           }
        }
    });     
}