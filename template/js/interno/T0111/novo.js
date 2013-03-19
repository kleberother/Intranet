$(function(){


})

      
function fmtMoney(n, c, d, t){
   var m = (c = Math.abs(c) + 1 ? c : 2, d = d || ",", t = t || ".",
      /(\d+)(?:(\.\d+)|)/.exec(n + "")), x = m[1].length > 3 ? m[1].length % 3 : 0;
   return (x ? m[1].substr(0, x) + t : "") + m[1].substr(x).replace(/(\d{3})(?=\d)/g,
      "$1" + t) + (c ? d + (+m[2] || 0).toFixed(c).substr(2) : "");
};         

function soma(){

document.getElementById("total").value = '0'

var unidade = parseFloat(document.getElementById("quantidade").value);

var custo_unitario = parseFloat(document.getElementById("preco").value.replace('.','').replace(',','.'));

var total = ('' + ((unidade||0) * (custo_unitario||0))); 

//a linha acima nao pode ser subistituida por
document.getElementById("total").value = fmtMoney(total);
}