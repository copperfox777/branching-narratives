jQuery(document).ready(function($){
    $('div[goto]').click(MakeNextStep);
});

function MakeNextStep() {
  //  var activeZone=$('section[label="active"]');
    
    var goto =  jQuery(this).attr('goto');                       	// получаем от нажатой кнопки лейбл куда идти по сюжету
    goto='section[label="'+goto+'"]';							 	// преобразуем это в строку которую будем использовать в запросе
    var NextText= jQuery(goto).html();                         	  	// получаем текст в виде html из искомого лейбла а именно из 
																	// из section с нужным лейблом

    jQuery('section[label="active"]').fadeTo('medium', 0, function(){
        jQuery(this).html(NextText);                             	//Собственно переносим текст из скрытого блока в активный
    }
    ).fadeTo('slow',1,function(){								 	// сопровождаем это немного анимацией
        jQuery('div[goto]').click(MakeNextStep);   					// заново привязываем к кнопкам события потому что появились новые кнопки
    });
}
