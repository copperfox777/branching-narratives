jQuery(document).ready(function ($) {
    $('div[goto]').click(MakeNextStep);
});

//Выполняем аякс запрос в базу данных
function SendAnswerToDatabase(goto_name) {
    var data = {
        post_id: jQuery('article').attr('id').slice(5),
        goto_name: goto_name,
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


function MakeNextStep() {
    //  var activeZone=$('section[label="active"]');

    var goto_name = jQuery(this).attr('goto'); // получаем от нажатой кнопки лейбл куда идти по сюжету
    SendAnswerToDatabase(goto_name);

    goto_name = 'section[label="' + goto_name + '"]'; // преобразуем это в строку которую будем использовать в запросе
    var NextText = jQuery(goto_name).html(); // получаем текст в виде html из искомого лейбла а именно из 
    // из section с нужным лейблом

    jQuery('section[label="active"]').fadeTo('medium', 0, function () {
        jQuery(this).html(NextText); //—обственно переносим текст из скрытого блока в активный
    }).fadeTo('slow', 1, function () { // сопровождаем это немного анимацией
        jQuery('div[goto]').click(MakeNextStep); // заново прив¤зываем к кнопкам событи¤ потому что по¤вились новые кнопки
    });
}