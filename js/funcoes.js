var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
var formula = 'sqrt((2 * D * cp) / (i * v))';

function calcular() {
    let campos = $('form input');
    let escopo = {};
    for (let i = 0; i < campos.length; ++i) {
        escopo[campos[i].id] = campos[i].value;
    }
    $('#resultado').val(math.evaluate(formula, escopo));
}