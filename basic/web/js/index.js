setInterval(()=>{
    $.pjax.reload('#requests');
},5000);

$(document).on('pjax:complete', ()=>{
    if (count !== $("#requests span").text()) {
        count = $("#requests span").text();

        let audio = new Audio('/sound/sound.mp3');
        audio.play();
    }
});