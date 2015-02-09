//Wer das liest ist doof!
var maxCommentLength = 140;

function check() {
	var tex = document.comment.message.value;
	var len = tex.length;
	var remaining = maxCommentLength - len;
	if (remaining > 20) {
		document.getElementById("counter").innerHTML="<strong>Zeichen verbleibend: " + remaining + "<strong>";
	} else {
		document.getElementById("counter").innerHTML="<strong><font color=\"red\">Zeichen verbleibend: " + remaining + "</font><strong>";
	}
}

function checkCommentSubmit() {
	var tex = document.comment.message.value;
	var len = tex.length;
	if (len > maxCommentLength) {
		alert(unescape("Dein Kommentar besteht aus " + len + " Zeichen, es sind aber nur " + maxCommentLength + " zeichen als Maximall%E4nge erlaubt. Bitte k%FCrze deinen Kommentar"));
		return false;
	} else {
		return true;
	}
}

function disable1() {
	document.baby.button1.disabled = true;
	document.baby.button1.value = "Bitte warten...";
}
			
function disable2() {
	document.aktuell.button2.disabled = true;
	document.aktuell.button2.value = "Bitte warten...";
}

function toggleVisibility(id) {
	var e = document.getElementById(id);
	var parent = document.getElementById(id + "A");
	
	if(e.style.display == 'block') {
		e.style.display = 'none';
		parent.innerHTML = "<strong>&#x25B6; " + id + "</strong>";
	} else {
		e.style.display = 'block';
		parent.innerHTML = "<strong>&#x25BC; " + id + "</strong>";
	}
}

var lastPage = '';

function loadContent(name) {
	if (name != lastPage) {
		lastPage = name;
		
		var xmlHttp = null;
		var content = document.getElementById("realContent");
		
		content.innerHTML = "<div class=\"loading\"><br>Laden... <img src=\"icons/bigrotation2.gif\"></div>";
		
		try {
			xmlHttp = new XMLHttpRequest();
		} catch(e) {
			try {
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch(e) {
				xmlHttp = null;
			}
		}
		
		if (xmlHttp) {
			xmlHttp.open("GET", "contentloader.php?s=" + name, true);
			xmlHttp.onreadystatechange = function() {
				if (xmlHttp.readyState == 4) {
					content.innerHTML = xmlHttp.responseText;
				}
			};
			xmlHttp.send(null);
		}
	}
}

function ShowBigImage(elem, id, event) {
	if (!document.getElementById(id)) {
		newelement = document.createElement('img');
		newelement.id = id;
	} else {
		newelement = document.getElementById(id);
	}
	newelement.src = elem.src;
	newelement.style.position='absolute';
	moveImage(event,id);
	document.body.appendChild(newelement);
}

function moveImage(event, id) {
	var image = document.getElementById(id);
	if(image) {
		image.style.display = 'inline';
		var offset = 15;
		var width = document.body.clientWidth;
		var height = document.body.clientHeight;
		
		if (navigator.appName == 'Microsoft Internet Explorer') {
			offset = 25;
		}
		
		var positionX = mouseX(event) + offset;
		var positionY = mouseY(event) + offset;
		
		if(positionX + image.width > width) {
			image.style.left = positionX - image.width - 2 * offset;
		} else {
			image.style.left = positionX;
		}
		if(image.clientHeight > height) {
			image.style.top = document.body.scrollTop;
		} else if (event.clientY + offset + image.clientHeight > height) {
			image.style.top = height - image.clientHeight + document.body.scrollTop;
		} else {
			image.style.top = positionY;
		}
	}
}

function mouseX(evt) {
	if (evt.pageX) {
		return evt.pageX;
	} else if (evt.clientX) {
		return evt.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft :document.body.scrollLeft);
	} else {
		return null;
	}
}

function mouseY(evt) {
	if (evt.pageY) {
		return evt.pageY;
	} else if (evt.clientY) {
		return evt.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop :document.body.scrollTop);
	} else {
		return null;
	}
}

function removett(id) {
	var tt = document.getElementById(id);
	tt.parentNode.removeChild(tt);
}