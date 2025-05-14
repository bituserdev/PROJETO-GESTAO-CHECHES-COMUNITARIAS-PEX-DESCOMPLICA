// Função para confirmar exclusão
function confirmarExclusao(mensagem) {
    return confirm(mensagem);
}

// Função para aplicar máscara de telefone
function mascaraTelefone(input) {
    let valor = input.value.replace(/\D/g, '');
    let formatado = '';

    if (valor.length > 0) {
        formatado = '(' + valor.substring(0, 2);
        if (valor.length > 2) {
            formatado += ') ' + valor.substring(2, 7);
            if (valor.length > 7) {
                formatado += '-' + valor.substring(7, 11);
            }
        }
    }
    input.value = formatado;
}

// Função para validar formulário
function validarFormulario(form) {
    let campos = form.querySelectorAll('[required]');
    let valido = true;

    campos.forEach(campo => {
        if (!campo.value) {
            campo.classList.add('is-invalid');
            valido = false;
        } else {
            campo.classList.remove('is-invalid');
        }
    });

    return valido;
}

// Inicialização de componentes Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    // Ativar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Ativar popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});

// Função para atualizar status de presença
function atualizarPresenca(alunoId, presente) {
    let row = document.querySelector(`tr[data-aluno-id="${alunoId}"]`);
    if (row) {
        row.classList.toggle('table-success', presente);
    }
}

// Função para filtrar tabelas
function filtrarTabela(input, tabela) {
    let termo = input.value.toLowerCase();
    let linhas = document.querySelectorAll(`${tabela} tbody tr`);

    linhas.forEach(linha => {
        let texto = linha.textContent.toLowerCase();
        linha.style.display = texto.includes(termo) ? '' : 'none';
    });
}