inputElements = document.getElementsByClassName("pickr");
container = document.querySelector('.color-picker-contain');
primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primaryh');

for (var elm = 0; elm < inputElements.length; elm ++) {
 pickr = new Pickr({
    el: elm,
    useAsButton: true,
    default: primaryColor,
    appClass: 'color-picker',
    lockOpacity: true,
    theme: 'nano',
    defaultRepresentation: 'HEX',
    position: 'bottom',
    padding: 3,

    swatches: [
        '#D65A67', 
        '#FFB06D', 
        '#00BF9F', 
        '#008DB7',
        '#6F70A6',
        '#BF94FF', 
        '#FF72C0', 
    ],

    components: {
        preview: true,
        opacity: false,
        hue: true
    }

    
    }).on('init', pickr => {
    inputElement.value = pickr.getSelectedColor().toHEXA().toString(0);
    container.style.background = pickr.getSelectedColor().toHEXA().toString(0);
    }).on('change', color => {
        inputElement.value = color.toHEXA().toString(0);
        container.style.background = color.toHEXA().toString(0);
    })
}

function updateColorPickerLabel(classCode) {
    classCode = classCode.name;
    classCheckedOff = document.getElementById(classCode);
    classLabel = document.getElementById(classCode + "-picker-label");
    classContain = document.getElementById(classCode + "-picker-contain");
    classColor = document.getElementById(classCode + "-color-picker")
    if (classCheckedOff.checked == true) {
        classLabel.classList.add("crossed");
        classContain.classList.add("crossed");
        classColor.classList.add("invisible");
    } else {
        classLabel.classList.remove("crossed");
        classContain.classList.remove("crossed");
        classColor.classList.remove("invisible");
    }
}