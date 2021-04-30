var formula = 'sqrt((2 * D * cp) / (i * v))';

function calcular() {
    let campos = $('form input');
    let escopo = {};
    for (let i = 0; i < campos.length; ++i) {
        escopo[campos[i].id] = campos[i].value;
    }
    $('#resultado').val(math.evaluate(formula, escopo));
}