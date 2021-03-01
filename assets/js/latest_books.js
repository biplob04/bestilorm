count = 0;
/** sls = second list shown **/
function hideBooks(sls) {
    if (sls == false) {
        hideBooksContent('rtlShow', 'rtlHide');
        count = 1;
    } else {
        if(count > 0)
            hideBooksContent('ltrHide', 'ltrShow');
    }
}

function hideBooksContent(book2anim, book1anim) {
    var books2 = document.getElementById('lat-books2');
    var books1 = document.getElementById('lat-books1');

    books2.style.animation = book2anim;
    books2.style.animationDuration = '0.4s';
    books2.style.animationFillMode = 'forwards';
    books1.style.animation = book1anim;
    books1.style.animationDuration = '0.4s';
    books1.style.animationFillMode = 'forwards';
}