<?php

////////////////////////////////////////////////////////////////////////////////////////////////////
//
// ESTA PARTE PROCESA EL FORMULARIO CUANDO ES ENVIADO
//
////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////
//
// FUNCIONES
//
////////////////////////////////////////////////////////////////////////////////////////////////////

function lee_txt_to_array()
{
    //LEE EL TXT DEL SERVER
    $txt = trim(file_get_contents("http://4milfundadores.com/datos/Listado_Total.txt"));
    $array = preg_split("/[\s]+/", $txt);
    return $array;

}

function extrae_una_columna_del_array($columna, $array)
{

    $lista_de_valores = array();

    for ($i = 0; $i < count($array); $i++)
    {
        $arr_linea_actual = explode("\t", $array[$i]);
        $dato = $arr_linea_actual[$columna];
        array_push($lista_de_valores, $dato);

    }

    return $lista_de_valores;

}


function hora_local($zona_horaria)
{
    if ($zona_horaria > -12.1 and $zona_horaria < 12.1)
    {
        $hora_local = time() + ($zona_horaria * 3600);
        return $hora_local;
    }
    return 'error';
}


function agrega_a_txt($dato, $ruta_txt)
{

    $archivo = fopen($ruta_txt, 'a') or die("Se produjo un error inesperado, por favor intentelo nuevamente");
    fwrite($archivo, $dato);
    fclose($archivo);

}

function decodifica_mail($mail_codificado)
{

    return base64_decode(substr($mail_codificado, -5) . substr($mail_codificado, 0,
        -5));

}

////////////////////////////////////////////////////////////////////////////////////////////////////

$hora = gmdate('Y-m-d H:i:s', hora_local(-3));


$enviado = $_POST["enviado"];

//$mail = $_GET["mail"];

//$codigo = $_GET["codigo"];

//$codigo = decodifica_mail($codigo);

//$nombre = $_GET["nombre"];

//$barrio = $_GET["barrio"];

/////////////////////////////////////////////////


/*
if (($mail !== $codigo) || ($mail == null) || ($codigo == null))
{

echo "El Mail no pudo verificarse, si el problema continua por favor contactenos a: preguntasenred@gmail.com";
die;
} else
{

if ($enviado == 1)
{

$nombre = $_POST["nombre"];

$apellido = $_POST["apellido"];



$dato = $hora . "\t" . "$mail\t" . "$nombre $apellido\t" . "$barrio\t" ."ENVIO EL FORMULARIO\n";
$ruta_txt = "datos/listado_de_mails.txt";
agrega_a_txt($dato, $ruta_txt);


} else
{
$dato = $hora . "\t" . "$mail\t" . "$nombre\t" . "$barrio\t"."CONFIRMADO\n";
$ruta_txt = "datos/listado_de_mails.txt";
agrega_a_txt($dato, $ruta_txt);

}

}
*/


if ($enviado == 1)
{


    $apellido = $_POST["apellido"];

    $nombre = $_POST["nombre"];

    $dni = $_POST["dni"];

    $dni = str_replace(".", "", $dni);

    $sexo = $_POST["sexo"];

    $dia = $_POST["dia"];

    $mes = $_POST["mes"];

    $ano = $_POST["ano"];

    $fecha_nacimiento = $dia . "/" . $mes . "/" . $ano;

    $lugar_nacimiento = $_POST["lugar_nacimiento"];

    $estado_civil = $_POST["estado_civil"];

    $domicilio = $_POST["domicilio"];

    $telefono = $_POST["telefono"];

    $mail = $_POST["mail"];

    $afiliador = $_POST["afiliador"];

    $fichas = $_POST["fichas"];

    $mosaico = $_POST["mosaico"];

    $profesion = $_POST["profesion"];

    $mosaico = $_POST["mosaico"];


    ///////////////////////////////////////////////////////////////////
    //////////////// CHEQUEA SI EL VALOR YA FUE CARGADO
    ///////////////////////////////////////////////////////////////////

    $array_datos = lee_txt_to_array();

    $columna_dni = extrae_una_columna_del_array(0, $array_datos);

    if (in_array($dni, $columna_dni, true))
    {
        echo "<center><b>Estos datos no puedieron ser cargados, porque el DNI " . $dni . "<br>
        ya fue cargado previamente y se encuentra en proceso.<br>
        <br>
        Para consultar en que estado se encuentra esta afiliaci�n<br>
        por favor escriba su consulta a afiliacionespdr@gmail.com</b></center>";

        die;
    }

    ///////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////
    

    ////*** TXT ***//
    $nombre_archivo = $dni;

    $contenido = "$dni $apellido" . "\t" . "\t" . "\t" . "\t" . "\t" . "\t" . $afiliador .
        "\t" . $nombre . "\t" . $apellido . "\t" . $dni . "\t" . $sexo . "\t" . $fecha_nacimiento .
        "\t" . $lugar_nacimiento . "\t" . $profesion . "\t" . $estado_civil . "\t" . $domicilio .
        "\t" . $mail . "\t" . $telefono . "\t" . $fichas . "\t" . $mosaico . "\t" . $barrio;


    $fp = fopen("subidas_afiliadores/" . $dni . ".txt", "w+");
    if (fwrite($fp, "$contenido"))
    {

    } else
    {
        echo "SE PRODUJO UN ERROR AL INTENTAR CARGAR EL FORMULARIO.<br>
    POR FAVOR VUELVA A INTENTARLO O REPORTE EL INCONVENIENTE A afiliacionespdr@gmail.com";

    }

    fclose($fp);

////////////////////////////////////////////////

 ////*** Attachment 1 ***//
    if ($_FILES["foto1"]["name"] != "")
    {

        $nombre_archivo = $_FILES["foto1"]["name"];
        $extension = end(explode(".", $nombre_archivo));

        if (!copy($_FILES["foto1"]["tmp_name"], "subidas_afiliadores/" . $dni . _1 .".". $extension))
        {
            echo "SE PRODUJO UN ERROR AL INTENTAR CARGAR LA FOTO 1 DEL FORMULARIO.<br>
    POR FAVOR VUELVA A INTENTARLO O REPORTE EL INCONVENIENTE A afiliacionespdr@gmail.com";

        }
    }


    ////*** Attachment 2 ***//
    if ($_FILES["foto2"]["name"] != "")
    {

        $nombre_archivo = $_FILES["foto2"]["name"];
        $extension = end(explode(".", $nombre_archivo));

        if (!copy($_FILES["foto2"]["tmp_name"], "subidas_afiliadores/" . $dni . _2 .".". $extension))
        {
            echo "SE PRODUJO UN ERROR AL INTENTAR CARGAR LA FOTO 2 DEL FORMULARIO.<br>
    POR FAVOR VUELVA A INTENTARLO O REPORTE EL INCONVENIENTE A afiliacionespdr@gmail.com";

        }
    }

    ////*** Attachment 3 ***//
    if ($_FILES["foto3"]["name"] != "")
    {

        $nombre_archivo = $_FILES["foto3"]["name"];
        $extension = end(explode(".", $nombre_archivo));

        if (!copy($_FILES["foto3"]["tmp_name"], "subidas_afiliadores/" . $dni . _3 .".". $extension))
        {
            echo "SE PRODUJO UN ERROR AL INTENTAR CARGAR LA FOTO 3 DEL FORMULARIO.<br>
    POR FAVOR VUELVA A INTENTARLO O REPORTE EL INCONVENIENTE A afiliacionespdr@gmail.com";

        }
    }
/////////////////////////////////////////////////



    // EL FORMULARIO SE CARGO Y REDIRECCIONA
    include ("gracias_form.html");

    //echo "se envio el formulario de prueba";
    //header('Location: gracias.html');


    die;


}

?>
 
 
 

 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="TBSOFT" />
 
	<title>Formulario Afiliadores</title>
 
 
    <script>
 
function validateForm()
{
 
var campo="apellido";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Apellido");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="nombre";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Nombre");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="dni";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el N�mero de DNI");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="sexo";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Sexo");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="dia";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Dia de Nacimiento");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="mes";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Mes de Nacimiento");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="ano";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el A�o de Nacimiento");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="lugar_nacimiento";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Lugar de Nacimiento");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="profesion";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar la Profesi�n u Oficio");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="estado_civil";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Estado Civil");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="domicilio";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar el Domicilio");document.forms["formulario"].elements[campo].focus();return false}

var campo="afiliador";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta completar tu Mail");document.forms["formulario"].elements[campo].focus();return false}

var campo="fichas";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta indicar qui�n tiene las fichas");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="foto1";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta seleccionar la foto del DNI");document.forms["formulario"].elements[campo].focus();return false}
 
var campo="foto2";
var elemento=document.forms["formulario"][campo].value;
if (elemento=null || elemento==""){cargandoOFF();alert("Falta seleccionar la foto del dorso del DNI");document.forms["formulario"].elements[campo].focus();return false}
 
}
 
 
</script>
 
 
 
 
<style type="text/css">
span.estilo{font-family:"Verdana", sans-serif; font-size:16.0px; line-height:1.13em;color:#3D3D3D;}
 
span.rojo{font-family:"Verdana", sans-serif; font-size:16.0px; line-height:1.13em;color: #AD0000;font-weight: bold;}
 
 
 
</style>
 
 
 
 
</head>
 
<body text="#000000" style="background-color:#ffffff;background-image:url(wpimages/wpa21cc0b3_06.png);background-repeat:repeat;background-position:top center;background-attachment:scroll; text-align:center; height:1000px; /*Master Page Body Style*/ /*Page Body Style*/" >
 
 
 
<div style="background-color:transparent;text-align:left;margin-left:auto;margin-right:auto;position:relative;width:960px;height:1400px; __AddCode="Master DIV Tag">
 
 
<center>NUEVO FORMULARIO ONLINE</center><br/>
<center>EN CASO DE CONSULTAS O REPORTE DE ERRORES POR FAVOR ESCRIBIR A: afiliacionespdr@gmail.com</center>

<br/><br/>
 
<div style="margin-left:auto;margin-right:auto;position:relative; position:relative;left:40px;">
 
<form id="formulario" name="formulario" onsubmit="return validateForm()" action="<?php echo $_SERVER['PHP_SELF']; ?>" accept-charset="UTF-8" method="post" target="_self" enctype="multipart/form-data" style="margin:0px; /*MainDivStyle*/" >
 
 
 
 
<span class="estilo">Apellido/s (Como Figura en el DNI)</span><BR>
<input type=text NAME=apellido size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">Nombre/s (Como Figura en el DNI)</span><BR>
<input type=text NAME=nombre size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">N�mero de DNI</span><BR>
<input type=text NAME=dni size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">Sexo</span><BR>
<select  name="sexo" >
    <option value="" selected >-&nbsp;SEXO&nbsp;-</option>
    <option value="F" >Femenino</option>
    <option value="M" >Masculino</option>
</select><BR><BR>
 
<span class="estilo">Fecha de Nacimiento</span><BR>
<select  name="dia" size="1" >
    <option value="" selected >-&nbsp;DIA&nbsp;-</option>
    <option value="01" >01</option>
    <option value="02" >02</option>
    <option value="03" >03</option>
    <option value="04" >04</option>
    <option value="05" >05</option>
    <option value="06" >06</option>
    <option value="07" >07</option>
    <option value="08" >08</option>
    <option value="09" >09</option>
    <option value="10" >10</option>
    <option value="11" >11</option>
    <option value="12" >12</option>
    <option value="13" >13</option>
    <option value="14" >14</option>
    <option value="15" >15</option>
    <option value="16" >16</option>
    <option value="17" >17</option>
    <option value="18" >18</option>
    <option value="19" >19</option>
    <option value="20" >20</option>
    <option value="21" >21</option>
    <option value="22" >22</option>
    <option value="23" >23</option>
    <option value="24" >24</option>
    <option value="25" >25</option>
    <option value="26" >26</option>
    <option value="27" >27</option>
    <option value="28" >28</option>
    <option value="29" >29</option>
    <option value="30" >30</option>
    <option value="31" >31</option>
</select>
 
 
<select  name="mes" size="1">
    <option value="" selected >-&nbsp;MES&nbsp;-</option>
    <option value="01" >01</option>
    <option value="02" >02</option>
    <option value="03" >03</option>
    <option value="04" >04</option>
    <option value="05" >05</option>
    <option value="06" >06</option>
    <option value="07" >07</option>
    <option value="08" >08</option>
    <option value="10" >09</option>
    <option value="10" >10</option>
    <option value="11" >11</option>
    <option value="12" >12</option>
</select>
 
<select  name="ano" size="1" ">
    <option value="" selected >-&nbsp;A�O&nbsp;-</option>
    <option value="1996" >1998</option>
    <option value="1996" >1997</option>
    <option value="1996" >1996</option>
    <option value="1995" >1995</option>
    <option value="1994" >1994</option>
    <option value="1993" >1993</option>
    <option value="1992" >1992</option>
    <option value="1991" >1991</option>
    <option value="1990" >1990</option>
    <option value="1989" >1989</option>
    <option value="1988" >1988</option>
    <option value="1987" >1987</option>
    <option value="1986" >1986</option>
    <option value="1985" >1985</option>
    <option value="1984" >1984</option>
    <option value="1983" >1983</option>
    <option value="1982" >1982</option>
    <option value="1981" >1981</option>
    <option value="1980" >1980</option>
    <option value="1979" >1979</option>
    <option value="1978" >1978</option>
    <option value="1977" >1977</option>
    <option value="1976" >1976</option>
    <option value="1975" >1975</option>
    <option value="1974" >1974</option>
    <option value="1973" >1973</option>
    <option value="1972" >1972</option>
    <option value="1971" >1971</option>
    <option value="1970" >1970</option>
    <option value="1969" >1969</option>
    <option value="1968" >1968</option>
    <option value="1967" >1967</option>
    <option value="1966" >1966</option>
    <option value="1965" >1965</option>
    <option value="1964" >1964</option>
    <option value="1963" >1963</option>
    <option value="1962" >1962</option>
    <option value="1961" >1961</option>
    <option value="1960" >1960</option>
    <option value="1959" >1959</option>
    <option value="1958" >1958</option>
    <option value="1957" >1957</option>
    <option value="1956" >1956</option>
    <option value="1955" >1955</option>
    <option value="1954" >1954</option>
    <option value="1953" >1953</option>
    <option value="1952" >1952</option>
    <option value="1951" >1951</option>
    <option value="1950" >1950</option>
    <option value="1949" >1949</option>
    <option value="1948" >1948</option>
    <option value="1947" >1947</option>
    <option value="1946" >1946</option>
    <option value="1945" >1945</option>
    <option value="1944" >1944</option>
    <option value="1943" >1943</option>
    <option value="1942" >1942</option>
    <option value="1941" >1941</option>
    <option value="1940" >1940</option>
    <option value="1939" >1939</option>
    <option value="1938" >1938</option>
    <option value="1937" >1937</option>
    <option value="1936" >1936</option>
    <option value="1935" >1935</option>
    <option value="1934" >1934</option>
    <option value="1933" >1933</option>
    <option value="1932" >1932</option>
    <option value="1931" >1931</option>
    <option value="1930" >1930</option>
    <option value="1929" >1929</option>
    <option value="1928" >1928</option>
    <option value="1927" >1927</option>
    <option value="1926" >1926</option>
    <option value="1925" >1925</option>
    <option value="1924" >1924</option>
    <option value="1923" >1923</option>
    <option value="1922" >1922</option>
    <option value="1921" >1921</option>
    <option value="1920" >1920</option>
    <option value="1919" >1919</option>
    <option value="1918" >1918</option>
    <option value="1917" >1917</option>
    <option value="1916" >1916</option>
    <option value="1915" >1915</option>
    <option value="1914" >1914</option>
    <option value="1913" >1913</option>
    <option value="1912" >1912</option>
    <option value="1911" >1911</option>
    <option value="1910" >1910</option>
    <option value="1909" >1909</option>
    <option value="1908" >1908</option>
    <option value="1907" >1907</option>
    <option value="1906" >1906</option>
    <option value="1905" >1905</option>
    <option value="1904" >1904</option>
    <option value="1903" >1903</option>
    <option value="1902" >1902</option>
    <option value="1901" >1901</option>
    <option value="1900" >1900</option>
</select><BR><BR>
 
<span class="estilo">Lugar de Nacimiento como figura en el DNI.<BR>(Esta escrito en el Dorso del DNI Tarjeta o Segunda hoja del DNI Libro)</span><BR>
<input type=text NAME=lugar_nacimiento size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">Profesi�n u Oficio</span><BR>
<input type=text NAME=profesion size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">Estado Civil</span><BR>
<input type=text NAME=estado_civil size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">Domicilio como figura en el DNI.<BR>(Si es DNI Libro, el �ltimo domicilio registrado legalmente)</span><BR>
<input type=text NAME=domicilio size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">Tel�fono</span><BR>
<input type=text NAME=telefono size=33 placeholder="OPCIONAL"><BR><BR>

<span class="estilo">Mail del Afiliado</span><BR>
<input type=text NAME=mail size=33 placeholder="OPCIONAL PERO IMPORTANTE"><BR><BR>

<span class="estilo">Mail Afiliador de la lista ejecutiva.<BR> Tu mail.</span><BR>
<input type=text NAME=afiliador size=33 placeholder="REQUERIDO"><BR><BR>

<span class="estilo">�Se completaron las fichas? �Las ten�s vos? <BR>Otros Comentarios</span><BR>
<input type=text NAME=fichas size=33 placeholder="REQUERIDO"><BR><BR>
 
<span class="estilo">Como queres que figure el nombre en el mosaico de los 4.000 Fundadores.</span><BR>
<span class="estilo">(Ej. P. Gonzalez � Pablo G.)</span><BR>
 
<select  name="mosaico" >
    <option value="poner_nombre" selected >NOMBRE + INICIAL APELLIDO</option>
    <option value="poner_apellido" >INICIAL NOMBRE + APELLIDO</option>
</select><BR><BR>
 
<span class="estilo">Sub� las dos caras del DNI que tengan un m�ximo de 6MB.</span><BR>
<span class="rojo">Es muy importante que las fotos esten en foco y que los datos sean legibles.</span><BR>
<span class="rojo">Si tu c�mara no permite tomar fotos en foco de muy cerca,</span><BR>
<span class="rojo">al�jala unos cent�metros hasta que los datos en las fotos aparezcan legibles.</span><BR><BR>
 
<span class="estilo">Subir Frente DNI Tarjeta � Primera hoja con foto DNI Libro (Requerido)</span><BR>
<input type="file" name="foto1" ><BR><BR>
 
<span class="estilo">Subir Dorso DNI Tarjeta � Segunda Hoja DNI libro (Requerido)</span><BR>
<input type="file" name="foto2" ><BR><BR>
 
<span class="estilo">En el caso que haya cambio de domicilio en DNI libro, subirlo tambi�n:</span><BR>
<input type="file" name="foto3" ><BR><BR>
 
<input type="hidden" name="enviado" value="1">
 
<INPUT TYPE=SUBMIT VALUE="ENVIAR!" onclick="cargandoON()">
 
</FORM>
 
</div>
 
 
<div id="carga" style="margin-left:40px; display:none;">
<img src="../imagenes/carga.gif" width="418" height="54" border="0" id="agif1" alt="" >
 
<script type="text/javascript">
function cargandoOFF()
{
   document.getElementById("carga").style.display = "none"; // to display
   return true;
}
function cargandoON()
{
   document.getElementById("carga").style.display = ""; // to display
   return true;
}
</script>
 
<script type="text/javascript" src="wpscripts/jsValidation.js"></script>
 
</div>
 
<br/><br/>
 
<div>

</div>
</div>
</body>
</html>