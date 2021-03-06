<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="0"> 

<meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
<base href="<?php echo $this->config->item('base_url') ?>/"/>

<link rel="stylesheet" href="www/css/main.css" type="text/css" media="screen" />
<link rel='stylesheet' href='www/lib/jquery/ui/themes/base/jquery.ui.all.css'   type='text/css' media="screen"/>

<script type="text/javascript" src="www/lib/jquery/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="www/lib/dataTable/js/jquery.dataTables.js"  ></script>
<script src="www/js/work.js"  type="text/javascript"></script>
<script type='text/javascript' src='www/lib/jquery/jquery-ui-1.8.16.custom.js'></script>
<script type='text/javascript' src='www/lib/extenal.js'></script>
<script type='text/javascript' src='www/js/call.js'></script>
<script type='text/javascript' src='www/js/work.js'></script>
<script type='text/javascript' src='www/lib/myDynamicUI/dynamicUI.js'></script>
<script type='text/javascript' src='www/lib/jquery/jquery.json-2.3.min.js'></script>
<script type='text/javascript' src='www/lib/json2.js'></script>

<style type="text/css" title="currentStyle">
			@import "www/lib/dataTable/css/demo_page.css";
			@import "www/lib/dataTable/css/demo_table.css";
.dataTables_filter{display:none}
.dataTables_length{display:none}
</style>


<script>
	


$(document).ready(function() {		
	//招生状态赋值
	function getDateString(ymd, hour, minut){
	 	return ymd+" "+hour+":"+minut+":00";
	}
	
	setDatePickerLanguageCn();
	//给时间控件付初值
	var ctime=new Date();
	$("#s_hour").get(0).selectedIndex="00";//index为索引值
	$("#s_min").get(0).selectedIndex="00"	
	$("#start_ymd").attr('value', ctime.format('yyyy-MM-dd'));	
	$("#e_hour").get(0).selectedIndex="23";//index为索引值
	$("#e_min").get(0).selectedIndex="59"
	$("#end_ymd").attr('value', ctime.format('yyyy-MM-dd'));	
	$("#start_ymd").datepicker(); 
	$("#end_ymd").datepicker(); 

	/*getSelectedItem=function(){
		var rsSelected=[];
		$('#example tbody tr :checkbox:checked').each(function(i){
			//alert($(this).attr("value"));
			var id = $(this).attr("value");
			//$rsSelected.push($(this).attr("value"));
			if($(this).children("td").children(":checkbox").attr("checked"))
				rsSelected.push(id);
			
		});
		
		//alert(rsSelected);
		return rsSelected;
	}*/
	
	
	//alert($searchStr);
	 
	var gSearchPaenlData=<?php echo json_encode($searchPanelTableData);?>;
	
	$('#searchPanelTable').dynamicui(gSearchPaenlData);

	function getSearchString(){	
		var searchStr=[];
		var timeSearch=[];
		timeSearch.push("and");
		timeSearch.push("datetime");
		if($('#stimeType').val() === "0")
			timeSearch.push("lastTime");
		else
			timeSearch.push("lastTime");	
			
		timeSearch.push(getDateString($('#start_ymd').attr('value'), $('#s_hour').val(),$('#s_min').val()));
		timeSearch.push(getDateString($('#end_ymd').attr('value'), $('#e_hour').val(),$('#e_min').val()));
	
		
		filterString={"searchType":1,"agentId":"","searchText":""};
		//filterString.agentId=$("#agentId").attr("value");
		if($("#searchPanel").css("display") == "none"){
			var searchValue=$("#searchText").attr("value");
			var likeSearch=["and","set","like",["order_id","client_address","client_cell_phone"],""];
			likeSearch[4]=searchValue;			
			searchStr.push(likeSearch);
			searchStr.push(timeSearch);
			filterString.searchText=searchStr;	
		}
		else{		
			$.each(gSearchPaenlData.elements,function(index,row){
				$.each(row,function(rowIndex,node){		 
					var onSearchItem=[];
					onSearchItem.push("and");
					onSearchItem.push(node.dbtype);
					onSearchItem.push(node.id);
					onSearchItem.push($("#"+node.id).val());

					if(node.type ===2 && $("#"+node.id).val() != '全部'){
						searchStr.push(onSearchItem);
					}	
					if(node.type ===1 && $("#"+node.id).value != ''){
						searchStr.push(onSearchItem);
					}			
				});	
			});
			searchStr.push(timeSearch);
			filterString.searchText=searchStr;
			
		}
		//var $searchStr={};


		return JSON.stringify(filterString);
	}
	
	createTables=function (filterString){
		$('#dataList').dataTable( {
			"bProcessing": true,
			"bServerSide": true,
			"bStateSave" : false,
			"aoColumnDefs": [
				{
					"fnRender": function ( oObj ) {
						return '<input type=\"checkbox\"  value="'+ oObj.aData[0] +'"> ';
					},
					"aTargets": [0]
				}
			],
			"fnCreatedRow": function( nRow, aData, iDataIndex ) {
				
    		},
			"aoColumns": [
				{"bSortable":false,"mDataProp":"0"},{"mDataProp":"1"},{"mDataProp":"2"},
				{"mDataProp":"3"},{"mDataProp":"4"},{"mDataProp":"5"},{"mDataProp":"6"},
				{"mDataProp":"7"},{"mDataProp":"8"},{"mDataProp":"9"},{"mDataProp":"10"}
			],
			"iDisplayLength": 10,
			"fnServerParams": function (aoData) {
				var externData={ "name": "filterString", "value": "my_value" };
				externData.value=filterString;
				aoData.push(externData);
			},
			"sAjaxSource": "<?php echo site_url('order/ajaxOrderFormFind')?>",
			"oLanguage": {
				"sUrl": "<?php echo $this->config->item('base_url')?>/www/lib/dataTable/de_DE.txt"
			}
			
    	}); 
	}	
	
	createTables(getSearchString());
	$req={agent:''};
	$req.agent=$('#agentId').attr('value');
	
	$.post("<?php echo site_url('role/ajaxGetRoleByAgent')?>",$req,function(ret){	
		
		if(ret.isOk){
			if(ret.delete_client){
				
				$('#btnDelAll').css('visibility','visible');
				$('#btnDel').css('visibility','visible');
			}
			if(ret.export_client){
				$('#btnExport').css('visibility','visible');
			}
		}													
	});  
			
	$("#btnSearch").click(function(){
		filterString=getSearchString();
		var oTable = $('#dataList').dataTable();
		oTable.fnDestroy();	
		createTables(filterString);	
	});
	function refreashTable(){
		var oTable = $('#dataList').dataTable();
		oTable.fnDestroy();	
		createTables(getSearchString());
	}
	
	
	
	//高级搜索
	$("#btnAdvance").click(function(){		
		if($("#searchPanel").css("display") == "none")
			$("#searchPanel").css("display","block");
		else
			$("#searchPanel").css("display","none");
	});
	
	//导出文件
	$("#btnExport").click(function(){
	    // var dbMap=openClientExportDialog();
		 $ids=[];
		 $datas=[];
		
		 
		 $('#example tbody tr :checkbox:checked').each(function(){
		 $datas.push($(this).attr("value"));});
		 for(var i in $datas){			
			var $item=[];
			$item.push('or');
			$item.push('varchar');
			$item.push('order_id');
			$item.push($datas[i]);	
			$ids.push($item);
		 }

		 var req={"filterString":"","ids":[],"dbMap":[]};
		 req.filterString=getSearchString();
		 req.ids=$ids;
		
		 $("#csvUrl").html("");		 
		
		 $.post("<?php echo site_url('export/ajaxOrderFormExport')?>",req,function(res){	
			$("#csvUrl").attr("href", res.path);
			$("#csvUrl").html(res.fileName);					  							
		});  	
	});
	
	$("#btnDelAll").click(function(){
		 if(confirm("确定要删除满足查询条件的所有客户吗？")){
			$req={'filterString':'','campaignId':''};
			$req.filterString= getSearchString();	
			alert($req.filterString);

			//$req.campaignId=window.parent.parent.document.getElementById('vicidial_campaign_id').value;
			$.post("<?php echo site_url('client/ajaxDeleteAllFormClient')?>",$req,function(res){	
				if(res.ok)
					refreashTable();									
			});  
		 }
	});
	
	$("#btnDel").click(function(){
		 if(confirm("确定要删除选中的客户吗？")){		 
			$ids=[];
			$datas=[];
			//var datas=getSelectedItem();
			$('#example tbody tr :checkbox:checked').each(function(){
			$datas.push($(this).attr("value"));});

			//alert($datas[0]);
			for(var i in $datas){			
				var $item=[];
				$item.push('or');
				$item.push('varchar');
				$item.push('order_id');
				$item.push($datas[i]);	
				$ids.push($item);
			}
			$req={'ids':[],'campaignId':''};
			$req.ids=$ids;

			//$req.campaignId=window.parent.parent.document.getElementById('order_id').value;

			$.post("<?php echo site_url('client/ajaxDeleteOneFormClient')?>",$req,function(res){
				if(res.ok)	
					refreashTable();									
			}); 		 
		 }
	});
});
</script>    
</head>
<body scroll="auto">
<input id='agentId' type="hidden" value="<?php  echo $agentId;?>">
<div class="page_main page_tops">
	<div class="page_nav">
         <div class="nav_ico"><img src="www/images/page_nav_ico.jpg" /></div>
         <div class="nav_">当前位置：&gt; 订单查询</div>
         <div class="nav_other"></div>
	</div>
    <div class="func-panel">
			 <div class="left"><input type="text" id="searchText">
             时间类型<select id="stimeType" name="select"><option value="1">最后沟通时间</option><option value="0">导入时间</option></select>
          从
          <input type="text" name="start_ymd"   id="start_ymd" value="" style="width:80px"/>
         <?php echo form_dropdown('s_hour',$beginTime['hourOptions'],$beginTime['hourDef'],'id="s_hour"')?><?php echo form_dropdown('s_min',$beginTime['minOptions'],$beginTime['minDef'],'id="s_min"');?>
       	 到<input type="text" name="end_ymd"   id="end_ymd" value="" style="width:80px"/>
  <?php echo form_dropdown('e_hour',$endTime['hourOptions'],$endTime['hourDef'],'id="e_hour"');?><?php echo form_dropdown('e_min',$endTime['minOptions'],$endTime['minDef'],'id="e_min"'); ?>
          
			 	<input type="button" id="btnSearch" value="搜索" class="btnSearch"/>
                <input type="button" id="btnAdvance" value="高级" class="btnSearch"/>
                <input type="button" id="btnExport" value="导出" style="visibility:hidden;" class="btnSearch"/>
                <a id="csvUrl" href='export_datas/clients_09Apr12.csv'></a>
			 </div>
			 <div align='right' class="right">
				 <input  id='btnDel' type="button" name="btnSearch" value="删除 " class="btnDel" style="visibility:hidden;" />
                 <input   id='btnDelAll' type="button" name="btnSearch" value="删除所有 " class="btnDel" style="display:none;visibility:hidden;" />&nbsp;
			 </div>		
			 <div style="clear:both;"></div>  
	</div>	
   <div id="searchPanel" style="display:none;margin-top:5px;margin-bottom:5px">
    	<table  id="searchPanelTable" width="100%">
        <tbody></tbody>	
		</table>	
    </div>
   <div id="example" style='display:block'>
          <table width="100%" cellpadding="0" cellspacing="0" border="0"  id="dataList" >
          		<thead>
                	<tr>
						<th align="left" id="cbAll" width="20px"><input   type="checkbox" value="全选" /></td>
						<th align="left">订单单号</th>
						<th align="left">状态</th>
						<th align="left">产品</th>
						<th align="left">客户姓名</th>
						<th align="left">来电号码</th>
						<th align="left">地址</th>
						<th align="left">快递</th>
						<th align="left">登记时间</th>
						<th align="left">话务员</th>
						<th align="left">来电时间</th>
                    </tr>               
            </thead>
          </table>
      </div>
</div>
</body>
</html>