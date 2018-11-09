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
var image;
var image2 = new Image();
var underlay_image = new Image();
var overlay;
var underlay;
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');
var capture = document.getElementById('capture');
var main_image = document.getElementById('main_image');

function background_image (event){
    var upload_image = document.getElementById('upload_image');
    underlay = event.target.style.backgroundImage.slice(5, -2);
    console.log(underlay);

    upload_image.style.backgroundImage = 'url('+underlay+')';
    main_image.value = underlay;
    // console.log(image);
    // underlay.style.backgroundImage = 'url(stickers_borders/' + image +')';

}

function sticker (event){
    image = event.target.style.backgroundImage.slice(22, -2);
    // console.log(image);
    overlay = document.getElementById('overlay');
    var sticker_2 = document.getElementById('sticker_2');

    sticker_2.value = image;
    overlay.style.backgroundImage = 'url(stickers_borders/' + image +')';
    // console.log(image);
    // console.log(overlay);
    capture.disabled = false;
    // var 
}

capture.addEventListener("click", function(){
    // var overlay = document.getElementById('overlay');
    var video = document.getElementById('video');
    // console.log(video);
    var submit = document.getElementById('submit_image');
    // console.log(image);
    // console.log(overlay);
    if (underlay != ""){
        // console.log(upload);
        underlay_image.src = underlay;
        context.drawImage(underlay_image, 0, 0, 500, 500);
    }
    else{
        main_image.value = video;
        context.drawImage(video, 0, 0, 500, 500);
    }
    // context.drawImage(video, 0, 0, 500, 300);

    image2.src = '/camagru/stickers_borders/' + image;
    context.drawImage(image2, 0, 0, 500, 300);
    submit.disabled = false;
}
);

