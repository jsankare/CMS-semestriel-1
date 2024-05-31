document.addEventListener("DOMContentLoaded", function() {
    const quill = new Quill('#editor', {
        placeholder: 'Entrez votre contenu ici',
        theme: 'snow',
    });
    const form = document.querySelector('form');
    form.onsubmit = function() {
        const content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;
    };
});
