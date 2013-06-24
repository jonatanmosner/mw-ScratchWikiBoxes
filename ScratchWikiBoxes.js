document.getElementById('forumLink').onclick = function () {
	document.getElementById('forumLink').focus();
	document.getElementById('forumLink').select();
	document.getElementById('forumLink').onmouseup = function () {
		document.getElementById('forumLink').onmouseup = null;
		return false;
	};
};