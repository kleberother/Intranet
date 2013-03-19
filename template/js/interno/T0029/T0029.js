//-- AO ESCOLHER DATA INICIAL, COMPLETAR A MESMA COISA NA FINAL -----------------------------------------//
$(function() {
        $( "#dt_inicial" ).live("change",function(){
          var $this       =   $("#dt_inicial");
          var dt_final    =   $("#dt_final").val()
          if(dt_final == "")
          {
           $( "#dt_final" ).val($this.val());
          }
        });
});

