/**
 * 
 */
function gotoRegister(){
	var cover=document.getElementById('cover');
	cover.style.display='none';
	
	var signin=document.getElementById('login');
	signin.style.display='none';
	
	var register=document.getElementById('register');
	register.style.display='table-cell';
}	

function gotoLogin(){
	var cover=document.getElementById('cover');
	cover.style.display='none';
	
	var signin=document.getElementById('login');
	signin.style.display='table-cell';
	
	var register=document.getElementById('register');
	register.style.display='none';
}	

function gotoCover(){
	var cover=document.getElementById('cover');
	cover.style.display='table-cell';
	
	var signin=document.getElementById('login');
	signin.style.display='none';
	
	var register=document.getElementById('register');
	register.style.display='none';
}	

function redirectRegister(){
	try{
	gotoRegister();
	}catch(err){
	window.location.href = "index.php#register";}
}
function redirectLogin(){
	try{
	gotoLogin();
	}catch(err){
	window.location.href = "index.php#login"}
}