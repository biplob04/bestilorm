function showModal(index, eClass) {
	eClass[index].style.display = 'block';
}

window.onclick = function(event) {
	var modal = document.getElementsByClassName('modal-box');

	for (var i = 0; i < modal.length; i++) {
		if(event.target == modal[i]) {
			modal[i].style.display = 'none';
		} 
	}
}

