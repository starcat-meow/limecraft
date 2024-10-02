const canvas = document.getElementById('canvas');  
const ctx = canvas.getContext('2d');  
  
const topLeft = document.getElementById('topLeft');  
const topRight = document.getElementById('topRight');  
const bottomLeft = document.getElementById('bottomLeft');  
const bottomRight = document.getElementById('bottomRight');  
  
let cropRect = {  
    x: 50,  
    y: 50,  
    width: 200,  
    height: 150  
};  
  
function drawCropRect() {  
    ctx.clearRect(0, 0, canvas.width, canvas.height);  
    ctx.strokeStyle = 'blue';  
    ctx.strokeRect(cropRect.x, cropRect.y, cropRect.width, cropRect.height);  
  
    // Position handles  
    topLeft.style.left = `${cropRect.x}px`;  
    topLeft.style.top = `${cropRect.y}px`;  
    topRight.style.left = `${cropRect.x + cropRect.width - 5}px`;  
    topRight.style.top = `${cropRect.y}px`;  
    bottomLeft.style.left = `${cropRect.x}px`;  
    bottomLeft.style.top = `${cropRect.y + cropRect.height - 5}px`;  
    bottomRight.style.left = `${cropRect.x + cropRect.width - 5}px`;  
    bottomRight.style.top = `${cropRect.y + cropRect.height - 5}px`;  
}  
  
function updateHandlePositions(e) {  
    const rect = canvas.getBoundingClientRect();  
    const offsetX = e.clientX - rect.left;  
    const offsetY = e.clientY - rect.top;  
  
    // Dragging top-left corner  
    if (e.target === topLeft) {  
        cropRect.width = cropRect.x + cropRect.width - offsetX;  
        cropRect.height = cropRect.y + cropRect.height - offsetY;  
        cropRect.x = offsetX;  
        cropRect.y = offsetY;  
    }  
    // Dragging top-right corner  
    else if (e.target === topRight) {  
        cropRect.width = offsetX - cropRect.x;  
        cropRect.height = cropRect.y + cropRect.height - offsetY;  
    }  
    // Dragging bottom-left corner  
    else if (e.target === bottomLeft) {  
        cropRect.width = cropRect.x + cropRect.width - offsetX;  
        cropRect.height = offsetY - cropRect.y;  
    }  
    // Dragging bottom-right corner  
    else if (e.target === bottomRight) {  
        cropRect.width = offsetX - cropRect.x;  
        cropRect.height = offsetY - cropRect.y;  
    }  
  
    drawCropRect();  
}  
  
// Attach event listeners to handles  
[topLeft, topRight, bottomLeft, bottomRight].forEach(handle => {  
    handle.addEventListener('mousedown', (e) => {  
        e.preventDefault();  
        window.addEventListener('mousemove', updateHandlePositions);  
        window.addEventListener('mouseup', () => {  
            window.removeEventListener('mousemove', updateHandlePositions);  
        });  
    });  
});  
  
// Initial draw  
drawCropRect();