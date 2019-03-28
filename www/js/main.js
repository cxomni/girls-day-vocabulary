Vocabulary = {};

Vocabulary.disableLanguage = function ($this) {
    let translator = document.getElementById("language-translation");
    if ($this.value === "") {
        translator.disabled = true;
        return false;
    }
    translator.disabled = false;

    let options  = translator.getElementsByTagName("option");
    for (let i = 0; i < options.length; i++) {
        options[i].selected = (options[i].value === "");
        options[i].disabled = ($this.value === options[i].value);
    }
};

Vocabulary.goTo = function($step) {
    document.querySelectorAll('.catalog-page').forEach(elem => {
        elem.classList.add('hidden');
    });
    document.getElementById('page-'+$step).classList.remove('hidden');
};


window.addEventListener("DOMContentLoaded", function() {
    if (window.speechSynthesis !== undefined) {
        var wiedergaben = document.getElementsByClassName("wiedergabe");
        for (let i = 0; i < wiedergaben.length; i++) {
            wiedergaben[i].addEventListener("click", function() {
                if (this.classList.contains('solution-hidden')) {
                    return false;
                }
                var lang = this.dataset.lang;
                var words = this.innerHTML;
                var worte = new SpeechSynthesisUtterance(words);
                worte.lang = lang.replace("_", "-");
                window.speechSynthesis.speak(worte);
            }, false);
        }
    }
}, false);