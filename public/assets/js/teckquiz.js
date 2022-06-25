// window.console.log = function () {
//     console.warn("%cSTOP RIGHT YOU ARE CRIMINAL SCUM!", "font: 3em sans-serif; color: yellow; background-color: red;");
//     console.warn("%cAttempting to manipulate anything in this system will lead to serious reperation.", "font: 2em sans-serif; color: yellow; background-color: red;");
//     console.warn("You are attempting to use a feature intended for web developers.");
//     console.warn("If you are here by mistake, press F12 and never look back.")
//     window.console.log = function () {
//         return null;
//     }
// }
console.log("Trying to warn you of using a feature intended for web developers!");

function MoveQuestion(id){
    $('.nav-item a[href="#q' + id + '"]').tab('show');
}

function enableQuiz() {
    $(".disabled").removeClass("disabled");
    $("#v-pills-welcome-tab").addClass("disabled");
    $('.nav-item a[href="#q1"]').tab('show');
}

function theFinalCountdown(){
    
}
