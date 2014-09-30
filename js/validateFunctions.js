function verificaTipoPessoa(tipoPessoa)
{
    var fieldCPF  = document.getElementById('cpf');
    var fieldCNPJ = document.getElementById('cnpj');
    
    if ( tipoPessoa === 'f' )
    {
        //textDisabled
        fieldCPF.disabled = false;
        fieldCPF.setAttribute('class', 'text');
        
        fieldCNPJ.value = '';
        fieldCNPJ.disabled = true;
        fieldCNPJ.setAttribute('class', 'textDisabled');
    }
    else if ( tipoPessoa === 'j' )
    {
        fieldCNPJ.disabled = false;
        fieldCNPJ.setAttribute('class', 'text');
        
        fieldCPF.value = '';
        fieldCPF.disabled = true;
        fieldCPF.setAttribute('class', 'textDisabled');
    }
}

function cnpjValidation(cnpj)
{
    
}

function cpfValidation(cpf)
{
    
}

function emailValidation(email)
{    
    if ( email != '' )
    {
        if ( !$.validateEmail(email) )
        {
            alert('Email inválido');
            document.getElementById('email').value=null;
        }
    }
}

$.validateEmail = function(email)
{
    er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;

    if(er.exec(email))
    {
        return true;
    }
    else
    {
        return false;
    }
};