PHPExcel-import-export
excel的导入/导出

方法一
//form表单提交 新窗口打开
function be(){  
    document.form.submit();  
}  

方法二
使用window.open打开一个新窗口
$('#exportCard').on('click',function(){
    var checks=$(".App-check:checked");
    var chk='';
    $(checks).each(function(){
        chk+=$(this).val()+',';
    });
    window.open("{:U('Admin/Vip/cardExport')}/type/{$type}/id/"+chk);
})
