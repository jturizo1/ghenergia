<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars($_POST['name'] ?? '');
    $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject'] ?? 'Formulario de contacto');
    $message = htmlspecialchars($_POST['message'] ?? '');

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ghenergiasas@gmail.com';
        $mail->Password   = 'cxul kpuw nqvx mwma';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('ghenergiasas@gmail.com', 'Formulario Web');
        $mail->addAddress('ghenergiasas@gmail.com', 'GH Energía');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <title>Nuevo mensaje de contacto</title>
</head>
<body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
  <table align='center' width='100%' cellpadding='0' cellspacing='0' style='padding: 20px;'>
    <tr>
      <td>
        <table width='600' align='center' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden;'>
          <tr>
            <td style='background-color: #004aad; color: #ffffff; padding: 20px; text-align: center;'>
              <h2 style='margin: 0;'>📩 Nuevo mensaje desde el sitio web</h2>
            </td>
          </tr>
          <tr>
            <td style='padding: 30px; color: #333333;'>
              <p><strong>Nombre:</strong> $name</p>
              <p><strong>Correo:</strong> $email</p>
              <p><strong>Asunto:</strong> $subject</p>
              <hr style='border: none; border-top: 1px solid #dddddd; margin: 20px 0;'>
              <p><strong>Mensaje:</strong></p>
              <p style='white-space: pre-line;'>$message</p>
            </td>
          </tr>
          <tr>
            <td style='background-color: #eeeeee; padding: 15px; text-align: center; font-size: 12px; color: #666666;'>
              GH Energía SAS &copy; ".date('Y').". Todos los derechos reservados.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
";

        $mail->send();
        echo json_encode(['status' => 'success', 'message' => 'Mensaje enviado correctamente.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje: ' . $mail->ErrorInfo]);
    }
}

?>