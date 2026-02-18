/**
 * Quill init for admin backend
 * Replaces TinyMCE - targets textarea.rich-editor
 * Quill is free and open source (BSD-3-Clause)
 */
(function() {
    if (typeof Quill === 'undefined') return;
    var textareas = document.querySelectorAll('textarea.rich-editor');
    if (textareas.length === 0) return;

    var quillMap = new WeakMap();

    textareas.forEach(function(ta) {
        var value = ta.value || '';
        var wrapper = document.createElement('div');
        wrapper.className = 'quill-editor-wrap';
        ta.parentNode.insertBefore(wrapper, ta);
        ta.style.display = 'none';

        var editor = document.createElement('div');
        editor.style.minHeight = '200px';
        wrapper.appendChild(editor);

        var quill = new Quill(editor, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'blockquote'],
                    ['clean']
                ]
            }
        });
        quill.root.innerHTML = value;
        quillMap.set(ta, quill);

        quill.on('text-change', function() {
            ta.value = quill.root.innerHTML;
        });
    });

    document.querySelectorAll('form').forEach(function(form) {
        if (!form.querySelector('textarea.rich-editor')) return;
        form.addEventListener('submit', function() {
            form.querySelectorAll('textarea.rich-editor').forEach(function(ta) {
                var q = quillMap.get(ta);
                if (q) ta.value = q.root.innerHTML;
            });
        });
    });
})();
