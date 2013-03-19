function VerificaCPF () {
if (vercpf(document.NovoAjuste.T106_cpf.value)) 
{document.NovoAjuste.submit();}else 
{errors="1";if (errors) alert('CPF NÃO VÁLIDO');
document.retorno = (errors == '');}}
function vercpf (T106_cpf) 
{if (T106_cpf.length != 11 || T106_cpf == "00000000000" || T106_cpf == "11111111111" || T106_cpf == "22222222222" || T106_cpf == "33333333333" || T106_cpf == "44444444444" || T106_cpf == "55555555555" || T106_cpf == "66666666666" || T106_cpf == "77777777777" || T106_cpf == "88888888888" || T106_cpf == "99999999999")
return false;
add = 0;
for (i=0; i < 9; i ++)
add += parseInt(T106_cpf.charAt(i)) * (10 - i);
rev = 11 - (add % 11);
if (rev == 10 || rev == 11)
rev = 0;
if (rev != parseInt(T106_cpf.charAt(9)))
return false;
add = 0;
for (i = 0; i < 10; i ++)
add += parseInt(T106_cpf.charAt(i)) * (11 - i);
rev = 11 - (add % 11);
if (rev == 10 || rev == 11)
rev = 0;
if (rev != parseInt(T106_cpf.charAt(10)))
return false;
alert('O CPF INFORMADO É VÁLIDO.');return true;}