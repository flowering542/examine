


window.onload =function(){
		    showTime(); 
            sele();			
		  }
		  var n=0;
		  var modal=document.getElementById('myModal');
		  var hold=document.getElementById('ensure');
		  var Btn1=document.getElementById('btn1');
		  var Btn2=document.getElementById('btn2');
		  var Btn3=document.getElementById('btn3');
		  var Btn4=document.getElementById('btn4');
		  var Btn5=document.getElementById('btn5');
		  var Btn6=document.getElementById('btn6');
		  var btn1=document.getElementById('button1');
		  var btn2=document.getElementById('button2');
		  var btn3=document.getElementById('button3');
		  var btn4=document.getElementById('button4');
		  var btn5=document.getElementById('button5');
		  var btn6=document.getElementById('button6');
		  var Dan1=document.getElementsByName('choice1');
		  var Dan2=document.getElementsByName('choice2');
		  var Dan3=document.getElementsByName('choice3');
		  var Dan4=document.getElementsByName('choice4');
		  var D1=document.getElementById('dd1');
		   var D2=document.getElementById('dd2');
		    var D3=document.getElementById('dd3');
			 var D4=document.getElementById('dd4');
         hold.onclick=function(){   
		   alert("提交成功！");
		  }
		  function showTime(){
			 var lefttime=parseInt(600)-n;
			 alert(lefttime);
			 var h = parseInt(lefttime/(60*60));
			 var m = parseInt(lefttime/60%60);
			 var s = parseInt(lefttime%60);
			  m=checkTime(m);
			  s=checkTime(s);
			 document.getElementById('timercontrol').innerHTML ='0'+h+":"+m+":"+s;
			 setTimeout(showTime,1000);
			 n=n+1;
		  }
		  function checkTime(i){
		    if(i<10){
			   i="0"+i;
			}
			return i;
		  }
		  
		  Btn1.onclick=function(){
			  btn1.style.display="block";
			  btn2.style.display="none";
			  btn3.style.display="none";
			  btn4.style.display="none";
			  btn5.style.display="none";
			  btn6.style.display="none";
		  }
		  Btn2.onclick=function(){
			  btn2.style.display="block";
			  btn1.style.display="none";
			  btn3.style.display="none";
			  btn4.style.display="none";
			  btn5.style.display="none";
			  btn6.style.display="none";
		  }
		  Btn3.onclick=function(){
			  btn3.style.display="block";
			  btn2.style.display="none";
			  btn1.style.display="none";
			  btn4.style.display="none";
			  btn5.style.display="none";
			  btn6.style.display="none";
		  }
		  
		  Btn4.onclick=function(){
			  btn4.style.display="block";
			  btn2.style.display="none";
			  btn3.style.display="none";
			  btn1.style.display="none";
			  btn5.style.display="none";
			  btn6.style.display="none";
		  }
		  Btn5.onclick=function(){
			  btn5.style.display="block";
			  btn2.style.display="none";
			  btn3.style.display="none";
			  btn4.style.display="none";
			  btn1.style.display="none";
			  btn6.style.display="none";
		  }
		  
		  Btn6.onclick=function(){
			  btn6.style.display="block";
			  btn2.style.display="none";
			  btn3.style.display="none";
			  btn4.style.display="none";
			  btn5.style.display="none";
			  btn1.style.display="none";
		  }
		  
		  //按钮变色
		  function sele(){
			  for(var i=0;i<Dan1.length;i++){
				  if (Dan1[i].checked){
					
					  
					  D1.style.backgroundColor="#589eda";
				  }
				  else{
					  D1.className="btn btn-default";
				  }
		       }
		   }
		 function change(){
			 sele();
		 }
		  
		  
		  
		  