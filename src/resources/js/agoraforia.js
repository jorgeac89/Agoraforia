function modPost(){
	var post=document.getElementById("newPostContent").value;
	post=post.replace(/\n/g, "</br>\n");
	document.getElementById("preview").innerHTML=post;
}
			
function insPicture(){
	alert("picture");
}

function mStyle(tag){
	var postText = document.getElementById("newPostContent");
	var start = postText.selectionStart;
	var end = postText.selectionEnd;
	
	var startText = postText.value.substring(0, start);
	var innerText = postText.value.substring(start, end);
	var endText = postText.value.substring(end);

	if(start!=end){
		postText.value=startText+"<"+tag+">"+innerText+"</"+tag+">"+endText;
		postText.selectionStart=start;
		postText.selectionEnd=end+tag.length*2+5;
	}
	modPost();
	postText.focus();
}
