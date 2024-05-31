document.addEventListener('DOMContentLoaded', function() {
    var editors = document.querySelectorAll('[id^="editor-container-"]');
    var quills = {};

    editors.forEach(function(editor) {
        var name = editor.id.replace('editor-container-', '');
        quills[name] = new Quill(editor, {
            theme: 'snow'
        });

        var form = document.querySelector('form');
        form.onsubmit = function() {
            var editorContent = quills[name].root.innerHTML;
            var hiddenInput = document.getElementById('hidden-input-' + name);
            hiddenInput.value = editorContent;
        };
    });
});
