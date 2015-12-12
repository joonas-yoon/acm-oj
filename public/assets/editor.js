function loadScript(url, callback) {
    // Adding the script tag to the head as suggested before
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src  = url;

    // Then bind the event to the callback function.
    // There are several events for cross browser compatibility.
    script.onreadystatechange = callback;
    script.onload = callback;

    // Fire the loading
    head.appendChild(script);
}

function initEditor(editor, language, theme, callback) {
    editor.setOptions({
        fontFamily: "consolas, tahoma",
        fontSize: "10pt"
    });
    editor.setTheme("ace/theme/"+(theme != undefined && String(theme).length > 0 ? theme : 'chrome'));
    editor.session.setMode("ace/mode/"+(language != undefined && String(language).length > 0 ? language : 'plain_text'));
    editor.commands.addCommand({
        name: 'fullscreen',
        bindKey: {win: 'Alt-Return',  mac: 'Command-Return'},
        exec: function(editor) {
            $(document.body).toggleClass("fullscreen");
            $(editor.container).toggleClass("fullscreen-editor");
            editor.resize();
        }
    });
    editor.getSession().setTabSize(4);
    editor.getSession().setUseSoftTabs(true);
    document.getElementById('editor').style.display = 'block';
}

function getLanguageClass(language) {
    var defaultClass = 'plain_text';
    var array = {
        'c'     : 'c_cpp',
        'c++'   : 'c_cpp',
        'c++14' : 'c_cpp',
        'java'  : 'java'
    };
    var lang = String(language).toLowerCase();
    return array[lang] == undefined ? defaultClass : array[lang];
}