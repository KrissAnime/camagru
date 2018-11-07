var video = document.getElementById('video');
// console.log("works");
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(
        function(stream) {
            video.src = window.URL.createObjectURL(stream);
            // video.play();
        }
        );
}

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');
var capture = document.getElementById('capture');



capture.addEventListener("click", function(){
    var sticker = document.getElementById('drawn_sticker');
    var video = document.getElementById('video');
    console.log(video);
    context.drawImage(video, 0, 0, 500, 500);
    context.drawImage(sticker, 0, 0, 500, 500);
}
);

