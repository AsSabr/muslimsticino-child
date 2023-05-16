/**
 * Copyright
 */
export function copyrightLink() {

    const addCopyrightLink = () => {
        //Get the selected text and append the extra info
        let selection = window.getSelection();
        let page_link = '... <br><br> Подробнее:<br>&copy; ' + document.location.href;
        let copy_text = selection + page_link;
        //Create a new div to hold the prepared text
        let new_div = document.createElement('div');
        //hide the newly created container
        new_div.style.position = 'absolute';
        new_div.style.left = '-99999px';
        //insert the container, fill it with the extended text, and define the new selection
        document.body.appendChild(new_div);
        new_div.innerHTML = copy_text;
        selection.selectAllChildren(new_div);
        window.setTimeout(function () {
            document.body.removeChild(new_div);
        }, 100);
    };
    document.addEventListener('copy', addCopyrightLink);
}