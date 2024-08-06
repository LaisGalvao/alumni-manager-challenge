<!DOCTYPE HTML
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <meta content="IE=9; IE=8; IE=7; IE=EDGE" http-equiv="X-UA-Compatible" />
    <title>Um novo usuário se registrou - Vulpee</title>

</head>

<body style="background:#fff">
    <div style="padding:0;margin:0 auto;font-family:Manrope,sans-serif">
        <div
            style="bbackground: rgb(66,43,112);
            background: linear-gradient(124deg, rgba(66,43,112,1) 0%, rgba(80,52,108,1) 30%, rgba(151,98,88,1) 62%, rgba(200,129,74,1) 94%, rgba(255,165,59,1) 100%);width:95%;margin:10px auto;max-width:600px;-webkit-box-shadow: 0 0 5px 2px rgba(0, 0, 0, .1);box-shadow: 0 0 5px 2px rgba(0, 0, 0, .1);">
            <img src="{{ asset('assets/logo-vulpee.png') }}" alt="logo Vulpee"
                style="display:block;margin:0 auto;padding-top:32px; height:100px;">


            <h2 style="color: white;text-align:center;">Um novo usuário se registrou no app
                Vulpee</h2>


            <div style="display: block;text-align: center;padding: 40px 0;background-color: #e9e9e9;color: #fff;">
                <div style="text-align:center;display: block;margin-bottom:36px;">

                    <h2 style="margin-bottom:80px;color:#000;text-align:center;padding:0 40px;">Informações:
                    </h2>

                    <p style="margin-bottom:10px;color:#000;text-align:center;padding:0 20px;"><span
                            style="font-weight: 600">Nome:</span> <?php echo $info['name']; ?></p>
                    <p style="margin-bottom:10px;color:#000;text-align:center;padding:0 20px;"><span
                            style="font-weight: 600">Documento:</span>
                        @if (isset($info['cpf']))
                            <?php echo $info['cpf']; ?>
                        @elseif (isset($info['document']))
                            <?php echo $info['document']; ?>
                        @endif
                    </p>
                    <p style="margin-bottom:10px;color:#000;text-align:center;padding:0 20px;"><span
                            style="font-weight: 600">Email:</span> <?php echo $info['email']; ?></p>
                    <p style="margin-bottom:10px;color:#000;text-align:center;padding:0 20px;"><span
                            style="font-weight: 600">Telefone:</span> <?php echo $info['telephone']; ?>
                    </p>

                </div>
            </div>
            <div class="yj6qo"></div>
            <div class="adL">
            </div>
        </div>
        <div class="adL">
        </div>
    </div>
</body>

</html>
