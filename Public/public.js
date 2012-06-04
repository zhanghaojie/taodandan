/**
 * 
 */
function startUpload() { 
document.getElementById('processing').innerHTML = 'loding...'; 
return true; 
} 
function stopUpload(rel){ 
var msg; 
switch (rel) { 
case 0: 
msg = "上传成功"; 
break; 
case 1: 
msg = "上传的文件超过限制"; 
break; 
case 2: 
msg = "只能上传图片文件"; 
break; 
default: 
msg = "上传文件失败"; 
} 
document.getElementById('processing').innerHTML = rel; 
}
