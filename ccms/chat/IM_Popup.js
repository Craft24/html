/**
 * ��ʱ���쵯����غ���
 */

function openWindow(url,width,height,options,name) {
	width = width ? width : 700;
	height = height ? height : 600;
	options = options ? options : 'resizable=yes';
	name = name ? name : 'IMWindow';
	$("#win_status").val("");
	return window.open(url,name,'screenX='+(screen.width-width)/2+',screenY='+(screen.height-height)/2+',width='+width+',height='+height+','+options);

}
function checkMessage(url,name){
	if($("#win_status").val() == "no"){
		//����lastID�ж��Ƿ�������Ϣ����
		$.get(url, { tanpingStatus: "2", lastID: $("#win_lastID").val(), userName: name},
		   function(data){
			 var count = Number(data);
			 if(count>0){
				 openWindow(url + "?userName="+name);
			 }
		   }
		);
	}
}
function IM_Popup(url,name){
	//��ȡ��½ǰ�����¼������lastID
	if($("#win_lastID").val()==""){
		$.get(url, { tanpingStatus: "1", userName: name},
		   function(data){
				$("#win_lastID").val(data);
		   }
		);
	}
	
	window.setInterval("checkMessage('"+url+"','"+name+"')",3000);	
}