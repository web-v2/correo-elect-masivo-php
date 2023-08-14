<?php 
require_once 'sentMail.php';
require_once 'core.php';

Class enviarMail {

    public function mail($oid){
        $hr = new Tools();
        $id = $hr->limpiarCadena($oid);

        $app = new Contactos();
        $respuesta = $app->getContactoById($id);        
        for ($i=0; $i <count($respuesta) ; $i++) { 
          $nombres = $respuesta[$i]['nombres'];
          $mail = $respuesta[$i]['correo'];
          $path = $respuesta[$i]['path'];
        }
        echo "<br>";        
        
        $cc = '';  //Correo CC para copia del cuerpo enviado     
        $suj = 'Certificado de Ingresos 2022 - IRIS SAS';
        $data = $this->prepare_mail($nombres, $mail, $path);
       
       
        //Ruta del archivo adjunto
        $file = "D:/XAMPP/htdocs/correo-electronico/attachments/". $path .".pdf";

        $resp=sent_mail($mail,$cc,$suj,$data,$file);            
        if($resp == 'OK'){
            return true;            
        }else{            
            return false;
        }        
    }

    public function prepare_mail($nombres, $mail, $path){
        $data = "
        <!DOCTYPE html>
        <html lang='en' xmlns='http://www.w3.org/1999/xhtml' xmlns:o='urn:schemas-microsoft-com:office:office'>
        <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width,initial-scale=1'>
        <meta name='x-apple-disable-message-reformatting'>
        <title>Proceso Cambio de Contraseñas</title>
        <!--[if mso]>
        <noscript>
        <xml>
        <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        </noscript>
        <![endif]-->
        <style>
        table, td, div, h1, p {font-family: Arial, sans-serif;}
        </style>
        </head>
        <body style='margin:0;padding:0;'>
        <table role='presentation' style='width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;'>
        <tr>
        <td align='center' style='padding:0;'>
        <table role='presentation' style='width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;'>
          <tr>
            <td align='center' style='padding:40px 0 30px 0;background:#70bbd9;'>
              <img src='https://assets.codepen.io/210284/h1.png' alt='' width='300' style='height:auto;display:block;' />
            </td>
          </tr>
          <tr>
            <td style='padding:36px 30px 42px 30px;'>
              <table role='presentation' style='width:100%;border-collapse:collapse;border:0;border-spacing:0;'>
                <tr>
                  <td style='padding:0 0 36px 0;color:#153643;'>
                    <h1 style='font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;'>CERTIFICADOS DE INGRESOS 2022 - INSTITUTO DEL RIÑÓN DE SUCRE SAS</h1>                    
                    <p style='margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;'>
                    <table border=1>
                      <tr style='background-color: #1F3D95;color: #fff;'>
                      <th colspan='2'>Datos del Colaborador</th>
                      </tr>
                      <tr>
                      <th style='background-color: #B4DFFC;'>Nombres y Apellidos</th>
                      <td>$nombres</td>
                      </tr>
                      <tr>
                      <th style='background-color: #B4DFFC;'>Correo Electrónico</th>
                      <td>$mail</td>
                      </tr>
                      <tr>
                      <th style='background-color: #B4DFFC;'>Adjuntos</th>
                      <td>Si, $path.pdf</td>
                      </tr>                      
                      </table>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style='padding:30px;background:#70bbd9;;'>
              <table role='presentation' style='width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;'>
                <tr>
                  <td style='padding:0;width:50%;' align='left'>
                    <p style='margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;'>
                      &reg; Derechos reservados 2023; <br/>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        </td>
        </tr>
        </table>
        </body>
        </html>
    ";
    return $data;
    }    
}

Class Tools{	
    public function limpiarCadena($valor){
        $valor = str_ireplace("SELECT","",$valor);
        $valor = str_ireplace("<script>","",$valor);
        $valor = str_ireplace("DATABASES","",$valor);
        $valor = str_ireplace("TRUNCATE","",$valor);
        $valor = str_ireplace("DROP TABLE","",$valor);
        $valor = str_ireplace("FROM","",$valor);
        $valor = str_ireplace("SHOW","",$valor);
        $valor = str_ireplace("WHERE","",$valor);
        $valor = str_ireplace(" * ","",$valor);
        $valor = str_ireplace("COPY","",$valor);
        $valor = str_ireplace("DELETE","",$valor);
        $valor = str_ireplace("DROP","",$valor);
        $valor = str_ireplace("DUMP","",$valor);
        $valor = str_ireplace(" OR ","",$valor);
        $valor = str_ireplace("%","",$valor);
        $valor = str_ireplace("LIKE","",$valor);
        $valor = str_ireplace("--","",$valor);
        $valor = str_ireplace("^","",$valor);
        $valor = str_ireplace("[","",$valor);
        $valor = str_ireplace("]","",$valor);
        $valor = str_ireplace("!","",$valor);
        $valor = str_ireplace("¡","",$valor);
        $valor = str_ireplace("?","",$valor);
        $valor = str_ireplace("=","",$valor);
        $valor = str_ireplace("&","",$valor);
        $valor = str_ireplace("==","",$valor);
        $valor = str_ireplace("()","",$valor);
        $valor = str_ireplace("'>","",$valor);
        $valor = str_ireplace("HTML","",$valor);
        $valor = str_ireplace("$(","",$valor);
        $valor = str_ireplace("').","",$valor);
        $valor = trim($valor);
        $valor = htmlspecialchars($valor);
        $valor = stripslashes($valor);
    return $valor;
    }

    public function validaCell($dato){
        if (filter_var($dato, FILTER_VALIDATE_INT)) {
          return true;
        } return false;
    }

    public function validaCorreo($dato){
        if (filter_var($dato, FILTER_VALIDATE_EMAIL)) {
          return true;
        } return false;
    }    
}
?>
