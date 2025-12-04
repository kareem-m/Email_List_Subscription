// Popup Message
const popup = document.getElementById('popup');
if (popup) {
    setTimeout(() => {
        popup.classList.add('fade-out');
    }, 5000);
}

// Overlay Blur
const overlay = document.createElement('div');
overlay.id = 'overlay';
document.body.appendChild(overlay);

// Buttons and Boxes
const buttons = ["mngDepartmentBtn", "mngEmployeeBtn", "mngEmailBtn"];
const boxes = ["mngDepartmentBox", "mngEmployeeBox", "mngEmailBox"];

// Open main boxes
buttons.forEach((btnId, index) => {
    document.getElementById(btnId).addEventListener('click', () => {
        document.getElementById(boxes[index]).classList.add("active");
        overlay.classList.add('active');
    });
});

// Close buttons
const closeBtns = document.querySelectorAll('.close');
closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        boxes.forEach(boxId => {
            document.getElementById(boxId).classList.remove('active');
        });
        overlay.classList.remove('active');
    });
});

// Close Boxes on Outside Click
document.addEventListener('click', (e) => {
    const clickedInsideBox = boxes.some(boxId => document.getElementById(boxId).contains(e.target));
    const clickedButton = buttons.some(btnId => document.getElementById(btnId).contains(e.target));
    if (!clickedInsideBox && !clickedButton) {
        boxes.forEach(boxId => {
            document.getElementById(boxId).classList.remove('active');
        });
        overlay.classList.remove('active');
    }
});