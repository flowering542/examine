
window.onload=function(){
	var slideBox = document.getElementById('slideBox');
	var slide = document.getElementById('slide');
	var buttons = document.getElementById('buttons').getElementsByTagName('span');
	var prev = document.getElementsByClassName('fa fa-angle-left fa-2x')[0];
	var next = document.getElementsByClassName('fa fa-angle-right fa-2x')[0];
	var index=1;
	var timer;
	function showButton(){
		for(var i=0;i< buttons.length;i++){
			if(buttons[i].className =='on'){
				buttons[i].className='';
				break;
			}
			
		}
		buttons[index - 1].className = 'on';
	}
	
	function animate(offset){
		
		slide.style.left = parseInt(slide.style.left) + offset + 'px';
		if(parseInt(slide.style.left)> -550){
			slide.style.left = -2750+'px';
			
		}
		if(parseInt(slide.style.left) < -2750){
			slide.style.left = -550+'px';
		}
	}
	
	
	function play(){
		timer = setInterval(function(){
			next.onclick();
		},3000);
	}
	function stop(){
		clearInterval(timer);
	}
	
	next.onclick = function(){
		if(index == 5){
			index = 1
		}
		else{
			index = index + 1;
		}
		showButton();
		animate(-550);
	}
	prev.onclick = function(){
		if(index == 1){
			index = 5
		}
		else{
			index = index - 1;
		}
		
		showButton();
		animate(550);
	}
	for(var i=0; i < buttons.length;i++){
		buttons[i].onclick =function(){
			if(this.className == 'on'){
				return;
			}
			var myIndex =parseInt( this.getAttribute('index'));
			var offset = -550 * (myIndex - index);
			animate(offset);
			index = myIndex;
			showButton();
		}
	}
	slideBox.onmouseover = stop;
	slideBox.onmouseout = play;
	
	play();
}

