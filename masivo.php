<?php 
include_once 'app/procesa_correo.php';
include_once 'app/core.php';

if(isset($_POST['formulario']) && $_POST['formulario'] == 'correo'){  
  for ($i=0; $i <count($_POST['check']) ; $i++) { 
    $obj = new enviarMail();
    $res = $obj->mail($_POST['check'][$i]);
  }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">  
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <script src="https://code.jquery.com/jquery-1.9.1.js"></script>    
    <title>Taller - Formulario Correo</title>
    <style>
     .card{ width: 950px !important; border-radius: 15px;}
     body{ background-color: #f0f0f0;}
     .bloque{ height: 50px;}
    </style>  
    <script type="text/javascript" charset="utf-8">
      $(document).ready(function(){
         $('#btnsend').attr('disabled','disabled');
         $('input[type="checkbox"]').change(function(){            
            if($(this).val() != ''){
              if($('#btnsend').attr('disabled')){
                $('#btnsend').removeAttr('disabled');
              }else{
                $('#btnsend').attr('disabled','disabled');
              }
            }else{
             $('#btnsend').attr('disabled','disabled');
            }
         });
      })
          
    function ActivarCasilla(casilla){
      miscasillas=document.getElementsByTagName('input'); //Rescatamos controles tipo Input
      for(i=0;i<miscasillas.length;i++){ //Ejecutamos y recorremos los controles      
        if(miscasillas[i].type == "checkbox"){ // Ejecutamos si es una casilla de verificacion
          miscasillas[i].checked=casilla.checked; // Si el input es CheckBox se aplica la funcion ActivarCasilla
        }
      }      
    }      
</script>    
</head>
<body>
<div class="login-box">
<center>
  <div class="bloque"></div>
<div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><strong>ENVIO MASIVOS DE CORREOS IRIS SAS</strong></p>
      <p class="login-box-msg"><strong>Listar Contactos</strong></p>
      
      <form action="" method="post" id="formulario">
      <input type="hidden" name="formulario" value="correo">
      <table class="table table-responsive table-bordered">
        <tr>
          <th><label for="check">
            <input type="checkbox" name="acta" id="acta" style="width:28px;height:28px;align-items:middle;" onClick="ActivarCasilla(this);"></label>
          </th>
          <th><label for="celular">Id: </label></th>
          <th><label for="nombres">Nombres: </label></th>
          <th><label for="Correo">Correo Electronico: </label></th>
          <th><label for="path">Adjunto </label></th>
        </tr>
        <?php 
        $app = new Contactos();
        $resp = $app->getContactos();
        //print_r($resp);
        for ($i=0; $i <count($resp) ; $i++) { 
      
        ?>
        <tr>
          <td><input type="checkbox" name="check[]" id="check" value="<?php echo $resp[$i]['id_cont'] ?>" style="width:28px;height:28px;align-items:middle;"></td>
          <td><?php echo $resp[$i]['id_cont'] ?></td>
          <td><?php echo $resp[$i]['nombres'] ?></td>
          <td><?php echo $resp[$i]['correo'] ?></td>
          <td><?php echo $resp[$i]['path'] ?>.pdf</td>
        </tr>
      <?php } ?>
      </table>

        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="btnsend">
            Enviar Correo Electronico</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    </center>
    <!-- /.login-card-body -->
  </div>
  <script src="plugins/jquery/jquery.min.js"></script>  
  <script src="plugins/toastr/toastr.min.js"></script>
  <script>
      $(function(){
        let Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
          });
      });

      toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-full-width",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }
  </script>   
<?php
if(isset($_POST['formulario']) && $_POST['formulario'] == 'correo'){
  if($res==1){
    echo "
    <script>
    Command: toastr['success']('Su correo electrónico fue enviado correctamente!', 'Formulario y Correo')
    </script>
    ";
  }else{
    echo "
    <script>
        Command: toastr['error']('Ocurrio un problema al enviar el correo!', 'Error, Correo No Enviado!');
    </script>
    ";
  }
}
?>
</body>
</html>
