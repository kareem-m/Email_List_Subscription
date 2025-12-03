const popup = document.getElementById('popup');
if (popup) {
    setTimeout(() => {
        popup.classList.add('fade-out');
    }, 5000);
}

const overlay = document.createElement('div');
overlay.id = 'overlay';
document.body.appendChild(overlay);

function showBox(id) {
    const box = document.getElementById(id);
    box.classList.add('active');
    overlay.classList.add('active');
}

function hideAllBoxes() {
    const boxes = document.querySelectorAll('#box1, #box2, #box3');
    boxes.forEach(box => box.classList.remove('active'));
    overlay.classList.remove('active');
}

document.getElementById('button1').addEventListener('click', () => showBox('box1'));
document.getElementById('button2').addEventListener('click', () => showBox('box2'));
document.getElementById('button3').addEventListener('click', () => showBox('box3'));

document.querySelectorAll('.close').forEach(btn => {
    btn.addEventListener('click', hideAllBoxes);
});

document.addEventListener('click', function (e) {
    const boxes = document.querySelectorAll('#box1, #box2, #box3');
    boxes.forEach(box => {
        if (box.classList.contains('active')) {
            if (!box.contains(e.target) && !e.target.matches('button')) {
                hideAllBoxes();
            }
        }
    });
});

overlay.addEventListener('click', hideAllBoxes);