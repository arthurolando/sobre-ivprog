/*

 iVprog: http://www.matematica.br/ivprog.

 */

var ex = null;     // número do exercício: ex=N
var idioma = null; // idioma a ser usado: idioma=xx

function prepare () {
  ex = getRequestParameter("ex");
  idioma = getRequestParameter("idioma");
  if (idioma == "") {
     idioma="pt";
     }
  if (ex == "") {
     ex = 1;
     }
  document.getElementById("appletDefinition").innerHTML = montaExercicio(ex,document.getElementById("appletDefinition").innerHTML,idioma);
  }

// Substitui '@numeroExerc@' por número do exercício
function numExercicio () {
  var txt = document.getElementById("numExerc").innerHTML; // igaul a '@numeroExerc@'
  document.getElementById("numExerc").innerHTML = ex; // substitua campo sob 'element' 'numExerc' por valor de variável global 'ex'
   }

function pegaResposta () {
  var resposta = document.iVprog.getAnswer();
  var avaliacao = document.iVprog.getAvaliacao(); 
  var trace = document.iVprog.getTrace();  
  alert("Exemplo");
  }

/* para cada item no texto (@variavel@) substitua pelo texto correto */  
function findAndReplace (texto, de, para) {
  try { // para evitar erro se 'de' ou 'para' não estiver(em) definido(s)
    var match = new RegExp(de, "ig");
    var replaced = "";
    if (para.length > 0) { //
       replaced = texto.replace(match, para);
       }
    else {
       return texto;
       }
    return replaced; 
  } catch (Exception) {
    // alert('de='+de+' para='+para);
    }

  }

function consultaExercicio (numEx, campo, idioma) {
  var resultado = null;
  for (var i=0 ; i < exercicios.length ; i++) {
    if (exercicios[i].numero == numEx) {
       resultado = exercicios[i][campo];
       if (resultado != null)
          return resultado;
       else return exercicios[i][campo + "_" + idioma];
       }
    }
  return null;
  }

function montaExercicio (numEx, template, idioma) {
  template = findAndReplace(template,"@referencia@", consultaExercicio(numEx, "referencia", idioma));
  template = findAndReplace(template,"@enunciado@", consultaExercicio(numEx, "enunciado", idioma));
  template = findAndReplace(template,"@tipo@", consultaExercicio(numEx, "tipo", idioma));
  template = findAndReplace(template,"@solucao@",  consultaExercicio(numEx, "solucao", idioma));
  template = findAndReplace(template,"@resposta@",  consultaExercicio(numEx, "resposta", idioma));
  template = findAndReplace(template,"@universo@",  consultaExercicio(numEx, "universo", idioma));
  template = findAndReplace(template,"@dica@", consultaExercicio(numEx, "dica", idioma));
  template = findAndReplace(template,"@online@", consultaExercicio(numEx, "online", idioma));
  return template;
  }

function getRequestParameter (name) {
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if ( results == null )
     return "";
  else
    return results[1];
  }
