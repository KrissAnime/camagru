var modalImg = document.getElementById("modal_image");
	var captionText = document.getElementById("caption");
	var modal = document.getElementById('myModal');
	
	function submit_comment(event) {
		var user_comment = document.getElementById('user_comment').value;
		var modal_img = document.getElementById('modal_img_name');
		var img_name = modal_img.value;
		var xhttp = new XMLHttpRequest();
		
		xhttp.open("POST", "functions/submit_comment.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var comments = document.getElementById('my_comments');
				if (this.responseText === "empty"){
					window.alert("You Need to Actually Add A Comment");
				}
				else if (this.responseText === "too_long"){
					window.alert("Comment Limited To 400 Characters");
				}
				else{
					comments.innerHTML = this.responseText;
					// console.log(event);
				}
			}
  		}
  		xhttp.send("user_comment="+user_comment+"&img_name="+img_name);
		//   user_comment = "";
		return false;
		  
	}

	function like_event(event, source){
		var heart = event.target;
		var xhttp = new XMLHttpRequest();
  		
		if (heart.classList.contains('fas', 'fa-heart')){
			var like = 'yes';
		}
		else{
			var like = 'no';
		}

		xhttp.open("POST", "functions/likes.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText === "fail"){
					window.alert("You Need To Login First");
				}
				else{
					if (heart.classList.contains('fas', 'fa-heart')){
						heart.classList.remove('fas', 'fa-heart');
						heart.classList.add('far', 'fa-heart');
						location.reload();
					}
					else{
						heart.classList.remove('far', 'fa-heart');
						heart.classList.add('fas', 'fa-heart');
						location.reload();
					}
				}
			}
  		};
  		xhttp.send("like="+like+"&source="+source);
	}

	function blowup(event, img){
		var heart = event.target;
		var xhttp = new XMLHttpRequest();
		

		xhttp.open("POST", "functions/comments.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var comments = document.getElementById('my_comments');
				if (this.responseText !== "fail"){
					comments.innerHTML = this.responseText;
				}
			}
		}

		var modal_img = document.getElementById('modal_img_name');
		modal_img.value = img;
		modal.style.display = "block";
		modalImg.style.backgroundImage = 'url(images/' + img +')';

		xhttp.send("img_name="+img);
	}
	
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
		modal.style.display = "none";
    }
    
function delete_image(source) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../functions/delete.php", true);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    // xhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         var comments = document.getElementById('my_comments');
    //         if (this.responseText !== "fail"){
    //             location.reload();
    //         }
    //     }
    // }
    // xhttp.send("source="+source);
}