document.addEventListener("DOMContentLoaded", function() {
    const toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],

        ['clean'],                                         // remove formatting button

        ['link', 'image']                                  // link and image
    ];

    const quill = new Quill('#editor', {
        placeholder: 'Entrez votre contenu ici',
        theme: 'snow',
        modules: {
            toolbar: toolbarOptions,
            imageResize: {
                modules: ['Resize', 'DisplaySize', 'Toolbar']
            }
        }
    });

    const form = document.querySelector('form');
    form.onsubmit = function() {
        const content = document.querySelector('input[name=content]');
        content.value = quill.root.innerHTML;
    };
});
