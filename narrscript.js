jQuery(document).ready(function($){
    $('div[goto]').click(MakeNextStep);
});

function MakeNextStep() {
  //  var activeZone=$('section[label="active"]');
    
    var goto =  jQuery(this).attr('goto');                       	// �������� �� ������� ������ ����� ���� ���� �� ������
    goto='section[label="'+goto+'"]';							 	// ����������� ��� � ������ ������� ����� ������������ � �������
    var NextText= jQuery(goto).html();                         	  	// �������� ����� � ���� html �� �������� ������ � ������ �� 
																	// �� section � ������ �������

    jQuery('section[label="active"]').fadeTo('medium', 0, function(){
        jQuery(this).html(NextText);                             	//���������� ��������� ����� �� �������� ����� � ��������
    }
    ).fadeTo('slow',1,function(){								 	// ������������ ��� ������� ���������
        jQuery('div[goto]').click(MakeNextStep);   					// ������ ����������� � ������� ������� ������ ��� ��������� ����� ������
    });
}
