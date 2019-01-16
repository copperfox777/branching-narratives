jQuery(document).ready(function ($) {
    session_id = make_random_id();
    $('[goto]').click(MakeNextStep);
});

//Выполняем аякс запрос в базу данных
function SendAnswerToDatabase(goto_name) {
    var data = {
        post_id: jQuery('article').attr('id').slice(5),
        goto_name: goto_name,
        session_id: session_id
    };

    jQuery.ajax({
        url: "/wp-content/plugins/branching-narratives/fast-ajax-save-results.php",
        type: "POST",
        data: data,
        dataType: "text",
        success: function (data) {
            // alert(data)
        },
        error: function (data) {
            alert('error');
        }
    });

    return false;
}

function make_random_id() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < 5; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
  
    return text;
  }

function MakeNextStep() {
    //  var activeZone=$('section[label="active"]');

    var goto_name = jQuery(this).attr('goto'); // получаем от нажатой кнопки куда идти по сюжету
    SendAnswerToDatabase(goto_name);

    goto_name = 'section[name="' + goto_name + '"]'; // преобразуем это в строку которую будем использовать в запросе
    var NextText = jQuery(goto_name).html(); // получаем текст в виде html из искомого лейбла а именно из 
    // из section с нужным лейблом

    jQuery('section[name="active"]').fadeTo('fast', 0, function () {
        jQuery(this).html(NextText); //—обственно переносим текст из скрытого блока в активный
    }).fadeTo('medium', 1, function () { // сопровождаем это немного анимацией
        jQuery('[goto]').click(MakeNextStep); // заново прив¤зываем к кнопкам событи¤ потому что по¤вились новые кнопки
    });
}