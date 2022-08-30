function showField(id) {
    document.getElementById(id).parentElement.hidden = false;
    document.getElementById(id).setAttribute("required", "required");
}
function hideField(id) {
    document.getElementById(id).removeAttribute("required");
    document.getElementById(id).parentElement.hidden = true;
}
document.getElementById("productType").onchange = (event) => {
    switch (document.getElementById("productType").selectedIndex){
        case 0:
            showField("size");
            hideField("weight");
            hideField("height");
            hideField("width");
            hideField("length");
            break;
        case 1:
            hideField("size");
            showField("weight");
            hideField("height");
            hideField("width");
            hideField("length");
            break;
        default:
            hideField("size");
            hideField("weight");
            showField("height");
            showField("width");
            showField("length");
    }
}
