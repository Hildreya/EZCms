function ajax(position){
    $.ajax({
        type: 'get',
        url: Routing.generate('ajax_server_info', { server_position: position }),
        beforeSend: function() {
            $($.find('.position_'+position)).empty();

            $($.find('.position_'+position)).append('<div class="col-md-6 col-md-offset-3 text-center loading"></div>');
        },
        success: function(data) {
            $($.find('.loading')).remove();
            if(data.error){

                $($.find('.position_'+position)).append('<div class="col-md-12 text-center"><h4>Une erreur est survenue... :(</h4></div>');
            }
            else{
                var players = data.server.players;
                console.log(players.length);
                $($.find('.position_'+position)).append(
                    '<div class="col-md-4 text-center">' +
                    '<input type="text" value="'+data.memory+'" class="knob_memory">' +
                    '<div class="knob-label">Mémoire (en %)</div>' +
                    '</div>' +
                    '<div class="col-md-4 text-center">' +
                    '<b>Nom:</b><br>'+
                    data.server.serverName +
                    '<br><b>Version:</b><br>'+
                    data.server.version +

                    '</div>' +
                    '<div class="col-md-4 text-center">' +
                    '<input type="text" value="'+ data.disk +'" class="knob_disk">' +
                    '<div class="knob-label">Disque (en %)</div>' +
                    '</div>');
                $($($.find('.position_'+position)).parent().parent().find('.online_players')).empty();
                $($($.find('.position_'+position)).parent().parent().find('.online_players')).text(players.length);

                $('.knob_disk').knob(
                    {
                        'readOnly' : true,
                        'width': 100,
                        'height': 100,
                        'fgColor': "#00A65A"

                    }
                );
                $('.knob_memory').knob(
                    {
                        'readOnly' : true,
                        'width': 100,
                        'height': 100,
                        'fgColor': "#f56954"

                    }
                );
            }
        },
        error: function() {
            $($.find('.loading')).remove();
            $($.find('.position_'+position)).append('<div class="col-md-12 text-center"><h4>Une erreur est survenue... :(</h4></div>');
        }
    });
}

$('document').ready(function(){
    var arr = [];
   $('.btn-box-tool').click(function(){
      var position= $(this).parent().parent().parent().find(".position").text();

      if($(this).parent().parent().parent().hasClass("box-success")) {
          if (jQuery.inArray(position, arr) === -1) {

              ajax(position);
              arr.push(position);
          }
          else {

          }
      }

   });
   $('.refresh').click(function(){
       var position = $(this).parent().parent().parent().parent().find(".position").text();
       ajax(position);


   });
   $('.ajax-link').click(function(){
       var name = $(this).html();
       var link = $(this).attr('href').replace('#','');
       var user_id = $(location).attr('pathname').substr($(location).attr('pathname').length - 1);
       if(jQuery.inArray(name, arr) === -1){
           $.ajax({
               type: 'get',
               url: Routing.generate(link, {user: user_id}),
               beforeSend: function () {
                   $($.find('#' + link)).empty();

                   $($.find('#' + link)).append('<div class="text-center loading"></div>');
               },
               success: function (response) {
                   $($.find('.loading')).remove();
                   var template = response;
                   $($.find('#'+link)).append(template);
               },
               error: function (jqXHR, textStatus, errorThrown) {
                   $($.find('.loading')).remove();
                   $($.find('#'+link)).append('<h1>Une erreur est survenue ! (</h1><p> Error : ' + errorThrown + '</p>');

               }
           })
           arr.push(name);
       }
   })
    $('.ajax-form-link').click(function(){
        var name = $(this).html();
        var link = $(this).attr('href').replace('#','');
        if(jQuery.inArray(name, arr) === -1){
            $.ajax({
                type: 'get',
                url: Routing.generate(link),
                beforeSend: function () {
                    $($.find('#' + link)).empty();

                    $($.find('#' + link)).append('<div class="text-center loading"></div>');
                },
                success: function (response) {
                    $($.find('.loading')).remove();
                    var template = response;
                    $($.find('#'+link)).append(template);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $($.find('.loading')).remove();
                    $($.find('#'+link)).append('<h1>Une erreur est survenue ! (</h1><p> Error : ' + errorThrown + '</p>');

                }
            })
            arr.push(name);
        }
    })

});
