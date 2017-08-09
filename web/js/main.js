$('document').ready(function(){
    var arr = [];
   $('.btn-box-tool').click(function(){
      var position= $(this).parent().parent().parent().find(".position").text();

       if(jQuery.inArray(position,arr) === -1  ){
           $.ajax({
               type: 'get',
               url: Routing.generate('ajax_server_info', { server_position: position }),
               beforeSend : function(){

               },
               success : function(data) {
                   console.log(data.memory);
               }
           })
           arr.push(position);
       }
       else{

       }

   });
});
