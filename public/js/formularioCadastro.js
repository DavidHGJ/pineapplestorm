validarCampos = (selectorContainerCampos, selectorHabilitar, nomeClasse) => {
    let selector = `${selectorContainerCampos} input,
                    ${selectorContainerCampos} select,
                    ${selectorContainerCampos} textarea`;
    validacao = true;

    $(selector).each(function (index, element) {
        switch ($(element).context.localName) {
            case 'input':
                switch($(element).attr(`type`)) {
                    case 'text':
                    case 'date':
                    case 'number':
                    case 'password':
                        if ($(element).val() == '')
                            validacao = false;
                    break

                    case 'checkbox':
                    case 'radio':
                        if (!$(`input[name="${$(element).attr('name')}"]:checked`).length > 0)
                            validacao = false
                    break
                }
            break

            case 'select':
                if ($(element).val() == '')
                    validacao = false;
            break

            case 'textarea':
                if ($(element).val() == '')
                    validacao = false;
            break
        }
    });

    if (validacao)
        removerClass(nomeClasse, selectorHabilitar)
    else
        addClass(nomeClasse, selectorHabilitar)
}

addClass = (nomeClasse, selectorDestino) => {
    $(`${selectorDestino}`).addClass(`${nomeClasse}`)
}

removerClass = (nomeClasse, selectorDestino) => {
    $(`${selectorDestino}`).removeClass(`${nomeClasse}`)
}

transicao = (selectorContainerAtual, selectorContainerDestino) => {
    $(`${selectorContainerAtual}`).fadeOut(300)
    setTimeout(() => {
        $(`${selectorContainerDestino}`).fadeIn(300)
    }, 300)
}