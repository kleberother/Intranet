
//Função para calcular margem do combustivel

////Função Gasolina Comum
//function margemGC(){
//custo = document.getElementById("custo_gc").value;
//custo = custo.replace(",",".");
//venda = document.getElementById("venda_gc").value;
//venda = venda.replace(",",".");
//
////Bloco de código para calculo da margem
////Captura o ID de destino
//margem = document.getElementById("margem_gc");
////Verifica se os valores não estão vazios.
//    if((custo!="") && (venda!=""))
//    {
//     //Executa a fórmula (((VENDA-CUSTO)/VENDA)*100)
//     margem.value = (((eval(venda)-eval(custo))/eval(venda))*100);
//     //Formata o resultado com 1 casa decimal
//     margem.value = eval(margem.value).toFixed(1);
//     //Substitui o ponto(.) por virgula(,), e acrescenta % no final
//     margem.value = margem.value.replace(".",",");
//    }
//}

//Função Gasolina Aditivada
function margemGA(){
custo = document.getElementById("custo_ga").value;
custo = custo.replace(",",".");
venda = document.getElementById("venda_ga").value;
venda = venda.replace(",",".");

//Bloco de código para calculo da margem
//Captura o ID de destino
margem = document.getElementById("margem_ga");
//Verifica se os valores não estão vazios.
    if((custo!="") && (venda!=""))
    {
     //Executa a fórmula (((VENDA-CUSTO)/VENDA)*100)
     margem.value = (((eval(venda)-eval(custo))/eval(venda))*100);
     //Formata o resultado com 1 casa decimal
     margem.value = eval(margem.value).toFixed(1);
     //Substitui o ponto(.) por virgula(,), e acrescenta % no final
     margem.value = margem.value.replace(".",",");
     if(isNaN(margem.value))
         {
             margem.value = 0;
         }
    }
}

//Função Etanol Comum
function margemEC(){
custo = document.getElementById("custo_ec").value;
custo = custo.replace(",",".");
venda = document.getElementById("venda_ec").value;
venda = venda.replace(",",".");

//Bloco de código para calculo da margem
//Captura o ID de destino
margem = document.getElementById("margem_ec");
//Verifica se os valores não estão vazios.
    if((custo!="") && (venda!=""))
    {
     //Executa a fórmula (((VENDA-CUSTO)/VENDA)*100)
     margem.value = (((eval(venda)-eval(custo))/eval(venda))*100);
     //Formata o resultado com 1 casa decimal
     margem.value = eval(margem.value).toFixed(1);
     //Substitui o ponto(.) por virgula(,), e acrescenta % no final
     margem.value = margem.value.replace(".",",");
     if(isNaN(margem.value))
         {
             margem.value = 0;
         }
    }
}

//Função Etanol Aditivado
function margemEA(){
custo = document.getElementById("custo_ea").value;
custo = custo.replace(",",".");
venda = document.getElementById("venda_ea").value;
venda = venda.replace(",",".");

//Bloco de código para calculo da margem
//Captura o ID de destino
margem = document.getElementById("margem_ea");
//Verifica se os valores não estão vazios.
    if((custo!="") && (venda!=""))
    {
     //Executa a fórmula (((VENDA-CUSTO)/VENDA)*100)
     margem.value = (((eval(venda)-eval(custo))/eval(venda))*100);
     //Formata o resultado com 1 casa decimal
     margem.value = eval(margem.value).toFixed(1);
     //Substitui o ponto(.) por virgula(,), e acrescenta % no final
     margem.value = margem.value.replace(".",",");
     if(isNaN(margem.value))
         {
             margem.value = 0;
         }
    }
}

//Função Diesel
function margemDI(){
custo = document.getElementById("custo_di").value;
custo = custo.replace(",",".");
venda = document.getElementById("venda_di").value;
venda = venda.replace(",",".");

//Bloco de código para calculo da margem
//Captura o ID de destino
margem = document.getElementById("margem_di");
//Verifica se os valores não estão vazios.
    if((custo!="") && (venda!=""))
    {
     //Executa a fórmula (((VENDA-CUSTO)/VENDA)*100)
     margem.value = (((eval(venda)-eval(custo))/eval(venda))*100);
     //Formata o resultado com 1 casa decimal
     margem.value = eval(margem.value).toFixed(1);
     //Substitui o ponto(.) por virgula(,), e acrescenta % no final
     margem.value = margem.value.replace(".",",");
     if(isNaN(margem.value))
         {
             margem.value = 0;
         }
    }
}

//Função Gás Natural
function margemGN(){
custo = document.getElementById("custo_gn").value;
custo = custo.replace(",",".");
venda = document.getElementById("venda_gn").value;
venda = venda.replace(",",".");

//Bloco de código para calculo da margem
//Captura o ID de destino
margem = document.getElementById("margem_gn");
//Verifica se os valores não estão vazios.
    if((custo!="") && (venda!=""))
    {
     //Executa a fórmula (((VENDA-CUSTO)/VENDA)*100)
     margem.value = (((eval(venda)-eval(custo))/eval(venda))*100);
     //Formata o resultado com 1 casa decimal
     margem.value = eval(margem.value).toFixed(1);
     //Substitui o ponto(.) por virgula(,), e acrescenta % no final
     margem.value = margem.value.replace(".",",");
     if(isNaN(margem.value))
         {
             margem.value = 0;
         }
    }
}
