   $(function(){
              var url1 = "{:U('Student/modifyLink')}";
              var url2 = "{:U('Student/modifyPwd')}";
              $('#btn1').click(function() {
                  /* Act on the event */
                  if(arr1[0]&&arr1[1]){
                      var link = $('#form1').serialize();
                      $.post(url1,link,function(data){
                        if(data === "ok"){
                         $("#myModal").modal({
                        //    remote:"test/test.jsp";//可以填写一个url，会调用jquery load方法加载数据
                        //    backdrop:"static";//指定一个静态背景，当用户点击背景处，modal界面不会消失
                            keyboard:true,//当按下esc键时，modal框消失
                            });
                          $('.msg').each(function(index, el) {
                               $(this).hide();
                          });
                        }
                      })
                  }   
              });
              $('#btn2').click(function() {
                  if(arr2[0]&&arr2[1]){
                      var link = $('#form2').serialize();
                     // alert(link);
                      $.post(url2,link,function(data){
                        alert(data);
                        if(data === "ok"){
                         $("#myModal").modal({
                            keyboard:true, });
                          $('.msg').each(function(index, el) {
                               $(this).hide();
                          });
                          $('#form2').find('input[type="password"]').each(function(){
                                $(this).val('');
                          })
                         }
                         else{
                              $('#msg1').show().text("原密码输入不正确！");
                              $('.msg').each(function(index, el) {
                               $(this).hide();
                            });
                         }
                      })
                  }   
              });
              $('#inputOldPassword').focus(function(event) {
                  /* Act on the event */
                  $('#msg1').hide();
              });
         });
function getLength(str){
    return str.replace(/^\x00-xff/g,"xx").length;
}
var arr1 = [true,true];
var arr2 = [true,true];
window.onload = function(){
      var oPhone = document.getElementById('inputPhoneNum');
      var eMail = document.getElementById('inputEmailAdd');
      var pwd =document.getElementById('inputNewPassword');
      var pwd2 =document.getElementById('confirmPassword');
      var aP=document.getElementsByTagName('p');
      var oPhone_msg=aP[0];
      var eMail_msg=aP[1];
      var pwd_msg=aP[2];
      var pwd2_msg=aP[3];
      
       //邮箱验证
   eMail.onfocus=function(){
       eMail_msg.style.display="inline";
   }
   eMail.onblur=function(){
       var re_e= /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/g;
       if(!re_e.test(this.value)){
          arr1[0] = false;
          eMail_msg.innerHTML='<i class="err"></i>请输入正确的邮箱!!';
       }
       else{
           arr1[0] = true;
           eMail_msg.innerHTML='<i class="ok"></i>验证通过&nbsp<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
       }
   }
   
   
   
   //手机号验证
   oPhone.onfocus=function(){
       oPhone_msg.style.display="inline";
   }
   oPhone.onblur=function(){
       var re_p = /^[1][3578][0-9]{9}$/;
       if(!re_p.test(this.value)){
           arr1[1] = false;
           oPhone_msg.innerHTML='<i class="err"></i>请输入正确的手机号!!';
           
       }
       else{
           arr1[1] = true;
           oPhone_msg.innerHTML='<i class="ok"></i>手机号验证通过&nbsp<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
       }
   }
   
   //密码
   pwd.onfocus=function(){
       pwd_msg.style.display="inline";
       
   }
   pwd.onblur=function(){
       
       //不能为空
       if(this.value===""){
           arr2[0] = false;
           pwd_msg.innerHTML='<i class="err"></i>不能为空!';
       }
       //OK
       else{
           arr2[0] = true;
           pwd_msg.innerHTML='<i class="ok"></i>&nbsp<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
       }
      
       
    }
   //确认密码
     pwd2.onfocus=function(){
       pwd2_msg.style.display="inline";
       
    }
    
    pwd2.onblur=function(){
        if(this.value===""){
           arr2[1] = false;
           pwd2_msg.innerHTML='<i class="err"></i>不能为空!';
       }
       else if(this.value!=pwd.value){
           arr2[1] = false;
        pwd2_msg.innerHTML='<i class="err"></i>两次输出的密码不一致,请重新输入!!';
           
       }
       else{
            arr2[1] = true;
            pwd2_msg.innerHTML='<i class="ok"></i>&nbsp<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
       }
    }
   
      
}