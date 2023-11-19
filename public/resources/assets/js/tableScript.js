document.addEventListener('DOMContentLoaded', () => {
    const resizableThs = document.querySelectorAll('th');
  
    resizableThs.forEach((th) => {
      const columnId = th.id;
      const columnClass = `.${columnId}`;
      let startX;
      let startWidth;
  
      // Set the initial width for both <th> and <td>
      const initialWidth = th.offsetWidth + 'px';
      th.style.width = initialWidth;
  
      // Set the initial width for <td> elements in the same column
      const associatedTds = document.querySelectorAll(columnClass);
      associatedTds.forEach((td) => {
        td.style.width = initialWidth;
      });
  
      th.addEventListener('mousedown', (e) => {
        startX = e.pageX;
        startWidth = th.offsetWidth;
  
        document.addEventListener('mousemove', handleMouseMove);
        const isRTL = document.documentElement.dir === 'rtl';
  
        function handleMouseMove(e) {
          const offset = isRTL ? startX - e.pageX : e.pageX - startX;
          const newWidth = startWidth + offset;
          th.style.width = newWidth + 'px';
  
          associatedTds.forEach((td) => {
            td.style.width = newWidth + 'px';
          })
        };
  
        document.addEventListener('mouseup', () => {
          document.removeEventListener('mousemove', handleMouseMove);
        });
      });
    });
  });
  