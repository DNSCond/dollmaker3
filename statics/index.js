// datadex
const img = document.querySelector('#main-svg'), a = document.createElement('a');
document.querySelector('button[type=button].convertpng').addEventListener('click',
    () => createImageBitmap(img).then(imageBitmap => {
        const canvas = new OffscreenCanvas(imageBitmap.width, imageBitmap.height);
        canvas.getContext("2d").drawImage(imageBitmap, 0, 0);
        return canvas.convertToBlob();
    }).then(blob => {
        a.download = Date();
        const blobHref = a.href = URL.createObjectURL(blob);
        document.body.append(a);
        a.click();
        return new Promise(resolve => setTimeout(resolve, 5000, blobHref));
    }).then(URL.revokeObjectURL).finally(() => a.remove()),
);