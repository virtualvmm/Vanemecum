<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto Vanemecum</title>
    <style>
        body { font-family: sans-serif; line-height: 1.5; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: white; padding: 12px 16px; border-radius: 8px 8px 0 0; }
        .box { border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px; padding: 16px; }
        .label { font-weight: bold; color: #6b7280; font-size: 0.875rem; }
        .value { margin-bottom: 12px; }
        .mensaje { background: #f9fafb; padding: 12px; border-radius: 6px; white-space: pre-wrap; }
    </style>
</head>
<body>
    <div class="header"><strong>Vanemecum</strong> – Mensaje de contacto</div>
    <div class="box">
        <p>Un usuario ha enviado un mensaje desde el formulario de contacto:</p>
        <div class="value">
            <span class="label">Usuario</span><br>
            {{ $userName }} &lt;{{ $userEmail }}&gt;
        </div>
        <div class="value">
            <span class="label">Motivo</span><br>
            {{ $tipoLabel }}
        </div>
        <div class="value">
            <span class="label">Mensaje</span><br>
            <div class="mensaje">{{ $mensaje }}</div>
        </div>
        <p style="margin-top: 16px; font-size: 0.875rem; color: #6b7280;">
            Puede responder directamente a este correo; la respuesta llegará al usuario.
        </p>
    </div>
</body>
</html>
