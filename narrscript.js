jQuery(document).ready(function($){
    $('div[goto]').click(MakeNextStep);  
});

//Выполняем аякс запрос в базу данных
function SendAnswerToDatabase(goto_name) {

	jQuery.ajax({
		type:"POST",
		url: "/wp-admin/admin-ajax.php",
		data: goto_name,
		success:function(data){
			alert(data)
		}
	});

	return false;
}


function MakeNextStep() {
  //  var activeZone=$('section[label="active"]');
    
    var goto_name =  jQuery(this).attr('goto');                       	// получаем от нажатой кнопки лейбл куда идти по сюжету
	SendAnswerToDatabase(goto_name);
	
    goto_name='section[label="'+goto_name+'"]';							 	// преобразуем это в строку которую будем использовать в запросе
    var NextText= jQuery(goto_name).html();                         	  	// получаем текст в виде html из искомого лейбла а именно из 
																	// из section с нужным лейблом

    jQuery('section[label="active"]').fadeTo('medium', 0, function(){
        jQuery(this).html(NextText);                             	//—обственно переносим текст из скрытого блока в активный
    }
    ).fadeTo('slow',1,function(){								 	// сопровождаем это немного анимацией
        jQuery('div[goto]').click(MakeNextStep);   					// заново прив¤зываем к кнопкам событи¤ потому что по¤вились новые кнопки
    });
}
