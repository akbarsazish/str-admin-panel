document.addEventListener('DOMContentLoaded', () => {

    const resizableTable = document.querySelector('.resizeAbleTable');
    const resizableThs = resizableTable.querySelectorAll('.resizable');

    resizableThs.forEach(th => {
    const resizeHandle = document.createElement('div');
    resizeHandle.classList.add('resize-handle');
    th.appendChild(resizeHandle);

    let startX;
    let startWidth;

    resizeHandle.addEventListener('mousedown', (event) => {
        startX = event.pageX;
        startWidth = th.offsetWidth;

        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', () => {
        document.removeEventListener('mousemove', onMouseMove);
        });
    });

    function onMouseMove(event) {
        const width = startWidth + (event.pageX - startX);
        th.style.width = `${width}px`;

        // Set the corresponding td's width
        const columnIndex = Array.from(th.parentElement.children).indexOf(th);
        const tds = Array.from(resizableTable.querySelectorAll(`td:nth-child(${columnIndex + 1})`));
        tds.forEach(td => {
        td.style.width = `${width}px`;
        });
    }
    });

});


